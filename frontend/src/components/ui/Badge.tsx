import { cn } from "@/lib/utils";

type BadgeVariant = "enrolled" | "in_progress" | "completed" | "certificate_issued"
  | "upcoming" | "waitlisted" | "pending" | "paid" | "failed" | "refunded"
  | "confirmed" | "cancelled" | "primary" | "accent";

const BADGE_STYLES: Record<BadgeVariant, string> = {
  enrolled:           "bg-blue-50 text-primary",
  in_progress:        "bg-amber-50 text-warning",
  completed:          "bg-green-50 text-success",
  certificate_issued: "bg-accent text-white",
  upcoming:           "bg-surface text-muted",
  waitlisted:         "bg-red-50 text-danger",
  pending:            "bg-amber-50 text-warning",
  confirmed:          "bg-blue-50 text-primary",
  cancelled:          "bg-red-50 text-danger",
  paid:               "bg-green-50 text-success",
  failed:             "bg-red-50 text-danger",
  refunded:           "bg-gray-100 text-muted",
  primary:            "bg-primary text-white",
  accent:             "bg-accent text-white",
};

interface BadgeProps {
  variant?: BadgeVariant;
  label: string;
  className?: string;
}

export function Badge({ variant = "primary", label, className }: BadgeProps) {
  return (
    <span
      className={cn(
        "inline-flex items-center px-3 py-1 rounded-full text-xs font-heading font-semibold",
        BADGE_STYLES[variant],
        className
      )}
    >
      {label.replace(/_/g, " ").replace(/\b\w/g, (c) => c.toUpperCase())}
    </span>
  );
}
