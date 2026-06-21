import { InputHTMLAttributes, forwardRef } from "react";
import { cn } from "@/lib/utils";

interface InputProps extends InputHTMLAttributes<HTMLInputElement> {
  label?: string;
  error?: string;
  hint?: string;
}

export const Input = forwardRef<HTMLInputElement, InputProps>(
  ({ label, error, hint, className, id, ...props }, ref) => {
    const inputId = id ?? label?.toLowerCase().replace(/\s/g, "-");
    return (
      <div className="flex flex-col gap-1.5">
        {label && (
          <label htmlFor={inputId} className="font-heading text-sm font-semibold text-ink">
            {label}
          </label>
        )}
        <input
          ref={ref}
          id={inputId}
          className={cn(
            "w-full rounded-md border border-fog bg-white px-4 py-2.5 font-heading text-sm text-ink placeholder:text-muted",
            "focus:outline-none focus:ring-2 focus:ring-accent/40 focus:border-accent transition-all",
            error && "border-danger focus:ring-danger/30",
            className
          )}
          {...props}
        />
        {error && <p className="font-heading text-xs text-danger">{error}</p>}
        {hint && !error && <p className="font-heading text-xs text-muted">{hint}</p>}
      </div>
    );
  }
);
Input.displayName = "Input";
