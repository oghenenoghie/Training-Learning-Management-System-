"use client";
import { useState } from "react";

// ============================================================
// IFS NIGERIA — ENTERPRISE LMS DESIGN SYSTEM
// Stack: Next.js 15 (App Router) + Laravel API + cPanel Deploy
// Audience: Thousands of concurrent users
// ============================================================

const TOKENS = {
  colors: {
    primary:    { hex: "#1A4D5E", name: "IFS Deep Teal",     usage: "Brand primary, nav, CTAs" },
    accent:     { hex: "#E07B2A", name: "IFS Amber",          usage: "Highlights, badges, active states" },
    surface:    { hex: "#F5F7F9", name: "Cloud Grey",         usage: "Page background, card surfaces" },
    elevated:   { hex: "#FFFFFF", name: "Pure White",         usage: "Cards, modals, sidebars" },
    text:       { hex: "#0F1F2B", name: "Ink Navy",           usage: "Body copy, headings" },
    muted:      { hex: "#6B7C8D", name: "Slate",              usage: "Meta, labels, placeholders" },
    border:     { hex: "#DDE3EA", name: "Fog",                usage: "Dividers, inputs, table rows" },
    success:    { hex: "#1A7A4A", name: "Forest",             usage: "Completed, passed, enrolled" },
    warning:    { hex: "#B85C00", name: "Ember",              usage: "Deadlines, overdue, caution" },
    danger:     { hex: "#C0392B", name: "Alert Red",          usage: "Errors, failed, destructive" },
    overlay:    { hex: "#0F1F2B", name: "Ink Navy (10%)",     usage: "Modal overlays, scrim" },
  },
  typography: {
    display:  { family: "Libre Baskerville",  role: "Display / Page titles",          note: "Authoritative serif — echoes IFS institutional weight" },
    heading:  { family: "DM Sans",            role: "Section headings, nav, UI labels", note: "Clean grotesque — precision and legibility at scale" },
    body:     { family: "Source Serif 4",     role: "Long-form content, course text",  note: "Optimised for extended reading — training content focus" },
    mono:     { family: "JetBrains Mono",     role: "Code, data, IDs, schedule times", note: "Financial modeling courses need legible monospace" },
  },
  scale: {
    "4xl": "clamp(2.5rem, 5vw, 3.75rem)",
    "3xl": "clamp(2rem, 4vw, 3rem)",
    "2xl": "clamp(1.5rem, 3vw, 2.25rem)",
    "xl":  "clamp(1.25rem, 2.5vw, 1.75rem)",
    "lg":  "1.125rem",
    "base":"1rem",
    "sm":  "0.875rem",
    "xs":  "0.75rem",
  },
  spacing: { base: "8px", scale: "×0.5, ×1, ×1.5, ×2, ×3, ×4, ×6, ×8, ×12, ×16" },
  radius:  { sm: "4px", md: "8px", lg: "12px", xl: "20px", full: "9999px" },
  shadow:  {
    card:  "0 1px 4px rgba(15,31,43,0.08), 0 4px 12px rgba(15,31,43,0.06)",
    float: "0 8px 32px rgba(15,31,43,0.14)",
    focus: "0 0 0 3px rgba(224,123,42,0.35)",
  },
};

const ARCHITECTURE = {
  frontend: {
    framework: "Next.js 15 (App Router, TypeScript strict)",
    styling: "Tailwind CSS v3 + shadcn/ui",
    motion: "Framer Motion (lazy-loaded, reduced-motion aware)",
    state: "Zustand (client) + TanStack Query (server state)",
    forms: "React Hook Form + Zod validation",
    tables: "TanStack Table v8 (virtual rows for 1000+ records)",
    auth: "NextAuth.js v5 (JWT + Laravel Sanctum)",
    i18n: "next-intl (English + future languages)",
    charts: "Recharts (lightweight, tree-shakeable)",
    static: "next export → Apache on cPanel",
  },
  backend: {
    framework: "Laravel 11 (API only — no Blade)",
    auth: "Laravel Sanctum (SPA tokens)",
    queue: "Laravel Queues → database driver (cPanel-safe)",
    cache: "Redis or file driver (cPanel fallback)",
    search: "Laravel Scout + database driver",
    media: "Spatie Media Library → local disk on cPanel",
    roles: "Spatie Laravel-Permission (RBAC)",
    export: "Maatwebsite Excel (certificates, reports)",
    email: "Laravel Mail → SMTP via cPanel mail",
    api: "RESTful JSON API — versioned under /api/v1/",
  },
  database: {
    primary: "MySQL 8 (cPanel MariaDB compatible)",
    migrations: "Laravel Migrations (reversible, seeded)",
    indexing: "Composite indexes on (user_id, course_id, status)",
    pagination: "Cursor-based pagination for large datasets",
  },
  deployment: {
    nextjs: "next build → next export → FTP /public_html/",
    laravel: "Git pull → composer install → php artisan migrate",
    cicd: "GitHub Actions → SSH into cPanel → deploy script",
    ssl: "cPanel AutoSSL (Let's Encrypt)",
    htaccess: "Apache .htaccess for SPA routing fallback",
  },
};

