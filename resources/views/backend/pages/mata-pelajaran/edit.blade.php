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
            <form action="{{ route('mata.pelajaran.update',$data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-6 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title text-center">Edit</h4>
                            <hr>
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Kode Mata Pelajaran</label>
                                        <input type="text" class="form-control" value="{{ $data->kode_mapel }}" name="kode_mapel" required placeholder="Kode Mata Pelajaran..">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Nama Mata Pelajaran</label>
                                        <input type="text" class="form-control" value="{{ $data->nama_mapel }}" name="nama_mapel" required placeholder="Nama Mata Pelajaran..">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Kelas</label>
                                        <select name="id_kelas" class="form-control" id="">
                                            <option value="" selected disabled>Pilih Kelas</option>
                                            @foreach ($kelas as $item)
                                                <option value="{{ $item->id }}" {{ $item->id == $data->id_kelas ? 'selected' : '' }} >Kelas {{ $item->nama_kelas }} {{ $item->jenis_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Guru</label>
                                        <select name="id_guru" class="form-control" id="" required>
                                            <option value="" selected disabled>Pilih Guru</option>
                                            @foreach ($guru as $g)
                                                <option value="{{ $g->id }}" {{ $g->id == $data->id_guru ? 'selected' : '' }}>{{ $g->nama }}</option>
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
