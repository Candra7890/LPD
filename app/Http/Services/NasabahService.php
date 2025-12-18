<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NasabahService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = url('/api/nasabah');
    }

    public function getAllNasabah()
    {
        try {
            $response = Http::timeout(10)->get($this->baseUrl);

            if ($response->successful()) {
                return $response->json()['data'] ?? [];
            }

            return [];
        } catch (\Exception $e) {
            \Log::error('Error fetching nasabah: ' . $e->getMessage());
            return [];
        }
    }

    public function getNasabahById($id)
    {
        try {
            $response = Http::timeout(10)->get("{$this->baseUrl}/{$id}");

            if ($response->successful()) {
                return $response->json()['data'] ?? null;
            }

            return null;
        } catch (\Exception $e) {
            \Log::error('Error fetching nasabah by ID: ' . $e->getMessage());
            return null;
        }
    }

    public function searchNasabah($keyword)
    {
        try {
            $response = Http::timeout(10)->get("{$this->baseUrl}/search", [
                'keyword' => $keyword
            ]);

            if ($response->successful()) {
                return $response->json()['data'] ?? [];
            }

            return [];
        } catch (\Exception $e) {
            \Log::error('Error searching nasabah: ' . $e->getMessage());
            return [];
        }
    }
}