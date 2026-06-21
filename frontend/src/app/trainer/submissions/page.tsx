"use client";

import { DashboardLayout } from "@/components/layout/DashboardLayout";
import { Badge } from "@/components/ui/Badge";
import { Button } from "@/components/ui/Button";
import { FileText, CheckCircle2, XCircle } from "lucide-react";

export default function TrainerSubmissionsPage() {
  return (
    <DashboardLayout role="trainer" title="Assessment Submissions">
      <div className="bg-white rounded-lg border border-fog overflow-hidden">
        <div className="px-5 py-4 border-b border-fog">
          <p className="font-heading text-sm text-muted">Pending delegate submissions for grading</p>
        </div>
        <div className="flex flex-col items-center py-20">
          <FileText size={48} className="text-fog mb-4" />
          <p className="font-heading text-base text-muted">No pending submissions.</p>
          <p className="font-heading text-xs text-muted mt-1">
            Submissions from your cohorts will appear here.
          </p>
        </div>
      </div>
    </DashboardLayout>
  );
}
