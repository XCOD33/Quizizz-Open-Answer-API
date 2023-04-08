<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\Game;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GameController extends Controller
{
    public function getAnswer(Request $request)
    {

        // mendapatkan api key dari query / request header 
        $apiKey = $request->header('X-API-KEY') ?? $request->query('api_key');

        // mendapatkan api key dari database
        $key = ApiKey::where('api_key', '=', $apiKey)->first();

        // jika key tidak ditemukan di database
        if(!$key) {
            return response()->json(['message' => 'Invalid API Key'], 401);
        }

        // cek apakah hit count sudah maksimum
        if($key['hit_count'] >= $key['max_hit'] and $key['last_reset_date'] == date('Y-m-d')) {
            // gagalkan request karena hit count melampaui batas
            return response()->json(['message' => 'API Key Hit Limit Exceeded'], 429);
        }

        // update hit count
        ApiKey::findOrFail($key['id'])->update(['hit_count' => $key['hit_count'] + 1]);

        // cek apakah last reset date sudah terlewati
        if($key['last_reset_date'] < date('Y-m-d')) {
            // reset hit count dan reset date
            ApiKey::findOrFail($key['id'])->update([
                'hit_count' => 1,
                'last_reset_date' => date('Y-m-d')
            ]);
        }

        $apiEndpoint = env('URI_ENDPOINT');
        // mendapatkan query dari pin
        $pin = $request->query('pin');

        // melakukan request
        $client = new Client();
        $response = $client->request('GET', $apiEndpoint, [
            'query' => ['pin' => $pin]
        ]);

        Game::create([
            'pin' => $pin,
            'ip' => $request->ip(),
            'api_key_id' => $key['id']
        ]);

        $data = json_decode($response->getBody(), true);

        return response()->json($data);
    }
}
