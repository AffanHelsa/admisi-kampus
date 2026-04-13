<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class HipolabsService
{
    protected string $baseUrl = 'http://universities.hipolabs.com';

    public function search(?string $name = null, string $country = 'Indonesia'): array
    {
        $response = Http::get("{$this->baseUrl}/search", [
            'name'    => $name,
            'country' => $country,
        ]);

        return $response->successful() ? $response->json() : [];
    }
}
