# Path Management System

This directory contains configuration files for the application, including a centralized path management system.

## Overview

The path management system provides a consistent way to handle paths throughout the application, especially when dealing with different environments (development vs. production).

## Key Files

- `paths.php`: Defines constants and functions for path management
- `config.php`: Loads environment variables and includes paths.php

## Environment Variables

The following environment variables can be set in the `.env` file:

- `APP_PATH`: The base path for the application (default: '/')
- `PROJECT_ROOT`: The root directory of the project (default: parent directory of config)
- `VITE_DEV_SERVER`: The URL of the Vite development server (default: 'http://localhost:5173/')
- `IS_DEV`: Whether the application is in development mode (default: false)

## Constants

The following constants are defined in `paths.php`:

- `APP_PATH`: The base path for the application
- `PROJECT_ROOT`: The root directory of the project
- `VITE_DEV_SERVER`: The URL of the Vite development server
- `VITE_DEV_CLIENT`: The URL of the Vite client
- `ASSETS_PATH`: The base path for assets (VITE_DEV_SERVER in dev mode, APP_PATH in production)
- `DIST_PATH`: The path to the dist directory
- `IMAGES_PATH`: The path to the images directory
- `STYLES_PATH`: The path to the styles directory
- `SCRIPTS_PATH`: The path to the scripts directory

## Functions

### getAssetPath(string $path, bool $isViteModule = false): string

Returns the appropriate path for an asset based on the environment. In development mode, it will use the Vite development server if it's running. Otherwise, it will use the production path.

```php
// Example usage
$imagePath = getAssetPath('dist/assets/images/logo.png');
```

### isViteServerRunning(): bool

Checks if the Vite development server is running by making a quick HTTP request to the server URL. This function uses static caching to avoid repeated checks.

```php
// Example usage
if (isViteServerRunning()) {
    // Use Vite server
} else {
    // Use built assets
}
```

## Usage

To use the path management system in your code, simply use the constants and functions defined in `paths.php`. For example:

```php
// Get the path to an image
$imagePath = getAssetPath('dist/assets/images/logo.png');

// Get the path to a script
$scriptPath = getAssetPath('dist/assets/js/main.js');
```

This ensures that the correct paths are used regardless of the environment.