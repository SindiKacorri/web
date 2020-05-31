<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\SkinType;
use App\Models\Size;
use App\Models\Color;
use App\Models\Company;

class ProductSettingsController extends Controller
{

	public function __construct(){
		$this->middleware('role:admin');
	}

	/**
	 * Where to redirect users after product setting deletion.
	 *
	 * @var string
	 */
	protected $redirectTo = '/admin/dashboard';

	public function settings(){
		$categories = Category::orderBy('id', 'DESC')->get();
		$sizes = Size::orderBy('id', 'DESC')->get();
		$skin_types = SkinType::orderBy('id', 'DESC')->get();
		return view('back.manage.product-settings')
				->with('categories', $categories)
				->with('skin_types', $skin_types)
				// ->with('materials', $materials)
				->with('sizes', $sizes);
				// ->with('subcats', $subcats);
	}

	public function newProduct(){
		$categories = Category::all();
		$companies = Company::all();
		$sizes = Size::all();
		$skin_types = SkinType::all();
		$sizes = Size::all();
		return view('back.products.create')
				->with('categories', $categories)
				->with('companies', $companies)
				->with('sizes', $sizes)
				->with('skin_types', $skin_types);
	}

	/**
	 * Krijo kategori te re per produkt
	 *
	 * @param Request $request
	 * @return action
	 */
	public function createCategory(Request $request){
		$validator = Validator::make($request->all(), Category::$rules);

		if ($validator->fails()){
			return back()->withInput()->withErrors($validator);
		}

		$category = new Category;
		$category->name = $request->get('name');
		$category->save();

		return redirect($this->redirectTo)->with('success','New Category created successfully!');
	}

	/**
	 * Krijo kategori te re per produkt
	 *
	 * @param Request $request
	 * @return action
	 */
	public function createSkintype(Request $request){
		$validator = Validator::make($request->all(), SkinType::$rules);

		if ($validator->fails()){
			return back()->withInput()->withErrors($validator);
		}

		$category = new SkinType;
		$category->name = $request->get('name');
		$category->code = $request->get('code');
		$category->save();

		return redirect($this->redirectTo)->with('success','New Skin type created successfully!');
	}


	/**
	 * Krijo ngjyre te re per produkt
	 *
	 * @param Request $request
	 * @return action
	 */
	public function createColor(Request $request){
		$validator = Validator::make($request->all(), Color::$rules);

		if ($validator->fails()){
			return back()->withInput()->withErrors($validator);
		}

		$color = new Color;
		$color->name = $request->get('name');
		$color->code = $request->get('code');
		$color->save();

		return redirect($this->redirectTo)->with('success','New Color created successfully!');
	}

	/**
	 * Krijo material te ri per produkt
	 *
	 * @param Request $request
	 * @return action
	 */
	public function createMaterial(Request $request){
		$validator = Validator::make($request->all(), Material::$rules);

		if ($validator->fails()){
			return back()->withInput()->withErrors($validator);
		}

		$material = new Material;
		$material->name = $request->get('name');
		$material->save();

		return redirect($this->redirectTo)->with('success','New Material created successfully!');
	}

	/**
	 * Krijo madhesi te re per produkt
	 * (x/xs/m/l/xl)
	 *
	 * @param Request $request
	 * @return action
	 */
	public function createSize(Request $request){
		$validator = Validator::make($request->all(), Size::$rules);

		if ($validator->fails()){
			return back()->withInput()->withErrors($validator);
		}

		$size = new Size;
		$size->name = $request->get('name');
		$size->save();

		return redirect($this->redirectTo)->with('success','New Size created successfully!');
	}

	/**
	 * delete a product category
	 *
	 * @param Request $request
	 * @param [int] $id
	 * @return [response]
	 */
	public function deleteCategory($id){
		$category = Category::where('id', $id)->first();
		if($category->products->count() == 0){
			$category->delete();
			return redirect($this->redirectTo)->with('success','Category deleted successfully!');
		}
			return redirect($this->redirectTo)->with('warning','Kjo kategori permban produkte dhe nuk mund te fshihet');
	}

	/**
	 * delete a product subcategory
	 *
	 * @param Request $request
	 * @param [int] $id
	 * @return [response]
	 */
	public function deleteSkintype($id){
		$category = SkinType::where('id', $id)->first();
		//if($category->products->count() == 0){
			$category->delete();
			return redirect($this->redirectTo)->with('success','Skin type deleted successfully!');
		//}
			//return redirect($this->redirectTo)->with('warning','Cannot lose your masterpiece!');
	}

	/**
	 * delete a product size
	 * e.g. (s,xs,med, xl)
	 *
	 * @param Request $request
	 * @param [int] $id
	 * @return [response]
	 */
	public function deleteSize($id){
		$size = Size::where('id', $id)->first();
		//if($size->products->count() == 0){
			$size->delete();
			return redirect($this->redirectTo)->with('success','Size settings deleted successfully!');
		//}
			//return redirect($this->redirectTo)->with('warning','Cannot lose your masterpiece!');
	}

	/**
	 * delete a product material
	 * e.g. (pambuk, ku di un)
	 * @param Request $request
	 * @param [int] $id
	 * @return [response]
	 */
	public function deleteMaterial($id){
		$material = Material::where('id', $id)->first();
		//if($material->products->count() == 0){
		$material->delete();
		return redirect($this->redirectTo)->with('success','Material settings deleted successfully!');
		//}
			//return redirect($this->redirectTo)->with('warning','Cannot lose your masterpiece!');
	}

	/**
	 * delete a product color
	 * e.g. (blu, e zeze, e bardhe, jeshile)
	 * @param Request $request
	 * @param [int] $id
	 * @return [response]
	 */
	public function deleteColor($id){
		$color = Color::where('id', $id)->first();
		//if($color->products->count() == 0){
		$color->delete();
			return redirect($this->redirectTo)->with('success','Ngjyra deleted successfully!');
		//}
			//return redirect($this->redirectTo)->with('warning','Cannot lose your masterpiece!');
	}
}
