# Docker Usage

⬅️ [Back to Home](../README.md)

➡️ [Installation](#installation)

➡️ [Docker Compose](#docker-compose)

➡️ [Examples](#examples)

➡️ [Additional Commands](#additional-commands)

---

## Installation

> additional information first

[Get Docker](https://docs.docker.com/get-docker/)

[Installing Docker Compose](https://docs.docker.com/compose/install/)

```bash

# For Ubuntu/Debian, you can install gnome-terminal for convenience
sudo apt install gnome-terminal
```

## Docker Compose

⬆️ [Back to Top](#docker-usage)

⬅️ [Back to Home](../README.md)

---

### Common Usage

``` 
docker-compose up [OPTIONS]
```

> Start containers for the application based on docker-compose.yml.

| Option             | Description                                                                      |
|--------------------|----------------------------------------------------------------------------------|
| `--build`          | Builds images **before** starting containers (if changes were made).             |
| `--no-cache`       | Builds images **without using cache**, useful for forced clean builds.           |
| `-d`               | Runs containers in the **background (detached mode)**.                           |
| `--force-recreate` | Forces recreation of containers even if nothing changed.                         |
| `restart`          | Restarts **all** services (containers) defined in `docker-compose.yml`.          |
| `down`             | Stops **and removes** containers, networks, and volumes created by `up`.         |
| `--remove-orphans` | Removes containers for services not defined in the current `docker-compose.yml`. |

## Examples

⬆️ [Back to Top](#docker-usage)

⬅️ [Back to Home](../README.md)

---

```bash

# Start the app (builds only if needed):
docker-compose up && echo 'Server started at http://localhost:8080'",
```

Visit [localhost:8080](http://localhost:8080)

```bash

# Force rebuild before starting:
docker-compose up --build
```

```bash 

# Just build:
docker-compose build
```

```bash 

# Force rebuild without cache:
docker-compose up --build --no-cache
```

```bash

# Start in background:
docker-compose up -d
```

```bash

# Stop containers, networks, etc.
docker-compose down
```

```bash

# Restart the container
docker-compose restart
```

## Additional Commands

⬆️ [Back to Top](#docker-usage)

⬅️ [Back to Home](../README.md)

---

```bash

# View current status of all project containers
docker ps
```

```bash

# Monitor Docker containers
docker run --rm -ti --name=ctop -v /var/run/docker.sock:/var/run/docker.sock quay.io/vektorlab/ctop:latest
```

### How to stop Docker (running)

```bash 

# Stop containers
docker stop $(docker ps -aq)

# Remove containers
docker rm $(docker ps -aq)
```

Visit [How to work with ports (:8080) ](vite.md#how-to-stop-ports)

### How to clean Docker and Rebuild (running)

> Stop the containers first

```bash 

# Clean unused Docker resources
docker system prune -af

# Clean up all unused containers and images
docker system prune -a

# Delete all local project images (PROJECT_DIRECTORY_NAME_web)
docker rmi warriors_web

# Just build:
docker-compose build
```

---

⬆️ [Back to Top](#docker-usage)

⬅️ [Back to Home](../README.md)