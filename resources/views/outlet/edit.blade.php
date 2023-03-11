@extends('layouts.main',['title' => 'Outlet'])
@section('content')
    <x-content :title="[
        'name'=>'Outlet',
        'icon'=>'fas fa-store-alt',
    ]">
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('outlet.update',['outlet'=>$outlet->id]) }}" class="card card-info" method="POST">
                <div class="card-header">
                    <h3 class="card-title">Edit Outlet</h3>
                </div>
                <div class="card-body">
                    @csrf
                    @method('put')
                    <x-input label="Nama" name="nama" :value="$outlet->nama"/>
                    <x-input label="Telepon" name="tlp" :value="$outlet->tlp" type="number"/>
                    <x-textarea label="Alamat" name="alamat" :value="$outlet->alamat"/>
                </div>
                <div class="card-footer">
                    <x-btn-update />
                </div>
            </form>
        </div>
    </div>
    </x-content>
@endsection
