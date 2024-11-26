<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Exception;

class SertifApiService
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = Config::get('services.customer_api.url');
        $this->apiKey = Config::get('services.customer_api.key');

        if (!$this->baseUrl || !$this->apiKey) {
            throw new Exception('API configuration not found in .env');
        }
    }

    public function getCustomers($nama = '')
    {
        $response = Http::withHeaders([
            'Authorization' => $this->apiKey,
            'Accept' => 'application/json',
        ])->post("{$this->baseUrl}/customers", [
            'nama' => $nama
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception('Error fetching data: ' . $response->body());
        }
    }
}
