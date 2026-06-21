<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class StoreEnrolmentRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'course_id' => 'required|exists:courses,id',
            'schedule_id' => 'nullable|exists:course_schedules,id',
        ];
    }
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(['success'=>false,'message'=>'Validation error','errors'=>$validator->errors()],422));
    }
}
