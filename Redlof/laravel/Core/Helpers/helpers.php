<?php

function getAsset($file) {

	if (config('app.env') === 'local') {
		return $file;
	}

	// read the build json
	// read the correspending value & return

	$buildJson = json_decode(file_get_contents(public_path('build/build.json')), true);

	if (array_key_exists($file, $buildJson)) {
		return 'build/' . $buildJson[$file];
	}

	return $file;
}

function api($msg, $data = [], $status = 200) {

	return response()->json(['msg' => $msg, 'data' => $data], $status);
}

function upload($folder, $fileObject, $visibility = 'private') {
	
	$filename = \Uuid::generate()->string . '.' . $fileObject->guessExtension();

	// $fileObject = \Image::open($fileObject);

	// $autorotate = new Autorotate();
	// $fileObject = $autorotate->apply($fileObject);

	return \Storage::disk('s3')->putFileAs($folder, $fileObject, $filename, $visibility);
}

function googletrans($string, $target){

	if($target == "default" || $target == null ){

		return $string;

	}else{

		$translator = new \Dedicated\GoogleTranslate\Translator;

		$string = $translator->setTargetLang($target)->translate($string);

		return $string;	
	}

}