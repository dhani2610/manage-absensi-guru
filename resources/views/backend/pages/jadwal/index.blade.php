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
                        <h4 class="header-title float-left">Data {{ $page_title }}</h4>
                        @if ($usr->can('jadwal.create'))
                            <p class="float-right mb-2">
                                <a href="{{ route('jadwal.create') }}" class="btn btn-primary text-white mb-3">
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
                                        <th>Mata Pelajaran</th>
                                        <th>Jam Mulai</th>
                                        <th>Jam Selesai</th>
                                        <th>Hari</th>
                                        @if ($usr->can('jadwal.edit') || $usr->can('jadwal.delete'))
                                            <th>Aksi</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->mapel->nama_mapel }}</td>
                                            <td>{{ $item->jam_mulai }}</td>
                                            <td>{{ $item->jam_akhir }}</td>
                                            <td>{{ $item->hari }}</td>
                                            @if ($usr->can('jadwal.edit') || $usr->can('jadwal.delete'))
                                                <td>
                                                    @if ($usr->can('jadwal.edit'))
                                                        <a href="{{ route('jadwal.edit', $item->id) }}"
                                                            class="btn btn-success text-white">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endif
                                                    @if ($usr->can('jadwal.delete'))
                                                        <a onclick="confirmDelete('{{ route('jadwal.destroy', $item->id) }}')"
                                                            class="btn btn-danger text-white">
                                                            <i class="fa-solid fa-trash"></i>
                                                        </a>
                                                    @endif
                                                </td>
                                            @endif

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
