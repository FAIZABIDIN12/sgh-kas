<?php

namespace App\Http\Controllers;

use App\Models\CashFlow;
use App\Models\CashType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Imports\CashTypesImport;
use Maatwebsite\Excel\Facades\Excel;

class CashFlowController extends Controller
{
    public function index(Request $request)
    {
        $currentPage = $request->input('page', 1);

        $perPage = 10;

        $saldoAwal = CashFlow::where('tanggal', '<', now())
            ->orderBy('tanggal', 'asc')
            ->take(($currentPage - 1) * $perPage)
            ->get()
            ->reduce(function ($carry, $cashFlow) {
                return $carry + ($cashFlow->cashType->jenis === 'masuk' ? $cashFlow->nominal : -$cashFlow->nominal);
            }, 0);

        $cashFlows = CashFlow::orderBy('tanggal', 'desc')->paginate($perPage);
        return view('index', compact('cashFlows', 'saldoAwal'));
    }

    public function editCashFlow($id)
    {
        $data = CashFlow::findOrFail($id);
        $cashTypes = CashType::all();
        return view('edit-cash-flow', compact('data', 'cashTypes'));
    }
    public function updateCashFlow(Request $request, $id)
    {
        $data = CashFlow::findOrFail($id);
        $request->validate([
            'uraian' => 'required|string|max:255',
            'jenis' => 'required',
            'rp' => 'required|string'
        ]);

        $nominal = (float) str_replace(',', '.', str_replace('.', '', str_replace('Rp.', '', $request->rp)));

        $data->update([
            'uraian' => $request->input('uraian'),
            'cash_type_id' => $request->input('jenis'),
            'nominal' => $nominal
        ]);

        return redirect()->route('cashFlow.edit', $id)->with('success', 'Data berhasil diubah.');
    }


    public function destroyCashFlow($id)
    {
        $data = CashFlow::findOrFail($id);
        $data->delete();
        return redirect()->route('dashboard')->with('success', 'Data berhasil dihapus.');
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

        $user = $request->user()->id;

        CashFlow::create([
            'tanggal' => $request->tanggal,
            'uraian' => $request->uraian,
            'cash_type_id' => $request->jenis, // Menyimpan jenis
            'nominal' => $masuk,
            'user_id' => $user, // Adjust as needed
        ]);

        return redirect()->route('dashboard')->with('success', 'Data kas masuk berhasil ditambahkan');
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

        $user = $request->user()->id;

        CashFlow::create([
            'tanggal' => $request->tanggal,
            'uraian' => $request->uraian,
            'cash_type_id' => $request->jenis,
            'nominal' => $keluar,
            'user_id' => $user,
        ]);


        return redirect()->route('dashboard')->with('success', 'Data kas keluar berhasil ditambahkan');
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
            'keterangan' => 'required|string'
        ]);

        CashType::create($validated);

        return redirect()->back()->with('success', 'Berhasil menambahkan data.');
    }

    public function editTypeCash($id)
    {
        $data = CashType::findOrFail($id);
        return view('edit-jenis-kas', compact('data'));
    }
    public function updateTypeCash(Request $request, $id)
    {
        $data = CashType::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => ['required', Rule::in(['masuk', 'keluar'])],
        ]);

        $data->update([
            'nama' => $request->input('nama'),
            'jenis' => $request->input('jenis'),
        ]);

        return redirect()->route('typecash.edit', $data->id)->with('success', 'Data berhasil diubah.');
    }

    public function destroyTypeCash($id)
    {
        $data = CashType::findOrFail($id);
        $data->delete();
        return redirect()->route('typecash')->with('success', 'Data berhasil dihapus.');
    }

    public function importCashType(Request $request)
    {
        $request->validate([
            'file' => 'required|max:2048',
        ]);

        Excel::import(new CashTypesImport, $request->file('file'));
        return back()->with('success', 'Cashflow imported successfully.');
    }
}
