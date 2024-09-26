<!doctype html>
<html lang="en">

<head>
	<title>DWOR</title>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<!-- VENDOR CSS -->
	<link rel="stylesheet" href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/vendor/font-awesome/css/font-awesome.min.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/vendor/linearicons/style.css') }}">
	<link rel="stylesheet" href="{{ asset('admin/assets/vendor/chartist/css/chartist-custom.css') }}">
	<!-- MAIN CSS -->
	<link rel="stylesheet" href="{{ asset('admin/assets/css/main.css') }}">
	<!-- FOR DEMO PURPOSES ONLY. You should remove this in your project -->
	<link rel="stylesheet" href="{{ asset('admin/assets/css/demo.css') }}">
	<!-- GOOGLE FONTS -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700" rel="stylesheet">
	<!-- ICONS -->
	<link rel="apple-touch-icon" sizes="76x76" href="{{ asset('admin/assets/img/Dwor1.png') }}">
	<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('admin/assets/img/Dwor1.png') }}">
</head>

<body>
	<!-- WRAPPER -->
	<div id="wrapper">
		<!-- NAVBAR -->
		{{-- <nav class="navbar navbar-default navbar-fixed-top">
			<div class="brand">
				<a href="/dwor"><img src="{{ asset('admin/assets/img/Dwor1.png') }}" alt="Klorofil Logo" class="img-responsive logo"></a>
			</div>
			<div class="container-fluid">
				<div class="navbar-btn">
					<button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
				</div>
			
		
			
			</div>
		</nav> --}}
		<!-- END NAVBAR -->
		<!-- LEFT SIDEBAR -->
		<div id="sidebar-nav" class="sidebar">
			<div class="sidebar-scroll">
		


				<div class="user-account">
					<img src="{{ asset('admin/assets/img/Dwor1.png') }}" 
                    class="img-responsive" >
				
				</div>

				<nav>
					<ul class="nav">
						<li><a href="/" class="{{ ($judul  === "index") ? 'active' : ''}}"><i class="lnr lnr-home"></i> <span>Jumlah Pasien Terlayani</span></a></li>
						<li><a href="/bor" class="{{ ($judul  === "bor") ? 'active' : ''}}"><i class="lnr lnr-home"></i> <span>Jumlah MRS</span></a></li>
						<li><a href="/jri" class="{{ ($judul  === "jri") ? 'active' : ''}}"><i class="lnr lnr-code"></i> <span>Jumlah Rawat Inap</span></a></li>
						<li><a href="/jkpl" class="{{ ($judul  === "jkpl") ? 'active' : ''}}"><i class="lnr lnr-chart-bars"></i> <span>Jumlah Kunjungan Pasien Lama</span></a></li>
						<li><a href="/jkpb" class="{{ ($judul  === "jkpb") ? 'active' : ''}}"><i class="lnr lnr-cog"></i> <span>Jumlah Kunjungan Pasien Baru</span></a></li>
					</ul>
				</nav>
			</div>
		</div>
		<!-- END LEFT SIDEBAR -->
		<!-- MAIN -->
	@yield('content')
		<!-- END MAIN -->
		<div class="clearfix"></div>
		<footer>
			<div class="container-fluid">
				<p class="copyright" >&copy; 2023 IT RSUD DAHA HUSADA</p>
			</div>
		</footer>
	</div>
	<!-- END WRAPPER -->
	<!-- Javascript -->
	<script src="{{ asset('admin/assets/vendor/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('admin/assets/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('admin/assets/vendor/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
	<script src="{{ asset('admin/assets/scripts/klorofil-common.js') }}"></script>
	<script src="{{ asset('admin/assets/vendor/chartist/js/chartist.min.js') }}"></script>
	@yield('footer')	
</body>

</html>
