<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\ImageRepository;
use Validator;
use App\Models\Product;
use App\Models\ProductSize;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\Order;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\Company;
use App\Models\SkinType;
use App\Models\ProductSkinType;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
	protected $imageRepo;

	public function __construct(ImageRepository $imageRepository)
	{
		$this->middleware('role:admin');
		$this->imageRepo = $imageRepository;
	}
	/**
	 * Where to redirect users after product setting deletion.
	 *
	 * @var string
	 */
	protected $redirectTo = 'admin/dashboard';

	/**
	 *
	 *
	 * @param Request $request
	 * @return void
	 */
	public function newProduct(Request $request){
		$validator = Validator::make($request->all(), Product::$rules);
		if ($validator->fails()){
			return back()->withInput()->withErrors($validator);
		}

		DB::transaction(function() use($request) {
			$product = new Product;
			$product->uuid = $this->uniqidReal();
			$product->is_featured = false;
			$product->title = $request->get('title');
			$product->description = $request->get('description') ?? null;
			$product->category_id = $request->get('cat_id');
			//$product->company_id = $request->get('company_id');
			$product->product_code = $request->get('product_code') ?? null;

			//PRODUCT SAVE
			$product->save();

			$imgs = $request->get('images');
			if(!empty($imgs)){
				$imgs = explode(',', $imgs);

				foreach($imgs as $id){
					$dt = ProductImage::where('id', $id)->first();
					$dt->product_id = $product->id;
					$dt->save();
				}
			}

			$skinTypes = $request->get('skin_types');

			if(!empty($skinTypes)) {
				foreach($skinTypes as $skinId) {
					$newSkin = new ProductSkinType;
					$newSkin->product_id = $product->id;
					$newSkin->skin_type_id = $skinId;
					$newSkin->save();
				}
			}

			$sizes = $request->get('sizes');
			if(!empty($sizes)){
				for($i = 0; $i < count($sizes['size_id']); $i++){
					$dafina = new ProductSize;
					$dafina->product_id = $product->id;
					$dafina->size_id = $sizes['size_id'][$i];
					$dafina->price = $sizes['price'][$i];
					$dafina->has_discount = (!empty($sizes['second_price'][$i])) ? true : false;
					$dafina->second_price = $sizes['second_price'][$i] ?? null;
					$dafina->save();
				}
			}
		});

		return redirect($this->redirectTo)->with('success', 'Produkti i ruajt me sukses!');
	}

	public function productImage(Request $request){
		// http_response_code(500);
		// dd($request->all());
		if($request->get('delete_file')){
			//delete image
			$imgId = $request->get('back_id');
			$this->imageRepo->deleteById($imgId);
			return response()->json(['id' => $imgId]);
		}else {
			$file = $request->file('file');
			//create new image
			$image = $this->imageRepo->saveProductImage($file);
			return response()->json(['filename' => $image->path, 'id' => $image->id]);
		}
	}

	//'products.sizes', 'products.colors',
	public function allOrders(){
		$orders = Order::with('user.location')->orderBy('created_at', 'DESC')->get();
		return view('back.orders.all')->with('orders', $orders);
	}

	public function editProduct($id){
		$product = Product::with('sizes', 'category', 'images', 'skinTypes')->where('id', $id)->first();
		$categories = Category::all();
		// $companies = Company::all();
		$sizes = Size::all();
		$skin_types = SkinType::all();
		$skin_types = $skin_types->except($product->skinTypes->modelKeys());
		$sizes = Size::all();
		//dd($product->skinTypes->toArray());
		return view('back.products.edit')->with('product', $product)
										 ->with('categories', $categories)
										 ->with('skin_types', $skin_types)
										//  ->with('companies', $companies)
										 ->with('sizes', $sizes);
	}

	public function updateProduct(Request $request, $id){

		DB::transaction(function() use ($request, $id) {
			$product = Product::where('id', $id)->first();
			$product->title = $request->get('title');
			$product->description = $request->get('description') ?? null;
			$product->category_id = $request->get('cat_id');
			//$product->company_id = $request->get('company_id');
			$product->product_code = $request->get('product_code') ?? null;

			//PRODUCT SAVE
			$product->save();

			$imgs = $request->get('images');
			if(!empty($imgs)){
				$imgs = explode(',', $imgs);

				foreach($imgs as $imageId){
					$dt = ProductImage::where('id', $imageId)->first();
					$dt->product_id = $id;
					$dt->save();
				}
			}

			$skinTypes = $request->get('skin_types');

			if(!empty($skinTypes)) {
				DB::table('product_skin_types')->where('product_id', $id)->delete();
				foreach($skinTypes as $skinId) {
					$newSkin = new ProductSkinType;
					$newSkin->product_id = $id;
					$newSkin->skin_type_id = $skinId;
					$newSkin->save();
				}
			}

			$sizes = $request->get('sizes');
			if(!empty($sizes)) {
				DB::table('product_sizes')->where('product_id', $id)->delete();

				for($i = 0; $i < count($sizes['size_id']); $i++){
					$dafina = new ProductSize;
					$dafina->product_id = $id;
					$dafina->size_id = $sizes['size_id'][$i];
					$dafina->price = $sizes['price'][$i];
					$dafina->has_discount = (!empty($sizes['second_price'][$i])) ? true : false;
					$dafina->second_price = $sizes['second_price'][$i] ?? null;
					$dafina->save();
				}
			}
		});

		return redirect('/admin/products/all')->with('success', 'Produkti i be update me sukses!');

	}


	public function allProducts(){
		$products = Product::with('category', 'sizes')->orderBy('created_at', 'DESC')->get();
		return view('back.products.index')->with('products', $products);
	}

	public function viewOrder($id){
		$order = Order::where('id', $id)->with('user.location', 'products.sizes')->first();
		return view('back.orders.view')->with('order', $order);
	}

	/**
	 * ORDER STATUS:
	 * 1. ne proces
	 * 2. konfirmuar
	 * 3. anulluar
	 *	@TODO: check if is canceled or confirmed
	 * @param [type] $id
	 * @return void
	 */
	public function confirmOrder($id){
		$order = Order::where('id' ,$id)->first();
		$order->status_id = 2;
		$order->save();

		return redirect('/admin/orders/all')->with('success', 'Porosia u konfirmua!');

	}

	public function cancelOrder($id){
		$order = Order::where('id' ,$id)->first();
		$order->status_id = 3;
		$order->save();

		return redirect('/admin/orders/all')->with('warning', 'Porosia u anullua!');
	}

	protected function uniqidReal($length = 12) {
		// uniqid gives 13 chars, but you could adjust it to your needs.
		if (function_exists("random_bytes")) {
			$bytes = random_bytes(ceil($length / 2));
		} elseif (function_exists("openssl_random_pseudo_bytes")) {
			$bytes = openssl_random_pseudo_bytes(ceil($length / 2));
		} else {
			throw new Exception("no cryptographically secure random function available");
		}
		return substr(bin2hex($bytes), 0, $length);
	}
}
