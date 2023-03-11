@extends('layouts.main',['title' => 'User'])
@section('content')
<x-content :title="[
    'name'=>'User',
    'icon'=>'fas fa-users',
]">
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('user.update',['user'=>$user->id]) }}" class="card card-info" method="POST" enctype="multipart/form-data">
                <div class="card-header">
                    <h3 class="card-title">Edit User</h3>
                </div>
                <div class="card-body">
                    @csrf
                    @method('put')
                    <x-input label="Nama" name="nama" :value="$user->nama"/>
                    <x-input label="Username" name="username" :value="$user->username"/>
                        <img src="{{ $user->foto }}" class="img-fluid" |>
                    <x-input label="File Foto/Gambar" name="file_foto" type="file" />
                    <x-select label="Role" name="role" :value="$user->role" :data-option="[['value'=>'kasir','option'=>'Kasir'], ['value'=>'owner','option'=>'Pemilik'],['value'=>'admin','option'=>'Administrator'],]" />
                    <x-select label="Outlet" name="outlet_id" :data-option="$outlets" :value="$user->outlet_id" />
                    <x-input label="Password" name="password" type="password"/>
                    <x-input label="Password Confirmation" name="password_confirmation" type="password"/>
                </div>
                <div class="card-footer">
                    <x-btn-update />
                </div>
            </form>
        </div>
    </div>
    </x-content>
@endsection