const TOOLS = [
  {
    icon: "🎓",
    category: "Learning Tools",
    color: "#1A4D5E",
    items: [
      { name: "Course Player", desc: "Multi-section video + PDF reader with progress tracking, chapter navigation, playback speed, and note-taking panel." },
      { name: "Assessment Engine", desc: "MCQ, short answer, file upload. Auto-graded with instant feedback. Configurable pass score per course." },
      { name: "Certificate Generator", desc: "PDF certificate with QR verification code. Auto-issued on course completion. Downloadable & shareable." },
      { name: "Learning Path Builder", desc: "Admin tool to chain courses into structured programmes (e.g., Finance Masterclass Bundle)." },
      { name: "Course Scheduling", desc: "Monthly date grids per course (Jan–Dec). Delegates register for specific cohort dates." },
    ],
  },
  {
    icon: "👤",
    category: "User & Role Tools",
    color: "#E07B2A",
    items: [
      { name: "Role Manager", desc: "Super Admin, Admin, Trainer, Delegate, Corporate HR. Spatie RBAC. Each role sees a tailored dashboard." },
      { name: "Delegate Portal", desc: "My Courses, My Certificates, My Schedule, Payment History, Profile." },
      { name: "Corporate Dashboard", desc: "HR managers view team enrolments, completions, CPD hours, and export reports." },
      { name: "Trainer Portal", desc: "View assigned cohorts, upload materials, grade submissions, message delegates." },
      { name: "Auth Flow", desc: "Register → Email verify → Profile complete → Enrol. SSO-ready via OAuth." },
    ],
  },
  {
    icon: "📊",
    category: "Admin & Analytics Tools",
    color: "#1A7A4A",
    items: [
      { name: "Enrolment Manager", desc: "Search, filter, bulk-approve, waitlist management. CSV export for finance team." },
      { name: "Revenue Dashboard", desc: "Course revenue, delegate counts, payment status (paid/pending/refunded). Chart by month." },
      { name: "Report Builder", desc: "Custom reports: completion rates, attendance, CPD hours. Schedule & email delivery." },
      { name: "Notification Centre", desc: "Email templates, SMS triggers (enrolment confirm, reminder, certificate issued)." },
      { name: "Content Manager", desc: "Upload course materials, videos (YouTube embed / direct). Rich text editor." },
    ],
  },
  {
    icon: "💳",
    category: "Commerce Tools",
    color: "#B85C00",
    items: [
      { name: "Payment Gateway", desc: "Paystack (Nigeria primary) + Flutterwave fallback. Virtual/physical course fees." },
      { name: "Invoice Generator", desc: "Auto-PDF invoice on payment. Corporate PO number support. VAT calculation." },
      { name: "Discount & Promo Engine", desc: "Coupon codes, early-bird pricing, group booking discount (3+ delegates)." },
      { name: "Instalment Plans", desc: "Split payment options for multi-day masterclasses. Automated payment reminders." },
    ],
  },
  {
    icon: "⚙️",
    category: "Platform & DevOps Tools",
    color: "#4A5568",
    items: [
      { name: "API Gateway", desc: "Versioned Laravel REST API (/api/v1/). Rate-limited (60 req/min per user). Sanctum auth." },
      { name: "Job Queue Monitor", desc: "Laravel Horizon-style dashboard. Email queue, certificate queue, report queue." },
      { name: "Activity Log", desc: "Spatie Activity Log. Every enrolment, payment, login, admin action tracked." },
      { name: "Error Tracker", desc: "Sentry integration. Frontend + backend errors with stack traces and user context." },
      { name: "CI/CD Pipeline", desc: "GitHub Actions → SSH deploy → php artisan migrate → next build → rsync to cPanel." },
    ],
  },
];

const ROUTES = [
  { group: "Public", routes: ["/", "/courses", "/courses/[slug]", "/about", "/contact", "/login", "/register"] },
  { group: "Delegate", routes: ["/dashboard", "/my-courses", "/my-courses/[id]/learn", "/certificates", "/profile", "/payments"] },
  { group: "Corporate HR", routes: ["/org/dashboard", "/org/team", "/org/reports", "/org/enrolments"] },
  { group: "Trainer", routes: ["/trainer/dashboard", "/trainer/cohorts/[id]", "/trainer/submissions"] },
  { group: "Admin", routes: ["/admin/dashboard", "/admin/courses", "/admin/users", "/admin/enrolments", "/admin/payments", "/admin/reports", "/admin/settings"] },
  { group: "API (Laravel)", routes: ["/api/v1/auth/*", "/api/v1/courses", "/api/v1/enrolments", "/api/v1/payments", "/api/v1/certificates", "/api/v1/users", "/api/v1/reports"] },
];

// ─── COMPONENTS ──────────────────────────────────────────────

function Tab({ label, active, onClick }) {
  return (
    <button
      onClick={onClick}
      style={{
        padding: "10px 20px",
        borderRadius: "8px",
        border: "none",
        cursor: "pointer",
        fontFamily: "'DM Sans', system-ui, sans-serif",
        fontWeight: active ? 600 : 400,
        fontSize: "0.875rem",
        background: active ? "#1A4D5E" : "transparent",
        color: active ? "#fff" : "#6B7C8D",
        transition: "all 0.2s",
        whiteSpace: "nowrap",
      }}
    >
      {label}
    </button>
  );
}

