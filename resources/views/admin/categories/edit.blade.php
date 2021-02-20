@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h4 text-center">Editar categoría</div>
        <div class="row justify-content-center my-3">
            <div class="col-12 col-md-6 text-center mt-0 mt-md-3">
                <form action="{{ route('admin.categories.update', $category->id) }}" method="post">
                    @csrf
                    @method('patch')
                    <div class="row form-group">
                        <label for="name" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Nombre de
                                la categoría:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Asigna un nombre de usuario" value="{{ old('name') ?? $category->name }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row justify-content-center mt-4">
                        <div class="col-auto text-center">
                            <a href="{{ route('admin.users') }}" class="btn btn-sm btn-secondary">Cancelar</a>
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
