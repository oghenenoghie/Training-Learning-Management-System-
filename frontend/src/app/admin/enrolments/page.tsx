"use client";

import { DashboardLayout } from "@/components/layout/DashboardLayout";
import { Badge } from "@/components/ui/Badge";
import { useEnrolments } from "@/hooks/useEnrolments";
import { formatDate, formatCurrency } from "@/lib/utils";
import { Loader2 } from "lucide-react";

export default function AdminEnrolmentsPage() {
  const { data, isLoading } = useEnrolments();
  const enrolments = data?.data ?? [];

  return (
    <DashboardLayout role="admin" title="Enrolments">
      <div className="flex items-center justify-between mb-6">
        <p className="font-heading text-sm text-muted">{enrolments.length} enrolments total</p>
      </div>

      {isLoading && (
        <div className="flex justify-center py-20">
          <Loader2 size={28} className="text-primary animate-spin" />
        </div>
      )}

      {!isLoading && (
        <div className="bg-white rounded-lg border border-fog overflow-hidden">
          <div className="overflow-x-auto">
            <table className="w-full font-heading text-sm">
              <thead className="bg-surface">
                <tr>
                  {["Delegate", "Course", "Fee", "Enrolled", "Payment", "Status"].map((h) => (
                    <th key={h} className="px-4 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wider border-b border-fog">
                      {h}
                    </th>
                  ))}
                </tr>
              </thead>
              <tbody className="divide-y divide-fog">
                {enrolments.map((e) => (
                  <tr key={e.id} className="hover:bg-surface/50 transition-colors">
                    <td className="px-4 py-3">
                      <p className="font-medium text-ink">{e.user?.name}</p>
                      <p className="text-xs text-muted">{e.user?.email}</p>
                    </td>
                    <td className="px-4 py-3 max-w-xs">
                      <p className="truncate font-medium text-ink">{e.course.title}</p>
                    </td>
                    <td className="px-4 py-3 font-mono font-bold text-ink">
                      {formatCurrency(e.course.fee, e.course.currency)}
                    </td>
                    <td className="px-4 py-3 text-muted font-mono text-xs">{formatDate(e.enrolled_at)}</td>
                    <td className="px-4 py-3">
                      <Badge
                        label={e.payment_status}
                        variant={e.payment_status as Parameters<typeof Badge>[0]["variant"]}
                      />
                    </td>
                    <td className="px-4 py-3">
                      <Badge
                        label={e.status}
                        variant={e.status as Parameters<typeof Badge>[0]["variant"]}
                      />
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}
    </DashboardLayout>
  );
}
