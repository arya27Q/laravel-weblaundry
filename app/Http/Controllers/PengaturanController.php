<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\Service;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PengaturanController extends Controller
{
    public function index(): View
    {
        
        $setting = Setting::firstOrCreate(['id' => 1]);
        $services = Service::all();

        return view('pages.pengaturan', compact('setting', 'services'));
    }

    public function updateProfil(Request $request): RedirectResponse
    {
        /** @var \App\Models\Setting $setting */
        $setting = Setting::findOrFail(1);
        
        $setting->update($request->only(['nama_laundry', 'whatsapp', 'alamat']));

        return back()->with('success', 'Profil Laundry berhasil diperbarui!');
    }

    public function storeLayanan(Request $request): RedirectResponse
    {
        $request->validate([
            'service_name' => 'required|string',
            'unit'         => 'required',
            'price'        => 'required|numeric',
            'estimation'   => 'required',
        ]);

        Service::create([
            'service_name' => $request->service_name,
            'unit'         => $request->unit,
            'price'        => $request->price,
            'estimation'   => $request->estimation,
        ]);

        return back()->with('success', 'Layanan baru berhasil ditambahkan!');
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => 'required',
            'new_password'     => 'required|min:8|confirmed',
        ]);

        /** @var \App\Models\User $user */
        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Password saat ini salah!');
        }

        $user->update(['password' => Hash::make($request->new_password)]);

        return back()->with('success', 'Password berhasil diganti!');
    }
}