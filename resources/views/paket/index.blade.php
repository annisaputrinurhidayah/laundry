@extends('layouts.main', ['title' => 'Paket'])
@section('content')
    <x-content :title="[
        'name' => 'Paket',
        'icon' => 'fas fa-cubes',
    ]">
        @if (session('message') == 'success store')
            <x-alert-success />
        @endif
        @if (session('message') == 'success update')
            <x-alert-success type="update" />
        @endif
        @if (session('message') == 'success delete')
            <x-alert-success type="delete" />
        @endif

        <div class="card card-outline card-info">
            <div class="card-header form-inline">
                <x-btn-add href="{{ route('paket.create') }}" />
                <x-search />
            </div>
            <div class="card-body p-0">
                <table class="table table-striped table-hover m-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Paket</th>
                            <th>Jenis</th>
                            <th>Harga Pokok</th>
                            <th>Diskon</th>
                            <th>Harga Total</th>
                            <th>Tipe Diskon</th>
                            <th>Outlet</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = $pakets->firstItem();
                        ?>
                        @foreach ($pakets as $paket)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $paket->nama_paket }}</td>
                                <td>{{ $paket->jenis }}</td>
                                <td>{{ $paket->harga }}</td>
                               <td>
                                    @if ($paket->discount_type == 'percent')
                                    ({{ $paket->diskon }}%)
                                    @else
                                    {{ $paket->diskon }}
                                @endif
                               </td>
                                {{-- <td>{{ $paket->diskon }}</td> --}}
                                <td>{{ $paket->harga_diskon }}
                                    </td>
                                <td>{{ $paket->discount_type }}</td>
                                <td>{{ $paket->outlet }}</td>
                                <td class="text-right">
                                    <x-edit href="{{ route('paket.edit', ['paket' => $paket->id]) }}" />
                                    <x-delete data-name="{{ $paket->nama_paket }}" data-url="{{ route('paket.destroy', ['paket' => $paket->id]) }}" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
                {{ $pakets->links('page') }}
            </div>
        </div>
    </x-content>
@endsection
@push('modal')
    <x-modal-delete />
@endpush
