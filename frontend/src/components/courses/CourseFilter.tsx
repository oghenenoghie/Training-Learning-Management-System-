"use client";

import { useCategories } from "@/hooks/useCourses";
import { Button } from "@/components/ui/Button";
import { Search } from "lucide-react";
import { useState } from "react";

interface CourseFilterProps {
  onFilter: (params: Record<string, string>) => void;
}

const MODES = [
  { value: "", label: "All Modes" },
  { value: "virtual", label: "Virtual" },
  { value: "in-person", label: "In-Person" },
  { value: "hybrid", label: "Hybrid" },
];

export function CourseFilter({ onFilter }: CourseFilterProps) {
  const { data: categoriesRes } = useCategories();
  const categories = categoriesRes?.data ?? [];
  const [search, setSearch] = useState("");
  const [category, setCategory] = useState("");
  const [mode, setMode] = useState("");

  const handleSearch = () => {
    const params: Record<string, string> = {};
    if (search) params.search = search;
    if (category) params.category_id = category;
    if (mode) params.mode = mode;
    onFilter(params);
  };

  return (
    <div className="bg-white rounded-lg border border-fog shadow-card p-4">
      <div className="flex flex-col sm:flex-row gap-3">
        {/* Search */}
        <div className="relative flex-1">
          <Search size={16} className="absolute left-3 top-1/2 -translate-y-1/2 text-muted" />
          <input
            type="text"
            placeholder="Search courses..."
            value={search}
            onChange={(e) => setSearch(e.target.value)}
            onKeyDown={(e) => e.key === "Enter" && handleSearch()}
            className="w-full pl-9 pr-4 py-2.5 rounded-md border border-fog font-heading text-sm text-ink placeholder:text-muted focus:outline-none focus:ring-2 focus:ring-accent/40 focus:border-accent"
          />
        </div>

        {/* Category */}
        <select
          value={category}
          onChange={(e) => setCategory(e.target.value)}
          className="px-4 py-2.5 rounded-md border border-fog font-heading text-sm text-ink bg-white focus:outline-none focus:ring-2 focus:ring-accent/40"
        >
          <option value="">All Categories</option>
          {categories.map((c) => (
            <option key={c.id} value={c.id}>{c.name}</option>
          ))}
        </select>

        {/* Mode */}
        <select
          value={mode}
          onChange={(e) => setMode(e.target.value)}
          className="px-4 py-2.5 rounded-md border border-fog font-heading text-sm text-ink bg-white focus:outline-none focus:ring-2 focus:ring-accent/40"
        >
          {MODES.map((m) => (
            <option key={m.value} value={m.value}>{m.label}</option>
          ))}
        </select>

        <Button onClick={handleSearch} variant="primary">Search</Button>
      </div>
    </div>
  );
}
