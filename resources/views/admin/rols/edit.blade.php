@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h4 text-center">Editar rol</div>

        <div class="row justify-content-center my-3">
            <div class="col-12 col-md-9 text-center">
                <form action="{{ route('admin.rols.update',$rol->id) }}" method="post">
                    @csrf
                    @method('patch')

                    <div class="row form-group">
                        <label for="name" class="col-12 col-md-4 text-center text-md-right"><b>Nombre del rol</b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror" value="{{ old('name') ?? $rol->name }}"
                                placeholder="Asigna un nombre al rol">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="description" class="col-12 col-md-4 text-center text-md-right"><b>Descripción del
                                rol</b></label>
                        <div class="col-12 col-md-8">
                            <textarea name="description" id="description" rows="2"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Agrega una breve descripción">{{ old('description') ?? $rol->description }}</textarea>
                            @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="h3 text-center">Permisos</div>

                    <div class="row justify-content-center form-group">

                        <div class="col-6 text-center mt-1 border">
                            <div class="h5 text-center my-2">Inventarios</div>
                            <label for="main_inventory"><b>Acceder inventarios </b></label> <input type="checkbox" {{$rol->main_inventory == 1 ? "checked" : ""}}
                                name="main_inventory" id="main_inventory"> <br>
                            <label for="edit_inventory"><b>Administrar inventarios </b></label> <input type="checkbox" {{$rol->edit_inventory == 1 ? "checked" : ""}}
                                name="edit_inventory" id="edit_inventory">
                        </div>

                        <div class="col-6 text-center mt-1 border">
                            <div class="h5 text-center my-2">RH</div>
                            <label for="main_rh"><b>Acceder Rh </b></label> <input type="checkbox" name="main_rh" {{$rol->main_rh == 1 ? "checked" : ""}}
                                id="main_rh"> <br>
                            <label for="edit_rh"><b>Administrar Rh </b></label> <input type="checkbox" name="edit_rh"  {{$rol->edit_rh == 1 ? "checked" : ""}}
                                id="edit_rh">
                        </div>

                        <div class="col-6 text-center mt-1 border">
                            <div class="h5 text-center my-2">Finanzas</div>
                            <label for="main_finance"><b>Acceder Finanzas </b></label> <input type="checkbox" {{$rol->main_finance == 1 ? "checked" : ""}}
                                name="main_finance" id="main_finance"> <br>
                            <label for="edit_finance"><b>Administrar Finanzas </b></label> <input type="checkbox" {{$rol->edit_finance == 1 ? "checked" : ""}}
                                name="edit_finance" id="edit_finance">
                        </div>

                        <div class="col-6 text-center mt-1 border">
                            <div class="h5 text-center my-2">Social</div>
                            <label for="main_social"><b>Acceder Social </b></label> <input type="checkbox" {{$rol->main_social == 1 ? "checked" : ""}}
                                name="main_social" id="main_social"> <br>
                            <label for="edit_social"><b>Administrar Social </b></label> <input type="checkbox" {{$rol->edit_social == 1 ? "checked" : ""}}
                                name="edit_social" id="edit_social">
                        </div>
                    </div>

                    <div class="row form-group justify-content-center">
                        <div class="col-auto">
                            <a role="button" href="{{route('admin.rols')}}" class="btn btn-sm btn-secondary">Cancelar</a>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-sm btn-primary" id="btnCreate">Editar</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('js/rols.js') }}" defer></script>
@endpush
