<?php

namespace App\Services\VTPass\Models;

use Illuminate\Contracts\Support\Arrayable;

class ElectricityProfileData implements Arrayable
{
    public function __construct(
        public string $customerName,
        public string $address,
        public string $meterNumber,
        public ?string $customerArrears,
        public ?string $minimumAmount,
        public ?string $minPurchaseAmount,
        public string $canVend,
        public ?string $businessUnit,
        public string $customerAccountType,
        public string $meterType,
        public bool $wrongBillersCode
    ) {}

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'Customer_Name' => $this->customerName,
            'Address' => $this->address,
            'Meter_Number' => $this->meterNumber,
            'Customer_Arrears' => $this->customerArrears,
            'Minimum_Amount' => $this->minimumAmount,
            'Min_Purchase_Amount' => $this->minPurchaseAmount,
            'Can_Vend' => $this->canVend,
            'Business_Unit' => $this->businessUnit,
            'Customer_Account_Type' => $this->customerAccountType,
            'Meter_Type' => $this->meterType,
            'WrongBillersCode' => $this->wrongBillersCode,
        ];
    }

    /**
     * Create an instance of ElectricityProfileData from an array.
     *
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new static(
            $data['Customer_Name'] ?? '',
            $data['Address'] ?? '',
            $data['Meter_Number'] ?? '',
            $data['Customer_Arrears'] ?? null,
            $data['Minimum_Amount'] ?? null,
            $data['Min_Purchase_Amount'] ?? null,
            $data['Can_Vend'] ?? 'no',
            $data['Business_Unit'] ?? null,
            $data['Customer_Account_Type'] ?? '',
            $data['Meter_Type'] ?? '',
            $data['WrongBillersCode'] ?? false
        );
    }
}