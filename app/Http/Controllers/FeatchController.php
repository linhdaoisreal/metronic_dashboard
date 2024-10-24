<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Log;

class FeatchController extends Controller
{
    public function index()
    {

        $client = new Client();

        try {

            // Gọi đến route proxy
            $response = $client->request(
                'GET',
                url('http://wa-logger.pat-tech.com.vn/v1/api/loggers/list')
            );

            // Giải mã dữ liệu JSON
            $data = json_decode($response->getBody(), true);

            if (!is_array($data)) {
                throw new \Exception('Dữ liệu không phải là mảng');
            }

            $detailedData = [];

            foreach ($data as $logger) {
                $logger_sn = $logger['logger_sn'];

                $detailedResponse = $client->request(
                    'GET',
                    url('http://wa-logger.pat-tech.com.vn/v1/api/loggers/?logger_sn=' . $logger_sn . '')
                );

                $detailData = json_decode($detailedResponse->getBody(), true);

                $detailedData[] = [
                    'logger'        => $logger,
                    'detailData'    => $detailData
                ];
            }

            // Phân trang
            $currentPage = LengthAwarePaginator::resolveCurrentPage();
            $perPage = 10; // Số lượng item mỗi trang
            $currentItems = array_slice($detailedData, ($currentPage - 1) * $perPage, $perPage);
            $paginatedData = new LengthAwarePaginator($currentItems, count($detailedData), $perPage, $currentPage, [
                'path' => LengthAwarePaginator::resolveCurrentPath()
            ]);
            // dd($detailedData);

            return view('admin.featch.index', compact('paginatedData',));
        } catch (\Throwable $th) {
            Log::error('Có lỗi xảy ra', ['error' => $th->getMessage()]);
            return response()->json(['error' => 'Có lỗi xảy ra'], 500);
        }
    }

    public function featchOne($logger_sn)
    {

        $client = new Client();

        try {
            $start_time = Carbon::today()->startOfDay(); // 2024-10-24 00:00:00
            $end_time = Carbon::today()->endOfDay(); // 2024-10-24 23:59:59
            $start_time_formatted = $start_time->format('Y-m-d H:i:s');
            $end_time_formatted = $end_time->format('Y-m-d H:i:s');

            // Gọi đến route proxy
            $response = $client->request(
                'GET',
                url(
                    'http://wa-logger.pat-tech.com.vn/v1/api/history/day/?logger_sn=' . $logger_sn . '&start_time=' . $start_time_formatted . '&end_time=' . $end_time_formatted . ''
                    )
            );

            $data = json_decode($response->getBody(), true);

            if (!is_array($data)) {
                throw new \Exception('Dữ liệu không phải là mảng');
            }

            $chartData = [];

            //Dữ liệu cho chart
            foreach ($data as $record) {
                $chartData[] = [
                    'x' => strtotime($record['created_date_srv']) * 1000, // Chuyển đổi sang milliseconds  
                    'flow' => (float)$record['flow'],
                    'pressure' => (float)$record['pressure'],
                    'meter_idx' => (float)$record['meter_idx'],
                ];
            }

            //Chi tiết Logger
            $detailedResponse = $client->request(
                'GET',
                url('http://wa-logger.pat-tech.com.vn/v1/api/loggers/?logger_sn=' . $logger_sn . '')
            );

            $detailData = json_decode($detailedResponse->getBody(), true);

            // dd($chartData, $detailData);

            return view('admin.featch.show', compact('chartData', 'detailData', 'logger_sn'));
        } catch (\Throwable $th) {
            Log::error('Có lỗi xảy ra', ['error' => $th->getMessage()]);
            return response()->json(['error' => 'Có lỗi xảy ra'], 500);
        }
    }
}
