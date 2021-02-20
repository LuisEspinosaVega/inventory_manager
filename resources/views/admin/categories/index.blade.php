@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h4 text-center">Lista de categorías</div>
        <div class="row justify-content-center justify-content-md-end mt-2">
            <div class="col-auto text-center mb-3">
                <a href="{{ route('admin.categories.create') }}" class="btn btn-sm btn-dark">Crear categoría</a>
            </div>
        </div>
        @foreach ($categories as $category)
            <div class="row justify-content-center form-group border p-2">
                <div class="col-10 col-md-4 text-center">
                    {{ $category->name }}
                </div>
                <div class="col-2 text-center">
                    <a role="button" href="{{ route('admin.categories.edit', $category->id) }}"
                        class="btn btn-sm btn-primary">Editar</a>
                </div>
            </div>
        @endforeach
    </div>
@endsection
