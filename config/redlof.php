<?php

return [

	'name' => 'RightToEducation',
	'logo' => 'rte-logo.png',

	// Mail Related Values
	'MAIL_USERNAME' => env('MAIL_USERNAME'),
	'MAIL_PASSWORD' => env('MAIL_PASSWORD'),
	'MAIL_FROM' => env('MAIL_FROM'),
	'MAIL_NAME' => env('MAIL_NAME'),
	'ADMIN_MAIL' => env('ADMIN_MAIL'),
	'MAIL_HOST' => env('MAIL_HOST'),
	'MAIL_PORT' => env('MAIL_PORT'),
	'MAIL_ENCRYPTION' => env('MAIL_ENCRYPTION'),

	// AWS Related Values
	'AWS_ACCESS_KEY_ID' => env('AWS_ACCESS_KEY_ID'),
	'AWS_SECRET_ACCESS_KEY' => env('AWS_SECRET_ACCESS_KEY'),

	'aws_s3_bucket' => env('AWS_S3_BUCKET'),

	'aws_s3_bucket_folder' => env('AWS_S3_BUCKET_FOLDER', 'rte'),
	'aws_s3_bucket_db_bk' => env('AWS_S3_BUCKET_DB_BK', 'rte.com'),
	'aws_s3_public_url' => 'https://s3.ap-south-1.amazonaws.com/',

	// Social Keys
	'FB_APP_KEY' => env('FACEBOOK_CLIENT_ID'),
	'GOOGLE_APP_KEY' => env('GOOGLE_CLIENT_ID'),
	'AWS_SNS_END_POINT' => env('AWS_SNS_END_POINT'),

];