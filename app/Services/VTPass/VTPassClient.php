<?php

namespace App\Services\VTPass;

use App\Enums\CableProvider;
use App\Enums\NetworkProvider;
use App\Services\VTPass\Exceptions\VTPassException;
use App\Services\VTPass\Exceptions\VTPassServerError;
use Illuminate\Http\Client\ConnectionException;
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
    use CanVendCable;

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
     * Fetch available plans.
     *
     * @param string $type
     * @param string $service
     * @return array
     */
    public function availablePlans(string $type, string $service): array
    {
        $validTypes = ['data', 'cables'];

        if (!in_array($type, $validTypes, true)) {
            Log::warning("Invalid service TYPE requested: $type");
            return [];
        }

        return match ($type) {
            'data' => $this->getDataPlans($service) ?? [],
            'cables' => $this->getCablePlans($service) ?? [],
            default => [],
        };
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

    public function getDataPlanKeyByNetwork(NetworkProvider $network): string|array
    {
        return match ($network) {
            NetworkProvider::MTN => 'mtn-data',
            NetworkProvider::GLO => ['glo-data', 'glo-sme-data'],
            NetworkProvider::AIRTEL => 'airtel-data',
            NetworkProvider::_9MOBILE => 'etisalat-data',
        };
    }

    public function getAirtimePlanKeyByNetwork(NetworkProvider $network): string|array
    {
        return match ($network) {
            NetworkProvider::MTN => 'mtn',
            NetworkProvider::GLO => 'glo',
            NetworkProvider::AIRTEL => 'airtel',
            NetworkProvider::_9MOBILE => 'etisalat',
        };
    }

    public function getCablePlanKeyByProvider(CableProvider $network): string|array
    {
        return match ($network) {
            CableProvider::Startimes => 'startimes',
            CableProvider::GoTV => 'gotv',
            CableProvider::DSTV => 'dstv',
            CableProvider::ShowMax => 'showmax',
        };
    }

    /**
     * Make an API request (GET or POST) and handle errors centrally.
     *
     * @param string $method GET or POST
     * @param string $endpoint API endpoint (without base URL)
     * @param array $data Data for POST requests (optional)
     *
     * @return array|null Response data or null on failure
     * @throws RequestException
     * @throws Throwable
     * @throws VTPassException
     * @throws ConnectionException
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

            logger()->channel('api_logs')->info('HTTP Request', [
                'method' => $method,
                'endpoint' => $endpoint,
                'data' => $data,
                'response_status' => $response->status(),
                'response_body' => $response->body(),
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            if ($response->serverError()) {
                throw new VTPassException($response);
            }

            if ($response->clientError()) {
                throw new VTPassException($response);
            }

            throw new RequestException($response);
        } catch (Throwable|VTPassException $e) {
            Log::error("VTPass API Error: {$e->getMessage()}");

            throw $e;
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

    public function generateRequestID(): string
    {
        $currentData = now()->timezone('Africa/Lagos')->format('YmdHi');
        $id = Str::random(10);

        return "{$currentData}{$id}";
    }
}