<?php

namespace App\Http\Controllers;

use App\Models\CashFlow;
use Illuminate\Http\Request;

class CashFlowController extends Controller
{
    public function index()
    {
        $cashFlows = CashFlow::all();
        return view('index', compact('cashFlows'));
    }

    public function createMasuk()
    {
        return view('kas-masuk');
    }

    public function storeMasuk(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|string|max:255',
            'uraian' => 'required|string|max:255',
            'rp' => 'required|string',
        ]);

        $masuk = (float) str_replace(',', '.', str_replace('.', '', str_replace('Rp.', '', $request->rp)));
        $saldo = CashFlow::latest()->first()?->saldo ?? 0;
        $saldo += $masuk;

        CashFlow::create([
            'tanggal' => $request->tanggal,
            'uraian' => $request->uraian,
            'jenis' => $request->jenis, // Menyimpan jenis
            'masuk' => $masuk,
            'keluar' => 0,
            'saldo' => $saldo,
            'fo' => 'Rosyad Siregar cita cita kapal Lawud', // Adjust as needed
        ]);

        return redirect()->route('cashflows.index')->with('success', 'Data kas masuk berhasil ditambahkan');
    }

    public function createKeluar()
    {
        return view('kas-keluar');
    }

    public function storeKeluar(Request $request)
    {
        $validatedData = $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|string|max:255',
            'uraian' => 'required|string|max:255',
            'rp' => 'required|string',
        ]);

        $keluar = str_replace('.', '', str_replace('Rp.', '', $request->rp));
        $keluar = (float) $keluar;
        $saldo = CashFlow::latest()->first()?->saldo ?? 0;
        $saldo -= $keluar;

        CashFlow::create([
            'tanggal' => $request->tanggal,
            'jenis' => $request->jenis,
            'uraian' => $request->uraian,
            'masuk' => 0,
            'keluar' => $keluar,
            'saldo' => $saldo,
            'fo' => 'Rosyad Siregar cita cita kapal Lawud', // Adjust as needed
        ]);

        return redirect()->route('cashflows.index')->with('success', 'Data kas keluar berhasil ditambahkan');
    }

    public function showGroup()
    {
        // Mendapatkan data kas masuk dengan jenis tertentu
        $groupCashFlows = CashFlow::whereIn('jenis', ['DP Tamu Group', 'Pendapatan Payment Group'])->get();

        // Debugging
        //  dd($groupCashFlows);
        // return dd($groupCashFlows, $groupCashFlows->count());

        // Menghitung total deposit dan pendapatan
        $totalDeposit = $groupCashFlows->where('jenis', 'DP Tamu Group')->sum('masuk');
        $totalPendapatan = $groupCashFlows->where('jenis', 'Pendapatan Payment Group')->sum('masuk');

        // Mengirim data ke view
        return view('kas-masuk-group', compact('groupCashFlows', 'totalDeposit', 'totalPendapatan'));
    }

    public function showReport()
    {
        // Ambil semua data transaksi
        $transactions = CashFlow::all();
        // Kirim data ke tampilan
        return view('lap-akun', compact('transactions'));
    }
}
