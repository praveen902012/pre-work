<?php
namespace Exceptions;

class ActionFailedException extends \Exception {
	protected $code = 401;
	protected $message = "Action Failed";
}
