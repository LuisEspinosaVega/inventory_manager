@extends('layouts.inventory')

@push('filter-required')
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
@endpush

@section('content')
    <div class="container">
        <h4 class="text-center">Generar ingreso de artículos</h4>

        <div class="row justify-content-center my-4">
            <div class="col-12 col-md-6">
                <div class="h5 text-center">Datos del ingreso</div>
                {{-- seccion para los datos generales del ingreso --}}
                <form action="{{ route('entry.store') }}" method="post" class="formCreate">
                    @csrf
                    <div class="row form-group">
                        <label for="provider_id"
                            class="col-12 col-md-5 text-center text-md-right align-self-center"><b>PROVEEDOR<span
                                    class="text-danger">*</span>:</b></label>
                        <div class="col-12 col-md-7">
                            <select name="provider_id" id="provider_id" required data-live-search="true" data-size="5"
                                class="@error('provider_id') is-invalid @enderror catalog-select">
                                <option value="">Selecciona un proveedor...</option>
                                @foreach ($providers as $provider)
                                    <option value="{{ $provider->id }}" @if ($provider->id == old('provider_id')) selected @endif>{{ $provider->name }}</option>
                                @endforeach
                            </select>
                            @error('provider_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="office_id"
                            class="col-12 col-md-5 text-center text-md-right align-self-center"><b>SUCURSAL<span
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
                        <label for="type" class="col-12 col-md-5 text-center text-md-right align-self-center"><b>TIPO DE
                                INGRESO<span class="text-danger">*</span>:</b></label>
                        <div class="col-12 col-md-7">
                            <select name="type" id="type" class="@error('type') is-invalid @enderror custom-select"
                                required>
                                <option value="">Selecciona el tipo de ingreso...</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}" @if ($type->id == old('type')) selected @endif>
                                        {{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="mandated"
                            class="col-12 col-md-5 text-center text-md-right align-self-center"><b>ENCARGADO DEL
                                INGRESO<span class="text-danger">*</span>:</b></label>
                        <div class="col-12 col-md-7">
                            <input type="text" name="mandated" id="mandated" required
                                class="form-control @error('mandated') is-invalid @enderror"
                                placeholder="Escribe quién es el encargado de este ingreso"
                                value="{{ old('mandated') }}">
                            @error('mandated')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="purchase_date"
                            class="col-12 col-md-5 text-center text-md-right align-self-center"><b>FECHA DE SOLICITUD<span
                                    class="text-danger">*</span> :</b></label>
                        <div class="col-12 col-md-7">
                            <input type="date" name="purchase_date" id="purchase_date" required
                                class="form-control @error('purchase_date') is-invalid @enderror"
                                placeholder="Escribe quién es el encargado de este ingreso"
                                value="{{ old('purchase_date') ?? date('Y-m-d') }}">
                            @error('purchase_date')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="purchase_order"
                            class="col-12 col-md-5 text-center text-md-right align-self-center"><b>ORDEN DE
                                COMPRA:</b></label>
                        <div class="col-12 col-md-7">
                            <input type="text" name="purchase_order" id="purchase_order"
                                class="form-control @error('purchase_order') is-invalid @enderror"
                                placeholder="Escribe la OC (si existe)" value="{{ old('purchase_order') }}">
                            @error('purchase_order')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group justify-content-center">
                        <div class="col-auto">
                            <button type="button" class="btn btn-sm btn-secondary" data-toggle="modal"
                                data-target="#cancelEntryModal">Cancelar ingreso</button>
                            {{-- <a href="{{route('entries')}}" class="btn btn-sm btn-secondary">Cancelar ingreso</a> --}}
                        </div>
                        <div class="col-auto">
                            @if (Auth::user()->can('edit_inventory'))
                                <button type="button" class="btn btn-sm btn-primary" id="btnConfirmEntry">Confirmar
                                    ingreso</button>
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

                </form>
            </div>

            <div class="col-12 col-md-6">
                {{-- Agregar y mostrar la lista de los items que se les dará ingreso --}}
                <div class="h5 text-center">Articulos a ingresar</div>
                <div class="row form-group">
                    <label for="catalog_search"
                        class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Catalogo<span
                                class="text-danger">*</span>:</b></label>
                    <div class="col-12 col-md-7 text-center">
                        <select name="catalog_search" id="catalog_search" class="catalog-select" data-live-search="true"
                            data-size="5">
                            <option class="font-weight-bold" value="">Buscar...</option>
                            @foreach ($catalogs as $catalog)
                                <option class="font-weight-bold" value="{{ $catalog->id }}">
                                    {{ $catalog->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- Datos de los items que se agregaran en el ingreso --}}
                <form action="" id="itemListForm">
                    <div class="row form-group">
                        <div class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Nombre corto:</b></div>
                        <div class="col-12 col-md-7">
                            <input type="text" name="catalog_name" id="catalog_name" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-12 col-md-5 text-center text-md-right align-self-center"><b>SKU:</b></div>
                        <div class="col-12 col-md-7">
                            <input type="text" name="catalog_sku" id="catalog_sku" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Marca:</b></div>
                        <div class="col-12 col-md-7">
                            <input type="text" name="catalog_brand" id="catalog_brand" class="form-control" disabled>
                        </div>
                    </div>

                    <div class="row form-group">
                        <div class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Modelo:</b></div>
                        <div class="col-12 col-md-7">
                            <input type="text" name="catalog_model" id="catalog_model" class="form-control" disabled>
                        </div>
                    </div>

                    <input type="hidden" name="catalog_id" id="catalog_id">

                    <div class="row form-group">
                        <label for="item_serie" class="col-12 col-md-5 text-center text-md-right align-self-center"><b>N°
                                Serie:</b></label>
                        <div class="col-12 col-md-7">
                            <input type="text" name="item_serie" id="item_serie" class="form-control"
                                placeholder="Ingresa el numero de serie">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="item_lot"
                            class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Lote:</b></label>
                        <div class="col-12 col-md-7">
                            <input type="text" name="item_lot" id="item_lot" class="form-control"
                                placeholder="Ingresa el lote">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="item_caducity"
                            class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Caducidad:</b></label>
                        <div class="col-12 col-md-7">
                            <input type="text" name="item_caducity" id="item_caducity" class="form-control"
                                placeholder="Ingresa la caducidad">
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="item_amount"
                            class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Cantidad<span
                                    class="text-danger">*</span>:</b></label>
                        <div class="col-12 col-md-7">
                            <input type="number" name="item_amount" id="item_amount" class="form-control"
                                placeholder="Cantidad del mismo articulo a ingresar" required>
                        </div>
                    </div>

                    <div class="row justify-content-center my-3 d-none" id="rowAlertItem">
                        <div class="col-10 text-center alert alert-danger font-weight-bolder">
                            Completa los campos con un <span class="text-danger">*</span>
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

            <div class="h5 text-center font-weight-bolder">Lista de articulos a ingresar</div>



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
                Necesitas ingresar almenos 1 artículo
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="cancelEntryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body bg-dark">
                    <div class="row justify-content-center my-3">
                        <div class="col-12 text-center text-light font-weight-bolder mb-3">
                            ¿Cancelar el ingreso?
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">No,
                                continuar</button>
                        </div>
                        <div class="col-auto">
                            <a href="{{ route('entries') }}" class="btn btn-sm btn-danger">Si, cancelar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-scripts')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js" defer></script>
    <script src="{{ asset('js/entry.js') }}" defer></script>
@endpush
