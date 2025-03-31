<?php

namespace App\Services\VTPass;

use App\Enums\Electricity\MeterType;
use App\Services\VTPass\Models\ElectricityProfileData;
use App\Services\VTPass\Models\ElectricityTransactionData;
use App\Services\VTPass\Models\TransactionData;
use Couchbase\Meter;
use Throwable;

trait CanVendElectricity
{
    /**
     * Verify Meter Number
     *
     * @param string $billersCode
     * @param string $providerId
     * @param string $type
     * @return ElectricityProfileData
     * @throws Throwable
     */
    public function verifyMeterNumber(
        string $billersCode,
        string $providerId,
        string $type,
    ): ElectricityProfileData
    {
        $data = $this->request('POST', 'merchant-verify', [
            'billersCode' => $billersCode,
            'serviceID' => $providerId,
            'type' => $type,
        ]);

        return ElectricityProfileData::fromArray($data['content']);
    }


    /**
     * Purchase electricity for prepaid/postpaid meters from any of the available providers
     *
     * @param string $requestId
     * @param string $providerId
     * @param string $billersCode
     * @param MeterType $meterType
     * @param string $amount
     * @param string $phoneNumber
     * @return TransactionData
     * @throws Throwable
     */
    public function purchasePower(
        string $requestId,
        string $providerId,
        string $billersCode,
        MeterType $meterType,
        string $amount,
        string $phoneNumber,
    ): TransactionData
    {
        $data =  $this->request('POST', 'pay', [
            'request_id' => $requestId,
            'serviceID' => $providerId,
            'billersCode' => $billersCode,
                'variation_code' => $meterType->value,
            'amount' => $amount,
            'phone' => $phoneNumber,
        ]);

        return ElectricityTransactionData::fromArray($data);
    }
}