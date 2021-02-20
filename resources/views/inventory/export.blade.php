@extends('layouts.inventory')

@section('content')
    <div class="container">
        <div class="h4 text-center">Exportar datos a archivo CSV.</div>

        <div class="row justify-content-center my-3">
            <div class="col-12 text-center py-2 border" style="background-color: rgba(161, 151, 255, 0.582)">
                <div class="h5 text-center">Exportar catalogo <b class="text-danger"><span id="catalog_count"></span>
                        registros</b></div>
                <form action="{{ route('export.data') }}" method="post" id="exportCatalogForm">
                    @csrf
                    <input type="hidden" name="typeRequest" id="typeRequest" value="exportCatalog">
                    <div class="row justify-content-between">
                        <div class="col-6 col-md-2" style="overflow: hidden">
                            <select name="catalog_family" id="catalog_family"
                                class="custom-select custom-select-sm catalog-select">
                                <option value="">Buscar por familia...</option>
                                @foreach ($families as $family)
                                    <option value="{{ $family->id }}">{{ $family->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-2" style="overflow: hidden">
                            <select name="catalog_group" id="catalog_group"
                                class="custom-select custom-select-sm catalog-select">
                                <option value="">Buscar por grupo...</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}">{{ $group->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-2" style="overflow: hidden">
                            <select name="catalog_color_primary" id="catalog_color_primary"
                                class="custom-select custom-select-sm catalog-select">
                                <option value="">Buscar por color primario...</option>
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-2" style="overflow: hidden">
                            <select name="catalog_category" id="catalog_category"
                                class="custom-select custom-select-sm catalog-select">
                                <option value="">Buscar por categoria...</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-md-2" style="overflow: hidden">
                            <input type="text" name="catalog_name" id="catalog_name"
                                class="form-control form-control-sm catalog-text" placeholder="Buscar por nombre corto">
                        </div>
                        <div class="col-6 col-md-2" style="overflow: hidden">
                            <button type="submit" class="btn btn-sm btn-dark" id="btnExportCatalog">Export</button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- export items --}}
            <div class="col-12 text-center py-2 border mt-5" style="background-color: rgba(255, 210, 151, 0.582)">
                <div class="h5 text-center">Exportar articulos <b class="text-danger"><span id="item_count"></span>
                        registros</b></div>
                <form action="{{ route('export.data') }}" method="post" id="exportItemForm">
                    @csrf
                    <input type="hidden" name="typeRequest" id="typeRequest" value="exportItem">
                    <div class="row justify-content-between">

                        <div class="col-6 col-md-3" style="overflow: hidden">
                            <select name="item_catalog" id="item_catalog"
                                class="custom-select custom-select-sm item-select">
                                <option value="">Buscar por catalogo...</option>
                                @foreach ($catalogs as $catalog)
                                    <option value="{{ $catalog->id }}">{{ $catalog->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        
                        <div class="col-6 col-md-3" style="overflow: hidden">
                            <input type="text" name="item_serie" id="item_serie"
                                class="form-control form-control-sm item-text" placeholder="Buscar por numero de serie">
                        </div>
                        <div class="col-12 col-md-2 text-center" style="overflow: hidden">
                            <button type="submit" class="btn btn-sm btn-dark" id="btnExportItem">Export</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('js/export.js') }}" defer></script>
@endpush
