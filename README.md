# [WARRIORS](https://ashuksu.github.io/warriors/public)

<details>
  <summary>Click, to show Preview</summary>


![WARRIORS](https://raw.githubusercontent.com/ashuksu/warriors/refs/heads/main/preview.jpg)
</details>

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