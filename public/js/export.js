//Cargar los count al entrar a la pagina
$(function () {
    getCountCatalog();
    getCountItem();
});
$(".catalog-select").on('change', function () {
    getCountCatalog();
});

$(".catalog-text").on('keyup', function () {
    getCountCatalog();
});

$(".item-select").on('change', function () {
    getCountItem();
});

$(".item-text").on('keyup', function () {
    getCountItem();
});

// $("#btnExportCatalog").on('click', function(){
//     getExportCatalog();
// });
const token = document.querySelector('meta[name="csrf-token"]').content;

function getCountItem(){
    let item_catalog = $("#item_catalog").val();
    let item_serie = $("#item_serie").val();

    // Aqui se hace el request con la info
    fetch('/inventory/export', {
        method: 'post',
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({ item_catalog: item_catalog, item_serie: item_serie, typeRequest: 'countItem' })
    })
        .then(response => response.text())
        .then(data => {
            $("#item_count").text(data);
            if(data == "0"){
                $("#btnExportItem").prop('disabled', true);
            }else{
                $("#btnExportItem").prop('disabled', false);
            }
        })
        .catch((error) => {
            console.log(error);
        })
}

function getCountCatalog() {
    let catalog_name = $("#catalog_name").val();
    let catalog_family = $("#catalog_family").val();
    let catalog_group = $("#catalog_group").val();
    let catalog_color_primary = $("#catalog_color_primary").val();
    let catalog_category = $("#catalog_category").val();

    // Aqui se hace el request con la info
    fetch('/inventory/export', {
        method: 'post',
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({ catalog_name: catalog_name, catalog_family: catalog_family, catalog_group: catalog_group, catalog_color_primary: catalog_color_primary, catalog_category: catalog_category, typeRequest: 'countCatalog' })
    })
        .then(response => response.text())
        .then(data => {
            $("#catalog_count").text(data);
            if(data == "0"){
                $("#btnExportCatalog").prop('disabled', true);
            }else{
                $("#btnExportCatalog").prop('disabled', false);
            }
        })
        .catch((error) => {
            console.log(error);
        })
}

function getExportCatalog(){
    let catalog_name = $("#catalog_name").val();
    let catalog_family = $("#catalog_family").val();
    let catalog_group = $("#catalog_group").val();
    let catalog_color_primary = $("#catalog_color_primary").val();
    let catalog_category = $("#catalog_category").val();

    // Aqui se hace el request con la info
    fetch('/inventory/export', {
        method: 'post',
        headers: {
            "Content-Type": "application/json; charset=utf-8",
            "X-CSRF-TOKEN": token
        },
        body: JSON.stringify({ catalog_name: catalog_name, catalog_family: catalog_family, catalog_group: catalog_group, catalog_color_primary: catalog_color_primary, catalog_category: catalog_category, typeRequest: 'exportCatalog' })
    })
        .then(()=>{
            console.log("Archivo listo");
        })
        
        .catch((error) => {
            console.log(error);
        })
}