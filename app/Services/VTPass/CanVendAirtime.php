<?php

namespace App\Services\VTPass;

trait CanVendAirtime
{

    /**
     * Purchase airtime from any of the available providers
     *
     * @param string $requestId
     * @param string $providerId
     * @param float $amount
     * @param string $phoneNumber
     * @return array|null
     */
    public function purchaseAirtime(string $requestId, string $providerId, float $amount, string $phoneNumber): ?array
    {
        return $this->request('POST', 'pay', [
            'request_id' => $requestId,
            'serviceID' => $providerId,
            'amount' => $amount,
            'phone' => $phoneNumber,
        ]);
    }
}