<?php

namespace App\Services\VTPass;

use http\Exception\InvalidArgumentException;

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

    /**
     * Get available plans for a specific network provide
     *
     * @param string $provider
     * @return array|null
     */
    public function getDataPlans(string $provider): ?array
    {
        if (! in_array($provider, ['mtn-data', 'airtel-data', 'glo-data', 'etisalat-data', 'glo-sme-data'])) {
            throw new InvalidArgumentException("Invalid service ID: $provider");
        }

        return $this->request('GET', 'service-variations', [
            'serviceID' => $provider
        ]);
    }
}