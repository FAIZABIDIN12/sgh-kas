<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel; // Import Excel facade
use App\Models\Invoice;
use App\Imports\InvoicesImport; // Sesuaikan dengan nam
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
        $user = $request->user()->name;
        try {
            Invoice::create([
                'nama_tamu' => $request->nama_tamu,
                'tgl_checkin' => $request->tgl_checkin,
                'tgl_checkout' => $request->tgl_checkout,
                'pax' => $request->pax,
                'tagihan' => $request->tagihan,
                'sp' => $request->sp,
                'fo' => $user,
            ]);

            return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('invoices.index')->with('error', 'Failed to create invoice.');
        }
    }

    public function import(Request $request)
    {
        $request->validate([
            'excel_file' => 'required|mimes:xls,xlsx',
        ]);

        try {
            $file = $request->file('excel_file');
            Excel::import(new InvoicesImport, $file);
            return redirect()->route('invoices.index')->with('success', 'Data berhasil diimpor.');
        } catch (\Exception $e) {
            return redirect()->route('invoices.index')->with('error', 'Failed to import data from Excel. Error: ' . $e->getMessage());
        }
    }
}
