<?php
namespace Exceptions;

class EntryCreationFailed extends \Exception {
	protected $code = 401;
	protected $message = "Entry creation failed";
}
