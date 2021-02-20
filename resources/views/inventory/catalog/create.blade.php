@extends('layouts.inventory')

@section('content')
    <div class="container">
        <h4 class="text-center">Dar de alta producto al catalogo</h4>
        <div class="row justify-content-center my-3">
            <div class="col-12 col-md-8 text-center">
                <form action="{{ route('inventory.catalog.store') }}" method="post" class="formCreate"
                    enctype="multipart/form-data">
                    @csrf

                    <div class="row form-group">
                        <label for="name" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Nombre corto <span class="text-danger">*</span> </b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="name" id="name"
                                class="@error('name') is-invalid @enderror form-control"
                                placeholder="Ingresa el nombre corto del producto" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="brand" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Marca</b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="brand" id="brand"
                                class="@error('brand') is-invalid @enderror form-control"
                                placeholder="Ingresa la marca del producto" value="{{ old('brand') }}">
                            @error('brand')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="model" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Modelo <span class="text-danger">*</span> </b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="model" id="model"
                                class="@error('model') is-invalid @enderror form-control"
                                placeholder="Ingresa el modelo del producto" value="{{ old('model') }}">
                            @error('model')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="description"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Descripción <span class="text-danger">*</span> </b></label>
                        <div class="col-12 col-md-8">
                            <textarea name="description" id="description" rows="2"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Ingresa una descripción general del producto">{{ old('description') }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="category"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Categoría <span class="text-danger">*</span> </b></label>
                        <div class="col-12 col-md-8">
                            <select name="category" id="category"
                                class="custom-select @error('category') is-invalid @enderror">
                                <option value="">Selecciona una categoría...</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if ($category->id == old('category')) selected @endif>
                                        {{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="sub_category" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Sub
                                categoría</b></label>
                        <div class="col-12 col-md-8">
                            <select name="sub_category" id="sub_category"
                                class="custom-select @error('sub_category') is-invalid @enderror">
                                <option value="">Selecciona una sub categoría...</option>
                                @foreach ($subCategories as $subCategory)
                                    <option value="{{ $subCategory->id }}" @if ($subCategory->id == old('sub_category')) selected @endif>
                                        {{ $subCategory->name }}</option>
                                @endforeach
                            </select>
                            @error('sub_category')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="group" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Grupo</b></label>
                        <div class="col-12 col-md-8">
                            <select name="group" id="group"
                                class="custom-select @error('group') is-invalid @enderror">
                                <option value="">Selecciona un grupo...</option>
                                @foreach ($groups as $group)
                                    <option value="{{ $group->id }}" @if ($group->id == old('group')) selected @endif>
                                        {{ $group->name }}</option>
                                @endforeach
                            </select>
                            @error('group')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="family" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Familia</b></label>
                        <div class="col-12 col-md-8">
                            <select name="family" id="family"
                                class="custom-select @error('family') is-invalid @enderror">
                                <option value="">Selecciona una familia...</option>
                                @foreach ($families as $family)
                                    <option value="{{ $family->id }}" @if ($family->id == old('family')) selected @endif>
                                        {{ $family->name }}</option>
                                @endforeach
                            </select>
                            @error('family')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="color_primary" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Color primario <span class="text-danger">*</span> </b></label>
                        <div class="col-12 col-md-8">
                            <select name="color_primary" id="color_primary"
                                class="custom-select @error('color_primary') is-invalid @enderror">
                                <option value="">Selecciona un color...</option>
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}" @if ($color->id == old('color_primary')) selected @endif>
                                        {{ $color->name }}</option>
                                @endforeach
                            </select>
                            @error('color_primary')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="color_secondary" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Color secundario</b></label>
                        <div class="col-12 col-md-8">
                            <select name="color_secondary" id="color_secondary"
                                class="custom-select @error('color_secondary') is-invalid @enderror">
                                <option value="">Selecciona un color...</option>
                                @foreach ($colors as $color)
                                    <option value="{{ $color->id }}" @if ($color->id == old('color_secondary')) selected @endif>
                                        {{ $color->name }}</option>
                                @endforeach
                            </select>
                            @error('color_secondary')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="image"
                            class="col-12 col-md-4 text-center text-md-right align-self-center align-self-center"><b>Imagen
                                para catalogo:</b></label>
                        <div class="col-12 col-md-8 text-center text-md-left">
                            <input type="file" name="image" id="image" accept="image/*" style="overflow: hidden;">
                            @if ($errors->has('image'))
                                <div class="col-12 text-center text-danger"><b>{{ $errors->first('image') }}</b></div>
                            @endif
                        </div>
                    </div>

                    <div class="row form-group justify-content-center my-3">
                        <div class="col-auto">
                            <a role="button" href="{{ route('inventory.catalog') }}"
                                class="btn btn-sm btn-secondary">Cancelar</a>
                        </div>
                        <div class="col-auto">
                            @if (Auth::user()->can('edit_inventory'))
                                <button type="submit" class="btn btn-sm btn-primary" id="btnCreate">Aceptar</button>
                            @else
                                <button type="button" class="btn btn-sm btn-dark" disabled>Aceptar</button>
                            @endif

                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('js/inventory.js') }}" defer></script>
@endpush
