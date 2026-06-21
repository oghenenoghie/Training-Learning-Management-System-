"use client";

import { DashboardLayout } from "@/components/layout/DashboardLayout";
import { CourseCard } from "@/components/courses/CourseCard";
import { useEnrolments } from "@/hooks/useEnrolments";
import { Loader2, BookOpen } from "lucide-react";
import { Button } from "@/components/ui/Button";
import Link from "next/link";
import { useState } from "react";

const TABS = ["All", "In Progress", "Completed"] as const;
type Tab = (typeof TABS)[number];

export default function MyCoursesPage() {
  const { data, isLoading } = useEnrolments();
  const [tab, setTab] = useState<Tab>("All");
  const all = data?.data ?? [];

  const filtered =
    tab === "In Progress" ? all.filter((e) => e.progress > 0 && e.progress < 100) :
    tab === "Completed"   ? all.filter((e) => e.progress >= 100 || e.status === "completed") :
    all;

  return (
    <DashboardLayout role="delegate" title="My Courses">
      {/* Tabs */}
      <div className="flex gap-1 bg-white border border-fog rounded-lg p-1 w-fit mb-6">
        {TABS.map((t) => (
          <button
            key={t}
            onClick={() => setTab(t)}
            className={`px-4 py-2 rounded-md font-heading text-sm font-medium transition-all ${
              tab === t ? "bg-primary text-white" : "text-muted hover:text-ink"
            }`}
          >
            {t}
          </button>
        ))}
      </div>

      {isLoading && (
        <div className="flex justify-center py-20">
          <Loader2 size={28} className="text-primary animate-spin" />
        </div>
      )}

      {!isLoading && filtered.length === 0 && (
        <div className="flex flex-col items-center py-20 bg-white rounded-lg border border-fog">
          <BookOpen size={48} className="text-fog mb-4" />
          <p className="font-heading text-base text-muted mb-4">
            {tab === "All" ? "You haven't enrolled in any courses yet." : `No ${tab.toLowerCase()} courses.`}
          </p>
          <Link href="/courses">
            <Button variant="accent">Browse Courses</Button>
          </Link>
        </div>
      )}

      {!isLoading && filtered.length > 0 && (
        <div className="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
          {filtered.map((e) => (
            <CourseCard key={e.id} course={e.course} enrolment={e} variant="enrolled" />
          ))}
        </div>
      )}
    </DashboardLayout>
  );
}
