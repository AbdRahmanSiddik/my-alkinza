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
          <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="card">
              <div class="card-body p-5">
                <div class="login-userheading text-center">
                  <h3>Sign In</h3>
                  <h4>Akses panel Al-Kinza menggunakan email/username dan kata sandi Anda.</h4>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <div class="mb-3">
                  <label for="email" class="form-label">Email / Username <span class="text-danger"> *</span></label>
                  <div class="input-group">
                    <input type="text" name="email" id="email" class="form-control border-end-0">
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
                  <label for="password" class="form-label">Password <span class="text-danger"> *</span></label>
                  <div class="pass-group">
                    <input type="password" name="password" id="password" class="pass-input form-control">
                    <span class="ti toggle-password ti-eye-off text-gray-9"></span>
                  </div>
                  <small class="text-danger">
                    @error('password')
                      {{ $message }}
                    @enderror
                  </small>
                </div>
                <div class="form-login authentication-check">
                  <div class="row">
                    <div class="col-12 d-flex align-items-center justify-content-between">
                      <div class="custom-control custom-checkbox">
                        <label for="remember_me" class="checkboxs ps-4 mb-0 pb-0 line-height-1 fs-16 text-gray-6">
                          <input type="checkbox" name="remember_me" id="remember_me" class="form-control">
                          <span class="checkmarks"></span>Remember me
                        </label>
                      </div>
                      @if (Route::has('password.request'))
                        <div class="text-end">
                          <a class="text-orange fs-16 fw-medium" href="{{ route('password.request') }}">Forgot
                            Password?</a>
                        </div>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="form-login">
                  <button type="submit" class="btn btn-login">Sign In</button>
                </div>
                <div class="form-setlogin or-text">
                  <h4 class="mx-2 mb-3">ATAU</h4>
                </div>
                <div class="signinform">
                  <h4>Belum punya akun ? <a href="{{ route('register') }}" class="hover-a">Daftarkan akun sekarang</a></h4>
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
          <p>Copyright &copy; 2025 <a href="https://xplode.site/">RahmanSDK</a></p>
        </div>
      </div>
    </div>
  </div>

</x-guest-layout>
