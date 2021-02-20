@extends('layouts.inventory')

@push('filter-required')
    <script src="{{ asset('js/datatable.js') }}" defer></script>
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container">
        <h4 class="text-center">Existencias</h4>


        <div class="row justify-content-center my-4">
            <div class="col-12 text-center table-responsive">
                <table class="table table-sm table-bordered table-striped table-hover" id="itemsTable">
                    <thead class="bg-dark text-light">
                        <tr>
                            <th class=" d-none d-sm-none d-md-table-cell">ID</th>
                            <th>N° Serie</th>
                            <th>Catalogo</th>
                            <th>Stock</th>
                            <th class=" d-none d-sm-none d-md-table-cell">Fecha de alta</th>
                            <th class=" d-none d-sm-none d-md-table-cell">Ultima actualización</th>
                            <th>Detalle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td class=" d-none d-sm-none d-md-table-cell">{{ $item->id }}</td>
                                <td>{{ $item->serial_number }}</td>
                                <td>{{ $item->catalog->name }}</td>
                                <td>{{ $item->stock }}</td>
                                <td class=" d-none d-sm-none d-md-table-cell">{{ $item->created_at }}</td>
                                <td class=" d-none d-sm-none d-md-table-cell">{{ $item->updated_at }}</td>
                                <td>
                                    <a role="button" href="{{ route('item.details', $item->id) }}" class="btn btn-sm btn-primary">Ir ⇗</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-12 text-center">
                {{ $items->links() }}
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('js/item/item-index.js') }}" defer></script>
@endpush
