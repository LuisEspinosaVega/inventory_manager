$(function () {
    //Crear la datatable =0
    $("#catalogDetailTable").DataTable(
        {
            "searching": true,
            "retrieve": false,
            "info": false,
            "language": {
                "decimal": "",
                "emptyTable": "No hay información",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
                "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
                "infoFiltered": "(Filtrado de _MAX_ total entradas)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ Entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "Sin resultados encontrados",
                "paginate": {
                    "first": "Primero",
                    "last": "Ultimo",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            },

        }
    );
});
//Evitar dobles registros por accidente
$("#btnCreate").on('click', function (e) {
    $(".formCreate").trigger('submit');
    $(this).prop('disabled', true);
});

//Delete catalog
$('#deleteCatalogModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id_catalog = button.data('idcatalog');

    var modal = $(this);

    $("#id_catalog").val(id_catalog);
});

$("#deleteCatalogForm").on("submit", function (e) {
    e.preventDefault();
    let id_catalog = $("#id_catalog").val();
    const token = document.querySelector('meta[name="csrf-token"]').content;

    fetch('/inventory/catalog', {
        method: 'delete',
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({ id_catalog: id_catalog })
    })
        .then((response) => {
            // console.log(response);
            window.location.href = "/inventory/catalog";
        })
        .catch((error) => {
            console.log(error);
        })
});
