# [WARRIORS](https://ashuksu.github.io/warriors)

A modern PHP application template with Vite bundling, Docker support, and deployment to GitHub Pages.

**Key features:**

- Modern Vite bundling system with PHP integration
- Automated build processes and task runners
- Hot Module Replacement (HMR) support
- Containerized development workflow
- Optimized static site generation
- Page Speed Optimization
- SEO Optimization
- Accessibility (A11y) Enhancements
- Responsive Image Handling (preparation and adaptive serving, `Sharp` (for image processing))
- Local Image Caching
- Device-based Triggers (mobile/tablet/desktop)
- Manual GitHub Pages deployment
- Environment-based configuration

**Tech Stack:**

* **Frontend:** `JavaScript` `HTML5` `CSS3` `SCSS`
* **Build & Style:** `Vite` `npm` `Make` `Autoprefixer` `Sharp`
* **Template Engine:** `PHP`
* **Backend Tools:** `Apache` `Composer` `Mod_Rewrite`
* **DevOps:** `Docker` `GitHub Pages` `Git`
* **Documentation:** `Markdown` `PHPDoc` `JSDoc`

## Table of Contents

* [Repository Structure](#repository-structure)
* [Quick Start](#quick-start)
* [Development](#development)
* [Deployment](#deployment)
* [Documentation](#documentation)

## Repository Structure

### Core Branches

* **`master`**
    - Production branch containing the latest stable version
    - All feature branches are created from here
    - Receives only tested and approved changes

* **`dev`**
    - Development branch for feature integration
    - All new features are merged here first
    - Synced with `master` after testing

* **`gh-pages`**
    - Deployment branch for GitHub Pages
    - Submodule in `/public` directory
    - Contains only built static files
    - Automatically served at ashuksu.github.io/warriors
    - Updated manually via deployment script
    - [More details](docs/deployment.md)

* **`archive/OLD-DESIGN-v1`**
    - Historical snapshot of the original website design
    - Tagged as tag `v1.7.0`
    - **NEVER** merged into active branches
    - [More details](docs/version-v1.md)

### Development Branches

* **`feature/WRRS-№`** - New features (e.g., `feature/WRRS-1`)

* **`bugfix/WRRS-№`** - Bug fixes (e.g., `bugfix/WRRS-2`)

* **`experiment/[API]`** - Experimental features (e.g., `experiment/WGET`)

## Quick Start

```bash
# Clone the repository
git clone https://github.com/ashuksu/warriors.git
cd warriors
```

```bash
# Create `.env` file
make config
```

> [Set up an environment in .env](#environment-configuration)

```bash
# Initialize environment configuration and building assets
make install
```

See [More details](docs/docker.md#configuration-and-environment-variables) - contains all available environment
variables and settings

See [More details](docs/docker.md#installation) for detailed instructions on Docker setup

See [More details](docs/vite.md#installation) for detailed instructions on Vite setup

## Development

### Environment Configuration

Running in Development Mode:

```.env
DOMAIN=localhost
DOMAIN=localhost:8080
VITE_DEV_SERVER=http://localhost:5173/
IS_DEV=true
```

```bash
# Start the development environment (fast) (optimized for deployment)
make up
```

or

```bash
# Start the development environment (Force rebuild before starting) (optimized for deployment)
make dev
```

---

Running in Production Mode:

```.env
DOMAIN=your-domain.com
IS_DEV=false
```

```bash
# Build optimized production
make prod
```

```bash
# Build Docker images and frontend assets (optimized for deployment)
make build
```

### Available Commands

```bash
# Build optimized production Docker images and start them
make prod-up
```

Visit [localhos](http://localhost) to see the application in action.

---

```bash
# Stop all containers and servers
make kill
```

```bash
# Destroying Docker environment (cleaning containers, images, volumes, networks).
make docker-clean
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

- Production build process
- GitHub Pages deployment
- Static site generation

---

⬆️ [Back to Top](#warriors)
