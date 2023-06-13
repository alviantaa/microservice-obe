<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseStoreRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
	 */
	public function rules(): array
	{
		return [
			// 'id' => ['integer'],
			'creator_user_id' => ['integer'],
			'study_program_id' => ['integer'],
			'name' => ['string'],
			'code' => ['string'],
			'course_credit' => ['integer'],
			'lab_credit' => ['integer'],
			'type' => ['string'],
			'short_description' => ['string'],
			'minimal_requirement' => ['string'],
			'study_material' => ['string'],
			'learning_media' => ['string'],
		];
	}
}
