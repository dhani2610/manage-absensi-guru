@extends('backend.layouts-new.app')

@section('content')
    <style>
        .create-new {
            display: none;
        }
    </style>
    @include('backend.layouts.partials.messages')

    <div class="row">
        <!-- Customer-detail Sidebar -->
        @include('backend.pages.profile.partials.sidebar')
        <!--/ Customer Sidebar -->

        <!-- Customer Content -->
        <div class="col-xl-8 col-lg-7 col-md-7 order-0 order-md-1">
            <!-- Customer Pills -->
            @include('backend.pages.profile.partials.tabs')
            <div class="col-xl-12">
                <div class="card mb-4">
                    <h5 class="card-header">Change Password</h5>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                           
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label class="mt-2" for="jenis">Foto</label>
                                    <input type="file" accept="image/*" class="form-control" value="" name="foto">
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="mt-2" for="jenis">Fullname</label>
                                    <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->name ?? '' }}" name="name" required placeholder="Fullname..">
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="mt-2" for="jenis">Email</label>
                                    <input type="email" class="form-control" value="{{ Auth::guard('admin')->user()->email ?? '' }}" name="email" required placeholder="Email..">
                                </div>
                                <div class="form-group col-md-12">
                                    <label class="mt-2" for="jenis">Username</label>
                                    <input type="text" class="form-control" value="{{ Auth::guard('admin')->user()->username ?? '' }}" name="username" required placeholder="Username..">
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary me-2 mt-2">Update Profile</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

        </div>
        <!--/ Customer Content -->
    </div>
@endsection

@section('script')
    <script>
        function showLampiranEdit(fileExist) {
            $('#pdfViewer').attr('src', fileExist);
            $('#previewModal').modal('show');
        }
    </script>
@endsection
