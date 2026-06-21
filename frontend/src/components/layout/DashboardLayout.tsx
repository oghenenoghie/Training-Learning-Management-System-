"use client";

import { Sidebar } from "./Sidebar";
import { Bell } from "lucide-react";
import { useAuth } from "@/hooks/useAuth";

interface DashboardLayoutProps {
  children: React.ReactNode;
  role?: "delegate" | "admin" | "trainer" | "org";
  title?: string;
}

export function DashboardLayout({ children, role = "delegate", title }: DashboardLayoutProps) {
  const { user } = useAuth();

  return (
    <div className="flex h-screen bg-surface overflow-hidden">
      <Sidebar role={role} />

      <div className="flex-1 flex flex-col min-w-0 overflow-hidden">
        {/* Top bar */}
        <header className="h-16 bg-white border-b border-fog flex items-center justify-between px-6 shrink-0">
          <h1 className="font-display text-xl font-bold text-ink">{title ?? "Dashboard"}</h1>
          <div className="flex items-center gap-3">
            <button className="relative p-2 text-muted hover:text-ink hover:bg-surface rounded-md transition-colors">
              <Bell size={18} />
              <span className="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-accent" />
            </button>
            {user && (
              <div className="font-heading text-sm text-muted">
                Welcome, <span className="text-ink font-semibold">{user.name.split(" ")[0]}</span>
              </div>
            )}
          </div>
        </header>

        {/* Page content */}
        <main className="flex-1 overflow-y-auto p-6">
          {children}
        </main>
      </div>
    </div>
  );
}
