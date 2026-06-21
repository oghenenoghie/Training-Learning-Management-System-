export type Role = "super_admin" | "admin" | "trainer" | "delegate" | "corporate_hr";

export interface User {
  id: number;
  name: string;
  email: string;
  phone?: string;
  organisation?: string;
  job_title?: string;
  roles: Role[];
  avatar?: string;
  created_at: string;
}

export interface Category {
  id: number;
  name: string;
  slug: string;
  description?: string;
  courses_count?: number;
}

export interface CourseSchedule {
  id: number;
  course_id: number;
  start_date: string;
  end_date: string;
  mode: "virtual" | "in-person";
  location?: string;
  seats_available: number;
  seats_total: number;
}

export interface Course {
  id: number;
  title: string;
  slug: string;
  description: string;
  short_description?: string;
  category: Category;
  duration_days: number;
  fee: number;
  currency: string;
  mode: "virtual" | "in-person" | "hybrid";
  level: "beginner" | "intermediate" | "advanced";
  is_published: boolean;
  is_featured: boolean;
  thumbnail?: string;
  objectives?: string[];
  schedules?: CourseSchedule[];
  enrolments_count?: number;
  created_at: string;
}

export interface CourseMaterial {
  id: number;
  course_id: number;
  title: string;
  type: "video" | "pdf" | "document" | "link";
  url: string;
  order: number;
  duration_minutes?: number;
}

export interface Enrolment {
  id: number;
  user: User;
  course: Course;
  schedule?: CourseSchedule;
  status: "pending" | "confirmed" | "cancelled" | "completed" | "waitlisted";
  progress: number;
  payment_status: "pending" | "paid" | "refunded";
  enrolled_at: string;
  completed_at?: string;
}

export interface Assessment {
  id: number;
  course_id: number;
  title: string;
  description?: string;
  pass_score: number;
  time_limit_minutes?: number;
  questions: AssessmentQuestion[];
}

export interface AssessmentQuestion {
  id: number;
  question: string;
  type: "mcq" | "short_answer" | "file_upload";
  options?: string[];
  correct_answer?: string;
  marks: number;
  order: number;
}

export interface AssessmentSubmission {
  id: number;
  assessment_id: number;
  user_id: number;
  score: number;
  passed: boolean;
  answers: Record<number, string | string[]>;
  submitted_at: string;
}

export interface Certificate {
  id: number;
  user: User;
  course: Course;
  certificate_number: string;
  issued_at: string;
  download_url: string;
  qr_code_url?: string;
}

export interface Payment {
  id: number;
  user: User;
  course: Course;
  enrolment_id: number;
  amount: number;
  currency: string;
  gateway: "paystack" | "flutterwave";
  reference: string;
  status: "pending" | "paid" | "failed" | "refunded";
  paid_at?: string;
  created_at: string;
}

export interface Report {
  total_enrolments: number;
  total_revenue: number;
  total_completions: number;
  total_certificates: number;
  monthly: MonthlyData[];
  top_courses: TopCourse[];
}

export interface MonthlyData {
  month: string;
  enrolments: number;
  revenue: number;
  completions: number;
}

export interface TopCourse {
  id: number;
  title: string;
  enrolments: number;
  revenue: number;
  completion_rate: number;
}

export interface ApiResponse<T> {
  success: boolean;
  message?: string;
  data: T;
  meta?: {
    current_page: number;
    last_page: number;
    per_page: number;
    total: number;
  };
}

export interface LoginCredentials {
  email: string;
  password: string;
}

export interface RegisterData {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
  phone?: string;
  organisation?: string;
  job_title?: string;
}

export interface AuthSession {
  user: User;
  token: string;
}
