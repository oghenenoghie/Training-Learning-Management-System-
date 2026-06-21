"use client";

import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import { useRouter } from "next/navigation";
import { useState } from "react";
import Link from "next/link";
import { signIn } from "next-auth/react";
import { authApi } from "@/lib/api";
import { Input } from "@/components/ui/Input";
import { Button } from "@/components/ui/Button";
import { Card } from "@/components/ui/Card";

const schema = z.object({
  name: z.string().min(2, "Full name is required"),
  email: z.string().email("Enter a valid email"),
  phone: z.string().optional(),
  organisation: z.string().optional(),
  job_title: z.string().optional(),
  password: z.string().min(8, "Password must be at least 8 characters"),
  password_confirmation: z.string(),
}).refine((d) => d.password === d.password_confirmation, {
  message: "Passwords do not match",
  path: ["password_confirmation"],
});

type FormData = z.infer<typeof schema>;

export default function RegisterPage() {
  const router = useRouter();
  const [serverError, setServerError] = useState<string | null>(null);

  const {
    register,
    handleSubmit,
    formState: { errors, isSubmitting },
  } = useForm<FormData>({ resolver: zodResolver(schema) });

  const onSubmit = async (data: FormData) => {
    setServerError(null);
    try {
      await authApi.register(data);
      const res = await signIn("credentials", {
        email: data.email,
        password: data.password,
        redirect: false,
      });
      if (res?.ok) router.push("/dashboard");
    } catch (err: unknown) {
      const msg = (err as { response?: { data?: { message?: string } } })?.response?.data?.message;
      setServerError(msg ?? "Registration failed. Please try again.");
    }
  };

  return (
    <Card className="w-full max-w-lg">
      <div className="mb-7">
        <h1 className="font-display text-2xl font-bold text-ink mb-1">Create your account</h1>
        <p className="font-heading text-sm text-muted">Join IFS Nigeria — free to register</p>
      </div>

      <form onSubmit={handleSubmit(onSubmit)} className="space-y-4">
        <div className="grid sm:grid-cols-2 gap-4">
          <Input
            label="Full Name"
            placeholder="Adaeze Okonkwo"
            error={errors.name?.message}
            {...register("name")}
          />
          <Input
            label="Email Address"
            type="email"
            placeholder="you@example.com"
            error={errors.email?.message}
            {...register("email")}
          />
        </div>
        <div className="grid sm:grid-cols-2 gap-4">
          <Input
            label="Phone Number"
            type="tel"
            placeholder="+234 ..."
            error={errors.phone?.message}
            {...register("phone")}
          />
          <Input
            label="Organisation"
            placeholder="FGN / GTBank / NNPC..."
            error={errors.organisation?.message}
            {...register("organisation")}
          />
        </div>
        <Input
          label="Job Title"
          placeholder="Financial Analyst"
          error={errors.job_title?.message}
          {...register("job_title")}
        />
        <div className="grid sm:grid-cols-2 gap-4">
          <Input
            label="Password"
            type="password"
            placeholder="Min. 8 characters"
            error={errors.password?.message}
            {...register("password")}
          />
          <Input
            label="Confirm Password"
            type="password"
            placeholder="Repeat password"
            error={errors.password_confirmation?.message}
            {...register("password_confirmation")}
          />
        </div>

        {serverError && (
          <div className="bg-red-50 border border-danger/30 rounded-md px-4 py-3">
            <p className="font-heading text-sm text-danger">{serverError}</p>
          </div>
        )}

        <Button type="submit" variant="accent" size="lg" loading={isSubmitting} className="w-full mt-2">
          Create Account
        </Button>
      </form>

      <p className="mt-5 text-center font-heading text-sm text-muted">
        Already have an account?{" "}
        <Link href="/login" className="text-primary font-semibold hover:underline">
          Sign in
        </Link>
      </p>
    </Card>
  );
}
