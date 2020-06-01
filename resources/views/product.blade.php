@extends('layouts.front')

@section('title')
<title>{{ $product->title }} | Juliette Armand Albania</title>
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-6 product-view">
				<div class="product-images">
					<div class="image-primary">
					<img src="{{asset('front/products/images/'. $product->images->first()->path)}}" alt="{{$product->title}}" class="img-responsive" id="primary-img">
					</div>
					<div class="image-secondary">
						<div class="row">
						@foreach($product->images as $image)
							@if($loop->first)
								<div class="col-xs-3 image-thumb">
									<img src="{{asset('front/products/images/'. $image->path)}}" alt="{{$product->title}}" class="img-responsive selected">
								</div>
							@else
								<div class="col-xs-3 image-thumb">
									<img src="{{asset('front/products/images/'. $image->path)}}" alt="{{$product->title}}" class="img-responsive">
								</div>
							@endif
						@endforeach
						</div>
					</div>
				</div>
			</div>
			<div class="col-xs-12 col-sm-6 product-view no-margin">
				<div class="product-data">
					<div class="data-section flex-only-vertical">
						<h3 class="title" id="vptitle">{{$product->title}}</h3>
						<p>{!! str_replace(PHP_EOL, "<br>", $product->description) !!}</p>
						<h4 class="price" id="vpprice" data-price="{{$product->sizes->first()->pivot->price}}">EUR {{$product->sizes->first()->pivot->price}}</h4>
						<input type="hidden" value="{{$product->uuid}}" id="puid">
						<div class="clearfix"></div>
					</div>
					<div class="data-section mg25 pb25">
						<div class="row">

							<div class="col-xs-6 col-md-4">
								<div class="header">Sasia</div>
								<div class="quantity" style="display:inline-block;">
								<input type="hidden" id="price_list" value="{{$product->getPricesList()}}">
									<div class="minus"><i class="fas fa-minus" id="decrement"></i></div><div class="count" id="product-count">1</div><div class="plus" id="increment"><i class="fas fa-plus"></i></div>
									<div class="clearfix"></div>
								</div>
							</div>

							<div class="col-xs-6 col-md-4">
								<div class="header">Përmasa</div>
								@foreach($product->sizes as $size)
									<div class="p_size" data-size="{{$size->id}}" data-index="{{$loop->index}}">{{$size->name}}</div>
								@endforeach
							</div>
						</div>
					</div>

					<div class="data-section p25">
						<div class="row">
							<div class="col-xs-12 misc-margin">
								<h5 class="misc-prop">Kategoria</h5>
								<h5 class="misc-value">{{$product->category->name}}</h5>
							</div>

							<div class="col-xs-12 misc-margin">
								<h5 class="misc-prop">Llojet e lekures</h5>
								<h5 class="misc-value">{{(!empty($product->getSkinTypes())) ? $product->getSkinTypes() :  '- - -'}}</h5>
							</div>
							<div class="col-xs-12 misc-margin">
								<h5 class="misc-prop">share</h5>
								<h5 class="misc-value">
									<a href="#">
										<span><i class="fab fa-facebook-f"></i></span>
									</a>
									<a href="#">
										<span><i class="fab fa-instagram"></i></span>
									</a>
								</h5>
							</div>
						</div>
					</div>

					<div class="data-section p25 nb">
						<button class="btn btn-favourite" id="add-product">shto ne shporte</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container-fluid no-padding">
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
												<div class="price">EUR {{$item->sizes->first()->pivot->price}}</div>
												</div>
											</a>
										</div>
									@endforeach

								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
	</div>
@endsection