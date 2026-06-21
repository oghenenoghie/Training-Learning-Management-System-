import type { Metadata } from "next";
import { Libre_Baskerville, DM_Sans, Source_Serif_4, JetBrains_Mono } from "next/font/google";
import "./globals.css";
import { Providers } from "./providers";

const libreBaskerville = Libre_Baskerville({
  subsets: ["latin"],
  weight: ["400", "700"],
  variable: "--font-libre-baskerville",
  display: "swap",
});

const dmSans = DM_Sans({
  subsets: ["latin"],
  variable: "--font-dm-sans",
  display: "swap",
});

const sourceSerif = Source_Serif_4({
  subsets: ["latin"],
  variable: "--font-source-serif",
  display: "swap",
});

const jetbrainsMono = JetBrains_Mono({
  subsets: ["latin"],
  variable: "--font-jetbrains-mono",
  display: "swap",
});

export const metadata: Metadata = {
  title: {
    default: "IFS Nigeria — Professional Training & LMS",
    template: "%s | IFS Nigeria",
  },
  description:
    "Institute for Fiscal Studies — Professional training and capacity development for finance, legal, and governance professionals across Nigeria.",
  openGraph: {
    type: "website",
    siteName: "IFS Nigeria",
    title: "IFS Nigeria — Professional Training & LMS",
    description: "Professional training and capacity development for finance, legal, and governance professionals.",
  },
};

export default function RootLayout({ children }: { children: React.ReactNode }) {
  return (
    <html
      lang="en"
      className={`${libreBaskerville.variable} ${dmSans.variable} ${sourceSerif.variable} ${jetbrainsMono.variable}`}
    >
      <body>
        <Providers>{children}</Providers>
      </body>
    </html>
  );
}
