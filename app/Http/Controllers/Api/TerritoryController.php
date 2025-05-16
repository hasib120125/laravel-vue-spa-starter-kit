<?php

namespace App\Http\Controllers\Api;

use App\Models\Territory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TerritoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Territory::with('customer');

        if ($search = $request->query('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('phone', 'like', "%$search%");
            });
        }

        return $query->orderBy('name')->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'customer_id' => 'nullable|exists:customers,id',
        ]);

        return Territory::create($validated);
    }

    /**
     * Display the specified resource.
     */
    public function show(Territory $territory)
    {
        return $territory->load('customer');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Territory $territory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'customer_id' => 'nullable|exists:customers,id',
        ]);

        $territory->update($validated);
        return $territory->load('customer');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Territory $territory)
    {
        $territory->delete();
        return response()->noContent();
    }
}
