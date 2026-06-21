<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class StorePaymentRequest extends FormRequest {
    public function authorize(): bool { return true; }
    public function rules(): array {
        return [
            'enrolment_id' => 'required|exists:enrolments,id',
            'gateway' => 'required|in:paystack,flutterwave',
        ];
    }
    protected function failedValidation(Validator $validator) {
        throw new HttpResponseException(response()->json(['success'=>false,'message'=>'Validation error','errors'=>$validator->errors()],422));
    }
}
