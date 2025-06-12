# WGET Usage

⬅️ [Back to Home](../README.md)

➡️ [Installation](#installation)

➡️ [Common Usage](#common-usage)

➡️ [Additional Commands](#additional-commands)

---

> First, you need to initialize the Git repository in the `gh-pages/root` directory
> according to [Deployment](deployment.md) instructions

## Installation

```bash
# check if wget is installed
which wget
which live-server
```

```bash
# Install wget and live-server
sudo apt update && sudo apt install wget
sudo npm install -g live-server
```

## Common Usage

⬆️ [Back to Top](#wget-usage)

⬅️ [Back to Home](../README.md)

---

disable development mode in `.env`

```.env
`IS_DEV=false`
```

```bash
# Generation of static pages
make wget
```

## Detailed Steps

```bash
# Preparation
make wget-preparation
```

<details>
  <summary>alternative</summary>

```bash
#be in the root of the project
cd ~/projects/warriors

# stop all local servers
docker-compose down
docker stop $(docker ps -aq)
kill-port 4173 5173 8080 9000 || true
```

```bash
# building in background
composer install
vite build
composer dump-autoload -o
docker-compose up -d --build
```

```bash
rm -rf gh-pages/public  # Delete gh-pages/public/dist
cp -a gh-pages/root gh-pages/public # Copy root as public
cp -r public/dist gh-pages/public/dist  # Copy dist to public
rm -rf gh-pages/public/dist/.vite # Delete .vite
```

</details>

---

```bash
# Generate static pages
make wget-generation
```

<details>
  <summary>alternative</summary>

```bash
# get the pages-html from http://localhost:8080/
wget --convert-links --adjust-extension --page-requisites --no-parent -P gh-pages/public -nH http://localhost:8080/contacts  http://localhost:8080/catalog  http://localhost:8080/404  http://localhost:8080
```

```bash
# Start local server 
live-server gh-pages/public --port=9000 --open=.
```

</details>

---

> check the result at

> ready to Push [Deploy to GitHub Pages](deployment.md#deploy-to-github-pages)

## Additional Commands

⬆️ [Back to Top](#wget-usage)

⬅️ [Back to Home](../README.md)

---

```bash
# start local server
cd gh-pages/public
live-server
```

```bash
# Check the list of auto-started containers
docker ps -a
```

```bash
# stop all
make down
```

<details>
  <summary>alternative</summary>

```bash
# stop Docker if -d (detach mode)
docker stop $(docker ps -aq)
docker rm $(docker ps -aq)
```

---

```bash
# stop localhost
docker stop $(docker ps -aq)
fkill-port 4173 5173 8080 9000 || true
```

</details>

---

```bash
# show list of processes
ps aux | grep live-server | grep -v grep
```

```bash
# username  113726 79.6  1.2 1033532 197504 pts/0  Sl+  00:09   0:07 node /usr/local/bin/live-server
kill 113726

# forcedly
kill -9 113726
```

Visit [How to work with ports ](vite.md#how-to-stop-ports)

---

⬆️ [Back to Top](#wget-usage)

⬅️ [Back to Home](../README.md)