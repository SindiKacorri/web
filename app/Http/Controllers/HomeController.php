<?php

namespace App\Http\Controllers;

use Auth;
use DB;
use Validator;
use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\UserLocation;
use App\Models\ProductOrder;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{

	/**
	*
	*
	* @var string
	*/
    protected $redirectTo = '/';


	public function home(){
		$categories = Category::all();

		$mostViews = Product::with('images')->orderBy('view_count', 'DESC')->take(8)->get();

		return view('home')
			->with('categories', $categories)
			->with('mostViews', $mostViews);
	}

	public function viewCategory($name) {
		$category = Category::with('products.images', 'products.sizes')->where('name', $name)->first();
		return view('category')->with('category', $category);
	}

	public function ourProducts() {
		return view('our-products');
	}

	/**
	 * search functionality
	 * 1. search with product title
	 *
	 * 1. filter with category  &category_id=1
	 * 2. filter with sizes		&size_id=1,5,14
	 * 3. filter with min price &min_price=50
	 * 4. filter with max price &max_price=180
	 * 5. filter with skin type &skin_types=soft,oily
	 *
	 */
	public function getSearch(Request $request) {
		//DB::enableQueryLog();
		$categories = Category::withCount('products')->orderBy('id', 'DESC')->get();
		$sizes = Size::orderBy('id', 'DESC')->get();

		$query = $request->get('q');

		$products = Product::with('sizes', 'skinTypes', 'sizes', 'category');


		if($query) {
			$products->where('title', 'LIKE', '%'.$query.'%');
		}

		// 1. filter with category  &category_id=1
		if($request->get('category_id')) {
			$products->where(function($query) use ($request) {
				$query->where('category_id', $request->category_id);
			});
		}

		// 2. filter with sizes &size_id=1,5,14
		if($request->get('size_id') || $request->get('min_price') || $request->get('max_price')) {
			$products->where(function($query) use ($request) {
				$query->whereHas('sizes', function($query) use ($request) {

					if($request->get('size_id')){
						$query->where('product_sizes.size_id', $request->size_id);
					}
				});
			});
		}

		// 5. filter with skin type &skin_types=soft,oily

		if($request->get('skin_types')) {
			$products->where(function($query) use ($request) {
				$query->whereHas('skinTypes', function($q) use ($request) {
					$q->whereIn('product_skin_types.skin_type_id', explode(',', $request->skin_types));
				});
			});

		}

		$products = $products->get();

		return view('search')->with('products', $products)
							 ->with('categories', $categories)
							 ->with('sizes', $sizes);

	}

	public function contactus() {
		return view('static.contact');
	}

	public function aboutus() {
		return view('static.about');
	}

	public function viewProduct($uuid){
		$product = Product::where('uuid', $uuid)->with('sizes', 'images', 'skinTypes')->first();
		$mostViews = Product::with('images')->orderBy('view_count', 'DESC')->take(8)->get();


		$productKey = 'article_' . $product->uuid;
		// Check session exists, if not then increment view count and create session key
		if(!Session::get($productKey)){
			$product->view_count++;
			$product->save();
			Session::put($productKey,1);
		}
		return view('product')->with('product', $product)->with('mostViews', $mostViews);
	}

	public function viewOrder(){
		return view('order');
	}

	public function checkout(){
		return view('checkout');
	}

	/**
	 * 1. check if users exists, if not create new one
	 * 2. attach current location to this user
	 * 3. get product id e.g. (215,12)
	 * 4. get product qty e.g. (1,4)
	 * 5. get product selected size e.g. (4,3)
	 * 6. get product selected color e.g. (6, 59)
	 *
	 *
	 * @param Request $request
	 * @return void
	 */
	public function saveOrder(Request $request){
		$quantity = $request->get('qty');
		$sizes = $request->get('sIds');
		$products = $request->get('pIds');

		if(empty($quantity) || empty($sizes) || empty($products)){
			return redirect('/')->with('error', 'Ndodhi nje gabim! Ju lutem provoni me vone.');
		}

		$validator = Validator::make($request->all(), Order::$rules);

		if ($validator->fails()){
			return back()->withInput()->withErrors($validator);
		}

        // STEP 1: if user exists, update current location
        if(Auth::check()) {
            $user = Auth::user();
        } else {
            $user = User::where('email', $request->get('email'))->first();
        }
		if($user){
            $location = UserLocation::where('user_id', $user->id)->first();
            if($location == null) {
                $location = new UserLocation;
                $location->user_id = $user->id;
            }
			$location->country = $request->get('country');
			$location->city = $request->get('city');
			$location->address = $request->get('address');
			$location->phone_number = $request->get('phone_number');
			$location->save();

			// STEP 2: else create new user, and attach this location
		}else {
			$user = new User;
			$user->name = $request->get('first_name') .'-'. $request->get('last_name') .'-'. time(); //terri-prifti-4540575744
			$user->email = $request->get('email');
			$user->password = bcrypt('ex2018');
			$user->save();

			$location = new UserLocation;
			$location->user_id = $user->id;
			$location->country = $request->get('country');
			$location->city = $request->get('city');
			$location->address = $request->get('address');
			$location->phone_number = $request->get('phone_number');
			$location->save();
		}

		//STEP 3: get product order options and convert to array;
		$sizes = explode(',', $sizes);
		$qty = explode(',', $quantity);
		$productIds = [];

		$uuids = explode(',', $products);

		foreach($uuids as $uuid){
			$prod = Product::where('uuid', $uuid)->first();
			if($prod){
				$productIds[] = $prod->id;
			}
		}

		if(count($sizes) && count($qty) !== count($productIds)){
			return view('home')->with('error', 'Ndodhi nje gabim! Provoni me vone');
		}

		// STEP 4: create order
		$order = new Order;
		$order->user_id = $user->id;
		$order->payment_method_id = 1;
		$order->status_id = 1; // statusi 1 = ne pritje
		$order->message = (!empty($request->get('message'))) ? $request->get('message') : null;
		$order->save();


		//STEP 5: attach product order options to this order
		// product_id
		// order_id
		// size_id
		// color_id
		// qty
		for($i = 0; $i < count($productIds); $i++){
			$productOrder = new ProductOrder;
			$productOrder->order_id = $order->id;
			$productOrder->product_id = $productIds[$i];
			$productOrder->size_id = $sizes[$i];
			$productOrder->qty = $qty[$i];
			$productOrder->save();
		}

		return redirect('/checkout')->with('order-success', 'Porosia u krye me sukses! Do ju njoftojmë së shpejti.');
    }

    public function viewUserProfile(){
        if(!Auth::check()) {
            return redirect('/');
        }

        return view('user-profile');
    }
}
