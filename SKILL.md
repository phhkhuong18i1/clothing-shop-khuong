---
name: fashion-store-ui
description: Design and implement a premium clothing-store website using Laravel Blade and Tailwind CSS, with separate public storefront and authenticated admin dashboard. Use for fashion ecommerce UI, product catalog pages, category/product CRUD, and secure product image uploads.
---

# Fashion Store UI — Laravel Blade + Tailwind CSS

## Purpose

Build a polished clothing-store website with two clearly separated areas:
- **Web storefront:** public product discovery and product details.
- **Admin dashboard:** authenticated product/category management, including secure multiple-image uploads.

Use the existing Laravel project and conventions. Do not migrate to React, Vue, Inertia, or a separate frontend app.

## Before coding

1. Inspect the repository: Laravel version, routes, controllers, models, migrations, authentication, Tailwind version/configuration, frontend build tooling, and existing assets.
2. Read this repository's `AGENTS.md` and README if present.
3. Read `.codex/skills/ui-ux-pro-max/SKILL.md` if it exists. Follow its design guidance. If unavailable, say so; never pretend to have read it.
4. Briefly summarize the architecture and design direction, then implement the work rather than stopping at a plan.
5. Preserve working functionality and avoid unnecessary framework or dependency changes.

## Design direction

Create a distinctive, editorial fashion aesthetic—not a generic ecommerce template.

- Use large, high-quality product/editorial photography and generous whitespace.
- Establish clear typographic hierarchy and readable Vietnamese text where applicable.
- Prefer warm off-white, black, charcoal, and restrained earthy accents.
- Keep spacing, buttons, form controls, product-image ratios, and states consistent.
- Use subtle transitions only when they improve feedback or navigation.
- Avoid arbitrary gradients, excessive shadows, oversized rounded cards, gratuitous animations, and clutter.
- Ensure adequate contrast, keyboard focus, semantic HTML, accessible labels, and reduced-motion friendliness.
- Build mobile-first layouts and verify mobile, tablet, and desktop behavior.
- Prefer existing project assets. If none exist, use replaceable assets and graceful fallbacks; do not leave broken image URLs.

Define a small design system before building multiple pages: color tokens, typography, spacing, button variants, form styles, and product-card rules. Follow UI/UX Pro Max recommendations when available.

## Technology constraints

- Backend: the Laravel version already used by the repository.
- Views: Laravel Blade.
- Styling: the Tailwind CSS version and build setup already present.
- Database: use the configured relational database; never overwrite credentials.
- Images: Laravel Storage, preferably the configured `public` disk.
- JavaScript: lightweight JavaScript for galleries, mobile navigation, and previews where needed.
- Do not add a frontend framework or new dependencies unless necessary and compatibility has been checked.

## Application structure

Keep storefront and admin code clearly separated with route groups, controllers, layouts, and view directories. Follow existing conventions where they differ.

### Public storefront

Suggested routes:
- `GET /` — homepage
- `GET /products` — product listing
- `GET /products/{product:slug}` — product detail
- `GET /categories/{category:slug}` — category listing

Use named routes, route model binding, and show only published products publicly. Check for route-name conflicts before adding routes.

### Admin dashboard

Use an `/admin` prefix and an `admin.` route-name prefix. Protect every admin route with authentication and server-side authorization middleware.

Include:
- Login/logout using the project's existing authentication approach, or a minimal compatible admin flow if none exists.
- Dashboard overview.
- Product list/create/view/edit/delete.
- Category list/create/edit/delete.
- Search and pagination in admin tables.
- Validation feedback, empty states, delete confirmation, and responsive navigation.

Never rely on hiding links in the UI as authorization. Public visitors must not access admin pages or upload endpoints.

## Data model

Inspect the existing schema before creating migrations. Reuse or extend compatible tables instead of creating duplicates.

Suggested models:
- `Product`
- `Category`
- `ProductImage`

Suggested product fields:
- `name`, unique `slug`, `sku`
- `description`
- `price`, nullable `sale_price`
- `stock_quantity`
- `sizes` and `colors` using JSON or normalized tables, consistent with project conventions
- `category_id`
- `is_published`
- timestamps

Suggested product-image fields:
- `product_id`
- `image_path`
- `alt_text`
- `sort_order`
- `is_primary`

