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

## Development

### Installation
```bash
npm install
```

### Running the Project

#### PHP Built-in Server
```bash
npm run php
```

#### Live Server
```bash
# Install Live Server globally (if not already installed)
sudo npm install -g live-server

# Run Live Server
npm run ls
```

#### Docker
Prerequisites:
1. Install [Docker](https://docs.docker.com/get-docker/) and [Docker Compose](https://docs.docker.com/compose/install/)

```bash
# On Ubuntu/Debian you can install gnome-terminal for convenience
sudo apt install gnome-terminal
```

Docker commands:
- Start the server: `npm run start`
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

After starting the server, open http://localhost:8080 in your browser.
