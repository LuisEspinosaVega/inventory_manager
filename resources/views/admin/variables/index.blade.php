@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h4 text-center">Lista de variables</div>
        <div class="row justify-content-center justify-content-md-end mt-2">
            <div class="col-auto text-center mb-3">
                <a href="{{ route('admin.variables.create') }}" class="btn btn-sm btn-dark">Crear variable</a>
            </div>
        </div>
        <div class="row justify-content-center my-3">
            @foreach ($categories as $category)
                <div class="col-6 col-md-3 text-center my-1 p-2">
                    <div class="card">
                        <div class="card-header text-center bg-dark text-light p-1">{{ $category->name }}</div>
                        <div class="card-body text-center bg-light">
                            @foreach ($variables as $var)
                                @if ($var->category_id == $category->id)
                                    <div class="row justify-content-center mt-1">
                                        <div class="col-8 text-center align-self-center">
                                            {{ $var->name }}
                                        </div>
                                        <div class="col-4 text-center align-self-center">
                                            <a href="{{ route('admin.variables.edit', $var->id) }}"
                                                class="btn btn-sm btn-primary">Editar</a>
                                        </div>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
