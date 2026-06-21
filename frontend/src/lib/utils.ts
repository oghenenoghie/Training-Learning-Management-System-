import { clsx, type ClassValue } from "clsx";
import { twMerge } from "tailwind-merge";

export function cn(...inputs: ClassValue[]) {
  return twMerge(clsx(inputs));
}

export function formatCurrency(amount: number, currency = "NGN"): string {
  if (currency === "NGN") {
    return `₦${amount.toLocaleString("en-NG")}`;
  }
  return new Intl.NumberFormat("en-US", { style: "currency", currency }).format(amount);
}

export function formatDate(dateStr: string): string {
  return new Date(dateStr).toLocaleDateString("en-NG", {
    day: "numeric",
    month: "long",
    year: "numeric",
  });
}

export function formatDateShort(dateStr: string): string {
  return new Date(dateStr).toLocaleDateString("en-NG", {
    day: "numeric",
    month: "short",
  });
}

export function getInitials(name: string): string {
  return name
    .split(" ")
    .slice(0, 2)
    .map((n) => n[0])
    .join("")
    .toUpperCase();
}

export function truncate(str: string, length: number): string {
  return str.length > length ? `${str.slice(0, length)}...` : str;
}

export const STATUS_COLORS: Record<string, { bg: string; text: string }> = {
  enrolled:          { bg: "bg-blue-50",   text: "text-primary" },
  in_progress:       { bg: "bg-amber-50",  text: "text-warning" },
  completed:         { bg: "bg-green-50",  text: "text-success" },
  certificate_issued:{ bg: "bg-accent",    text: "text-white" },
  upcoming:          { bg: "bg-surface",   text: "text-muted" },
  waitlisted:        { bg: "bg-red-50",    text: "text-danger" },
  pending:           { bg: "bg-amber-50",  text: "text-warning" },
  confirmed:         { bg: "bg-blue-50",   text: "text-primary" },
  cancelled:         { bg: "bg-red-50",    text: "text-danger" },
  paid:              { bg: "bg-green-50",  text: "text-success" },
  failed:            { bg: "bg-red-50",    text: "text-danger" },
  refunded:          { bg: "bg-gray-100",  text: "text-muted" },
};
