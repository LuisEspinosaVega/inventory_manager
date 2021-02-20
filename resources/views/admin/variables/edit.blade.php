@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h4 text-center">Editar variable variable</div>
        <div class="row justify-content-center my-3">
            <div class="col-12 col-md-6 text-center mt-0 mt-md-3">
                <form action="{{ route('admin.variables.update', $variable->id) }}" method="post">
                    @csrf
                    @method('patch')

                    <div class="row form-group">
                        <label for="category_id"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Categoría de la
                                variable<span class="text-danger">*</span>:</b></label>
                        <div class="col-12 col-md-8">
                            <select name="category_id" id="category_id"
                                class="custom-select @error('category_id') is-invalid @enderror">
                                <option value="">Selecciona una opción...</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" @if ($category->id == $variable->category_id) selected @endif>{{ $category->name }}</option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="name" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Nombre de
                                la variable<span class="text-danger">*</span>:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Asigna un nombre a la variable" value="{{ old('name') ?? $variable->name }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="description"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Descripción de la
                                variable:</b></label>
                        <div class="col-12 col-md-8">
                            <textarea name="description" id="description" rows="2"
                                class="form-control @error('description') is-invalid @enderror">{{ old('description') ?? $variable->description }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row justify-content-center mt-4">
                        <div class="col-auto text-center">
                            <a href="{{ route('admin.variables') }}" class="btn btn-sm btn-secondary">Cancelar</a>
                        </div>
                        <div class="col-auto text-center">
                            <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
