# Cambodia Destinations (Laravel 12)

A Laravel 12 tourism CMS + public site for exploring Cambodia’s destinations, galleries, travel tips, and more. Includes an admin panel, newsletter, contact inquiries, backups, and an AI assistant powered by Gemini.

## Repository

- Repo name (suggested): `cambodia-destinations`
- Clone:
```bash
git clone https://github.com/seavpeavpech24-bot/cambodia-destinations.git
cd cambodia-destinations
```

## Requirements
- PHP 8.2+
- Composer 2+
- Node.js 18+ and npm
- SQLite (for local dev) or any Laravel-supported DB
- Open Internet access (for Gemini + OpenWeather)

## Installation
1) Install PHP dependencies:
```bash
composer install
```

2) Install JS dependencies:
```bash
npm install
```

## Environment Setup
1) Create env file and app key:
```bash
cp .env.example .env
php artisan key:generate
```

2) Configure database (SQLite example for local):
```bash
# Ensure the SQLite file exists
mkdir -p database
copy NUL database\database.sqlite  # Windows PowerShell alternative: New-Item database/database.sqlite -ItemType File

# In .env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```
For MySQL/Postgres, set the usual `DB_` vars in `.env`.

3) Configure third-party services in `.env`:
```env
# OpenWeather (weather widget)
OPENWEATHER_API_KEY=your_openweather_api_key

# Gemini (AI assistant)
GEMINI_API_KEY=your_gemini_api_key

# (Optional) OpenAI / Resend / Mail if you plan to use them
OPENAI_API_KEY=
RESEND_KEY=
MAIL_MAILER=smtp
MAIL_HOST=
MAIL_PORT=
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@example.com
MAIL_FROM_NAME="Cambodia Destinations"
```

## Database
1) Run migrations:
```bash
php artisan migrate
```

2) Seed data (includes admin user):
```bash
php artisan db:seed --class=AdminUserSeeder
```
Default admin (from `database/seeders/AdminUserSeeder.php`):
- Email: `peavppppkh13@gmail.com`
- Password: `SEAVPEAV989164061090@@PP$*1000`

Change this in production.

## Build & Run (Local)
- One-shot (PHP server + queue + logs + Vite) via Composer script:
```bash
composer run dev
```
This runs:
- `php artisan serve`
- `php artisan queue:listen --tries=1`
- `php artisan pail --timeout=0`
- `npm run dev`

Alternatively run separately:
```bash
php artisan serve
php artisan queue:listen
npm run dev
```

Open: `http://127.0.0.1:8000`

## Asset Building
- Dev (HMR):
```bash
npm run dev
```
- Production build:
```bash
npm run build
```

## Admin Panel
- URL: `/admin`
- Requires authentication. Use the seeded admin credentials. After login, you can manage:
  - Destinations, Categories, Galleries, YouTube Videos
  - Travel Tips, Activities
  - Advertising, Testimonials, Subscribers (import/export)
  - Hero Pages, Web Info
  - Best Visiting Times, Culture & Etiquette, Getting Around, Map Coordinators
  - Contact Inquiries (respond/close/export)
  - Users (CRUD, restore, reset password)
  - Database Backups (create/download/restore/delete)

## Visitor Features
- Home page:
  - Hero banner managed via `HeroPages` with title/description and CTAs
  - Featured destinations grid with category badges and quick facts
  - Real-time weather widget (OpenWeather)
  - Latest destinations list
  - Photo gallery highlights from `Gallery` with destination overlays
  - Newsletter subscription with AJAX and toast feedback
  - Testimonials slider/cards with ratings and visitor info
  - FAQ accordion and call-to-action section
- Destinations:
  - Listing with search (title/description/location) and category filters
  - Pagination (6 per page)
  - Detail page shows category, activities, travel tips, and gallery
- Gallery:
  - Filter by category and search by related destination
  - Pagination (12 per page)
- Tours:
  - Hero content via `HeroPages` and dynamic advertising blocks
- Contact:
  - Contact details from `WebInfo`
  - AJAX contact form validates and stores `ContactInquiry`
- Interactive Map (Leaflet):
  - Grouped layers: Temples, Natural Sites, Accommodations, Local Dishes, Historical Sites
  - Custom icons per layer, popups with image, description, Google Maps link, and destination link
- Advertising blocks:
  - Supports image or video assets via Laravel Storage URLs

## Additional Capabilities & Notes
- Search & Filters:
  - Destination search over `title`, `description`, `location`
  - Category counts via `DestinationCategory::withCount('destinations')`
- Media & Storage:
  - Public-accessible files should live under `storage/app/public` and be exposed with `php artisan storage:link`
  - Blade uses `Storage::url(...)` to serve ad media, testimonials, etc.
- Caching & Performance:
  - Weather responses cached for 30 minutes per city
  - Consider enabling config/route/view caching in production
- Localization:
  - AI assistant supports language hinting (English/Khmer) via user phrases
  - You can expand i18n by adding Laravel localization files for Blade/UI
- SEO:
  - Public routes are server-rendered Blade views suitable for SEO
  - Add meta tags and Open Graph in layout and per-page views as needed
- Security:
  - Admin area under `auth` middleware with explicit auth routes
  - Validate/authorize in admin controllers (extend as needed)
  - Rotate seeded admin password in production
- Backups & Data Lifecycle:
  - Admin includes database backup listing/create/download/restore/delete
  - Data Management routes allow soft-deleted item restore or permanent delete
- Email & Notifications:
  - Configure SMTP or a provider (Resend, Mailgun, SES) in `.env` for production
- Logging & Monitoring:
  - Local logs in `storage/logs/laravel.log`
  - `laravel/pail` included for streaming logs during `composer run dev`

## AI Assistant
- UI: `/ai-assistant`
- Backend: `POST /ai-assistant/chat` (also exposed in `routes/api.php`)
- Provider: Gemini 2.0 Flash (`services.gemini.api_key`)
- Behavior: detects destination-related queries, surfaces relevant destinations from DB, supports Khmer/English hints.

## Weather Widget
- Provider: OpenWeather (`services.openweather.key`)
- Default city: Phnom Penh (metric units). Cached 30 min.

## Newsletter
- Endpoint: `POST /newsletter/subscribe`
- Frontend: AJAX with CSRF token and toast notifications on the home page

## Contact Form
- Page: `/contact`
- Endpoint: `POST /contact/submit` (JSON), stores `ContactInquiry`

## Testing
```bash
php artisan test
```

## Useful Artisan Commands
```bash
php artisan migrate:fresh --seed
php artisan queue:work
php artisan storage:link
php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear
```

## Deployment Notes
- Ensure correct `.env` with production DB, cache, queue, mail, and API keys
- Run `php artisan storage:link` if serving files from `storage/app/public`
- Build assets: `npm ci && npm run build`
- Optimize: `php artisan config:cache && php artisan route:cache && php artisan view:cache`

## Project Structure (high-level)
- `app/Http/Controllers` — Public + Admin controllers
- `app/Models` — Eloquent models (Destinations, Categories, Gallery, Ads, Testimonials, etc.)
- `app/Services/WeatherService.php` — Weather via OpenWeather
- `resources/views` — Blade templates (home, public pages, admin)
- `routes/web.php` — Web routes, admin group, newsletter, AI
- `routes/api.php` — API chat route for AI
- `database/migrations` — Schema
- `database/seeders` — `AdminUserSeeder` and others

## License
This project is licensed under the MIT License. See the `LICENSE` file for details.

Copyright (c) 2025 SEAVPEAV PECH
