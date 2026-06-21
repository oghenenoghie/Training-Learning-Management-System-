import Link from "next/link";
import { GraduationCap } from "lucide-react";

const LINKS = {
  Courses:   ["/courses", "/courses?category=finance", "/courses?category=legal", "/courses?mode=virtual"],
  Labels:    ["All Courses", "Finance", "Legal & Governance", "Virtual Training"],
  Company:   ["/about", "/contact", "/blog", "/careers"],
  CLabels:   ["About IFS", "Contact", "Blog", "Careers"],
  Legal:     ["/privacy", "/terms", "/cookie-policy"],
  LLabels:   ["Privacy Policy", "Terms of Use", "Cookie Policy"],
};

export function Footer() {
  return (
    <footer className="bg-ink text-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-14">
        <div className="grid grid-cols-1 md:grid-cols-4 gap-10">
          {/* Brand */}
          <div>
            <div className="flex items-center gap-2.5 mb-4">
              <div className="w-8 h-8 bg-accent rounded-md flex items-center justify-center">
                <GraduationCap size={18} className="text-white" />
              </div>
              <span className="font-display font-bold text-xl">IFS Nigeria</span>
            </div>
            <p className="font-body text-sm text-white/60 leading-relaxed">
              Institute for Fiscal Studies — Professional training and capacity development for finance, legal, and governance professionals.
            </p>
          </div>

          {/* Courses */}
          <div>
            <h4 className="font-heading font-semibold text-sm text-accent mb-4 uppercase tracking-wider">Courses</h4>
            <ul className="space-y-2.5">
              {LINKS.Courses.map((href, i) => (
                <li key={href}>
                  <Link href={href} className="font-heading text-sm text-white/60 hover:text-white transition-colors">
                    {LINKS.Labels[i]}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Company */}
          <div>
            <h4 className="font-heading font-semibold text-sm text-accent mb-4 uppercase tracking-wider">Company</h4>
            <ul className="space-y-2.5">
              {LINKS.Company.map((href, i) => (
                <li key={href}>
                  <Link href={href} className="font-heading text-sm text-white/60 hover:text-white transition-colors">
                    {LINKS.CLabels[i]}
                  </Link>
                </li>
              ))}
            </ul>
          </div>

          {/* Legal */}
          <div>
            <h4 className="font-heading font-semibold text-sm text-accent mb-4 uppercase tracking-wider">Legal</h4>
            <ul className="space-y-2.5">
              {LINKS.Legal.map((href, i) => (
                <li key={href}>
                  <Link href={href} className="font-heading text-sm text-white/60 hover:text-white transition-colors">
                    {LINKS.LLabels[i]}
                  </Link>
                </li>
              ))}
            </ul>
          </div>
        </div>

        <div className="mt-12 pt-6 border-t border-white/10 flex flex-col sm:flex-row justify-between gap-3 items-center">
          <p className="font-heading text-xs text-white/40">
            © {new Date().getFullYear()} IFS Nigeria. All rights reserved.
          </p>
          <div className="flex gap-4">
            {["Next.js 15", "Laravel", "Paystack"].map((t) => (
              <span key={t} className="font-mono text-xs text-white/30">{t}</span>
            ))}
          </div>
        </div>
      </div>
    </footer>
  );
}
