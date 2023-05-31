<?php
namespace Exceptions;

class EntityNotFoundException extends \Exception {
	protected $code = 401;
	protected $message = "No entity found";
}
