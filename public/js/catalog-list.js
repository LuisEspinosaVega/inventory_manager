$(function () {
    getCatalogData();
});

$(".keys").on("keyup", function (e) {
    getCatalogData();
});

$(".selects").on("change", function (e) {
    getCatalogData();
});

function getCatalogData() {
    let name = $("#search_name").val();
    let sku = $("#search_sku").val();
    let category = $("#search_category").val();
    let sub_category = $("#search_sub_category").val();

    const token = document.querySelector('meta[name="csrf-token"]').content;

    fetch('/inventory/filter-catalog', {
        method: 'post',
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({ name: name, sku: sku, category: category, sub_category: sub_category })
    })
        .then(response => response.json())
        .then(data => {
            $("#tableBody").html('');
            data.map(item => {
                document.getElementById("tableBody").innerHTML += `<tr>
                    <td>${item.name}</td>
                    <td>${item.sku}</td>
                    <td class=" d-none d-sm-none d-md-table-cell">${item.description}</td>
                    <td class=" d-none d-sm-none d-md-table-cell">${item.stock}</td>
                    <td> <a role="button" href="/inventory/catalog/${item.id}" class="btn btn-sm btn-primary">Detalles <span class="align-middle" style="font-size:17px;">⇗</span></a> </td>
                </tr>`;
            });

            //Crear la datatable =0
            $("#catalogTable").DataTable(
                {
                    "searching": false,
                    "retrieve": true,
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
        })
        .catch((error) => {
            console.log(error);
        })
}
