<?php
namespace Exceptions;

class TPLFailedException extends \Exception {
	protected $code = 401;
	protected $message = "Something went wrong";
}
