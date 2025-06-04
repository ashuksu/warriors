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
# Make (copy) the example environment file
make env
```

> [Set up an environment in .env](#environment-configuration)

```bash
# Initialize environment configuration and building assets
make install
```

<details>
  <summary>alternative</summary>

```bash
cp .env.example .env # Copy example environment file

composer install          # Install dependencies
npm install

vite build                # the Vite build
composer dump-autoload    # to update startup
docker-compose up --build # Build the Docker image
vite                      # Start dev server
```

</details>

See [More details](docs/docker.md#configuration-and-environment-variables) - contains all available environment
variables and settings

See [More details](docs/docker.md#installation) for detailed instructions on Docker setup

See [More details](docs/vite.md#installation) for detailed instructions on Vite setup

## Development

### Environment Configuration

Development mode:

```.env
DOMAIN=localhost:8080
VITE_DEV_SERVER=http://localhost:5173/
IS_DEV=true
```

Production mode:

```.env
DOMAIN=your-domain.com
IS_DEV=false
```

### Available Commands

```bash
# Start development servers
make docker-up
make vite
```

Visit [localhost:8080](http://localhost:8080) or [localhost:5173](http://localhost:5173) to see the application in
action.

<details>
  <summary>additionally</summary>

```bash
# Start development server asynchronously
make dev
```

</details>

```bash
# Stop development server
make stop
```

```bash
# Stop all containers and servers
make kill
```

```bash
# Preview production build after Docker rebuild
make wget
```

<details>
  <summary>alternative</summary>

```bash

npm run dev    # Start development server
npm run build  # Build for production
npm run stop   # Stop development server
npm run kill   # Stop all containers and servers

# Preview production build after Docker rebuild
npm run docker:build && vite preview 
```

</details>

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