function ColorSwatch({ name, hex, usage }) {
  const [copied, setCopied] = useState(false);
  return (
    <div
      onClick={() => { navigator.clipboard?.writeText(hex); setCopied(true); setTimeout(() => setCopied(false), 1500); }}
      style={{
        borderRadius: "10px",
        overflow: "hidden",
        border: "1px solid #DDE3EA",
        cursor: "pointer",
        background: "#fff",
        transition: "transform 0.15s",
      }}
      title="Click to copy hex"
    >
      <div style={{ height: 64, background: hex, position: "relative" }}>
        {copied && (
          <span style={{ position:"absolute", inset:0, display:"flex", alignItems:"center", justifyContent:"center", background:"rgba(0,0,0,0.45)", color:"#fff", fontFamily:"'DM Sans',sans-serif", fontSize:"0.75rem", fontWeight:600 }}>Copied!</span>
        )}
      </div>
      <div style={{ padding: "10px 12px" }}>
        <div style={{ fontFamily: "'JetBrains Mono', monospace", fontSize: "0.75rem", color: "#1A4D5E", fontWeight: 600 }}>{hex}</div>
        <div style={{ fontFamily: "'DM Sans', sans-serif", fontSize: "0.8rem", color: "#0F1F2B", fontWeight: 600, marginTop: 2 }}>{name}</div>
        <div style={{ fontFamily: "'DM Sans', sans-serif", fontSize: "0.7rem", color: "#6B7C8D", marginTop: 2, lineHeight: 1.4 }}>{usage}</div>
      </div>
    </div>
  );
}

function TypeSpecimen({ family, role, note, sample }) {
  const fontStyles = {
    "Libre Baskerville": { fontFamily: "'Georgia', 'Times New Roman', serif", fontStyle: "normal" },
    "DM Sans": { fontFamily: "'Segoe UI', 'Helvetica Neue', Arial, sans-serif", fontWeight: 500 },
    "Source Serif 4": { fontFamily: "'Georgia', serif", fontStyle: "italic" },
    "JetBrains Mono": { fontFamily: "'Courier New', 'Consolas', monospace" },
  };
  return (
    <div style={{ background: "#fff", border: "1px solid #DDE3EA", borderRadius: 10, padding: "20px 24px", marginBottom: 12 }}>
      <div style={{ display: "flex", justifyContent: "space-between", alignItems: "flex-start", marginBottom: 16 }}>
        <div>
          <div style={{ fontFamily: "'DM Sans', sans-serif", fontWeight: 700, fontSize: "0.875rem", color: "#1A4D5E" }}>{family}</div>
          <div style={{ fontFamily: "'DM Sans', sans-serif", fontSize: "0.75rem", color: "#6B7C8D", marginTop: 2 }}>{role}</div>
        </div>
        <span style={{ background: "#F5F7F9", border: "1px solid #DDE3EA", borderRadius: 6, padding: "3px 10px", fontSize: "0.7rem", color: "#6B7C8D", fontFamily: "'DM Sans', sans-serif" }}>next/font/google</span>
      </div>
      <div style={{ ...fontStyles[family], fontSize: family === "JetBrains Mono" ? "1.1rem" : "1.75rem", color: "#0F1F2B", lineHeight: 1.25, marginBottom: 10 }}>
        {family === "Libre Baskerville" && "Professional Training & Capacity Development"}
        {family === "DM Sans" && "Advanced Financial Modeling · Certificate"}
        {family === "Source Serif 4" && "Participants will be equipped with practical skills to navigate complex fiscal governance frameworks."}
        {family === "JetBrains Mono" && "IFS-2025-FIN-001 · ₦350,000"}
      </div>
      <div style={{ fontFamily: "'DM Sans', sans-serif", fontSize: "0.72rem", color: "#6B7C8D", paddingTop: 12, borderTop: "1px solid #DDE3EA" }}>{note}</div>
    </div>
  );
}

function ToolCard({ icon, category, color, items }) {
  const [open, setOpen] = useState(false);
  return (
    <div style={{ background: "#fff", border: "1px solid #DDE3EA", borderRadius: 12, overflow: "hidden", marginBottom: 12 }}>
      <button
        onClick={() => setOpen(!open)}
        style={{
          width: "100%", display: "flex", alignItems: "center", gap: 12,
          padding: "16px 20px", border: "none", background: "none", cursor: "pointer", textAlign: "left",
        }}
      >
        <span style={{ fontSize: "1.4rem" }}>{icon}</span>
        <span style={{ fontFamily: "'DM Sans', sans-serif", fontWeight: 700, fontSize: "0.95rem", color: "#0F1F2B", flex: 1 }}>{category}</span>
        <span style={{ background: color, color: "#fff", borderRadius: 20, padding: "2px 10px", fontSize: "0.72rem", fontFamily: "'DM Sans', sans-serif", fontWeight: 600 }}>{items.length} tools</span>
        <span style={{ color: "#6B7C8D", fontSize: "1rem", marginLeft: 8, transform: open ? "rotate(180deg)" : "rotate(0)", transition: "transform 0.2s" }}>▾</span>
      </button>
      {open && (
        <div style={{ padding: "0 20px 20px" }}>
          {items.map((t, i) => (
            <div key={i} style={{ display: "flex", gap: 12, padding: "12px 0", borderTop: "1px solid #F5F7F9" }}>
              <div style={{ width: 6, borderRadius: 3, flexShrink: 0, background: color, alignSelf: "stretch", minHeight: 8 }} />
              <div>
                <div style={{ fontFamily: "'DM Sans', sans-serif", fontWeight: 600, fontSize: "0.85rem", color: "#0F1F2B" }}>{t.name}</div>
                <div style={{ fontFamily: "'DM Sans', sans-serif", fontSize: "0.78rem", color: "#6B7C8D", marginTop: 3, lineHeight: 1.5 }}>{t.desc}</div>
              </div>
            </div>
          ))}
        </div>
      )}
    </div>
  );
}

