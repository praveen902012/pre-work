
# README #

This README would normally document whatever steps are necessary to get your application up and running.

### What is this repository for? ###

* Quick summary: __Right To Education Web Application__
* Version: 1.0
* [Learn Markdown](https://bitbucket.org/tutorials/markdowndemo)

### How do I get set up? ###

* Summary of set up: 
* Configuration
	1. Local server setup
	2. Install PHP
	3. Install Composer 
	4. Install nodejs
	5. Run npm install
	6. Laravel installation and env keys
		1. Run composer install
		2. Generate env file for your project(_run php artisan key:generate_)
		3. Generate JWT_SECRET(_run php artisan jwt:secret_)
		4. Update rest of the env keys as per your customization
	7. Give permission to bootstrap and storage folder [_run chmod 0777 -R bootstrap/cache storage/_]
	8. Run composer dumpautoload
	9. Run gulp
* Additional configuration (If previously not installed)
	1. Install Memcache 
	2. Install Curl
	3. Install Openssl
	4. Install Php5-mcrypt
	5. Install Gulp
	6. Install Sass
* AWS configuration (Add the following keys to your ENV)
	1. AWS_ACCESS_KEY_ID
	2. AWS_SECRET_ACCESS_KEY
	3. AWS_REGION
	4. AWS_S3_BUCKET
	5. AWS_S3_BUCKET_FOLDER
	6. AWS_S3_BUCKET_DB_BK
* Dependencies
	1. __PHP version - 7.0.30__
	2. __Laravel version - 5.5.40__
	3. __Angular version - 1.6.7__
* Database configuration
* How to run tests
* Deployment instructions
* References
	1. [laravel](https://laravel.com/docs/5.5/installation)
	2. [nodejs](https://www.digitalocean.com/community/tutorials/how-to-install-node-js-on-ubuntu-16-04)

### Contribution guidelines ###

* Writing tests
* Code review
* Other guidelines

### Who do I talk to? ###

* Repo owner or admin
* Other community or team contact


### Note ###

* On initial commit, Add public folder to your repo.
readme.md
Displaying readme.md.