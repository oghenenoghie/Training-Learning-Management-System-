"use client";

import { useState } from "react";
import { DashboardLayout } from "@/components/layout/DashboardLayout";
import { Button } from "@/components/ui/Button";
import { useQuery } from "@tanstack/react-query";
import { usersApi } from "@/lib/api";
import { formatDate, getInitials } from "@/lib/utils";
import { Loader2, Search, Trash2 } from "lucide-react";
import { useQueryClient } from "@tanstack/react-query";

export default function AdminUsersPage() {
  const [search, setSearch] = useState("");
  const qc = useQueryClient();

  const { data, isLoading } = useQuery({
    queryKey: ["users", search],
    queryFn: () => usersApi.list(search ? { search } : {}),
  });

  const users = data?.data ?? [];

  const handleDelete = async (id: number) => {
    if (!confirm("Delete this user? This cannot be undone.")) return;
    await usersApi.delete(id);
    qc.invalidateQueries({ queryKey: ["users"] });
  };

  return (
    <DashboardLayout role="admin" title="Users">
      <div className="flex gap-3 mb-6">
        <div className="relative flex-1 max-w-sm">
          <Search size={16} className="absolute left-3 top-1/2 -translate-y-1/2 text-muted" />
          <input
            type="text"
            placeholder="Search users..."
            value={search}
            onChange={(e) => setSearch(e.target.value)}
            className="w-full pl-9 pr-4 py-2.5 rounded-md border border-fog font-heading text-sm focus:outline-none focus:ring-2 focus:ring-accent/40"
          />
        </div>
        <p className="self-center font-heading text-sm text-muted ml-auto">{users.length} users</p>
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
                  {["User", "Organisation", "Roles", "Joined", ""].map((h) => (
                    <th key={h} className="px-4 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wider border-b border-fog">
                      {h}
                    </th>
                  ))}
                </tr>
              </thead>
              <tbody className="divide-y divide-fog">
                {users.map((u) => (
                  <tr key={u.id} className="hover:bg-surface/50 transition-colors">
                    <td className="px-4 py-3">
                      <div className="flex items-center gap-3">
                        <div className="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-heading text-xs font-bold shrink-0">
                          {getInitials(u.name)}
                        </div>
                        <div>
                          <p className="font-medium text-ink">{u.name}</p>
                          <p className="text-xs text-muted">{u.email}</p>
                        </div>
                      </div>
                    </td>
                    <td className="px-4 py-3 text-muted">{u.organisation ?? "—"}</td>
                    <td className="px-4 py-3">
                      <div className="flex flex-wrap gap-1">
                        {u.roles.map((r) => (
                          <span key={r} className="font-heading text-[10px] bg-primary/10 text-primary px-2 py-0.5 rounded-full font-semibold capitalize">
                            {r.replace(/_/g, " ")}
                          </span>
                        ))}
                      </div>
                    </td>
                    <td className="px-4 py-3 text-muted font-mono text-xs">{formatDate(u.created_at)}</td>
                    <td className="px-4 py-3">
                      <Button size="sm" variant="danger" onClick={() => handleDelete(u.id)}>
                        <Trash2 size={13} />
                      </Button>
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
