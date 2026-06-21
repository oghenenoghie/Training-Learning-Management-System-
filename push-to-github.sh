#!/bin/bash
# ============================================================
# IFS LMS — Auto Push Design System to GitHub
# Project: Training-Learning-Management-System-
# Run this ONCE from your local machine after downloading
# the IFS-LMS-Design-System.jsx file
# ============================================================

set -e  # Exit on any error

# ── CONFIG (edit these two lines) ──────────────────────────
GITHUB_USERNAME="YOUR_GITHUB_USERNAME"
REPO_NAME="Training-Learning-Management-System-"
# ────────────────────────────────────────────────────────────

REPO_URL="https://github.com/$GITHUB_USERNAME/$REPO_NAME.git"
FILE="IFS-LMS-Design-System.jsx"
TARGET_PATH="src/design-system/$FILE"
BRANCH="main"

echo ""
echo "╔══════════════════════════════════════════════════════╗"
echo "║   IFS Nigeria LMS — GitHub Push Script              ║"
echo "╚══════════════════════════════════════════════════════╝"
echo ""

# Check the JSX file exists in current directory
if [ ! -f "$FILE" ]; then
  echo "❌  ERROR: $FILE not found in current directory."
  echo "    Place this script in the same folder as $FILE and re-run."
  exit 1
fi

# Check git is installed
if ! command -v git &> /dev/null; then
  echo "❌  Git is not installed. Install from https://git-scm.com"
  exit 1
fi

# ── Clone or pull repo ──────────────────────────────────────
if [ -d "$REPO_NAME" ]; then
  echo "📁  Repo folder found. Pulling latest..."
  cd "$REPO_NAME"
  git pull origin "$BRANCH" --rebase
else
  echo "📥  Cloning repo from GitHub..."
  git clone "$REPO_URL"
  cd "$REPO_NAME"
fi

# ── Create folder structure ─────────────────────────────────
echo "📂  Creating src/design-system/ directory..."
mkdir -p src/design-system

# ── Copy the design system file ────────────────────────────
echo "📄  Copying $FILE → $TARGET_PATH ..."
cp "../$FILE" "$TARGET_PATH"

# ── Stage, commit, push ─────────────────────────────────────
echo "🔧  Staging files..."
git add "$TARGET_PATH"

echo "💬  Committing..."
git commit -m "feat: add IFS Nigeria LMS enterprise design system

- Full color token system (IFS Deep Teal + Amber palette)
- Typography: Libre Baskerville / DM Sans / Source Serif 4 / JetBrains Mono
- 22 platform tool definitions across 5 domains
- Component showcase: Course Card, Buttons, Status Badges, Admin Table
- Technical architecture: Next.js 15 + Laravel 11 + MySQL + cPanel
- App Router route map for all user roles
- Spacing & border radius systems
- Responsive, accessible design system"

echo "🚀  Pushing to GitHub ($BRANCH)..."
git push origin "$BRANCH"

echo ""
echo "✅  Done! File live at:"
echo "    https://github.com/$GITHUB_USERNAME/$REPO_NAME/blob/$BRANCH/$TARGET_PATH"
echo ""
