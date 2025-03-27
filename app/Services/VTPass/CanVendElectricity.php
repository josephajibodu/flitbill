<?php

namespace App\Services\VTPass;

use App\Enums\Electricity\MeterType;
use Couchbase\Meter;

trait CanVendElectricity
{
    /**
     * Verify Meter Number
     *
     * @param string $billerCode
     * @param string $providerId
     * @param string $type
     * @return array|null
     */
    public function verifyMeterNumber(
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
     * Purchase electricity for prepaid/postpaid meters from any of the available providers
     *
     * @param string $requestId
     * @param string $providerId
     * @param string $billerCode
     * @param string $meterType
     * @param string $amount
     * @param string $phoneNumber
     * @return array|null
     */
    public function purchasePower(
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