@extends('layouts.inventory')

@section('content')
    <div class="container">
        <div class="h4 text-center">Detalles del traspaso con ID <b>{{ $transfer->id }}</b></div>
        <div class="row justify-content-center justify-content-md-end">
            <a role="button" href="{{ route('transfer') }}" class="btn btn-sm btn-dark">Regresar ⇖</a>
        </div>

        <div class="row justify-content-center my-4">
            <div class="col-12 col-md-8 text-center text-md-right">
                <div class="row form-group h5">
                    <div class="col-12 col-md-5 text-center text-md-right">Fecha solicitado:</div>
                    <div class="col-12 col-md-7 text-center text-md-left">{{ $transfer->created_at }}</div>
                </div>
                <div class="row form-group h5">
                    <div class="col-12 col-md-5 text-center text-md-right">Última modificación:</div>
                    <div class="col-12 col-md-7 text-center text-md-left">{{ $transfer->updated_at }}</div>
                </div>
                <div class="row form-group h5">
                    <div class="col-12 col-md-5 text-center text-md-right">Transferencia creada por:</div>
                    <div class="col-12 col-md-7 text-center text-md-left">{{ $transfer->user->name }}</div>
                </div>
                <div class="row form-group h5">
                    <div class="col-12 col-md-5 text-center text-md-right">Encargado de la transferencia:</div>
                    <div class="col-12 col-md-7 text-center text-md-left">{{ $transfer->mandated }}</div>
                </div>
                <div class="row form-group h5">
                    <div class="col-12 col-md-5 text-center text-md-right">Solicitante:</div>
                    <div class="col-12 col-md-7 text-center text-md-left">{{ $transfer->applicant }}</div>
                </div>
                <div class="row form-group h5">
                    <div class="col-12 col-md-5 text-center text-md-right">Sucursal de origen:</div>
                    <div class="col-12 col-md-7 text-center text-md-left">{{ $transfer->office->name }}</div>
                </div>
                <div class="row form-group h5">
                    <div class="col-12 col-md-5 text-center text-md-right">Sucursal destino:</div>
                    <div class="col-12 col-md-7 text-center text-md-left">
                        @foreach ($offices as $office)
                            @if ($office->id == $transfer->destiny)
                                {{ $office->name }}
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="row form-group h5">
                    @php
                        $text = '';
                        switch ($transfer->status) {
                            case 'Solicitado':
                                $text = 'text-primary';
                                break;
                            case 'Autorizado':
                                $text = 'text-info';
                                break;
                            case 'Recibido':
                                $text = 'text-success';
                                break;
                            case 'Cancelado':
                                $text = 'text-danger';
                                break;
                        }
                    @endphp
                    <div class="col-12 col-md-5 text-center text-md-right">Estatus del traspaso:</div>
                    <div class="col-12 col-md-7 text-center text-md-left {{ $text }}">{{ $transfer->status }}
                    </div>
                </div>

                <div class="row form-group justify-content-center">
                    {{-- <div class="col-auto text-center">
                        @if (Auth::user()->can('edit_inventory') && $transfer->status == 'Solicitado')
                            <a role="button" href="{{ route('transfer.edit', $transfer->id) }}"
                                class="btn btn-sm btn-primary">Editar</a>
                        @else
                            <button type="button" class="btn btn-sm btn-dark" disabled>Editar</button>
                        @endif
                    </div> --}}
                    <div class="col-auto text-center">
                        @if (Auth::user()->can('edit_inventory') && $transfer->status == 'Solicitado')
                            <button type="button" class="btn btn-sm btn-info" data-toggle="modal"
                                data-target="#authorizeTransferModal">Autorizar</button>
                        @else
                            <button type="button" class="btn btn-sm btn-dark" disabled>Autorizar</button>
                        @endif
                    </div>
                    <div class="col-auto text-center">
                        @if (Auth::user()->can('edit_inventory') && $transfer->status == 'Autorizado')<!-- && $transfer->status == 'Autorizado'-->
                            <button type="button" class="btn btn-sm btn-success"  data-toggle="modal" data-target="#recibirTransferModal">Recibir</button>
                        @else
                            <button type="button" class="btn btn-sm btn-dark" disabled>Recibir</button>
                        @endif
                    </div>
                    <div class="col-auto text-center">
                        @if (Auth::user()->can('edit_inventory') && $transfer->status == 'Solicitado')
                            <button type="button" class="btn btn-sm btn-danger" data-toggle="modal" data-target="#cancelTransferModal">Cancelar</button>
                        @else
                            <button type="button" class="btn btn-sm btn-dark" disabled>Cancelar</button>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center my-3">
            <div class="col-12 col-md-8 text-center table-responsive">
                <table class="table table-sm table-dark table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ARTICULO</th>
                            <th>N° SERIE</th>
                            <th>CANTIDAD</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{ $log->item->catalog->name }}</td>
                                <td>{{ $log->item->serial_number }}</td>
                                <td>{{ $log->amount }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal autorizar -->
    <div class="modal fade" id="authorizeTransferModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-info text-light">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <input type="hidden" name="autorizar_id" id="autorizar_id" value="{{$transfer->id}}">
                        <div class="col-12 text-center h5">¿Autorizar este traspaso?</div>
                        <div class="col-auto text-center">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">No, cancelar</button>
                        </div>
                        <div class="col-auto text-center">
                            <button type="button" class="btn btn-sm btn-primary" id="btnAuthorizeTransfer">Si, autorizar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal autorizar -->
    <div class="modal fade" id="recibirTransferModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-success text-light">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <input type="hidden" name="recibir_id" id="recibir_id" value="{{$transfer->id}}">
                        <div class="col-12 text-center h5">¿Recibir los articulos de este traspaso?</div>
                        <div class="col-auto text-center">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">No, cancelar</button>
                        </div>
                        <div class="col-auto text-center">
                            <button type="button" class="btn btn-sm btn-primary" id="btnRecibirTransfer">Si, recibir</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal autorizar -->
    <div class="modal fade" id="cancelTransferModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content bg-danger text-light">
                <div class="modal-body">
                    <div class="row justify-content-center">
                        <input type="hidden" name="cancel_id" id="cancel_id" value="{{$transfer->id}}">
                        <div class="col-12 text-center h5">¿Cancelar este traspaso?</div>
                        <div class="col-auto text-center">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">No, continuar</button>
                        </div>
                        <div class="col-auto text-center">
                            <button type="button" class="btn btn-sm btn-primary" id="btnCancelTransfer">Si, cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('js/transfer-detail.js') }}" defer></script>
@endpush
