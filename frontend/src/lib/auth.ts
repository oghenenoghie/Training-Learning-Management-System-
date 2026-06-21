import NextAuth from "next-auth";
import CredentialsProvider from "next-auth/providers/credentials";
import { authApi } from "./api";

declare module "next-auth" {
  interface User {
    id: string;
    name: string;
    email: string;
    roles: string[];
    token: string;
  }
  interface Session {
    user: User & { roles: string[]; token: string };
  }
}

export const { handlers, signIn, signOut, auth } = NextAuth({
  providers: [
    CredentialsProvider({
      name: "credentials",
      credentials: {
        email: { label: "Email", type: "email" },
        password: { label: "Password", type: "password" },
      },
      async authorize(credentials) {
        try {
          const res = await authApi.login({
            email: credentials.email as string,
            password: credentials.password as string,
          });
          if (res.success && res.data) {
            const { user, token } = res.data;
            return {
              id: String(user.id),
              name: user.name,
              email: user.email,
              roles: user.roles,
              token,
            };
          }
          return null;
        } catch {
          return null;
        }
      },
    }),
  ],
  callbacks: {
    async jwt({ token, user }) {
      if (user) {
        token.roles = user.roles;
        token.apiToken = user.token;
      }
      return token;
    },
    async session({ session, token }) {
      session.user.roles = token.roles as string[];
      session.user.token = token.apiToken as string;
      return session;
    },
  },
  pages: {
    signIn: "/login",
    error: "/login",
  },
  session: { strategy: "jwt" },
});
