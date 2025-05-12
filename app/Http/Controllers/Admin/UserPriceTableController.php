<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PriceTable;
use App\Models\User;
use App\Models\UserPriceTable;
use Illuminate\Http\Request;

class UserPriceTableController extends Controller
{
    public function index()
    {
        $userPriceTables = UserPriceTable::with(['user', 'priceTable'])->get();
        return view('admin.user-price-tables.index', compact('userPriceTables'));
    }

    public function create()
    {
        $users = User::all();
        $priceTables = PriceTable::all();
        return view('admin.user-price-tables.create', compact('users', 'priceTables'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'price_table_id' => 'required|exists:price_tables,id'
        ]);

        UserPriceTable::create($validated);
        return redirect()->route('user-price-tables.index');
    }

    public function show(UserPriceTable $userPriceTable)
    {
        return view('admin.user-price-tables.show', compact('userPriceTable'));
    }

    public function destroy(UserPriceTable $userPriceTable)
    {
        $userPriceTable->delete();
        return redirect()->route('user-price-tables.index');
    }
}
