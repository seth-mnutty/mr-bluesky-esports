# MR BLUESKY - Esports Management Platform

A comprehensive Laravel-based esports tournament management platform featuring team registration, match scheduling, player performance tracking, and review systems.

## Features

- **Tournament Management**: Create, manage, and track esports tournaments
- **Team Registration**: Teams can register for tournaments with member management
- **Match Scheduling**: Schedule and track matches within tournaments
- **Game Management**: Manage game library with ratings and reviews
- **Player Performance Metrics**: Track individual and team performance statistics
- **Review System**: Post-match reviews and ratings for games and matches
- **User Roles**: Admin, Organizer, and Player roles with appropriate permissions

## Tech Stack

- **Backend**: Laravel 12
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Database**: MySQL (with migrations and seeders)
- **Authentication**: Laravel Breeze

## Installation

1. Clone the repository
2. Navigate to the `laravel` directory
3. Copy `.env.example` to `.env`
4. Configure your database in `.env`
5. Run `composer install`
6. Run `npm install`
7. Run `php artisan migrate`
8. Run `php artisan db:seed`
9. Run `php artisan storage:link`
10. Run `npm run build` or `npm run dev`

## Project Structure

- `laravel/app/` - Application logic (Models, Controllers, Policies)
- `laravel/resources/views/` - Blade templates
- `laravel/database/` - Migrations and seeders
- `laravel/routes/` - Application routes

## Key Updates

- Updated FIFA 24 to FC 26
- Added Fortnite game support
- Dark theme with blue accents (MR BLUESKY branding)
- Currency display in Kshs (Kenyan Shillings)
- Game images displayed on tournament cards

## License

Proprietary - All rights reserved

