<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CucianController extends Controller
{
    public function updateStatus(Request $request)
    {
        $kg = $request->kg;
        $status = $request->status;

        // TODO: Update database sesuai logika aplikasi
        // Misal:
        // Cucian::where('berat', $kg)->update(['status' => $status]);

        return response()->json(['success' => true]);
    }
}
