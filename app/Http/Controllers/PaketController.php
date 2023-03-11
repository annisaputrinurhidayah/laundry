<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use App\Models\Paket;
use Illuminate\Http\Request;
use App\Models\LogActivity;

class PaketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $pakets = Paket::join('outlets','outlets.id','pakets.outlet_id')
        ->when($search, function ($query, $search) {
            return $query->where('nama_paket', 'like', "%{$search}%");
        })
        ->select(
            'pakets.id as id',
            'nama_paket',
            'harga',
            'harga_diskon',
            'discount_type',
            'jenis',
            'diskon',
            'outlets.nama as outlet',
        )
        ->orderBy('id','desc')
        ->paginate();


        if ($search) {
            $pakets->appends(['search' => $search]);
        }

        // $discount_type = [
        //     'fixed' => 'Fixed',
        //     'percent' => 'Persen'
        // ];

        $jenis = [
            'kiloan' => 'Kiloan',
            'kaos' => 'T-Shirt/Kaos',
            'bed_cover' => 'Bed Cover',
            'selimut' => 'Selimut',
            'lain' => 'Lainnya',
        ];

        $pakets->map(function ($row) use ($jenis) {
            $row->jenis = $jenis[$row->jenis];
            // $row->discount_type = $discount_type[$row->discount_type];
            $row->harga = number_format($row->harga, 0, ',', '.');
            $row->diskon = number_format($row->diskon, 0, ',', '.');
            $row->harga_diskon = number_format($row->harga_diskon, 0, ',', '.');
            return $row;
        });

        return view('paket.index', ['pakets'=>$pakets,]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $outlets = Outlet::select('id as value', 'nama as option')->get();
        return view('paket.create',[
            'outlets' => $outlets,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_paket' => 'required|max:100|unique:pakets,nama_paket,',
            'harga' => 'required|numeric|min:0',
            'jenis' => 'required|in:kiloan,selimut,bed_cover,kaos,lain',
            'discount_type' => 'nullable|in:fixed,percent',
            'diskon' => 'nullable|numeric|min:0',
            'harga_diskon' => 'nullable|numeric',
            'outlet_id' => 'required|exists:outlets,id',

        ], [], [
            'outlet_id' => 'Outlet',
        ]);

        if ($request->discount_type == 'percent') {
            $request->validate([
                'diskon' => 'required|numeric|between:0,100',
            ]);
        }

        // $harga = $request->harga;
        // $diskon = $request->diskon;
        // $harga_diskon = $harga * (100 - $diskon) / 100;

        Paket::create([
            'nama_paket'=> $request->nama_paket,
            'discount_type' => $request->discount_type,
            'harga' => $request->harga,
            'diskon' => $request->diskon,
            'harga_diskon' => $request->harga_diskon,
            'jenis' => $request->jenis,
            'outlet_id' => $request->outlet_id,
        ]);

        LogActivity::add('berhasil menambahkan paket');

        return redirect()->route('paket.index')->with('message', 'success store');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(Outlet $outlet)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(Paket $paket)
    {
        $outlets = Outlet::select('id as value', 'nama as option')->get();
        return view('paket.edit',[
            'paket' => $paket,
            'outlets' => $outlets,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Paket $paket)
    {
        $request->validate([
            'nama_paket' => 'required|max:100|unique:pakets,nama_paket,'.$paket->id,
            'harga' => 'required|numeric',
            'jenis' => 'required|in:kiloan,selimut,bed_cover,kaos,lain',
            'diskon' => 'nullable|numeric',
            'discount_type' => 'nullable|in:fixed,percent',
            'harga_diskon' => 'required|numeric',
            'outlet_id' => 'required|exists:outlets,id',

        ], [], [
            'outlet_id' => 'Outlet',
        ]);

        if ($request->discount_type == 'percent') {
            $request->validate([
                'diskon' => 'required|numeric|between:0,100',
            ]);
        }

        // $harga = $request->harga;
        // $diskon = $request->diskon;
        // $harga_diskon = $harga * (100 - $diskon) / 100;

        $paket->update([
            'nama_paket'=> $request->nama_paket,
            'discount_type' => $request->discount_type,
            'harga' => $request->harga,
            'diskon' => $request->diskon,
            'harga_diskon' => $request->harga_diskon,
            'jenis' => $request->jenis,
            'outlet_id' => $request->outlet_id,
        ]);

         LogActivity::add('berhasil mengupdate paket');
        return redirect()->route('paket.index')->with('message', 'success update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Paket $paket)
    {
        $paket->delete();
        LogActivity::add('berhasil menghapus paket');
        return back()->with('message', 'success delete');
    }
}
