<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Office;
use App\Models\Variable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:main_inventory');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = Item::simplePaginate(50);

        return view('inventory.items.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function details(Item $item)
    {
        //Sucursales para mostrar nombre =3
        $offices = Office::select('name', 'id')->get();

        $existence = DB::select('select * from item_office where item_id = ?', [$item->id]);

        return view('inventory.items.detail', compact('item', 'existence', 'offices'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Item $item)
    {

        return view('inventory.items.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Item $item)
    {
        $request->validate([
            'serial_number' => ['nullable','max:255','string'],
            'caducity' => ['nullable', 'max:255', 'string'],
            'lot' => ['nullable', 'max:255', 'string'],
            'image' => ['image']
        ]);

        if ($request->image) {
            if ($item->image) {
                unlink('storage/' . $item->image);
            }

            $path = $request->image->store('item', 'public');
            $item->image = $path;
        }

        $item->serial_number = $request->serial_number;
        $item->caducity = $request->caducity;
        $item->lot = $request->lot;

        $item->save();

        return redirect('/inventory/items/' . $item->id)->with('edited', 'Articulo editado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
    }

    //Retornar el item de catalogo
    public function getItem(Request $request)
    {
        $item = Item::select('id','serial_number','stock','catalog_id')->where('id','=',$request->item_id)->first();

        $itemData = [
            'name' => $item->catalog->name,
            'serial_number' => $item->serial_number,
            'id' => $item->id,
            'stock' => $item->stock
        ];

        return json_encode($itemData);
    }
}
