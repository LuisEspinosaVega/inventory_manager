@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h4 text-center">Lista de sucursales</div>
        <div class="row justify-content-center justify-content-md-end mt-2">
            <div class="col-auto text-center mb-3">
                <a href="{{ route('admin.offices.create') }}" class="btn btn-sm btn-dark">Agregar sucursal</a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-dark">
                        <thead>
                            <tr>
                                <th class="align-middle p-2 text-center">Nombre</th>
                                <th class="align-middle p-2 text-center">Dirección</th>
                                <th class="align-middle p-2 text-center d-none d-sm-none d-md-table-cell">Contacto</th>
                                <th class="align-middle p-2 text-center d-none d-sm-none d-md-table-cell">Correo</th>
                                <th class="align-middle p-2 text-center d-none d-sm-none d-md-table-cell">Telefono</th>
                                <th colspan="1" class="align-middle p-2 text-center">Administrar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($offices as $office)
                                <tr>
                                    <td class="align-middle p-1">{{ $office->name }}</td>
                                    <td class="align-middle p-1">{{ $office->address }}</td>
                                    <td class="align-middle p-1 d-none d-sm-none d-md-table-cell">{{ $office->contact }}
                                    </td>
                                    <td class="align-middle p-1 d-none d-sm-none d-md-table-cell">{{ $office->email }}
                                    </td>
                                    <td class="align-middle p-1 d-none d-sm-none d-md-table-cell">{{ $office->phone }}
                                    </td>
                                    <td class="align-middle p-1 text-center">
                                        <a role="button" href="{{ route('admin.offices.edit', $office->id) }}"
                                            class="btn btn-sm btn-primary">Detalle</a>
                                    </td>
                                    {{-- <td class="align-middle p-1 text-center">
                                        <button type="button" class="btn btn-sm btn-danger"
                                            data-idsucursal="{{ $office->id }}" data-toggle="modal"
                                            data-target="#deleteSucursalModal">Eliminar</button>
                                    </td> --}}
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteSucursalModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body bg-dark">
                    <form action="{{ route('admin.offices.destroy') }}" method="post" id="deleteSucursalForm">
                        @csrf
                        <div class="row justify-content-center p-1">
                            <input type="hidden" name="id_sucursal" id="id_sucursal">
                            <div class="col-12 text-center h5 text-light mb-3">
                                ¿Eliminar sucursal?
                            </div>
                            <div class="col-auto">
                                <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">Cancelar</button>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-sm btn-danger">Si, eliminar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('custom-scripts')
    <script src="{{ asset('js/admin.js') }}" defer></script>
@endpush
