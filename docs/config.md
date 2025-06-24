# Configuration

⬅️ [Back to Home](../README.md)

➡️ [Configuration and Environment Variables](#configuration-and-environment-variables)

---

### Path Management System

This directory contains configuration files for the application, including a centralized path management system.

### Overview

The path management system provides a consistent way to handle paths throughout the application, especially when dealing
with different environments (development vs. production).

### Key Files

- `config/config.php`: Loads environment variables and defines core application constants (paths, domains, environment
  settings)
- `config/constants.php`: Defines application-specific constants (page names, titles and other structural data)
- `app/Helpers/Vite.php`: Manages Vite assets loading and path resolution
- `app/Helpers/helpers.php`: Contains helper functions for path management and asset handling

### Configuration Structure

- Environment variables (`.env`) - Site-specific settings and credentials
- Core constants (`config.php`) - System paths and technical configuration
- Application constants (`constants.php`) - Business logic related constants
- Development settings (`vite.config.js`) - Vite and asset building configuration

## Configuration and Environment Variables

⬆️ [Back to Top](#configuration)

⬅️ [Back to Home](../README.md)

---

> Constants are defined in `config.php`.<br/>
> The environment variables can be set in the `.env` file.

```bash

# To set up, copy `.env.example` to `.env` and edit as needed:
cp .env.example .env
```

| Variable          | Default value                  | Description                                                                                                                         |
|-------------------|--------------------------------|-------------------------------------------------------------------------------------------------------------------------------------|
| `APP_PATH`        | `/`                            | The base path for the application                                                                                                   |
| `VITE_DEV_SERVER` | `http://localhost:5173/`       | The URL of the Vite `development` server<br/> * for local only                                                                      |
| `VITE_DEV_CLIENT` | `VITE_DEV_SERVER@vite/client`  | The URL of the Vite client<br/> * used for hot module reload in dev mode                                                            |
| `ASSETS_PATH`     | depends on `IS_DEV`            | The base path for assets<br/> * `VITE_DEV_SERVER` in dev mode,<br/> * `APP_PATH` in production                                      |
| `DIST_PATH`       | `APP_PATH/dist/`               | The path to the dist directory                                                                                                      |
| `IMAGES_PATH`     | `DIST_PATH/assets/images/`     | The path to the images directory                                                                                                    |
| `STYLES_PATH`     | `DIST_PATH/assets/css/`        | The path to the styles directory                                                                                                    |
| `SCRIPTS_PATH`    | `DIST_PATH/assets/js/`         | The path to the scripts directory                                                                                                   |
| `DOMAIN`          | `warriors.example.com`         | Main domain for the site<br/> * used in production                                                                                  |
| `LINK`            | `https://github.com/username/` | Main external link                                                                                                                  |
| `EMAIL`           | `email@example.com`            | Contact email                                                                                                                       |
| `TELEGRAM`        | `https://t.me/username`        | Telegram link                                                                                                                       |
| `IS_DEV`          | `false`                        | Set to `true` for local **development**,<br/> `false` for **production** build.<br/> Whether the application is in development mode |

> For development, set `IS_DEV=true` and specify `VITE_DEV_SERVER` if using Vite.<br/>
> For production, set `IS_DEV=false` and use your real `DOMAIN`.

---

⬆️ [Back to Top](#configuration)

⬅️ [Back to Home](../README.md)