@extends('layouts.inventory')

@section('content')
    <div class="container">
        <div class="h4 text-center">Editar item con ID: <b>{{ $item->id }}</b></div>

        <div class="row justify-content-center my-4">
            <div class="col-12 col-md-4">
                {{-- imagen --}}
                @if ($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" class="img-fluid" alt="">
                @else
                    <img src="{{ asset('storage/item/no-image-item.svg') }}" class="img-fluid" alt="">
                @endif
            </div>
            <div class="col-12 col-md-8">

                <form action="{{ route('item.update', $item->id) }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div class="row form-group h5">
                        <label for="" class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Nombre
                                corto:</b></label>
                        <div class="col-12 col-md-7">
                            {{ $item->catalog->name }}
                        </div>
                    </div>

                    <div class="row form-group h5">
                        <label for=""
                            class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Descripción:</b></label>
                        <div class="col-12 col-md-7">
                            {{ $item->catalog->description }}
                        </div>
                    </div>

                    <div class="row form-group h5">
                        <label for="serial_number"
                            class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Numero de
                                serie:</b></label>
                        <div class="col-12 col-md-7">
                            <input type="text" name="serial_number" id="serial_number"
                                class="form-control @error('serial_number') is-invalid @enderror"
                                value="{{ old('serial_number') ?? $item->serial_number }}">

                            @error('serial_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group h5">
                        <label for="caducity"
                            class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Caducidad:</b></label>
                        <div class="col-12 col-md-7">
                            <input type="text" name="caducity" id="caducity"
                                class="form-control @error('caducity') is-invalid @enderror"
                                value="{{ old('caducity') ?? $item->caducity }}">

                            @error('caducity')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group h5">
                        <label for="lot"
                            class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Lote:</b></label>
                        <div class="col-12 col-md-7">
                            <input type="text" name="lot" id="lot" class="form-control @error('lot') is-invalid @enderror"
                                value="{{ old('lot') ?? $item->lot }}">

                            @error('lot')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="image" class="col-12 col-md-5 text-center text-md-right align-self-center h5"><b>Imagen especifica:</b></label>
                        <div class="col-12 col-md-7 text-center text-md-left">
                            <input type="file" name="image" id="image" accept="image/*" style="overflow: hidden;">
                            @if ($errors->has('image'))
                                <div class="col-12 text-center text-danger"><b>{{ $errors->first('image') }}</b></div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group justify-content-center justify-content-md-end">
                        <div class="col-auto text-center">
                            <a role="button" href="{{ route('items') }}" class="btn btn-sm btn-secondary">Regresar</a>
                        </div>
                        <div class="col-auto text-center">
                            @if (Auth::user()->can('edit_inventory'))
                                <button type="submit" class="btn btn-sm btn-primary">Editar</button>
                            @else
                                <button type="button" class="btn btn-sm btn-dark" disabled>Editar</button>
                            @endif

                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteItemModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body bg-dark">
                    <form action="{{ route('item.destroy') }}" method="post" id="deleteItemForm">
                        @csrf
                        <div class="row justify-content-center p-1">
                            <input type="hidden" name="id_item" id="id_item">
                            <div class="col-12 text-center h5 text-light mb-3">
                                ¿Eliminar este articulo?
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Cancelar</button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-sm btn-danger">Si, eliminar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('js/item/item-detail.js') }}" defer></script>
@endpush
