<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Transaksi;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\LogActivity;

class LaporanController extends Controller
{
    public function index()
    {
        $outlets = Outlet::select('id as value', 'nama as option')->get();

        $bulan = [
            ['value' => 1, 'option' => 'Januari'],
            ['value' => 2, 'option' => 'Februari'],
            ['value' => 3, 'option' => 'Maret'],
            ['value' => 4, 'option' => 'April'],
            ['value' => 5, 'option' => 'Mei'],
            ['value' => 6, 'option' => 'Juni'],
            ['value' => 7, 'option' => 'Juli'],
            ['value' => 8, 'option' => 'Agustus'],
            ['value' => 9, 'option' => 'September'],
            ['value' => 10, 'option' => 'Oktober'],
            ['value' => 11, 'option' => 'November'],
            ['value' => 12, 'option' => 'Desember'],
        ];

        $tahun = Transaksi::select(DB::raw('YEAR(tgl) tahun'))
        ->groupBy('tahun')
        ->get();

        $tahun->map(function ($row) {
            $row->option = $row->tahun;
            $row->value = $row->tahun;
        });

        return view('laporan.index', [
            'outlets' => $outlets,
            'bulan' => $bulan,
            'tahun' => $tahun,
        ]);
    }

    public function harian(Request $request)
    {

        $request->validate([
            'tanggal' => 'required|date_format:Y-m-d',
            'outlet_id' => 'required'
        ]);

        $outlet = Outlet::find($request->outlet_id);

        $data = Transaksi::join('users','users.id','transaksis.user_id')
        ->join('members','members.id','transaksis.member_id')
        ->where('dibayar','dibayar')
        ->where('transaksis.outlet_id', $request->outlet_id)
        ->whereDate('tgl', $request->tanggal)
        ->where('status', '!=', 'batal')
        ->select(
            'members.nama as nama',
            'users.nama as kasir',
            'total_bayar',
            'tgl',
        )
        ->get();

        LogActivity::add('berhasil membuat laporan harian');
        return view('laporan.harian', [
            'data' => $data,
            'outlet'=> $outlet
        ]);
    }

    public function perbulan(Request $request)
    {
        $request->validate([
            'bulan' => 'required|numeric|between:1,12',
            'tahun' => 'required|numeric|digits:4',
            'outlet_id' => 'required'
        ]);

        $outlet = Outlet::find($request->outlet_id);

        $data = Transaksi::where('dibayar','dibayar')
        ->whereMonth('tgl', $request->bulan)
        ->whereYear('tgl', $request->tahun)
        ->where('outlet_id', $request->outlet_id)
        ->where('status', '!=', 'batal')
        ->select(
            DB::raw('date(tgl) as tanggal'),
            DB::raw('sum(total_bayar) as jumlah'))
        ->groupBy('tanggal')
        ->get();

        LogActivity::add('berhasil membuat laporan bulanan');
        return view('laporan.perbulan', [
            'data' => $data,
            'outlet'=> $outlet
        ]);
    }
}
