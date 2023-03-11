<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\LogActivity;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.profile',['user'=>$user]);
    }

    public function update(Request $request)
    {

        $user = Auth::user();
        $request->validate([
            'nama'=>'required|between:3,255',
            'password'=>[
                'nullable',
                'string',
                Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()
                ->uncompromised(),
                'confirmed'
            ]
        ]);

        if($request->password) {
            $request->merge([
                'password'=>bcrypt($request->password)
            ]);
            $user->update($request->all());
        } else{
            $user->update($request->only('nama'));
        }

        LogActivity::add('berhasil mengupdate profile');
        return back()->with('message','success update');
    }
}
