# Path Management System

This directory contains configuration files for the application, including a centralized path management system.

## Overview

The path management system provides a consistent way to handle paths throughout the application, especially when dealing with different environments (development vs. production).

## Key Files

- `config.php`: Loads environment variables and defines constants for path management
- `app/Helpers/helpers.php`: Contains helper functions for path management and asset handling

## Environment Variables

The following environment variables can be set in the `.env` file:

- `APP_PATH`: The base path for the application (default: '/')
- `PROJECT_ROOT`: The root directory of the project (default: parent directory of config)
- `VITE_DEV_SERVER`: The URL of the Vite development server (default: 'http://localhost:5173/')
- `IS_DEV`: Whether the application is in development mode (default: false)
- `DOMAIN`: The main domain of the site (default: 'warriors.example.com')
- `LINK`: The main external link (default: 'https://github.com/username/')
- `EMAIL`: Contact email (default: 'email@example.com')
- `TELEGRAM`: Telegram link (default: 'https://t.me/username')

## Constants

The following constants are defined in `config.php`:

- `APP_PATH`: The base path for the application
- `PROJECT_ROOT`: The root directory of the project
- `VITE_DEV_SERVER`: The URL of the Vite development server
- `VITE_DEV_CLIENT`: The URL of the Vite client
- `ASSETS_PATH`: The base path for assets (VITE_DEV_SERVER in dev mode, APP_PATH in production)
- `DIST_PATH`: The path to the dist directory
- `IMAGES_PATH`: The path to the images directory
- `STYLES_PATH`: The path to the styles directory
- `SCRIPTS_PATH`: The path to the scripts directory
- `DOMAIN`: The main domain of the site
- `LINK`: The main external link
- `EMAIL`: Contact email
- `TELEGRAM`: Telegram link