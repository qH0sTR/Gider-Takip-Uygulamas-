<!DOCTYPE html>
<html>

<head>
	<!-- <script src="/frontend/vendor/modernizr/modernizr.js"></script> -->

	<meta charset="utf-8">
	<title>Porto - Responsive HTML5 Template 3.7.0</title>
	<meta name="description" content="Gelir Gider Takip Programı">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="css/bootstrap-datetimepicker.min.css">
	<link rel="stylesheet" href="/css/bootstrap.css">
	<link rel="stylesheet" href="/css/theme.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.0/css/all.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	@yield('css')
	<style>
		#map1,
		#map2 {
			position: static !important;
			height: 100%;
		}

	

		#information,
		#information2 {
			position: absolute;
			top: 0;
			z-index: 999;
		}

		.map_container,
		.map_genel {
			display: none;
		}

		.fa-map-marker {
			color: red;
		}

		.fa-edit {
			color: blue;
		}

		.fa-trash {
			color: red;
		}

		.konum_var {
			color: #0f0;
		}

		.btn-third {
			background-color: rgba(100, 100, 100);
			color: #f24;
		}

		.ortala{
			text-align: center;
		}

		.bos{
			background-color: black;
		}
	</style>
</head>

<body>
	<div class="body">
		<header id="header">
			<div class="container">
				<div class="logo">
					<a href="/">
						<img alt="Porto" width="111" height="54" data-sticky-width="82" data-sticky-height="40" src="img/logo.png">
					</a>
				</div>
				<h2 class="mt-5">Gider Takip Programı</h2>
				<!-- <div class="search">
					<form id="searchForm" action="page-search-results.html" method="get">
						<div class="input-group">
							<input type="text" class="form-control search" name="q" id="q" placeholder="Ara..." required>
							<span class="input-group-btn">
								<button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
							</span>
						</div>
					</form>
				</div> -->
			</div>
		</header>

		@yield('icerik')
		<div class="map_container">
			<div id="information" style="padding:10px;">
				<input value="41.028325" disabled class="form-control my-2" id="lat" name="lat" placeholder="Enlem">
				<input value="28.913060" disabled class="form-control" id="lng" name="lng" placeholder="Boylam">
				<button class="geri_don btn btn-danger" type="button">Geri Dön</button>
				<button class="konumu_kaydet btn btn-success my-2" type="button">Konumu Kaydet</button>
			</div>
			<div id="map1"></div>
		</div>
		<div class="map_genel">
			<div id="information2" style="padding:10px;">

				<button class="geri_don2 btn btn-danger" type="button">Geri Dön</button>

			</div>
			<div id="map2"></div>
		</div>
	</div>

	<script src="/js/jquery_3.6.js"></script>
	<script src="/js/bootstrap.js"></script>
	<script src="/js/vanilla-toast.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.14/dist/sweetalert2.all.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js" type="text/javascript"></script>
	<script src="/js/bootstrap-datetimepicker.min.js"></script>

	<script src="/js/google_script.js"></script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?&callback=initMap">
	</script>

	<script>
		var locations = `{{ json_encode($locations) }}`
		locations = JSON.parse(locations.replace(/&quot;/g, '"'));
		console.log(locations)
	</script>
	@yield('js')

</body>

</html>