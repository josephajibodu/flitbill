<?php

namespace App\Services\VTPass\Models;

use Illuminate\Contracts\Support\Arrayable;

class TransactionData implements Arrayable
{
    public function __construct(
        public string $code,
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
            'code' => $this->code,
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
        $transaction = $data['content']['transactions'];

        return new static(
            $data['code'] ?? '',
            $transaction['status'] ?? '',
            $transaction['product_name'] ?? '',
            $transaction['unique_element'] ?? '',
            $transaction['unit_price'] ?? '',
            $transaction['quantity'] ?? 0,
            $transaction['service_verification'] ?? null,
            $transaction['channel'] ?? '',
            $transaction['commission'] ?? 0.0,
            $transaction['total_amount'] ?? 0.0,
            $transaction['discount'] ?? null,
            $transaction['type'] ?? '',
            $transaction['email'] ?? '',
            $transaction['phone'] ?? '',
            $transaction['name'] ?? null,
            $transaction['convenience_fee'] ?? 0.0,
            $transaction['amount'] ?? '',
            $transaction['platform'] ?? '',
            $transaction['method'] ?? '',
            $transaction['transactionId'] ?? '',
            CommissionRateData::fromArray($transaction['commission_details'] ?? [])
        );
    }
}