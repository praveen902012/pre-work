<?php
namespace Exceptions;

class UnAuthorizedException extends \Exception {
	protected $code = 401;
	protected $message = "You are not authorized to perform this action";
}
