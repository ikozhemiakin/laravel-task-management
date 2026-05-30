# Task Management

Laravel app: **projects**, **tasks**, global **priority** ordering, drag-and-drop reorder, project filter.

**Repo:** [github.com/ikozhemiakin/laravel-task-management](https://github.com/ikozhemiakin/laravel-task-management)

## Features

- Projects & tasks CRUD (Blade)
- Tasks sorted by `priority` (1 = top), then `id`
- Drag-and-drop on **All tasks** — saves order as `1, 2, 3…` (Alpine.js + SortableJS)
- Filter by project (drag disabled while filtered)

## Priority

| Action | Behaviour |
|--------|-----------|
| Create (no priority) | `max(priority) + 1` |
| Create with priority N | Insert at N; shift others with `priority >= N` |
| Drag (All tasks) | Top row → 1, next → 2, … for all visible tasks |
| Edit | Updates name and project only; priority unchanged |

## Setup (DDEV)

From **repository root** (after `git clone`):

```bash
ddev start
ddev composer install
cp -n .env.example .env
ddev exec php artisan key:generate
ddev exec php artisan migrate
ddev npm ci && ddev npm run build
```

**URL:** https://laravel-task-management.ddev.site

**MySQL (host):** `127.0.0.1:3308`, user/password/database `db`

## Setup (local, no DDEV)

```bash
composer install && cp -n .env.example .env && php artisan key:generate
touch database/database.sqlite   # default SQLite in .env.example
php artisan migrate
npm ci && npm run build
php artisan serve
```

## Tests

```bash
php artisan test
# DDEV: ddev exec php artisan test
```

## Deploy (summary)

1. Web root → `public/`
2. `.env` with `APP_KEY`, database, `APP_DEBUG=false`
3. `composer install --no-dev`, `npm ci && npm run build`, `php artisan migrate --force`
4. Writable `storage/`, `bootstrap/cache/`

Temporary public URL: `ddev share` (local only).

## Stack

Laravel · Blade · Tailwind v4 · Vite · Alpine.js · SortableJS · PHPUnit