Add appropriate foreign keys, indexes, casts, relationships, and validation. Use suitable numeric types for prices and stock. Avoid duplicate migrations or model definitions.

## Storefront requirements

### Homepage

Include:
- Responsive header with brand, navigation, categories, search, and mobile menu.
- Large editorial hero with fashion photography, concise headline, and CTA.
- Featured collections/categories.
- New arrivals.
- Best sellers only if there is a real field or defensible query; otherwise use a clearly defined curated collection.
- Editorial/promotional section.
- Brand/value proposition.
- Optional newsletter only if behavior is implemented or clearly presented as a nonfunctional placeholder.
- Footer with useful navigation and contact/social links where data exists.

Use consistent image ratios, avoid stretching images, and provide meaningful alt text and graceful fallbacks.

### Product listing

Implement server-side:
- Search by product name.
- Category filter.
- Price range filter with validation.
- Size filter where size data exists.
- Sorting by newest, price ascending, and price descending.
- Pagination that preserves active query filters.
- Clear-filter action and helpful empty state.

Only show published products publicly. Validate and bound user-supplied filter values.

### Product detail

Include:
- Main image and gallery thumbnails with working image switching.
- Product name, SKU if available, price and sale price.
- Stock status.
- Size/color selection only when configured for that product.
- Description and related products.
- Responsive layout and accessible controls.

Do not show fake cart, checkout, wishlist, or purchase behavior. If those features are not implemented, present the site as a product catalog and omit misleading action buttons.

## Admin product and image management

Implement a working multi-image workflow:
- Upload multiple images and preview selected files before submission.
- Choose a primary image.
- Store alt text and sort order; add drag-and-drop ordering only if practical.
- Replace and remove individual images.
- Validate file type/MIME and size on the server; allow only supported image formats such as JPEG, PNG, and WebP unless the project has a reason to support others.
- Generate safe unique filenames and store through Laravel Storage.
- Do not trust client-provided filenames or MIME declarations alone.
- Escape output and use CSRF protection.
- Clean up obsolete files when replaced/deleted, but do not delete a file still referenced by another record.
- Handle storage failures without leaving inconsistent database records where practical.
- Never expose arbitrary filesystem paths or allow arbitrary file uploads.

Use the public disk when appropriate and document `php artisan storage:link` if required. Do not run destructive storage/database commands without checking the target environment.

## Quality and security

- Keep business logic out of Blade templates.
- Use Form Request classes when they improve clarity.
- Use Eloquent relationships and eager loading to avoid N+1 queries.
- Validate all inputs server-side, including IDs, filters, prices, sizes, and uploaded files.
- Use CSRF protection, safe Blade escaping, authorization policies/middleware, and mass-assignment protection.
- Use database transactions where multiple changes must remain consistent.
- Never hardcode credentials, production admin passwords, API keys, or secrets.
- Avoid exposing stack traces or sensitive configuration in production.
- Format/lint code using tooling already available in the project.

## Seed data

Add development seeders/factories for a small set of realistic categories and products where useful. Do not include copyrighted brand assets as if they belong to the store. Make seed data safe to run repeatedly and do not overwrite production data.

## Implementation workflow

1. Inspect repository and existing UI/UX Pro Max instructions.
2. Define design system and architecture.
3. Implement or adapt migrations, models, relationships, authentication, and authorization.
4. Implement admin product/category CRUD and image uploads.
5. Implement storefront pages, filtering, sorting, and pagination.
6. Implement responsive styling and interactions.
7. Add development seeders where useful.
8. Run migrations and tests only when the configured environment permits.
9. Run available tests, frontend build, and quality checks; fix errors.
10. Verify important pages at mobile and desktop sizes if browser tooling is available.

Do not stop after a plan or mockup. Implement the application in the existing repository. If configuration or credentials block a step, identify the blocker and finish independent work.

## Completion report

Report:
- Features implemented.
- Important files created/modified.
- Migration and seed commands.
- Dependency and run commands.
- How to create/configure the first admin account securely.
- Image-storage setup instructions.
- Tests/build checks performed and failures.
- Remaining limitations.

Prioritize a cohesive storefront and a genuinely functional, secure admin dashboard.
