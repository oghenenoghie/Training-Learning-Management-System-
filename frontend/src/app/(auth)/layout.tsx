import Link from "next/link";
import { GraduationCap } from "lucide-react";

export default function AuthLayout({ children }: { children: React.ReactNode }) {
  return (
    <div className="min-h-screen bg-surface flex flex-col">
      <header className="py-5 px-6">
        <Link href="/" className="inline-flex items-center gap-2.5 text-primary">
          <div className="w-8 h-8 bg-primary rounded-md flex items-center justify-center">
            <GraduationCap size={18} className="text-white" />
          </div>
          <span className="font-display font-bold text-xl">IFS Nigeria</span>
        </Link>
      </header>
      <div className="flex-1 flex items-center justify-center px-4 py-8">
        {children}
      </div>
      <footer className="py-4 text-center font-heading text-xs text-muted">
        © {new Date().getFullYear()} IFS Nigeria. All rights reserved.
      </footer>
    </div>
  );
}
