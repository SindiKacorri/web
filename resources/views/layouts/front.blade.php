<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<meta name="description" content="Miresevini ne boten e kujdesit personal. Juliette Armand, linje estetike profesionale per fytyren dhe trupin.">
	<meta name="keywords" content="">
	<meta name="google-site-verification" content="MxGP4VXUO_3qRg8mXUqBjCe_UuGNtPVp3RHftjFMesM" />
	@yield('title')

	<link href="https://fonts.googleapis.com/css?family=Lato:300,400,700" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Noto+Serif:700" rel="stylesheet">
	<link href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" rel="stylesheet" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">

	<!--custom-->
	<link rel="stylesheet" href="{{mix('front/css/libs.css')}}">
	<link rel="stylesheet" href="{{mix('front/css/ltd.css')}}">

	@yield('css')
</head>
<body ontouchstart>
	<header>
		<nav class="menu-wrapper">
			<div class="container">
				<button class="btn-nav-toggle" id="nav-o">
					<span class="bars"></span>
				</button>
				<div class="menu-logo pull-left">
					<a href="{{url('/')}}">
						{{-- <img src="src/img/logo.png" alt="SET_LOGO_ALT"> --}}
						<h3 style="margin-bottom:0;">LOGO</h3>
					</a>
				</div>
				<ul class="menu-list">
					<li><a href="{{url('/')}}">Faqja Kryesore</a></li>
					<li><a href="{{url('/about')}}">Rreth nesh</a></li>
					<li><a href="{{url('/contact')}}">Kontakt</a></li>
				</ul>
				<div class="menu-search">
					<div class="search-group">
						<form role="search" action="{{route('search')}}">
							<input type="text" name="q" placeholder="Kërko Produkte" value="{{ request()->get('q')}}">
							<span class="search-icon">
								<i class="fas fa-search"></i>
							</span>
						</form>
					</div>
				</div>
				<div class="icons-wrapper">
					{{-- <span class="user"><i class="far fa-user fa-lg"></i></span> --}}
					<a href="{{url('orders')}}"><span class="shopping-card" ><i class="fas fa-shopping-bag fa-lg"></i></span>
						<span id="bag-count"></span>
					</a>
				</div>
				<div class="clearfix"></div>
			</div>

			<div id="fixed">
				<div id="shad"></div>
				<div class="mobile-nav mobile-nav-block" id="mobile-nav">
					<div class="navigation-block">
						<button class="btn-nav-toggle" id="nav-cc">
							<span class="bars"></span>
						</button>
						<div class="text-nav">JA</div>
					</div>
					<ul class="nav navbar-nav">
						<li><a href="{{url('/')}}">Faqja Kryesore</a></li>
						<li><a href="{{url('/about')}}">Rreth nesh</a></li>
						<li><a href="{{url('/contact')}}">Kontakt</a></li>
						<li><a href="{{url('/our-products')}}">Produktet tona</a></li>
					 <!---->
				  </ul>
				</div>
			</div>
		</nav>
	</header>
	<!-- logo -->
	@yield('content')

	<footer class="container-fluid">
		<div class="container pb25">
			<div class="row">
				<div class="col-xs-12 col-md-5">
					<div class="row mb25">
						<div class="col-xs-6 col-md-4">
							<div class="logo-part">
								<h3 style="margin-bottom:0;">LSS</h3>
								{{-- <img src="{{asset('src/img/logo.png')}}" class="w-50 logo-footer" > --}}
								{{-- <p>7637 Laurel Dr. King Of Prussia, PA 19406</p>
								<p>Use this tool as test data for an automated system or find your next pen</p> --}}
							</div>
						</div>
						<div class="col-xs-6 col-md-8 px-4">
							<h5> Faqet Kryesore</h5>
							<ul>
								<li> <a href="#"> Home</a> </li>
								<li> <a href="{{url('about')}}"> Rreth nesh</a> </li>
								<li> <a href="{{url('our-products')}}"> Produktet tona</a> </li>
								<li> <a href="{{url('contact')}}"> Kontakt</a> </li>
							</ul>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-6">
					<div class="row">
						<div class="col-xs-12 col-md-8 px-4 mb25">
							<h5> Kategoritë</h5>
							<div class="row ">
								<div class="col-xs-6">
									<ul>
										@foreach(App\Models\Category::all()->take(6) as $category)
										<li> <a href="{{ route('view.category', $category->name) }}"> {{$category->name}}</a> </li>
										@endforeach
									</ul>
								</div>
								<div class="col-xs-6">
									<ul>
										@foreach(App\Models\Category::all()->slice(6)->take(5) as $category)
										<li> <a href="{{ route('view.category', $category->name) }}"> {{$category->name}}</a> </li>
										@endforeach
									</ul>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-4">
							<h5>Na ndiqni në rrjetet sociale</h5>
							<div class="social">
								<a href="http://www.fshn.edu.al/" target="_blank"><i class="fab fa-instagram" aria-hidden="true"></i></a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</footer>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js" defer></script>
	<script src="{{ mix('front/js/libs.js') }}" defer></script>
	<script src="{{ mix('front/js/jaal.js') }}" defer ></script>
	<script src="{{ mix('front/app.js') }}" defer></script>
	@yield('scripts')

	@if(session('success'))
	<script>toastr.success('{{ session('success') }}')</script>
	@endif

	@if(session('error'))
	<script>toastr.error('{{ session('error') }}')</script>
	@endif

	@if(session('warning'))
	<script>toastr.warning('{{ session('warning') }}')</script>
	@endif

	@if(session('order-success'))
	<script>
		var ofn = '{{ session('order-success') }}';
		window.orderFinishNotify = true;
	</script>
	@endif

</body>
</html>
