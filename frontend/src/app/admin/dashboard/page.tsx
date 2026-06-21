"use client";

import { DashboardLayout } from "@/components/layout/DashboardLayout";
import { StatCard } from "@/components/ui/Card";
import { useQuery } from "@tanstack/react-query";
import { reportsApi } from "@/lib/api";
import { formatCurrency } from "@/lib/utils";
import {
  AreaChart, Area, XAxis, YAxis, CartesianGrid, Tooltip, ResponsiveContainer,
} from "recharts";
import { Loader2 } from "lucide-react";

export default function AdminDashboardPage() {
  const { data: reportRes, isLoading } = useQuery({
    queryKey: ["reports", "revenue"],
    queryFn: () => reportsApi.revenue(),
  });

  const report = reportRes?.data;
  const monthly = report?.monthly ?? [];

  return (
    <DashboardLayout role="admin" title="Admin Dashboard">
      {/* Stats */}
      <div className="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <StatCard icon="📋" label="Total Enrolments" value={report?.total_enrolments ?? "—"} />
        <StatCard icon="💰" label="Total Revenue" value={report ? formatCurrency(report.total_revenue) : "—"} accent />
        <StatCard icon="✅" label="Completions" value={report?.total_completions ?? "—"} />
        <StatCard icon="🏆" label="Certificates" value={report?.total_certificates ?? "—"} accent />
      </div>

      {/* Revenue Chart */}
      <div className="bg-white rounded-lg border border-fog p-6 mb-8">
        <h3 className="font-display text-lg font-bold text-ink mb-6">Revenue by Month</h3>
        {isLoading ? (
          <div className="flex justify-center py-16">
            <Loader2 size={24} className="text-primary animate-spin" />
          </div>
        ) : (
          <ResponsiveContainer width="100%" height={280}>
            <AreaChart data={monthly} margin={{ top: 5, right: 20, left: 0, bottom: 0 }}>
              <defs>
                <linearGradient id="revGrad" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="5%" stopColor="#1A4D5E" stopOpacity={0.15} />
                  <stop offset="95%" stopColor="#1A4D5E" stopOpacity={0} />
                </linearGradient>
                <linearGradient id="enrolGrad" x1="0" y1="0" x2="0" y2="1">
                  <stop offset="5%" stopColor="#E07B2A" stopOpacity={0.15} />
                  <stop offset="95%" stopColor="#E07B2A" stopOpacity={0} />
                </linearGradient>
              </defs>
              <CartesianGrid strokeDasharray="3 3" stroke="#DDE3EA" />
              <XAxis dataKey="month" tick={{ fontFamily: "var(--font-dm-sans)", fontSize: 11 }} />
              <YAxis tick={{ fontFamily: "var(--font-dm-sans)", fontSize: 11 }} />
              <Tooltip contentStyle={{ fontFamily: "var(--font-dm-sans)", fontSize: 12, borderColor: "#DDE3EA" }} />
              <Area type="monotone" dataKey="revenue" stroke="#1A4D5E" strokeWidth={2} fill="url(#revGrad)" name="Revenue (₦)" />
              <Area type="monotone" dataKey="enrolments" stroke="#E07B2A" strokeWidth={2} fill="url(#enrolGrad)" name="Enrolments" />
            </AreaChart>
          </ResponsiveContainer>
        )}
      </div>

      {/* Top Courses */}
      {report?.top_courses && report.top_courses.length > 0 && (
        <div className="bg-white rounded-lg border border-fog overflow-hidden">
          <div className="px-6 py-4 border-b border-fog">
            <h3 className="font-display text-lg font-bold text-ink">Top Courses</h3>
          </div>
          <div className="overflow-x-auto">
            <table className="w-full font-heading text-sm">
              <thead className="bg-surface">
                <tr>
                  {["Course", "Enrolments", "Revenue", "Completion Rate"].map((h) => (
                    <th key={h} className="px-5 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wider">
                      {h}
                    </th>
                  ))}
                </tr>
              </thead>
              <tbody className="divide-y divide-fog">
                {report.top_courses.map((c) => (
                  <tr key={c.id} className="hover:bg-surface/50">
                    <td className="px-5 py-3 font-medium text-ink">{c.title}</td>
                    <td className="px-5 py-3 text-muted">{c.enrolments}</td>
                    <td className="px-5 py-3 font-mono font-bold text-ink">{formatCurrency(c.revenue)}</td>
                    <td className="px-5 py-3">
                      <div className="flex items-center gap-2">
                        <div className="flex-1 h-1.5 rounded-full bg-fog overflow-hidden">
                          <div
                            className="h-full rounded-full bg-success"
                            style={{ width: `${c.completion_rate}%` }}
                          />
                        </div>
                        <span className="font-mono text-xs text-muted">{c.completion_rate}%</span>
                      </div>
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
