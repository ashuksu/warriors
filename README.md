# [WARRIORS](https://ashuksu.github.io/warriors)

A modern, containerized (Docker support) PHP application template featuring Vite bundling, PostgreSQL, Nginx, and automated deployment to GitHub Pages.

**Key features:**

* Modern `Vite` bundling system with `PHP` integration
* Modular JavaScript (`ES Modules`)
* CSS Preprocessing (`SCSS`)
* Task Automation with `Make`
* Automated build processes and task runners
* Hot Module Replacement (`HMR`) support
* Automatic Reloading for Development (PHP & Frontend)
* Seamless Dependency Management (Composer for PHP, npm for Node.js)
* Flexible Environment-based Configuration (`.env` files)
* Containerized development workflow (`Nginx`, `PHP-FPM`, `PostgreSQL`, `Vite Dev Server`)
* Optimized Docker Images (`Multi-Stage Builds`)
* Optimized static site generation
* Page Speed Optimization
* `SEO` Optimization
* `Accessibility` (A11y) Enhancements
* Responsive Image Handling (preparation and adaptive serving, `Sharp` for image processing)
* Local Image Caching
* Device-based Triggers (mobile/tablet/desktop)
* Semi-Automated GitHub Pages Deployment
* Database migrations with `Phinx`
* Caching with `APCu`

**Tech Stack:**

* **Frontend:** `JavaScript` `HTML5` `CSS3` `SCSS`
* **Build & Style:** `Vite` `npm` `Make` `Autopreload` `Sharp` `Node.js`
* **Template Engine:** `PHP`
* **Backend Tools:** `Nginx` `PHP-FPM` `Composer` `PostgreSQL` `Phinx` `APCu`
* **DevOps:** `Docker` `GitHub Pages` `Git`
* **Documentation:** `Markdown` `PHPDoc` `JSDoc`

## Table of Contents

