# Warriors Project

<details>
  <summary>Click to show Preview</summary>

  ![WARRIORS](https://raw.githubusercontent.com/ashuksu/warriors/refs/heads/main/preview.jpg)
</details>

## Project Structure
This project uses a modern PHP structure with MVC pattern and Vite for frontend asset building.

### Directory Structure
- `app/` - Application code
  - `Controllers/` - Controller classes
  - `Data/` - Data files
  - `Services/` - Service classes
  - `Views/` - View templates
- `assets/` - Static assets (images, fonts, etc.)
- `config/` - Configuration files
- `public/` - Public web root
  - `assets/` - Compiled assets
- `src/` - Frontend source files for Vite
  - `css/` - CSS source files
  - `js/` - JavaScript source files

## Getting Started

### Prerequisites
Before you begin, ensure you have the following installed:
- [Node.js](https://nodejs.org/) (v14 or later)
- [PHP](https://www.php.net/) (v8.0 or later)
- [Docker](https://docs.docker.com/get-docker/) and [Docker Compose](https://docs.docker.com/compose/install/) (optional, for Docker deployment)

### Installation
1. Clone the repository:
   ```bash
   git clone https://github.com/ashuksu/warriors.git
   cd warriors
   ```

2. Install dependencies:
   ```bash
   npm install
   ```

3. Create required PHP files:
   The project requires several PHP files that need to be created before running the application. See the [Missing Files](#missing-files) section below for details.

### Running the Project

#### Option 1: PHP Built-in Server (Recommended for Development)
```bash
npm run php
```
This will start a PHP development server at http://localhost:8000.

#### Option 2: Live Server
```bash
# Install Live Server globally (if not already installed)
npm install -g live-server

# Run Live Server
npm run ls
```

#### Option 3: Docker
```bash
# Start the server
npm run start

# The application will be available at http://localhost:8080
```

Additional Docker commands:
- Restart the container: `npm run restart`
- Stop the container: `npm run stop`
- Rebuild the Docker image: `npm run build`
- Monitor Docker containers: `npm run monitor`
- Clean unused Docker resources: `npm run clean`

### Frontend Development
```bash
# Run Vite development server
npm run dev

# Build frontend assets
npm run build:assets
```

## Missing Files
The project is missing several required PHP files that need to be created:

### View Files
- `app/Views/head.php` - HTML head section
- `app/Views/header.php` - Site header
- `app/Views/footer.php` - Site footer
- `app/Views/footer-links.php` - JavaScript includes
- `app/Views/Popup.php` - Popup component

### Component Files
- `app/Views/components/button.php` - Button component with render_button() function
- `app/Views/components/preloader.php` - Preloader component

### Section Templates
- `app/Views/sections/main-section/template.php` - Main section template
- `app/Views/sections/about/template.php` - About section template
- `app/Views/sections/faq/template.php` - FAQ section template
- `app/Views/sections/info/template.php` - Info section template

You need to create these files with appropriate content before running the application.

## Troubleshooting

### Common Issues

#### Application Not Starting
- Check if all required PHP files have been created
- Verify that the PHP version is 8.0 or later
- Check for PHP errors in the console output

#### Docker Issues
- Ensure Docker and Docker Compose are installed and running
- Check if port 8080 is already in use by another application
- Run `docker-compose logs` to see detailed error messages

#### Vite Development Server Issues
- Ensure Node.js is installed and is version 14 or later
- Check if port 3000 is already in use
- Run `npm run dev -- --debug` for more detailed error messages

### Getting Help
If you encounter issues not covered in this troubleshooting section, please:
1. Check the console for error messages
2. Review the project structure and ensure all files are in the correct locations
3. Contact the project maintainer at ashuksu@gmail.com or via Telegram at https://t.me/ashuksu
