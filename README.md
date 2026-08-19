<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# AI-Powered Job Automation System

This is a modern, real-time Laravel 11 application that uses Puppeteer and Google Gemini AI to automate discovering, analyzing, and applying for jobs across multiple platforms (LinkedIn, Naukri, Indeed, Uplers, Unstop, Hirist, Cutshort).

## 🏗️ System Architecture

The application is built on a robust, asynchronous architecture designed to handle long-running scraping tasks without blocking the user interface.

- **Frontend:** Laravel Livewire 3 + Alpine.js + Tailwind CSS + Vite
- **Backend:** Laravel 11 (PHP 8.3)
- **Database:** SQLite (with optimized pragmas for concurrency)
- **Real-Time Engine:** Laravel Reverb (WebSocket server on port `8081`)
- **Queue System:** Laravel Database Queues (for asynchronous scraping jobs)
- **Scraping Engine:** Node.js + Puppeteer (managed via Symfony Process)
- **AI Integrations:** Google Gemini AI (via `google-gemini-php/client`)

### How it Works (Data Flow)

1. **User Action:** The user clicks "Scrape" in the Live Activity Feed.
2. **Job Dispatch:** Livewire dispatches `RunScraperJob` to the Laravel database queue.
3. **Queue Worker:** A background worker (`php artisan queue:work`) picks up the job and spawns a Node.js Puppeteer process.
4. **Real-time Feedback:** As the scraper finds jobs or encounters errors, it logs output. Laravel Reverb broadcasts these updates (`ActivityLogged` events) directly to the user's browser in real-time.
5. **AI Processing:** Users can trigger Gemini AI from the Jobs List to instantly generate Cover Letters, mock interview prep, or analyze their resume against the job description.

## 🤖 Google Gemini AI Integration

This project relies heavily on Google's Gemini AI to provide a personalized job hunt experience. It requires a `GEMINI_API_KEY` to be set in your `.env` file.

**AI Features Include:**
- **Resume Match Analysis:** Evaluates the user's uploaded resume against a specific scraped job description and provides a match percentage, missing skills, and recommendations.
- **Auto-Cover Letter Generation:** Drafts a highly tailored cover letter combining the user's experience and the company's requirements.
- **Mock Interview Prep:** Generates potential interview questions, technical topics to brush up on, and company-specific behavioral prep based on the job role.

## 🛠️ Developer Documentation (Local Setup)

To run this project locally, you must run several services simultaneously to ensure the frontend, queues, and WebSockets function correctly.

### Prerequisites
- PHP 8.2+
- Node.js 18+ (20+ recommended)
- Composer

### 1. Initial Setup
```bash
composer install
npm install

# Setup Environment
cp .env.example .env
php artisan key:generate

# Run Migrations
php artisan migrate:fresh --seed
```

### 2. Environment Variables (`.env`)
Ensure the following variables are correctly configured:
```env
DB_CONNECTION=sqlite

# Real-time WebSockets
REVERB_SERVER_HOST="0.0.0.0"
REVERB_SERVER_PORT=8081
REVERB_SERVER_HOSTNAME="localhost"

# Google Gemini API
GEMINI_API_KEY="your-gemini-api-key-here"

# Notification Channels (Optional)
SLACK_WEBHOOK_URL="..."
```

### 3. Running the Stack
You will need **four** separate terminal tabs running concurrently to develop locally:

**Terminal 1: Web Server**
```bash
php artisan serve
```

**Terminal 2: Frontend Assets (Vite)**
```bash
npm run dev
```

**Terminal 3: WebSocket Server (Reverb)**
```bash
php artisan reverb:start
```

**Terminal 4: Background Queue Worker**
```bash
php artisan queue:work
```
*(Note: If you make changes to queueable Jobs, you must restart the queue worker for the changes to take effect).*

## 🐳 Docker Deployment (Production)

The application includes a fully containerized setup for production using Docker and Docker Compose. The `docker-compose.yml` handles the web server, queue workers, and cron scheduler automatically.

1. Clone the repository to your server.
2. Configure your `.env` file.
3. Run the stack:
   ```bash
   docker-compose up -d --build
   ```
4. Install dependencies inside the container:
   ```bash
   docker-compose exec app composer install --optimize-autoloader --no-dev
   docker-compose exec app php artisan key:generate
   docker-compose exec app php artisan migrate --force
   ```
5. The application is now accessible on port `8000`. The background worker and scheduler are already managed by Supervisor inside the container.
