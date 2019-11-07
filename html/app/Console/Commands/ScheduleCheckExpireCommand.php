<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailOrder;
class ScheduleCheckExpireCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ScheduleCheckExpire:run';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expire Order';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
      $o = new Order;
      $check = $o->getExpireOrder();
      if(!empty($check))
      {
        foreach($check as $order)
        {
          $o->updateExpireOrder($order->orderno);
          $data = (object)[
      			'orderheader'=>$o->getOrderHeader($order->orderno),
      			'orderdetail'=>$o->getOrderDetail($order->orderno),
      			'orderinfo'  =>$o->getOrderInfo($order->orderno)
      		];
      		Mail::to($order->memberemail)->send(new EmailOrder($data));
        }
      }
    }
}
