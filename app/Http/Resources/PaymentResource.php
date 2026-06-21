<?php
namespace App\Http\Resources;
use Illuminate\Http\Resources\Json\JsonResource;
class PaymentResource extends JsonResource {
    public function toArray($request): array {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'enrolment_id' => $this->enrolment_id,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'reference' => $this->reference,
            'gateway' => $this->gateway,
            'status' => $this->status,
            'paid_at' => $this->paid_at,
            'invoice_number' => $this->invoice_number,
            'vat_amount' => $this->vat_amount,
            'created_at' => $this->created_at,
        ];
    }
}
