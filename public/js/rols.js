//seleccionar-deseleccionar roles por jerarquia
$('input[type="checkbox"]').on('click', function () {
    //Checar el principal si algun rol "main" esta seleccionado

    if ($(this).is(":checked")) {
        if ($(this).prop('id') == "edit_inventory") {
            $('#main_inventory').prop('checked', true);
        }

        if ($(this).prop('id') == "edit_rh") {
            $('#main_rh').prop('checked', true);
        }

        if ($(this).prop('id') == "edit_social") {
            $('#main_social').prop('checked', true);
        }

        if ($(this).prop('id') == "edit_finance") {
            $('#main_finance').prop('checked', true);
        }
    } else if ($(this).is(":not(:checked)")) {
        if ($(this).prop('id') == "main_inventory") {
            $('#edit_inventory').prop('checked', false);
        }

        if ($(this).prop('id') == "main_rh") {
            $('#edit_rh').prop('checked', false);
        }

        if ($(this).prop('id') == "main_finance") {
            $('#edit_finance').prop('checked', false);
        }

        if ($(this).prop('id') == "main_social") {
            $('#edit_social').prop('checked', false);
        }
    }

});
