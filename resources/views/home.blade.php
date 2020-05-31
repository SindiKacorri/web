@extends('layouts.front')

@section('title')
<title>Linje Estetike</title>
@endsection

@section('content')

<section id="welcome-banner">
	<div class="container-fluid">
		<div class="row">
			<div class="col-xs-12 no-padding">
				<div class="owl-carousel owl-theme" id="owl1">
					<div class="welcome-wrapper bg-img" style="background-image: url('/src/home-slider/slide-1.jpg?v=0.2')">
						<div class="bg-shadow"></div>
						<div class="welcome-item-content">
							<h2>THE PERSONAL PROFESSIONAL CONCEPT</h2>
							<p>“The reason I sign on these cosmetics is not from a desire for fame. Behind this signature is a message, a personal dialogue with every woman. When I am at the lab carrying out research on a formula, I see a woman before me, as if I am about to create her personal line of cosmetics… ”</p>
							<h4>I.A.
								Chemist
								president of Juliette Armand</h4>
							<a href="{{url('/search')}}">Më shumë</a>
						</div>
					</div>
					<div class="welcome-wrapper bg-img" style="background-image: url('/src/home-slider/slide-2.jpg?v=0.2')">
						<div class="bg-shadow"></div>
						<div class="welcome-item-content">
							<h2>Rreth nesh</h2>
							<p>Në një periudhë kur gjithçka është jopersonale dhe e industrializuar, vendosëm të bëhemi një kompani e personalizuar. Kjo bëhet e qartë jo vetëm nga përkushtimi personal i themeluesve të saj në kërkimin dhe formulimin e kozmetikës, por dëshmohet edhe nga linjat tona të produkteve.</p>
							<a href="{{url('/about')}}">Lexo më shumë</a>
						</div>
					</div>
					<div class="welcome-wrapper bg-img" style="background-image: url('/src/home-slider/slide-3.jpg?v=0.2')">
						<div class="bg-shadow"></div>
						<div class="welcome-item-content">
							<h2>PRODUKTET TONA</h2>
							<p>Juliette Armand sjell një gamë të gjerë produktesh, me mbi 120 kode për përdorim personal. Shikoni më poshtë gjithçka ju ofrojmë për përmbushjen e nevojave tuaja kozmotogjike.</p>
							<a href="{{ route('our-products') }}">Shiko Produktet</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<section id="categories-section">
	<div id="imgs-ef"></div>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3">
				<h2 class="text-center mb0 w100" style="margin-bottom:30px;">Kategoritë</h2>
			</div>
		</div>

        @if(!empty($categories))
        @foreach($categories->chunk(3) as $c)
		<div class="row mb35">
            @foreach($c as $cat)
			<div class="col-xs-12 col-sm-5 text-center">
				<a href="{{ route('view.category', $cat->name) }}">
					<div class="category-outer cat-{{$cat->id}}" style="background-image: url('/src/categories/{{$cat->id}}/default.jpg?v=0.2')">
						<div class="button-category-outer">
							<div class="button-category-inner">
								{{$cat->name}}
							</div>
						</div>
					</div>
				</a>
			</div>
			@endforeach
        </div>
        @endforeach
        @endif

	</div>
</section>

{{-- <section id="showcase">
	<div class="container-fluid">
		<div class="row">
			@foreach($categories->take(3) as $cat)
			<div class="col-xs-12 col-sm-6 col-lg-3 no-padding">
				<div class="showcase-wrapper">
					<div class="showcase-item bg" style="background-image: url('{{(!empty($cat->products->first()->images)) ? '/front/products/thumbs/'. $cat->products->first()->images->first()->path : null}}');">
						<div class="showcase-overlay"></div>
						<div class="showcase-content">
							<h2>{{$cat->name}}</h2>
						</div>
					</div>
				</div>
			</div>
			@endforeach

			<div class="col-xs-12 col-sm-6 col-lg-3 no-padding hidden-xs hidden-sm">
				@foreach($categories->slice(3,2) as $cat)
				<div class="showcase-wrapper small">
					<div class="showcase-item bg item-small" style="background-image: url('{{(!empty($cat->products->first()->images)) ? '/front/products/thumbs/'. $cat->products->first()->images->first()->path : null}}');">
						<div class="showcase-overlay"></div>
						<div class="showcase-content">
							<h2 style="color: #fff;">{{$cat->name}}</h2>
						</div>
					</div>
				</div>
				@endforeach
			</div>
		</div>
	</div>
</section> --}}

