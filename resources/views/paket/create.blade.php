@extends('layouts.main', ['title' => 'Paket'])
@section('content')
    <x-content :title="[
        'name' => 'Paket',
        'icon' => 'fas fa-cubes',
    ]">
        <div class="row">
            <div class="col-md-6">
                <form action="{{ route('paket.store') }}" class="card card-info" method="POST">
                    <div class="card-header">
                        <h3 class="card-title">Buat Paket</h3>
                    </div>
                    <div class="card-body">
                        @csrf
                        <x-input label="Nama Paket" name="nama_paket" />
                        <x-select name="discount_type" label="Tipe Diskon" id="diskonType" :data-option="[
                            ['option' => 'Fixed', 'value' => 'fixed'],
                            ['option' => 'Persen', 'value' => 'percent'],
                        ]" />

                        <div class="row">
                            <div class="col-6">
                                <x-input label="Harga" name="harga" id="harga" />
                            </div>
                            <div class="col-6">
                                <x-input label="Diskon" name="diskon" id="diskon" type="number" />
                            </div>
                        </div>
                        <x-input label="Harga Setelah Diskon" name="harga_diskon" id="hargaSetelahDiskon" type="number"
                            readonly />
                        <x-select label="Jenis" name="jenis" :data-option="[
                            ['option' => 'Kiloan', 'value' => 'kiloan'],
                            ['option' => 'T-Shirt/Kaos', 'value' => 'kaos'],
                            ['option' => 'Bed Cover', 'value' => 'bed_cover'],
                            ['option' => 'Selimut', 'value' => 'selimut'],
                            ['option' => 'Lainnya', 'value' => 'lain'],
                        ]" />

                        <x-select label="Outlet" name="outlet_id" :data-option="$outlets" />
                    </div>
                    <div class="card-footer">
                        <x-btn-submit />
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

                if (hargaSetelahDiskon < 0) {
                    $('#hargaSetelahDiskon').val('');
                    alert('Diskon tidak boleh melebihi harga.');
                    $('button[type="submit"]').attr('disabled', true);
                    return;
                }
                $('#hargaSetelahDiskon').val(hargaSetelahDiskon);
                $('button[type="submit"]').attr('disabled', false);

                $('#hargaSetelahDiskon').val(hargaSetelahDiskon);
            });
        });
    </script>
@endpush
