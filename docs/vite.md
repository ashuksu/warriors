# Vite Usage

⬅️ [Back to Home](../README.md)

➡️ [Installation](#installation)

➡️ [Common Usage](#common-usage)

➡️ [Additional Commands](#additional-commands)

➡️ [Using the Vite Helper](#using-the-vite-helper)

---

## Installation

[Getting Started](https://vitejs.dev/guide/)

```bash

# installation vite
npm create vite@latest
```

```bash

# or globally
npm install -g vite
```

## Common Usage

⬆️ [Back to Top](#docker-usage)

⬅️ [Back to Home](../README.md)

---

```bash
# Start dev server
make vite
```

<details>
  <summary>alternative</summary>

```bash
vite
```

</details>

➡️️ [localhost:5173](http://localhost:5173)

```bash
# Start build
make vite-build
```

<details>
  <summary>alternative</summary>

```bash
vite build
```

</details>

```bash
# Preview
make vite-preview
```

<details>
  <summary>additionally</summary>

```bash
vite preview
```

</details>

➡️️ [localhost:4173](http://localhost:4173)

## Additional Commands

⬆️ [Back to Top](#vite-usage)

⬅️ [Back to Home](../README.md)

---

### How to stop ports

> How to stop Vite

<details>
  <summary>Kill Port</summary>

️️➡️ [Kill Port, NPM](https://www.npmjs.com/package/kill-port)

➡️ [Kill Port, GitHub](https://github.com/tiaanduplessis/kill-port)

---

```bash

# installation kill-port
npm install kill-port --save-dev
```

```bash 

# or globally
npm install -g kill-port
```

</details>

```bash
# Stop the port used by Vite
make vite-kill
```

<details>
  <summary>Kill Port</summary>

```bash
kill-port 4173 5173 || true
```

</details>

---

<details>
  <summary>Fuser (Linux only)</summary>

️️➡️ [Fuser](https://man7.org/linux/man-pages/man1/fuser.1.html)

---

```bash

# installation kill-port
sudo apt install psmisc
```

</details>

```bash

#Stop the port used by Vite(Linux only)
fuser -k 5173/tcp || true
```

---

```bash

# Find the PID of the process
lsof -i :5173
```

```bash

# Or alternatively (Find the PID)
netstat -tulpn | grep 5173
```

```bash

# Kill the process (replace <PID> with the process number from the previous command)
kill -9 <pid>
```

## Using the Vite Helper

⬆️ [Back to Top](#vite-usage)

⬅️ [Back to Home](../README.md)

---

The project includes a Vite helper class that simplifies asset management in both development and production
environments. The helper automatically handles the loading of assets from the Vite development server in development
mode and from the built files in production mode.

### Including Assets in Templates

```js

export default defineConfig({
    build: {
        input: {
            script: './src/js/script.js',
            style: './src/css/style.css',
            styleHome: './src/css/styleHome.css',
            animate: './src/styles/libs/animate.min.css',
            critical: './src/scss/critical.scss'
        }
    }
})
```

> **Important:**  
> These files must be listed in the `input` option of your `vite.config.js` configuration.  
> If you do not include them, Vite will not process or output these assets, and you may encounter errors when trying to
> load them in your templates.
> Except for those that are connected in modules

Use the `getPath` method to include assets in your templates:

```php

<?php
use App\Helpers\Vite;
?>
```

```php

<!-- CSS files -->
<link rel="stylesheet" href="<?= Vite::getPath('src/css/style.css') ?>">
<link rel="stylesheet" href="<?= Vite::getPath('src/styles/critical.scss') ?>">

<!-- JavaScript modules -->
<script type="module" src="<?= Vite::getPath('src/js/modules/Menu.js') ?>"></script>
<script type="module" src="<?= Vite::getPath('src/js/modules/utils/Toggle.js') ?>"></script>

<!-- Library CSS files -->
<link rel="stylesheet" href="<?= Vite::getPath('src/styles/libs/animate.min.css') ?>">
```

### Development vs Production

The Vite helper automatically detects whether the application is running in development or production mode based on the
`IS_DEV` constant defined in the `.env` file:

- In development mode (`IS_DEV=true`), assets are loaded from the Vite development server
- In production mode (`IS_DEV=false`), assets are loaded from the built files with hashed filenames

### Supported Asset Types

The Vite helper supports various asset types:

- CSS files (e.g., `src/css/style.css`, `src/styles/libs/animate.min.css`)
- SCSS files (e.g., `src/scss/main.scss`, `src/scss/critical.scss`)
- JavaScript files (e.g., `src/js/modules/Menu.js`, `src/js/modules/utils/Toggle.js`)

---

⬆️ [Back to Top](#vite-usage)

⬅️ [Back to Home](../README.md)