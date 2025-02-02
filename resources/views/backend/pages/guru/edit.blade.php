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
            <form action="{{ route('guru.update',$data->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="col-12 mt-5">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title text-center">Edit</h4>
                            <hr>
                            <div class="row">
                                <div class="col-lg-6">
                                    <h5>Data Guru</h5>
                                    <hr>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Kode Guru</label>
                                        <input type="text" class="form-control" value="{{ $data->kode_guru }}" name="kode_guru" required placeholder="Kode Guru..">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Nama Guru</label>
                                        <input type="text" class="form-control" value="{{ $data->nama }}" name="nama" required placeholder="Nama Guru..">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">NIDN</label>
                                        <input type="text" class="form-control" value="{{ $data->nidn }}" name="nidn" required placeholder="NIDN Guru..">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <h5>Account Setting</h5>
                                    <hr>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Email</label>
                                        <input type="email" class="form-control" value="{{ $data->user->email ?? '' }}" name="email" required placeholder="Email Guru..">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Username</label>
                                        <input type="text" class="form-control" value="{{ $data->user->username ?? '' }}" name="username" required placeholder="Username Guru..">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label class="mt-2" for="jenis">Password Baru</label>
                                        <input type="text" class="form-control" value="" name="password" placeholder="Password Baru Guru..">
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
