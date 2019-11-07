<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailNewsletter extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;
    protected $mailTitle;
    protected $mailBody;
    protected $products;
    protected $image_path;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($title,$body,$products,$image_path)
    {
      $this->mailTitle = $title;
      $this->mailBody = $body;
      $this->products = $products;
      $this->image_path= $image_path;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
      ini_set('max_execution_time', 120);
      $data=array(
        "action"=>""
        ,"actionText"=>""
        ,"title"=>$this->mailTitle
        ,"logo"=>url('images/icons/logo.png')
        ,"image"=>url('images/icons/email-register.png')
        ,"thumbail"=>(!empty($this->image_path) ? url($this->image_path) : null )
        ,"body"=>$this->mailBody
        ,"products"=>$this->products
      );
      return $this->view('email/newsletterEmail')->with('data',$data);
    }
}
