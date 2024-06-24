<?php

namespace App\Http\Controllers;

use App\Models\BcaCashflow;
use Illuminate\Http\Request;

class BcaCashflowController extends Controller
{
    public function index()
    {
        $inCashs = BcaCashflow::where('type', 'masuk')->get();
        $outCashs = BcaCashflow::where('type', 'keluar')->get();

        return view('bca_cashflows.index', compact('inCashs', 'outCashs'));
    }

    public function createMasuk()
    {
        return view('bca_cashflows.createMasuk');
    }

    public function storeMasuk(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'uraian' => 'required|string',
            'nominal' => 'required|string', // Ubah menjadi string
        ]);

        // Membersihkan nilai nominal dari 'Rp.' dan titik jika diperlukan
        $nominalCleaned = str_replace(['Rp.', '.'], '', $request->nominal);

        BcaCashflow::create([
            'tanggal' => $request->tanggal,
            'uraian' => $request->uraian,
            'nominal' => $nominalCleaned, // Simpan sebagai string
            'type' => 'masuk',
        ]);

        return redirect()->route('bca_cashflows.index')->with('success', 'Kas masuk BCA berhasil ditambahkan.');
    }


    public function createKeluar()
    {
        return view('bca_cashflows.createKeluar');
    }

    public function storeKeluar(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'uraian' => 'required|string',
            'nominal' => 'required|string',
        ]);

        // Membersihkan nilai nominal dari 'Rp.' dan titik
        $nominalCleaned = str_replace(['Rp.', '.'], '', $request->nominal);

        BcaCashflow::create([
            'tanggal' => $request->tanggal,
            'uraian' => $request->uraian,
            'nominal' => $nominalCleaned, // Simpan sebagai string yang sudah dibersihkan
            'type' => 'keluar',
        ]);

        return redirect()->route('bca_cashflows.index')->with('success', 'Kas keluar BCA berhasil ditambahkan.');
    }
}
