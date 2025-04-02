<?php

namespace App\Actions\Transactions;

use App\Enums\NetworkProvider;
use App\Enums\TransactionStatus;
use App\Enums\TransactionType;
use App\Enums\WalletType;
use App\Models\Airtime;
use App\Models\Transaction;
use App\Models\User;
use App\Services\VTPass\VTPassClient;
use App\Services\WalletService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Throwable;

class CreateAirtimeTransaction
{
    public function __construct(public VTPassClient $airtimeProvider)
    {}

    public function execute(array $data): Transaction
    {
        [$phone_number, $network, $amount] = $data;

        DB::beginTransaction();

        try {
            $user = Auth::user();

            // Debit the user wallet based on balance availability
            WalletService::forUser($user)->debit(WalletType::Main, $amount, "Airtime Purchase of $amount NGN");
            $user = $user->refresh();

            $airtimeReference = $this->airtimeProvider->generateRequestID();
            $response = $this->airtimeProvider->purchaseAirtime($airtimeReference, $network, $amount, $phone_number);

            if ($response->code === '016') {
                throw new Exception("Transaction failed");
            }

            $isSuccessful = $response->code === "000" && $response->status === "delivered";

            $transaction = Transaction::create([
                'user_id' => $user->id,
                'reference' => Str::uuid(),
                'description' => "Airtime Purchase of $amount NGN",
                'type' => TransactionType::Airtime,
                'amount' => $amount * 100,
                'balance' => $user->main_balance,
                'status' => TransactionStatus::Completed,
                'commission' => 0,
                'metadata' => null,
            ]);

            Airtime::create([
                'user_id' => $user->id,
                'transaction_id' => $transaction->id,
                'reference' => $airtimeReference,
                'amount' => $amount * 100,
                'network' => $network,
                'phone_number' => $phone_number,
                'service' => 'vtpass',
                'status' => $isSuccessful ? TransactionStatus::Completed : TransactionStatus::Pending,
                'metadata' => json_encode($response->toArray()),
            ]);

            DB::commit();

            return $transaction;
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}