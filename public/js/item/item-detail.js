//Delete catalog
$('#deleteItemModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id_item = button.data('iditem');

    var modal = $(this);

    $("#id_item").val(id_item);
});

$("#deleteItemForm").on("submit", function (e) {
    e.preventDefault();
    let id_item = $("#id_item").val();
    const token = document.querySelector('meta[name="csrf-token"]').content;

    fetch('/inventory/items', {
        method: 'delete',
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({ id_item: id_item })
    })
        .then((response) => {
            // console.log(response);
            window.location.href = "/inventory/items";
        })
        .catch((error) => {
            console.log(error);
        })
});
