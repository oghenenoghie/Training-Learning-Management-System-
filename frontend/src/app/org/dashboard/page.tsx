"use client";

import { DashboardLayout } from "@/components/layout/DashboardLayout";
import { StatCard } from "@/components/ui/Card";
import { Badge } from "@/components/ui/Badge";
import { Button } from "@/components/ui/Button";
import { useEnrolments } from "@/hooks/useEnrolments";
import { formatDate } from "@/lib/utils";
import { Loader2, Download } from "lucide-react";

export default function OrgDashboardPage() {
  const { data, isLoading } = useEnrolments();
  const enrolments = data?.data ?? [];
  const completed = enrolments.filter((e) => e.status === "completed");

  return (
    <DashboardLayout role="org" title="Corporate Dashboard">
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <StatCard icon="👥" label="Team Enrolments" value={enrolments.length} />
        <StatCard icon="✅" label="Completions" value={completed.length} accent />
        <StatCard icon="📜" label="CPD Hours" value="—" />
        <StatCard icon="🏆" label="Certificates" value="—" accent />
      </div>

      <div className="bg-white rounded-lg border border-fog overflow-hidden">
        <div className="flex items-center justify-between px-5 py-4 border-b border-fog">
          <h3 className="font-display text-lg font-bold text-ink">Team Enrolments</h3>
          <Button size="sm" variant="outline" className="gap-1.5">
            <Download size={13} /> Export CSV
          </Button>
        </div>
        {isLoading ? (
          <div className="flex justify-center py-16">
            <Loader2 size={24} className="text-primary animate-spin" />
          </div>
        ) : (
          <div className="overflow-x-auto">
            <table className="w-full font-heading text-sm">
              <thead className="bg-surface">
                <tr>
                  {["Employee", "Course", "Enrolled", "Progress", "Status"].map((h) => (
                    <th key={h} className="px-4 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wider">
                      {h}
                    </th>
                  ))}
                </tr>
              </thead>
              <tbody className="divide-y divide-fog">
                {enrolments.map((e) => (
                  <tr key={e.id} className="hover:bg-surface/50">
                    <td className="px-4 py-3">
                      <p className="font-medium text-ink">{e.user?.name}</p>
                      <p className="text-xs text-muted">{e.user?.job_title}</p>
                    </td>
                    <td className="px-4 py-3 max-w-xs truncate font-medium text-ink">{e.course.title}</td>
                    <td className="px-4 py-3 font-mono text-xs text-muted">{formatDate(e.enrolled_at)}</td>
                    <td className="px-4 py-3">
                      <div className="flex items-center gap-2">
                        <div className="w-20 h-1.5 rounded-full bg-fog overflow-hidden">
                          <div className="h-full rounded-full bg-primary" style={{ width: `${e.progress}%` }} />
                        </div>
                        <span className="font-mono text-xs text-muted">{e.progress}%</span>
                      </div>
                    </td>
                    <td className="px-4 py-3">
                      <Badge label={e.status} variant={e.status as Parameters<typeof Badge>[0]["variant"]} />
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        )}
      </div>
    </DashboardLayout>
  );
}
