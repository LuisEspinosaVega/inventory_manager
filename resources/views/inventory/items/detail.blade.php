@extends('layouts.inventory')

@section('content')
    <div class="container">
        <div class="h4 text-center">Detalles del item con ID: <b>{{ $item->id }}</b></div>

        
        @if (session('edited'))
            <div class="row justify-content-center mb-3">
                <div class="col-10 text-center">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{session('edited')}}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

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
                    <label for="" class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Numero de
                            serie:</b></label>
                    <div class="col-12 col-md-7">
                        {{ $item->serial_number }}
                    </div>
                </div>

                <div class="row form-group h5">
                    <label for=""
                        class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Caducidad:</b></label>
                    <div class="col-12 col-md-7">
                        {{ $item->caducity ?? 'N/A' }}
                    </div>
                </div>

                <div class="row form-group h5">
                    <label for="" class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Lote:</b></label>
                    <div class="col-12 col-md-7">
                        {{ $item->lot ?? 'N/A' }}
                    </div>
                </div>

                <div class="row form-group h5">
                    <label for="" class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Stock:</b></label>
                    <div class="col-12 col-md-7">
                        {{ $item->stock }}
                    </div>
                </div>

                <div class="row form-group h5">
                    <label for="" class="col-12 col-md-5 text-center text-md-right align-self-center"><b>Fecha de
                            alta:</b></label>
                    <div class="col-12 col-md-7">
                        {{ $item->created_at }}
                    </div>
                </div>

                <div class="row form-group justify-content-center justify-content-md-end">
                    <div class="col-auto text-center">
                        <a role="button" href="{{ route('items') }}" class="btn btn-sm btn-secondary">Regresar</a>
                    </div>
                    <div class="col-auto text-center">
                        @if (Auth::user()->can('edit_inventory'))
                            <a role="button" href="{{ route('item.edit', $item->id) }}"
                                class="btn btn-sm btn-primary">Editar</a>
                        @else
                            <button type="button" class="btn btn-sm btn-dark" disabled>Editar</button>
                        @endif

                    </div>
                    {{-- <div class="col-auto text-center">
                        @if (!Auth::user()->can('edit_inventory'))
                            <button type="button" class="btn btn-sm btn-dark" disabled>Eliminar</button>
                        @else
                            <button type="button" class="btn btn-sm btn-danger" data-iditem="{{ $item->id }}"
                                data-toggle="modal" data-target="#deleteItemModal">Eliminar</button>
                        @endif

                    </div> --}}
                </div>

            </div>
        </div>

        <div class="h4 text-center">Existencias en cada sucursal</div>
        <div class="row justify-content-center my-3">
            <div class="col-12 col-md-6 text-center">
                <table class="table table-sm table-dark table-hover table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>SUCURSAL</th>
                            <th>STOCK</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($existence as $exist)
                            <tr>
                                <td>
                                    @foreach ($offices as $office)
                                        @if ($office->id == $exist->office_id)
                                            {{ $office->name }}
                                        @endif
                                    @endforeach
                                </td>
                                <td>
                                    {{ $exist->stock }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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
