"use client";

import { DashboardLayout } from "@/components/layout/DashboardLayout";
import { Input } from "@/components/ui/Input";
import { Button } from "@/components/ui/Button";
import { Card } from "@/components/ui/Card";
import { useAuth } from "@/hooks/useAuth";
import { usersApi } from "@/lib/api";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import { useState } from "react";
import { getInitials } from "@/lib/utils";

const schema = z.object({
  name: z.string().min(2),
  phone: z.string().optional(),
  organisation: z.string().optional(),
  job_title: z.string().optional(),
});

type FormData = z.infer<typeof schema>;

export default function ProfilePage() {
  const { user } = useAuth();
  const [saved, setSaved] = useState(false);

  const {
    register,
    handleSubmit,
    formState: { errors, isSubmitting },
  } = useForm<FormData>({
    resolver: zodResolver(schema),
    defaultValues: {
      name: user?.name ?? "",
      phone: user?.phone ?? "",
      organisation: user?.organisation ?? "",
      job_title: user?.job_title ?? "",
    },
  });

  const onSubmit = async (data: FormData) => {
    await usersApi.updateProfile(data);
    setSaved(true);
    setTimeout(() => setSaved(false), 3000);
  };

  return (
    <DashboardLayout role="delegate" title="Profile">
      <div className="max-w-2xl space-y-6">
        {/* Avatar section */}
        <Card>
          <div className="flex items-center gap-5">
            <div className="w-16 h-16 rounded-full bg-primary flex items-center justify-center text-white font-display text-xl font-bold">
              {user ? getInitials(user.name) : "?"}
            </div>
            <div>
              <p className="font-display text-lg font-bold text-ink">{user?.name}</p>
              <p className="font-heading text-sm text-muted">{user?.email}</p>
              <div className="flex gap-2 mt-1">
                {user?.roles?.map((r) => (
                  <span
                    key={r}
                    className="font-heading text-xs bg-primary/10 text-primary px-2 py-0.5 rounded-full font-semibold capitalize"
                  >
                    {r.replace(/_/g, " ")}
                  </span>
                ))}
              </div>
            </div>
          </div>
        </Card>

        {/* Edit form */}
        <Card>
          <h2 className="font-display text-lg font-bold text-ink mb-6">Personal Information</h2>
          <form onSubmit={handleSubmit(onSubmit)} className="space-y-4">
            <Input label="Full Name" error={errors.name?.message} {...register("name")} />
            <Input label="Email Address" value={user?.email ?? ""} disabled hint="Email cannot be changed" />
            <div className="grid sm:grid-cols-2 gap-4">
              <Input label="Phone Number" type="tel" error={errors.phone?.message} {...register("phone")} />
              <Input label="Organisation" error={errors.organisation?.message} {...register("organisation")} />
            </div>
            <Input label="Job Title" error={errors.job_title?.message} {...register("job_title")} />

            <div className="flex items-center gap-3 pt-2">
              <Button type="submit" loading={isSubmitting}>Save Changes</Button>
              {saved && <span className="font-heading text-sm text-success">Changes saved!</span>}
            </div>
          </form>
        </Card>
      </div>
    </DashboardLayout>
  );
}
