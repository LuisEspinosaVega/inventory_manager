@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h4 text-center">Crear un nuevo usuario</div>
        <div class="row justify-content-center my-3">
            <div class="col-12 col-md-6 text-center mt-0 mt-md-3">
                <form action="{{ route('admin.users.store') }}" method="post" class="formCreate">
                    @csrf

                    <div class="row form-group">
                        <label for="name" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Nombre de
                                usuario:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Asigna un nombre de usuario" value="{{ old('name') }}">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="email" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Correo
                                electrónico:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="Asigna un correo electrónico" value="{{ old('email') }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="password"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Contraseña:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror"
                                placeholder="Asigna una contraseña temporal">
                            @error('password')
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
                            <button type="submit" class="btn btn-sm btn-primary" id="btnCreate">Crear</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('js/admin.js') }}" defer></script>
@endpush
