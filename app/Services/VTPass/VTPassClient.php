<?php

namespace App\Services\VTPass;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use InvalidArgumentException;
use Throwable;

class VTPassClient
{
    use CanVendElectricity;
    use CanVendData;
    use CanVendAirtime;

    public string $baseUrl;
    public string $apiKey;
    public string $publicKey;
    public string $secretKey;

    public function __construct()
    {
        $this->baseUrl = config('services.vtpass.url');
        $this->apiKey = config('services.vtpass.api_key');
        $this->publicKey = config('services.vtpass.pub_key');
        $this->secretKey = config('services.vtpass.secret');
    }

    /**
     * Fetch available services.
     *
     * @return array|null
     */
    public function availableServices(): ?array
    {
        return $this->request('GET', 'service-categories');
    }

    /**
     * Get providers/sub-services under a service.
     *
     * @param string $serviceId The Identifier for the service
     * @return array|null
     */
    public function providersFor(string $serviceId): ?array
    {
        return $this->request('GET', 'services', [
            'identifier' => $serviceId
        ]);
    }

    /**
     * Get VTPass Wallet Balance
     *
     * @return array|null
     */
    public function walletBalance(): ?array
    {
        return $this->request('GET', 'balance');
    }

    /**
     * Re-query a transaction for the details
     *
     * @param string $requestId
     * @return array|null
     */
    public function verifyTransaction(string $requestId): ?array
    {
        return $this->request('POST', 'requery', [
            'request_id' => $requestId
        ]);
    }

    /**
     * Make an API request (GET or POST) and handle errors centrally.
     *
     * @param string $method   GET or POST
     * @param string $endpoint API endpoint (without base URL)
     * @param array  $data     Data for POST requests (optional)
     *
     * @return array|null Response data or null on failure
     */
    private function request(string $method, string $endpoint, array $data = []): ?array
    {
        try {
            $headers = strtoupper($method) === 'POST' ? $this->postHeader() : $this->getHeader();
            $client = Http::withHeaders($headers)->baseUrl($this->baseUrl);

            $response = match (strtoupper($method)) {
                'GET'  => $client->get($endpoint, $data),
                'POST' => $client->post($endpoint, $data),
                default => throw new InvalidArgumentException("Unsupported HTTP method: $method")
            };

            if ($response->successful()) {
                return $response->json();
            }

            throw new RequestException($response);
        } catch (Throwable $e) {
            // Log the error (optional)
            Log::error("VTPass API Error: {$e->getMessage()}");

            return null; // Return null on failure
        }
    }

    private function getHeader(): array
    {
        return [
            "api-key" => $this->apiKey,
            "public-key" => $this->publicKey,
        ];
    }

    private function postHeader(): array
    {
        return [
            "api-key" => $this->apiKey,
            "secret-key" => $this->secretKey,
        ];
    }

    private function generateRequestID(): string
    {
        $currentData = now()->timezone('Africa/Lagos')->format('YmdHi');
        $id = Str::random(10);

        return "{$currentData}{$id}";
    }
}