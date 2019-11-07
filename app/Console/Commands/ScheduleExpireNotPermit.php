<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Models\Order;
use Illuminate\Support\Facades\Mail;
use App\Mail\EmailExpireNotPermit;
class ScheduleExpireNotPermit extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ScheduleExpireNotPermit:run';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Schedule Email Expire Not Permit';

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
      $checks = $o->getExpireNotPermit();
      if(!empty($checks))
      {
        foreach($checks as $check)
        {
          if($check->paid == 0)
          {
        		$data = (object)[
        			'orderheader' =>$o->getOrderHeader($check->orderno),
        			'ordernotpermit' =>$o->getOrderNotPermit($check->orderno)
        		];
            Mail::to($check->memberemail)->send(new EmailExpireNotPermit($data));
          }
        }
      }
    }
}
