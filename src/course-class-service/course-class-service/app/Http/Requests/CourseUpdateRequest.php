<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseUpdateRequest extends FormRequest
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
		$method = $this->method();
		if ($method == 'PATCH') {
			return [
				'study_program_id' => ['sometimes', 'integer'],
				'code' => ['sometimes', 'string'],
				'name' => ['sometimes', 'string'],
				'course_credit' => ['sometimes', 'integer'],
				'lab_credit' => ['sometimes', 'integer'],
				'type' => ['sometimes', 'string'],
				'short_description' => ['sometimes', 'string'],
				'minimal_requirement' => ['sometimes', 'string'],
				'study_material' => ['sometimes', 'string'],
				'learning_media' => ['sometimes', 'string']
			];
		} else {
			return [
				'study_program_id' => ['required', 'integer'],
				'code' => ['required', 'string'],
				'name' => ['required', 'string'],
				'course_credit' => ['required', 'integer'],
				'lab_credit' => ['required', 'integer'],
				'type' => ['required', 'string'],
				'short_description' => ['required', 'string'],
				'minimal_requirement' => ['required', 'string'],
				'study_material' => ['required', 'string'],
				'learning_media' => ['required', 'string']
			];
		}
	}
}
