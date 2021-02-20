@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h4 text-center">Lista de proveedores</div>
        <div class="row justify-content-center justify-content-md-end mt-2">
            <div class="col-auto text-center mb-3">
                <a href="{{ route('admin.providers.create') }}" class="btn btn-sm btn-dark">Dar de alta proveedor</a>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-dark">
                        <thead>
                            <tr>
                                <th class="align-middle p-2 text-center">Logo</th>
                                <th class="align-middle p-2 text-center">Nombre</th>
                                <th class="align-middle p-2 text-center d-none d-sm-none d-md-table-cell">Contacto</th>
                                <th class="align-middle p-2 text-center d-none d-sm-none d-md-table-cell">Correo</th>
                                <th class="align-middle p-2 text-center d-none d-sm-none d-md-table-cell">Telefono</th>
                                <th colspan="2" class="align-middle p-2 text-center">Administrar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($providers as $provider)
                                <tr>
                                    <td class="align-middle text-center p-1">
                                        @if ($provider->image)
                                            <img src="{{ asset('/storage/' . $provider->image) }}"
                                                alt="Logo del proveedor" class="img-fluid"
                                                style="max-height:80px; width: auto;">
                                        @else
                                            <img src="{{ asset('/storage/providers/no-image-provider.svg') }}"
                                                alt="Logo del proveedor" class="img-fluid"
                                                style="max-height:80px; width: auto;">
                                        @endif
                                    </td>
                                    <td class="align-middle p-1">{{ $provider->name }}</td>
                                    <td class="align-middle p-1 d-none d-sm-none d-md-table-cell">{{ $provider->contact }}
                                    </td>
                                    <td class="align-middle p-1 d-none d-sm-none d-md-table-cell">{{ $provider->email }}
                                    </td>
                                    <td class="align-middle p-1 d-none d-sm-none d-md-table-cell">{{ $provider->phone }}
                                    </td>
                                    <td class="align-middle p-1 text-center">
                                        <a role="button" href="{{ route('admin.providers.edit', $provider->id) }}"
                                            class="btn btn-sm btn-primary">Detalle</a>
                                    </td>
                                    <td class="align-middle p-1 text-center">
                                        @if ($provider->entries()->count())
                                            <button type="button" class="btn btn-sm btn-danger" disabled>❌</button>
                                        @else
                                            <button type="button" class="btn btn-sm btn-danger"
                                                data-idprovider="{{ $provider->id }}" data-toggle="modal"
                                                data-target="#deleteProviderModal">Eliminar</button>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteProviderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body bg-dark">
                    <form action="{{ route('admin.providers.destroy') }}" method="post" id="deleteProviderForm">
                        @csrf
                        <div class="row justify-content-center p-1">
                            <input type="hidden" name="id_provider" id="id_provider">
                            <div class="col-12 text-center h5 text-light mb-3">
                                ¿Eliminar proveedor?
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
