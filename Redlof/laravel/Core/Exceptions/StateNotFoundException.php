<?php
namespace Exceptions;

class StateNotFoundException extends \Exception {
	protected $code = 404;
	protected $message = "The requested State is not yet in portal.";
}
