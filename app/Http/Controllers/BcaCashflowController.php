<?php

namespace App\Http\Controllers;

use App\Models\BcaCashflow;
use App\Models\BcaCashType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\BcaCashTypesImport;
use App\Imports\BcaCashFlowsImport;
use Carbon\Carbon;

class BcaCashflowController extends Controller
{
    public function index()
    {
        $cashFlows = BcaCashflow::orderBy('tanggal', 'asc')->get();
        $saldo = 0;

        foreach ($cashFlows as $cashFlow) {
            $cashFlow->tanggal = Carbon::parse($cashFlow->tanggal);
            if ($cashFlow->bcaCashType->jenis == "masuk") {
                $saldo += $cashFlow->nominal;
            } elseif ($cashFlow->bcaCashType->jenis == "keluar") {
                $saldo -= $cashFlow->nominal;
            }
            $cashFlow->saldo = $saldo;
        }

        return view('bca_cashflows.index', compact('cashFlows'));
    }

    public function createMasuk()
    {
        $inCashs = BcaCashType::where('jenis', 'masuk')->get();
        return view('bca_cashflows.form-masuk', compact('inCashs'));
    }

    public function storeMasuk(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'uraian' => 'required|string',
            'nominal' => 'required|string',
        ]);

        $nominalCleaned = str_replace(['Rp.', '.'], '', $request->nominal);
        $user = $request->user()->id;
        BcaCashflow::create([
            'tanggal' => $request->tanggal,
            'uraian' => $request->uraian,
            'bca_cash_type_id' => $request->jenis,
            'nominal' => $nominalCleaned,
            'user_id' => $user,
        ]);

        return redirect()->route('bca_cashflows.index')->with('success', 'Kas masuk BCA berhasil ditambahkan.');
    }


    public function createKeluar()
    {
        $outCashs = BcaCashType::where('jenis', 'keluar')->get();
        return view('bca_cashflows.form-keluar', compact('outCashs'));
    }

    public function storeKeluar(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'uraian' => 'required|string',
            'nominal' => 'required|string',
        ]);

        $nominalCleaned = str_replace(['Rp.', '.'], '', $request->nominal);
        $user = $request->user()->id;
        BcaCashflow::create([
            'tanggal' => $request->tanggal,
            'uraian' => $request->uraian,
            'bca_cash_type_id' => $request->jenis,
            'nominal' => $nominalCleaned,
            'user_id' => $user,
        ]);

        return redirect()->route('bca_cashflows.index')->with('success', 'Kas keluar BCA berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $data = BcaCashFlow::findOrFail($id);
        $cashTypes = BcaCashType::all();
        return view('bca_cashflows.edit', compact('data', 'cashTypes'));
    }
    public function update(Request $request, $id)
    {
        $data = BcaCashFlow::findOrFail($id);
        $request->validate([
            'uraian' => 'required|string|max:255',
            'jenis' => 'required',
            'rp' => 'required|string'
        ]);

        $nominal = (float) str_replace(',', '.', str_replace('.', '', str_replace('Rp.', '', $request->rp)));

        $data->update([
            'uraian' => $request->input('uraian'),
            'bca_cash_type_id' => $request->input('jenis'),
            'nominal' => $nominal
        ]);

        return redirect()->route('bca_cashflows.index', $id)->with('success', 'Data berhasil diubah.');
    }

    public function BcaCashFlowsUpload()
    {
        return view('bca_cashflows.upload');
    }

    public function BcaCashFlowsImport(Request $request)
    {
        $request->validate([
            'file' => 'required|max:2048',
        ]);

        Excel::import(new BcaCashFlowsImport, $request->file('file'));
        return back()->with('success', 'Cash flows berhasil diimport.');
    }

    public function CashType()
    {
        $cashTypes = BcaCashType::orderBy('id', 'desc')->paginate(10);

        return view('bca_cashflows.cash-type', compact('cashTypes'));
    }
    public function CashTypeStore(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => ['required', Rule::in(['masuk', 'keluar'])],
            'keterangan' => 'required|string'
        ]);

        BcaCashType::create($validated);

        return redirect()->back()->with('success', 'Berhasil menambahkan data.');
    }
    public function CashTypeDestroy($id)
    {
        $data = BcaCashType::findOrFail($id);
        $data->delete();
        return redirect()->route('bca_cashflows.type')->with('success', 'Data berhasil dihapus.');
    }
    public function CashTypeImport(Request $request)
    {
        $request->validate([
            'file' => 'required|max:2048',
        ]);

        Excel::import(new BcaCashTypesImport, $request->file('file'));
        return back()->with('success', 'Jenis kas berhasil diimport.');
    }

    public function CashTypeEdit($id)
    {
        $data = BcaCashType::findOrFail($id);
        return view('bca_cashflows.cash-type-edit', compact('data'));
    }

    public function CashTypeUpdate(Request $request, $id)
    {
        $data = BcaCashType::findOrFail($id);
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => ['required', Rule::in(['masuk', 'keluar'])],
        ]);

        $data->update([
            'nama' => $request->input('nama'),
            'jenis' => $request->input('jenis'),
        ]);

        return redirect()->route('bca_cashflows.type.edit', $data->id)->with('success', 'Data berhasil diubah.');
    }
}
