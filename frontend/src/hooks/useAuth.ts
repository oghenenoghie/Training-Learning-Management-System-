"use client";

import { useSession, signOut } from "next-auth/react";
import { useStore } from "@/store/useStore";
import { useEffect } from "react";
import type { Role } from "@/types";

export function useAuth() {
  const { data: session, status } = useSession();
  const { setToken } = useStore();

  useEffect(() => {
    if (session?.user?.token) {
      setToken(session.user.token);
    }
  }, [session, setToken]);

  const hasRole = (role: Role | Role[]) => {
    const roles = session?.user?.roles ?? [];
    if (Array.isArray(role)) return role.some((r) => roles.includes(r));
    return roles.includes(role);
  };

  const isAdmin = hasRole(["super_admin", "admin"]);
  const isTrainer = hasRole("trainer");
  const isCorporateHR = hasRole("corporate_hr");
  const isDelegate = hasRole("delegate");

  const logout = async () => {
    await signOut({ callbackUrl: "/login" });
  };

  return {
    user: session?.user,
    token: session?.user?.token,
    isLoading: status === "loading",
    isAuthenticated: status === "authenticated",
    hasRole,
    isAdmin,
    isTrainer,
    isCorporateHR,
    isDelegate,
    logout,
  };
}
