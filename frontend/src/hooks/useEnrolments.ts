"use client";

import { useQuery, useMutation, useQueryClient } from "@tanstack/react-query";
import { enrolmentsApi, paymentsApi, certificatesApi } from "@/lib/api";

export function useEnrolments(params?: Record<string, unknown>) {
  return useQuery({
    queryKey: ["enrolments", params],
    queryFn: () => enrolmentsApi.list(params),
  });
}

export function useEnrol() {
  const qc = useQueryClient();
  return useMutation({
    mutationFn: (data: { course_id: number; schedule_id?: number }) =>
      enrolmentsApi.create(data),
    onSuccess: () => qc.invalidateQueries({ queryKey: ["enrolments"] }),
  });
}

export function useCancelEnrolment() {
  const qc = useQueryClient();
  return useMutation({
    mutationFn: (id: number) => enrolmentsApi.cancel(id),
    onSuccess: () => qc.invalidateQueries({ queryKey: ["enrolments"] }),
  });
}

export function useInitiatePayment() {
  return useMutation({
    mutationFn: (data: { enrolment_id: number; gateway?: "paystack" | "flutterwave" }) =>
      paymentsApi.initiate(data),
    onSuccess: (res) => {
      if (res.data?.payment_url) {
        window.location.href = res.data.payment_url;
      }
    },
  });
}

export function usePayments(params?: Record<string, unknown>) {
  return useQuery({
    queryKey: ["payments", params],
    queryFn: () => paymentsApi.list(params),
  });
}

export function useCertificates() {
  return useQuery({
    queryKey: ["certificates"],
    queryFn: () => certificatesApi.list(),
  });
}
