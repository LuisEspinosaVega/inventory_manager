<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Log;
use App\Models\Office;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransferController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:main_inventory');
        $this->middleware('auth');
    }

    public function index()
    {
        $transfers = Transfer::all();
        return view('inventory.transfer.index', compact('transfers'));
    }

    public function create()
    {
        //Solo se necesitarán las sucursales
        $offices = Office::select('name', 'id')->where('id', '>', '1')->get();
        $items = DB::table('items')->select('catalogs.name', 'items.serial_number', 'items.id')->join('catalogs', 'items.catalog_id', '=', 'catalogs.id')->get();

        return view('inventory.transfer.create', compact('offices', 'items'));
    }

    //aqui solo se guarda la info de el traspaso y los LOGS que es donde se guarda la información de cantidades e items
    public function store(Request $request)
    {
        //Crear la transferencia SOLO CREARLAAAAAAAAAAAAAAAAAAAAAAAAAA
        $transfer = Transfer::create([
            'user_id' => Auth::user()->id,
            'office_id' => $request->office_id,
            'destiny' => $request->destiny,
            'mandated' => $request->mandated,
            'applicant' => $request->applicant,
            'comment' => $request->comment
        ]);

        //Generar los registros por cada item
        if ($transfer) {
            foreach ($request->items as $transfer_item) {
                // crear el registro
                Log::create([
                    'type' => "Traspaso",
                    'transfer_id' => $transfer->id,
                    'amount' => $transfer_item['transfer_amount'],
                    'item_id' => $transfer_item['item_id']
                ]);
            }
        }

        return "ok";
    }

    public function detail(Transfer $transfer)
    {
        $offices = Office::select('name', 'id')->where('id', '>', '1')->get();
        $logs = Log::where('transfer_id','=',$transfer->id)->get();
        return view('inventory.transfer.detail',compact('transfer','offices','logs'));
    }

    //Cancelar el traspaso
    public function destroy(Request $request)
    {
        $transfer = Transfer::find($request->cancel_id);
        $transfer->status = "Cancelado";
        $transfer->updated_by = Auth::user()->id;
        $transfer->save();

        return "ok";
    }

    //Autorizar el traspaso, aqui se harán todos los movimientos
    public function authorizeTransfer(Request $request)
    {
        $transfer = Transfer::find($request->autorizar_id);
        $logs = Log::where('transfer_id', '=', $transfer->id)->get();
        // dd($transfer);
        foreach($logs as $log){
            $item = Item::select('id')->where('id', '=', $log->item_id)->first();
            //Scara los items del origen y moverlos a la sucursal 1 que es  "TRANSITO"

            //Guardar existencias ಥ_ಥ verificar si la tabla de relacion ya existe o hay que crearla
            $existRelationship = DB::select('select * from item_office where item_id = ? AND office_id = ?', [$item->id, $transfer->office_id]);
            if ($existRelationship) {
                $newStock = $existRelationship[0]->stock - $log['amount'];
                //Guardar el registro
                DB::update("update item_office set stock = ? where item_id = ? AND office_id = ?", [$newStock, $item->id, $transfer->office_id]);
            } else {
                DB::insert('insert into item_office (item_id, office_id, stock) values (?, ?,?)', [$item->id, $transfer->office_id, -intval($log['amount'])]);
            }

            //Mandarlos a transito
            //Guardar existencias ಥ_ಥ verificar si la tabla de relacion ya existe o hay que crearla
            $existRelationship = DB::select('select * from item_office where item_id = ? AND office_id = ?', [$item->id, 1]);
            if ($existRelationship) {
                $newStock = $existRelationship[0]->stock + $log['amount'];
                //Guardar el registro
                DB::update("update item_office set stock = ? where item_id = ? AND office_id = ?", [$newStock, $item->id, 1]);
            } else {
                DB::insert('insert into item_office (item_id, office_id, stock) values (?, ?,?)', [$item->id, 1, intval($log['amount'])]);
            }

        }

        $transfer->status = "Autorizado";
        $transfer->updated_by = Auth::user()->id;
        $transfer->authorizes = Auth::user()->name;
        $transfer->save();

        return "ok";
    }

    public function entryTransfer(Request $request){
        $transfer = Transfer::find($request->recibir_id);
        $logs = Log::where('transfer_id', '=', $transfer->id)->get();

        foreach($logs as $log){
            $item = Item::select('id')->where('id', '=', $log->item_id)->first();
            //Guardar existencias ಥ_ಥ verificar si la tabla de relacion ya existe o hay que crearla
            $existRelationship = DB::select('select * from item_office where item_id = ? AND office_id = ?', [$item->id, 1]);
            $newStock = $existRelationship[0]->stock - $log['amount'];
            DB::update("update item_office set stock = ? where item_id = ? AND office_id = ?", [$newStock, $item->id, 1]);

            //Movelo a la sucursal destino

            //Guardar existencias ಥ_ಥ verificar si la tabla de relacion ya existe o hay que crearla
            $existRelationship = DB::select('select * from item_office where item_id = ? AND office_id = ?', [$item->id, $transfer->destiny]);
            if ($existRelationship) {
                $newStock = $existRelationship[0]->stock + $log['amount'];
                //Guardar el registro
                DB::update("update item_office set stock = ? where item_id = ? AND office_id = ?", [$newStock, $item->id, $transfer->destiny]);
            } else {
                DB::insert('insert into item_office (item_id, office_id, stock) values (?, ?,?)', [$item->id, $transfer->destiny, intval($log['amount'])]);
            }
        }

        $transfer->status = "Recibido";
        $transfer->updated_by = Auth::user()->id;
        $transfer->receive = Auth::user()->name;
        $transfer->save();

        return "ok";
    }
}
