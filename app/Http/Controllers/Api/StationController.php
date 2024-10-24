<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class StationController extends Controller
{
    public function fetchData()
    {
        $client = new Client();

        try {
            // Gọi đến route proxy
            $response = $client->request(
                'GET', 
                url('http://wa-logger.pat-tech.com.vn/v1/api/history/day/?logger_sn=ELR231002&start_time=2024-10-18+00%3A00%3A00&end_time=2024-10-18+23%3A59%3A59')
            );
            // Giải mã dữ liệu JSON
            $data = json_decode($response->getBody(), true);

            // Log phản hồi từ server
            Log::info('Response from server:', ['data' => $data]);

            // Trả về dữ liệu dưới dạng JSON
            return response()->json($data);
        } catch (RequestException $e) {
            // Xử lý lỗi và log thông báo lỗi
            Log::error('Request failed:', [
                'error' => $e->getMessage(),
                'response' => $e->hasResponse() ? (string) $e->getResponse()->getBody() : null
            ]);

            // Trả về thông báo lỗi
            return response()->json([
                'error' => $e->getMessage(),
                'response' => $e->hasResponse() ? (string) $e->getResponse()->getBody() : null
            ], 500);
        }
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
