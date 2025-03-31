<?php

namespace App\Services\VTPass;

use App\Services\VTPass\Models\TransactionData;
use Throwable;

trait CanVendAirtime
{

    /**
     * Purchase airtime from any of the available providers
     *
     * @param string $requestId
     * @param string $providerId
     * @param float $amount
     * @param string $phoneNumber
     * @return TransactionData
     * @throws Throwable
     */
    public function purchaseAirtime(string $requestId, string $providerId, float $amount, string $phoneNumber): TransactionData
    {
        $data = $this->request('POST', 'pay', [
            'request_id' => $requestId,
            'serviceID' => $providerId,
            'amount' => $amount,
            'phone' => $phoneNumber,
        ]);

        return TransactionData::fromArray($data['content']['transactions']);
    }
}