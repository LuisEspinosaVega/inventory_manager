//Evitar dobles registros por accidente
$("#btnCreate").on('click',function (e) {
    $(".formCreate").trigger('submit');
    $(this).prop('disabled', true);
});
//Delete user
$('#deleteUserModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id_user = button.data('iduser');

    var modal = $(this);

    $("#id_user").val(id_user);
});

$("#deleteUserForm").on("submit", function (e) {
    e.preventDefault();
    let id_user = $("#id_user").val();
    const token = document.querySelector('meta[name="csrf-token"]').content;

    fetch('/admin/users', {
        method: 'delete',
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({ id_user: id_user })
    })
        .then((response) => {
            // console.log(response);
            location.reload();
        })
        .catch((error) => {
            console.log(error);
        })
});

//Delete provider
$('#deleteProviderModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id_provider = button.data('idprovider');

    var modal = $(this);

    $("#id_provider").val(id_provider);
});

$("#deleteProviderForm").on("submit", function (e) {
    e.preventDefault();
    let id_provider = $("#id_provider").val();
    const token = document.querySelector('meta[name="csrf-token"]').content;

    fetch('/admin/providers', {
        method: 'delete',
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({ id_provider: id_provider })
    })
        .then((response) => {
            // console.log(response);
            location.reload();
        })
        .catch((error) => {
            console.log(error);
        })
});

//Delete sucursal
$('#deleteSucursalModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id_sucursal = button.data('idsucursal');

    var modal = $(this);

    $("#id_sucursal").val(id_sucursal);
});

$("#deleteSucursalForm").on("submit", function (e) {
    e.preventDefault();
    let id_sucursal = $("#id_sucursal").val();
    const token = document.querySelector('meta[name="csrf-token"]').content;

    fetch('/admin/offices', {
        method: 'delete',
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({ id_sucursal: id_sucursal })
    })
        .then((response) => {
            // console.log(response);
            location.reload();
        })
        .catch((error) => {
            console.log(error);
        })
});
