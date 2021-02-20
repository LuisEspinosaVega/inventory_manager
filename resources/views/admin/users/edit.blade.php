@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h4 text-center">Editar usuario <b>{{ $user->name }}</b></div>
        <div class="row justify-content-center my-3">
            <div class="col-12 col-md-6 text-center mt-0 mt-md-3">
                <form action="{{ route('admin.users.update', $user->id) }}" method="post">
                    @csrf
                    @method('patch')
                    <div class="row form-group">
                        <label for="name" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Nombre de
                                usuario:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Asigna un nombre de usuario" value="{{ old('name') ?? $user->name }}">
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
                                placeholder="Asigna un correo electrónico" value="{{ old('email') ?? $user->email }}">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="rol" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Rol de
                                usuario:</b></label>
                        <div class="col-12 col-md-8">
                            <select name="rol" id="rol" class="custom-select @error('rol') is-invalid @enderror">
                                <option value="">Selecciona un rol...</option>
                                @foreach ($rols as $rol)
                                    @php
                                        if ($rol->id == 1) {
                                            continue;
                                        }
                                    @endphp
                                    <option value="{{ $rol->id }}" @if ($rol->id == $user->profile->rol_id) selected @endif>{{ $rol->name }}</option>
                                @endforeach
                            </select>
                            @error('rol')
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
                                placeholder="Modificar contraseña">
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
                            <button type="submit" class="btn btn-sm btn-primary">Editar</button>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
