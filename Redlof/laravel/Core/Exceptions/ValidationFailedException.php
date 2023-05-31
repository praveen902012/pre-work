<?php
namespace Exceptions;

class ValidationFailedException extends \Exception {

	public $validator;
	public $response;

	protected $code = 422;
	protected $message = "Validation Error";

	public function __construct($message, $response = null) {

		parent::__construct($message, $this->code);

		$this->message = $message;
		$this->response = $response;
	}

	public function getResponse() {

		return $this->response;
	}
}
