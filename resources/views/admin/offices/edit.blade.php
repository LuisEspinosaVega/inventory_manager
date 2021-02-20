@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h4 text-center">Editar sucursal {{ $office->name }}</div>

        <div class="row justify-content-center my-3">
            <div class="col-12 col-md-8 text-center">
                <form action="{{ route('admin.offices.update', $office->id) }}" method="post">
                    @csrf
                    @method('patch')
                    <div class="row form-group">
                        <label for="name"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Nombre:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') ?? $office->name }}" placeholder="Ingresa el nombre de la sucursal">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="contact"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Contacto:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="contact" id="contact"
                                class="form-control @error('contact') is-invalid @enderror"
                                value="{{ old('contact') ?? $office->contact }}"
                                placeholder="Ingresa un nombrepara contactar">
                            @error('contact')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="phone"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Telefono:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="number" name="phone" id="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone') ?? $office->phone }}" placeholder="10 digitos">
                            @error('phone')
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
                                value="{{ old('email') ?? $office->email }}" placeholder="Ingresa un correo electrónico">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="country"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>País:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="country" id="country"
                                class="form-control @error('country') is-invalid @enderror"
                                value="{{ old('country') ?? $office->country }}" placeholder="Ingresa el país">
                            @error('country')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="city"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Ciudad:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="city" id="city"
                                class="form-control @error('city') is-invalid @enderror"
                                value="{{ old('city') ?? $office->city }}" placeholder="Ingresa la ciudad">
                            @error('city')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="address"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Dirección:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="address" id="address"
                                class="form-control @error('address') is-invalid @enderror"
                                value="{{ old('address') ?? $office->address }}" placeholder="Ingresa la dirección">
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="cp" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Codigo
                                postal:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="cp" id="cp" class="form-control @error('cp') is-invalid @enderror"
                                value="{{ old('cp') ?? $office->cp }}" placeholder="Ingresa el código postal">
                            @error('cp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row justify-content-center form-group">
                        <div class="col-auto">
                            <a role="button" href="{{ route('admin.offices') }}"
                                class="btn btn-sm btn-secondary">Cancelar</a>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-sm btn-primary">Actualizar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
