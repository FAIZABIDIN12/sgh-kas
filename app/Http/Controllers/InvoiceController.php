<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::all();
        return view('invoice', compact('invoices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tamu' => 'required|string|max:255',
            'tgl_checkin' => 'required|date',
            'tgl_checkout' => 'required|date',
            'pax' => 'required|integer',
            'tagihan' => 'required|numeric',
            'sp' => 'required|string|max:255',
        ]);

        try {
            Invoice::create([
                'nama_tamu' => $request->nama_tamu,
                'tgl_checkin' => $request->tgl_checkin,
                'tgl_checkout' => $request->tgl_checkout,
                'pax' => $request->pax,
                'tagihan' => $request->tagihan,
                'sp' => $request->sp,
                'fo' => 'Rosad', // Default value for FO
            ]);

            return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('invoices.index')->with('error', 'Failed to create invoice.');
        }
    }
}
