# Deployment

⬅️ [Back to Home](../README.md)

➡️ [Make and Push branches | Preparation](#make-branches)

➡️ [Deploy to GitHub Pages](#deploy-to-github-pages)

---

## GitHub Pages

```bash
#init gitignore push-root
make gh-pages
```

## Detailed Steps

### Make branches

```bash
#init
make gh-pages-init
```

<details>
  <summary>alternative</summary>

```bash
# be in the root of the project
cd ~/projects/warriors
mkdir -p gh-pages/root  # creation `gh-pages`
cd gh-pages/root
git init
# add as SSH
git remote add origin git@github.com:ashuksu/warriors.git
git branch -m 'gh-pages'
```

```bash
# be in gh-pages/root 
cd ~/projects/warriors/gh-pages/root 
touch .nojekyll .gitignore
```

</details>

> The `gh-pages/` directory should be in main `.gitignore`

---

```bash
#set up gh-pages/root/.gitignore
make gh-pages-gitignore
```

> set up gh-pages/root/.gitignore <br/>
> this is the initial guide for .gitignore <br/>
> if you need something more - add it here and in the Makefile too

<details>
  <summary>.gitignore</summary>

```gitignore
# Node.js
node_modules/
npm-debug.log

# Vite
.vite/
*.local

# IDEs and editors
.idea/
.vscode/
*.sublime-workspace
*.sublime-project

# OS-specific files
.DS_Store
Thumbs.db

# Environment
.env

# Tests and vendors (if any)
test/
vendor/

#hide gh-pages from PRs
*
!important/dist/
!important/.gitignore
!important/.nojekyll
!important/404.html
!important/catalog.html
!important/contacts.html
!important/favicon.ico
!important/index.html
!important/robots.txt
```

</details>

---

### Push `gh-pages/root/` to GitHub (only once at first time)

```bash
#push root to GitHub
make gh-pages-ush-root
```

<details>
  <summary>.gitignore</summary>

```bash
# be in gh-pages/root 
cd ~/projects/warriors/gh-pages/root
git add . -f
git commit -m "Update GH-Pages build $(date +%F\ %T)"
git push -u origin gh-pages --force
```

</details>

### GitHub settings for GitHub Pages

> In the Build and deployment block, set on GitHub Pages
> Source: `Deploy from a branch`
> Branch: select `gh-pages`
> Folder: select `/ (root)`
> https://ashuksu.github.io/warriors/

## Deploy to GitHub Pages

⬆️ [Back to Top](#deployment)

⬅️ [Back to Home](../README.md)

---

Production mode:

```.env
IS_DEV=false
DOMAIN=your-domain.com
```

```bash
#generate static pages in public and push to gh-pages
make deploy
```

or

> first fill the `public` folder according to [WGET Usage](wget.md)

### Push `gh-pages/public/` to GitHub (every time after generating static pages in `public`)

```bash
#push public to GitHub
make gh-pages-ush-public
```

<details>
  <summary>.gitignore</summary>

```bash
# be in gh-pages/public 
cd ~/projects/warriors/gh-pages/public
git add . -f
git commit -m "Update GH-Pages build $(date +%F\ %T)"
git push -u origin gh-pages --force
```

</details>

---

⬆️ [Back to Top](#deployment)

⬅️ [Back to Home](../README.md)