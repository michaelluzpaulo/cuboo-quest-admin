@extends('admin::layouts.master')

@section('css')
@endsection

@section('js')
    <script type="text/javascript" src="{{ asset('vendorjs/ckeditor4/ckeditor.js') }}?v=2"></script>
    <script type="text/javascript" src="{{ asset('vendorjs/ckeditor4/adapters/jquery.js') }}"></script>
    <script type="text/javascript" src="/dist/js/modules/Scenario.js?v=2"></script>
    <script type="text/javascript" src="/dist/js/modules/ScenarioOption.js?v=2"></script>

    <script type="text/javascript">
        $(document).ready(function() {
            Scenario.init();
        });
    </script>
@endsection

@section('module_title')
    <h1><small>Cadastros /</small> Cenários</h1>
@endsection

@section('content')
    <section class="content">
        <div class="card card-secondary card-outline">
            <div class="card-header">

                <form name="form-scenario-principal" id="form-scenario-principal">
                    <div class="row">
                        <div class="col-lg-2">
                            <div class="form-group">
                                <label for="filtro_id" class="control-label">Registro ID</label>
                                <input type="number" class="form-control" name="filtro_id" id="filtro_id" autofocus="">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label for="filtro_title" class="control-label">Título</label>
                                <input type="text" class="form-control" name="filtro_title" id="filtro_title"
                                    placeholder="Digite uma palavra chave">
                            </div>
                        </div>

                        <div class="col-lg-3">
                            <div class="form-group">
                                <label class="control-label" for="filtro_scenarios">Cenário Raiz</label>
                                <select class="form-control" name="filtro_scenarios" id="filtro_scenarios" style="width:100%">
                                    <option value="" disabled selected>Todos</option>
                                    @foreach ($scenarios as $s)
                                        <option value="{{ $s->id }}">{{ $s->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>


                        <div class="col-lg-1">
                            <label class="control-label">&nbsp;</label>
                            <button type="submit" class="run-search btn btn-secondary btn-block" data-toggle="tooltip"
                                data-placement="top" title="" id="btn-refresh"
                                data-original-title="Carregar resultados"><i class="fa fa-search"></i>
                            </button>
                        </div>
                        <div class="col-lg-1">
                            <label class="control-label">&nbsp;</label>
                            <button type="button" class="btn  btn-secondary btn-block run-add-cadastro"
                                data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="Adicionar um cadastro"><i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="card-body pb-4">
                <div class="row">
                    <div class="col-12">
                        <br />
                        <div class="table-responsive">
                            <table id="scenarioTable" class="table table-striped dataTable table-bordered" cellspacing="0"
                                width="100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Título</th>
                                        <th class="text-center">Tela Raiz</th>
                                        <th class="text-center">Tela Final</th>
                                        <th class="text-center">Editar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                            <br />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
