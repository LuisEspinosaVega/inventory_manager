@extends('layouts.admin')

@section('content')
    <div class="container">
        <div class="h4 text-center">Lista de usuarios</div>
        <div class="row justify-content-center justify-content-md-end mt-2">
            <div class="col-auto text-center">
                <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-dark">Crear usuario</a>
            </div>
        </div>
        <div class="row justify-content-center my-3">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-dark">
                        <thead class="">
                            <tr>
                                <th class="align-middle p-2 text-center">Nombre de usuario</th>
                                <th class="align-middle p-2 text-center d-none d-sm-none d-md-table-cell">Correo electrónico
                                </th>
                                <th class="align-middle p-2 text-center d-none d-sm-none d-md-table-cell">Estatus</th>
                                <th colspan="2" class="align-middle p-2 text-center">Administrar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="align-middle p-1">{{ $user->name }}</td>
                                    <td class="align-middle p-1 d-none d-sm-none d-md-table-cell">{{ $user->email }}</td>
                                    <td class="align-middle p-1 d-none d-sm-none d-md-table-cell">
                                        {{ $user->profile->status == 1 ? 'Activo' : 'Inactivo' }}</td>
                                    @if ($user->id == 1)
                                        <td colspan="2" class="align-middle p-1 text-center">
                                            <div class="btn btn-sm btn-secondary disabled">❌</div>
                                        </td>
                                    @else
                                        <td class="align-middle p-1 text-center">
                                            <a role="button" href="{{ route('admin.users.edit', $user->id) }}"
                                                class="btn btn-sm btn-primary">Editar</a>
                                        </td>
                                        <td class="align-middle p-1 text-center">
                                            <button role="button" class="btn btn-sm btn-danger"
                                                data-iduser="{{ $user->id }}" data-toggle="modal"
                                                data-target="#deleteUserModal">Eliminar</button>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row justify-content-center mt-3">
            <div class="col-auto text-center">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="deleteUserModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-body bg-dark">
                    <form action="{{ route('admin.users.destroy') }}" method="post" id="deleteUserForm">
                        @csrf
                        <div class="row justify-content-center p-1">
                            <input type="hidden" name="id_user" id="id_user">
                            <div class="col-12 text-center h5 text-light mb-3">
                                ¿Eliminar usuario?
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
