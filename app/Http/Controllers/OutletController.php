<?php

namespace App\Http\Controllers;

use App\Models\Outlet;
use Illuminate\Http\Request;
use App\Models\LogActivity;

class OutletController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $outlets = Outlet::when($search, function ($query, $search) {
            return $query->where('users.nama', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%");
        })
        ->paginate();


        if ($search) {
            $outlets->appends(['search' => $search]);
        }
        return view('outlet.index', ['outlets'=>$outlets,]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('outlet.create');
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
            'nama' => 'required|max:100|unique: outlets,nama',
            'tlp' => 'required|max:20',
            'alamat' => 'required|max:250',

        ], [], [
            'tlp' => 'Telepon',
        ]);

        LogActivity::add('berhasil menambahkan outlet');
        Outlet::create($request->all());

        return redirect()->route('outlet.index')->with('message', 'success store');
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
    public function edit(Outlet $outlet)
    {
        return view('outlet.edit',['outlet'=>$outlet]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Outlet $outlet)
    {
        $request->validate([
            'nama' => 'required|max:100|unique:outlets,nama,'.$outlet->id,
            'tlp' => 'required|max:20',
            'alamat' => 'required|max:250',

        ], [], [
            'tlp' => 'Telepon',
        ]);
       $outlet->update($request->all());
       LogActivity::add('berhasil mengupdate outlet');
        return redirect()->route('outlet.index')->with('message', 'success update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Outlet $outlet)
    {
        $outlet->delete();
        LogActivity::add('berhasil menghapus outlet');
        return back()->with('message', 'success delete');
    }
}
