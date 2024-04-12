
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SPK Tribe</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('../assets/vendor')}}/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('../assets/css')}}/sb-admin-2.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.css">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                
                <div class="sidebar-brand-text mx-3">SPK TRIBE</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item {{ Request::is('home') ? 'active' : '' }}">
                <a class="nav-link" href="/home">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>
            <li class="nav-item {{ Request::is('tribe*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('tribe.index') }}">
                    <i class="fas fa-list"></i>
                    <span>Tribe</span>
                </a>
            </li>

            <li class="nav-item {{ Request::is('kriteria*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('kriteria.index') }}">
                    <i class="fas fa-list"></i>
                    <span>Kriteria</span>
                </a>
            </li>
        
            <!-- Nav Item - Penilaian -->
            <li class="nav-item {{ Request::is('penilaian*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('penilaian.index') }}">
                    <i class="fas fa-edit"></i>
                    <span>Penilaian</span>
                </a>
            </li>
        
            {{-- <!-- Nav Item - Perhitungan -->
            <li class="nav-item {{ Request::is('perhitungan*') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('perhitungan.index') }}">
                    <i class="fas fa-calculator"></i>
                    <span>Perhitungan</span>
                </a>
            </li> --}}
            <!-- Nav Item - Perhitungan -->
          
        
            <!-- Nav Item - Riwayat -->
            <li class="nav-item {{ Request::is('riwayat-perhitungan') ? 'active' : '' }}">
                <a class="nav-link" href="{{ route('perhitungan.riwayat') }}">
                    <i class="fas fa-history"></i>
                    <span>Riwayat</span>
                </a>
            </li>


            <li class="nav-item {{ Request::is('perhitungan*') ? 'active' : '' }}">
                <a href="" class="nav-link">
                 <form action="{{ route('logout') }}" method="POST">
                     @csrf
                     <button class="dropdown-item" type="submit">
                         <i class="fas fa-calculator"></i>
                         <span>Logout</span>
                     </button>
                 </form>
                     </a> 
             </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    @yield('content')
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->


        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="login.html">Logout</a>
                </div>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <!-- Bootstrap core JavaScript-->
    <script src="{{asset('../assets/vendor')}}/jquery/jquery.min.{{asset('../assets/js')}}"></script>
    <script src="{{asset('../assets/vendor')}}/bootstrap/{{asset('../assets/js')}}/bootstrap.bundle.min.{{asset('../assets/js')}}"></script>

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>

    <script>
        $(document).ready( function () {
        $('#tableData').DataTable();
        } );
    </script>

    <!-- Core plugin JavaScript-->
    <script src="{{asset('../assets/vendor')}}/jquery-easing/jquery.easing.min.{{asset('../assets/js')}}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{asset('../assets/js')}}/sb-admin-2.min.{{asset('../assets/js')}}"></script>

    <!-- Page level plugins -->
    <script src="{{asset('../assets/vendor')}}/chart.{{asset('../assets/js')}}/Chart.min.{{asset('../assets/js')}}"></script>

    <!-- Page level custom scripts -->
    <script src="{{asset('../assets/js')}}/demo/chart-area-demo.{{asset('../assets/js')}}"></script>
    <script src="{{asset('../assets/js')}}/demo/chart-pie-demo.{{asset('../assets/js')}}"></script>

</body>

</html>