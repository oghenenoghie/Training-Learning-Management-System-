"use client";

import { DashboardLayout } from "@/components/layout/DashboardLayout";
import { Button } from "@/components/ui/Button";
import { useQuery } from "@tanstack/react-query";
import { reportsApi } from "@/lib/api";
import { StatCard } from "@/components/ui/Card";
import {
  BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer,
} from "recharts";
import { Download, Loader2 } from "lucide-react";

export default function OrgReportsPage() {
  const { data, isLoading } = useQuery({
    queryKey: ["reports", "delegates"],
    queryFn: () => reportsApi.delegates(),
  });

  const report = data?.data;
  const monthly = report?.monthly ?? [];

  return (
    <DashboardLayout role="org" title="Team Reports">
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <StatCard icon="📋" label="Total Enrolments" value={report?.total_enrolments ?? "—"} />
        <StatCard icon="✅" label="Completions" value={report?.total_completions ?? "—"} accent />
        <StatCard icon="🏆" label="Certificates" value={report?.total_certificates ?? "—"} />
        <StatCard icon="⏱️" label="Avg. Completion" value="—" accent />
      </div>

      <div className="bg-white rounded-lg border border-fog p-6">
        <div className="flex items-center justify-between mb-5">
          <h3 className="font-display text-lg font-bold text-ink">Monthly Progress</h3>
          <Button size="sm" variant="outline" className="gap-1.5">
            <Download size={13} /> Export
          </Button>
        </div>
        {isLoading ? (
          <div className="flex justify-center py-16"><Loader2 size={24} className="text-primary animate-spin" /></div>
        ) : (
          <ResponsiveContainer width="100%" height={280}>
            <BarChart data={monthly}>
              <CartesianGrid strokeDasharray="3 3" stroke="#DDE3EA" />
              <XAxis dataKey="month" tick={{ fontFamily: "var(--font-dm-sans)", fontSize: 11 }} />
              <YAxis tick={{ fontFamily: "var(--font-dm-sans)", fontSize: 11 }} />
              <Tooltip contentStyle={{ fontFamily: "var(--font-dm-sans)", fontSize: 12 }} />
              <Bar dataKey="enrolments" name="Enrolments" fill="#1A4D5E" radius={[3,3,0,0]} />
              <Bar dataKey="completions" name="Completions" fill="#E07B2A" radius={[3,3,0,0]} />
            </BarChart>
          </ResponsiveContainer>
        )}
      </div>
    </DashboardLayout>
  );
}
