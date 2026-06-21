"use client";

import { DashboardLayout } from "@/components/layout/DashboardLayout";
import { useCertificates } from "@/hooks/useEnrolments";
import { Button } from "@/components/ui/Button";
import { formatDate } from "@/lib/utils";
import { Loader2, Award, Download, Share2 } from "lucide-react";

export default function CertificatesPage() {
  const { data, isLoading } = useCertificates();
  const certs = data?.data ?? [];

  return (
    <DashboardLayout role="delegate" title="My Certificates">
      {isLoading && (
        <div className="flex justify-center py-20">
          <Loader2 size={28} className="text-primary animate-spin" />
        </div>
      )}

      {!isLoading && certs.length === 0 && (
        <div className="flex flex-col items-center py-20 bg-white rounded-lg border border-fog">
          <Award size={48} className="text-fog mb-4" />
          <p className="font-heading text-base text-muted">
            No certificates yet. Complete a course to earn your first certificate.
          </p>
        </div>
      )}

      {!isLoading && certs.length > 0 && (
        <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
          {certs.map((cert) => (
            <div
              key={cert.id}
              className="bg-white rounded-xl border border-fog shadow-card overflow-hidden hover:shadow-float transition-shadow"
            >
              {/* Certificate visual */}
              <div className="h-36 bg-gradient-to-br from-primary to-[#0f2e3a] flex flex-col items-center justify-center text-white p-4 relative">
                <Award size={32} className="text-accent mb-2" />
                <p className="font-display text-xs text-white/70 uppercase tracking-widest">Certificate of Completion</p>
                <p className="font-mono text-xs text-white/50 mt-1">{cert.certificate_number}</p>
              </div>

              <div className="p-5">
                <h3 className="font-display font-bold text-sm text-ink mb-1 line-clamp-2">{cert.course.title}</h3>
                <p className="font-heading text-xs text-muted">Issued {formatDate(cert.issued_at)}</p>

                <div className="flex gap-2 mt-4">
                  <a href={cert.download_url} target="_blank" rel="noreferrer" className="flex-1">
                    <Button size="sm" variant="primary" className="w-full gap-1.5">
                      <Download size={13} /> Download
                    </Button>
                  </a>
                  <Button
                    size="sm"
                    variant="outline"
                    className="gap-1.5"
                    onClick={() => {
                      navigator.clipboard?.writeText(`${window.location.origin}/verify/${cert.certificate_number}`);
                    }}
                  >
                    <Share2 size={13} /> Share
                  </Button>
                </div>
              </div>
            </div>
          ))}
        </div>
      )}
    </DashboardLayout>
  );
}
