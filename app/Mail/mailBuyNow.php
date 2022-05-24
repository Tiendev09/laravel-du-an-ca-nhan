<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class mailBuyNow extends Mailable
{
    use Queueable, SerializesModels;
    public $data;
    public $content;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data,$content)
    {
        //
        $this->data = $data;
        $this->content = $content;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('frontend.mail_buy_now')
                    ->from('hoangtukimthu123@gmail.com','Lê Mạnh Tiến')
                    ->subject('[ISMART] Xác nhận đơn đặt hàng')
                    ->with($this->data,$this->content);
    }
}
