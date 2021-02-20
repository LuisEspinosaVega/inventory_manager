@extends('layouts.inventory')

@push('filter-required')
    <script src="{{ asset('js/datatable.js') }}" defer></script>
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container">
        <div class="h4 text-center">Catalogo de inventario</div>
        <div class="row justify-content-center justify-content-md-end my-3">
            @if (Auth::user()->can('edit_inventory'))
                <a role="button" href="{{ route('inventory.catalog.create') }}" class="btn btn-sm btn-dark">Dar de alta
                    articulo en catalogo <span class="text-primary align-middle" style="font-size: 17px;">+</span></a>
            @else
                <button type="button" class="btn btn-sm btn-dark" disabled>❌</button>
            @endif
        </div>

        @if (session('success'))
            <div class="row justify-content-center mb-3">
                <div class="col-10 text-center">
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <strong>{{session('success')}}</strong>
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            </div>
        @endif

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

        <div class="row justify-content-center">
            {{-- filtros --}}
            <div class="col-6 col-md-3 text-center">
                <input type="text" name="search_name" id="search_name" class="form-control form-control-sm keys"
                    placeholder="Filtrar por nombre">
            </div>
            <div class="col-6 col-md-3 text-center">
                <input type="text" name="search_sku" id="search_sku" class="form-control form-control-sm keys"
                    placeholder="Filtrar por SKU">
            </div>
            <div class="col-6 col-md-3 text-center">
                <select name="search_category" id="search_category" class="custom-select custom-select-sm selects">
                    <option value="">Filtrar por categoria...</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-6 col-md-3 text-center">
                <select name="search_sub_category" id="search_sub_category" class="custom-select custom-select-sm selects">
                    <option value="">Filtrar por sub categoria...</option>
                    @foreach ($subCategories as $csubCategory)
                        <option value="{{ $csubCategory->id }}">{{ $csubCategory->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Mostrar tabla, lo unico que se actualizara sera el tbody --}}
        <div class="row justify-content-center mt-3">
            <div class="col-12 text-center table-responsive rounded">
                <table class="table table-sm table-bordered table-hover" id="catalogTable" style="width:100%">
                    <thead class="bg-dark text-light">
                        <tr>
                            <th>Nombre</th>
                            <th>SKU</th>
                            <th class=" d-none d-sm-none d-md-table-cell">Descripción</th>
                            <th class=" d-none d-sm-none d-md-table-cell">Stock</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody id="tableBody">

                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection

@push('custom-scripts')
    <script src="{{ asset('js/catalog-list.js') }}" defer></script>
@endpush
