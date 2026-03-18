{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                <div class="max-w-xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout> --}}

<x-admin-panel>
  <div class="page-header">
    <div class="page-title">
      <h4>Profile</h4>
      <h6>User Profile</h6>
    </div>
  </div>
  <!-- /product list -->
  <div class="card">
    <div class="card-header">
      <h4>Profile</h4>
    </div>
    <div class="card-body profile-body">
      <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PATCH')
        <h5 class="mb-2"><i class="ti ti-user text-primary me-1"></i>Basic Information</h5>
        <div class="profile-pic-upload image-field">
          <div class="profile-pic p-2">
            <img class="object-fit-cover h-100 rounded-1" id="preview-image" alt="user" data-cfsrc="{{ asset(Auth::user()->avatar) }}"
              style="display:none;visibility:hidden;"><noscript><img src="{{ asset(Auth::user()->avatar) }}" id="preview-image"
                class="object-fit-cover h-100 rounded-1" alt="user"></noscript>
            <button type="button" class="close rounded-1">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="mb-3">
            <div class="image-upload mb-0 d-inline-flex">
              <input type="file" name="file" id="upload-image" upload-image accept="image/*">
              <div class="btn btn-primary fs-13">Change Image</div>
            </div>
            <p class="mt-2">Upload an image below 2 MB, Accepted File format JPG, PNG</p>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 col-sm-12">
            <div class="mb-3">
              <label class="form-label">User Name<span class="text-danger ms-1">*</span></label>
              <input type="text" class="form-control" name="name" value="{{ Auth::user()->name }}">
            </div>
          </div>
          <div class="col-lg-6 col-sm-12">
            <div class="mb-3">
              <label>Email<span class="text-danger ms-1">*</span></label>
              <input type="email" class="form-control" name="email" value="{{ Auth::user()->email }}">
            </div>
          </div>

          <div class="col-12 d-flex justify-content-end">
            <button type="reset" class="btn btn-secondary me-2 shadow-none">Cancel</button>
            <button type="submit" class="btn btn-primary shadow-none">Simpan Perubahan</button>
          </div>
        </div>
      </form>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <h4>Ubah Password</h4>
    </div>
    <div class="card-body profile-body">
      <form action="{{ route('password.update') }}" method="POST">
        @csrf
        @method('PUT')
        <div class="col-lg-6 col-sm-12">
          <div class="mb-3">
            <label class="form-label">Password Sekarang<span class="text-danger ms-1">*</span></label>
            <div class="pass-group">
              <input type="password" name="current_password" class="pass-input form-control">
              <i class="ti ti-eye-off toggle-password"></i>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-lg-6 col-sm-12">
            <div class="mb-3">
              <label class="form-label">Password Baru<span class="text-danger ms-1">*</span></label>
              <div class="pass-group">
                <input type="password" name="password" class="pass-inputs form-control">
                <i class="ti ti-eye-off toggle-passwords"></i>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-sm-12">
            <div class="mb-3">
              <label class="form-label">Konfirmasi Password<span class="text-danger ms-1">*</span></label>
              <div class="pass-group">
                <input type="password" name="password_confirmation" class="pass-inputa form-control">
                <i class="ti ti-eye-off toggle-passworda"></i>
              </div>
            </div>
          </div>
        </div>
        <div class="col-12 d-flex justify-content-end">
            <button type="reset" class="btn btn-secondary me-2 shadow-none">Cancel</button>
            <button type="submit" class="btn btn-primary shadow-none">Simpan Perubahan</button>
          </div>
      </form>
    </div>
  </div>
  <!-- /product list -->
  <script>
  document.getElementById('upload-image').addEventListener('change', function (event) {
    const imagePreview = document.getElementById('preview-image');
    const file = event.target.files[0];

    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = function (e) {
        imagePreview.src = e.target.result;
      };
      reader.readAsDataURL(file);
    }
  });
</script>

</x-admin-panel>
