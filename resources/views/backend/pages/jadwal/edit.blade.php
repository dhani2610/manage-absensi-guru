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
            <form action="{{ route('jadwal.update',$data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-6 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title text-center">Edit</h4>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Mata Pelajaran</label>
                                        <select name="id_mapel" class="form-control" id="" required>
                                            <option value="" selected disabled>Pilih Mata Pelajaran</option>
                                            @foreach ($mapel as $item)
                                                <option value="{{ $item->id }}" {{ $item->id == $data->id_mapel ? 'selected' : '' }} >{{ $item->nama_mapel }} | Kelas {{ $item->kelas->nama_kelas ?? '-' }} {{ $item->kelas->jenis_kelas ?? '-' }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Jam Mulai</label>
                                        <input type="time" class="form-control" value="{{ $data->jam_mulai }}" name="jam_mulai" placeholder="Jam Mulai.." required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Jam Akhir</label>
                                        <input type="time" class="form-control" value="{{ $data->jam_akhir }}" name="jam_akhir" placeholder="Jam Akhir.." required>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Hari</label>
                                        <select name="hari" class="form-control" id="hari" required >
                                            <option value="" selected disabled>Pilih Hari</option>
                                            @php
                                                $hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat','Sabtu','Minggu'];
                                            @endphp
                                            @foreach ($hari as $h)
                                                <option value="{{ $h }}" {{ $h == $data->hari ? 'selected' : '' }}>{{ $h }}</option>
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
@endsection
