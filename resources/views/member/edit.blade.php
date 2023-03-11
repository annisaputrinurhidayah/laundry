@extends('layouts.main',['title' => 'Member'])
@section('content')
    <x-content :title="[
        'name'=>'Member',
        'icon'=>'fas fa-users',
    ]">
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('member.update',['member'=>$member->id]) }}" class="card card-info" method="POST" enctype="multipart/form-data">
                <div class="card-header">
                    <h3 class="card-title">Edit Member</h3>
                </div>
                <div class="card-body">
                    @csrf
                    @method('put')
                    <x-input label="Nama Member" name="nama" :value="$member->nama"/>

                    <x-select label=" Kelamin" name="jenis_kelamin" :value="$member->jenis_kelamin" :data-option="[
                        ['value'=>'L','option'=>'Laki-laki'],
                        ['value'=>'P','option'=>'Perempuan'],
                    ]" />
                        <img src="{{ $member->foto }}" class="img-fluid" |>
                     <x-input label="File Foto/Gambar" name="file_foto" type="file" />
                    <x-input label="Telepon" name="tlp" :value="$member->tlp" type="number"/>
                    <x-textarea label="Alamat" name="alamat" :value="$member->alamat"/>
                </div>
                <div class="card-footer">
                    <x-btn-update />
                </div>
            </form>
        </div>
    </div>
    </x-content>
@endsection
