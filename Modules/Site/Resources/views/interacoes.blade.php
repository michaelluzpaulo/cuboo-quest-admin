@extends('site::layouts.master')

@section('content')

    <section class="container content">
        <div class="row">
            <div class="col-lg-12">
                <h2>Manifesto</h2>
                <p>{{ $comunicacao->manifestacao }}</p>
            </div>
            <h2 class="mt-5">Interações</h2>
        </div>


        <div class="row">
            <div class="col-lg-12">
                <div class="accordion" id="accordion-interacoes">
                    @foreach ($interacoes as $i)
                        <div class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button accordion_title" type="button" data-bs-toggle="collapse"
                                    data-bs-target="#accordion-interacoes-{{ $i->id }}" aria-expanded="false"
                                    aria-controls="accordion-interacoes-{{ $i->id }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" style="margin-right: 12px;" width="14"
                                        height="14" fill="#c4c4c4" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z" />
                                    </svg>
                                    {{ __date_time_mysql_to_iso($i->created_at) }}
                                    - {{ $i->remetente == 'U' ? $empresa->nome : 'Você' }}
                                </button>
                            </h2>
                            <div id="accordion-interacoes-{{ $i->id }}" class="accordion-collapse collapse"
                                data-bs-parent="#accordion-interacoes">
                                <div class="accordion-body">
                                    <p> {!! $i->texto !!}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <br />
        <br />
        <div class="row">
            <div class="col-lg-12">
                <h2>Nova Interação:</h2>
                <form class="form_nova_interacao" id="form-interacoes">
                    <input type="hidden" id="empresa_id" name="empresa_id" value="{{ $comunicacao->empresa_id }}" />
                    <input type="hidden" id="codigo" name="codigo" value="{{ $codigo }}" />
                    <textarea name="interacao" id="interacao" style="width: 100%" cols="20" rows="5"></textarea>
                    <div class="text-center">
                        <button type="submit" class="btn btn-lg btn-primary" id="btn-interacao">Enviar</button>
                    </div>
                </form>
            </div>
        </div>

    </section>

@stop
