"use client";

import { DashboardLayout } from "@/components/layout/DashboardLayout";
import { StatCard } from "@/components/ui/Card";
import { CourseCard } from "@/components/courses/CourseCard";
import { Badge } from "@/components/ui/Badge";
import { Button } from "@/components/ui/Button";
import { useEnrolments, useCertificates } from "@/hooks/useEnrolments";
import { useAuth } from "@/hooks/useAuth";
import { formatDate } from "@/lib/utils";
import { Loader2, BookOpen } from "lucide-react";
import Link from "next/link";

export default function DelegateDashboard() {
  const { user } = useAuth();
  const { data: enrolmentsRes, isLoading } = useEnrolments();
  const { data: certsRes } = useCertificates();

  const enrolments = enrolmentsRes?.data ?? [];
  const certs = certsRes?.data ?? [];
  const inProgress = enrolments.filter((e) => e.status === "confirmed" && e.progress < 100);
  const completed = enrolments.filter((e) => e.status === "completed");

  return (
    <DashboardLayout role="delegate" title="My Dashboard">
      {/* Welcome */}
      <div className="mb-6">
        <h2 className="font-display text-2xl font-bold text-ink">
          Welcome back, {user?.name?.split(" ")[0]} 👋
        </h2>
        <p className="font-heading text-sm text-muted mt-1">Here&apos;s an overview of your learning journey.</p>
      </div>

      {/* Stats */}
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <StatCard icon="📚" label="Enrolled Courses" value={enrolments.length} />
        <StatCard icon="▶️" label="In Progress" value={inProgress.length} accent />
        <StatCard icon="✅" label="Completed" value={completed.length} />
        <StatCard icon="🏆" label="Certificates" value={certs.length} accent />
      </div>

      {/* In-Progress */}
      <section className="mb-10">
        <div className="flex items-center justify-between mb-4">
          <h3 className="font-display text-lg font-bold text-ink">Continue Learning</h3>
          <Link href="/my-courses">
            <Button variant="ghost" size="sm">View All</Button>
          </Link>
        </div>

        {isLoading && (
          <div className="flex justify-center py-10">
            <Loader2 size={24} className="text-primary animate-spin" />
          </div>
        )}

        {!isLoading && inProgress.length === 0 && (
          <div className="flex flex-col items-center justify-center py-12 bg-white rounded-lg border border-fog">
            <BookOpen size={36} className="text-fog mb-3" />
            <p className="font-heading text-sm text-muted mb-3">No courses in progress yet.</p>
            <Link href="/courses">
              <Button variant="accent" size="sm">Browse Courses</Button>
            </Link>
          </div>
        )}

        {!isLoading && inProgress.length > 0 && (
          <div className="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
            {inProgress.slice(0, 3).map((e) => (
              <CourseCard key={e.id} course={e.course} enrolment={e} variant="enrolled" />
            ))}
          </div>
        )}
      </section>

      {/* Recent Enrolments Table */}
      {enrolments.length > 0 && (
        <section>
          <h3 className="font-display text-lg font-bold text-ink mb-4">All Enrolments</h3>
          <div className="bg-white rounded-lg border border-fog overflow-hidden">
            <div className="overflow-x-auto">
              <table className="w-full text-sm font-heading">
                <thead className="bg-surface">
                  <tr>
                    {["Course", "Enrolled", "Status", "Progress", ""].map((h) => (
                      <th key={h} className="px-4 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wider border-b border-fog">
                        {h}
                      </th>
                    ))}
                  </tr>
                </thead>
                <tbody className="divide-y divide-fog">
                  {enrolments.map((e) => (
                    <tr key={e.id} className="hover:bg-surface/50 transition-colors">
                      <td className="px-4 py-3 font-medium text-ink">{e.course.title}</td>
                      <td className="px-4 py-3 text-muted font-mono text-xs">{formatDate(e.enrolled_at)}</td>
                      <td className="px-4 py-3">
                        <Badge variant={e.status as Parameters<typeof Badge>[0]["variant"]} label={e.status} />
                      </td>
                      <td className="px-4 py-3 text-muted">{e.progress}%</td>
                      <td className="px-4 py-3 text-right">
                        <Link href={`/my-courses/${e.id}/learn`}>
                          <Button size="sm" variant="ghost">Resume →</Button>
                        </Link>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          </div>
        </section>
      )}
    </DashboardLayout>
  );
}
