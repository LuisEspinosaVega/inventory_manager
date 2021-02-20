<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Log;
use App\Models\Office;
use App\Models\Outlet;
use App\Models\Variable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OutletController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:main_inventory');
        $this->middleware('auth');
    }

    public function index()
    {
        $outlets = Outlet::all();
        return view('inventory.outlet.index', compact('outlets'));
    }

    public function create()
    {
        $offices = Office::select('name', 'id')->where('id', '>', '1')->get();
        $items = DB::table('items')->select('catalogs.name', 'items.serial_number', 'items.id')->join('catalogs', 'items.catalog_id', '=', 'catalogs.id')->get();

        $type = Category::select('id')->where('name', 'Tipo salida')->pluck('id')[0];
        $types = Variable::where('category_id', $type)->get();

        return view('inventory.outlet.create', compact('offices', 'items', 'types'));
    }

    public function store(Request $request)
    {
        //Crear la salida
        $outlet = Outlet::create([
            'user_id' => Auth::user()->id,
            'office_id' => $request->office_id,
            'type' => $request->type,
            'mandated' => $request->mandated
        ]);

        if ($outlet) {
            foreach ($request->items as $out_item) {
                //Encontrar el item al que se le harán los movimientos
                $item = Item::where([
                    ['id', '=', $out_item['item_id']]
                ])->first();

                //Actualizar el stock y el quien lo actualizo
                $item->stock = $item->stock - $out_item['outlet_amount'];
                $item->updated_by = Auth::user()->id;

                $item->save();

                // crear el registro
                Log::create([
                    'type' => "Salida",
                    'outlet_id' => $outlet->id,
                    'amount' => $out_item['outlet_amount'],
                    'item_id' => $item->id
                ]);

                //Aqui viene la magia, actualizar los inventarios por sucursal, aunque queden negativos c:
                //Guardar existencias ಥ_ಥ verificar si la tabla de relacion ya existe o hay que crearla
                $existRelationship = DB::select('select * from item_office where item_id = ? AND office_id = ?', [$item->id, $outlet->office_id]);
                if ($existRelationship) {
                    $newStock = $existRelationship[0]->stock - $out_item['outlet_amount'];
                    //Guardar el registro
                    DB::update("update item_office set stock = ? where item_id = ? AND office_id = ?", [$newStock, $item->id, $outlet->office_id]);
                } else {
                    DB::insert('insert into item_office (item_id, office_id, stock) values (?, ?,?)', [$item->id, $outlet->office_id, -intval($out_item['outlet_amount'])]);
                }
            }
        }

        return "ok";
    }

    public function detail(Outlet $outlet)
    {
        $logs = Log::where('outlet_id','=',$outlet->id)->get();
        return view('inventory.outlet.detail', compact('outlet','logs'));
    }
}
