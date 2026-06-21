"use client";

import { use, useState } from "react";
import { DashboardLayout } from "@/components/layout/DashboardLayout";
import { ProgressBar } from "@/components/ui/ProgressBar";
import { Button } from "@/components/ui/Button";
import { Badge } from "@/components/ui/Badge";
import { useEnrolments } from "@/hooks/useEnrolments";
import { Loader2, ChevronLeft, ChevronRight, Play, FileText, Link2 } from "lucide-react";
import type { CourseMaterial } from "@/types";

const ICON_MAP = {
  video:    <Play size={16} />,
  pdf:      <FileText size={16} />,
  document: <FileText size={16} />,
  link:     <Link2 size={16} />,
};

export default function CourseLearnPage({ params }: { params: Promise<{ id: string }> }) {
  const { id } = use(params);
  const { data } = useEnrolments({ id });
  const enrolment = data?.data?.[0];
  const course = enrolment?.course;
  const materials: CourseMaterial[] = (course as unknown as { materials?: CourseMaterial[] })?.materials ?? [];

  const [currentIdx, setCurrentIdx] = useState(0);
  const current = materials[currentIdx];

  if (!enrolment) {
    return (
      <DashboardLayout role="delegate" title="Loading...">
        <div className="flex justify-center py-20">
          <Loader2 size={28} className="text-primary animate-spin" />
        </div>
      </DashboardLayout>
    );
  }

  return (
    <DashboardLayout role="delegate" title={course?.title ?? "Course Player"}>
      <div className="grid lg:grid-cols-4 gap-6">
        {/* Sidebar: Material List */}
        <aside className="lg:col-span-1 space-y-2">
          <ProgressBar value={enrolment.progress} className="mb-4" />
          <p className="font-heading text-xs font-semibold text-muted uppercase tracking-wider mb-3">
            Course Content
          </p>
          {materials.length === 0 && (
            <p className="font-heading text-xs text-muted">No materials uploaded yet.</p>
          )}
          {materials.map((m, i) => (
            <button
              key={m.id}
              onClick={() => setCurrentIdx(i)}
              className={`w-full flex items-start gap-3 p-3 rounded-lg text-left transition-all ${
                i === currentIdx
                  ? "bg-primary/10 text-primary"
                  : "hover:bg-surface text-muted hover:text-ink"
              }`}
            >
              <span className="mt-0.5 shrink-0">{ICON_MAP[m.type]}</span>
              <div className="min-w-0">
                <p className="font-heading text-xs font-medium truncate">{m.title}</p>
                {m.duration_minutes && (
                  <p className="font-mono text-[10px] mt-0.5 text-muted">{m.duration_minutes} min</p>
                )}
              </div>
            </button>
          ))}
        </aside>

        {/* Player Area */}
        <div className="lg:col-span-3 space-y-4">
          {current ? (
            <>
              <div className="bg-ink rounded-xl overflow-hidden aspect-video flex items-center justify-center">
                {current.type === "video" ? (
                  <iframe
                    src={current.url}
                    className="w-full h-full"
                    allowFullScreen
                    title={current.title}
                  />
                ) : current.type === "pdf" ? (
                  <iframe
                    src={current.url}
                    className="w-full h-full bg-white"
                    title={current.title}
                  />
                ) : (
                  <div className="text-center text-white/60">
                    <FileText size={48} className="mx-auto mb-3 opacity-40" />
                    <p className="font-heading text-sm">
                      <a href={current.url} target="_blank" rel="noreferrer" className="text-accent underline">
                        Open material in new tab
                      </a>
                    </p>
                  </div>
                )}
              </div>

              <div className="bg-white rounded-lg border border-fog p-5">
                <div className="flex items-start justify-between gap-3">
                  <div>
                    <Badge label={current.type} variant="primary" className="mb-2" />
                    <h3 className="font-display text-lg font-bold text-ink">{current.title}</h3>
                  </div>
                  <div className="flex gap-2 shrink-0">
                    <Button
                      size="sm" variant="outline"
                      disabled={currentIdx === 0}
                      onClick={() => setCurrentIdx(i => i - 1)}
                    >
                      <ChevronLeft size={16} /> Prev
                    </Button>
                    <Button
                      size="sm"
                      disabled={currentIdx === materials.length - 1}
                      onClick={() => setCurrentIdx(i => i + 1)}
                    >
                      Next <ChevronRight size={16} />
                    </Button>
                  </div>
                </div>
              </div>
            </>
          ) : (
            <div className="flex flex-col items-center justify-center bg-white rounded-xl border border-fog py-20">
              <Play size={48} className="text-fog mb-4" />
              <p className="font-heading text-base text-muted">No material selected.</p>
            </div>
          )}
        </div>
      </div>
    </DashboardLayout>
  );
}
