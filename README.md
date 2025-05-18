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

```bash
# Install dependencies
npm install
```

```bash   
# Rebuild the Docker image (once at first time, or after edition Docker files)
npm run docker:build
```

### Running the Project (Docker)

```bash
# Install dependencies
npm run docker:dev
```
```bash
http://localhost:8080
```

### Additional Docker commands

```bash
# Restart the container
npm run docker:restart
```

```bash  
# Stop the container
npm run docker:stop
```


```bash
# Monitor Docker containers
npm run docker:monitor
```

```bash 
# !! Clean unused Docker resources
npm run docker:clean
```
