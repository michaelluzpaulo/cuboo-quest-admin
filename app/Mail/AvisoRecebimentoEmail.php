<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class AvisoRecebimentoEmail extends Mailable
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
      ->subject('Aviso de Recebimento de Denúncia/Comunicação');
    // ->subject('Aviso de Recebimento de Comunicação');

    // return $this->from('auth@canal-ouvidoria.com.br','Canal Ouvidoria')
    //->replyTo($this->arr['email'],$this->arr['nome']);
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    return $this->view('api::email/aviso-recebimento', ['dados' => $this->arr]);
  }
}
