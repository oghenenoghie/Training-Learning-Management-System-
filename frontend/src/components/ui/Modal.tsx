"use client";

import { Fragment } from "react";
import { X } from "lucide-react";
import { cn } from "@/lib/utils";

interface ModalProps {
  open: boolean;
  onClose: () => void;
  title?: string;
  children: React.ReactNode;
  size?: "sm" | "md" | "lg" | "xl";
}

const sizeMap = {
  sm: "max-w-sm",
  md: "max-w-md",
  lg: "max-w-lg",
  xl: "max-w-2xl",
};

export function Modal({ open, onClose, title, children, size = "md" }: ModalProps) {
  if (!open) return null;
  return (
    <Fragment>
      <div
        className="fixed inset-0 bg-ink/30 backdrop-blur-sm z-40"
        onClick={onClose}
      />
      <div className="fixed inset-0 z-50 flex items-center justify-center p-4">
        <div
          className={cn(
            "bg-white rounded-xl shadow-float w-full animate-in fade-in zoom-in-95 duration-200",
            sizeMap[size]
          )}
        >
          {title && (
            <div className="flex items-center justify-between px-6 py-4 border-b border-fog">
              <h2 className="font-display text-lg font-bold text-ink">{title}</h2>
              <button
                onClick={onClose}
                className="text-muted hover:text-ink transition-colors rounded-md p-1 hover:bg-surface"
              >
                <X size={18} />
              </button>
            </div>
          )}
          <div className="p-6">{children}</div>
        </div>
      </div>
    </Fragment>
  );
}
