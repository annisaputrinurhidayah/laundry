<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Outlet;
use Image;
use Illuminate\Validation\Rules\Password;
use App\Models\LogActivity;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->search;
        $users = User::join('outlets', 'outlets.id','users.outlet_id')
        ->when($search, function ($query, $search) {
            return $query->where('users.nama', 'like', "%{$search}%")
                ->orWhere('username', 'like', "%{$search}%");
        })
        ->select(
            'users.id as id',
            'users.nama as nama',
            'username',
            'foto',
            'role',
            'outlets.nama as outlet'

        )
        ->paginate();

        $users->map(function($row) {
            $row->foto = asset("images/{$row->foto}");
        });


        if ($search) {
            $users->appends(['search' => $search]);
        }
        return view('user.index', ['users'=>$users,]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $outlets = Outlet::select('id as value', 'nama as option')->get();
        return view('user.create',[
            'outlets' => $outlets
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
            'nama' => 'required|max:100',
            'username' => 'required|max:100|unique:users',
            'file_foto'=>'required|image|max:2000',
            'role' => 'required|in:admin,kasir,owner',
            'outlet_id' => 'required|exists:outlets,id',
            'password' => 'required|max:100|confirmed'
            // 'password' => [
            //     'required',
            //     'string',
            //     Password::min(8)
            //     ->mixedCase()
            //     ->numbers()
            //     ->symbols()
            //     ->uncompromised(),
            //     'confirmed'
            // ]
        ], [], [
            'outlet_id' => 'Outlet',
        ]);


        $folder = 'images';
        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
        }
        $file = $request->file('file_foto');
        $ext = $file->getClientOriginalExtension();
        $filename = date('Ymdhis').'.'.$ext;
        $img = Image::make($file);
        $img->fit(300,200);
        $img->save($folder.'/'.$filename);

        $request->merge([
            'password' => bcrypt($request->password),
            'foto'=>$filename,
        ]);

        LogActivity::add('berhasil menambahkan user');
        user::create($request->all());
        return redirect()->route('user.index')->with('message', 'success store');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function show(user $user)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $outlets = Outlet::select('id as value', 'nama as option')->get();
        $user->foto = asset("images/{$user->foto}");
        return view('user.edit',[
            'user'=>$user,
            'outlets' => $outlets
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, user $user)
    {
        $request->validate([
            'nama' => 'required|max:100',
            'username' => 'required|max:100|unique:users,username,'.$user->id,
            'role' => 'required|in:admin,kasir,owner',
            'outlet_id' => 'required|exists:outlets,id',
            'password' => 'nullable|max:100|confirmed'
            // 'password' => [
            //     'nullable',
            //     'string',
            //     Password::min(8)
            //     ->mixedCase()
            //     ->numbers()
            //     ->symbols()
            //     ->uncompromised(),
            //     'confirmed'
            // ]
        ], [], [
            'outlet_id' => 'Outlet',
        ]);

        if ($request->file_foto){

            $folder = 'images';
            $foto_lama = "{$folder}/{$user->foto}";
            if (file_exists($foto_lama)){
                unlink($foto_lama);
            }
            $file = $request->file('file_foto');
            $ext = $file->getClientOriginalExtension();
            $filename = date('Ymdhis').'.'.$ext;
            $img = Image::make($file);
            $img->fit(300,200);
            $img->save($folder.'/'.$filename);

            $request->merge([
                'foto'=>$filename,
            ]);
        }

        if ($request->password) {
            $request->merge([
                'password' => bcrypt($request->password),
            ]);
            $user->update($request->all());
        } else {
            $user->update($request->except('password'));
        }


        LogActivity::add('berhasil mengupdate user');
        return redirect()->route('user.index')->with('message', 'success update');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\user  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $folder = 'images';
        $foto_lama = "{$folder}/{$user->foto}";

        if (file_exists($foto_lama)){
            unlink($foto_lama);
        }
        $user->delete();
        LogActivity::add('berhasil menghapus user');
        return back()->with('message', 'success delete');
    }
}
