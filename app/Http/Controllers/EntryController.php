<?php

namespace App\Http\Controllers;

use App\Models\Catalog;
use App\Models\Category;
use App\Models\Entry;
use App\Models\Item;
use App\Models\Log;
use App\Models\Office;
use App\Models\Provider;
use App\Models\Variable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EntryController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:main_inventory');
        $this->middleware('auth');
    }

    public function index()
    {
        $entries = Entry::all();
        return view('inventory.entry.index', compact('entries'));
    }

    public function create()
    {
        $offices = Office::select('name', 'id')->where('id', '>', '1')->get();
        $providers = Provider::select('name', 'id')->get();
        $catalogs = Catalog::select('name', 'id')->orderBy('name', 'asc')->get();

        //Mandar las variables para los filtros (*￣3￣)╭
        $type = Category::select('id')->where('name', 'Tipo ingreso')->pluck('id')[0];

        $types = Variable::where('category_id', $type)->get();

        return view('inventory.entry.create', compact('offices', 'types', 'providers', 'catalogs'));
    }

    //Retornar el item de catalogo
    public function getCatalog(Request $request)
    {
        $catalog = Catalog::select('name', 'sku', 'id', 'brand', 'model')->where('id', '=', $request->catalog_id)->get();

        return json_encode($catalog);
    }

    //Guardar el ingreso, varios movimientos se hacen en esta funcion
    public function store(Request $request)
    {
        //crear primero el ingreso
        $entry = Entry::create([
            'provider_id' => $request->provider_id,
            'office_id' => $request->office_id,
            'mandated' => $request->mandated,
            'type' => $request->type,
            'purchase_date' => $request->purchase_date,
            'purchase_order' => $request->purchase_order,
            'user_id' => Auth::user()->id
        ]);

        foreach ($request->items as $item) {
            if($item['item_serie'] == ""){
                $serie = "Default-serial";
            }else{
                $serie = $item["item_serie"];
            }
            //Verificar si ya existe un item con este numero de serie
            $existItem = Item::where([
                ['serial_number', '=', $serie],
                ['catalog_id', '=', $item['catalog_id']]
            ])->first();

            if ($existItem) {
                //Actualizar el stock y el quien lo actualizo
                $existItem->stock = $existItem->stock + $item['item_amount'];
                $existItem->updated_by = Auth::user()->id;

                $existItem->save();

                //Guardar el registro
                Log::create([
                    'type' => "Ingreso",
                    'entry_id' => $entry->id,
                    'amount' => $item['item_amount'],
                    'item_id' => $existItem->id
                ]);

                //Guardar existencias ಥ_ಥ verificar si la tabla de relacion ya existe o hay que crearla
                $existRelationship = DB::select('select * from item_office where item_id = ? AND office_id = ?', [$existItem->id, $entry->office_id]);
                if ($existRelationship) {
                    $newStock = $existRelationship[0]->stock + $item['item_amount'];
                    //Guardar el registro
                    DB::update("update item_office set stock = ? where item_id = ? AND office_id = ?", [$newStock, $existItem->id, $entry->office_id]);
                } else {
                    DB::insert('insert into item_office (item_id, office_id, stock) values (?, ?,?)', [$existItem->id, $entry->office_id, $item['item_amount']]);
                }
            } else {
                
                $newItem = Item::create([
                    'catalog_id' => $item['catalog_id'],
                    'serial_number' => $serie,
                    'lot' => $item['item_lot'],
                    'caducity' => $item['item_caducity'],
                    'stock' => $item['item_amount'],
                    'user_id' => Auth::user()->id
                ]);

                //Crear el registro
                Log::create([
                    'type' => "Ingreso",
                    'entry_id' => $entry->id,
                    'amount' => $item['item_amount'],
                    'item_id' => $newItem->id
                ]);

                //Crear la relacion entre sucursal e item
                DB::insert('insert into item_office (item_id, office_id, stock) values (?, ?,?)', [$newItem->id, $entry->office_id, $item['item_amount']]);
            }
        }

        return "ok";
    }

    //Detalles de el ingreso
    public function detail(Entry $entry)
    {
        //Logs de este ingreso
        $logs = Log::where('entry_id', '=', $entry->id)->get();

        return view('inventory.entry.detail', compact('entry', 'logs'));
    }
}
