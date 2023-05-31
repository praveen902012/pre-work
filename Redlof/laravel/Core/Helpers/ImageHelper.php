<?php
namespace Redlof\Core\Helpers;
/**
 * API Helper class
 */
class ImageHelper {

	function __construct() {

	}

	public static function resizeImageSize($filename, $file_path, $width = 600, $height = 400) {
		$ImgObj = \Image::make($file_path);

		$ImgObj->resize($width, $height, function ($constraint) {
			$constraint->aspectRatio();
		});

		$ImgObj->save(public_path('temp/' . $filename));

		return $ImgObj;
	}

	public static function resizeImage($file_name, $width, $height, $base_dir, $folder_name) {
		$file_path = asset('temp/' . $file_name);

		self::resizeImageSize($file_name, $file_path, $width, $height);

		\AWSHelper::pushToS3WithBody($file_name, $file_path, $folder_name);

		return true;
	}

	public static function saveProfilePicFromSocial($Type, $sourcePath, $filename) {
		// Call the Curl Library
		$curl = New Curl;

		$path = public_path() . '/img/temp/' . $filename;

		// Call the Curl library function to get the data
		$data = $curl->simple_get($sourcePath);

		// Open file with append mode
		$fd = fopen($path, 'a+');

		if ($fd == FALSE) {
			return FALSE;
		}

		// Write data into file
		$numOfbytes = fwrite($fd, $data);

		if ($numOfbytes === FALSE) {
			return FALSE;
		}

		// Close the file
		fclose($fd);

		// Resize profile photo for google
		if ($Type === 'Google') {
			\Image::make($path, array(
				'width' => 150,
				'height' => 150,
				'greyscale' => false,
			))->save($path);
		}
	}

	public static function generateUserDefaultPhoto($userObj = false, $file_name = 'default.jpg', $size = 80, $background_color = '#666', $text_color = '#FFF') {

		if (!$userObj) {
			return fasle;
		}

		if ($size <= 0) {
			return fasle;
		}

		if ($file_name == 'default.jpg') {
			$file_name = strtotime($userObj->created_at) . '_' . $userObj->id . '.png';
		}

		$font_file = public_path() . '/fonts/montserrat-light-webfont.ttf';

		$background_color_arr = array('#093145', '#107896', '#829356', '#3c6478', '#bca136', '#c2571a', '#9a2617', '#666666');
		$background_color = $background_color_arr[array_rand($background_color_arr, 1)];

		$firstName = substr($userObj->first_name, 0, 1);
		$lastName = substr($userObj->last_name, 0, 1);

		$firstName = strtoupper($firstName);
		$lastName = strtoupper($lastName);

		$str = $firstName . $lastName;

		$fileObj = \Image::canvas($size, $size, $background_color)->text($str, $size / 2, $size / 2, function ($font) use ($size, $text_color, $font_file) {
			$font->file($font_file);
			$font->size($size / 2);
			$font->color($text_color);
			$font->align('center');
			$font->valign('middle');
		});

		$fileObj->save(public_path() . '/temp/' . $file_name);
		$fileObj = asset('temp/' . $file_name);

		$s3 = \Storage::disk('s3');
		$filePath = '/userphotos/' . $file_name;
		$s3->put($filePath, file_get_contents($fileObj));

		$fileThumbPath = '/userphotos/thumb/' . $file_name;

		$s3->put($fileThumbPath, file_get_contents($fileObj));
		\AppHelper::cleanTempFile($file_name);

		return $file_name;
	}

	public static function updateProfilePhoto($user, $imgObj) {

		$FileName = strtotime($user->created_at) . '_' . $user->id . '.' . $imgObj->getClientOriginalExtension();

		\AWSHelper::pushToS3($FileName, $imgObj, 'userphotos');
		\ImageHelper::resizeImage($FileName, 200, 200, 'userphotos', 'userphotos');
		\ImageHelper::resizeImage($FileName, 80, 80, 'userphotos', 'userphotos/thumb');

		return $FileName;
	}

