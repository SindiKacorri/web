@extends('layouts.dashboard')


@section('content')
<form action="{{url('admin/product/create')}}" method="POST" enctype="multipart/form-data">
{{ csrf_field() }}
<div class="container mobfix">
	<div class="row">
		<div class="col-xs-12 col-md-8">
			@if($errors->any())
			<h4>{{$errors->first()}}</h4>
			@endif
			<div class="col-xs-12">
				<div class="box box-white">
					<div class="box-header with-border">
					<h3 class="box-title">Emri i produktit.</h3>
						@if($errors->has('title'))
							<label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('title') }}</label>
						@endif
					</div>
					<div class="box-body">
					<input class="form-control input-lg" type="text" name="title" placeholder="emri i produktit..." value="{{ old('title') }}" required>
					<br>
					</div>
					<!-- /.box-body -->
				</div>

				<!-- body-->
				<div class="box box-white">
					<div class="box-header with-border">
					<h3 class="box-title">Foto te Produktit</h3>
					@if($errors->has('images'))
							<label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('images') }}</label>
						@endif
					</div>
					<div class="box-body">
						<div class="full-dark-bg">
							<input type="hidden" id="img_paths" name="images">
							<!-- Files section -->
							<div class="dropzone files-container" data-back="/admin/product/image">
								<div class="fallback">
									<input name="file" type="file" multiple />
								</div>
							</div>

							<!-- Notes -->
							<span>Only JPG, PNG, JPEG file types are supported.</span>
							<span>Maximum file size is 5MB.</span>

							<!-- Uploaded files section -->
							<h4 class="section-sub-title"><span>Foto te zgjedhura</span> (<span class="uploaded-files-count">0</span>)</h4>
							<span class="no-files-uploaded">Nuk ka foto te zgjedhura.</span>

							<!-- Preview collection of uploaded documents -->
							<div class="preview-container dz-preview uploaded-files">
								<div id="previews">
									<div id="onyx-dropzone-template">
										<div class="onyx-dropzone-info">
											<div class="thumb-container">
												<img data-dz-thumbnail />
											</div>
											<div class="details">
												<div>
													<span data-dz-name></span> <span data-dz-size></span>
												</div>
												<div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>
												<div class="dz-error-message"><span data-dz-errormessage></span></div>
												<div class="actions">
													<a href="#!" data-dz-remove><i class="fa fa-times"></i></a>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="box box-white">
					<div class="box-header with-border">
						<h3 class="box-title">Lista e Çmimeve</h3>
						<span class="label label-primary pull-right add-more-size" id="add-spg">Shto mase te re</span>
						@if($errors->has('images'))
							<label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('images') }}</label>
						@endif
					</div>
					<div class="box-body" id="spg">
						<div class="sizes-price">
							<div class="size-wrapper" style="width:40%;margin-right:5%">
								<select class="form-control" name="sizes[size_id][]" required>
									<option disabled selected value> -- Masa -- </option>
									@foreach($sizes as $m)
										<option value="{{ $m->id }}"
										@if(old('cat_id') == $m->id)
											selected
										@endif>
										{{ $m->name }}</option>
									@endforeach
								</select>
							</div>
							<div class="price-wrapper" style="margin-right:5%">
								<div class="input-group">
									<span class="input-group-addon"><strong><i class="fa fa-eur"></i></strong></span>
									<input class="form-control input-md" type="number" name="sizes[price][]" placeholder="Cmimi" step="0.01" value="{{ old('price') }}">
								</div>
							</div>
							<div class="price-wrapper">
								<div class="input-group">
									<span class="input-group-addon"><strong><i class="fa fa-eur"></i></strong></span>
									<input class="form-control input-md" type="number" name="sizes[second_price][]" placeholder="Cmimi i zbritur" step="0.01" value="{{ old('price') }}">
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-12 col-md-4">

			<!-- /.box-body -->
			<div class="col-xs-12">
					<div class="box box-white">
						<div class="box-header with-border">
							<h3 class="box-title">Kodi i Produktit (opsional)</h3>
							@if($errors->has('product_code'))
							<label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('product_code') }}</label>
						@endif
						</div>
						<div class="box-body">
							<input class="form-control input-md" type="text" name="product_code" placeholder="Kodi i Produktit" value="{{ old('product_code') }}">
						</div>
						<!-- /.box-body -->
					</div><!--box-->
			</div><!-- row of category-->
			<!-- /.box-body -->
			<div class="col-xs-12">
					<div class="box box-white">
						<div class="box-header with-border">
							<h3 class="box-title">Kategoria e Produktit</h3>
							@if($errors->has('cat_id'))
							<label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('cat_id') }}</label>
						@endif
						</div>
						<div class="box-body">
							<select class="form-control" name="cat_id" required>
							<option disabled selected value> -- zgjidh nje opsion -- </option>
							@foreach($categories as $category)
								<option value="{{ $category->id }}"
								@if(old('cat_id') == $category->id)
									selected
								@endif>
								{{ $category->name }}</option>
							@endforeach
							</select>
						</div>
						<!-- /.box-body -->
					</div><!--box-->
			</div><!-- row of category-->

			{{-- <div class="col-xs-12">
				<div class="box box-white">
					<div class="box-header with-border">
						<h3 class="box-title">Kompania e produktit</h3>
						@if($errors->has('company_id'))
						<label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('company_id') }}</label>
					@endif
					</div>
					<div class="box-body">
						<select class="form-control" name="company_id" required>
						<option disabled selected value> -- zgjidh nje opsion -- </option>
						@foreach($companies as $m)
							<option value="{{ $m->id }}"
							@if(old('company_id') == $m->id)
								selected
							@endif>
							{{ $m->name }}</option>
						@endforeach
						</select>
					</div>
					<!-- /.box-body -->
				</div><!--box-->
			</div><!-- row of company--> --}}

			<div class="col-xs-12">
				<div class="box box-white">
					<div class="box-header with-border">
						<h3 class="box-title">Pershkrimi i produktit.</h3>
							@if($errors->has('description'))
								<label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('description') }}</label>
							@endif
						</div>
						<div class="box-body">
							<textarea class="form-control" rows="5" id="description" name="description"></textarea>
						<br>
					</div>
					<!-- /.box-body -->
				</div>
			</div>
			<div class="col-xs-12">
				<div class="box box-white">
					<div class="box-header with-border">
						<h3 class="box-title">Skin Type</h3>
					</div>
					<div class="box-body">
						<select class="form-control select2 skin-types-multiple" name="skin_types[]" multiple="multiple" data-placeholder="Skin types">
							@foreach($skin_types as $s)
								<option value="{{ $s->id }}"
								@if(old('cat_id') == $s->id)
									selected
								@endif>
								{{ $s->name }} </option>
							@endforeach
						</select>
					</div>
				</div>
			</div><!-- row of price-->


			<div class="col-xs-12">
					{{-- <div class="box box-white">
						<div class="box-header with-border">
							<h3 class="box-title">Zgjidh permasat e produktit</h3>
							@if($errors->has('sizes'))
							<label class="control-label text-danger" for="inputError"><i class="fa fa-times-circle-o"></i> {{ $errors->first('sizes') }}</label>
						@endif
						</div>
						<div class="box-body">
								<select class="form-control select2 sizes-multiple" name="sizes[]" multiple="multiple" data-placeholder="Zgjidhni disa permasa" required>
									@foreach($sizes as $s)
										<option value="{{ $s->id }}"
										@if(old('cat_id') == $s->id)
											selected
										@endif>
										{{ $s->name }} </option>
									@endforeach
								</select>
						</div>
						<!-- /.box-body -->
					</div><!--box--> --}}
					<button type="submit" class="btn btn-success btn-flat btn-media margin pull-right" style="font-size: 16px;font-weight: bold;">
						Ruaj Produktin</button>
			</div><!-- row of colors-->
		</div>
	</div>
</div>
</form>


@endsection

@section('scripts')
<script src="{{mix('back/js/dropzone.js')}}"></script>
<script src="{{mix('back/js/dz.js')}}"></script>
<script src="{{mix('back/js/new-product.js')}}"></script>

<script>
	$(document).ready(function() {
		$('.skin-types-multiple').select2();
	});
</script>
@endsection