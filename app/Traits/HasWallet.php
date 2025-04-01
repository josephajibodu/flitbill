<?php

namespace App\Traits;

use App\Enums\WalletType;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Services\WalletService;
use Exception;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\DB;

/**
 * @property Wallet $wallet
 *
 * @property-read float $main
 * @property-read float $bonus
 */
trait HasWallet
{
    /**
     * The base unit for wallet balance
     *
     */
    public const BALANCE_UNIT = 100;

    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    public function walletTransactions(): HasMany
    {
        return $this->hasMany(WalletTransaction::class, 'user_id');
    }

    /**
     * Get the user's balance in Naira.
     */
    public function mainBalance(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->wallet ? $this->wallet->main / static::BALANCE_UNIT : 0,
        );
    }

    /**
     * Get the user's bonus balance in Naira.
     */
    public function bonusBalance(): Attribute
    {
        return Attribute::make(
            get: fn() => $this->wallet ? $this->wallet->bonus / static::BALANCE_UNIT : 0,
        );
    }

    /**
     * Credit any of the users account
     *
     * @throws Exception
     */
    public function credit(WalletType $creditWallet, float $amount, string $reason = ''): WalletTransaction
    {
        return WalletService::forUser($this)->credit($creditWallet, $amount, $reason);
    }

    /**
     * Internal funds transfer between wallets
     *
     * @throws Exception
     */
    public function internalTransfers(WalletType $from, WalletType $to, float $amount, string $reason = ''): WalletTransaction
    {
        return WalletService::forUser($this)->transferFunds($from, $to, $amount, $reason);
    }

    public function hasSufficientBalance(WalletType|array $in, float $amount): bool
    {
        $amountInBaseUnit = $amount * 100;

        if ($in instanceof WalletType) {
            return $this->wallet->{$in->value} >= $amountInBaseUnit;
        } else {
            $totalBalance = collect($in)->reduce(function ($carry, WalletType $walletType) {
                return $carry + $this->wallet->{$walletType->value};
            }, 0);

            return ($totalBalance * 100) >= $amountInBaseUnit;
        }
    }

    /*
     * Check for sufficient balance
     */

    public function debitWithBonus(float $amount, string $reason = ''): WalletTransaction
    {
        return DB::transaction(function () use ($amount, $reason) {
            $walletService = WalletService::forUser($this);
            $mainBalance = $this->main;
            $bonusBalance = $this->bonus;

            if ($amount <= $mainBalance) {
                return $walletService->debit(WalletType::Main, $amount, $reason);
            }

            if ($amount > ($mainBalance + $bonusBalance)) {
                throw new Exception('Insufficient funds in main and bonus balance.');
            }

            // Debit whatever is available in the main balance
            if ($mainBalance > 0) {
                $walletService->debit(WalletType::Main, $mainBalance, $reason);
            }

            // Deduct the remaining amount from the bonus balance
            $remainingAmount = $amount - $mainBalance;
            return $walletService->debit(WalletType::Bonus, $remainingAmount, $reason);
        });
    }

    /*
    * Debit Multiple wallets: main and bonus
    */

    /**
     * Debit any of the users account
     *
     * @throws Exception
     */
    public function debit(WalletType $debitWallet, float $amount, string $reason = ''): WalletTransaction
    {
        return WalletService::forUser($this)->debit($debitWallet, $amount, $reason);
    }
}