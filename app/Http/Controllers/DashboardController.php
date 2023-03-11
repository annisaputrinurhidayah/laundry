<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\Outlet;
use App\Models\Transaksi;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
   public function index()
   {
        $auth = Auth::user();
        $outlet_id = $auth->level == 'kasir' ? $auth->outlet_id : null;

        $user = User::select(DB::raw('count(id) as jumlah'))->first();
        $member = Member::select(DB::raw('count(id) as jumlah'))->first();
        $outlet = Outlet::select(DB::raw('count(id) as jumlah'))->first();

        $transaksi = Transaksi::where('dibayar', 'belum_bayar')
        ->select(DB::raw('count(id) as jumlah'))->first();

        $charts = Transaksi::where('dibayar', 'dibayar')
        ->when($outlet_id, function ($query, $outlet_id) {
            return $query->where('outlet_id', $outlet_id);
        })
        ->whereMonth('tgl', date('m'))
        ->select(
            DB::raw('DATE(tgl_bayar) as tanggal'),
            DB::raw('SUM(total_bayar) as jumlah')
        )
        ->groupBy('tanggal')
        ->get();

        $label = [];
        $jumlah =[];

        foreach ($charts as $chart) {
            $label[] = $chart->tanggal;
            $jumlah[] = $chart->jumlah;
        }

        $data = [
            'user' => $user,
            'member' => $member,
            'outlet' => $outlet,
            'transaksi' => $transaksi,
            'label' => $label,
            'jumlah' => $jumlah,
        ];

        return view('welcome', $data);
   }
}
