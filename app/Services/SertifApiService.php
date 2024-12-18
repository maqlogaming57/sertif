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
        // $currentDate = date('Y-m-t');
        $response = Http::withOptions([
            'verify' => false
        ])->withHeaders([
            'Authorization' => $this->apiKey,
            'Accept' => 'application/json',
        ])->post("{$this->baseUrl}/sertifs", [
            'nama' => $nama
            // 'date' => $currentDate
        ]);

        if ($response->successful()) {
            return $response->json();
        } else {
            throw new \Exception('Error fetching data: ' . $response->body());
        }
    }
}
