<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailOrderReminder;
class ScheduleEmailOrderReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ScheduleReminderExpire:run';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule Email Reminder Expire Order';

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
      $orders = $o->getReminderOrder();

      if(!empty($orders))
      {
        $product=array();
        foreach($orders as $order){
          if($order->paymenttype == "Bank Transfer"){
            $data = (object)[
        			'orderheader' =>$o->getOrderHeader($orders[0]->orderno),
        			'orderdetail' =>$o->getOrderDetail($orders[0]->orderno),
        			'orderinfo'=>$o->getOrderInfo($orders[0]->orderno),
        		];
             Mail::to($data->orderheader[0]->memberemail)->send(new EmailOrderReminder($data));
           }
        }
      }
    }
}
