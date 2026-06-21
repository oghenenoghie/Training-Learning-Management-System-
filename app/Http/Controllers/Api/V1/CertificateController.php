<?php
namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CertificateResource;
use App\Mail\CertificateIssued;
use App\Models\Certificate;
use App\Traits\ApiResponse;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
        $certificate->load(['user', 'course']);
        $pdf = Pdf::loadView('certificates.certificate', ['certificate' => $certificate])
            ->setPaper('a4', 'landscape');
        return $pdf->download("certificate-{$certificate->certificate_number}.pdf");
    }

    public static function issue(int $userId, int $courseId, int $enrolmentId): Certificate
    {
        $certificate = Certificate::create([
            'user_id'            => $userId,
            'course_id'          => $courseId,
            'enrolment_id'       => $enrolmentId,
            'certificate_number' => 'CERT-' . strtoupper(Str::random(10)),
            'verification_code'  => Str::uuid()->toString(),
            'issued_at'          => now(),
        ]);

        $user = \App\Models\User::find($userId);
        if ($user) {
            Mail::to($user->email)->queue(new CertificateIssued($certificate->load(['user', 'course'])));
        }

        return $certificate;
    }
}
