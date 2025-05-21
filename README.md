# Warriors Project

<details>
  <summary>Click to show Preview</summary>

  ![WARRIORS](https://raw.githubusercontent.com/ashuksu/warriors/refs/heads/main/preview.jpg)
</details>


## Getting Started

### Prerequisites

Before you begin, ensure you have the following installed:
- [Node.js](https://nodejs.org/) (v14 or later)
- [PHP](https://www.php.net/) (v8.0 or later)
- [Docker](https://docs.docker.com/get-docker/) and [Docker Compose](https://docs.docker.com/compose/install/) (optional, for Docker deployment)

### Installation

## Requirements
- PHP 8.0 or higher
- Composer
- Node.js and NPM

```bash
# Install dependencies
composer install
npm install
```

```bash
# to update startup
composer dump-autoload
```
or

```bash
# optimized generation, better for production
composer dump-autoload -o
```

```bash   
# Rebuild the Docker image and the Vite build
npm run build
```

```bash   
# Once at first time, or after edition/cleaning Docker files
docker-compose build
```

### Running the Project (Docker + Vite)

```
http://localhost:8080
```

```
http://localhost:5173/
```

```bash 
# Start dev server
npm run dev
```

```bash 
# Start build
npm run build
```

```bash  
# Stop
npm run stop
```

```bash  
# Preview
npm run preview
```

### Running Docker

```bash
# Start
npm run docker:dev
```

```
http://localhost:8080
```

```bash 
# Forced rebuild without cache:
docker-compose up --build
```

```bash 
# Just build:
docker-compose build
```

### Additional Docker commands

```bash
# Restart the container
npm run docker:restart
```

```bash
# Monitor Docker containers
npm run docker:monitor
```

#### How to stop Docker

```bash  
# Stop the container
npm run docker:stop
```

#### How to clean Docker

```bash 
# !! Clean unused Docker resources
npm run docker:clean
```

```bash 
# Clean up all unused containers and images
docker system prune -a
```

```bash 
# Delete all local project images (PROJECT_DIRECTORY_NAME_web)
docker rmi warriors_web
```

### Running Vite

```bash 
# Start dev server
npm run vite:dev
```

```
http://localhost:5173/
```

```bash 
# Start build
npm run vite:build
```

### Using the Vite Helper

The project includes a Vite helper class that simplifies asset management in both development and production environments. The helper automatically handles the loading of assets from the Vite development server in development mode and from the built files in production mode.

#### Including Assets in Templates

```markdown
```js
input: {
  script: './src/js/script.js',
  style: './src/css/style.css',
  styleHome: './src/css/styleHome.css',
  animate: './src/css/libs/animate.min.css',
  criticalStyles: './src/scss/criticalStyles.scss'
},
```

> **Important:**  
> These files must be listed in the `input` option of your `vite.config.js` configuration.  
> If you do not include them, Vite will not process or output these assets, and you may encounter errors when trying to load them in your templates.
> Except for those that are connected in modules
```
Use the `getAssetPath` method to include assets in your templates:

```php
<?php
use App\Helpers\Vite;
?>

<!-- CSS files -->
<link rel="stylesheet" href="<?= Vite::getAssetPath('src/css/style.css') ?>">
<link rel="stylesheet" href="<?= Vite::getAssetPath('src/scss/criticalStyles.scss') ?>">

<!-- JavaScript modules -->
<script type="module" src="<?= Vite::getAssetPath('src/js/modules/Menu.js') ?>"></script>
<script type="module" src="<?= Vite::getAssetPath('src/js/modules/utils/Toggle.js') ?>"></script>

<!-- Library CSS files -->
<link rel="stylesheet" href="<?= Vite::getAssetPath('src/css/libs/animate.min.css') ?>">
```

#### Development vs Production

The Vite helper automatically detects whether the application is running in development or production mode based on the `IS_DEV` constant defined in the `.env` file:

- In development mode (`IS_DEV=true`), assets are loaded from the Vite development server
- In production mode (`IS_DEV=false`), assets are loaded from the built files with hashed filenames

#### Supported Asset Types

The Vite helper supports various asset types:

- CSS files (e.g., `src/css/style.css`, `src/css/libs/animate.min.css`)
- SCSS files (e.g., `src/scss/main.scss`, `src/scss/criticalStyles.scss`)
- JavaScript files (e.g., `src/js/modules/Menu.js`, `src/js/modules/utils/Toggle.js`)

### Additional Vite commands

```bash
# Preview
npm run vite:preview
```

```
http://localhost:4173
```

#### How to check|clean|stop|kill Vite

```bash  
# Stop
npm run vite:stop
```

```bash
# Stop (Linux only)
npm run vite:kill
```

```bash
# Find the PID of the process
lsof -i :5173
```

```bash
# Or alternatively
netstat -tulpn | grep 5173
```

```bash
# Kill the process (replace <PID> with the process number from the previous command)
kill -9 <pid>
```