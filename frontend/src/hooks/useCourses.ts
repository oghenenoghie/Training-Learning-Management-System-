"use client";

import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import { coursesApi, categoriesApi } from "@/lib/api";

export function useCourses(params?: Record<string, unknown>) {
  return useQuery({
    queryKey: ["courses", params],
    queryFn: () => coursesApi.list(params),
    staleTime: 1000 * 60 * 5,
  });
}

export function useCourse(slug: string) {
  return useQuery({
    queryKey: ["course", slug],
    queryFn: () => coursesApi.get(slug),
    enabled: !!slug,
  });
}

export function useCategories() {
  return useQuery({
    queryKey: ["categories"],
    queryFn: () => categoriesApi.list(),
    staleTime: 1000 * 60 * 10,
  });
}

export function usePublishCourse() {
  const qc = useQueryClient();
  return useMutation({
    mutationFn: (id: number) => coursesApi.publish(id),
    onSuccess: () => qc.invalidateQueries({ queryKey: ["courses"] }),
  });
}

export function useDeleteCourse() {
  const qc = useQueryClient();
  return useMutation({
    mutationFn: (id: number) => coursesApi.delete(id),
    onSuccess: () => qc.invalidateQueries({ queryKey: ["courses"] }),
  });
}