{{-- <section id="latest-products">
	<div class="container-fluid">
		<div class="section-title">Produktet me te fundit</div>
		@foreach($products->chunk(4) as $chunk)
		<div class="row">
			@foreach($chunk as $p)
			<div class="col-xs-12 col-sm-6 col-md-3">
				<div class="staff-picks-wrapper">
					<div class="item">
						<a href="{{route('view.product', $p->uuid)}}">
							<div class="image-outer">
								<img class="img-responsive" src="/front/products/thumbs/{{isset($p->images->first()->path) ? $p->images->first()->path : null}}" alt="SET_ALT">
							</div>
							<div class="item-description">
								<h3 class="title">{{$p->title}}</h3>
								<h5 class="description">{{isset($p->description) ?: $p->description}}</h5>
							<div class="price">ALL {{number_format($p->sizes->first()->pivot->price)}}</div>
							</div>
						</a>
					</div>
				</div>
			</div>
			@endforeach
		</div>
		@endforeach
	</div>
</section> --}}

<section id="staff-picks">
	<div class="container">
		<div class="row">
			<div class="section-title">Produktet më të shitura</div>
			<div class="col-xs-12 no-padding">
				<div class="staff-picks-wraper">
					<div class="owl-carousel owl-theme" id="owl2">
						@foreach($mostViews as $item)
						<div class="item">
							<a href="{{route('view.product', $item->uuid)}}">
								<div class="image-outer">
									<img src="/front/products/thumbs/{{count($item->images) ? $item->images->first()->path : 'default.png'}}" alt="SET_ALT">
								</div>
								<div class="item-description">
									<h3 class="title">{{$item->title}}</h3>
									<h5 class="description">{{(!empty($p->description)) ?? $p->description}}</h5>
								<div class="price">EUR {{number_format($item->price)}}</div>
								</div>
							</a>
						</div>
						@endforeach
						{{-- <div class="item">
							<div class="image-outer">
								<img src="src/img/product-2.png" alt="SET_ALT">
							</div>
							<div class="item-description">
								<h3 class="title">Vince</h3>
								<h5 class="description">Essential Long Sleeve Pima Cotton Crew</h5>
								<div class="price">$87</div>
							</div>
						</div> --}}
						{{-- <div class="item">
							<div class="image-outer">
								<img src="src/img/product-3.png" alt="SET_ALT">
							</div>
							<div class="item-description">
								<h3 class="title">Vince</h3>
								<h5 class="description">Essential Long Sleeve Pima Cotton Crew</h5>
								<div class="price">$87</div>
							</div>
						</div> --}}
						{{-- <div class="item">
							<div class="image-outer">
								<img src="src/img/product-4.png" alt="SET_ALT">
							</div>
							<div class="item-description">
								<h3 class="title">Vince</h3>
								<h5 class="description">Essential Long Sleeve Pima Cotton Crew</h5>
								<div class="price">$87</div>
							</div>
						</div> --}}
						{{-- <div class="item">
							<div class="image-outer">
								<img src="src/img/product-3.png" alt="SET_ALT">
							</div>
							<div class="item-description">
								<h3 class="title">Vince</h3>
								<h5 class="description">Essential Long Sleeve Pima Cotton Crew</h5>
								<div class="price">$87</div>
							</div>
						</div> --}}
					</div>
				</div>
			</div>
		</div>
	</div>
</section>


{{-- <section id="featured-products">
	<div class="container-fluid">
		<div class="row">
			<div class="section-title">SECTION PER MARKAT</div>
			<!-- <div class="featured_wrapper"> -->
				<div class="col-xs-12 col-md-6 col-lg-3">
					<div class="featured_block">
						<div class="image_container">
							<img class="img-responsive" src="/front/products/thumbs/1569070687-krem-4.1.jpg" alt="SET_ALT`">
						</div>
						<div class="item-description">
							<h3>PRODUCT_TITLE</h3>
						</div>
					</div>
					<div class="clearfix"></div>
				</div>

				<div class="col-xs-12 col-md-6 col-lg-3">
					<div class="featured_block">
						<div class="image_container">
							<img class="img-responsive" src="/front/products/thumbs/1569070651-krem-3.jpg" alt="SET_ALT`">
						</div>
						<div class="item-description">
							<h3>PRODUCT_TITLE</h3>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-md-6 col-lg-3">
					<div class="featured_block">
						<div class="image_container">
							<img class="img-responsive" src="/front/products/thumbs/1569070609-krem-2.jpg" alt="SET_ALT`">
						</div>
						<div class="item-description">
							<h3>PRODUCT_TITLE</h3>
						</div>
					</div>
				</div>

				<div class="col-xs-12 col-md-6 col-lg-3">
					<div class="featured_block">
						<div class="image_container">
							<img class="img-responsive" src="/front/products/thumbs/1569070022-krem-1.jpg" alt="SET_ALT`">
						</div>
						<div class="item-description">
							<h3>PRODUCT_TITLE</h3>
						</div>
					</div>
				</div>
			<!-- </div> -->
		</div>
	</div>
</section> --}}
@endsection