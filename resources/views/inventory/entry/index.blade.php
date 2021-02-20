@extends('layouts.inventory')

@push('filter-required')
    <script src="{{ asset('js/datatable.js') }}" defer></script>
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container">
        <h4 class="text-center">Ingresos registrados</h4>

        <div class="row justify-content-center justify-content-md-end">
            <div class="col-auto">
                @if (Auth::user()->can('edit_inventory'))
                <a role="button" href="{{ route('entry.create') }}" class="btn btn-sm btn-dark">Generar ingreso de
                    artículos <span class="text-primary align-middle" style="font-size: 17px;">+</span></a>
                @else
                    <button type="button" class="btn btn-sm btn-dark" disabled>❌</button>
                @endif
            </div>
        </div>

        <div class="row justify-content-center my-3">
            <div class="col-12">
                {{-- Filtros --}}

            </div>

            {{-- tablita xd --}}
            <div class="col-12 text-center table-responsive">
                <table class="table table-sm table-bordered table-striped" id="entriesTable">
                    <thead class="bg-dark text-light">
                        <tr>
                            <th>Fecha</th>
                            <th>Sucursal</th>
                            <th class=" d-none d-sm-none d-md-table-cell">Proveedor</th>
                            <th class=" d-none d-sm-none d-md-table-cell">Encargado</th>
                            <th class=" d-none d-sm-none d-md-table-cell">Usuario de sistema</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($entries as $entry)
                            <tr>
                                <td>{{ $entry->created_at }}</td>
                                <td>{{ $entry->office->name }}</td>
                                <td class=" d-none d-sm-none d-md-table-cell">{{ $entry->provider->name }}</td>
                                <td class=" d-none d-sm-none d-md-table-cell">{{ $entry->mandated }}</td>
                                <td class=" d-none d-sm-none d-md-table-cell">{{ $entry->user->name }}</td>
                                <td>
                                    <a role="button" href="{{ route('entry.detail', $entry->id) }}"
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
    <script src="{{ asset('js/entry-index.js') }}" defer></script>
@endpush
