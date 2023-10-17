<?php

namespace App\Http\Controllers;

use App\Models\tbltrans;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SseController extends Controller
{
    public function sendSse(Request $request)
    {
        while (true) {
            $data = [
                'authuser' => 1,
                'type' => 'testing',
            ];
            $response = new \Symfony\Component\HttpFoundation\StreamedResponse(function () use ($data) {
                echo "data: " . json_encode($data) . "\n\n";
                ob_flush();
                flush();
                sleep(1); // Atur interval sesuai kebutuhan
            });

            $response->headers->set('Content-Type', 'text/event-stream');
            $response->headers->set('Cache-Control', 'no-cache');
            $response->headers->set('Connection', 'keep-alive');
            $response->send();
        }
    }
    private function push($data)
    {
        if(isset($data->status_code)){
            $response = new \Symfony\Component\HttpFoundation\StreamedResponse(function () use ($data) {
                echo "data: " . json_encode($data) . "\n\n";
                ob_flush();
                flush();
            });

            $response->headers->set('Content-Type', 'text/event-stream');
            $response->headers->set('Cache-Control', 'no-cache');
            $response->headers->set('Connection', 'keep-alive');
            $response->send();
        }
    }
}