function ArchSection({ title, data, color }) {
  return (
    <div style={{ background: "#fff", border: "1px solid #DDE3EA", borderRadius: 12, padding: "20px 24px", marginBottom: 16 }}>
      <div style={{ display: "flex", alignItems: "center", gap: 10, marginBottom: 16 }}>
        <div style={{ width: 4, height: 20, borderRadius: 2, background: color }} />
        <div style={{ fontFamily: "'DM Sans', sans-serif", fontWeight: 700, fontSize: "0.95rem", color: "#0F1F2B" }}>{title}</div>
      </div>
      <div style={{ display: "grid", gap: 8 }}>
        {Object.entries(data).map(([key, val]) => (
          <div key={key} style={{ display: "flex", gap: 12, fontSize: "0.8rem" }}>
            <span style={{ fontFamily: "'JetBrains Mono', monospace", color: color, fontWeight: 600, minWidth: 120, flexShrink: 0, fontSize: "0.75rem" }}>{key}</span>
            <span style={{ fontFamily: "'DM Sans', sans-serif", color: "#4A5568", lineHeight: 1.5 }}>{val}</span>
          </div>
        ))}
      </div>
    </div>
  );
}

function RouteTable() {
  return (
    <div style={{ display: "grid", gap: 12 }}>
      {ROUTES.map((r) => (
        <div key={r.group} style={{ background: "#fff", border: "1px solid #DDE3EA", borderRadius: 10, padding: "16px 20px" }}>
          <div style={{ fontFamily: "'DM Sans', sans-serif", fontWeight: 700, fontSize: "0.85rem", color: "#1A4D5E", marginBottom: 10 }}>{r.group}</div>
          <div style={{ display: "flex", flexWrap: "wrap", gap: 6 }}>
            {r.routes.map((route) => (
              <span key={route} style={{ fontFamily: "'JetBrains Mono', monospace", fontSize: "0.72rem", background: "#F5F7F9", border: "1px solid #DDE3EA", borderRadius: 5, padding: "3px 8px", color: "#4A5568" }}>{route}</span>
            ))}
          </div>
        </div>
      ))}
    </div>
  );
}

function SpacingScale() {
  const steps = [
    { name: "space-1", val: "4px", note: "Icon gap" },
    { name: "space-2", val: "8px", note: "Inline gap" },
    { name: "space-3", val: "12px", note: "Form item gap" },
    { name: "space-4", val: "16px", note: "Card padding" },
    { name: "space-6", val: "24px", note: "Section padding" },
    { name: "space-8", val: "32px", note: "Content gap" },
    { name: "space-12", val: "48px", note: "Section spacing" },
    { name: "space-16", val: "64px", note: "Hero padding" },
    { name: "space-24", val: "96px", note: "Page sections" },
  ];
  return (
    <div style={{ display: "grid", gap: 8 }}>
      {steps.map((s) => (
        <div key={s.name} style={{ display: "flex", alignItems: "center", gap: 16 }}>
          <div style={{ width: parseInt(s.val), height: 12, background: "#1A4D5E", borderRadius: 3, flexShrink: 0 }} />
          <span style={{ fontFamily: "'JetBrains Mono', monospace", fontSize: "0.72rem", color: "#1A4D5E", minWidth: 70 }}>{s.val}</span>
          <span style={{ fontFamily: "'DM Sans', sans-serif", fontSize: "0.75rem", color: "#6B7C8D" }}>{s.name} — {s.note}</span>
        </div>
      ))}
    </div>
  );
}

