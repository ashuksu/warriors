# [WARRIORS](https://ashuksu.github.io/warriors/public)

# Repository Structure

<details>
  <summary>Core Branches</summary>

This repository uses the following branch structure to manage different versions of the project:

</details>

---

## Core Branches

<details>
  <summary>Core Branches</summary>

* **`master`**:
    * This is the **main (production)** branch. It always contains the **latest version of the website with the new
      design**, which is deployed to production.
    * Any release-ready changes are merged here.

* **`dev`**:
    * This is the **development branch**. All new features and bug fixes are initially developed here or in separate
      feature branches, then merged into `dev`.
    * `dev` is synchronized with `master` after each successful release.

</details>

---

## Old Website Version (Pre-Redesign)

<details>
  <summary>Pre-Redesign</summary>

We've preserved the previous version of the website (before the major redesign) for historical access or in case it's
needed. It's represented as follows:

* **`master-old-v1` (Branch)**:
    * This is a **dedicated branch** that holds the **complete history of the old website design**.
    * If minor changes or fixes are ever needed for the old version, they can be made within this branch.

* **`old-design-v1` (Tag)**:
    * This is a **permanent tag** that points to the **last commit of the old website version** (at the time it was "
      frozen" before the redesign).
    * Tags serve as static "snapshots" of the code's state at a specific point in time. It acts as a reference point for
      the old design.

</details>

---

## How to Switch Between Versions

<details>
  <summary>How to Switch</summary>

### Switching to the Main or Dev Branch:

* To work on the new version or synchronize with it:
    ```bash
    git checkout master
    # or
    git checkout dev
    ```

### Switching to the Old Branch:

* If you need to work with the code of the old design:
    ```bash
    git checkout master-old-v1
    ```

### Viewing and Checking Out Tags:

* To see all available tags:
    ```bash
    git tag
    ```
  You'll see a list, including `old-design-v1`.

* To "check out" the state that a tag points to (this will put you in a "detached HEAD" state, which is fine for viewing
  but not for active development):
    ```bash
    git checkout old-design-v1
    ```
  If you want to start development based on this tagged state, you should create a new branch:
    ```bash
    git checkout -b feature/old-v1-TASK old-design-v1
    ```

  Or branch off the `master-old-v1`
    ```bash
    git checkout master-old-v1
    ```

</details>

By adhering to this structure, we ensure a clear separation between active development, current production, and
historical versions of the project.

---

# Installation

<details>
  <summary>Installation</summary>

```bash
# Install dependencies
composer install
npm install
```

```bash   
# Build the Docker image and the Vite build
docker-compose up --build
vite build
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

</details>

---

### Running the Project (Docker + Vite)

<details>
  <summary>Docker + Vite</summary>

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

</details>

---

### Running Docker

<details>
  <summary>Docker</summary>

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

```bash 
# Just build:
docker-compose build
```

</details>

---

### Running Vite

<details>
  <summary>Vite</summary>

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

</details>

---

### Using the Vite Helper

The project includes a Vite helper class that simplifies asset management in both development and production
environments. The helper automatically handles the loading of assets from the Vite development server in development
mode and from the built files in production mode.

#### Including Assets in Templates

<details>
  <summary>Vite Helper</summary>

```markdown
```js
input: {
  script: './src/js/script.js',
  style: './src/css/style.css',
  styleHome: './src/css/styleHome.css',
  animate: './src/styles/libs/animate.min.css',
  critical: './src/scss/critical.scss'
},
```

> **Important:**  
> These files must be listed in the `input` option of your `vite.config.js` configuration.  
> If you do not include them, Vite will not process or output these assets, and you may encounter errors when trying to
> load them in your templates.
> Except for those that are connected in modules

```
Use the `getAssetPath` method to include assets in your templates:

```php
<?php
use App\Helpers\Vite;
?>

<!-- CSS files -->
<link rel="stylesheet" href="<?= Vite::getAssetPath('src/css/style.css') ?>">
<link rel="stylesheet" href="<?= Vite::getAssetPath('src/styles/critical.scss') ?>">

<!-- JavaScript modules -->
<script type="module" src="<?= Vite::getAssetPath('src/js/modules/Menu.js') ?>"></script>
<script type="module" src="<?= Vite::getAssetPath('src/js/modules/utils/Toggle.js') ?>"></script>

<!-- Library CSS files -->
<link rel="stylesheet" href="<?= Vite::getAssetPath('src/styles/libs/animate.min.css') ?>">
```

#### Development vs Production

The Vite helper automatically detects whether the application is running in development or production mode based on the
`IS_DEV` constant defined in the `.env` file:

- In development mode (`IS_DEV=true`), assets are loaded from the Vite development server
- In production mode (`IS_DEV=false`), assets are loaded from the built files with hashed filenames

#### Supported Asset Types

The Vite helper supports various asset types:

- CSS files (e.g., `src/css/style.css`, `src/styles/libs/animate.min.css`)
- SCSS files (e.g., `src/scss/main.scss`, `src/scss/critical.scss`)
- JavaScript files (e.g., `src/js/modules/Menu.js`, `src/js/modules/utils/Toggle.js`)

</details>

---

## Experiment WGET

<details>
  <summary>Preparation</summary>

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

---

```bash
cd ~/projects/warriors

# stop docker, vite, live-server
docker-compose down
docker stop $(docker ps -aq)
kill-port 4173 5173 8080 9000 || true
```

disable development mode in .env

```
IS_DEV=false
```

```bash
# build (docker in background)
docker-compose up -d --build
composer install
composer dump-autoload -o
vite build
```

```bash
# Delete gh-pages/public/dist
rm -rf gh-pages/public

# Copy root as public
cp -a gh-pages/root gh-pages/public

# Copy dist to public
cp -r public/dist gh-pages/public/dist

# Delete .vite
rm -rf gh-pages/public/dist/.vite
```

```bash
# get the pages-html from http://localhost:8080/
wget --convert-links --adjust-extension --page-requisites --no-parent -P gh-pages/public -nH http://localhost:8080/contacts  http://localhost:8080/catalog  http://localhost:8080/404  http://localhost:8080
```

```bash
# stop Docker -d (detach mode)
docker stop $(docker ps -aq)
```

```bash
# Start local server 
live-server gh-pages/public --port=9000 --open=.
```

check the result at

```bash
# stop localhost
kill-port 4173 5173 8080 9000 || true
```

#### Additional Commands

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
# show list of processes
ps aux | grep live-server | grep -v grep
```

```bash
# username  113726 79.6  1.2 1033532 197504 pts/0  Sl+  00:09   0:07 node /usr/local/bin/live-server
kill 113726

# forcedly
kill -9 113726
```

or

```bash
kill-port 4173 5173 8080 9000 || true
```

</details>

### RUNNING WGET

> be in the root of the project

<details>
  <summary>inside</summary>


</details>

---

## Deploy to GitHub Pages

<details>
  <summary>Deployment</summary>

```bash
# creation `gh-pages`
cd ~/projects/warriors
mkdir -p gh-pages/root
# add 'gh-pages/' to the .gitignore 

cd gh-pages/root

git init
# add as SSH
git remote add origin git@github.com:ashuksu/warriors.git
git branch -m 'feature/GH-PAGES'

```

## DO RUNNING WGET

> In the Build and deployment block, set on github pages
> Source: `Deploy from a branch`
> Branch: select `feature/GH-PAGES`
> Folder: select `/ (root)`
> https://ashuksu.github.io/warriors/

```bash
touch .nojekyll .gitignore
# set up .gitignore
# add .gitignore and .nojekyll
git add . -f
git commit -m "Update GH-Pages build $(date +%F\ %T)"
git push -u origin feature/GH-PAGES --force
```

```bash
# Manual Publishing to GitHub Pages (after generation)
cd gh-pages/public
git add . -f
git commit -m "Update GH-Pages build $(date +%F\ %T)"
git push -u origin feature/GH-PAGES --force
```

---

### 'gh-pages' publishing

```bash
# Install gh-pages npm package
npm install gh-pages --save-dev
```

```
# -d deploy/public - is the path to the folder you want to upload.
"scripts": {
"preview:publish": "gh-pages -d gh-pages/public -b feature/GH-PAGES -m 'Update GH-Pages build $(date +%F\ %T)'"
}
```

**Explanation:**

* `-d deploy/public` — specifies the folder containing the built site.
* `-b feature/GH-PAGES` — specifies the branch to which the files will be pushed.
* `-m "Update GH-Pages build $(date +%F\ %T)"` — sets the commit message with the current date and time.

**Escaping:**

* Inside a JSON string, double quotes must be escaped as `\"`.
* Inside a Bash command, spaces in the `date` format must be escaped as `\ `, so it becomes `+%F\ %T`.

```bash
# Launch
npm run preview:publish
```

</details>

