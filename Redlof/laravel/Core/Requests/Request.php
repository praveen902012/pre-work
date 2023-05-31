<?php
namespace Redlof\Core\Requests;

use Exceptions\ValidationFailedException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest {

	protected function failedValidation(Validator $validator) {

		$html = $this->makeErrors($validator);

		throw new ValidationFailedException($html['msg'], $html['object']);
	}

	protected function makeErrors(Validator $validator) {

		$errors = $validator->errors()->all();
		$html['msg'] = '';
		$html['object'] = [];

		foreach ($errors as $key => $value) {
			$html['msg'] .= $value . '<br>';
			$html['object'] = array_merge($html['object'], [$key => $value]);
		}

		return $html;
	}
}