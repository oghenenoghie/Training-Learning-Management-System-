"use client";

import { useState } from "react";
import { Navbar } from "@/components/layout/Navbar";
import { Footer } from "@/components/layout/Footer";
import { CourseCard } from "@/components/courses/CourseCard";
import { CourseFilter } from "@/components/courses/CourseFilter";
import { useCourses } from "@/hooks/useCourses";
import { Loader2 } from "lucide-react";

export default function CoursesPage() {
  const [filterParams, setFilterParams] = useState<Record<string, string>>({});
  const { data, isLoading, isError } = useCourses(filterParams);
  const courses = data?.data ?? [];

  return (
    <>
      <Navbar />
      <main className="max-w-7xl mx-auto px-4 sm:px-6 py-10">
        <div className="mb-8">
          <h1 className="font-display text-3xl font-bold text-ink mb-2">All Courses</h1>
          <p className="font-heading text-sm text-muted">
            {data?.meta ? `Showing ${courses.length} of ${data.meta.total} courses` : "Browse our full catalogue"}
          </p>
        </div>

        <CourseFilter onFilter={setFilterParams} />

        <div className="mt-8">
          {isLoading && (
            <div className="flex justify-center py-20">
              <Loader2 size={28} className="text-primary animate-spin" />
            </div>
          )}

          {isError && (
            <div className="text-center py-20">
              <p className="font-heading text-sm text-danger">Failed to load courses. Please try again.</p>
            </div>
          )}

          {!isLoading && !isError && courses.length === 0 && (
            <div className="text-center py-20">
              <p className="font-heading text-base text-muted">No courses found. Try adjusting your search.</p>
            </div>
          )}

          {!isLoading && courses.length > 0 && (
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
              {courses.map((course) => (
                <CourseCard key={course.id} course={course} />
              ))}
            </div>
          )}
        </div>
      </main>
      <Footer />
    </>
  );
}
