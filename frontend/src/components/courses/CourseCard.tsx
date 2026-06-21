import Link from "next/link";
import { Clock, MapPin, Users } from "lucide-react";
import { Badge } from "@/components/ui/Badge";
import { Button } from "@/components/ui/Button";
import { ProgressBar } from "@/components/ui/ProgressBar";
import { formatCurrency } from "@/lib/utils";
import type { Course, Enrolment } from "@/types";

interface CourseCardProps {
  course: Course;
  enrolment?: Enrolment;
  variant?: "catalog" | "enrolled";
}

export function CourseCard({ course, enrolment, variant = "catalog" }: CourseCardProps) {
  return (
    <div className="bg-white rounded-lg border border-fog shadow-card overflow-hidden flex flex-col hover:shadow-float transition-shadow duration-200 group">
      {/* Thumbnail */}
      <div className="h-36 bg-gradient-to-br from-primary to-[#0f3040] relative overflow-hidden">
        {course.thumbnail && (
          <img src={course.thumbnail} alt={course.title} className="w-full h-full object-cover opacity-80" />
        )}
        <div className="absolute bottom-3 left-3">
          <Badge
            label={course.category?.name ?? "General"}
            variant="accent"
            className="text-[10px] uppercase tracking-wider"
          />
        </div>
        {course.is_featured && (
          <div className="absolute top-3 right-3 bg-accent/90 text-white font-heading text-[10px] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider">
            Featured
          </div>
        )}
      </div>

      {/* Body */}
      <div className="flex flex-col flex-1 p-4">
        <h3 className="font-display font-bold text-sm text-ink leading-snug mb-1 line-clamp-2 group-hover:text-primary transition-colors">
          {course.title}
        </h3>

        <div className="flex flex-wrap items-center gap-x-3 gap-y-1 mt-1 mb-3">
          <span className="flex items-center gap-1 font-heading text-xs text-muted">
            <Clock size={12} /> {course.duration_days} day{course.duration_days !== 1 ? "s" : ""}
          </span>
          <span className="flex items-center gap-1 font-heading text-xs text-muted">
            <MapPin size={12} />
            {course.mode === "virtual" ? "Virtual" : course.mode === "in-person" ? "In-Person" : "Hybrid"}
          </span>
          {typeof course.enrolments_count === "number" && (
            <span className="flex items-center gap-1 font-heading text-xs text-muted">
              <Users size={12} /> {course.enrolments_count}
            </span>
          )}
        </div>

        {enrolment && variant === "enrolled" && (
          <ProgressBar value={enrolment.progress} className="mb-3" />
        )}

        <div className="mt-auto flex items-center justify-between pt-3 border-t border-fog">
          <span className="font-mono font-bold text-base text-ink">
            {formatCurrency(course.fee, course.currency)}
          </span>
          {variant === "enrolled" && enrolment ? (
            <Link href={`/my-courses/${enrolment.id}/learn`}>
              <Button size="sm" variant={enrolment.progress >= 100 ? "success" : "primary"}>
                {enrolment.progress >= 100 ? "Review" : "Continue"}
              </Button>
            </Link>
          ) : (
            <Link href={`/courses/${course.slug}`}>
              <Button size="sm" variant="accent">Enrol Now</Button>
            </Link>
          )}
        </div>
      </div>
    </div>
  );
}
