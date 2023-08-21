<?php
namespace App\Helpers\Classes;

use Illuminate\Support\Facades\DB;
use Validator;
use Image;

class EasyImage{

	public static $status = false;
	public static $message = 'Failed';

	public static $image = '';
	public static $save_path = '';
	public static $image_name = '';
	public static $max_size = 15;
	public static $ext = '.jpg';

	public static $validate = false;
	public static $request = '';

	public static $image_height = '';
	public static $image_width = '';
	public static $crop = '';
	public static $resize = '';

	public static $uploaded_image='';

	public static $image_path = '';

	public static $table_name = '';
	public static $column_name = '';
	public static $row_id = '';


	public static function model($tb_name,$cl_name,$row_id)
	{
		self::$table_name = $tb_name;
		self::$column_name = $cl_name;
		self::$row_id = $row_id;
		return new self;
	}

	public static function refresh_id($value='')
	{
	    $refresh_id = '';
	    if(!empty($value)){
	        $myfile = fopen("refresh_id.txt", "w+");
	        fwrite($myfile, $value);
	        fclose($myfile);
	    }else{
	        if(file_exists('refresh_id.txt')){
	            return file_get_contents('refresh_id.txt');
	        }else{
	            $myfile = fopen("refresh_id.txt", "w+");
	            fwrite($myfile, rand());
	            fclose($myfile);
	            return rand();
	        }
	    }
	}
	public static function image($request_data,$input_img_name)
	{
		self::$request = $request_data;
		self::$image = $input_img_name;
		return new self;
	}
	public static function path($imgpath)
	{
		if(!is_dir($imgpath)){
			mkdir($imgpath);
		}
		self::$save_path = $imgpath;
		return new self;
	}
	public static function image_path($img_path)
	{
		self::$image_path = $img_path;
		return new self;
	}

	public static function name($imgname)
	{
		self::$image_name = $imgname;
		return new self;
	}
	public static function ext($ext_is)
	{
		self::$ext = $ext_is;
		return new self;
	}
	public static function max($imgmax)
	{
		self::$max_size = $imgmax;
		return new self;
	}
	public static function crop($img_width,$img_height)
	{
		self::$image_height = $img_height;
		self::$image_width = $img_width;
		self::$crop = true;
		return new self;
	}
	public static function resize($img_width,$img_height)
	{
		self::$image_height = $img_height;
		self::$image_width = $img_width;
		self::$resize = true;
		return new self;
	}
	public static function save()
	{
		self::$message = 'Something is missing';
		if(!empty(self::$image_path)){
			self::refresh_id(rand());
            if(file_exists(self::$image_path)){
				$img_crop = self::$crop;
				$img_resize = self::$resize;
				$img_height = self::$image_height;
				$img_width = self::$image_width;
            	$imageName = self::$image_name.self::$ext;
            	$img = Image::make(self::$image_path);
                self::$message = 'Crop or resize is not set';
                if($img_crop == true){
                	self::$message = 'Invalid image height & width';
                	if(!empty($img_width) and !empty($img_height)){
		                $img->fit($img_width, $img_height, function ($constraint) {
		                    $constraint->upsize();
		                })->save(self::$save_path.$imageName,100);
						self::$status = true;
						self::$message = 'Image Uploaded Successfully';
						self::$uploaded_image = $imageName;
					}
                }elseif($img_resize == true){
                	self::$message = 'Invalid image height & width';
	                if(!empty($img_width) and !empty($img_height)){
	                	$img->resize($img_width, $img_height, function ($constraint){
		                    $constraint->aspectRatio();
		                })->save(self::$save_path.$imageName,100);
						self::$status = true;
						self::$message = 'Image Uploaded Successfully';
						self::$uploaded_image = $imageName;
					}
               	}
    		}else{
    			self::$message = 'Invalid image path';
    		}
		}elseif(!empty(self::$request) and !empty(self::$image) and !empty(self::$save_path) and !empty(self::$image_name)){
			self::refresh_id(rand());
			$request = self::$request;
			$imagex = self::$image;
			$img_name = self::$image_name;
			$img_crop = self::$crop;
			$img_resize = self::$resize;
			$img_height = self::$image_height;
			$img_width = self::$image_width;
			$maxsize = floatval(self::$max_size)*1024;
			$image_ext = self::$ext;
			$validation = Validator::make($request->all(), [
	          $imagex => 'required|image|mimes:jpeg,png,jpg|max:'.$maxsize,
	        ]);
	        if($validation->passes()){
          		$image = $request->$imagex;
          		$imageName = $img_name.$image_ext;
                $img = Image::make($image->path());
                self::$message = 'dir does not exist';
                if(is_dir(self::$save_path)){
	                if($img_crop == true){
	                	self::$message = 'Invalid image height & width';
	                	if(!empty($img_width) and !empty($img_height)){
			                $img->fit($img_width, $img_height, function ($constraint) {
			                    $constraint->upsize();
			                })->save(self::$save_path.$imageName,100);
							self::$status = true;
							self::$message = 'Image Uploaded Successfully';
							self::$uploaded_image = $imageName;
						}
	                }elseif($img_resize == true){
	                	self::$message = 'Invalid image height & width';
		                if(!empty($img_width) and !empty($img_height)){
		                	$img->resize($img_width, $img_height, function ($constraint){
			                    $constraint->aspectRatio();
			                })->save(self::$save_path.$imageName,100);
							self::$status = true;
							self::$message = 'Image Uploaded Successfully';
							self::$uploaded_image = $imageName;
						}
	               	}else{
	               		$image->move(self::$save_path, $imageName);
	               		self::$status = true;
						self::$message = 'Image Uploaded Successfully';
						self::$uploaded_image = $imageName;
	               	}
        		}
		    }
		    if(!empty($validation->errors()->all())){
		    	foreach ($validation->errors()->all() as $err_msg){
		    		self::$message = $err_msg;
		    		break;
		    	}
	    	}
		}

		if(!empty(self::$table_name) and !empty(self::$column_name) and !empty(self::$row_id) and self::$status == true){
			$tb = DB::table(self::$table_name)->where('id',self::$row_id)->update([self::$column_name => self::$uploaded_image]);
		}

		$retn_json = json_encode(['status'=>self::$status,'message'=>self::$message,'name'=>self::$uploaded_image]);
		return json_decode($retn_json);
	}
}


?>
