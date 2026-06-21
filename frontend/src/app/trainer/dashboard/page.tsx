"use client";

import { DashboardLayout } from "@/components/layout/DashboardLayout";
import { StatCard } from "@/components/ui/Card";
import { Button } from "@/components/ui/Button";
import { Badge } from "@/components/ui/Badge";
import { useQuery } from "@tanstack/react-query";
import { schedulesApi } from "@/lib/api";
import { formatDate } from "@/lib/utils";
import { Loader2, Users, Calendar } from "lucide-react";
import Link from "next/link";

export default function TrainerDashboardPage() {
  const { data, isLoading } = useQuery({
    queryKey: ["schedules"],
    queryFn: () => schedulesApi.list(),
  });

  const schedules = (data as { data?: unknown[] })?.data ?? [];

  return (
    <DashboardLayout role="trainer" title="Trainer Dashboard">
      <div className="grid grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
        <StatCard icon="📅" label="Active Cohorts" value={schedules.length} />
        <StatCard icon="👥" label="Delegates" value="—" accent />
        <StatCard icon="📝" label="Pending Submissions" value="—" />
      </div>

      <div className="bg-white rounded-lg border border-fog overflow-hidden">
        <div className="flex items-center justify-between px-5 py-4 border-b border-fog">
          <h3 className="font-display text-lg font-bold text-ink">My Cohorts</h3>
        </div>
        {isLoading ? (
          <div className="flex justify-center py-16">
            <Loader2 size={24} className="text-primary animate-spin" />
          </div>
        ) : schedules.length === 0 ? (
          <div className="flex flex-col items-center py-16 text-center">
            <Calendar size={40} className="text-fog mb-3" />
            <p className="font-heading text-sm text-muted">No cohorts assigned yet.</p>
          </div>
        ) : (
          <div className="divide-y divide-fog">
            {schedules.map((s: unknown) => {
              const schedule = s as { id: number; course?: { title?: string }; start_date: string; end_date: string; mode: string; seats_total: number };
              return (
                <div key={schedule.id} className="flex items-center justify-between px-5 py-4">
                  <div>
                    <p className="font-heading font-semibold text-sm text-ink">
                      {schedule.course?.title ?? "Untitled Course"}
                    </p>
                    <p className="font-heading text-xs text-muted mt-0.5">
                      {formatDate(schedule.start_date)} – {formatDate(schedule.end_date)}
                    </p>
                  </div>
                  <div className="flex items-center gap-3">
                    <Badge label={schedule.mode} variant="enrolled" />
                    <div className="flex items-center gap-1 font-heading text-xs text-muted">
                      <Users size={13} /> {schedule.seats_total}
                    </div>
                    <Link href={`/trainer/cohorts/${schedule.id}`}>
                      <Button size="sm" variant="outline">View</Button>
                    </Link>
                  </div>
                </div>
              );
            })}
          </div>
        )}
      </div>
    </DashboardLayout>
  );
}
