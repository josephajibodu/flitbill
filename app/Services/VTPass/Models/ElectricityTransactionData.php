<?php

namespace App\Services\VTPass\Models;

use Illuminate\Contracts\Support\Arrayable;

class ElectricityTransactionData extends TransactionData
{
    public function __construct(
        string $status,
        string $productName,
        string $uniqueElement,
        string $unitPrice,
        int $quantity,
        ?string $serviceVerification,
        string $channel,
        float $commission,
        float $totalAmount,
        ?string $discount,
        string $type,
        string $email,
        string $phone,
        ?string $name,
        float $convenienceFee,
        string $amount,
        string $platform,
        string $method,
        string $transactionId,
        CommissionRateData $commissionDetails,
        public ?string $customerName,
        public string $customerAddress,
        public string $receiptNumber,
        public float $tax,
        public string $units,
        public string $token,
        public string $tariff,
        public ?string $description,
        public ?string $kct1,
        public ?string $kct2
    ) {
        parent::__construct(
            $status,
            $productName,
            $uniqueElement,
            $unitPrice,
            $quantity,
            $serviceVerification,
            $channel,
            $commission,
            $totalAmount,
            $discount,
            $type,
            $email,
            $phone,
            $name,
            $convenienceFee,
            $amount,
            $platform,
            $method,
            $transactionId,
            $commissionDetails
        );
    }

    public function toArray(): array
    {
        return array_merge(parent::toArray(), [
            'CustomerName' => $this->customerName,
            'CustomerAddress' => $this->customerAddress,
            'ReceiptNumber' => $this->receiptNumber,
            'Tax' => $this->tax,
            'Units' => $this->units,
            'Token' => $this->token,
            'Tariff' => $this->tariff,
            'Description' => $this->description,
            'KCT1' => $this->kct1,
            'KCT2' => $this->kct2,
        ]);
    }

    public static function fromArray(array $data): static
    {
        return new static(
            $data['content']['transactions']['status'] ?? '',
            $data['content']['transactions']['product_name'] ?? '',
            $data['content']['transactions']['unique_element'] ?? '',
            $data['content']['transactions']['unit_price'] ?? '',
            $data['content']['transactions']['quantity'] ?? 0,
            $data['content']['transactions']['service_verification'] ?? null,
            $data['content']['transactions']['channel'] ?? '',
            $data['content']['transactions']['commission'] ?? 0.0,
            $data['content']['transactions']['total_amount'] ?? 0.0,
            $data['content']['transactions']['discount'] ?? null,
            $data['content']['transactions']['type'] ?? '',
            $data['content']['transactions']['email'] ?? '',
            $data['content']['transactions']['phone'] ?? '',
            $data['content']['transactions']['name'] ?? null,
            $data['content']['transactions']['convenience_fee'] ?? 0.0,
            $data['content']['transactions']['amount'] ?? '',
            $data['content']['transactions']['platform'] ?? '',
            $data['content']['transactions']['method'] ?? '',
            $data['content']['transactions']['transactionId'] ?? '',
            CommissionRateData::fromArray($data['content']['transactions']['commission_details'] ?? []),
            $data['CustomerName'] ?? null,
            $data['CustomerAddress'] ?? '',
            $data['ReceiptNumber'] ?? '',
            (float) ($data['Tax'] ?? 0.0),
            $data['Units'] ?? '',
            $data['Token'] ?? '',
            $data['Tariff'] ?? '',
            $data['Description'] ?? null,
            $data['KCT1'] ?? null,
            $data['KCT2'] ?? null
        );
    }
}