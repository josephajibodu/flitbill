<?php

namespace App\Services\VTPass;

trait CanVendData
{

    /**
     * Purchase data plan from any of the available providers
     *
     * @param string $requestId
     * @param string $providerId
     * @param string $billerCode
     * @param string $planId
     * @param string $phoneNumber
     * @return array|null
     */
    public function purchaseData(
        string $requestId,
        string $providerId,
        string $billerCode,
        string $planId,
        string $phoneNumber,
    ): ?array
    {
        return $this->request('POST', 'pay', [
            'request_id' => $requestId,
            'serviceID' => $providerId,
            'billerCode' => $billerCode,
            'planId' => $planId,
            'phone' => $phoneNumber,
        ]);
    }
}