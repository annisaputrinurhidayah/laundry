@extends('layouts.main',['title' => 'Outlet'])
@section('content')
    <x-content :title="[
        'name'=>'Outlet',
        'icon'=>'fas fa-store-alt',
    ]">
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('outlet.store') }}" class="card card-info" method="POST">
                <div class="card-header">
                    <h3 class="card-title">Buat Outlet</h3>
                </div>
                <div class="card-body">
                    @csrf
                    <x-input label="Nama" name="nama" />
                    <x-input label="Telepon" name="tlp" type="number"/>
                    <x-textarea label="Alamat" name="alamat"/>
                </div>
                <div class="card-footer">
                    <x-btn-submit />
                </div>
            </form>
        </div>
    </div>
    </x-content>
@endsection

