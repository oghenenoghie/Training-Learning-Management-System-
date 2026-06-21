import Link from "next/link";
import { Navbar } from "@/components/layout/Navbar";
import { Footer } from "@/components/layout/Footer";
import { Button } from "@/components/ui/Button";
import { ArrowRight, CheckCircle2, Star, Users, Award, Globe } from "lucide-react";

const STATS = [
  { icon: "🎓", value: "37+", label: "Expert Courses" },
  { icon: "👥", value: "10K+", label: "Professionals Trained" },
  { icon: "🏆", value: "98%", label: "Satisfaction Rate" },
  { icon: "📜", value: "5,000+", label: "Certificates Issued" },
];

const CATEGORIES = [
  { name: "Financial Modeling", icon: "📊", count: 8, slug: "finance" },
  { name: "Corporate Governance", icon: "🏛️", count: 6, slug: "governance" },
  { name: "Legal & Contracts", icon: "⚖️", count: 5, slug: "legal" },
  { name: "Investment & Capital", icon: "📈", count: 7, slug: "investment" },
  { name: "Oil & Gas", icon: "⛽", count: 4, slug: "oil-gas" },
  { name: "Digital & Technology", icon: "💻", count: 5, slug: "tech" },
];

const FEATURES = [
  { icon: <CheckCircle2 size={20} className="text-success" />, title: "Expert-led Training", desc: "Industry practitioners with 15+ years experience delivering practical, applied curriculum." },
  { icon: <Globe size={20} className="text-primary" />, title: "Virtual & In-Person", desc: "Flexible learning modes. Join cohorts from anywhere or attend at our Lagos training centre." },
  { icon: <Award size={20} className="text-accent" />, title: "Certified Credentials", desc: "IFS-certified certificates with QR verification, recognised across Nigeria's financial sector." },
  { icon: <Users size={20} className="text-primary" />, title: "Corporate Solutions", desc: "Bespoke programmes and group bookings for organisations. HR dashboard included." },
];

export default function HomePage() {
  return (
    <>
      <Navbar />
      <main>
        {/* Hero */}
        <section className="bg-gradient-to-br from-primary via-[#153f4e] to-[#0f2e3a] text-white py-24 px-4">
          <div className="max-w-5xl mx-auto text-center">
            <div className="inline-flex items-center gap-2 bg-white/10 border border-white/20 rounded-full px-4 py-1.5 mb-6">
              <Star size={13} className="text-accent fill-accent" />
              <span className="font-heading text-xs font-semibold text-white/80 uppercase tracking-wider">
                Nigeria's Premier Professional Training Institute
              </span>
            </div>
            <h1 className="font-display text-4xl md:text-6xl font-bold leading-tight mb-6">
              Professional Training &<br />Capacity Development
            </h1>
            <p className="font-body text-lg text-white/70 max-w-2xl mx-auto mb-10 leading-relaxed">
              Advance your career with industry-leading courses in finance, governance, legal, and investment.
              Monthly cohorts · Virtual & in-person · Certified credentials.
            </p>
            <div className="flex flex-wrap items-center justify-center gap-4">
              <Link href="/courses">
                <Button variant="accent" size="lg" className="gap-2">
                  Browse Courses <ArrowRight size={16} />
                </Button>
              </Link>
              <Link href="/register">
                <Button variant="outline" size="lg" className="border-white/30 text-white hover:bg-white/10 hover:text-white">
                  Create Free Account
                </Button>
              </Link>
            </div>
          </div>
        </section>

        {/* Stats */}
        <section className="bg-white border-b border-fog py-10">
          <div className="max-w-5xl mx-auto px-4 grid grid-cols-2 md:grid-cols-4 gap-8">
            {STATS.map((s) => (
              <div key={s.label} className="text-center">
                <div className="text-3xl mb-2">{s.icon}</div>
                <div className="font-display text-3xl font-bold text-primary">{s.value}</div>
                <div className="font-heading text-sm text-muted mt-1">{s.label}</div>
              </div>
            ))}
          </div>
        </section>

        {/* Categories */}
        <section className="max-w-7xl mx-auto px-4 sm:px-6 py-20">
          <div className="text-center mb-12">
            <h2 className="font-display text-3xl md:text-4xl font-bold text-ink mb-3">
              Learn by Category
            </h2>
            <p className="font-body text-base text-muted max-w-xl mx-auto">
              Structured programmes across Nigeria's key professional sectors.
            </p>
          </div>
          <div className="grid grid-cols-2 md:grid-cols-3 gap-4">
            {CATEGORIES.map((cat) => (
              <Link
                key={cat.slug}
                href={`/courses?category=${cat.slug}`}
                className="bg-white rounded-lg border border-fog shadow-card p-6 hover:shadow-float hover:border-primary/30 transition-all group"
              >
                <div className="text-3xl mb-3">{cat.icon}</div>
                <h3 className="font-heading font-semibold text-base text-ink group-hover:text-primary transition-colors mb-1">
                  {cat.name}
                </h3>
                <p className="font-heading text-xs text-muted">{cat.count} courses</p>
              </Link>
            ))}
          </div>
        </section>

        {/* Features */}
        <section className="bg-white border-t border-b border-fog py-20 px-4">
          <div className="max-w-6xl mx-auto">
            <div className="text-center mb-12">
              <h2 className="font-display text-3xl md:text-4xl font-bold text-ink mb-3">Why IFS Nigeria?</h2>
              <p className="font-body text-base text-muted max-w-xl mx-auto">
                Trusted by professionals across the public and private sector since 2010.
              </p>
            </div>
            <div className="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
              {FEATURES.map((f) => (
                <div key={f.title} className="flex flex-col gap-3 p-5 rounded-lg border border-fog">
                  <div className="w-10 h-10 rounded-lg bg-surface flex items-center justify-center">
                    {f.icon}
                  </div>
                  <h4 className="font-heading font-semibold text-sm text-ink">{f.title}</h4>
                  <p className="font-heading text-xs text-muted leading-relaxed">{f.desc}</p>
                </div>
              ))}
            </div>
          </div>
        </section>

        {/* CTA */}
        <section className="bg-gradient-to-r from-accent to-[#c96a1f] py-16 px-4 text-white text-center">
          <h2 className="font-display text-3xl md:text-4xl font-bold mb-4">Ready to advance your career?</h2>
          <p className="font-body text-base text-white/80 mb-8 max-w-xl mx-auto">
            Join thousands of professionals. Create a free account and enrol in your first course today.
          </p>
          <div className="flex flex-wrap justify-center gap-4">
            <Link href="/register">
              <Button className="bg-white text-accent hover:bg-white/90 hover:text-accent font-bold" size="lg">
                Get Started Free
              </Button>
            </Link>
            <Link href="/courses">
              <Button variant="outline" size="lg" className="border-white/40 text-white hover:bg-white/10 hover:text-white">
                View All Courses
              </Button>
            </Link>
          </div>
        </section>
      </main>
      <Footer />
    </>
  );
}
