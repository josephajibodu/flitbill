<?php

namespace App\Services\VTPass\Models;

use Illuminate\Contracts\Support\Arrayable;

class SmartCardData implements Arrayable
{
    public function __construct(
        public string $customerName,
        public string $status,
        public string $dueDate,
        public string $customerNumber,
        public string $customerType,
    )
    {}


    /**
     * @inheritDoc
     */
    public function toArray(): array
    {
        return [
            'Customer_Name' => $this->customerName,
            'Status' => $this->status,
            'Due_Date' => $this->dueDate,
            'Customer_Number' => $this->customerNumber,
            'Customer_Type' => $this->customerType,
        ];
    }

    /**
     * Create an instance of SmartCardData from an array.
     *
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new static(
            $data['Customer_Name'] ?? '',
            $data['Status'] ?? '',
            $data['Due_Date'] ?? '',
            $data['Customer_Number'] ?? '',
            $data['Customer_Type'] ?? ''
        );
    }
}