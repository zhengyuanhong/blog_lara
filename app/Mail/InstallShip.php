<?php

namespace App\Mail;

use App\Models\InstallmentItem;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InstallShip extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    protected $items;
    protected $subMoney;
    public $subject='通知：本月还款账单已出';

    public function __construct($items,$subMoney)
    {
        $this->items = $items;
        $this->subMoney = $subMoney;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $total = 0;
        foreach($this->items as $item){
            $total +=$item->fee;
        }
        return $this->view('email.notify')->with(['items' => $this->items,'total'=>$total,'sub_money'=>$this->subMoney]);
    }
}
