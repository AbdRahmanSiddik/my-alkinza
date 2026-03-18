<x-guest-layout>

  <div class="login-wrapper login-new">
    <div class="row w-100">
      <div class="col-lg-5 mx-auto">
        <div class="login-content user-login">
          <div class="login-logo">
            <img src="assets/img/logo.svg" alt="img">
            <a href="index.html" class="login-logo logo-white">
              <img src="assets/img/logo-white.svg" alt="Img">
            </a>
          </div>
          <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="card">
              <div class="card-body p-5">
                <div class="login-userheading text-center">
                  <h3>Register</h3>
                  <h4>Buat Akun Al-Kinza Baru</h4>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <div class="mb-3">
                  <label class="form-label" for="name">Username <span class="text-danger"> *</span></label>
                  <div class="input-group">
                    <input type="text" name="name" id="name" value="{{ old('name') }}" class="form-control border-end-0">
                    <span class="input-group-text border-start-0">
                      <i class="ti ti-user"></i>
                    </span>
                  </div>
                  <small class="text-danger">
                    @error('name')
                      {{ $message }}
                    @enderror
                  </small>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="email">Email <span class="text-danger"> *</span></label>
                  <div class="input-group">
                    <input type="text" name="email" id="email" value="{{ old('email') }}" class="form-control border-end-0">
                    <span class="input-group-text border-start-0">
                      <i class="ti ti-mail"></i>
                    </span>
                  </div>
                  <small class="text-danger">
                    @error('email')
                      {{ $message }}
                    @enderror
                  </small>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="password">Password <span class="text-danger"> *</span></label>
                  <div class="pass-group">
                    <input type="password" class="pass-input form-control" name="password" id="password">
                    <span class="ti toggle-password ti-eye-off text-gray-9"></span>
                  </div>
                  <small class="text-danger">
                    @error('password')
                      {{ $message }}
                    @enderror
                  </small>
                </div>
                <div class="mb-3">
                  <label class="form-label" for="password_confirmation">Konfirmasi Password <span class="text-danger">
                      *</span></label>
                  <div class="pass-group">
                    <input type="password" class="pass-inputs form-control" name="password_confirmation"
                      id="password_confirmation">
                    <span class="ti toggle-passwords ti-eye-off text-gray-9"></span>
                  </div>
                  <small class="text-danger">
                    @error('password_confirmation')
                      {{ $message }}
                    @enderror
                  </small>
                </div>
                <div class="form-login authentication-check">
                  <div class="row">
                    <div class="col-sm-8">
                      <div class="custom-control custom-checkbox justify-content-start">
                        <div class="custom-control custom-checkbox">
                          <label class="checkboxs ps-4 mb-0 pb-0 line-height-1" for="terms">
                            <input type="checkbox" required id="terms">
                            <span class="checkmarks"></span>Saya setuju dengan <a href="#" class="text-primary">Syarat & Privasi</a>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-login">
                  <button type="submit" class="btn btn-login">Sign Up</button>
                </div>
                <div class="form-setlogin or-text mb-2">
                  <h4 class="mx-2">ATAU</h4>
                </div>
                <div class="signinform">
                  <h4>Sudah punya akun? <a href="{{ route('login') }}" class="hover-a">Masuk di sini</a></h4>
                </div>

                {{-- <div class="mt-2">
                  <div class="d-flex align-items-center justify-content-center flex-wrap">
                    <div class="text-center me-2 flex-fill">
                      <a href="javascript:void(0);"
                        class="br-10 p-2 btn btn-info d-flex align-items-center justify-content-center">
                        <img class="img-fluid m-1" src="assets/img/icons/facebook-logo.svg" alt="Facebook">
                      </a>
                    </div>
                    <div class="text-center me-2 flex-fill">
                      <a href="javascript:void(0);"
                        class="btn btn-white br-10 p-2  border d-flex align-items-center justify-content-center">
                        <img class="img-fluid m-1" src="assets/img/icons/google-logo.svg" alt="Facebook">
                      </a>
                    </div>
                    <div class="text-center flex-fill">
                      <a href="javascript:void(0);"
                        class="bg-dark br-10 p-2 btn btn-dark d-flex align-items-center justify-content-center">
                        <img class="img-fluid m-1" src="assets/img/icons/apple-logo.svg" alt="Apple">
                      </a>
                    </div>
                  </div>
                </div> --}}
              </div>
            </div>
          </form>
        </div>
        <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
          <p>Copyright &copy; 2025 rahmanSDK</p>
        </div>
      </div>
    </div>
  </div>

</x-guest-layout>
