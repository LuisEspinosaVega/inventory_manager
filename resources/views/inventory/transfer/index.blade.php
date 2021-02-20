@extends('layouts.inventory')

@push('filter-required')
    <script src="{{ asset('js/datatable.js') }}" defer></script>
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container">
        <div class="h4 text-center">Traspasos registrados</div>

        <div class="row justify-content-center justify-content-md-end">
            <div class="col-auto">
                @if (Auth::user()->can('edit_inventory'))
                    <a role="button" href="{{ route('transfer.create') }}" class="btn btn-sm btn-dark">Generar traspaso de
                        artículos <span class="text-primary align-middle" style="font-size: 17px;">+</span></a>
                @else
                    <button type="button" class="btn btn-sm btn-dark" disabled>❌</button>
                @endif
            </div>
        </div>

        <div class="row justify-content-center my-4">
            <div class="col-12 text-center table-responsive">
                <table class="table table-sm table-hover table-bordered table-striped" id="transferTable">
                    <thead class="bg-dark text-light">
                        <tr>
                            <th class=" d-none d-sm-none d-md-table-cell align-self-center">Fecha solicitud</th>
                            <th class=" d-none d-sm-none d-md-table-cell align-self-center">Última modificación</th>
                            <th>Sucursal orígen</th>
                            <th class=" d-none d-sm-none d-md-table-cell align-self-center">Encargado</th>
                            <th class=" d-none d-sm-none d-md-table-cell align-self-center">Solicitante</th>
                            <th class=" d-none d-sm-none d-md-table-cell align-self-center">Autoriza</th>
                            <th class=" d-none d-sm-none d-md-table-cell align-self-center">Recibe</th>
                            <th class=" d-none d-sm-none d-md-table-cell align-self-center">Estatus</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transfers as $transfer)
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
                            <tr>
                                <td class=" d-none d-sm-none d-md-table-cell align-self-center">{{ $transfer->created_at }}
                                </td>
                                <td class=" d-none d-sm-none d-md-table-cell align-self-center">{{ $transfer->updated_at }}
                                </td>
                                <td>{{ $transfer->office->name }}</td>
                                <td class=" d-none d-sm-none d-md-table-cell align-self-center">{{ $transfer->mandated }}
                                </td>
                                <td class=" d-none d-sm-none d-md-table-cell align-self-center">{{ $transfer->applicant }}
                                </td>
                                <td class=" d-none d-sm-none d-md-table-cell align-self-center">
                                    {{ $transfer->authorizes ?? '' }}</td>
                                <td class=" d-none d-sm-none d-md-table-cell align-self-center">
                                    {{ $transfer->receive ?? '' }}</td>
                                <td class=" d-none d-sm-none d-md-table-cell align-self-center {{ $text }}">
                                    {{ $transfer->status }}</td>
                                <td>
                                    <a role="button" href="{{ route('transfer.detail', $transfer->id) }}"
                                        class="btn btn-sm btn-primary">Ir ⇗</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('js/transfer-index.js') }}" defer></script>
@endpush
