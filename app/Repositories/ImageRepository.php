<?php

namespace App\Repositories;
use Image;
use Storage;
use App\Models\ProductImage;

class ImageRepository {

	/**
	 * thumbnail image dir
	 */
	CONST THUMB_DIR = '/front/products/thumbs/';
	CONST MAIN_DIR = '/front/products/images/';

	/**
	 * create image and return file name
	 * @param  [type] $img [description]
	 * @return [type]      [description]
	 */
	public function saveProductImage($img){
		$filename = time() . '-' . $img->getClientOriginalName();
		$filename = $this->clear($filename);
		$path = public_path(self::MAIN_DIR . $filename);

		if (!Storage::disk('public')->has(self::MAIN_DIR)) {
			mkdir(public_path().self::MAIN_DIR, 0755, true);
		}

		Image::make($img)->save($path,70);

		// create thumbnail of image
		$this->createThumbFromImg($img,$filename);

		//store image path to database
		return $this->savePathToDB($filename);
	}

	/**
	 * create thumbnail from main image
	 * @param  [type] $img      [description]
	 * @param  [type] $filename [description]
	 * @return [type]           [description]
	 */
	public function createThumbFromImg($img,$filename){

		$image = Image::make($img);
		$path = public_path(self::THUMB_DIR . $filename);

		if (!Storage::disk('public')->has(self::THUMB_DIR)) {
			mkdir(public_path().self::THUMB_DIR, 0755, true);
		}
		//prevent image streching
		$image->resize(null, 580, function ($constraint) {
			$constraint->aspectRatio();
			$constraint->upsize();
		});

		$image->save($path,60);
		return;
	}

	/**
	 * Save Image path to db
	 * @param  string $filename
	 * @param  int    $articleId
	 * @return
	 */
	public function savePathToDB($filename){
		$image = new ProductImage;

		$image->path = $filename;
		$image->save();
		return $image;
	}

	/**
	 * upload user thumbnail
	 * @param  [type] $img [description]
	 * @return [type]      [description]
	 */
	public function uploadUserThumb($img){
		$image = Image::make($img);
		$filename = time() . '-' . $img->getClientOriginalName();
		$filename = $this->clear($filename);
		$path = public_path(self::USER_DIR . $filename);


		//prevent image streching
		$image->resize(120, null, function ($constraint) {
			$constraint->aspectRatio();
			$constraint->upsize();
		});

		$this->saveUserPathToDB($filename);
		$image->save($path,60);
	}

	/**
	 * save path to database
	 * @param  [type] $filename [description]
	 * @return [type]           [description]
	 */
	protected function saveUserPathToDB($filename){
		$image = new UserImage;
		$user = $this->getAuthUser();

		$oldImg = UserImage::where('user_id',$user->id)->first();

		//if user has not default image , delete it from directory
		if($oldImg->path != "user.png") {
			Storage::disk('public')->delete(self::USER_DIR . $oldImg->path);
		}

		if($oldImg){
			//delete record from database
			$oldImg->delete();

			$image->path = $filename;
			$image->user_id = $user->id;
			$image->save();
		}

	}
	public function getImgPathsById($articleId){
		return NewsImage::where('news_id',$articleId)->first()->path;
	}

	public function updateImg($img,$articleId){
			$path = $this->getImgPathsById($articleId);

			//delete images from /news/images and /news/thumbs directory
			$this->deleteImgs($path);

			//delete old image path from database
			NewsImage::where('path',$path)->delete();


			// call saveImg() to handle save process
			// 1.save img path to /news/images directory
			// 2.create thumbnail from image and save to /news/thumbs directory
			// 3.save path to database
			$this->saveImg($img,$articleId);
	}

	/**
	 * Delete images from directory
	 * @param  [type] $path [description]
	 * @return [type]       [description]
	 */
	public function deleteImgs($path){
			Storage::disk('public')->delete(self::THUMB_DIR . $path);
			Storage::disk('public')->delete(self::MAIN_DIR . $path);

			return;
	}

	public function deleteById($id){
		$pr = ProductImage::where('id' ,$id)->first();
		$pr->delete();
		return;
	}

	private function clear($string){
	   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
	   $string = preg_replace('/[^A-Za-z0-9\-.]/', '', $string); // Removes special chars.

	   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
	}
}