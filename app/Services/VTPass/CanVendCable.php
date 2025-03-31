<?php

namespace App\Services\VTPass;

use App\Enums\Electricity\MeterType;
use App\Services\VTPass\Models\CommissionRateData;
use App\Services\VTPass\Models\PlanCollection;
use App\Services\VTPass\Models\SmartCardData;
use App\Services\VTPass\Models\TransactionData;
use InvalidArgumentException;
use Throwable;

trait CanVendCable
{
    /**
     * Verify SmartCard Number
     *
     * @param string $billerCode
     * @param string $providerId
     * @return SmartCardData
     * @throws Throwable
     */
    public function verifySmartCardNumber(
        string $billersCode,
        string $providerId,
    ): SmartCardData
    {
        $data = $this->request('POST', 'merchant-verify', [
            'billersCode' => $billersCode,
            'serviceID' => $providerId,
        ]);

        return SmartCardData::fromArray($data['content']);
    }

    /**
     * Get available plans for a specific cable tv provider
     *
     * @param string $provider
     * @return PlanCollection
     * @throws Throwable
     */
    public function getCablePlans(string $provider): PlanCollection
    {
        if (! in_array($provider, ['showmax', 'startimes', 'gotv', 'dstv'])) {
            throw new InvalidArgumentException("Invalid service ID: $provider");
        }

        $data = $this->request('GET', 'service-variations', [
            'serviceID' => $provider
        ]);

        return PlanCollection::fromArray($data['content']['variations']);
    }


    /**
     * Purchase TV cable plans from any of the available providers
     *
     * @param string $requestId
     * @param string $providerId
     * @param string $billersCode
     * @param string $planCode
     * @param string $subscriptionType
     * @param string $phoneNumber
     * @param string $quality
     * @return TransactionData
     * @throws Throwable
     */
    public function purchaseCable(
        string $requestId,
        string $providerId,
        string $billersCode,
        string $planCode,
        string $subscriptionType,
        string $phoneNumber,
        string $quantity,
    ): TransactionData
    {
        if (!in_array($subscriptionType, ['renew', 'change'])) {
            throw new InvalidArgumentException("Invalid subscription type");
        }

        $data = $this->request('POST', 'pay', [
            'request_id' => $requestId,
            'serviceID' => $providerId,
            'billersCode' => $billersCode,
            'variation_code' => $planCode,
            'subscriptionType' => $subscriptionType,
            'phone' => $phoneNumber,
            'quantity' => $quantity,
        ]);

        return TransactionData::fromArray($data['content']['transactions']);
    }
}