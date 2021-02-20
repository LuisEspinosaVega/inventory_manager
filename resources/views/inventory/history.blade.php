@extends('layouts.inventory')

@push('filter-required')
    <script src="{{ asset('js/datatable.js') }}" defer></script>
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container">
        <div class="h4 text-center">Historial de movimientos</div>

        <div class="row justify-content-center my-4">
            <div class="col-12 text-center table-responsive">
                <table class="table-sm table-bordered table-striped" id="historyTable">
                    <thead class="bg-dark text-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Tipo</th>
                            <th>Articulo</th>
                            <th>N° Serie</th>
                            <th>Cantidad</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{ $log->created_at }}</td>
                                <td>{{ $log->type }}</td>
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
@endsection

@push('custom-scripts')
    <script src="{{ asset('js/history.js') }}" defer></script>
@endpush
