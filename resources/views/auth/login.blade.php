<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Chakra Giri Energi Indonesia</title>

  <!-- Custom fonts for this template-->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{asset('../assets/css')}}/sb-admin-2.min.css" rel="stylesheet">
  <style>
    .background-login {
      max-width: 100%;
      max-height: 100%;
      background-position: center;
      background-size: cover;
    }
  </style>
</head>

<body class="background-login" style="
background-image: url('../assets/img/sumberenergi.jpg');">

  <div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

      <div class="col-md-6 ">

        <div class="card o-hidden border-0 shadow-lg my-5">
          <div class="card-body ">
            <!-- Nested Row within Card Body -->
            <div class=" row">
              <div class="col">
                <div class="p-5">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4"> Sistem Pendukung Keputusan</h1>
                    <h1 class="h4 text-gray-900 mb-4"> Pemilihan Tribe Kampus Merdeka</h1>
                  </div>

                  <div class="text-center">
                    <img src="{{asset('../assets/img')}}/chakra.png" style="width: 50%;" />
                  </div>
                  <br />
                  <form  method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                      <input type="email" class="form-control form-control-user" name="email"
                        aria-describedby="emailHelp" placeholder="email...">
                    </div>
                    <div class="form-group">
                      <input type="password" class="form-control form-control-user" name="password"
                        placeholder="Password">
                    </div>

                    <button type="submit" class="btn btn-primary btn-user btn-block">
                      Login
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </div>

  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

</body>

</html>