function ComponentShowcase() {
  const [progress, setProgress] = useState(64);
  return (
    <div style={{ display: "grid", gap: 16 }}>
      {/* Buttons */}
      <div style={{ background: "#fff", border: "1px solid #DDE3EA", borderRadius: 10, padding: 20 }}>
        <div style={{ fontFamily: "'DM Sans', sans-serif", fontWeight: 700, fontSize: "0.8rem", color: "#6B7C8D", marginBottom: 14, textTransform: "uppercase", letterSpacing: "0.06em" }}>Buttons</div>
        <div style={{ display: "flex", flexWrap: "wrap", gap: 10 }}>
          {[
            { label: "Enrol Now", bg: "#E07B2A", color: "#fff" },
            { label: "View Course", bg: "#1A4D5E", color: "#fff" },
            { label: "Download PDF", bg: "#fff", color: "#1A4D5E", border: "1.5px solid #1A4D5E" },
            { label: "Completed ✓", bg: "#EAF5EE", color: "#1A7A4A", border: "1.5px solid #1A7A4A" },
            { label: "Waitlisted", bg: "#FFF4E6", color: "#B85C00", border: "1.5px solid #E07B2A" },
          ].map((b) => (
            <button key={b.label} style={{ ...b, borderRadius: 8, padding: "10px 18px", fontFamily: "'DM Sans', sans-serif", fontWeight: 600, fontSize: "0.85rem", cursor: "pointer", border: b.border || "none", transition: "opacity 0.15s" }}>{b.label}</button>
          ))}
        </div>
      </div>

      {/* Course Card */}
      <div style={{ background: "#fff", border: "1px solid #DDE3EA", borderRadius: 10, padding: 20 }}>
        <div style={{ fontFamily: "'DM Sans', sans-serif", fontWeight: 700, fontSize: "0.8rem", color: "#6B7C8D", marginBottom: 14, textTransform: "uppercase", letterSpacing: "0.06em" }}>Course Card</div>
        <div style={{ maxWidth: 340, border: "1px solid #DDE3EA", borderRadius: 12, overflow: "hidden", boxShadow: "0 1px 4px rgba(15,31,43,0.08)" }}>
          <div style={{ height: 140, background: "linear-gradient(135deg, #1A4D5E 0%, #0F3040 100%)", display: "flex", alignItems: "flex-end", padding: "16px" }}>
            <span style={{ background: "#E07B2A", color: "#fff", borderRadius: 20, padding: "4px 12px", fontFamily: "'DM Sans', sans-serif", fontWeight: 700, fontSize: "0.7rem", textTransform: "uppercase", letterSpacing: "0.06em" }}>Finance</span>
          </div>
          <div style={{ padding: 18 }}>
            <div style={{ fontFamily: "'Libre Baskerville', Georgia, serif", fontWeight: 700, fontSize: "1rem", color: "#0F1F2B", lineHeight: 1.35, marginBottom: 6 }}>Advanced Financial Modeling Using MS Excel</div>
            <div style={{ fontFamily: "'DM Sans', sans-serif", fontSize: "0.78rem", color: "#6B7C8D", marginBottom: 14 }}>4 Days · Monthly cohorts · Virtual or In-person</div>
            <div style={{ marginBottom: 14 }}>
              <div style={{ display: "flex", justifyContent: "space-between", fontFamily: "'DM Sans', sans-serif", fontSize: "0.72rem", color: "#6B7C8D", marginBottom: 5 }}>
                <span>Progress</span><span style={{ color: "#1A4D5E", fontWeight: 600 }}>{progress}%</span>
              </div>
              <div style={{ height: 6, borderRadius: 3, background: "#DDE3EA", overflow: "hidden" }}>
                <div style={{ width: `${progress}%`, height: "100%", borderRadius: 3, background: "linear-gradient(90deg, #1A4D5E, #E07B2A)" }} />
              </div>
            </div>
            <div style={{ display: "flex", justifyContent: "space-between", alignItems: "center" }}>
              <span style={{ fontFamily: "'DM Sans', sans-serif", fontWeight: 800, fontSize: "1rem", color: "#0F1F2B" }}>₦350,000</span>
              <button style={{ background: "#E07B2A", color: "#fff", border: "none", borderRadius: 8, padding: "9px 18px", fontFamily: "'DM Sans', sans-serif", fontWeight: 700, fontSize: "0.82rem", cursor: "pointer" }}>Enrol Now</button>
            </div>
          </div>
        </div>
      </div>

      {/* Progress & Status Badges */}
      <div style={{ background: "#fff", border: "1px solid #DDE3EA", borderRadius: 10, padding: 20 }}>
        <div style={{ fontFamily: "'DM Sans', sans-serif", fontWeight: 700, fontSize: "0.8rem", color: "#6B7C8D", marginBottom: 14, textTransform: "uppercase", letterSpacing: "0.06em" }}>Status Badges</div>
        <div style={{ display: "flex", flexWrap: "wrap", gap: 8 }}>
          {[
            { label: "Enrolled", bg: "#EBF4FF", color: "#1A4D5E" },
            { label: "In Progress", bg: "#FFF4E6", color: "#B85C00" },
            { label: "Completed", bg: "#EAF5EE", color: "#1A7A4A" },
            { label: "Certificate Issued", bg: "#E07B2A", color: "#fff" },
            { label: "Upcoming", bg: "#F5F7F9", color: "#4A5568" },
            { label: "Waitlisted", bg: "#FDF3F3", color: "#C0392B" },
          ].map((b) => (
            <span key={b.label} style={{ background: b.bg, color: b.color, borderRadius: 20, padding: "5px 14px", fontFamily: "'DM Sans', sans-serif", fontWeight: 600, fontSize: "0.75rem" }}>{b.label}</span>
          ))}
        </div>
      </div>

      {/* Data Table Row */}
      <div style={{ background: "#fff", border: "1px solid #DDE3EA", borderRadius: 10, padding: 20 }}>
        <div style={{ fontFamily: "'DM Sans', sans-serif", fontWeight: 700, fontSize: "0.8rem", color: "#6B7C8D", marginBottom: 14, textTransform: "uppercase", letterSpacing: "0.06em" }}>Admin Table (sample)</div>
        <div style={{ overflowX: "auto" }}>
          <table style={{ width: "100%", borderCollapse: "collapse", fontFamily: "'DM Sans', sans-serif", fontSize: "0.8rem" }}>
            <thead>
              <tr style={{ background: "#F5F7F9" }}>
                {["Delegate", "Course", "Date", "Fee", "Status"].map(h => (
                  <th key={h} style={{ padding: "10px 14px", textAlign: "left", color: "#6B7C8D", fontWeight: 600, fontSize: "0.72rem", textTransform: "uppercase", letterSpacing: "0.05em", whiteSpace: "nowrap", borderBottom: "1px solid #DDE3EA" }}>{h}</th>
                ))}
              </tr>
            </thead>
            <tbody>
              {[
                { name: "Adaeze Okonkwo", course: "Adv. Financial Modeling", date: "Jan 11–14", fee: "₦350,000", status: "Enrolled", sc: "#EBF4FF", tc: "#1A4D5E" },
                { name: "Emeka Nwosu", course: "Corporate Governance", date: "Feb 02–05", fee: "₦330,000", status: "Completed", sc: "#EAF5EE", tc: "#1A7A4A" },
                { name: "Fatima Al-Hassan", course: "Digital Marketing", date: "Mar 23–26", fee: "₦280,000", status: "Waitlisted", sc: "#FDF3F3", tc: "#C0392B" },
              ].map((row, i) => (
                <tr key={i} style={{ borderBottom: "1px solid #F5F7F9" }}>
                  <td style={{ padding: "12px 14px", color: "#0F1F2B", fontWeight: 500 }}>{row.name}</td>
                  <td style={{ padding: "12px 14px", color: "#4A5568" }}>{row.course}</td>
                  <td style={{ padding: "12px 14px", color: "#4A5568", fontFamily: "'JetBrains Mono', monospace", fontSize: "0.72rem" }}>{row.date}</td>
                  <td style={{ padding: "12px 14px", color: "#0F1F2B", fontFamily: "'JetBrains Mono', monospace", fontSize: "0.75rem", fontWeight: 600 }}>{row.fee}</td>
                  <td style={{ padding: "12px 14px" }}>
                    <span style={{ background: row.sc, color: row.tc, borderRadius: 20, padding: "4px 12px", fontWeight: 600, fontSize: "0.72rem" }}>{row.status}</span>
                  </td>
                </tr>
              ))}
            </tbody>
          </table>
        </div>
      </div>
    </div>
  );
}

