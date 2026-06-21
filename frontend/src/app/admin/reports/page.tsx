"use client";

import { DashboardLayout } from "@/components/layout/DashboardLayout";
import { StatCard } from "@/components/ui/Card";
import { Button } from "@/components/ui/Button";
import { useQuery } from "@tanstack/react-query";
import { reportsApi } from "@/lib/api";
import { formatCurrency } from "@/lib/utils";
import {
  BarChart, Bar, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer, Legend,
} from "recharts";
import { Loader2, Download } from "lucide-react";

export default function AdminReportsPage() {
  const { data: enrollRes, isLoading } = useQuery({
    queryKey: ["reports", "enrolments"],
    queryFn: () => reportsApi.enrolments(),
  });
  const { data: revRes } = useQuery({
    queryKey: ["reports", "revenue"],
    queryFn: () => reportsApi.revenue(),
  });

  const enrolReport = enrollRes?.data;
  const revReport = revRes?.data;
  const monthly = revReport?.monthly ?? [];

  return (
    <DashboardLayout role="admin" title="Reports & Analytics">
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <StatCard icon="📋" label="Total Enrolments" value={enrolReport?.total_enrolments ?? "—"} />
        <StatCard icon="💰" label="Total Revenue" value={revReport ? formatCurrency(revReport.total_revenue) : "—"} accent />
        <StatCard icon="✅" label="Completions" value={enrolReport?.total_completions ?? "—"} />
        <StatCard icon="🏆" label="Certificates" value={enrolReport?.total_certificates ?? "—"} accent />
      </div>

      {/* Chart */}
      <div className="bg-white rounded-lg border border-fog p-6 mb-6">
        <div className="flex items-center justify-between mb-6">
          <h3 className="font-display text-lg font-bold text-ink">Monthly Summary</h3>
          <Button size="sm" variant="outline" className="gap-2">
            <Download size={14} /> Export CSV
          </Button>
        </div>
        {isLoading ? (
          <div className="flex justify-center py-16">
            <Loader2 size={24} className="text-primary animate-spin" />
          </div>
        ) : (
          <ResponsiveContainer width="100%" height={300}>
            <BarChart data={monthly} margin={{ top: 5, right: 20, left: 0, bottom: 5 }}>
              <CartesianGrid strokeDasharray="3 3" stroke="#DDE3EA" />
              <XAxis dataKey="month" tick={{ fontFamily: "var(--font-dm-sans)", fontSize: 11 }} />
              <YAxis tick={{ fontFamily: "var(--font-dm-sans)", fontSize: 11 }} />
              <Tooltip contentStyle={{ fontFamily: "var(--font-dm-sans)", fontSize: 12, borderColor: "#DDE3EA" }} />
              <Legend wrapperStyle={{ fontFamily: "var(--font-dm-sans)", fontSize: 12 }} />
              <Bar dataKey="enrolments" name="Enrolments" fill="#1A4D5E" radius={[3,3,0,0]} />
              <Bar dataKey="completions" name="Completions" fill="#E07B2A" radius={[3,3,0,0]} />
            </BarChart>
          </ResponsiveContainer>
        )}
      </div>
    </DashboardLayout>
  );
}
