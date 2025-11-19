<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AvisoClienteEmail extends Mailable
{
  use Queueable, SerializesModels;
  public $arr;

  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($arr)
  {
    $this->arr = $arr;

    return $this->from(env('MAIL_USERNAME'), 'Canal Ouvidoria')
      ->replyTo($this->arr['email'], $this->arr['nome'])
      ->subject('Aviso de interação de comunicação');
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('api::email/aviso-cliente', ['dados' => $this->arr]);
  }
}
