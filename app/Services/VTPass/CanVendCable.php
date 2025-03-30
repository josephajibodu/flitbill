<?php

namespace App\Services\VTPass;

use App\Enums\Electricity\MeterType;
use InvalidArgumentException;

trait CanVendCable
{
    /**
     * Verify Meter Number
     *
     * @param string $billerCode
     * @param string $providerId
     * @param string $type
     * @return array|null
     */
    public function _verifyMeterNumber(
        string $billerCode,
        string $providerId,
        string $type,
    ): ?array
    {
        return $this->request('POST', 'merchant-verify', [
            'billerCode' => $billerCode,
            'serviceID' => $providerId,
            'type' => $type,
        ]);
    }

    /**
     * Get available plans for a specific cable tv provider
     *
     * @param string $provider
     * @return array|null
     */
    public function getCablePlans(string $provider): ?array
    {
        if (! in_array($provider, ['showmax', 'startimes', 'gotv', 'dstv'])) {
            throw new InvalidArgumentException("Invalid service ID: $provider");
        }

        return $this->request('GET', 'service-variations', [
            'serviceID' => $provider
        ]);
    }


    /**
     * Purchase TV cable plans from any of the available providers
     *
     * @param string $requestId
     * @param string $providerId
     * @param string $billerCode
     * @param MeterType $meterType
     * @param string $amount
     * @param string $phoneNumber
     * @return array|null
     */
    public function purchaseCable(
        string $requestId,
        string $providerId,
        string $billerCode,
        MeterType $meterType,
        string $amount,
        string $phoneNumber,
    ): ?array
    {
        return $this->request('POST', 'pay', [
            'request_id' => $requestId,
            'serviceID' => $providerId,
            'billerCode' => $billerCode,
            'variation_code' => $meterType->value,
            'amount' => $amount,
            'phone' => $phoneNumber,
        ]);
    }
}