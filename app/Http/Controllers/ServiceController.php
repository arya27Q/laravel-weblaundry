<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    
    public function store(Request $request)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'unit' => 'required|in:Kg,Pcs',
            'price' => 'required|numeric|min:0',
            'estimation' => 'nullable|string|max:100'
        ]);

        Service::create($request->all());

        return redirect()->back()->with('success', 'Layanan baru berhasil ditambahkan!');
    }

    
    public function update(Request $request, $id)
    {
        $request->validate([
            'service_name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'estimation' => 'nullable|string|max:100'
        ]);

        $service = Service::findOrFail($id);
        
       
        $service->update($request->only(['service_name', 'price', 'estimation']));

        return redirect()->back()->with('success', 'Data layanan berhasil diperbarui!');
    }

    
    public function destroy($id)
    {
        $service = Service::findOrFail($id);
        $service->delete();

        return redirect()->back()->with('success', 'Layanan berhasil dihapus!');
    }
}