<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tambah Akun</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="../assets/css/styles.min.css" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">
    <div class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
      <div class="d-flex align-items-center justify-content-center w-100">
        <div class="row justify-content-center w-100">
          <div class="col-md-8 col-lg-6 col-xxl-4">
            <div class="card mb-0">
              <div class="card-body">
                <div class="text-nowrap logo-img text-center d-block py-3 w-100">
                  <img src="{{ asset('assets/images/logos/logo-main.png') }}" width="180" alt="">
                </div>
                <form>
                  <div class="mb-3">
                    <label for="namaInput" class="form-label">Nama</label>
                    <input type="text" name="nama" class="form-control" id="namaInput" aria-describedby="namaHelp">
                  </div>
                  <div class="mb-3">
                    <label for="usernameInput" class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" id="usernameInput" aria-describedby="usernameHelp">
                  </div>
                  <div class="mb-3">
                    <label for="userType" class="form-label">Type User</label>
                    <select id="userType" name="jenis-user" class="form-select">
                      <option>Front Office</option>
                      <option>Admin</option>
                      <option>Accounting</option>
                      <option>Manager</option>
                    </select>
                  </div>
                  <div class="mb-4">
                    <label for="passwordInput" class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" id="passwordInput">
                  </div>

                  <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign Up</button>
                  <div class="d-flex align-items-center justify-content-center">
                    <p class="fs-4 mb-0 fw-bold">Already have an Account?</p>
                    <a class="text-primary fw-bold ms-2" href="{{ url('login') }}">Sign In</a>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script src="../assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="../assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>