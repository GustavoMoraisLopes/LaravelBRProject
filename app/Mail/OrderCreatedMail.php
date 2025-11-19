<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderCreatedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $items;

    public function __construct($order, $items = [])
    {
        $this->order = $order;
        $this->items = $items;
    }

    public function build()
    {
        return $this->subject('Confirmação da encomenda ' . ($this->order->order_number ?? ''))
                    ->markdown('emails.order-created')
                    ->with(['order' => $this->order, 'items' => $this->items]);
    }
}
