<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseClassUpdateRequest extends FormRequest
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
        'course_id' => ['sometimes', 'integer'],
        'name' => ['sometimes', 'string'],
        'class_code' => ['sometimes', 'string'],
        'thumbnail_img' => ['sometimes', 'string'],
        'creator_user_id' => ['sometimes', 'integer'],
        'syllabus_id' => ['sometimes', 'integer'],
      ];
    } else {
      return [
        'course_id' => ['required', 'integer'],
        'name' => ['required', 'string'],
        'class_code' => ['required', 'string'],
        'thumbnail_img' => ['required', 'string'],
        'creator_user_id' => ['required', 'integer'],
        'syllabus_id' => ['required', 'integer'],
      ];
    }
  }
}
