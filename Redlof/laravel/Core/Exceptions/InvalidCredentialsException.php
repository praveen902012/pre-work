<?php
namespace Exceptions;

class InvalidCredentialsException extends \Exception {
	protected $code = 401;
	protected $message = "Invalid Credentials";
}