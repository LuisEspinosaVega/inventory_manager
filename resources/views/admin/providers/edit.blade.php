@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h4 text-center">Editar proveedor {{ $provider->name }}</div>

        <div class="row justify-content-center my-3">
            <div class="col-12 col-md-4">
                @if ($provider->image)
                    <img src="{{ asset('storage/' . $provider->image) }}" class="img-fluid" alt="">
                @else
                    <img src="{{ asset('storage/providers/no-image-provider.svg') }}" class="img-fluid" alt="">
                @endif
            </div>
            <div class="col-12 col-md-8 text-center">
                <form action="{{ route('admin.providers.update', $provider->id) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('patch')

                    <div class="row form-group">
                        <label for="name" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Nombre<span
                                    class="text-danger">*</span>:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="name" id="name"
                                class="form-control @error('name') is-invalid @enderror"
                                value="{{ old('name') ?? $provider->name }}"
                                placeholder="Ingresa el nombre del proveedor">
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="type" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Tipo
                                proveedor<span class="text-danger">*</span>:</b></label>
                        <div class="col-12 col-md-8">
                            <select name="type" id="type" class="custom-select @error('type') is-invalid @enderror">
                                <option value="">Selecciona una opción...</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}" @if ($type->id == $provider->type) selected @endif>
                                        {{ $type->name }}</option>
                                @endforeach
                            </select>
                            @error('type')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="bank"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Banco:</b></label>
                        <div class="col-12 col-md-8">
                            <select name="bank" id="bank" class="custom-select @error('bank') is-invalid @enderror">
                                <option value="">Selecciona una opción...</option>
                                @foreach ($banks as $bank)
                                    <option value="{{ $bank->id }}" @if ($bank->id == $provider->bank) selected @endif>
                                        {{ $bank->name }}</option>
                                @endforeach
                            </select>
                            @error('bank')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="account"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Cuenta:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="account" id="account"
                                class="form-control @error('account') is-invalid @enderror"
                                value="{{ old('account') ?? $provider->account }}"
                                placeholder="Ingresa el numero de cuenta">
                            @error('account')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="clabe"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>CLABE:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="clabe" id="clabe"
                                class="form-control @error('clabe') is-invalid @enderror"
                                value="{{ old('clabe') ?? $provider->clabe }}" placeholder="Ingresa el numero de clabe">
                            @error('clabe')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="rfc"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>RFC:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="rfc" id="rfc" class="form-control @error('rfc') is-invalid @enderror"
                                value="{{ old('rfc') ?? $provider->rfc }}" placeholder="Ingresa el RFC">
                            @error('rfc')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="reazon" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Razón
                                social:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="reazon" id="reazon"
                                class="form-control @error('reazon') is-invalid @enderror"
                                value="{{ old('reazon') ?? $provider->reazon }}" placeholder="Ingresa la razón social">
                            @error('reazon')
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
                                value="{{ old('country') ?? $provider->country }}" placeholder="Ingresa el país">
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
                                value="{{ old('city') ?? $provider->city }}" placeholder="Ingresa la ciudad">
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
                                value="{{ old('address') ?? $provider->address }}" placeholder="Ingresa la dirección">
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
                                value="{{ old('cp') ?? $provider->cp }}" placeholder="Ingresa el código postal">
                            @error('cp')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="contact"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Contacto<span
                                    class="text-danger">*</span>:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="text" name="contact" id="contact"
                                class="form-control @error('contact') is-invalid @enderror"
                                value="{{ old('contact') ?? $provider->contact }}"
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
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Telefono<span
                                    class="text-danger">*</span>:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="number" name="phone" id="phone"
                                class="form-control @error('phone') is-invalid @enderror"
                                value="{{ old('phone') ?? $provider->phone }}" placeholder="10 digitos">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="email" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Correo
                                electrónico<span class="text-danger">*</span>:</b></label>
                        <div class="col-12 col-md-8">
                            <input type="email" name="email" id="email"
                                class="form-control @error('email') is-invalid @enderror"
                                value="{{ old('email') ?? $provider->email }}"
                                placeholder="Ingresa un correo electrónico">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="about"
                            class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Informacion
                                extra:</b></label>
                        <div class="col-12 col-md-8">
                            <textarea name="about" id="about" class="form-control @error('about') is-invalid @enderror"
                                rows="2"
                                placeholder="Información que consideres importante">{{ old('about') ?? $provider->about }}</textarea>
                            @error('about')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row form-group">
                        <label for="image" class="col-12 col-md-4 text-center text-md-right align-self-center"><b>Logo del
                                proveedor:</b></label>
                        <div class="col-12 col-md-8 text-center text-md-left">
                            <input type="file" name="image" id="image" accept="image/*" style="overflow: hidden;">
                            @if ($errors->has('image'))
                                <div class="col-12 text-center text-danger"><b>{{ $errors->first('image') }}</b></div>
                            @endif
                        </div>
                    </div>
                    <div class="row justify-content-center form-group">
                        <div class="col-auto">
                            <a role="button" href="{{ route('admin.providers') }}"
                                class="btn btn-sm btn-secondary">Cancelar</a>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-sm btn-primary" id="btnCreate">Aceptar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

    </div>
@endsection
