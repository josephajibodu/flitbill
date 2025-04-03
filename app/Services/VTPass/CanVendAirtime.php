<?php

namespace App\Services\VTPass;

use App\Enums\NetworkProvider;
use App\Services\VTPass\Exceptions\VTPassException;
use App\Services\VTPass\Models\TransactionData;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Throwable;

trait CanVendAirtime
{

    /**
     * Purchase airtime from any of the available providers
     *
     * @param string $requestId
     * @param NetworkProvider $providerId
     * @param float $amount
     * @param string $phoneNumber
     * @return TransactionData
     * @throws VTPassException
     * @throws Throwable
     * @throws ConnectionException
     * @throws RequestException
     */
    public function purchaseAirtime(string $requestId, NetworkProvider $providerId, float $amount, string $phoneNumber): TransactionData
    {
        $data = $this->request('POST', 'pay', [
            'request_id' => $requestId,
            'serviceID' => $this->getAirtimePlanKeyByNetwork($providerId),
            'amount' => $amount,
            'phone' => $phoneNumber,
        ]);

        return TransactionData::fromArray($data);
    }
}