"use client";

import { DashboardLayout } from "@/components/layout/DashboardLayout";
import { Badge } from "@/components/ui/Badge";
import { usePayments } from "@/hooks/useEnrolments";
import { formatCurrency, formatDate } from "@/lib/utils";
import { Loader2, CreditCard } from "lucide-react";

export default function PaymentsPage() {
  const { data, isLoading } = usePayments();
  const payments = data?.data ?? [];

  return (
    <DashboardLayout role="delegate" title="Payment History">
      {isLoading && (
        <div className="flex justify-center py-20">
          <Loader2 size={28} className="text-primary animate-spin" />
        </div>
      )}

      {!isLoading && payments.length === 0 && (
        <div className="flex flex-col items-center py-20 bg-white rounded-lg border border-fog">
          <CreditCard size={48} className="text-fog mb-4" />
          <p className="font-heading text-base text-muted">No payment records yet.</p>
        </div>
      )}

      {!isLoading && payments.length > 0 && (
        <div className="bg-white rounded-lg border border-fog overflow-hidden">
          <div className="overflow-x-auto">
            <table className="w-full font-heading text-sm">
              <thead className="bg-surface">
                <tr>
                  {["Course", "Amount", "Gateway", "Reference", "Date", "Status"].map((h) => (
                    <th key={h} className="px-4 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wider border-b border-fog">
                      {h}
                    </th>
                  ))}
                </tr>
              </thead>
              <tbody className="divide-y divide-fog">
                {payments.map((p) => (
                  <tr key={p.id} className="hover:bg-surface/50 transition-colors">
                    <td className="px-4 py-3 font-medium text-ink">{p.course.title}</td>
                    <td className="px-4 py-3 font-mono font-bold text-ink">{formatCurrency(p.amount, p.currency)}</td>
                    <td className="px-4 py-3 capitalize text-muted">{p.gateway}</td>
                    <td className="px-4 py-3 font-mono text-xs text-muted">{p.reference}</td>
                    <td className="px-4 py-3 text-muted">{p.paid_at ? formatDate(p.paid_at) : formatDate(p.created_at)}</td>
                    <td className="px-4 py-3">
                      <Badge variant={p.status as Parameters<typeof Badge>[0]["variant"]} label={p.status} />
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
