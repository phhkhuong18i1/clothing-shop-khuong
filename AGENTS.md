# AGENTS.md — Clothing Store Project

## Project goal

Build and maintain a professional clothing-store website using the existing Laravel application, Blade templates, and Tailwind CSS. The application has two distinct areas: the public storefront (`web`) and the authenticated administration area (`admin`).

## Required instructions

1. Before making changes, inspect the repository structure, Laravel/PHP versions, existing routes, migrations, models, authentication, Tailwind setup, and README.
2. Read and follow `.codex/skills/ui-ux-pro-max/SKILL.md` for visual design when that file exists.
3. Read and follow `SKILL.md` at the project root for the fashion-store implementation workflow.
4. Do not claim to have read a skill or run a test unless you actually did.
5. Preserve existing working behavior and project conventions. Do not replace the current stack with React, Vue, Inertia, or another frontend framework.
6. Keep public storefront and admin code separated using appropriate route groups, controllers, layouts, and Blade view directories.
7. Protect every admin route and upload endpoint with server-side authentication and authorization. Never rely only on hiding UI links.
8. Validate all incoming data on the server. Secure image uploads by checking file type and size, generating safe unique filenames, and using Laravel Storage.
9. Use CSRF protection, Blade's escaped output by default, mass-assignment protection, and database transactions where appropriate.
10. Avoid hardcoded credentials, secrets, production passwords, or destructive commands against an unverified environment.
11. Use named routes, Eloquent relationships, eager loading, and Form Request validation where appropriate.
12. Keep business logic out of Blade templates and avoid unnecessary dependencies.

## UI/UX quality bar

- Aim for a modern, premium, editorial fashion aesthetic.
- Focus on product photography, whitespace, clear typography, and consistent spacing.
- Use a restrained neutral palette with subtle earthy accents.
- Avoid generic layouts, excessive gradients/shadows, over-rounded cards, and gratuitous animations.
- Make pages responsive for mobile, tablet, and desktop.
- Ensure semantic HTML, accessible labels, keyboard focus, readable contrast, and useful empty/error states.
- Do not leave broken image links or pretend nonfunctional controls work.

## Expected workflow

1. Inspect existing implementation and skill files.
2. Briefly state the planned approach.
3. Implement the requested changes in the repository.
4. Run relevant tests, lint/build checks, and migrations only when safe and feasible.
5. Fix issues found by those checks.
6. Report files changed, commands run, results, and remaining limitations honestly.

Do not stop at a plan when implementation was requested. If something is blocked by missing credentials or environment configuration, explain the blocker and complete the independent work possible.
