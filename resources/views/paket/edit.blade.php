@extends('layouts.main',['title' => 'Paket'])
@section('content')
    <x-content :title="[
        'name'=>'Paket',
        'icon'=>'fas fa-cubes',
    ]">
    <div class="row">
        <div class="col-md-6">
            <form action="{{ route('paket.update',['paket'=>$paket->id]) }}" class="card card-info" method="POST">
                <div class="card-header">
                    <h3 class="card-title">Edit Paket</h3>
                </div>
                <div class="card-body">
                    @csrf
                    @method('put')
                    <x-input label="Nama Paket" name="nama_paket" :value="$paket->nama_paket"/>
                        <x-select name="discount_type" label="Tipe Diskon" :value="$paket->discount_type" id="diskonType" :data-option="[
                            ['option' => 'Fixed', 'value' => 'fixed'],
                            ['option' => 'Persen', 'value' => 'percent'],
                        ]" />

                        <div class="row">
                            <div class="col-6">
                                <x-input label="Harga" name="harga" id="harga" :value="$paket->harga"/>
                            </div>
                            <div class="col-6">
                                <x-input label="Diskon" name="diskon" id="diskon" type="number" :value="$paket->diskon"/>
                            </div>
                        </div>
                        <x-input label="Harga Setelah Diskon" name="harga_diskon" id="hargaSetelahDiskon" type="number" :value="$paket->harga_diskon" readonly/>
                        <x-select label="Jenis" name="jenis" :data-option="[
                            ['option' => 'Kiloan', 'value' => 'kiloan'],
                            ['option' => 'T-Shirt/Kaos', 'value' => 'kaos'],
                            ['option' => 'Bed Cover', 'value' => 'bed_cover'],
                            ['option' => 'Selimut', 'value' => 'selimut'],
                            ['option' => 'Lainnya', 'value' => 'lain'],
                        ]" :value="$paket->jenis"/>
                        <x-select label="Outlet" name="outlet_id" :data-option="$outlets" :value="$paket->outlet_id" />
                    </div>
                <div class="card-footer">
                    <x-btn-update />
                </div>
            </form>
        </div>
    </div>
    </x-content>
@endsection
@push('js')
<script>
    $(document).ready(function() {
        $('#harga, #diskon, #diskonType').on('input', function() {
            var harga = parseInt($('#harga').val());
            var diskon = parseInt($('#diskon').val());
            var diskonType = $('#diskonType').val();

            if (diskonType === 'fixed') {
                var diskonValue = diskon;
            } else if (diskonType === 'percent') {
                var diskonValue = diskon / 100 * harga;
            } else {
                var diskonValue = 0;
            }
            var hargaSetelahDiskon = harga - diskonValue;

            $('#hargaSetelahDiskon').val(hargaSetelahDiskon);
        });
    });

</script>
@endpush
