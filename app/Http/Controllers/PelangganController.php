<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    public function index()
    {
        $customers = Customer::latest()->get();
        return view('pages.pelanggan', compact('customers'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone', 
            'address' => 'required|string'
        ]);

        Customer::create($request->all());
        return redirect()->back()->with('success', 'Pelanggan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20|unique:customers,phone,' . $id,
            'address' => 'required|string'
        ]);

        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return redirect()->back()->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return redirect()->back()->with('success', 'Pelanggan berhasil dihapus!');
    }
}