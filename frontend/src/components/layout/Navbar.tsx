"use client";

import Link from "next/link";
import { usePathname } from "next/navigation";
import { useAuth } from "@/hooks/useAuth";
import { Button } from "@/components/ui/Button";
import { getInitials } from "@/lib/utils";
import { Menu, X, GraduationCap, ChevronDown, LogOut, User, LayoutDashboard } from "lucide-react";
import { useState } from "react";
import { cn } from "@/lib/utils";

const NAV_LINKS = [
  { href: "/courses", label: "Courses" },
  { href: "/about", label: "About" },
  { href: "/contact", label: "Contact" },
];

export function Navbar() {
  const pathname = usePathname();
  const { user, isAuthenticated, isAdmin, isTrainer, isCorporateHR, logout } = useAuth();
  const [menuOpen, setMenuOpen] = useState(false);
  const [dropOpen, setDropOpen] = useState(false);

  const dashboardHref = isAdmin
    ? "/admin/dashboard"
    : isTrainer
    ? "/trainer/dashboard"
    : isCorporateHR
    ? "/org/dashboard"
    : "/dashboard";

  return (
    <header className="bg-white border-b border-fog sticky top-0 z-30 shadow-sm">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex items-center justify-between h-16">
          {/* Logo */}
          <Link href="/" className="flex items-center gap-2.5 text-primary">
            <div className="w-8 h-8 bg-primary rounded-md flex items-center justify-center">
              <GraduationCap size={18} className="text-white" />
            </div>
            <span className="font-display font-bold text-xl leading-none">IFS Nigeria</span>
          </Link>

          {/* Desktop Nav */}
          <nav className="hidden md:flex items-center gap-6">
            {NAV_LINKS.map(({ href, label }) => (
              <Link
                key={href}
                href={href}
                className={cn(
                  "font-heading text-sm font-medium transition-colors",
                  pathname === href ? "text-primary" : "text-muted hover:text-ink"
                )}
              >
                {label}
              </Link>
            ))}
          </nav>

          {/* Auth Controls */}
          <div className="hidden md:flex items-center gap-3">
            {isAuthenticated && user ? (
              <div className="relative">
                <button
                  onClick={() => setDropOpen(!dropOpen)}
                  className="flex items-center gap-2 rounded-lg px-3 py-1.5 hover:bg-surface transition-colors"
                >
                  <div className="w-8 h-8 rounded-full bg-primary flex items-center justify-center text-white font-heading text-xs font-bold">
                    {getInitials(user.name)}
                  </div>
                  <span className="font-heading text-sm font-medium text-ink">{user.name.split(" ")[0]}</span>
                  <ChevronDown size={14} className={cn("text-muted transition-transform", dropOpen && "rotate-180")} />
                </button>
                {dropOpen && (
                  <div className="absolute right-0 mt-1 w-48 bg-white rounded-lg border border-fog shadow-float py-1 z-50">
                    <Link
                      href={dashboardHref}
                      className="flex items-center gap-2.5 px-4 py-2.5 font-heading text-sm text-ink hover:bg-surface"
                      onClick={() => setDropOpen(false)}
                    >
                      <LayoutDashboard size={15} className="text-muted" />
                      Dashboard
                    </Link>
                    <Link
                      href="/profile"
                      className="flex items-center gap-2.5 px-4 py-2.5 font-heading text-sm text-ink hover:bg-surface"
                      onClick={() => setDropOpen(false)}
                    >
                      <User size={15} className="text-muted" />
                      Profile
                    </Link>
                    <hr className="border-fog my-1" />
                    <button
                      onClick={() => { setDropOpen(false); logout(); }}
                      className="w-full flex items-center gap-2.5 px-4 py-2.5 font-heading text-sm text-danger hover:bg-red-50"
                    >
                      <LogOut size={15} />
                      Sign Out
                    </button>
                  </div>
                )}
              </div>
            ) : (
              <>
                <Link href="/login">
                  <Button variant="ghost" size="sm">Sign In</Button>
                </Link>
                <Link href="/register">
                  <Button variant="accent" size="sm">Get Started</Button>
                </Link>
              </>
            )}
          </div>

          {/* Mobile hamburger */}
          <button
            className="md:hidden text-ink p-1"
            onClick={() => setMenuOpen(!menuOpen)}
          >
            {menuOpen ? <X size={22} /> : <Menu size={22} />}
          </button>
        </div>
      </div>

      {/* Mobile menu */}
      {menuOpen && (
        <div className="md:hidden border-t border-fog bg-white px-4 py-4 flex flex-col gap-3">
          {NAV_LINKS.map(({ href, label }) => (
            <Link
              key={href}
              href={href}
              className="font-heading text-sm font-medium text-ink py-2"
              onClick={() => setMenuOpen(false)}
            >
              {label}
            </Link>
          ))}
          {isAuthenticated ? (
            <>
              <Link href={dashboardHref} className="font-heading text-sm text-primary font-semibold py-2" onClick={() => setMenuOpen(false)}>
                Dashboard
              </Link>
              <button onClick={() => { setMenuOpen(false); logout(); }} className="text-left font-heading text-sm text-danger py-2">
                Sign Out
              </button>
            </>
          ) : (
            <div className="flex gap-2 pt-2">
              <Link href="/login" className="flex-1"><Button variant="outline" size="sm" className="w-full">Sign In</Button></Link>
              <Link href="/register" className="flex-1"><Button variant="accent" size="sm" className="w-full">Get Started</Button></Link>
            </div>
          )}
        </div>
      )}
    </header>
  );
}
