<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class StoreCourseRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'category_id' => 'required|exists:categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'short_description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'duration_days' => 'nullable|integer|min:1',
            'mode' => 'nullable|in:virtual,in_person,hybrid',
            'level' => 'nullable|string',
            'max_delegates' => 'nullable|integer|min:1',
        ];
    }
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(['success'=>false,'message'=>'Validation error','errors'=>$validator->errors()],422));
    }
}
