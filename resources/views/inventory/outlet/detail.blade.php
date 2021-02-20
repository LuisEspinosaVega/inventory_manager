@extends('layouts.inventory')

@section('content')
    <div class="container">
        <div class="h4 text-center">Detalles de la salida con ID: <b>{{$outlet->id}}</b></div>
        <div class="row justify-content-center justify-content-md-end">
            <a role="button" href="{{route('outlet')}}" class="btn btn-sm btn-dark">Regresar ⇖</a>
        </div>

        <div class="row justify-content-center my-4">
            <div class="col-12 col-md-8 h5 text-center">
                <div class="row form-group">
                    <div class="col-12 col-md-6 text-center text-md-right"><b>Fecha de la salida:</b></div>
                    <div class="col-12 col-md-6 text-center text-md-left"><b>{{$outlet->created_at}}</b></div>
                </div>
                <div class="row form-group">
                    <div class="col-12 col-md-6 text-center text-md-right"><b>Sucursal:</b></div>
                    <div class="col-12 col-md-6 text-center text-md-left"><b>{{$outlet->office->name}}</b></div>
                </div>
                <div class="row form-group">
                    <div class="col-12 col-md-6 text-center text-md-right"><b>Encargado del ingreso:</b></div>
                    <div class="col-12 col-md-6 text-center text-md-left"><b>{{$outlet->mandated}}</b></div>
                </div>
            </div>

        </div>

        <div class="row justify-content-center my-3">
            <div class="col-12 col-md-8 text-center table-responsive">
                <table class="table table-sm table-dark table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th>ARTICULO</th>
                            <th>N° SERIE</th>
                            <th>CANTIDAD</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logs as $log)
                            <tr>
                                <td>{{$log->item->catalog->name}}</td>
                                <td>{{$log->item->serial_number}}</td>
                                <td>{{$log->amount}}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
