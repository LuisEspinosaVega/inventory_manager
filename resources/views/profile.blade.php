@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="h4 text-center">Editar mi perfil</div>

        <div class="alert alert-warning alert-dismissible fade show text-center" role="alert">
            <b>Para cambiar tu correo electrónico debes solicitarlo al administrador.</b>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="row justify-content-center my-3">
            <div class="col-12 col-md-4 text-center">
                @if ($user->profile->image)
                    <img src="{{ asset('storage/' . $user->profile->image) }}" alt="" class="img-fluid rounded-circle">
                @else
                    <img src="{{ asset('storage/profiles/no-image-profile.svg') }}" alt="" class="img-fluid">
                @endif
            </div>
            <div class="col-12 col-md-8">
                <form action="{{ route('profile.update') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div class="row form-group">
                        <div class="col-12 col-md-4 text-center text-md-right"><b>Username:</b></div>
                        <div class="col-12 col-md-8 text-center text-md-left h5"><b>{{ $user->name }}</b></div>
                    </div>
                    <div class="row form-group">
                        <div class="col-12 col-md-4 text-center text-md-right"><b>Email:</b></div>
                        <div class="col-12 col-md-8 text-center text-md-left h5"><b>{{ $user->email }}</b></div>
                    </div>
                    <div class="row form-group">
                        <label for="first_name"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Nombre:</b></label>
                        <div class="col-12 col-md-8 text-center text-md-left h5">
                            <input type="text" name="first_name" id="first_name"
                                class="form-control @error('first_name') is-invalid @enderror"
                                placeholder="Ingresa tus nombres"
                                value="{{ old('first_name') ?? $user->profile->first_name }}">
                            @error('first_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="last_name"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Apellido:</b></label>
                        <div class="col-12 col-md-8 text-center text-md-left h5">
                            <input type="text" name="last_name" id="last_name"
                                class="form-control @error('last_name') is-invalid @enderror"
                                placeholder="Ingresa tus apellidos"
                                value="{{ old('last_name') ?? $user->profile->last_name }}">
                            @error('last_name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="phone"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Telefono:</b></label>
                        <div class="col-12 col-md-8 text-center text-md-left h5">
                            <input type="number" name="phone" id="phone"
                                class="form-control @error('phone') is-invalid @enderror" placeholder="10 digitos"
                                value="{{ old('phone') ?? $user->profile->phone }}">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="password"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Contraseña:</b></label>
                        <div class="col-12 col-md-8 text-center text-md-left h5">
                            <input type="password" name="password" id="password"
                                class="form-control @error('password') is-invalid @enderror" placeholder="Nueva contraseña">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row form-group">
                        <label for="image" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Foto de
                                perfil:</b></label>
                        <div class="col-12 col-md-8 text-center text-md-left h5">
                            <input type="file" name="image" id="image" accept="image/*" style="overflow: hidden;">
                            @if ($errors->has('image'))
                                <div class="col-12 text-center text-danger"><b>{{ $errors->first('image') }}</b></div>
                            @endif
                        </div>
                    </div>

                    <div class="row justify-content-center form-group">
                        {{-- <div class="col-4"></div> --}}
                        <div class="col-auto">
                            <a role="button" href="{{ route('home') }}" class="btn btn-secondary btn-sm">Cancelar</a>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
            <b>{{session('success')}}</b>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif
    </div>
@endsection
