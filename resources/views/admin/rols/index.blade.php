@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h4 text-center">Lista de roles</div>
        <div class="row justify-content-center justify-content-md-end mt-2">
            <div class="col-auto text-center mb-3">
                <a href="{{ route('admin.rols.create') }}" class="btn btn-sm btn-dark">Crear rol</a>
            </div>
        </div>

        <div class="row justify-content-center my-3">
            <div class="col-12 col-md-7 text-center">
                <table class="table table-bordered table-sm table-dark">
                    <thead>
                        <tr>
                            <th class="align-middle p-2 text-center">Nombre</th>
                            <th class="align-middle p-2 text-center d-none d-sm-none d-md-table-cell">Descripción</th>
                            <th class="align-middle p-2 text-center">Editar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($rols as $rol)
                            <tr>
                                <td class="align-middle p-1">{{$rol->name}}</td>
                                <td class="align-middle p-1 d-none d-sm-none d-md-table-cell">{{$rol->description}}</td>
                                @if ($rol->id == 1 || $rol->id == 2)
                                <td class="align-middle p-1">
                                    <a href="#" class="btn btn-sm btn-secondary disabled">❌</a>
                                </td>
                                @else
                                <td class="align-middle p-1">
                                    <a href="{{route('admin.rols.edit',$rol->id)}}" class="btn btn-sm btn-primary">Editar</a>
                                </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
