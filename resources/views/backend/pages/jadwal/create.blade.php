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
        <div class="row">
            <form action="{{ route('jadwal.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-6 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title text-center">Tambah</h4>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Mata Pelajaran</label>
                                        <select name="id_mapel" class="form-control" id="" required>
                                            <option value="" selected disabled>Pilih Mata Pelajaran</option>
                                            @foreach ($mapel as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama_mapel }} | Kelas {{ $item->kelas->nama_kelas ?? '-' }} {{ $item->kelas->jenis_kelas ?? '-' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Jam Mulai</label>
                                        <input type="time" class="form-control" name="jam_mulai" placeholder="Jam Mulai.." required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Jam Akhir</label>
                                        <input type="time" class="form-control" name="jam_akhir" placeholder="Jam Akhir.." required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Hari</label>
                                        <select name="hari" class="form-control" id="hari" required >
                                            <option value="" selected disabled>Pilih Hari</option>
                                            @php
                                                $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat','Sabtu','Minggu'];
                                            @endphp
                                            @foreach ($hari as $item)
                                                <option value="{{ $item }}" >{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <button class="btn btn-primary mt-4" type="submit">Simpan Data</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
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
