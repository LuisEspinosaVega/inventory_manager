$(function () {
    $('.catalog-select').selectpicker();
});

var itemsList = [];

var item = new Object();

//Evitar duplicados
//Evitar dobles registros por accidente
$("#btnCreate").on('click', function (e) {
    $(".formCreate").trigger('submit');
    $(this).prop('disabled', true);
});


$("#catalog_search").on('change', function (e) {
    let catalog_id = $("#catalog_search").val();
    if (catalog_id != "") {
        getCatalogData(catalog_id);
    }else{
        $("#catalog_name").val('');
        $("#catalog_sku").val('');
        $("#catalog_id").val('');
        $("#catalog_brand").val('');
        $("#catalog_model").val('');
    }

});

function getCatalogData(val) {
    const token = document.querySelector('meta[name="csrf-token"]').content;

    fetch('/inventory/get-catalog', {
        method: 'post',
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({ catalog_id: val })
    })
        .then(response => response.json())
        .then((data) => {
            document.getElementById("catalog_name").value = data[0].name;
            document.getElementById("catalog_sku").value = data[0].sku;
            document.getElementById("catalog_id").value = data[0].id;
            document.getElementById("catalog_brand").value = data[0].brand;
            document.getElementById("catalog_model").value = data[0].model;
        })
}


//---------------------------------------Agregar o cancelar item---------------------------------------------
$("#btnCancelItem").on('click', function (e) {
    $("#itemListForm").trigger('reset');
});

$("#btnAddItem").on('click', function (e) {
    //Jalar los datos para crear un nuevo objeto y agregarlo al array
    let catalog_id = $("#catalog_id").val();
    let catalog_name = $("#catalog_name").val();
    let item_serie = $("#item_serie").val();
    let item_lot = $("#item_lot").val();
    let item_caducity = $("#item_caducity").val();
    let item_amount = $("#item_amount").val();

    if (item_amount == ""|| parseInt(item_amount) <= 0) {
        $("#rowAlertItem").removeClass('d-none');
        $("#item_amount").addClass('is-invalid');
        $("#catalog_name").addClass('is-invalid');
        setTimeout(() => {
            $("#rowAlertItem").addClass('d-none');
            $("#item_amount").removeClass('is-invalid');
            $("#catalog_name").removeClass('is-invalid');
        }, 2000);
    } else {
        item.catalog_id = catalog_id;
        item.catalog_name = catalog_name;
        item.item_serie = item_serie;
        item.item_lot = item_lot;
        item.item_caducity = item_caducity;
        item.item_amount = item_amount;

        // console.log(item);
        itemsList.push(item); //<---------agregar el item creado al arreglo de items
        // console.log("-----------------------------------");
        // console.log(itemsList);

        //LLenar la tabla de items cada que se agregue o elimine un item
        fillTableBody(itemsList); //<---------------dibujar la tabla  (solo es grafico esto)

        // Limpiar los items para volver a agregar al arreglo XD
        $("#catalog_search").val('');
        $("#itemListForm").trigger('reset');
        item = {};
    }
});

function fillTableBody(array) {
    document.getElementById("tableItemsBody").innerHTML = "";
    let i = 0;
    array.map(item => {
        document.getElementById("tableItemsBody").innerHTML += `
            <tr>
                <td>${item.catalog_name}</td>
                <td>${item.item_serie}</td>
                <td>${item.item_amount}</td>
                <td><button class="btn btn-sm btn-danger btnDeleteItemList" data-indexarray="${i}">❌</button></td>
            </tr>
        `;
        i++;
    });
}

// Eliminar item del arreglo
$(document).on('click', '.btnDeleteItemList', function (e) {
    let indexarray = $(this).data("indexarray");
    // console.log(" ahhh sewa eliminar el arreglo: " + indexarray);
    itemsList.splice(indexarray, 1);

    fillTableBody(itemsList);
});

//Confirmar el ingreso {aqui ocurre la magia XD}
$("#btnConfirmEntry").on('click', function (e) {
    //Verificar que el formulario ya esté completo
    let provider_id = $("#provider_id").val();
    let office_id = $("#office_id").val();
    let type = $("#type").val();
    let mandated = $("#mandated").val();
    let purchase_date = $("#purchase_date").val();
    let purchase_order = $("#purchase_order").val();

    if (provider_id == "" || office_id == "" || type == "" || mandated == "" || purchase_date == "") {
        $("#rowFormIncomplete").removeClass('d-none');

        setTimeout(() => {
            $("#rowFormIncomplete").addClass('d-none');
        }, 1500);
    } else {
        //Verificar que haya items en el arreglo
        if (itemsList.length == 0) {
            $("#rowEmptyAlert").removeClass('d-none');
            setTimeout(() => {
                $("#rowEmptyAlert").addClass('d-none');
            }, 1500);
        } else {
            $("#btnConfirmEntry").prop('disabled', true);
            const token = document.querySelector('meta[name="csrf-token"]').content;
            // Aqui se hace el request con la info
            fetch('/inventory/entries', {
                method: 'post',
                headers: {
                    "Content-Type": "application/json; charset=utf-8",
                    "X-CSRF-TOKEN": token
                },
                body: JSON.stringify({ provider_id: provider_id, office_id: office_id, type: type, mandated: mandated, purchase_date: purchase_date, purchase_order: purchase_order, items: itemsList })
            })
                .then(() => {
                    window.location.href = "/inventory/entries";
                })
                .catch((error) => {
                    console.log(error);
                })
        }
    }

});
