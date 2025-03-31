<?php

namespace App\Services\VTPass\Models;

use Illuminate\Contracts\Support\Arrayable;

class TransactionData implements Arrayable
{
    public function __construct(
        public string $status,
        public string $productName,
        public string $uniqueElement,
        public string $unitPrice,
        public int $quantity,
        public ?string $serviceVerification,
        public string $channel,
        public float $commission,
        public float $totalAmount,
        public ?string $discount,
        public string $type,
        public string $email,
        public string $phone,
        public ?string $name,
        public float $convenienceFee,
        public string $amount,
        public string $platform,
        public string $method,
        public string $transactionId,
        public CommissionRateData $commissionDetails
    ) {}

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'product_name' => $this->productName,
            'unique_element' => $this->uniqueElement,
            'unit_price' => $this->unitPrice,
            'quantity' => $this->quantity,
            'service_verification' => $this->serviceVerification,
            'channel' => $this->channel,
            'commission' => $this->commission,
            'total_amount' => $this->totalAmount,
            'discount' => $this->discount,
            'type' => $this->type,
            'email' => $this->email,
            'phone' => $this->phone,
            'name' => $this->name,
            'convenience_fee' => $this->convenienceFee,
            'amount' => $this->amount,
            'platform' => $this->platform,
            'method' => $this->method,
            'transactionId' => $this->transactionId,
            'commission_details' => $this->commissionDetails->toArray(),
        ];
    }

    /**
     * Create an instance of TransactionData from an array.
     *
     * @param array $data
     * @return static
     */
    public static function fromArray(array $data): static
    {
        return new static(
            $data['status'] ?? '',
            $data['product_name'] ?? '',
            $data['unique_element'] ?? '',
            $data['unit_price'] ?? '',
            $data['quantity'] ?? 0,
            $data['service_verification'] ?? null,
            $data['channel'] ?? '',
            $data['commission'] ?? 0.0,
            $data['total_amount'] ?? 0.0,
            $data['discount'] ?? null,
            $data['type'] ?? '',
            $data['email'] ?? '',
            $data['phone'] ?? '',
            $data['name'] ?? null,
            $data['convenience_fee'] ?? 0.0,
            $data['amount'] ?? '',
            $data['platform'] ?? '',
            $data['method'] ?? '',
            $data['transactionId'] ?? '',
            CommissionRateData::fromArray($data['commission_details'] ?? [])
        );
    }
}