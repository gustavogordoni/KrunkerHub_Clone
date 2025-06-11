<?php

namespace App\Http\Controllers\api;

use App\Models\Sale;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SaleResource;

class MarketController extends Controller
{
    public function index(Request $request)
    {
        $query = Sale::with('item')
            ->where('status', 'on_sale')
            ->when($request->rarities, fn($q) => $q->whereHas('item', fn($iq) => $iq->whereIn('rarity', (array) $request->rarities)))
            ->when($request->categories, fn($q) => $q->whereHas('item', fn($iq) => $iq->whereIn('category', (array) $request->categories)))
            ->when($request->season, fn($q) => $q->whereHas('item', fn($iq) => $iq->where('season', $request->season)))
            ->when($request->search, fn($q) => $q->whereHas('item', fn($iq) => $iq->where('name', 'like', "%{$request->search}%")));

        if ($request->sort === 'low') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort === 'high') {
            $query->orderBy('price', 'desc');
        }

        return SaleResource::collection($query->paginate(10));
    }
}
