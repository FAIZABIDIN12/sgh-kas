<?php

namespace App\Http\Controllers;

use App\Models\CashFlow;
use App\Models\CashType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class CashFlowController extends Controller
{
    public function index()
    {
        $cashFlows = CashFlow::all();
        return view('index', compact('cashFlows'));
    }

    public function createMasuk()
    {
        $inCashs = CashType::where('jenis', 'masuk')->get();
        return view('kas-masuk', compact('inCashs'));
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
            'cash_type_id' => $request->jenis, // Menyimpan jenis
            'masuk' => $masuk,
            'keluar' => 0,
            'saldo' => $saldo,
            'fo' => 'Faiz Kurohap', // Adjust as needed
        ]);

        return redirect()->route('cashflows.index')->with('success', 'Data kas masuk berhasil ditambahkan');
    }

    public function createKeluar()
    {
        $outCashs = CashType::where('jenis', 'keluar')->get();
        return view('kas-keluar', compact('outCashs'));
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
            'cash_type_id' => $request->jenis,
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
        $cashTypeGroup = CashType::where(DB::raw('LOWER(nama)'), 'like', '%group%')->get();
        $searchTerms = ['dp', 'group'];
        $cashTypeGroupDp = CashType::where(function ($query) use ($searchTerms) {
            foreach ($searchTerms as $term) {
                $query->where(DB::raw('LOWER(nama)'), 'like', '%' . strtolower($term) . '%');
            }
        })->get();
        $ids = $cashTypeGroup->pluck('id');
        $dpIds = $cashTypeGroupDp->pluck('id');


        $groupCashFlows = CashFlow::whereIn('cash_type_id', $ids)->get();
        $groupDpCashFlows = CashFlow::whereIn('cash_type_id', $dpIds)->get();

        $totalDeposit = $groupDpCashFlows->sum('masuk');
        $totalPendapatan = $groupCashFlows->sum('masuk');

        return view('kas-masuk-group', compact('groupCashFlows', 'totalDeposit', 'totalPendapatan'));
    }

    public function showReport()
    {
        $transactions = CashFlow::all();
        $cashTypes = CashType::all();

        $groupedCashTypes = $cashTypes->groupBy('jenis');
        return view('lap-akun', compact('transactions', 'groupedCashTypes'));
    }

    public function manageTypeCash()
    {
        $cashTypes = CashType::orderBy('id', 'desc')->paginate(10);

        return view('jenis-kas', compact('cashTypes'));
    }

    public function storeTypeCash(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => ['required', Rule::in(['masuk', 'keluar'])],
        ]);

        CashType::create($validated);

        return redirect()->back()->with('success', 'Berhasil menambahkan data.');
    }
}
