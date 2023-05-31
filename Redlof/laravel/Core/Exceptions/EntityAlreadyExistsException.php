<?php
namespace Exceptions;

class EntityAlreadyExistsException extends \Exception {
	protected $code = 401;
	protected $message = "Entity already exists";
}
