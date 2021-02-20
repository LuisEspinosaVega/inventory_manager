@extends('layouts.inventory')

@push('filter-required')
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endpush

@section('content')
    <div class="container">
        <h4 class="text-center">Generar traspaso de artículos</h4>
        <div class="row justify-content-center my-4">
            <div class="col-12 col-md-6">
                <form action="{{ route('transfer.store') }}" method="post" class="formCreate">
                    @csrf

                    <div class="row form-group">
                        <label for="office_id"
                            class="col-12 col-md-5 text-center text-md-right align-self-center"><b>SUCURSAL ORIGEN<span
                                    class="text-danger">*</span>:</b></label>
                        <div class="col-12 col-md-7">
                            <select name="office_id" id="office_id" required data-live-search="true" data-size="5"
                                class="@error('office_id') is-invalid @enderror catalog-select">
                                <option value="">Selecciona una sucursal...</option>
                                @foreach ($offices as $office)
                                    <option value="{{ $office->id }}" @if ($office->id == old('office_id')) selected @endif>
                                        {{ $office->name }}</option>
                                @endforeach
                            </select>
                            @error('office_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="destiny" class="col-12 col-md-5 text-center text-md-right align-self-center"><b>SUCURSAL
                                DESTINO<span class="text-danger">*</span>:</b></label>
                        <div class="col-12 col-md-7">
                            <select name="destiny" id="destiny" required data-live-search="true" data-size="5"
                                class="@error('destiny') is-invalid @enderror catalog-select">
                                <option value="">Selecciona una sucursal...</option>
                                @foreach ($offices as $office)
                                    <option value="{{ $office->id }}" @if ($office->id == old('destiny')) selected @endif>
                                        {{ $office->name }}</option>
                                @endforeach
                            </select>
                            @error('destiny')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="applicant"
                            class="col-12 col-md-5 text-center text-md-right align-self-center"><b>SOLICITANTE DEL
                                TRASPASO<span class="text-danger">*</span>:</b></label>
                        <div class="col-12 col-md-7">
                            <input type="text" name="applicant" id="applicant" required
                                class="form-control @error('applicant') is-invalid @enderror"
                                placeholder="Escribe quién solicita el traspaso" value="{{ old('applicant') }}">
                            @error('applicant')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="mandated"
                            class="col-12 col-md-5 text-center text-md-right align-self-center"><b>ENCARGADO DEL
                                TRASPASO<span class="text-danger">*</span>:</b></label>
                        <div class="col-12 col-md-7">
                            <input type="text" name="mandated" id="mandated" required
                                class="form-control @error('mandated') is-invalid @enderror"
                                placeholder="Escribe quién es el encargado de esta salida" value="{{ old('mandated') }}">
                            @error('mandated')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="comment"
                            class="col-12 col-md-5 text-center text-md-right align-self-center"><b>COMENTARIOS:</b></label>
                        <div class="col-12 col-md-7">
                            <textarea name="comment" id="comment"
                                class="form-control @error('comment') is-invalid @enderror" rows="3"
                                placeholder="Escribe algún comentario con informacion que consideres importante">{{ old('mandated') }}</textarea>
                            @error('comment')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group justify-content-center">
                        <div class="col-auto">
                            <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal"
                                data-target="#cancelTransferModal">Cancelar traspaso</button>
                            {{-- <a href="{{route('entries')}}" class="btn btn-sm btn-secondary">Cancelar ingreso</a> --}}
                        </div>
                        <div class="col-auto">
                            @if (Auth::user()->can('edit_inventory'))
                                <button type="button" class="btn btn-sm btn-primary" id="btnConfirmTransfer">Confirmar
                                    traspaso</button>
                            @else
                                <button type="button" class="btn btn-sm btn-dark" disabled>❌</button>
                            @endif

                        </div>
                    </div>

                    <div class="row justify-content-center my-3 d-none" id="rowFormIncomplete">
                        <div class="col-10 text-center alert alert-danger font-weight-bolder">
                            Completa los campos con un <span class="text-danger">*</span>
                        </div>
                    </div>

                    <div class="row justify-content-center my-3 d-none" id="originDestinyAlert">
                        <div class="col-10 text-center alert alert-danger font-weight-bolder">
                            El destino no puede ser el mismo que el origen.
                        </div>
                    </div>

                </form>
            </div>

            <div class="col-12 col-md-6">
                {{-- Agregar y mostrar la lista de los items que se les dará ingreso --}}
                <div class="h5 text-center">Articulos para traspaso</div>
                <div class="row form-group">
                    <label for="item_search" class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Lista
                            de articulos:</b></label>
                    <div class="col-12 col-md-7 text-center">
                        <select name="item_search" id="item_search" class="catalog-select" data-live-search="true"
                            data-size="5">
                            <option class="font-weight-bold" value="">Nombre corto - numero de serie...</option>
                            @foreach ($items as $item)
                                <option class="font-weight-bold" value="{{ $item->id }}">
                                    {{ $item->name }} - {{ $item->serial_number }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <form action="" id="itemsTransferForm">
                    <div class="row form-group">
                        <div class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Nombre corto:</b></div>
                        <div class="col-12 col-md-7">
                            <input type="text" name="catalog_name" id="catalog_name" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Numero de serie:</b>
                        </div>
                        <div class="col-12 col-md-7">
                            <input type="text" name="serial_number" id="serial_number" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-5 text-center text-md-right align-self-center"><b>ID Del artículo:</b>
                        </div>
                        <div class="col-12 col-md-7">
                            <input type="text" name="item_id" id="item_id" class="form-control" disabled>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Stock general
                                actual:</b></div>
                        <div class="col-12 col-md-7">
                            <input type="text" name="stock" id="stock" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Piezas para
                                traspaso:</b>
                        </div>
                        <div class="col-12 col-md-7">
                            <input type="number" name="transfer_amount" id="transfer_amount" class="form-control">
                        </div>
                    </div>

                    <div class="row justify-content-center my-3 d-none" id="rowAlertItem">
                        <div class="col-10 text-center alert alert-danger font-weight-bolder">
                            Verifica que la información sea correcta.
                        </div>
                    </div>

                    <div class="row justify-content-center form-group">
                        <div class="col-auto">
                            <button type="button" class="btn btn-sm btn-secondary" id="btnCancelItem">Cancelar</button>
                        </div>
                        <div class="col-auto">
                            @if (Auth::user()->can('edit_inventory'))
                                <button type="button" class="btn btn-sm btn-primary" id="btnAddItem">Agregar</button>
                            @else
                                <button type="button" class="btn btn-sm btn-dark" disabled>❌</button>
                            @endif

                        </div>
                    </div>

                </form>
            </div>

            <div class="h5 text-center font-weight-bolder">Lista de articulos para traspaso</div>

            <div class="col-10 text-center table-responsive">
                <table class="table table-sm table-bordered table-striped table-dark">
                    <thead>
                        <tr>
                            <th>Nombre articulo</th>
                            <th>N° Serie</th>
                            <th>Cantidad</th>
                            <th>Eliminar</th>
                        </tr>
                    </thead>
                    <tbody id="tableItemsBody">

                    </tbody>
                </table>
            </div>
        </div>
        <div class="row justify-content-center my-3 d-none" id="rowEmptyAlert">
            <div class="col-10 text-center alert alert-danger font-weight-bolder">
                Para continuar debes seleccionar almenos 1 artículo.
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cancelTransferModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body bg-dark">
                    <div class="row justify-content-center my-3">
                        <div class="col-12 text-center text-light font-weight-bolder mb-3">
                            ¿Cancelar el traspaso?
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">No,
                                continuar</button>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('transfer') }}" class="btn btn-sm btn-danger">Si, cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal warning -->
    <div class="modal fade" id="stockWarning" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body bg-warning">
                    <div class="row justify-content-center my-3">
                        <div class="col-12 text-center text-dark font-weight-bolder mb-3">
                            Stock actual menor a la cantidad seleccionada.
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-sm btn-dark" data-dismiss="modal">Si, continuar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js" defer></script>
    <script src="{{ asset('js/transfer-create.js') }}" defer></script>
@endpush