* [Repository Structure](#repository-structure)
* [Quick Start](#quick-start)
* [Development](#development)
  * [Core Commands](#core-commands)
  * [Interacting with Containers](#interacting-with-containers)
  * [Database Management](#database-management)
  * [Environment Configuration](#environment-configuration)
  * [Cleaning Up and Stop](#cleaning-up-and-stop)
* [Production](#production)
* [Documentation](#documentation)
* [Deployment](#deployment)

---

## Repository Structure

### Core Branches

* **`master`**
  * Production branch containing the latest stable version
  * All feature branches are created from here
  * Receives only tested and approved changes

* **`dev`**
  * Development branch for feature integration
  * All new features are merged here first
  * Synced with `master` after testing

* **`gh-pages`**
  * Deployment branch for GitHub Pages
  * Submodule in `/public` directory
  * Contains only built static files
  * Automatically served at ashuksu.github.io/warriors
  * Updated manually via a deployment script
  * [More details](docs/deployment.md)

* **`archive/OLD-DESIGN-v1`**
  * Historical snapshot of the original website design
  * Tagged as tag `v1.7.0`
  * **NEVER** merged into active branches
  * [More details](docs/version-v1.md)

### Development Branches

* **`feature/WRRS-task`** - New features (e.g., `feature/WRRS-nginx`)

* **`bugfix/WRRS-task`** - Bug fixes (e.g., `bugfix/WRRS-routing`)

* **`experiment/[API]`** - Experimental features (e.g., `experiment/WGET`)

## Quick Start

Get your development environment up and running in just a few steps.

**Prerequisites:**

* [Docker Desktop](https://www.docker.com/products/docker-desktop/) installed and running.

**1. Clone the Repository**

```bash
git clone https://github.com/ashuksu/warriors.git
cd warriors
```

**2. Create Environment File**
This command copies the example environment file. Review `.env` and adjust variables if needed.

```bash
make env
```

See [More details](#environment-configuration) for environment variable setup.
See [More details](docs/config.md#configuration-and-environment-variables) for all available environment variables and settings.

**3. Start the Development Environment**
This single command builds necessary Docker images, installs all dependencies (Composer & NPM) inside the containers,
and starts `Nginx`, `PHP-FPM`, `PostgreSQL`, and `Vite Dev Server`.

```bash
make up
```

<details>
  <summary>recommendations</summary>

> Use `make dev ARGS="list of arguments"` for more control over the `docker-compose` command in development mode.
> Example: `make dev ARGS="up --build -d"`

```bash
# For first time setup or after changes in Dockerfile or docker-compose.yml, use building without cache:
make dev ARGS="build --no-cache"
```

</details>

Your development environment is now running!

* **Web Application:** [localhost](http://localhost) served by Nginx, proxying to PHP-FPM and Vite Dev Server.
* **Vite Dev Server:** [localhost:5173](http://localhost:5173) for HMR and direct asset serving.

> After `make up` you need to install Composer dependencies and build NPM assets inside the containers.

*Sources*

1.  See [More details](docs/docker.md#installation) for detailed instructions on Docker setup.
2.  See [More details](docs/vite.md#installation) for detailed instructions on Vite setup.

## Development

Use the Makefile as your primary tool for managing the project. All commands are run from your host machine.

### Core Commands

* Start everything: `make up`
* Stop everything: `make down`

### Interacting with Containers

You never need to install PHP, Composer, or Node.js on your host machine. Use these commands to run tools inside their
respective containers:

* Run any Composer command:

```bash
# For installing Composer dependencies
make composer install
```

<details>
  <summary>recommendations</summary>

```bash
# For apdating dependencies after changes in `composer.json` you can use:
make composer update
make composer dump-autoload
```

```bash
# Example: require a new PHP package
make composer require phpleague/flysystem
```

</details>

* Run any NPM command:

```bash
# For building NPM assets
make npm build
```

<details>
  <summary>recommendations</summary>

```bash
# Example: install a new JS package
make npm install dayjs
```

</details>

* Open a shell in the PHP container:

```bash
make exec-php
```

* Open a shell in the Vite helper container:

```bash
make exec-vite
```

* Monitor Docker containers (requires `ctop` image):

```bash
make monitor
```

### Database Management

The development environment includes a PostgreSQL database and uses Phinx for database migrations.

* Apply new database migrations:

```bash
make migrate
```

* Run the database seeding script to populate the database with initial data:

```bash
make seed
```

<details>
  <summary>recommendations</summary>

> Use `make create-migration [...name]` for creating a new migration (use CamelCase format).
> Example: `make create-migration name=NewPageMigration`

```bash
make create-migration name=MigrationName
```

</details>

### Environment Configuration

The `IS_DEV` variable controls environment-specific settings.

Running in Development Mode (`.env`):

```env
DOMAIN=localhost
VITE_DEV_SERVER=http://localhost:5173/
IS_DEV=true
```

Running in Production Mode (configured in `docker-compose.yml` for `php` service):

```env
DOMAIN=domain.example.com
IS_DEV=false
```

*(This overrides any `IS_DEV` value in `.env` for production deployments)*

### Cleaning Up and Stop

To stop the development environment:

```bash
make down
```

To stop the production environment:

```bash
make down-prod
```

To completely remove all project-specific containers, networks, and persistent data volumes (`node_modules` cache,
database data, etc.), run:

```bash
make clean
```

> **Warning\! Purge ALL Docker system resources (containers, images, volumes, cache).**
> USE WITH EXTREME CAUTION\! This command removes *all* Docker resources on your system, not just project-specific ones.
> It will ask for confirmation.

```bash
make destroy
```

## Production

**1. Build Production Images**
This command executes a multi-stage Docker build, creating lean, self-contained images with all frontend assets and PHP
dependencies included.

```bash
make build-prod
```

**2. Build Frontend Assets for Local Processing**
If you need to build frontend assets locally (e.g., for specific deployment pipelines not using the Docker build stage for assets), run:

```bash
make npm run build
```

**3. Run in Production Mode**
This command starts the production services (`Nginx`, `PHP-FPM`, and `PostgreSQL`) in detached (background) mode.

```bash
make up-prod
```

## Documentation

* [Configuration Guide](docs/config.md)
* [Docker Setup](docs/docker.md)
* [Vite Configuration](docs/vite.md)
* [WGET Usage](docs/wget.md)
* [Deployment Guide](docs/deployment.md)
* [Version History](docs/version-v1.md)

## Deployment

See [Deployment Guide](docs/deployment.md) for detailed instructions on:

* Production build process
* GitHub Pages deployment
* Static site generation

---

⬆️ [Back to Top](#warriors)
