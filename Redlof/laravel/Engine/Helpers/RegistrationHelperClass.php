<?php
namespace Helpers;

class RegistrationHelperClass {

	public static function uploadFiles($request) {

		$attachments = [
			'birth_certificate' => [],
			'income_certificate' => [],
			'address_proof' => [],
			'parent_aadhar_card' => [],
			'child_aadhar_card' => [],
		];

		if ($request->hasFile('birth_certificate')) {

			$filename = \ImageHelper::createFileName($request->birth_certificate);
			\ImageHelper::FileUpload($request->birth_certificate, $filename, 'students');

			$object = [
				'f' => $filename,
				'n' => $request->birth_certificate->getClientOriginalName(),
			];

			$attachments['birth_certificate'] = $object;

		}

		if ($request->hasFile('income_certificate')) {

			$filename = \ImageHelper::createFileName($request->income_certificate);
			\ImageHelper::FileUpload($request->income_certificate, $filename, 'students');

			$object = [
				'f' => $filename,
				'n' => $request->income_certificate->getClientOriginalName(),
			];

			$attachments['income_certificate'] = $object;
		}

		if ($request->hasFile('address_proof')) {

			$filename = \ImageHelper::createFileName($request->address_proof);
			\ImageHelper::FileUpload($request->address_proof, $filename, 'students');

			$object = [
				'f' => $filename,
				'n' => $request->address_proof->getClientOriginalName(),
			];

			$attachments['address_proof'] = $object;
		}

		if ($request->hasFile('parent_aadhar_card')) {

			$filename = \ImageHelper::createFileName($request->parent_aadhar_card);
			\ImageHelper::FileUpload($request->parent_aadhar_card, $filename, 'students');

			$object = [
				'f' => $filename,
				'n' => $request->parent_aadhar_card->getClientOriginalName(),
			];

			$attachments['parent_aadhar_card'] = $object;
		}

		if ($request->hasFile('child_aadhar_card')) {

			$filename = \ImageHelper::createFileName($request->child_aadhar_card);
			\ImageHelper::FileUpload($request->child_aadhar_card, $filename, 'students');

			$object = [
				'f' => $filename,
				'n' => $request->child_aadhar_card->getClientOriginalName(),
			];

			$attachments['child_aadhar_card'] = $object;
		}

		return $attachments;

	}

}