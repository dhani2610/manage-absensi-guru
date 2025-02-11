@extends('backend.layouts-new.app')

@section('content')
    <style>
        .form-check-label {
            text-transform: capitalize;
        }

        .select2 {
            width: 100% !important;
        }

        label {
            float: left;
        }
    </style>
    @php
        $usr = Auth::guard('admin')->user();
    @endphp

    <div class="main-content-inner">
        <div class="row">
            <!-- data table start -->
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title float-left">Data Catatan Siswa</h4>
                        @if ($usr->can('catatan.create'))
                            <p class="float-right mb-2">
                                <a href="{{ route('catatan.create') }}" style="float: right" class="btn btn-primary text-white mb-3">
                                    Tambah Data
                                </a>
                            </p>
                        @endif

                        <div class="clearfix"></div>
                        <div class="table-responsive">
                            @include('backend.layouts.partials.messages')
                            <table id="dataTable" class="table text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th>No</th>
                                        <th>Guru</th>
                                        <th>Judul</th>
                                        <th>Jadwal</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                {{ $item->jadwal->mapel->guru->nama ?? '' }}
                                            </td>
                                            <td>{{ $item->judul }}</td>
                                            <td style="text-align: left">{{ $item->jadwal->mapel->nama_mapel ?? '' }} <br>
                                                Kelas
                                                {{ $item->jadwal->mapel->kelas->nama_kelas . ' ' . $item->jadwal->mapel->kelas->jenis_kelas . ' (' . $item->jadwal->jam_mulai . ' s/d ' . $item->jadwal->jam_akhir . ')' }}
                                            </td>
                                            <td>{{ $item->tanggal }}</td>
                                            <td>
                                                @if ($usr->can('catatan.edit'))
                                                    <a href="{{ route('catatan.edit', $item->id) }}"
                                                        class="btn btn-success text-white">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endif
                                                @if ($usr->can('catatan.delete'))
                                                    <a onclick="confirmDelete('{{ route('catatan.destroy', $item->id) }}')"
                                                        class="btn btn-danger text-white">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!-- data table end -->
        </div>
    </div>
@endsection

@section('script')
    <script>
        function confirmDelete(deleteUrl) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: "btn btn-success",
                    cancelButton: "btn btn-danger"
                },
                buttonsStyling: false
            });

            swalWithBootstrapButtons.fire({
                title: "Are you sure you want to delete this data?",
                text: "This action cannot be undone!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        }
    </script>
@endsection
