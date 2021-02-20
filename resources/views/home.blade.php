@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="col-12 h4 text-center">Bienvenido a Roesga ERP</div>
        <div class="row justify-content-center justify-content-md-between my-3">

            @if (Auth::user()->can('main_admin'))
                <div class="col-12 col-md-5 mx-2 text-center mt-3  rounded" style="background-color: rgba(40, 97, 219, 0.452); -webkit-box-shadow: 5px 5px 15px 5px #000000; 
                                    box-shadow: 5px 5px 15px 5px #000000;">
                    <a href="{{ route('admin') }}" class="text-center">
                        <h3>Administrador</h3>
                        <img src="{{ asset('storage/resources/admin.svg') }}" alt="home image" class="img-fluid">

                    </a>
                </div>
            @else
                <div class="col-12 col-md-5 mx-2 text-center mt-3  rounded" style="background-color: rgba(121, 121, 121, 0.589); -webkit-box-shadow: 5px 5px 15px 5px #000000; 
                    box-shadow: 5px 5px 15px 5px #000000;">
                    <h3>Administrador</h3>
                    <img src="{{ asset('storage/resources/admin.svg') }}" alt="home image" class="img-fluid">
                </div>
            @endif

            @if (Auth::user()->can('main_inventory'))
                <div class="col-12 col-md-5 mx-2 text-center mt-3  rounded" style="background-color: rgba(214, 118, 118, 0.452); -webkit-box-shadow: 5px 5px 15px 5px #000000; 
                                    box-shadow: 5px 5px 15px 5px #000000;">
                    <a href="{{ route('inventory') }}" class="text-center">
                        <h3>Inventarios</h3>
                        <img src="{{ asset('storage/resources/inventory.svg') }}" alt="home image" class="img-fluid">

                    </a>
                </div>
            @else
                <div class="col-12 col-md-5 mx-2 text-center mt-3  rounded" style="background-color: rgba(121, 121, 121, 0.589); -webkit-box-shadow: 5px 5px 15px 5px #000000; 
                                    box-shadow: 5px 5px 15px 5px #000000;">
                    <h3>Inventarios</h3>
                    <img src="{{ asset('storage/resources/inventory.svg') }}" alt="home image" class="img-fluid">

                </div>
            @endif

            {{-- @if (Auth::user()->can('main_rh'))
                <div class="col-12 col-md-5 mx-2 text-center mt-3 rounded" style="background-color: rgba(11, 156, 55, 0.452); -webkit-box-shadow: 5px 5px 15px 5px #000000; 
                                    box-shadow: 5px 5px 15px 5px #000000;">
                    <a href="#" class="text-center">
                        <h3>Recursos Humanos</h3>
                        <img src="{{ asset('storage/resources/rh.svg') }}" alt="home image" class="img-fluid">

                    </a>
                </div>
            @else
                <div class="col-12 col-md-5 mx-2 text-center mt-3 rounded" style="background-color: rgba(121, 121, 121, 0.589); -webkit-box-shadow: 5px 5px 15px 5px #000000; 
                box-shadow: 5px 5px 15px 5px #000000;">
                        <h3>Recursos Humanos</h3>
                        <img src="{{ asset('storage/resources/rh.svg') }}" alt="home image" class="img-fluid">
                </div>
            @endif

            @if (Auth::user()->can('main_finance'))
                <div class="col-12 col-md-5 mx-2 text-center mt-3 rounded" style="background-color: rgba(141, 12, 113, 0.452); -webkit-box-shadow: 5px 5px 15px 5px #000000; 
                                    box-shadow: 5px 5px 15px 5px #000000;">
                    <a href="#" class="text-center">
                        <h3>Finanzas</h3>
                        <img src="{{ asset('storage/resources/finance.svg') }}" alt="home image" class="img-fluid">

                    </a>
                </div>
            @else
                <div class="col-12 col-md-5 mx-2 text-center mt-3 rounded" style="background-color: rgba(121, 121, 121, 0.589); -webkit-box-shadow: 5px 5px 15px 5px #000000; 
                box-shadow: 5px 5px 15px 5px #000000;">
                        <h3>Finanzas</h3>
                        <img src="{{ asset('storage/resources/finance.svg') }}" alt="home image" class="img-fluid">
                </div>
            @endif

            @if (Auth::user()->can('main_social'))
                <div class="col-12 col-md-5 mx-2 text-center mt-3 rounded" style="background-color: rgba(128, 141, 12, 0.452); -webkit-box-shadow: 5px 5px 15px 5px #000000; 
                                    box-shadow: 5px 5px 15px 5px #000000;">
                    <a href="#" class="text-center">
                        <h3>Social</h3>
                        <img src="{{ asset('storage/resources/social.svg') }}" alt="home image" class="img-fluid">

                    </a>
                </div>
            @else
                <div class="col-12 col-md-5 mx-2 text-center mt-3 rounded" style="background-color: rgba(121, 121, 121, 0.589); -webkit-box-shadow: 5px 5px 15px 5px #000000; 
                box-shadow: 5px 5px 15px 5px #000000;">
                        <h3>Finanzas</h3>
                        <img src="{{ asset('storage/resources/social.svg') }}" alt="home image" class="img-fluid">
                </div>
            @endif --}}
        </div>
    </div>
@endsection
