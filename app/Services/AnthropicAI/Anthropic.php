<?php

namespace App\Services\AnthropicAI;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;
use Throwable;

class Anthropic
{
    private string $apiKey;
    private string $baseUrl = "https://api.anthropic.com/v1/";

    public function __construct()
    {
        $this->apiKey = config('services.anthropic.key');
    }

    /**
     * Send a message to the Anthropic API.
     *
     * @param array $messages
     * @return array|null
     */
    public function createMessage(array $messages): ?array
    {
        return $this->request('POST', 'messages', [
            'model' => 'claude-3-7-sonnet-20250219',
            'max_tokens' => 4096,
            'messages' => $messages,
        ]);
    }

    /**
     * Count the number of tokens in a message.
     *
     * @param array $messages
     * @return array|null
     */
    public function countToken(array $messages): ?array
    {
        return $this->request('POST', 'messages/count_tokens', [
            'model' => 'claude-3-7-sonnet-20250219',
            'messages' => $messages,
        ]);
    }

    /**
     * Make an API request and handle errors centrally.
     *
     * @param string $method GET or POST
     * @param string $endpoint API endpoint (without base URL)
     * @param array $data Data for POST requests (optional)
     * @return array|null Response data or null on failure
     */
    private function request(string $method, string $endpoint, array $data = []): ?array
    {
        try {
            $headers = [
                "Content-Type" => "application/json",
                "x-api-key" => "$this->apiKey",
                "anthropic-version" => "2023-06-01",
            ];

            $client = Http::withHeaders($headers)->timeout(60)->baseUrl($this->baseUrl);

            $response = match (strtoupper($method)) {
                'POST' => $client->post($endpoint, $data),
                'GET' => $client->get($endpoint, $data),
                default => throw new InvalidArgumentException("Unsupported HTTP method: $method")
            };

            logger()->channel('api_logs')->info('HTTP Request', [
                'method' => $method,
                'endpoint' => $endpoint,
                'response_status' => $response->status(),
                'response_body' => $response->body(),
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            throw new \Exception("Anthropic API request failed: " . $response->body());
        } catch (Throwable $e) {
            Log::error("Anthropic API Error: {$e->getMessage()}");
            return null;
        }
    }
}