	public static function ProfileImageUpload($fileObj, $file_name) {
		$fileObj = \Image::make($fileObj);

		$fileObj->save(public_path() . '/temp/' . $file_name);

		$file_Path = asset('temp/' . $file_name);

		// Distach the job to queue
		//dispatch(new \Redlof\Laravel\Engine\Core\Jobs\ProfileImageUpload($file_Path, $file_name, 'userphotos'));
		self::exectuteImageUpload($file_name, 'userphotos/', true);
	}

	public static function ImageUpload($fileObj, $file_name, $folder_name, $width = 200, $height = 200) {

		$fileObj = \Image::make($fileObj);

		$fileObj->save(public_path() . '/temp/' . $file_name);

		$file_Path = asset('temp/' . $file_name);

		self::exectuteImageUpload($file_name, $folder_name, true);
	}

	public static function FileUpload($fileObj, $file_name, $folder_name) {
		$fileObj->move(public_path() . '/temp/' . $file_name, $file_name);

		$file_Path = asset('temp/' . $file_name . '/' . $file_name);

		\AWSHelper::pushToS3WithBody($file_name, $file_Path, $folder_name);

		\AppHelper::cleanTempFileDir($file_name);
	}

	public static function filenameSansExtension($fileObj) {
		$filename = basename($fileObj->getClientOriginalName(), '.' . $fileObj->getClientOriginalExtension());
		return str_slug($filename);
	}

	public static function createFileName($fileObj) {
		$filename = self::filenameSansExtension($fileObj);
		$file_name = $filename . "_" . \Carbon::now()->timestamp . '_' . rand() . '.' . $fileObj->getClientOriginalExtension();
		return $file_name;
	}

	public static function uploadMemberInitialPhoto($user) {
		$file_name = \ImageHelper::generateUserDefaultPhoto($user);
		\UserHelper::updateFirstTimeUserPhoto($user->id, $file_name);
		return $file_name;
	}

	public static function ImageUploadToS3($obj, $name, $folder, $thumb = false, $width = 250, $height = 250, $small = true) {

		$image_normal = \Image::make($obj);
		$image_normal = $image_normal->stream();

		\Storage::disk('s3')->put($folder . $name, file_get_contents($obj));

		if ($thumb) {
			$image_thumb = \Image::make($obj)->resize($width, $height, function ($constraint) {
				$constraint->aspectRatio();
			});

			//file_put_contents(public_path('temp/thumb_' . $name), file_get_contents($obj));

			$image_thumb = $image_thumb->stream();
			\Storage::disk('s3')->put($folder . 'thumb/' . $name, $image_thumb->__toString());
		}

		if ($small) {

			$image_thumb = \Image::make($obj)->resize(35, 35, function ($constraint) {
				$constraint->aspectRatio();
			});

			$image_thumb = $image_thumb->stream();
			\Storage::disk('s3')->put($folder . 'small/' . $name, $image_thumb->__toString());
		}

		//self::exectuteImageUpload($name, $folder, $thumb);

	}

	public static function ImageUploadToS3Queue($obj, $name, $folder, $thumb = false, $width = 250, $height = 250) {

		file_put_contents(public_path('temp/' . $name), file_get_contents($obj));

		if ($thumb) {
			$image_thumb = \Image::make($obj)->resize($width, $height, function ($constraint) {
				$constraint->aspectRatio();
			});

			file_put_contents(public_path('temp/thumb_' . $name), file_get_contents($obj));
		}

		dispatch(new \Redlof\Laravel\Engine\Core\Jobs\ImageUpload($name, $folder, $thumb));
	}

	public static function exectuteImageUpload($name, $folder, $thumb) {

		$main_image = asset('temp/' . $name);

		\Storage::disk('s3')->put($folder . $name, file_get_contents($main_image), 'public');

		\File::delete(public_path() . '/temp/' . $name);

		if ($thumb) {

			$thumb_image = asset('temp/thumb_' . $name);

			\Storage::disk('s3')->put($folder . 'thumb/' . $name, file_get_contents($thumb_image), 'public');

			\File::delete(public_path() . '/temp/thumb_' . $name);
		}
	}
}