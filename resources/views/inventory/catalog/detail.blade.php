@extends('layouts.inventory')

@push('filter-required')
    <script src="{{ asset('js/datatable.js') }}" defer></script>
    <link href="{{ asset('css/datatable.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container">
        <div class="h4 text-center">Detalles <b>{{ $catalog->name }}</b></div>
        <div class="row justify-content-center my-4">
            <div class="col-12 col-md-4">
                @if ($catalog->image)
                    <img src="{{ asset('storage/' . $catalog->image) }}" class="img-fluid" alt="Catalogo image">
                @else
                    <img src="{{ asset('storage/catalog/no-image-catalog.svg') }}" class="img-fluid" alt="Catalogo image">
                @endif
            </div>
            <div class="col-12 col-md-8 mt-3 mt-md-0">
                <div class="row form-group h5">
                    <label for="name" class="col-12 col-md-4 text-center text-md-right"><b>Nombre corto:</b></label>
                    <div class="col-12 col-md-8 text-center text-md-left">
                        <b>{{ $catalog->name }}</b>
                    </div>
                </div>
                <div class="row form-group h5">
                    <label for="brand" class="col-12 col-md-4 text-center text-md-right"><b>Marca:</b></label>
                    <div class="col-12 col-md-8 text-center text-md-left">
                        <b>{{ $catalog->brand }}</b>
                    </div>
                </div>
                <div class="row form-group h5">
                    <label for="model" class="col-12 col-md-4 text-center text-md-right"><b>Modelo:</b></label>
                    <div class="col-12 col-md-8 text-center text-md-left">
                        <b>{{ $catalog->model }}</b>
                    </div>
                </div>
                <div class="row form-group h5">
                    <label for="sku" class="col-12 col-md-4 text-center text-md-right"><b>SKU:</b></label>
                    <div class="col-12 col-md-8 text-center text-md-left">
                        <b>{{ $catalog->sku }}</b>
                    </div>
                </div>

                <div class="row form-group h5">
                    <label for="sku" class="col-12 col-md-4 text-center text-md-right"><b>ARTICULOS:</b></label>
                    <div class="col-12 col-md-8 text-center text-md-left">
                        <b>{{ $catalog->items()->count() }}</b>
                    </div>
                </div>

                <div class="row form-group h5">
                    <label for="description" class="col-12 col-md-4 text-center text-md-right"><b>Descripción:</b></label>
                    <div class="col-12 col-md-8 text-center text-md-left">
                        <b>{{ $catalog->description }}</b>
                    </div>
                </div>
                <div class="row form-group h5">
                    <label for="category" class="col-12 col-md-4 text-center text-md-right"><b>Categoría:</b></label>
                    <div class="col-12 col-md-8 text-center text-md-left">
                        @foreach ($categories as $category)
                            @if ($category->id == $catalog->category)
                                <b>{{ $category->name }}</b>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="row form-group h5">
                    <label for="sub_category" class="col-12 col-md-4 text-center text-md-right"><b>Sub
                            categoría:</b></label>
                    <div class="col-12 col-md-8 text-center text-md-left">
                        @foreach ($subCategories as $subCategory)
                            @if ($subCategory->id == $catalog->sub_category)
                                <b>{{ $subCategory->name }}</b>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="row form-group h5">
                    <label for="group" class="col-12 col-md-4 text-center text-md-right"><b>Grupo:</b></label>
                    <div class="col-12 col-md-8 text-center text-md-left">
                        @foreach ($groups as $group)
                            @if ($group->id == $catalog->group)
                                <b>{{ $group->name }}</b>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="row form-group h5">
                    <label for="family" class="col-12 col-md-4 text-center text-md-right"><b>Familia:</b></label>
                    <div class="col-12 col-md-8 text-center text-md-left">
                        @foreach ($families as $family)
                            @if ($family->id == $catalog->family)
                                <b>{{ $family->name }}</b>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="row form-group h5">
                    <label for="color_primary" class="col-12 col-md-4 text-center text-md-right"><b>Color
                            primario:</b></label>
                    <div class="col-12 col-md-8 text-center text-md-left">
                        @foreach ($colors as $color)
                            @if ($color->id == $catalog->color_primary)
                                <b>{{ $color->name }}</b>
                            @endif
                        @endforeach
                    </div>
                </div>
                <div class="row form-group h5">
                    <label for="color_secondary" class="col-12 col-md-4 text-center text-md-right"><b>Color
                            secundario:</b></label>
                    <div class="col-12 col-md-8 text-center text-md-left">
                        @foreach ($colors as $color)
                            @if ($color->id == $catalog->color_secondary)
                                <b>{{ $color->name }}</b>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="row form-group justify-content-center justify-content-md-end">
                    <div class="col-auto text-center">
                        <a role="button" href="{{ route('inventory.catalog') }}"
                            class="btn btn-sm btn-secondary">Regresar</a>
                    </div>
                    <div class="col-auto text-center">
                        @if (Auth::user()->can('edit_inventory'))
                            <a role="button" href="{{ route('inventory.catalog.edit', $catalog->id) }}"
                                class="btn btn-sm btn-primary">Editar</a>
                        @else
                            <button type="button" class="btn btn-sm btn-dark" disabled>Editar</button>
                        @endif

                    </div>
                    <div class="col-auto text-center">
                        @if ($catalog->items()->count() || !Auth::user()->can('edit_inventory'))
                            <button type="button" class="btn btn-sm btn-dark" disabled>Eliminar</button>
                        @else
                            <button type="button" class="btn btn-sm btn-danger" data-idcatalog="{{ $catalog->id }}"
                                data-toggle="modal" data-target="#deleteCatalogModal">Eliminar</button>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        {{-- Lista de los items que derivan de este catalogo --}}
        <div class="h4 text-center">Artículos del catálogo</div>
        <div class="row justify-content-center mt-3">
            <div class="col-12 col-md-10 text-center table-responsive">
                <table class="table table-sm table-striped table-bordered table-hover" id="catalogDetailTable">
                    <thead class="bg-dark text-light">
                        <tr>
                            <th>ID</th>
                            <th>N° serie</th>
                            <th>Stock</th>
                            <th>Detalles</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $item->id }}</td>
                                <td>{{ $item->serial_number }}</td>
                                <td>{{ $item->stock }}</td>
                                <td>
                                    <a href="{{ route('item.details', $item->id) }}" class="btn btn-sm btn-primary">Ir
                                        ⇗</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteCatalogModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body bg-dark">
                    <form action="{{ route('inventory.catalog.destroy') }}" method="post" id="deleteCatalogForm">
                        @csrf
                        <div class="row justify-content-center p-1">
                            <input type="hidden" name="id_catalog" id="id_catalog">
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
    <script src="{{ asset('js/inventory.js') }}" defer></script>
@endpush
