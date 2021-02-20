@extends('layouts.inventory')

@push('filter-required')
    <script src="{{ asset('js/datatable.js') }}" defer></script>
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container">
        <h4 class="text-center">Salidas registradas</h4>

        <div class="row justify-content-center justify-content-md-end">
            <div class="col-auto">
                @if (Auth::user()->can('edit_inventory'))
                    <a role="button" href="{{ route('outlet.create') }}" class="btn btn-sm btn-dark">Generar salida de
                        artículos <span class="text-primary align-middle" style="font-size: 17px;">+</span></a>
                @else
                    <button type="button" class="btn btn-sm btn-dark" disabled>❌</button>
                @endif
            </div>
        </div>

        <div class="row justify-content-center my-4">
            <div class="col-12 text-center table-responsitve">
                <table class="table table-sm table-bordered table-hover table-striped" id="outletsTable">
                    <thead class="bg-dark text-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Sucursal</th>
                            <th class=" d-none d-sm-none d-md-table-cell">Encargado</th>
                            <th class=" d-none d-sm-none d-md-table-cell">Usuario de sistema</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($outlets as $outlet)
                            <tr>
                                <td>{{ $outlet->created_at }}</td>
                                <td>{{ $outlet->office->name }}</td>
                                <td class=" d-none d-sm-none d-md-table-cell">{{ $outlet->mandated }}</td>
                                <td class=" d-none d-sm-none d-md-table-cell">{{ $outlet->user->name }}</td>
                                <td>
                                    <a role="button" href="{{ route('outlet.detail', $outlet->id) }}"
                                        class="btn btn-sm btn-primary">Ir ⇗</button>
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
    <script src="{{ asset('js/outlet-index.js') }}" defer></script>
@endpush
