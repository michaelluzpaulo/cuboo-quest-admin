<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContatoEmail extends Mailable
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

    return $this->from('auth@canal-ouvidoria.com.br', 'Canal Ouvidoria')
      ->subject('Contatos')
      ->replyTo($this->arr['email'], $this->arr['nome']);
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('site::email/contato', ['dados' => $this->arr]);
  }
}
