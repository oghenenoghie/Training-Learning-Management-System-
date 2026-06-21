"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import {
  LayoutDashboard, BookOpen, Award, CreditCard, User,
  GraduationCap, LogOut, Users, BarChart2, Settings, FileText, Calendar,
} from "lucide-react";
import { cn } from "@/lib/utils";
import { useAuth } from "@/hooks/useAuth";

interface NavItem {
  href: string;
  label: string;
  icon: React.ReactNode;
}

const DELEGATE_NAV: NavItem[] = [
  { href: "/dashboard",    label: "Dashboard",    icon: <LayoutDashboard size={17} /> },
  { href: "/my-courses",   label: "My Courses",   icon: <BookOpen size={17} /> },
  { href: "/certificates", label: "Certificates", icon: <Award size={17} /> },
  { href: "/payments",     label: "Payments",     icon: <CreditCard size={17} /> },
  { href: "/profile",      label: "Profile",      icon: <User size={17} /> },
];

const ADMIN_NAV: NavItem[] = [
  { href: "/admin/dashboard",   label: "Dashboard",  icon: <LayoutDashboard size={17} /> },
  { href: "/admin/courses",     label: "Courses",    icon: <BookOpen size={17} /> },
  { href: "/admin/users",       label: "Users",      icon: <Users size={17} /> },
  { href: "/admin/enrolments",  label: "Enrolments", icon: <FileText size={17} /> },
  { href: "/admin/payments",    label: "Payments",   icon: <CreditCard size={17} /> },
  { href: "/admin/reports",     label: "Reports",    icon: <BarChart2 size={17} /> },
  { href: "/admin/settings",    label: "Settings",   icon: <Settings size={17} /> },
];

const TRAINER_NAV: NavItem[] = [
  { href: "/trainer/dashboard",   label: "Dashboard",   icon: <LayoutDashboard size={17} /> },
  { href: "/trainer/cohorts",     label: "My Cohorts",  icon: <Calendar size={17} /> },
  { href: "/trainer/submissions", label: "Submissions", icon: <FileText size={17} /> },
];

const ORG_NAV: NavItem[] = [
  { href: "/org/dashboard",   label: "Dashboard",  icon: <LayoutDashboard size={17} /> },
  { href: "/org/team",        label: "Team",       icon: <Users size={17} /> },
  { href: "/org/enrolments",  label: "Enrolments", icon: <FileText size={17} /> },
  { href: "/org/reports",     label: "Reports",    icon: <BarChart2 size={17} /> },
];

interface SidebarProps {
  role?: "delegate" | "admin" | "trainer" | "org";
}

export function Sidebar({ role = "delegate" }: SidebarProps) {
  const pathname = usePathname();
  const { user, logout } = useAuth();

  const navItems =
    role === "admin"   ? ADMIN_NAV :
    role === "trainer" ? TRAINER_NAV :
    role === "org"     ? ORG_NAV :
    DELEGATE_NAV;

  return (
    <aside className="w-64 shrink-0 h-screen sticky top-0 flex flex-col bg-white border-r border-fog">
      {/* Logo */}
      <div className="flex items-center gap-2.5 px-5 h-16 border-b border-fog">
        <div className="w-7 h-7 bg-primary rounded flex items-center justify-center">
          <GraduationCap size={15} className="text-white" />
        </div>
        <span className="font-display font-bold text-base text-primary">IFS Nigeria</span>
      </div>

      {/* Nav */}
      <nav className="flex-1 overflow-y-auto py-4 px-3">
        <ul className="space-y-0.5">
          {navItems.map(({ href, label, icon }) => {
            const active = pathname === href || pathname.startsWith(href + "/");
            return (
              <li key={href}>
                <Link
                  href={href}
                  className={cn(
                    "flex items-center gap-3 px-3 py-2.5 rounded-md font-heading text-sm font-medium transition-all",
                    active
                      ? "bg-primary/10 text-primary"
                      : "text-muted hover:bg-surface hover:text-ink"
                  )}
                >
                  <span className={active ? "text-primary" : "text-muted"}>{icon}</span>
                  {label}
                </Link>
              </li>
            );
          })}
        </ul>
      </nav>

      {/* User */}
      {user && (
        <div className="px-3 py-4 border-t border-fog">
          <div className="flex items-center gap-3 px-3 py-2">
            <div className="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-heading text-xs font-bold flex-shrink-0">
              {user.name.slice(0, 2).toUpperCase()}
            </div>
            <div className="min-w-0">
              <p className="font-heading text-sm font-semibold text-ink truncate">{user.name}</p>
              <p className="font-heading text-xs text-muted truncate">{user.email}</p>
            </div>
          </div>
          <button
            onClick={logout}
            className="mt-2 w-full flex items-center gap-3 px-3 py-2.5 rounded-md font-heading text-sm text-muted hover:text-danger hover:bg-red-50 transition-all"
          >
            <LogOut size={16} />
            Sign Out
          </button>
        </div>
      )}
    </aside>
  );
}
