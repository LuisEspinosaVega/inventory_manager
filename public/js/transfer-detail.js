const token = document.querySelector('meta[name="csrf-token"]').content;

//Hacer el request si se da click en autorizar el boton
$("#btnAuthorizeTransfer").on('click',function (e) {
    let autorizar_id = $("#autorizar_id").val();
    $(this).prop('disabled', true);

    //Hacer el fetch aqui
    //Hacer el fetch aqui
    fetch('/inventory/transfers/authorize', {
        method: 'POST',
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({ autorizar_id: autorizar_id })
    })
        .then((response) => {
            // console.log(response);
            location.reload();
        })
        .catch((error) => {
            console.log(error);
        })
});

//Hacer el request si se da click en autorizar el boton
$("#btnRecibirTransfer").on('click',function (e) {
    let recibir_id = $("#recibir_id").val();
    $(this).prop('disabled', true);

    //Hacer el fetch aqui
    fetch('/inventory/transfers/entry', {
        method: 'POST',
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({ recibir_id: recibir_id })
    })
        .then((response) => {
            // console.log(response);
            location.reload();
        })
        .catch((error) => {
            console.log(error);
        })
});

$("#btnCancelTransfer").on('click',function (e) {
    let cancel_id = $("#cancel_id").val();
    $(this).prop('disabled', true);

    //Hacer el fetch aqui
    fetch('/inventory/transfers', {
        method: 'delete',
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({ cancel_id: cancel_id })
    })
        .then((response) => {
            // console.log(response)
            location.reload();
        })
        .catch((error) => {
            console.log(error);
        })
});
