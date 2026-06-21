import { cn } from "@/lib/utils";
import { HTMLAttributes } from "react";

interface CardProps extends HTMLAttributes<HTMLDivElement> {
  padding?: "none" | "sm" | "md" | "lg";
}

const paddingMap = { none: "", sm: "p-4", md: "p-5 md:p-6", lg: "p-6 md:p-8" };

export function Card({ padding = "md", className, children, ...props }: CardProps) {
  return (
    <div
      className={cn(
        "bg-white rounded-lg border border-fog shadow-card",
        paddingMap[padding],
        className
      )}
      {...props}
    >
      {children}
    </div>
  );
}

export function StatCard({
  icon,
  label,
  value,
  sub,
  accent = false,
}: {
  icon: string;
  label: string;
  value: string | number;
  sub?: string;
  accent?: boolean;
}) {
  return (
    <Card className="flex items-start gap-4">
      <div
        className={cn(
          "w-12 h-12 rounded-lg flex items-center justify-center text-xl flex-shrink-0",
          accent ? "bg-accent/10" : "bg-primary/10"
        )}
      >
        {icon}
      </div>
      <div>
        <p className="font-heading text-sm text-muted">{label}</p>
        <p className={cn("font-display text-2xl font-bold mt-0.5", accent ? "text-accent" : "text-primary")}>
          {value}
        </p>
        {sub && <p className="font-heading text-xs text-muted mt-1">{sub}</p>}
      </div>
    </Card>
  );
}
