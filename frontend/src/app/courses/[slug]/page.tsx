"use client";

import { use } from "react";
import { Navbar } from "@/components/layout/Navbar";
import { Footer } from "@/components/layout/Footer";
import { Button } from "@/components/ui/Button";
import { Badge } from "@/components/ui/Badge";
import { Modal } from "@/components/ui/Modal";
import { useCourse } from "@/hooks/useCourses";
import { useEnrol, useInitiatePayment } from "@/hooks/useEnrolments";
import { useAuth } from "@/hooks/useAuth";
import { formatCurrency, formatDate } from "@/lib/utils";
import { Clock, MapPin, Calendar, CheckCircle2, Loader2 } from "lucide-react";
import { useState } from "react";
import type { CourseSchedule } from "@/types";
import Link from "next/link";

export default function CourseDetailPage({ params }: { params: Promise<{ slug: string }> }) {
  const { slug } = use(params);
  const { data, isLoading } = useCourse(slug);
  const course = data?.data;
  const { isAuthenticated } = useAuth();
  const enrol = useEnrol();
  const initiatePayment = useInitiatePayment();

  const [scheduleModal, setScheduleModal] = useState(false);
  const [selectedSchedule, setSelectedSchedule] = useState<CourseSchedule | null>(null);

  const handleEnrol = async () => {
    if (!course) return;
    try {
      const res = await enrol.mutateAsync({
        course_id: course.id,
        schedule_id: selectedSchedule?.id,
      });
      if (res.data?.id) {
        await initiatePayment.mutateAsync({ enrolment_id: res.data.id });
      }
    } catch {
      // handled by interceptor
    }
    setScheduleModal(false);
  };

  if (isLoading) {
    return (
      <>
        <Navbar />
        <div className="flex justify-center py-32">
          <Loader2 size={32} className="text-primary animate-spin" />
        </div>
      </>
    );
  }

  if (!course) {
    return (
      <>
        <Navbar />
        <div className="text-center py-32">
          <p className="font-heading text-muted">Course not found.</p>
          <Link href="/courses" className="text-primary font-heading text-sm mt-2 inline-block">
            Back to courses
          </Link>
        </div>
      </>
    );
  }

  return (
    <>
      <Navbar />
      <main>
        {/* Hero Banner */}
        <div className="bg-gradient-to-br from-primary to-[#0f2e3a] text-white py-14 px-4">
          <div className="max-w-5xl mx-auto">
            <Badge label={course.category?.name ?? "General"} variant="accent" className="mb-4" />
            <h1 className="font-display text-3xl md:text-4xl font-bold mb-4 max-w-3xl">{course.title}</h1>
            <p className="font-body text-base text-white/70 max-w-2xl leading-relaxed">{course.short_description ?? course.description}</p>
            <div className="flex flex-wrap gap-x-6 gap-y-2 mt-5">
              <span className="flex items-center gap-1.5 font-heading text-sm text-white/70">
                <Clock size={14} /> {course.duration_days} days
              </span>
              <span className="flex items-center gap-1.5 font-heading text-sm text-white/70">
                <MapPin size={14} /> {course.mode}
              </span>
              <span className="flex items-center gap-1.5 font-heading text-sm text-white/70">
                <Calendar size={14} /> Monthly cohorts
              </span>
            </div>
          </div>
        </div>

        <div className="max-w-5xl mx-auto px-4 py-10 grid md:grid-cols-3 gap-8">
          {/* Description */}
          <div className="md:col-span-2 space-y-8">
            <div>
              <h2 className="font-display text-xl font-bold text-ink mb-4">About This Course</h2>
              <p className="font-body text-base text-ink/80 leading-relaxed whitespace-pre-line">{course.description}</p>
            </div>

            {course.objectives && course.objectives.length > 0 && (
              <div>
                <h2 className="font-display text-xl font-bold text-ink mb-4">What You'll Learn</h2>
                <ul className="space-y-3">
                  {course.objectives.map((obj, i) => (
                    <li key={i} className="flex items-start gap-3">
                      <CheckCircle2 size={18} className="text-success mt-0.5 shrink-0" />
                      <span className="font-heading text-sm text-ink/80">{obj}</span>
                    </li>
                  ))}
                </ul>
              </div>
            )}

            {course.schedules && course.schedules.length > 0 && (
              <div>
                <h2 className="font-display text-xl font-bold text-ink mb-4">Upcoming Dates</h2>
                <div className="space-y-3">
                  {course.schedules.map((s) => (
                    <div
                      key={s.id}
                      className="flex items-center justify-between p-4 rounded-lg border border-fog bg-white"
                    >
                      <div>
                        <p className="font-heading font-semibold text-sm text-ink">
                          {formatDate(s.start_date)} – {formatDate(s.end_date)}
                        </p>
                        <p className="font-heading text-xs text-muted mt-0.5">
                          {s.mode} · {s.seats_available} seats remaining
                        </p>
                      </div>
                      <Button
                        size="sm"
                        variant={s.seats_available > 0 ? "accent" : "ghost"}
                        disabled={s.seats_available === 0}
                        onClick={() => { setSelectedSchedule(s); setScheduleModal(true); }}
                      >
                        {s.seats_available > 0 ? "Select" : "Full"}
                      </Button>
                    </div>
                  ))}
                </div>
              </div>
            )}
          </div>

          {/* Sticky Enrol Card */}
          <div>
            <div className="sticky top-20 bg-white rounded-xl border border-fog shadow-float p-6 space-y-5">
              <div className="font-mono text-3xl font-bold text-ink">{formatCurrency(course.fee, course.currency)}</div>
              <div className="space-y-2 text-sm font-heading">
                <div className="flex justify-between text-muted">
                  <span>Duration</span><span className="text-ink font-medium">{course.duration_days} days</span>
                </div>
                <div className="flex justify-between text-muted">
                  <span>Mode</span><span className="text-ink font-medium capitalize">{course.mode}</span>
                </div>
                <div className="flex justify-between text-muted">
                  <span>Level</span><span className="text-ink font-medium capitalize">{course.level}</span>
                </div>
                <div className="flex justify-between text-muted">
                  <span>Certificate</span><span className="text-success font-medium">Included</span>
                </div>
              </div>
              <hr className="border-fog" />
              {isAuthenticated ? (
                <Button
                  variant="accent"
                  size="lg"
                  className="w-full"
                  loading={enrol.isPending}
                  onClick={() => setScheduleModal(true)}
                >
                  Enrol Now
                </Button>
              ) : (
                <Link href={`/register?redirect=/courses/${course.slug}`} className="block">
                  <Button variant="accent" size="lg" className="w-full">Register to Enrol</Button>
                </Link>
              )}
              <p className="font-heading text-xs text-muted text-center">Secure payment via Paystack</p>
            </div>
          </div>
        </div>
      </main>

      <Modal open={scheduleModal} onClose={() => setScheduleModal(false)} title="Confirm Enrolment" size="sm">
        <div className="space-y-4">
          <p className="font-heading text-sm text-ink">
            You're enrolling in <strong>{course.title}</strong>.
            {selectedSchedule && (
              <> Cohort: <strong>{formatDate(selectedSchedule.start_date)}</strong></>
            )}
          </p>
          <p className="font-heading text-sm text-muted">
            Fee: <strong className="font-mono text-ink">{formatCurrency(course.fee, course.currency)}</strong>
          </p>
          <p className="font-heading text-xs text-muted">
            You will be redirected to Paystack to complete payment.
          </p>
          <div className="flex gap-3 pt-2">
            <Button variant="outline" className="flex-1" onClick={() => setScheduleModal(false)}>
              Cancel
            </Button>
            <Button variant="accent" className="flex-1" loading={enrol.isPending || initiatePayment.isPending} onClick={handleEnrol}>
              Pay Now
            </Button>
          </div>
        </div>
      </Modal>

      <Footer />
    </>
  );
}
