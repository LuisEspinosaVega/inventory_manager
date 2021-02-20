<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Category;
use App\Models\Item;
use App\Models\Log;
use App\Models\Variable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    public $main_inventory = false;
    public $edit_inventory = false;

    public function __construct()
    {
        $this->middleware('can:main_inventory');
        $this->middleware('auth');
    }

    public function index()
    {
        return view('inventory.index');
    }

    // handle catalog-----------------------------------------------------------------------------------------
    public function catalog()
    {
        //Mandar las variables para los filtros (*￣3￣)╭
        $categoria = Category::select('id')->where('name', 'Categoria producto')->pluck('id')[0];
        $subCategoria = Category::select('id')->where('name', 'Sub categoria producto')->pluck('id')[0];
        $grupo = Category::select('id')->where('name', 'Grupo')->pluck('id')[0];
        $familia = Category::select('id')->where('name', 'Familia')->pluck('id')[0];
        $color = Category::select('id')->where('name', 'Color')->pluck('id')[0];

        $categories = Variable::where('category_id', $categoria)->get();
        $subCategories = Variable::where('category_id', $subCategoria)->get();
        $groups = Variable::where('category_id', $grupo)->get();
        $families = Variable::where('category_id', $familia)->get();
        $colors = Variable::where('category_id', $color)->get();
        // dd($categories);

        return view('inventory.catalog.index', compact('categories', 'subCategories', 'groups', 'families', 'colors'));
    }
    //Funcion para las peticiones AJAX para usar filtros
    public function filtersCatalog(Request $request)
    {
        $name = $request->name;
        $sku = $request->sku;
        $category = $request->category;
        $subCategory = $request->sub_category;

        $name_query = ['id', '>', 0];
        $sku_query = ['id', '>', 0];
        $category_query = ['id', '>', 0];
        $subCategory_query = ['id', '>', 0];

        if ($name != "") {
            $name_query = ['name', 'LIKE', '%' . $name . '%'];
        }
        if ($sku != "") {
            $sku_query = ['sku', 'LIKE', '%' . $sku . '%'];
        }
        if ($category != "") {
            $category_query = ['category', '=', $category];
        }
        if ($subCategory != "") {
            $subCategory_query = ['sub_category', '=', $subCategory];
        }

        $catalog = Catalog::select('name', 'description', 'sku', 'id')->where([
            $name_query,
            $sku_query,
            $category_query,
            $subCategory_query
        ])->get();

        foreach ($catalog as $index => $key) {
            $stock = 0;
            foreach ($key->items as $item) {
                $stock = $stock + $item->stock;
            }
            $catalog[$index]->stock = $stock;
        }

        return json_encode($catalog);
    }

    public function createCatalog()
    {
        //Mandar las variables para los filtros (*￣3￣)╭
        $categoria = Category::select('id')->where('name', 'Categoria producto')->pluck('id')[0];
        $subCategoria = Category::select('id')->where('name', 'Sub categoria producto')->pluck('id')[0];
        $grupo = Category::select('id')->where('name', 'Grupo')->pluck('id')[0];
        $familia = Category::select('id')->where('name', 'Familia')->pluck('id')[0];
        $color = Category::select('id')->where('name', 'Color')->pluck('id')[0];

        $categories = Variable::where('category_id', $categoria)->get();
        $subCategories = Variable::where('category_id', $subCategoria)->get();
        $groups = Variable::where('category_id', $grupo)->get();
        $families = Variable::where('category_id', $familia)->get();
        $colors = Variable::where('category_id', $color)->get();

        return view('inventory.catalog.create', compact('categories', 'subCategories', 'groups', 'families', 'colors'));
    }

    public function storeCatalog(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['required', 'min:10', 'string'],
            'brand' => ['nullable', 'max:255'],
            'model' => ['required', 'string', 'min:5', 'max:255'],
            'category' => ['required'],
            'color_primary' => ['required'],
            'color_secondary' => ['nullable'],
            'group' => ['nullable'],
            'family' => ['nullable'],
            'sub_category' => ['nullable'],
            'image' => ['image']
        ]);

        if ($request->image) {
            //Guardar la imagen en el servidor
            $path = $request->image->store('catalog', 'public');
        } else {
            $path = null;
        }

        $sku = strtoupper(substr($request->name, 0, 3)) . date("dis");
        // dd($request);
        Catalog::create([
            'name' => $request->name,
            'sku' => $sku,
            'brand' => $request->brand,
            'model' => $request->model,
            'description' => $request->description,
            'category' => $request->category,
            'sub_category' => $request->sub_category,
            'color_primary' => $request->color_primary,
            'color_secondary' => $request->color_secondary,
            'group' => $request->group,
            'family' => $request->family,
            'image' => $path,
            'created_by' => Auth::user()->id
        ]);

        return redirect('/inventory/catalog')->with('success', 'Articulo creado en catalogo!');
    }

    public function detailCatalog(Catalog $catalog)
    {
        //Mandar las variables para los filtros (*￣3￣)╭
        $categoria = Category::select('id')->where('name', 'Categoria producto')->pluck('id')[0];
        $subCategoria = Category::select('id')->where('name', 'Sub categoria producto')->pluck('id')[0];
        $grupo = Category::select('id')->where('name', 'Grupo')->pluck('id')[0];
        $familia = Category::select('id')->where('name', 'Familia')->pluck('id')[0];
        $color = Category::select('id')->where('name', 'Color')->pluck('id')[0];

        $categories = Variable::where('category_id', $categoria)->get();
        $subCategories = Variable::where('category_id', $subCategoria)->get();
        $groups = Variable::where('category_id', $grupo)->get();
        $families = Variable::where('category_id', $familia)->get();
        $colors = Variable::where('category_id', $color)->get();

        $items = Item::select('serial_number', 'stock', 'id')->where('catalog_id', '=', $catalog->id)->get();

        return view('inventory.catalog.detail', compact('catalog', 'categories', 'subCategories', 'groups', 'families', 'colors', 'items'));
    }

    public function editCatalog(Catalog $catalog)
    {
        //Mandar las variables para los filtros (*￣3￣)╭
        $categoria = Category::select('id')->where('name', 'Categoria producto')->pluck('id')[0];
        $subCategoria = Category::select('id')->where('name', 'Sub categoria producto')->pluck('id')[0];
        $grupo = Category::select('id')->where('name', 'Grupo')->pluck('id')[0];
        $familia = Category::select('id')->where('name', 'Familia')->pluck('id')[0];
        $color = Category::select('id')->where('name', 'Color')->pluck('id')[0];

        $categories = Variable::where('category_id', $categoria)->get();
        $subCategories = Variable::where('category_id', $subCategoria)->get();
        $groups = Variable::where('category_id', $grupo)->get();
        $families = Variable::where('category_id', $familia)->get();
        $colors = Variable::where('category_id', $color)->get();

        return view('inventory.catalog.edit', compact('catalog', 'categories', 'subCategories', 'groups', 'families', 'colors'));
    }

    public function updateCatalog(Request $request, Catalog $catalog)
    {
        $request->validate([
            'name' => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['required', 'min:10', 'string'],
            'brand' => ['nullable', 'max:255'],
            'model' => ['nullable', 'max:255'],
            'category' => ['required'],
            'color_primary' => ['required'],
            'color_secondary' => ['nullable'],
            'group' => ['nullable'],
            'family' => ['nullable'],
            'sub_category' => ['nullable'],
            'image' => ['image']
        ]);

        if ($request->image) {
            //Guardar la imagen en el servidor
            if ($catalog->image) {
                unlink('storage/' . $catalog->image);
            }

            $path = $request->image->store('catalog', 'public');

            $catalog->image = $path;
        }

        $catalog->name = $request->name;
        $catalog->description = $request->description;
        $catalog->category = $request->category;
        $catalog->sub_category = $request->sub_category;
        $catalog->color_primary = $request->color_primary;
        $catalog->color_secondary = $request->color_secondary;
        $catalog->group = $request->group;
        $catalog->family = $request->family;
        $catalog->brand = $request->brand;
        $catalog->model = $request->model;
        $catalog->updated_by = Auth::user()->id;

        $catalog->save();

        return redirect('/inventory/catalog')->with('edited', 'Articulo editado!');
    }

    public function destroyCatalog(Request $request)
    {
        $catalog = Catalog::find($request->id_catalog);
        if ($catalog->image) {
            unlink('storage/' . $catalog->image);
        }

        $catalog->delete();
        return "ok";
    }

    //historial de movimientos
    public function history()
    {
        $logs = Log::all();
        return view('inventory.history', compact('logs'));
    }

    //Exportar datos aqui viene lo shido (┬┬﹏┬┬)

    public function exportView()
    {
        //mandar tambien los elementos del catalogo para el filtro en items ಠ_ಠ
        $catalogs = Catalog::select('id','name')->get();
        //Mandar las variables para los filtros (*￣3￣)╭
        $categoria = Category::select('id')->where('name', 'Categoria producto')->pluck('id')[0];
        $subCategoria = Category::select('id')->where('name', 'Sub categoria producto')->pluck('id')[0];
        $grupo = Category::select('id')->where('name', 'Grupo')->pluck('id')[0];
        $familia = Category::select('id')->where('name', 'Familia')->pluck('id')[0];
        $color = Category::select('id')->where('name', 'Color')->pluck('id')[0];

        $categories = Variable::where('category_id', $categoria)->get();
        $subCategories = Variable::where('category_id', $subCategoria)->get();
        $groups = Variable::where('category_id', $grupo)->get();
        $families = Variable::where('category_id', $familia)->get();
        $colors = Variable::where('category_id', $color)->get();

        return view('inventory.export', compact('categories', 'subCategories', 'groups', 'families', 'colors','catalogs'));
    }

    //Aqui van todos los request de los exports, tambien va el export aqui
    public function export(Request $request)
    {
        //Primero el catalogo------------------------------------------------------------------------------------------------------
        //Count catalogo =)
        if ($request->typeRequest == "countCatalog") {
            $catalogName = $request->catalog_name;
            $catalogFamily = $request->catalog_family;
            $catalogGroup = $request->catalog_group;
            $catalogCategory = $request->catalog_category;
            $catalogPrimaryColor = $request->catalog_color_primary;

            $catalog_name_query = ['id', '>', 0];
            $catalog_family_query = ['id', '>', 0];
            $catalog_group_query = ['id', '>', 0];
            $catalog_category_query = ['id', '>', 0];
            $catalog_color_query = ['id', '>', 0];

            if ($catalogName != "") {
                $catalog_name_query = ['name', 'LIKE', '%' . $catalogName . '%'];
            }
            if ($catalogFamily != "") {
                $catalog_family_query = ['family', '=', $catalogFamily];
            }
            if ($catalogGroup != "") {
                $catalog_group_query = ['group', '=', $catalogGroup];
            }
            if ($catalogCategory != "") {
                $catalog_category_query = ['category', '=', $catalogCategory];
            }
            if ($catalogPrimaryColor != "") {
                $catalog_color_query = ['color_primary', '=', $catalogPrimaryColor];
            }

            $catalogCount = Catalog::where([
                $catalog_name_query,
                $catalog_family_query,
                $catalog_group_query,
                $catalog_category_query,
                $catalog_color_query
            ])->count();

            // $catalogCount = Catalog::all()->count();
            return $catalogCount;
        }

        if ($request->typeRequest == "exportCatalog") {
            $catalogName = $request->catalog_name;
            $catalogFamily = $request->catalog_family;
            $catalogGroup = $request->catalog_group;
            $catalogCategory = $request->catalog_category;
            $catalogPrimaryColor = $request->catalog_color_primary;

            $catalog_name_query = ['id', '>', 0];
            $catalog_family_query = ['id', '>', 0];
            $catalog_group_query = ['id', '>', 0];
            $catalog_category_query = ['id', '>', 0];
            $catalog_color_query = ['id', '>', 0];

            if ($catalogName != "") {
                $catalog_name_query = ['name', 'LIKE', '%' . $catalogName . '%'];
            }
            if ($catalogFamily != "") {
                $catalog_family_query = ['family', '=', $catalogFamily];
            }
            if ($catalogGroup != "") {
                $catalog_group_query = ['group', '=', $catalogGroup];
            }
            if ($catalogCategory != "") {
                $catalog_category_query = ['category', '=', $catalogCategory];
            }
            if ($catalogPrimaryColor != "") {
                $catalog_color_query = ['color_primary', '=', $catalogPrimaryColor];
            }

            $catalogtoExport = Catalog::where([
                $catalog_name_query,
                $catalog_family_query,
                $catalog_group_query,
                $catalog_category_query,
                $catalog_color_query
            ])->get();

            if ($catalogtoExport) {
                $fileName = date("Y-m-d_H_i_s") . '_catalog.csv';

                $headers = array(
                    "Content-type"        => "text/csv",
                    "Content-Disposition" => "attachment; filename=$fileName",
                    "Pragma"              => "no-cache",
                    "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                    "Expires"             => "0"
                );

                $columns = array('Fecha creacion', 'Ultima modificacion', 'Nombre corto', 'SKU', 'Descripcion', 'Marca', 'Modelo', 'No Items');

                $callback = function () use ($catalogtoExport, $columns) {
                    $file = fopen('php://output', 'w');
                    fputcsv($file, $columns);

                    foreach ($catalogtoExport as $export) {
                        $row['Fecha creacion']  = $export->created_at;
                        $row['Ultima modificacion']    = $export->updated_at;
                        $row['Nombre corto']    = $export->name;
                        $row['SKU']  = $export->sku;
                        $row['Descripcion']  = $export->description;
                        $row['Marca']  = $export->brand;
                        $row['Modelo']  = $export->model;
                        $row['No Items']  = $export->items->count();

                        fputcsv($file, array($row['Fecha creacion'], $row['Ultima modificacion'], $row['Nombre corto'], $row['SKU'], $row['Descripcion'], $row['Marca'], $row['Modelo'], $row['No Items']));
                    }

                    fclose($file);
                };

                return response()->stream($callback, 200, $headers);
            } else {
                exit();
            }
        }

        // items-----------------------------------------------------------------------------------------------------------------------------
        if($request->typeRequest == "countItem"){
            $itemCatalog = $request->item_catalog;
            $itemSerie = $request->item_serie;

            $item_catalog_query = ['id', '>', 0];
            $item_serie_query = ['id', '>', 0];

            if ($itemCatalog != "") {
                $item_catalog_query = ['catalog_id', '=',$itemCatalog ];
            }
            if ($itemSerie != "") {
                $item_serie_query = ['serial_number', 'LIKE',  '%' . $itemSerie. '%'];
            }

            $itemCount = Item::where([
                $item_catalog_query,
                $item_serie_query
            ])->count();

            return $itemCount;
        }

        if($request->typeRequest = "exportItem"){
            $itemCatalog = $request->item_catalog;
            $itemSerie = $request->item_serie;

            $item_catalog_query = ['id', '>', 0];
            $item_serie_query = ['id', '>', 0];

            if ($itemCatalog != "") {
                $item_catalog_query = ['catalog_id', '=',$itemCatalog ];
            }
            if ($itemSerie != "") {
                $item_serie_query = ['serial_number', 'LIKE',  '%' . $itemSerie. '%'];
            }

            $itemExport = Item::where([
                $item_catalog_query,
                $item_serie_query
            ])->get();

            $fileName = date("Y-m-d_H_i_s") . '_articulos.csv';

                $headers = array(
                    "Content-type"        => "text/csv",
                    "Content-Disposition" => "attachment; filename=$fileName",
                    "Pragma"              => "no-cache",
                    "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                    "Expires"             => "0"
                );

                $columns = array('Fecha de alta','Nombre corto', 'Numero de serie', 'Lote', 'Caducidad', 'Stock');

                $callback = function () use ($itemExport, $columns) {
                    $file = fopen('php://output', 'w');
                    fputcsv($file, $columns);

                    foreach ($itemExport as $export) {
                        $row['Fecha de alta']  = $export->created_at;
                        $row['Nombre corto']  = $export->catalog->name;
                        $row['Numero de serie']    = $export->serial_number;
                        $row['Lote']    = $export->lot;
                        $row['Caducidad']  = $export->caducity;
                        $row['Stock']  = $export->stock;

                        fputcsv($file, array($row['Fecha de alta'],$row['Nombre corto'], $row['Numero de serie'], $row['Lote'], $row['Caducidad'], $row['Stock']));
                    }

                    fclose($file);
                };

                return response()->stream($callback, 200, $headers);
        }
    }
}
