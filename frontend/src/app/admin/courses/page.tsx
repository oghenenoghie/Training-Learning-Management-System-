"use client";

import { useState } from "react";
import { DashboardLayout } from "@/components/layout/DashboardLayout";
import { Button } from "@/components/ui/Button";
import { Badge } from "@/components/ui/Badge";
import { Modal } from "@/components/ui/Modal";
import { Input } from "@/components/ui/Input";
import { useCourses, usePublishCourse, useDeleteCourse } from "@/hooks/useCourses";
import { coursesApi } from "@/lib/api";
import { formatCurrency } from "@/lib/utils";
import { Loader2, Plus, Eye, Trash2, Globe } from "lucide-react";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import { useQueryClient } from "@tanstack/react-query";

const courseSchema = z.object({
  title: z.string().min(3, "Title required"),
  description: z.string().min(10, "Description required"),
  fee: z.coerce.number().positive("Fee must be positive"),
  duration_days: z.coerce.number().int().positive(),
  mode: z.enum(["virtual", "in-person", "hybrid"]),
  level: z.enum(["beginner", "intermediate", "advanced"]),
});

type CourseForm = z.infer<typeof courseSchema>;

export default function AdminCoursesPage() {
  const { data, isLoading } = useCourses();
  const courses = data?.data ?? [];
  const publish = usePublishCourse();
  const deleteCourse = useDeleteCourse();
  const qc = useQueryClient();
  const [createOpen, setCreateOpen] = useState(false);

  const { register, handleSubmit, reset, formState: { errors, isSubmitting } } = useForm<CourseForm>({
    resolver: zodResolver(courseSchema),
    defaultValues: { mode: "virtual", level: "intermediate" },
  });

  const onSubmit = async (data: CourseForm) => {
    await coursesApi.create(data);
    qc.invalidateQueries({ queryKey: ["courses"] });
    reset();
    setCreateOpen(false);
  };

  return (
    <DashboardLayout role="admin" title="Courses">
      <div className="flex items-center justify-between mb-6">
        <p className="font-heading text-sm text-muted">{courses.length} courses total</p>
        <Button onClick={() => setCreateOpen(true)} variant="accent" className="gap-2">
          <Plus size={15} /> New Course
        </Button>
      </div>

      {isLoading && (
        <div className="flex justify-center py-20">
          <Loader2 size={28} className="text-primary animate-spin" />
        </div>
      )}

      {!isLoading && (
        <div className="bg-white rounded-lg border border-fog overflow-hidden">
          <div className="overflow-x-auto">
            <table className="w-full font-heading text-sm">
              <thead className="bg-surface">
                <tr>
                  {["Title", "Category", "Fee", "Mode", "Status", "Actions"].map((h) => (
                    <th key={h} className="px-4 py-3 text-left text-xs font-semibold text-muted uppercase tracking-wider border-b border-fog">
                      {h}
                    </th>
                  ))}
                </tr>
              </thead>
              <tbody className="divide-y divide-fog">
                {courses.map((c) => (
                  <tr key={c.id} className="hover:bg-surface/50 transition-colors">
                    <td className="px-4 py-3">
                      <div className="font-medium text-ink max-w-xs truncate">{c.title}</div>
                      <div className="text-xs text-muted mt-0.5">{c.duration_days} days · {c.level}</div>
                    </td>
                    <td className="px-4 py-3 text-muted">{c.category?.name}</td>
                    <td className="px-4 py-3 font-mono font-bold text-ink">{formatCurrency(c.fee, c.currency)}</td>
                    <td className="px-4 py-3 capitalize text-muted">{c.mode}</td>
                    <td className="px-4 py-3">
                      <Badge
                        label={c.is_published ? "Published" : "Draft"}
                        variant={c.is_published ? "completed" : "upcoming"}
                      />
                    </td>
                    <td className="px-4 py-3">
                      <div className="flex items-center gap-2">
                        <a href={`/courses/${c.slug}`} target="_blank" rel="noreferrer">
                          <Button size="sm" variant="ghost" className="gap-1"><Eye size={13} /></Button>
                        </a>
                        <Button
                          size="sm"
                          variant={c.is_published ? "outline" : "success"}
                          className="gap-1 text-xs"
                          loading={publish.isPending}
                          onClick={() => publish.mutate(c.id)}
                        >
                          <Globe size={12} /> {c.is_published ? "Unpublish" : "Publish"}
                        </Button>
                        <Button
                          size="sm"
                          variant="danger"
                          className="gap-1"
                          onClick={() => {
                            if (confirm("Delete this course?")) deleteCourse.mutate(c.id);
                          }}
                        >
                          <Trash2 size={13} />
                        </Button>
                      </div>
                    </td>
                  </tr>
                ))}
              </tbody>
            </table>
          </div>
        </div>
      )}

      {/* Create Course Modal */}
      <Modal open={createOpen} onClose={() => setCreateOpen(false)} title="Create New Course" size="lg">
        <form onSubmit={handleSubmit(onSubmit)} className="space-y-4">
          <Input label="Course Title" error={errors.title?.message} {...register("title")} />
          <div>
            <label className="font-heading text-sm font-semibold text-ink block mb-1.5">Description</label>
            <textarea
              className="w-full rounded-md border border-fog px-4 py-2.5 font-heading text-sm text-ink focus:outline-none focus:ring-2 focus:ring-accent/40 focus:border-accent resize-none"
              rows={4}
              {...register("description")}
            />
            {errors.description && <p className="font-heading text-xs text-danger mt-1">{errors.description.message}</p>}
          </div>
          <div className="grid grid-cols-2 gap-4">
            <Input label="Fee (NGN)" type="number" error={errors.fee?.message} {...register("fee")} />
            <Input label="Duration (days)" type="number" error={errors.duration_days?.message} {...register("duration_days")} />
          </div>
          <div className="grid grid-cols-2 gap-4">
            <div>
              <label className="font-heading text-sm font-semibold text-ink block mb-1.5">Mode</label>
              <select className="w-full rounded-md border border-fog px-3 py-2.5 font-heading text-sm" {...register("mode")}>
                <option value="virtual">Virtual</option>
                <option value="in-person">In-Person</option>
                <option value="hybrid">Hybrid</option>
              </select>
            </div>
            <div>
              <label className="font-heading text-sm font-semibold text-ink block mb-1.5">Level</label>
              <select className="w-full rounded-md border border-fog px-3 py-2.5 font-heading text-sm" {...register("level")}>
                <option value="beginner">Beginner</option>
                <option value="intermediate">Intermediate</option>
                <option value="advanced">Advanced</option>
              </select>
            </div>
          </div>
          <div className="flex gap-3 pt-2">
            <Button variant="outline" type="button" onClick={() => setCreateOpen(false)} className="flex-1">Cancel</Button>
            <Button type="submit" variant="accent" loading={isSubmitting} className="flex-1">Create Course</Button>
          </div>
        </form>
      </Modal>
    </DashboardLayout>
  );
}
