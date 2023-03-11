@extends('layouts.main',['title' => 'Member'])
@section('content')
    <x-content :title="[
        'name'=>'Member',
        'icon'=>'fas fa-users',
    ]">
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('member.store') }}" class="card card-info" method="POST" enctype="multipart/form-data">
                <div class="card-header">
                    <h3 class="card-title">Buat Member</h3>
                </div>
                <div class="card-body">
                    @csrf
                    <x-input label="Nama Member" name="nama" />

                    <x-select label=" Kelamin" name="jenis_kelamin" :data-option="[
                        ['value'=>'L','option'=>'Laki-laki'],
                        ['value'=>'P','option'=>'Perempuan'],
                    ]" />
                    <x-input label="File Foto/Gambar" name="file_foto" type="file" />
                    <x-input label="Telepon" name="tlp" type="number"/>
                    <x-textarea label="Alamat" name="alamat" />
                </div>
                <div class="card-footer">
                    <x-btn-submit />
                </div>
            </form>
        </div>
    </div>
    </x-content>
@endsection

