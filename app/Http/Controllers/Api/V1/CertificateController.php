<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CertificateResource;
use App\Models\Certificate;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    use ApiResponse;

    public function index(Request $request)
    {
        $certs = Certificate::with(['course'])
            ->where('user_id', $request->user()->id)
            ->get();
        return $this->success(CertificateResource::collection($certs));
    }

    public function show(Certificate $certificate)
    {
        return $this->success(new CertificateResource($certificate->load(['user','course','enrolment'])));
    }

    public function verify(string $code)
    {
        $cert = Certificate::with(['user','course'])->where('verification_code', $code)->first();
        if (!$cert) return $this->error('Certificate not found or invalid code', 404);
        return $this->success(new CertificateResource($cert), 'Certificate is valid');
    }

    public function download(Certificate $certificate)
    {
        // In production generate PDF here
        return $this->success([
            'certificate_number' => $certificate->certificate_number,
            'download_url' => url("/api/v1/certificates/{$certificate->id}/pdf"),
        ], 'Certificate download link');
    }

    public static function issue(int $userId, int $courseId, int $enrolmentId): Certificate
    {
        return Certificate::create([
            'user_id' => $userId,
            'course_id' => $courseId,
            'enrolment_id' => $enrolmentId,
            'certificate_number' => 'CERT-' . strtoupper(Str::random(10)),
            'verification_code' => Str::uuid()->toString(),
            'issued_at' => now(),
        ]);
    }
}
