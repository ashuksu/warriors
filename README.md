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

## How to Switch Between Versions and View Them

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
    git checkout -b new-feature-for-old-design old-design-v1
    ```

</details>

By adhering to this structure, we ensure a clear separation between active development, current production, and
historical versions of the project.

---

## Установка

```bash
    npm install
```

## Способы запуска проекта

### PHP встроенный сервер

```bash
    npm run php
```

### Live Server

```bash
    # Установка Live Server глобально (если еще не установлен)
    sudo npm install -g live-server
```

```bash
    # Запуск Live Server
    npm run ls
```

## Docker

#### Предварительные требования

1. Установить [Docker](https://docs.docker.com/get-docker/) и [Docker Compose](https://docs.docker.com/compose/install/)

```bash
    # На Ubuntu/Debian можно установить gnome-terminal для удобства
    sudo apt install gnome-terminal
```

#### Docker команды

```bash
    # Запуск
    npm start
```

```bash
    # Перезапуск контейнера (работает с 'npm start')
    npm restart
```

```bash  
    # Остановка контейнера
    npm stop
```

```bash   
    # Пересборка Docker образа (если были внесены изменения в Dockerfile)
    npm run build
```

```bash
    # Мониторинг Docker контейнеров (может работать паралельно)
    npm run monitor
```

```bash 
    # Очистка неиспользуемых Docker ресурсов
    npm run clean
```

После запуска открыть в браузере http://localhost:8080