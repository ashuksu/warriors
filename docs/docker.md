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

## Docker Compose

### Common Usage

``` 
docker-compose up [OPTIONS]
```

> Start containers for the application based on docker-compose.yml.

| Option             | Description                                                                      |
|--------------------|----------------------------------------------------------------------------------|
| `-h`               | Help.                                                                            |
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
# Start the app:
make docker-up
```

<details>
  <summary>alternative</summary>

```bash
docker-compose up && echo 'Server started at http://localhost:8080'",
```

</details>

Visit [localhost:8080](http://localhost:8080)

```bash
# Force rebuild before starting:
make docker-up--build
```

<details>
  <summary>alternative</summary>

```bash
docker-compose up --build

```

</details>

```bash 
# Just build:
make docker-build:
```

<details>
  <summary>alternative</summary>

```bash 
docker-compose build
```

</details>

```bash
# Start in background:
make docker-up-d
```

<details>
  <summary>alternative</summary>

```bash
docker-compose up -d
```

</details>

```bash
# Stop containers, networks, etc.
make docker-down
```

<details>
  <summary>alternative</summary>

```bash
# Stop containers, networks, etc.
docker-compose down
```

</details>

```bash
# Restart the container
make docker-restart
```

<details>
  <summary>alternative</summary>

```bash
docker-compose restart
```

</details>

## Additional Commands

⬆️ [Back to Top](#docker-usage)

⬅️ [Back to Home](../README.md)

---

```bash 
# Force rebuild without cache:
docker-compose up --build --no-cache
```

```bash
# View current status of all project containers
docker ps
```

```bash
# Monitor Docker containers
make docker-monitor
```

<details>
  <summary>alternative</summary>

```bash
docker run --rm -ti --name=ctop -v /var/run/docker.sock:/var/run/docker.sock quay.io/vektorlab/ctop:latest
```

</details>

### How to stop Docker (running)

```bash
# Stop containers
make docker-stop
```

<details>
  <summary>alternative</summary>

```bash
docker stop $(docker ps -aq)
```

</details>

```bash
# Remove containers
make docker-rm
```

<details>
  <summary>alternative</summary>

```bash
docker rm $(docker ps -aq)
```

</details>

Visit [How to work with ports (:8080) ](vite.md#how-to-stop-ports)

### How to clean Docker and Rebuild (running)

> STOP the containers first

```bash
# Total rebuild (clean and build from scratch)
make docker-purge
make docker-build
```

<details>
  <summary>alternative</summary>

```bash 
# Clean unused Docker resources: containers, images, volumes and networks
docker system prune -af
docker volume prune -f
docker network prune -f 
docker rmi warriors_web || true

# Update autoloader
yes | composer dump-autoload -o

# Rebuild Docker image
docker-compose build
```

</details>

---

⬆️ [Back to Top](#docker-usage)

⬅️ [Back to Home](../README.md)