// ─── MAIN APP ────────────────────────────────────────────────

const TABS = ["Overview", "Colors", "Typography", "Spacing", "Components", "Tools", "Architecture", "Routes"];

export default function IFSDesignSystem() {
  const [activeTab, setActiveTab] = useState("Overview");

  return (
    <div style={{ fontFamily: "'DM Sans', system-ui, sans-serif", background: "#F5F7F9", minHeight: "100vh", color: "#0F1F2B" }}>
      {/* Header */}
      <div style={{ background: "linear-gradient(135deg, #1A4D5E 0%, #0F2E3A 100%)", color: "#fff", padding: "32px 32px 24px" }}>
        <div style={{ display: "flex", alignItems: "flex-start", justifyContent: "space-between", flexWrap: "wrap", gap: 16 }}>
          <div>
            <div style={{ fontFamily: "'DM Sans', sans-serif", fontWeight: 800, fontSize: "0.7rem", textTransform: "uppercase", letterSpacing: "0.12em", color: "#E07B2A", marginBottom: 6 }}>Enterprise Design System · v1.0</div>
            <div style={{ fontFamily: "'Georgia', serif", fontSize: "clamp(1.6rem, 4vw, 2.4rem)", fontWeight: 700, lineHeight: 1.15, marginBottom: 8 }}>IFS Nigeria<br/>Training & LMS Platform</div>
            <div style={{ fontSize: "0.85rem", color: "rgba(255,255,255,0.65)", maxWidth: 520 }}>
              Next.js 15 · Laravel 11 API · MySQL · cPanel Deployment · Scaled to 10,000+ users
            </div>
          </div>
          <div style={{ display: "flex", gap: 8, flexWrap: "wrap" }}>
            {["Next.js 15", "Laravel 11", "MySQL 8", "cPanel"].map(t => (
              <span key={t} style={{ background: "rgba(255,255,255,0.12)", border: "1px solid rgba(255,255,255,0.2)", borderRadius: 20, padding: "5px 14px", fontSize: "0.75rem", fontWeight: 600, color: "#fff" }}>{t}</span>
            ))}
          </div>
        </div>
      </div>

      {/* Tab Bar */}
      <div style={{ background: "#fff", borderBottom: "1px solid #DDE3EA", padding: "8px 24px", overflowX: "auto" }}>
        <div style={{ display: "flex", gap: 4, minWidth: "max-content" }}>
          {TABS.map(t => <Tab key={t} label={t} active={activeTab === t} onClick={() => setActiveTab(t)} />)}
        </div>
      </div>

      {/* Content */}
      <div style={{ maxWidth: 1100, margin: "0 auto", padding: "32px 24px" }}>

        {/* OVERVIEW */}
        {activeTab === "Overview" && (
          <div>
            <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fit, minmax(200px, 1fr))", gap: 16, marginBottom: 32 }}>
              {[
                { icon: "🎓", num: "37+", label: "Training Courses", sub: "Finance, Legal, Tech, Management" },
                { icon: "👥", num: "10K+", label: "Target Users", sub: "Delegates, Trainers, Admins, HR" },
                { icon: "🏛️", num: "5", label: "User Roles", sub: "RBAC via Spatie Permissions" },
                { icon: "📱", num: "100%", label: "Responsive", sub: "Mobile-first, cPanel-optimised" },
                { icon: "⚡", num: "< 2s", label: "Target TTFB", sub: "Static export + Apache cache" },
                { icon: "🔒", num: "A+", label: "Security Target", sub: "Sanctum auth, HTTPS, RBAC" },
              ].map((s) => (
                <div key={s.label} style={{ background: "#fff", border: "1px solid #DDE3EA", borderRadius: 12, padding: "20px 20px" }}>
                  <div style={{ fontSize: "1.5rem", marginBottom: 10 }}>{s.icon}</div>
                  <div style={{ fontFamily: "'Georgia', serif", fontWeight: 700, fontSize: "1.75rem", color: "#1A4D5E" }}>{s.num}</div>
                  <div style={{ fontWeight: 700, fontSize: "0.85rem", color: "#0F1F2B", marginTop: 4 }}>{s.label}</div>
                  <div style={{ fontSize: "0.75rem", color: "#6B7C8D", marginTop: 3 }}>{s.sub}</div>
                </div>
              ))}
            </div>

            <div style={{ background: "#fff", border: "1px solid #DDE3EA", borderRadius: 12, padding: "24px" }}>
              <div style={{ fontWeight: 700, fontSize: "0.95rem", marginBottom: 16, color: "#0F1F2B" }}>Course Categories Identified in Brochure</div>
              <div style={{ display: "flex", flexWrap: "wrap", gap: 8 }}>
                {["Advanced Financial Modeling", "Financial Statement Analysis", "Advanced Valuation", "Alternative Dispute Resolution", "Budget Preparation", "Contract Management", "Corporate Governance", "Cost Analysis", "Investment Strategies", "Project Appraisal", "Aircraft Leasing", "Capital Structuring", "Financial Derivatives", "Oil & Gas Agreements", "Power Purchase Agreements", "Private Equity Finance", "Real Estate Investment", "Employment Law", "Business Analysis", "Digital Marketing"].map(c => (
                  <span key={c} style={{ background: "#F5F7F9", border: "1px solid #DDE3EA", borderRadius: 20, padding: "5px 14px", fontSize: "0.75rem", color: "#4A5568", fontWeight: 500 }}>{c}</span>
                ))}
              </div>
            </div>
          </div>
        )}

        {/* COLORS */}
        {activeTab === "Colors" && (
          <div>
            <div style={{ fontFamily: "'Georgia', serif", fontSize: "1.5rem", fontWeight: 700, marginBottom: 6 }}>Color System</div>
            <div style={{ fontSize: "0.85rem", color: "#6B7C8D", marginBottom: 24 }}>Derived from IFS Nigeria branding — Deep Teal + Amber. Click any swatch to copy hex.</div>
            <div style={{ display: "grid", gridTemplateColumns: "repeat(auto-fill, minmax(180px, 1fr))", gap: 14 }}>
              {Object.values(TOKENS.colors).map(c => <ColorSwatch key={c.hex} {...c} />)}
            </div>
          </div>
        )}

        {/* TYPOGRAPHY */}
        {activeTab === "Typography" && (
          <div>
            <div style={{ fontFamily: "'Georgia', serif", fontSize: "1.5rem", fontWeight: 700, marginBottom: 6 }}>Typography System</div>
            <div style={{ fontSize: "0.85rem", color: "#6B7C8D", marginBottom: 24 }}>Four purposeful typefaces. All loaded via <code style={{ background: "#F5F7F9", padding: "1px 6px", borderRadius: 4 }}>next/font/google</code> — zero CLS, self-hosted at build time.</div>
            {Object.entries(TOKENS.typography).map(([key, t]) => (
              <TypeSpecimen key={key} {...t} />
            ))}
            <div style={{ background: "#fff", border: "1px solid #DDE3EA", borderRadius: 12, padding: "20px 24px", marginTop: 16 }}>
              <div style={{ fontWeight: 700, fontSize: "0.85rem", marginBottom: 14, color: "#0F1F2B" }}>Type Scale (Fluid / clamp)</div>
              <div style={{ display: "grid", gap: 10 }}>
                {Object.entries(TOKENS.scale).map(([key, val]) => (
                  <div key={key} style={{ display: "flex", alignItems: "baseline", gap: 20 }}>
                    <span style={{ fontFamily: "'JetBrains Mono', monospace", fontSize: "0.7rem", color: "#E07B2A", minWidth: 50 }}>{key}</span>
                    <span style={{ fontFamily: "'Georgia', serif", fontSize: key.includes("xl") ? "1.4rem" : "1rem", color: "#0F1F2B", lineHeight: 1 }}>Institute for Fiscal Studies</span>
                    <span style={{ fontFamily: "'JetBrains Mono', monospace", fontSize: "0.7rem", color: "#6B7C8D", marginLeft: "auto" }}>{val}</span>
                  </div>
                ))}
              </div>
            </div>
          </div>
        )}

        {/* SPACING */}
        {activeTab === "Spacing" && (
          <div>
            <div style={{ fontFamily: "'Georgia', serif", fontSize: "1.5rem", fontWeight: 700, marginBottom: 6 }}>Spacing & Layout</div>
            <div style={{ fontSize: "0.85rem", color: "#6B7C8D", marginBottom: 24 }}>8px base unit. Tailwind spacing scale mapped to Tailwind config.</div>
            <div style={{ background: "#fff", border: "1px solid #DDE3EA", borderRadius: 12, padding: "24px", marginBottom: 16 }}>
              <div style={{ fontWeight: 700, fontSize: "0.85rem", marginBottom: 16 }}>Spacing Scale</div>
              <SpacingScale />
            </div>
            <div style={{ background: "#fff", border: "1px solid #DDE3EA", borderRadius: 12, padding: "24px" }}>
              <div style={{ fontWeight: 700, fontSize: "0.85rem", marginBottom: 14 }}>Border Radius System</div>
              <div style={{ display: "flex", gap: 20, flexWrap: "wrap" }}>
                {Object.entries(TOKENS.radius).map(([key, val]) => (
                  <div key={key} style={{ textAlign: "center" }}>
                    <div style={{ width: 60, height: 60, background: "#1A4D5E", borderRadius: val, margin: "0 auto 8px" }} />
                    <div style={{ fontFamily: "'JetBrains Mono', monospace", fontSize: "0.7rem", color: "#E07B2A" }}>{key}</div>
                    <div style={{ fontFamily: "'DM Sans', sans-serif", fontSize: "0.7rem", color: "#6B7C8D" }}>{val}</div>
                  </div>
                ))}
              </div>
            </div>
          </div>
        )}

        {/* COMPONENTS */}
        {activeTab === "Components" && (
          <div>
            <div style={{ fontFamily: "'Georgia', serif", fontSize: "1.5rem", fontWeight: 700, marginBottom: 6 }}>Component Library</div>
            <div style={{ fontSize: "0.85rem", color: "#6B7C8D", marginBottom: 24 }}>shadcn/ui base components extended with IFS design tokens. All keyboard accessible via Radix UI primitives.</div>
            <ComponentShowcase />
          </div>
        )}

        {/* TOOLS */}
        {activeTab === "Tools" && (
          <div>
            <div style={{ fontFamily: "'Georgia', serif", fontSize: "1.5rem", fontWeight: 700, marginBottom: 6 }}>Platform Tools & Skills</div>
            <div style={{ fontSize: "0.85rem", color: "#6B7C8D", marginBottom: 24 }}>Every feature module the LMS needs — expandable by category. Organised by domain.</div>
            {TOOLS.map(t => <ToolCard key={t.category} {...t} />)}
          </div>
        )}

        {/* ARCHITECTURE */}
        {activeTab === "Architecture" && (
          <div>
            <div style={{ fontFamily: "'Georgia', serif", fontSize: "1.5rem", fontWeight: 700, marginBottom: 6 }}>Technical Architecture</div>
            <div style={{ fontSize: "0.85rem", color: "#6B7C8D", marginBottom: 24 }}>Full-stack blueprint for Next.js 15 + Laravel 11 deployed on cPanel. Optimised for shared hosting constraints with enterprise scalability path.</div>
            <ArchSection title="Next.js Frontend" data={ARCHITECTURE.frontend} color="#1A4D5E" />
            <ArchSection title="Laravel API Backend" data={ARCHITECTURE.backend} color="#E07B2A" />
            <ArchSection title="Database Layer" data={ARCHITECTURE.database} color="#1A7A4A" />
            <ArchSection title="cPanel Deployment" data={ARCHITECTURE.deployment} color="#B85C00" />
          </div>
        )}

        {/* ROUTES */}
        {activeTab === "Routes" && (
          <div>
            <div style={{ fontFamily: "'Georgia', serif", fontSize: "1.5rem", fontWeight: 700, marginBottom: 6 }}>Route Map</div>
            <div style={{ fontSize: "0.85rem", color: "#6B7C8D", marginBottom: 24 }}>All Next.js App Router pages and Laravel API endpoints. Role-protected routes enforced via middleware + Sanctum.</div>
            <RouteTable />
          </div>
        )}

      </div>

      {/* Footer */}
      <div style={{ borderTop: "1px solid #DDE3EA", background: "#fff", padding: "20px 32px", display: "flex", justifyContent: "space-between", alignItems: "center", flexWrap: "wrap", gap: 12 }}>
        <span style={{ fontFamily: "'DM Sans', sans-serif", fontSize: "0.8rem", color: "#6B7C8D" }}>IFS Nigeria LMS — Enterprise Design System v1.0 · 2025</span>
        <div style={{ display: "flex", gap: 16 }}>
          {["Next.js 15", "Laravel 11", "Tailwind CSS", "shadcn/ui", "Paystack"].map(t => (
            <span key={t} style={{ fontFamily: "'DM Sans', sans-serif", fontSize: "0.72rem", color: "#6B7C8D" }}>{t}</span>
          ))}
        </div>
      </div>
    </div>
  );
}
