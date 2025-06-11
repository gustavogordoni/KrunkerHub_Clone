<?php

namespace App\Http\Controllers\api;

use App\Models\Item;
use App\Models\Sale;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ItemResource;
use App\Http\Resources\ItemDetailResource;

class ItemController extends Controller
{
    public function index()
    {
        return ItemResource::collection(Item::paginate(10));        
    }
    
    public function show($id)
    {
        if (!is_numeric($id)) {
            abort(404, 'Item não encontrado.');
        }

        $item = Item::findOrFail($id);

        $salesQuery = Sale::where('item_id', $item->id)->where('status', 'sold');

        $data = [
            'item' => $item,
            'author' => User::find($item->author),
            'average_price' => $salesQuery->avg('price') ?? 0,
            'min_price' => $salesQuery->min('price') ?? 0,
            'max_price' => $salesQuery->max('price') ?? 0,
            'units_sold' => $salesQuery->count(),
            'owners' => Sale::where('item_id', $item->id)->distinct('user_id')->count('user_id') ?? 0,
        ];

        return new ItemDetailResource($item);
    }
}
