<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use Carbon\Carbon;

class ApiKeyController extends Controller
{
    public function generate()
    {
        // generate random key
        $apiKey = bin2hex(random_bytes(32));

        // set maksimal hit dan reset date
        $maxHit = 20;
        $last_reset_date = date('Y-m-d');

        // create new api_key record
        $generatedApiKey = ApiKey::create([
            'api_key' => $apiKey,
            'max_hit' => $maxHit,
            'hit_count' => 0,
            'last_reset_date' => $last_reset_date,
            'created_at' => Carbon::now()
        ]);

        if($generatedApiKey) {
            return response()->json([
                "success" => true,
                "message" => "Api Key Sudah Ditambahkan",
                "data" => $generatedApiKey
            ], 200);
        }

        return response()->json([
            "success" => false,
            "message" => "Ups sepertinya ada yang salah",
            "data" => []
        ]);
    }
}
