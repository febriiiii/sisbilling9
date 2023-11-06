<?php

namespace App\Services\Midtrans;

use Midtrans\Snap;

class CreateSnapTokenService extends Midtrans
{
    protected $order;

    public function __construct($order,$conf)
    {
        parent::__construct($conf);

        $this->order = $order;
    }

    public function getSnapToken()
    {
        $params = [
            'transaction_details' => [
                'order_id' => $this->order->notrans,
                'gross_amount' => (int) ceil($this->order->Amount),
            ],
            'item_details' => [
                [
                    'id' => $this->order->kodebarang,
                    'price' => (int) ceil($this->order->Amount),
                    'quantity' => 1,
                    'name' => $this->order->text,
                ],
            ],
            'customer_details' => [
                'first_name' => $this->order->nama,
                'email' => $this->order->email,
                'phone' => $this->order->hp,
            ]
        ];
        $snapToken = Snap::getSnapToken($params);
        return $snapToken;
    }
}