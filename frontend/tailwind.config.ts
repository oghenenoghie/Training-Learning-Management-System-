import type { Config } from "tailwindcss";

const config: Config = {
  content: ["./src/**/*.{js,ts,jsx,tsx,mdx}"],
  theme: {
    extend: {
      colors: {
        primary:  "#1A4D5E",
        accent:   "#E07B2A",
        surface:  "#F5F7F9",
        elevated: "#FFFFFF",
        ink:      "#0F1F2B",
        muted:    "#6B7C8D",
        fog:      "#DDE3EA",
        success:  "#1A7A4A",
        warning:  "#B85C00",
        danger:   "#C0392B",
      },
      fontFamily: {
        display: ["var(--font-libre-baskerville)", "Georgia", "serif"],
        heading: ["var(--font-dm-sans)", "system-ui", "sans-serif"],
        body:    ["var(--font-source-serif)", "Georgia", "serif"],
        mono:    ["var(--font-jetbrains-mono)", "monospace"],
      },
      boxShadow: {
        card:  "0 1px 4px rgba(15,31,43,0.08), 0 4px 12px rgba(15,31,43,0.06)",
        float: "0 8px 32px rgba(15,31,43,0.14)",
        focus: "0 0 0 3px rgba(224,123,42,0.35)",
      },
      borderRadius: {
        sm: "4px",
        md: "8px",
        lg: "12px",
        xl: "20px",
      },
    },
  },
  plugins: [],
};

export default config;
