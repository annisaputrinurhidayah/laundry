@extends('layouts.main',['title'=>'Laporan'])
@section('content')
<x-content :title="[
    'name'=>'Laporan',
    'icon'=>'fas fa-print'
    ]">
    <div class="row">
        <div class="col-md-4">
            <form action="{{ route('laporan.harian') }}" class="card card-info" target="_blank">
                <div class="card-header">
                    Laporan Harian
                </div>
                <div class="card-body">
                    @csrf
                    <x-input type="date" name="tanggal" label="Tanggal" />
                    <x-select label="Outlet" name="outlet_id" :data-option="$outlets" />
                </div>
                <div class="card-footer">
                    <button class="btn btn-info" type="submit">
                        Generate Laporan
                    </button>
                </div>
            </form>
        </div>
        <div class="col-md-4">
            <form action="{{ route('laporan.perbulan') }}" class="card card-info" target="_blank">
                <div class="card-header">
                    Laporan Per-bulan
                </div>
                <div class="card-body">
                    @csrf
                   <div class="row">
                        <div class="col">
                            <x-select label="Bulan" name="bulan" :data-option="$bulan"/>
                        </div>
                        <div class="col">
                            <x-select label="Tahun" name="tahun" :data-option="$tahun"/>
                        </div>
                   </div>
                   <x-select label="Outlet" name="outlet_id" :data-option="$outlets"/>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-info">
                        Generate Laporan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-content>
@endsection
