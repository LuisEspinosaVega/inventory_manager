$(function () {
    $('.catalog-select').selectpicker();
    $('.catalog-select').selectpicker();
    $('.catalog-select').selectpicker();
});

//Inicializar variables
var itemsList = [];

var item = new Object();

$("#item_search").on('change', function (e) {
    e.preventDefault();
    let item_search = $("#item_search").val();

    if (item_search != "") {
        getItemData(item_search);
    } else {
        $("#itemsOutletForm").trigger('reset');
    }
});

function getItemData(value) {
    const token = document.querySelector('meta[name="csrf-token"]').content;

    fetch('/inventory/get-item', {
        method: 'post',
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({ item_id: value })
    })
        .then(response => response.json())
        .then((data) => {
            document.getElementById("catalog_name").value = data.name;
            document.getElementById("serial_number").value = data.serial_number;
            document.getElementById("item_id").value = data.id;
            document.getElementById("stock").value = data.stock;

        })
}

//---------------------------------------Agregar o cancelar item---------------------------------------------
$("#btnCancelItem").on('click', function (e) {
    $("#itemsOutletForm").trigger('reset');
});

$("#btnAddItem").on('click', function (e) {
    let outlet_amount = $("#outlet_amount").val();
    let item_id = $("#item_id").val();
    let name = $("#catalog_name").val();
    let serial_number = $("#serial_number").val();
    let stock = $("#stock").val();

    if (item_id == "" || outlet_amount == "" || parseInt(outlet_amount) <= 0) {
        $("#rowAlertItem").removeClass('d-none');
        $("#outlet_amount").addClass('is-invalid');
        setTimeout(() => {
            $("#rowAlertItem").addClass('d-none');
            $("#outlet_amount").removeClass('is-invalid');
        }, 1500);
    } else {
        if (parseInt(outlet_amount) > parseInt(stock)) {
            $("#stockWarning").modal('show');
        }

        item.item_id = item_id;
        item.outlet_amount = outlet_amount;
        item.name = name;
        item.serial_number = serial_number;

        itemsList.push(item); //<---------agregar el item creado al arreglo de items

        //LLenar la tabla de items cada que se agregue o elimine un item
        fillTableBody(itemsList); //<---------------dibujar la tabla  (solo es grafico esto)

        // Limpiar los items para volver a agregar al arreglo XD
        $("#item_search").val('');
        $("#itemsOutletForm").trigger('reset');
        item = {};
    }
});

function fillTableBody(array) {
    document.getElementById("tableItemsBody").innerHTML = "";
    let i = 0;
    array.map(item => {
        document.getElementById("tableItemsBody").innerHTML += `
            <tr>
                <td>${item.name}</td>
                <td>${item.serial_number}</td>
                <td>${item.outlet_amount}</td>
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

$("#btnConfirmOutlet").on('click', function () {
    let office_id = $("#office_id").val();
    let type = $("#type").val();
    let mandated = $("#mandated").val();

    if (office_id == "" || type == "" || mandated == "") {
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
            $("#btnConfirmOutlet").prop('disabled', true);
            const token = document.querySelector('meta[name="csrf-token"]').content;
            // Aqui se hace el request con la info
            fetch('/inventory/outlets', {
                method: 'post',
                headers: {
                    "Content-Type": "application/json; charset=utf-8",
                    "X-CSRF-TOKEN": token
                },
                body: JSON.stringify({ office_id: office_id, type: type, mandated: mandated, items: itemsList })
            })
                .then(() => {
                    window.location.href = "/inventory/outlets";
                })
                .catch((error) => {
                    console.log(error);
                })
        }
    }
});
