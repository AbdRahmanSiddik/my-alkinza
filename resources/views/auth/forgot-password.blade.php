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
          <form action="{{ route('password.email') }}" method="POST">
            @csrf
            <div class="card">
              <div class="card-body p-5">
                <div class="login-userheading">
                  <h3>Lupa kata sandi?</h3>
                  <h4>Jika Anda lupa kata sandi, kami akan mengirimkan instruksi untuk mereset kata sandi Anda melalui email.</h4>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <div class="mb-3">
                  <label class="form-label" for="email">Email <span class="text-danger"> *</span></label>
                  <div class="input-group">
                    <input type="text" value="{{ old('email') }}" name="email" id="email"
                      class="form-control border-end-0">
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
                <div class="form-login">
                  <button type="submit" class="btn btn-login">Sign Up</button>
                </div>

                <div class="form-setlogin or-text mb-2">
                  <h4 class="mx-2">ATAU</h4>
                </div>
                <div class="signinform text-center">
                  <h4>Kembali ke <a href="{{ route('login') }}" class="hover-a">login</a></h4>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="my-4 d-flex justify-content-center align-items-center copyright-text">
          <p>Copyright &copy; 2025 <a href="https://xplode.site/">rahmanSDK</a></p>
        </div>
      </div>
    </div>
  </div>
</x-guest-layout>
