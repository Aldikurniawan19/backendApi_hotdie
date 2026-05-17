<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * Get all addresses for the authenticated user.
     */
    public function index(Request $request)
    {
        $addresses = $request->user()->addresses()->orderByDesc('is_default')->latest()->get();

        return response()->json([
            'status' => 'success',
            'data'   => ['addresses' => $addresses],
        ], 200);
    }

    /**
     * Store a new address.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'label'    => 'required|string|max:50',
            'street'   => 'required|string|max:255',
            'area'     => 'nullable|string|max:255',
            'city'     => 'required|string|max:255',
            'pin_code' => 'nullable|string|max:20',
            'state'    => 'required|string|max:255',
            'mobile'   => 'required|string|max:20',
            'is_default' => 'boolean',
        ]);

        // If this is set as default, unset others
        if ($request->is_default) {
            $request->user()->addresses()->update(['is_default' => false]);
        }

        $address = $request->user()->addresses()->create($request->only([
            'name', 'label', 'street', 'area', 'city', 'pin_code', 'state', 'mobile', 'is_default',
        ]));

        return response()->json([
            'status'  => 'success',
            'message' => 'Alamat berhasil ditambahkan',
            'data'    => ['address' => $address],
        ], 201);
    }

    /**
     * Update an address.
     */
    public function update(Request $request, Address $address)
    {
        // Ensure user owns this address
        if ($address->user_id !== $request->user()->id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $request->validate([
            'name'     => 'sometimes|string|max:255',
            'label'    => 'sometimes|string|max:50',
            'street'   => 'sometimes|string|max:255',
            'area'     => 'nullable|string|max:255',
            'city'     => 'sometimes|string|max:255',
            'pin_code' => 'nullable|string|max:20',
            'state'    => 'sometimes|string|max:255',
            'mobile'   => 'sometimes|string|max:20',
            'is_default' => 'boolean',
        ]);

        if ($request->is_default) {
            $request->user()->addresses()->where('id', '!=', $address->id)->update(['is_default' => false]);
        }

        $address->update($request->only([
            'name', 'label', 'street', 'area', 'city', 'pin_code', 'state', 'mobile', 'is_default',
        ]));

        return response()->json([
            'status'  => 'success',
            'message' => 'Alamat berhasil diperbarui',
            'data'    => ['address' => $address->fresh()],
        ], 200);
    }

    /**
     * Delete an address.
     */
    public function destroy(Request $request, Address $address)
    {
        if ($address->user_id !== $request->user()->id) {
            return response()->json(['status' => 'error', 'message' => 'Unauthorized'], 403);
        }

        $address->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Alamat berhasil dihapus',
        ], 200);
    }
}
