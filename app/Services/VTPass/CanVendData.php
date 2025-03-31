<?php

namespace App\Services\VTPass;

use App\Services\VTPass\Models\PlanCollection;
use App\Services\VTPass\Models\TransactionData;
use InvalidArgumentException;
use Throwable;

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
     * @return TransactionData
     * @throws Throwable
     */
    public function purchaseData(
        string $requestId,
        string $providerId,
        string $billerCode,
        string $planId,
        string $phoneNumber,
    ): TransactionData
    {
        $data = $this->request('POST', 'pay', [
            'request_id' => $requestId,
            'serviceID' => $providerId,
            'billersCode' => $billerCode,
            'variation_code' => $planId,
            'phone' => $phoneNumber,
        ]);

        return TransactionData::fromArray($data['content']['transactions']);
    }

    /**
     * Get available plans for a specific network provide
     *
     * @param string $provider
     * @return PlanCollection
     * @throws Throwable
     */
    public function getDataPlans(string $provider): PlanCollection
    {
        if (! in_array($provider, ['mtn-data', 'airtel-data', 'glo-data', 'etisalat-data', 'glo-sme-data'])) {
            throw new InvalidArgumentException("Invalid service ID: $provider");
        }

        $data = $this->request('GET', 'service-variations', [
            'serviceID' => $provider
        ]);

        return PlanCollection::fromArray($data['content']['variations']);
    }
}