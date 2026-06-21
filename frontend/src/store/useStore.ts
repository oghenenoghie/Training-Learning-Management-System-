"use client";

import { create } from "zustand";
import type { User, Course, Enrolment } from "@/types";

interface AppState {
  user: User | null;
  token: string | null;
  enrolments: Enrolment[];
  cartCourse: Course | null;

  setUser: (user: User | null) => void;
  setToken: (token: string | null) => void;
  setEnrolments: (enrolments: Enrolment[]) => void;
  setCartCourse: (course: Course | null) => void;
  clearAuth: () => void;
}

export const useStore = create<AppState>((set) => ({
  user: null,
  token: null,
  enrolments: [],
  cartCourse: null,

  setUser: (user) => set({ user }),
  setToken: (token) => {
    set({ token });
    if (typeof window !== "undefined") {
      if (token) localStorage.setItem("ifs_token", token);
      else localStorage.removeItem("ifs_token");
    }
  },
  setEnrolments: (enrolments) => set({ enrolments }),
  setCartCourse: (cartCourse) => set({ cartCourse }),
  clearAuth: () => {
    set({ user: null, token: null, enrolments: [] });
    if (typeof window !== "undefined") localStorage.removeItem("ifs_token");
  },
}));
