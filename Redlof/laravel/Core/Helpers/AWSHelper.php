<?php
namespace Redlof\Core\Helpers;

use Aws\Exception\S3Exception;
use Aws\S3\S3Client;
use Config;
use Exceptions\ActionFailedException;

/**
 * AWS wrapper class to use the aws storage service
 */
class AWSHelper {

	function __construct() {
	}

	/**
	 * [pushToS3 This function will push the resource to AWS s3 bucket]
	 * @param [string] $[key] [Key is the file name to identify the file as key]
	 * @param [string] $[folder] [This param will take folder name inside bucket]
	 * @param [string] $[bucket] [This param will take bucket name by default it will take user profile bucket name]
	 * @param [string] $[path/file object] [This is the complete path for file from where it will take as source or it can be file object as well]
	 * @return [object] [Result]
	 */
	public static function pushToS3($key, $fileObj, $folder) {
		// Create the client for s3
		// Call the s3 put object function
		// Pass the required params like bucket, Key, SourceFile
		// Use try catch to call push object function
		// return the object

		if ($folder == null || !isset($folder)) {
			throw new ActionFailedException("Could not able to complete the action");
		}

		$key = $folder . '/' . $key;

		$s3Client = self::getS3Client();

		try {
			$Result = $s3Client->putObject(array(
				'Bucket' => Config::get('redlof.aws_s3_bucket'),
				'Key' => $key,
				'SourceFile' => $fileObj,
				'ACL' => 'public-read',
			));
		} catch (S3Exception $e) {
			throw new ActionFailedException("Looks like some issues in uploading the file");
		}

		return $Result;
	}

	/**
	 * [getFromS3 This function will get the resource from AWS s3 bucket]
	 * @param [string] $[key] [Key is the file name to identify the file as key]
	 * @param [string] $[folder] [This param will take folder name inside bucket]
	 * @param [string] $[bucket] [This param will take bucket name by default it will take user profile bucket name]
	 * @return [object] [result]
	 */
	public static function getFromS3($key, $folder) {
		// Create the client for s3
		// Call the s3 get object function
		// Pass the required params like bucket, Key

		if ($folder == null || !isset($folder)) {
			throw new ActionFailedException("Could not able to complete the action");
		}

		$key = $folder . '/' . $key;

		$s3Client = self::getS3Client();

		try {
			$Result = $s3Client->getObjectUrl(Config::get('redlof.aws_s3_bucket'), $key);
		} catch (S3Exception $e) {
			throw new ActionFailedException("Not able to get the object from s3");
		}

		return $Result;
	}

	/**
	 * [checkS3Object This function will check if object has or not]
	 * @param [string] $[key] [Key is the file name to identify the file as key]
	 * @param [string] $[folder] [This param will take folder name inside bucket]
	 * @param [string] $[bucket] [This param will take bucket name by default it will take user profile bucket name]
	 * @return [boolean] [true / false]
	 */
	public static function checkS3Object($key, $folder) {

		if ($folder == null || !isset($folder)) {
			throw new ActionFailedException("Could not able to complete the action");
		}

		$key = $folder . '/' . $key;

		$s3Client = self::getS3Client();

		return $s3Client->doesObjectExist(Config::get('redlof.aws_s3_bucket'), $key);
	}

	/**
	 * [deleteFromS3 This function will delete the resource to AWS s3 bucket]
	 * @param [string] $[key] [Key is the file name to identify the file as key]
	 * @param [string] $[folder] [This param will take folder name inside bucket]
	 * @param [string] $[bucket] [This param will take bucket name by default it will take user profile bucket name]
	 * @return [object] [result]
	 */
	public static function deleteFromS3($key, $folder) {
		// Create the client for s3
		// Call the s3 delete object function
		// Pass the required params like bucket, Key

		if ($folder == null || !isset($folder)) {
			throw new ActionFailedException("Could not able to complete the action");
		}

		$key = $folder . '/' . $key;

		$s3Client = self::getS3Client();

		try {
			$Result = $s3Client->deleteObject(array(
				'Bucket' => Config::get('redlof.aws_s3_bucket'),
				'Key' => $key,
			));
		} catch (S3Exception $e) {
			throw new ActionFailedException("Not able to delete object from s3");
		}

		return $Result;
	}

	public static function pushToS3WithBody($key, $fileObj, $folder) {

		$key = $folder . '/' . $key;

		$s3Client = self::getS3Client();

		$curl = new \anlutro\cURL\cURL;
		$body = $curl->get($fileObj);

		try {
			$Result = $s3Client->putObject(array(
				'Bucket' => Config::get('redlof.aws_s3_bucket'),
				'Key' => $key,
				'Body' => $body,
				'ACL' => 'public-read',
			));

		} catch (S3Exception $e) {
			throw new ActionFailedException("Looks like some issues in uploading the file");
		}

		return $Result;
	}

	public static function uploadImageToS3($file_obj, $folder_name, $thumb = false, $file_name = '') {
		if ($file_name == '') {
			$file_name = rand() . \Carbon::now()->timestamp . '.' . $file_obj->getClientOriginalExtension();
		}

		// Call the AWS Helper class with push to s3
		\AWSHelper::pushToS3($file_name, $file_obj, $folder_name);

		// Generate thumb and push
		if ($thumb) {
			// Generate the thumbnail as puload to AWS in same folder under thumbs
			self::generateThumbnail($file_name, $folder_name);
		}

		return $file_name;
	}

	public static function generateThumbnail($file_name, $folder_name) {
		$S3ImageURL = getFromS3($file_name, $folder_name);

		$ImageNewObj = ImageHelper::resizeImageSize($file_name, $S3ImageURL, 600, 400);

		// Push for mobile
		\AWSHelper::pushToS3($file_name, $ImageNewObj, $folder_name . '/thumb');

		// Clear the temp dir
		cleanTempDir();

		// TODO: Handle exception
		return true;
	}

	private static function getS3Client() {
		$s3Client = S3Client::factory(array(
			'region' => Config::get('aws.region'),
			'version' => Config::get('aws.version'),
		));
		return $s3Client;
	}

	public static function getSignedUrl($key, $expiry = '+30 minutes') {
		$s3Client = S3Client::factory(array(
			'region' => Config::get('aws.region'),
			'version' => Config::get('aws.version'),
		));

		// Create command
		$cmd = $s3Client->getCommand('GetObject', [
			'Bucket' => Config::get('redlof.aws_s3_bucket'),
			'Key' => $key,
		]);

		// Create signed url
		$request = $s3Client->createPresignedRequest($cmd, $expiry);

		// Get the actual presigned-url
		$presignedUrl = (string) $request->getUri();

		return $presignedUrl;
	}
}