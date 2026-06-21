import axios from "axios";
import type {
  ApiResponse, Course, Category, Enrolment, Certificate,
  Payment, User, Assessment, AssessmentSubmission, Report,
  LoginCredentials, RegisterData, AuthSession,
} from "@/types";

const BASE_URL = process.env.NEXT_PUBLIC_API_URL ?? "http://localhost:8000";

const api = axios.create({
  baseURL: `${BASE_URL}/api/v1`,
  headers: { "Content-Type": "application/json", Accept: "application/json" },
  withCredentials: true,
});

api.interceptors.request.use((config) => {
  if (typeof window !== "undefined") {
    const token = localStorage.getItem("ifs_token");
    if (token) config.headers.Authorization = `Bearer ${token}`;
  }
  return config;
});

api.interceptors.response.use(
  (r) => r,
  (err) => {
    if (err.response?.status === 401 && typeof window !== "undefined") {
      localStorage.removeItem("ifs_token");
      window.location.href = "/login";
    }
    return Promise.reject(err);
  }
);

// ── Auth ──────────────────────────────────────────────────────

export const authApi = {
  login: (data: LoginCredentials) =>
    api.post<ApiResponse<AuthSession>>("/auth/login", data).then((r) => r.data),

  register: (data: RegisterData) =>
    api.post<ApiResponse<AuthSession>>("/auth/register", data).then((r) => r.data),

  logout: () =>
    api.post<ApiResponse<null>>("/auth/logout").then((r) => r.data),

  me: () =>
    api.get<ApiResponse<User>>("/auth/me").then((r) => r.data),
};

// ── Courses ───────────────────────────────────────────────────

export const coursesApi = {
  list: (params?: Record<string, unknown>) =>
    api.get<ApiResponse<Course[]>>("/courses", { params }).then((r) => r.data),

  get: (slug: string) =>
    api.get<ApiResponse<Course>>(`/courses/${slug}`).then((r) => r.data),

  create: (data: Partial<Course>) =>
    api.post<ApiResponse<Course>>("/courses", data).then((r) => r.data),

  update: (id: number, data: Partial<Course>) =>
    api.put<ApiResponse<Course>>(`/courses/${id}`, data).then((r) => r.data),

  delete: (id: number) =>
    api.delete<ApiResponse<null>>(`/courses/${id}`).then((r) => r.data),

  publish: (id: number) =>
    api.post<ApiResponse<Course>>(`/courses/${id}/publish`).then((r) => r.data),

  toggleFeatured: (id: number) =>
    api.post<ApiResponse<Course>>(`/courses/${id}/featured`).then((r) => r.data),
};

// ── Categories ────────────────────────────────────────────────

export const categoriesApi = {
  list: () =>
    api.get<ApiResponse<Category[]>>("/categories").then((r) => r.data),

  get: (id: number) =>
    api.get<ApiResponse<Category>>(`/categories/${id}`).then((r) => r.data),
};

// ── Enrolments ────────────────────────────────────────────────

export const enrolmentsApi = {
  list: (params?: Record<string, unknown>) =>
    api.get<ApiResponse<Enrolment[]>>("/enrolments", { params }).then((r) => r.data),

  create: (data: { course_id: number; schedule_id?: number }) =>
    api.post<ApiResponse<Enrolment>>("/enrolments", data).then((r) => r.data),

  cancel: (id: number) =>
    api.put<ApiResponse<Enrolment>>(`/enrolments/${id}/cancel`).then((r) => r.data),

  complete: (id: number) =>
    api.put<ApiResponse<Enrolment>>(`/enrolments/${id}/complete`).then((r) => r.data),
};

// ── Assessments ───────────────────────────────────────────────

export const assessmentsApi = {
  get: (id: number) =>
    api.get<ApiResponse<Assessment>>(`/assessments/${id}`).then((r) => r.data),

  submit: (id: number, answers: Record<number, string | string[]>) =>
    api.post<ApiResponse<AssessmentSubmission>>(`/assessments/${id}/submit`, { answers }).then((r) => r.data),

  results: (id: number) =>
    api.get<ApiResponse<AssessmentSubmission>>(`/assessments/${id}/results`).then((r) => r.data),
};

// ── Certificates ──────────────────────────────────────────────

export const certificatesApi = {
  list: () =>
    api.get<ApiResponse<Certificate[]>>("/certificates").then((r) => r.data),

  verify: (code: string) =>
    api.get<ApiResponse<Certificate>>(`/certificates/verify/${code}`).then((r) => r.data),
};

// ── Payments ──────────────────────────────────────────────────

export const paymentsApi = {
  list: (params?: Record<string, unknown>) =>
    api.get<ApiResponse<Payment[]>>("/payments", { params }).then((r) => r.data),

  initiate: (data: { enrolment_id: number; gateway?: "paystack" | "flutterwave" }) =>
    api.post<ApiResponse<{ payment_url: string; reference: string }>>("/payments/initiate", data).then((r) => r.data),

  verify: (reference: string) =>
    api.get<ApiResponse<Payment>>(`/payments/verify/${reference}`).then((r) => r.data),
};

// ── Users ─────────────────────────────────────────────────────

export const usersApi = {
  list: (params?: Record<string, unknown>) =>
    api.get<ApiResponse<User[]>>("/users", { params }).then((r) => r.data),

  get: (id: number) =>
    api.get<ApiResponse<User>>(`/users/${id}`).then((r) => r.data),

  update: (id: number, data: Partial<User>) =>
    api.put<ApiResponse<User>>(`/users/${id}`, data).then((r) => r.data),

  delete: (id: number) =>
    api.delete<ApiResponse<null>>(`/users/${id}`).then((r) => r.data),

  updateProfile: (data: Partial<User>) =>
    api.put<ApiResponse<User>>("/user/profile", data).then((r) => r.data),
};

// ── Reports ───────────────────────────────────────────────────

export const reportsApi = {
  enrolments: (params?: Record<string, unknown>) =>
    api.get<ApiResponse<Report>>("/reports/enrolments", { params }).then((r) => r.data),

  revenue: (params?: Record<string, unknown>) =>
    api.get<ApiResponse<Report>>("/reports/revenue", { params }).then((r) => r.data),

  completions: (params?: Record<string, unknown>) =>
    api.get<ApiResponse<Report>>("/reports/completions", { params }).then((r) => r.data),

  delegates: (params?: Record<string, unknown>) =>
    api.get<ApiResponse<Report>>("/reports/delegates", { params }).then((r) => r.data),
};

// ── Schedules ─────────────────────────────────────────────────

export const schedulesApi = {
  list: (params?: Record<string, unknown>) =>
    api.get("/schedules", { params }).then((r) => r.data),
};

export default api;
