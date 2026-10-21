# English Buddy

A web app where lower-secondary students (THCS, grades 6–9) practise everyday English with an AI
role-play partner, on content aligned to the *Tiếng Anh 6–9 Global Success* syllabus. Vietnamese
support fades as the student improves; teachers create classes, approve content and follow progress.

Built with Laravel 12, Livewire 4, Tailwind CSS 4 and MySQL 8; AI through OpenRouter.

> The GitHub repository is still named `manage-asset` for historical reasons — see
> [docs/product/discovery-log.md](docs/product/discovery-log.md), Sessions 1–4.

## Getting started

Requirements: PHP 8.2, Composer, Node.js, MySQL 8.

1. Create a MySQL database (the name the project expects is in [.env.example](.env.example)).
2. Run `composer run setup` — installs dependencies, creates `.env` from `.env.example`, migrates
   and builds assets. The steps are defined in [composer.json](composer.json).
3. Put the OpenRouter key in `.env` as `OPENROUTER_API_KEY`. Without it, everything except the AI
   features works.
4. `php artisan db:seed` (development only) loads the syllabus, starter topics and ready-made
   lessons for all 48 units with no AI calls, plus demo accounts — see
   [DatabaseSeeder](database/seeders/DatabaseSeeder.php) for their usernames.
5. `composer run dev` starts the server, queue worker and Vite together.

Tests: `php artisan test` (runs on in-memory SQLite, never calls the real AI).

## Documentation

| Read this | For |
| --- | --- |
| [CLAUDE.md](CLAUDE.md) | Hard rules for anyone changing the code, human or AI |
| [docs/product/vision.md](docs/product/vision.md) | What the product is for, scope, open questions |
| [docs/product/backlog.md](docs/product/backlog.md) | What is built and what is next (`AM-###` items) |
| [docs/product/discovery-log.md](docs/product/discovery-log.md) | Why each requirement exists, session by session |
| [docs/product/personas.md](docs/product/personas.md) · [glossary.md](docs/product/glossary.md) | Roles and vocabulary |
| [docs/architecture/tech-stack.md](docs/architecture/tech-stack.md) · [adr/](docs/architecture/adr/) | Technical choices and the decisions behind them |
| [docs/process/](docs/process/) | Scrum process, Definition of Ready / Done, git workflow |
| [docs/sprints/](docs/sprints/) | Sprint goals, boards and velocity |
