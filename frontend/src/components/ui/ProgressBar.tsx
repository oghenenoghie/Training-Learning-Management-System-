import { cn } from "@/lib/utils";

interface ProgressBarProps {
  value: number;
  className?: string;
  showLabel?: boolean;
  size?: "sm" | "md";
}

export function ProgressBar({ value, className, showLabel = true, size = "md" }: ProgressBarProps) {
  const clamped = Math.max(0, Math.min(100, value));
  return (
    <div className={cn("w-full", className)}>
      {showLabel && (
        <div className="flex justify-between font-heading text-xs text-muted mb-1.5">
          <span>Progress</span>
          <span className="text-primary font-semibold">{clamped}%</span>
        </div>
      )}
      <div className={cn("w-full rounded-full bg-fog overflow-hidden", size === "sm" ? "h-1.5" : "h-2")}>
        <div
          className="h-full rounded-full bg-gradient-to-r from-primary to-accent transition-all duration-500"
          style={{ width: `${clamped}%` }}
        />
      </div>
    </div>
  );
}
