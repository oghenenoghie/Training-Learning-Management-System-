"use client";

import { signIn } from "next-auth/react";
import { useForm } from "react-hook-form";
import { zodResolver } from "@hookform/resolvers/zod";
import { z } from "zod";
import { useRouter, useSearchParams } from "next/navigation";
import { useState } from "react";
import Link from "next/link";
import { Input } from "@/components/ui/Input";
import { Button } from "@/components/ui/Button";
import { Card } from "@/components/ui/Card";

const schema = z.object({
  email: z.string().email("Enter a valid email"),
  password: z.string().min(6, "Password must be at least 6 characters"),
});

type FormData = z.infer<typeof schema>;

export default function LoginPage() {
  const router = useRouter();
  const params = useSearchParams();
  const redirect = params.get("redirect") ?? "/dashboard";
  const [serverError, setServerError] = useState<string | null>(null);

  const {
    register,
    handleSubmit,
    formState: { errors, isSubmitting },
  } = useForm<FormData>({ resolver: zodResolver(schema) });

  const onSubmit = async (data: FormData) => {
    setServerError(null);
    const res = await signIn("credentials", {
      email: data.email,
      password: data.password,
      redirect: false,
    });
    if (res?.ok) {
      router.push(redirect);
      router.refresh();
    } else {
      setServerError("Invalid email or password. Please try again.");
    }
  };

  return (
    <Card className="w-full max-w-md">
      <div className="mb-8">
        <h1 className="font-display text-2xl font-bold text-ink mb-1">Welcome back</h1>
        <p className="font-heading text-sm text-muted">Sign in to your IFS Nigeria account</p>
      </div>

      <form onSubmit={handleSubmit(onSubmit)} className="space-y-5">
        <Input
          label="Email address"
          type="email"
          placeholder="you@example.com"
          error={errors.email?.message}
          {...register("email")}
        />
        <Input
          label="Password"
          type="password"
          placeholder="••••••••"
          error={errors.password?.message}
          {...register("password")}
        />

        {serverError && (
          <div className="bg-red-50 border border-danger/30 rounded-md px-4 py-3">
            <p className="font-heading text-sm text-danger">{serverError}</p>
          </div>
        )}

        <Button type="submit" size="lg" loading={isSubmitting} className="w-full">
          Sign In
        </Button>
      </form>

      <div className="mt-6 text-center space-y-2">
        <Link href="/forgot-password" className="font-heading text-sm text-primary hover:underline block">
          Forgot your password?
        </Link>
        <p className="font-heading text-sm text-muted">
          Don&apos;t have an account?{" "}
          <Link href="/register" className="text-primary font-semibold hover:underline">
            Create one free
          </Link>
        </p>
      </div>
    </Card>
  );
}
