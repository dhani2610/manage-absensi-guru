@extends('backend.layouts-new.app')

@section('content')
    <style>
        .create-new {
            display: none;
        }
        .alert-warning{
            background-color: #f6b425!important;
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
            <!-- Timeline Advanced-->
            <div class="col-xl-12">
                <div class="card mb-4">
                    <h5 class="card-header">Change Password</h5>
                    <div class="card-body">
                        <form id="formChangePassword" method="POST">
                            @csrf
                            <div class="alert alert-warning" role="alert">
                                <h6 class="alert-heading mb-1">Pastikan persyaratan ini terpenuhi</h6>
                                <span>Panjang minimal 8 karakter, huruf besar & simbol</span>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                                    <label class="form-label" for="newPassword">Password Baru</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control" type="password" id="newPassword" name="newPassword"
                                            placeholder="············">
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-show"></i></span>
                                    </div>
                                    <div id="newPasswordError" class="text-danger"></div>
                                </div>

                                <div class="mb-3 col-12 col-sm-6 form-password-toggle">
                                    <label class="form-label" for="confirmPassword">Konfirmasi Password Baru</label>
                                    <div class="input-group input-group-merge">
                                        <input class="form-control" type="password" name="confirmPassword"
                                            id="confirmPassword" placeholder="············">
                                        <span class="input-group-text cursor-pointer"><i class="bx bx-show"></i></span>
                                    </div>
                                    <div id="confirmPasswordError" class="text-danger"></div>
                                </div>
                                <div>
                                    <button type="submit" class="btn btn-primary me-2">Update Password</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
            <!-- /Timeline Advanced-->


        </div>
        <!--/ Customer Content -->
    </div>
@endsection

@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('formChangePassword').addEventListener('submit', function(event) {
                event.preventDefault();

                // Clear previous errors
                document.getElementById('newPasswordError').textContent = '';
                document.getElementById('confirmPasswordError').textContent = '';

                // Get form values
                const newPassword = document.getElementById('newPassword').value;
                const confirmPassword = document.getElementById('confirmPassword').value;

                // Validate new password
                const passwordError = validatePassword(newPassword);

                if (passwordError) {
                    document.getElementById('newPasswordError').textContent = passwordError;
                    return;
                }

                // Check if passwords match
                if (newPassword !== confirmPassword) {
                    document.getElementById('confirmPasswordError').textContent = 'Password tidak sama.';
                    return;
                }

                // If validation passes, send AJAX request
                $.ajax({
                    url: '{{ route('profile.proses-change-password') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        newPassword: newPassword,
                        confirmPassword: confirmPassword
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Password berhasil diupdate.',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.reload(); // Reload to reflect changes
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Gagal update password.',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        alert('An error occurred. Please try again.');
                    }
                });
            });

            function validatePassword(password) {
                if (password.length < 8) {
                    return 'Password harus terdiri dari minimal 8 karakter.';
                }
                if (!/[A-Z]/.test(password)) {
                    return 'Password harus mengandung setidaknya satu huruf besar.';
                }
                if (!/[@$!%*?&]/.test(password)) {
                    return 'Password harus mengandung setidaknya satu simbol.';
                }
                return null;
            }
        });
    </script>
@endsection