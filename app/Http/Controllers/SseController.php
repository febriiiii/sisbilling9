<?php

namespace App\Http\Controllers;

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

    public function paymentWebHook(Request $request){
        $log = new Controller;
        $log->savelog(Carbon::now(config('app.GMT')).' WeebHook MID : '. json_encode($request->all()));

        $this->push($request->all());

        return json_encode($request->all());
    }
}
