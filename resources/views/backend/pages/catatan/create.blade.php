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
            color: black;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 10px;
        }
    </style>

    <div class="main-content-inner">
        <form action="" method="get" class="form-jadwal">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                            <label class="mt-2" for="jenis">Jadwal Mata Pelajaran</label>
                            <select name="jadwal" class="form-control" id="" required onchange="$('.form-jadwal').submit()">
                                <option value="" selected disabled>Pilih Jadwal Mata Pelajaran</option>
                                @foreach ($jadwal as $item)
                                    <option value="{{ $item->id }}" {{ Request::get('jadwal') == $item->id ? 'selected' : '' }}>{{ $item->mapel->nama_mapel }} |
                                        Kelas
                                        {{ $item->mapel->kelas->nama_kelas ?? '-' }}
                                        {{ $item->mapel->kelas->jenis_kelas ?? '-' }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
        @if (Request::get('jadwal') != null)
            @if (!empty($siswa))
                <div class="row">
                    <form action="{{ route('catatan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-12 mt-2">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title text-center">Tambah</h4>
                                    <hr>

                                    <div class="row">
                                        <div class="col-lg-12">
                                            <input type="hidden" name="id_jadwal" value="{{ Request::get('jadwal') }}">
                                            <div class="form-group col-md-12">
                                                <label class="mt-2" for="jenis">Judul</label>
                                                <input type="text" class="form-control" name="judul" placeholder="Judul Catatan.." required>
                                            </div>
                                            <div class="form-group col-md-12">
                                                <label class="mt-2" for="jenis">Tanggal</label>
                                                <input type="date" class="form-control" name="tanggal"  required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="table-responsive mt-3">
                                        <h4 class="header-title text-center">Daftar Siswa</h4>
                                        <hr>

                                        @include('backend.layouts.partials.messages')
                                        <table id="dataTable" class="table text-center">
                                            <thead class="bg-light text-capitalize">
                                                <tr>
                                                    <th>No</th>
                                                    <th>NISN</th>
                                                    <th>Nama Siswa</th>
                                                    <th>Kelas</th>
                                                    <th>Catatan</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($siswa as $index => $item)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $item->nisn }}</td>
                                                        <td>{{ $item->nama }}</td>
                                                        <td>Kelas {{ $item->kelas->nama_kelas ?? '-' }} {{ $item->kelas->jenis_kelas ?? '' }}</td>
                                                        <td>
                                                            <input type="hidden" name="id_siswa[]" value="{{ $item->id }}">
                                                            <textarea name="catatan[{{ $item->id }}]" class="form-control" id=""></textarea>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                    <button class="btn btn-primary mt-4 mb-4" style="float: right" type="submit">Simpan Data</button>

                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            @else
                <center>
                    <h5 class="mt-4" >Tidak ada data siswa!</h5>
                </center>
            @endif
        @else
            <center>
                <h5 class="mt-4" >Pilih Jadwal Pelajaran terlebih dahulu!</h5>
            </center>
        @endif
       
    </div>
    <script type="text/javascript" src="https://jeremyfagis.github.io/dropify/dist/js/dropify.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://jeremyfagis.github.io/dropify/dist/css/dropify.min.css">

    <script>
        // Initialize Dropify
        $('.dropify').dropify();

        // Add new Dropify input
        $('#add-row').on('click', function() {
            const newRow = `
        <div class="dropify-row mb-2">
            <button type="button" class="btn btn-danger btn-sm remove-row" style="float: right">-</button>
            <input type="file" name="foto_deviasi[]" class="form-control" data-height="200" accept="image/*" />
        </div>
    `;
            $('#dropify-wrapper').append(newRow);

            // Reinitialize only new Dropify elements
            $('#dropify-wrapper .dropify').each(function() {
                if (!$(this).hasClass('dropify-initialized')) {
                    $(this).dropify();
                }
            });
        });


        // Remove Dropify input
        $('#dropify-wrapper').on('click', '.remove-row', function() {
            $(this).closest('.dropify-row').remove();
        });
    </script>
@endsection
