.PHONY: help install config dev build deploy clean \
        pre-install autoload autoload-o \
        composer-install \
        docker-up docker-up-d docker-up--build docker-up-d--build \
        docker-build docker-restart docker-down docker-stop docker-rm \
        docker-clean docker-purge docker-destroy docker-monitor \
        vite vite-build vite-kill \
        wget wget-preparation wget-generation \
        gh-pages gh-pages-init gh-pages-gitignore \
        gh-pages-push-root gh-pages-push-public


# Path variables
ROOT_DIR    := $(shell pwd)
PAGES_ROOT:= $(ROOT_DIR)/gh-pages/root
PAGES_PUBLIC := $(ROOT_DIR)/gh-pages/public


# GitHub Pages URLs
GIT_REPO_SSH_URL	:= git@github.com:ashuksu/warriors.git
GITHUB_PAGES_URL    := https://ashuksu.github.io/warriors


# Output colors
BLACK   := $(shell tput -Txterm setaf 0) # Not commonly used (usually invisible on dark backgrounds)
RED     := $(shell tput -Txterm setaf 1) # Errors and failures — e.g. "✖ Build failed"
GREEN   := $(shell tput -Txterm setaf 2) # Success messages — e.g. "✔ Build completed"
YELLOW  := $(shell tput -Txterm setaf 3) # Warnings or caution messages or non-critical issues — e.g. "⚠ Deprecated option used", "⚠ Using fallback config", "⚠ Feature X is disabled", "Action skipped"
BLUE    := $(shell tput -Txterm setaf 4) # Section headers or major steps, draws attention to what step is happening. — e.g. "==> Running tests"
MAGENTA := $(shell tput -Txterm setaf 5) # User prompts or input notices, is used when the script requires or expects something from the user, emphasizes manual actions — e.g. "Enter your project name:", '"Y/n'"
CYAN    := $(shell tput -Txterm setaf 6) # Informational messages or commands, shows commands being executed, descriptions, what the script is doing — e.g. "i Installing dependencies..."
WHITE   := $(shell tput -Txterm setaf 7) # Plain text (default)
RESET   := $(shell tput -Txterm sgr0)    # Reset to default color


# Help
help:
	@echo '${BLUE}=== Core Commands ===${RESET}'
	@echo '${GREEN}make install${RESET}         - Install dependencies, setup env, build Docker and Vite'
	@echo '${GREEN}make config${RESET}          - Create .env from .env.example'
	@echo '${GREEN}make dev${RESET}             - Start development environment (Docker + Vite)'
	@echo '${GREEN}make build${RESET}           - Build project for production (Vite + Docker)'
	@echo '${GREEN}make stop${RESET}            - Stop development services'
	@echo '${GREEN}make kill${RESET}            - Force stop all services and ports'
	@echo '${GREEN}make clean${RESET}           - Remove all temporary files and dependencies'
	@echo
	@echo '${BLUE}=== Docker Commands ===${RESET}'
	@echo '${CYAN}make docker-up${RESET}        - Start Docker containers'
	@echo '${CYAN}make docker-up-d${RESET}      - Start Docker in background'
	@echo '${CYAN}make docker-build${RESET}     - Build Docker image'
	@echo '${CYAN}make docker-down${RESET}      - Stop Docker containers'
	@echo '${CYAN}make docker-destroy${RESET}   - Complete Docker cleanup'
	@echo '${CYAN}make docker-monitor${RESET}   - Monitor Docker containers'
	@echo
	@echo '${BLUE}=== Asset Commands ===${RESET}'
	@echo '${CYAN}make vite${RESET}             - Start Vite dev server'
	@echo '${CYAN}make vite-build${RESET}       - Build frontend assets'
	@echo '${CYAN}make vite-kill${RESET}        - Stop Vite server'
	@echo
	@echo '${BLUE}=== Composer Commands ===${RESET}'
	@echo '${CYAN}make composer-install${RESET}  - Install PHP dependencies'
	@echo '${CYAN}make autoload${RESET}         - Update composer autoloader'
	@echo '${CYAN}make autoload-o${RESET}       - Update optimized autoloader'
	@echo
	@echo '${BLUE}=== Deployment ===${RESET}'
	@echo '${MAGENTA}make deploy${RESET}          - Build and deploy to GitHub Pages'
	@echo '${MAGENTA}make wget${RESET}            - Generate static site and preview'
	@echo '${MAGENTA}make gh-pages${RESET}        - Initialize GitHub Pages repository'
# Environment setup
config:
	@echo '${BLUE}Setting up environment...${RESET}'
	@cd $(ROOT_DIR) && cp .env.example .env
	@echo '${GREEN}✔ .env copied${RESET}'
	@echo '${MAGENTA}Set up the environment in .env${RESET}'


# Install dependencies
pre-install: docker-destroy kill composer-install
	@echo '${BLUE}Installing dependencies...${RESET}'
	npm install
	@echo '${GREEN}✔ Dependency installation complete${RESET}'

install:  pre-install
	@echo '${GREEN}✔ Project installation completed (dependencies)${RESET}'
	echo "${MAGENTA}You can now:${RESET}"; \
	echo "- ${YELLOW}make vite-build${RESET}		to start Vite-build for preparing images (long process)"; \
	echo "- ${YELLOW}make docker-up--build${RESET}	to start docker-build (run in parallel terminal)"; \
	echo "- ${YELLOW}make vite${RESET}		to start frontend server (run in parallel terminal)"; \

install-async: pre-install
	@echo '${GREEN}✔ Project installation completed (dependencies)${RESET}'
	@echo '${BLUE}Starting building...${RESET}'
	@echo '${CYAN}Starting Vite building...${RESET}'
	@gnome-terminal --tab --title="Vite-build" -- make vite-build || \
	xterm -e "make vite-build" || \
	open -a Terminal.app make vite-build || \
	start cmd /k make vite-build || \
	echo '${RED}Could not open new terminal. Run manually:${RESET}\nmake vite-build'
	@echo '${CYAN}Starting Docker building on http://localhost:8080/...${RESET}'
	@gnome-terminal --tab --title="Docker" -- make docker-up--build || \
	xterm -e "make docker-up--build" || \
	open -a Terminal.app make docker-up--build || \
	start cmd /k make docker-up--build || \
	echo '${RED}Could not open new terminal. Run manually:${RESET}\nmake docker-up--build'
	@echo '${CYAN}Starting Vite server...${RESET}'
	@make vite
	@echo '${GREEN}✔ Project installation completed (dependencies, Docker, Vite)...${RESET}'

# Development
dev:
	@echo '${BLUE}Starting development environment...${RESET}'
	@echo '${CYAN}Starting Docker on http://localhost:8080/...${RESET}'
	@gnome-terminal --tab --title="Docker" -- make docker-up || \
	xterm -e "make docker-up" || \
	open -a Terminal.app make docker-up || \
	start cmd /k make docker-up || \
	echo '${RED}Could not open new terminal. Run manually:${RESET}\nmake docker-up'
	@echo '${CYAN}Starting Vite server...${RESET}'
	@make vite

# Build
build: vite-build docker-build
	@echo '${GREEN}✔ Project build completed (optimized autoloader, Vite assets, Docker image)...${RESET}'


# Stop
stop: docker-down vite-kill
	@echo '${GREEN}✔ Development services stopped (Docker, Vite server)...${RESET}'

kill: stop docker-stop docker-rm
	@echo '${BLUE}Stopping all services (Docker containers, Vite, ports 4173, 5173 and 8080, 9000)...${RESET}'
	kill-port 8080 9000 || true
	@echo '${GREEN}✔ All services stopped, additional ports: 8080, 9000 destroyed.${RESET}'


# Composer
composer-install:
	@echo '${BLUE}Installing Composer dependencies...${RESET}'
	composer install

autoload:
	@echo '${BLUE}Updating composer autoloader...${RESET}'
	composer dump-autoload

autoload-o:
	@echo '${BLUE}Updating optimized composer autoloader...${RESET}'
	yes | composer dump-autoload -o

# Cleaning
clean: docker-destroy
	@echo '${BLUE}Cleaning project...${RESET}'
	@rm -rf public/dist || true
	@rm -rf node_modules || true
	@rm -rf vendor || true
	@rm -rf gh-pages/public || true
	@rm -rf .cache || true
	@echo '${GREEN}✔ Project cleaned${RESET}'

# Docker commands
docker-up: autoload
	@echo '${BLUE}Starting Docker on http://localhost:8080/...${RESET}'
	docker-compose up

docker-up-d: autoload
	@echo '${BLUE}Starting Docker in background...${RESET}'
	docker-compose up -d
	@echo '${CYAN}Docker runs in the background on http://localhost:8080/${RESET}'

docker-up--build: autoload-o
	@echo '${BLUE}Building Docker image and Starting Docker on http://localhost:8080/...${RESET}'
	docker-compose up --build

docker-up-d--build: autoload-o
	@echo '${BLUE}Building Docker image and Starting Docker in background...${RESET}'
	docker-compose up -d --build
	@echo '${GREEN}Docker building complete.${RESET}'
	@echo '${CYAN}Docker runs in background on http://localhost:8080/${RESET}'

docker-build: autoload-o
	@echo '${BLUE}Building Docker image...${RESET}'
	docker-compose build
	@echo '${GREEN}✔ Docker building complete${RESET}'

docker-restart:
	@echo '${BLUE}Restarting Docker...${RESET}'
	docker-compose restart
	@echo '${GREEN}✔ Docker restarted. Visit http://localhost:8080/${RESET}'

docker-down:
	@echo '${BLUE}Stopping and removing Docker resources...${RESET}'
	docker-compose down || true
	@echo '${GREEN}✔ Docker resources stopped${RESET}'

docker-stop:
	@echo '${BLUE}Stopping Docker services...${RESET}'
	@docker ps -q | xargs -r docker stop || true
	@echo '${GREEN}✔ Docker services stopped${RESET}'

docker-rm:
	@echo '${BLUE}Removing stopped containers...${RESET}'
	@docker ps -aq | xargs -r docker rm || true
	@echo '${GREEN}✔ Stopped containers have been removed${RESET}'

docker-clean: docker-down
	@echo '${BLUE}Cleaning Docker system...${RESET}'
	docker system prune -af
	@echo '${GREEN}✔ Docker system cleaned${RESET}'

docker-purge: docker-down
	@echo '${BLUE}Performing complete Docker cleanup...${RESET}'
	@docker system prune -af && echo '${CYAN}System pruned${RESET}' || echo '${YELLOW}⚠ No system resources to prune${RESET}'
	@docker volume prune -f && echo '${CYAN}Volumes pruned${RESET}' || echo '${YELLOW}⚠ No volumes to prune${RESET}'
	@docker network prune -f && echo '${CYAN}Networks pruned${RESET}' || echo '${YELLOW}⚠ No networks to prune${RESET}'
	@docker images "warriors_web" -q | xargs -r docker rmi || echo '${YELLOW}⚠ No warriors_web image found${RESET}'
	@echo '${GREEN}✔ Docker cleanup completed${RESET}'

docker-destroy: docker-down docker-stop docker-rm docker-purge
	@echo '${CYAN}Destroying Docker environment (containers, images, volumes, networks)...${RESET}'
	@echo '${GREEN}✔ Destroying Docker completed.${RESET}'

docker-monitor:
	@echo '${BLUE}Monitoring Docker containers...${RESET}'
	docker run --rm -ti --name=ctop -v /var/run/docker.sock:/var/run/docker.sock quay.io/vektorlab/ctop:latest


# Vite commands
vite:
	@echo '${BLUE}Starting Vite development server on http://localhost:5173/...${RESET}'
	vite

vite-build:
	@echo '${BLUE}Starting Vite building...${RESET}'
	vite build

vite-kill:
	@echo '${BLUE}Killing Vite server on ports 4173, 5173...${RESET}'
	kill-port 4173 5173 || true
	@echo '${GREEN}✔ Vita server stopped, ports: 4173, 5173 destroyed.${RESET}'


# Deployment to GitHub Pages
deploy: wget
	@bash -c '\
		echo "${MAGENTA}Would you like to deploy? (Enter=yes, Any key=no)${RESET}"; \
		read -n 1 -s key; \
		if [[ -z "$$key" ]]; then \
			make kill; \
			echo -e "\r${GREEN}✔ Deploy selected${RESET}"; \
			make gh-pages-push-public; \
		else \
			make kill; \
			echo -e "\r${YELLOW}Deploy cancelled by user${RESET}"; \
			echo "${MAGENTA}You can now:${RESET}"; \
			echo "- ${YELLOW}make deploy${RESET} to push to GitHub Pages"; \
		fi \
	'


# WGET commands
wget: wget-preparation wget-generation
	@echo "${GREEN}Generation completed successfully${RESET}"
	@echo "${BLUE}Starting preview server...${RESET}"
	@live-server gh-pages/public --port=9000 --open=. > /dev/null 2>&1 &
	@echo "${CYAN}Preview server running on http://localhost:9000${RESET}"

wget-preparation: kill composer-install vite-build docker-up-d--build
	@vite & sleep 3
	@echo '${CYAN}Vite runs in the background on http://localhost:5173${RESET}'
	@echo "${MAGENTA}To stop all services, copy and run: ${WHITE}make kill${RESET}"
	@echo '${GREEN}✔ All services started${RESET}'
	@echo
	@echo '${BLUE}Preparing project for WGET...${RESET}'
	@cd $(ROOT_DIR) && \
	if [ ! -d "gh-pages/root" ]; then \
		echo '${RED}Error: gh-pages/root/ not found${RESET}'; \
		echo '${MAGENTA}See docs/deployment.md for Git branch setup${RESET}'; \
		exit 1; \
	fi && \
	if [ ! -f "gh-pages/root/.gitignore" ] || [ ! -f "gh-pages/root/.nojekyll" ]; then \
		echo '${RED}Error: Missing required files in gh-pages/root/${RESET}'; \
		echo '${MAGENTA}See docs/deployment.md for Git branch setup${RESET}'; \
		exit 1; \
	fi && \
	if [ ! -d "public/dist" ]; then \
		echo '${YELLOW}⚠ Warning: public/dist not found. Running vite build...${RESET}' && \
		make vite-build; \
	fi && \
	rm -rf gh-pages/public || { echo '${RED}Failed to delete gh-pages/public${RESET}'; exit 1; } && \
	mkdir -p gh-pages/public || { echo '${RED}Failed to create gh-pages/public${RESET}'; exit 1; } && \
	cp -a gh-pages/root/. gh-pages/public/ || { echo '${RED}Failed to copy root files${RESET}'; exit 1; } && \
	cp -r public/dist gh-pages/public/ || { echo '${RED}Failed to copy dist files${RESET}'; exit 1; } && \
	rm -rf gh-pages/public/dist/.vite 2>/dev/null && echo '${CYAN}Cleaned: .vite directory${RESET}' || true && \
	echo '${GREEN}✔ WGET preparation completed successfully${RESET}' && \
	echo '${BLUE}Summary of operations:${RESET}' && \
	echo '${CYAN}- Removed: gh-pages/public/${RESET}' && \
	echo '${CYAN}- Created: gh-pages/public/${RESET}' && \
	echo '${CYAN}- Copied: gh-pages/root/ -> gh-pages/public/${RESET}' && \
	echo '${CYAN}- Copied: public/dist/ -> gh-pages/public/dist/${RESET}' && \
	echo '${CYAN}- Cleaned: gh-pages/public/dist/.vite${RESET}'

wget-generation:
	@echo '${BLUE}Starting WGET static files generation...${RESET}'
	@wget --convert-links --adjust-extension --page-requisites --no-parent -P gh-pages/public -nH \
		http://localhost:8080/contacts \
		http://localhost:8080/catalog \
		http://localhost:8080/404 \
		http://localhost:8080
	@echo '${GREEN}✔ WGET static files generated successfully${RESET}'


# GitHub Pages
gh-pages: gh-pages-init gh-pages-gitignore gh-pages-push-root
	echo "${YELLOW}Next steps:${RESET}" && \
	echo "${MAGENTA}1. Go to GitHub repository settings${RESET}" && \
	echo "${MAGENTA}2. In the Build and deployment block:${RESET}" && \
	echo "   ${CYAN}- Source: Deploy from a branch${RESET}" && \
	echo "   ${CYAN}- Branch: gh-pages${RESET}" && \
	echo "   ${CYAN}- Folder: / (root)${RESET}" && \
	echo "${GREEN}After enabling push, site will be available at: ${GITHUB_PAGES_URL}${RESET}"

gh-pages-push-public:
	@echo "${BLUE}Deploying to GitHub Pages...${RESET}"
	@cd $(PAGES_PUBLIC) && \
	git add . -f && \
	git commit -m "Update GH-Pages build $(shell date +%F\ %T)" && \
	git push -u origin gh-pages --force && \
	echo "${GREEN}✔ Successfully deployed to GitHub Pages${RESET}" && \
	echo "${CYAN}Site will be available at: ${GITHUB_PAGES_URL}${RESET}"

gh-pages-push-root:
	@echo "${BLUE}Pushing to GitHub Pages...${RESET}"
	@cd $(PAGES_ROOT) && \
	git add . -f && \
	git commit -m "Update GH-Pages build $(shell date +%F\ %T)" && \
	git push -u origin gh-pages --force && \
	echo "${GREEN}✔ Changes successfully pushed to gh-pages${RESET}" && \

gh-pages-init:
	@echo "${BLUE}Initializing GitHub Pages repository...${RESET}"
	@cd $(ROOT_DIR) && mkdir -p gh-pages/root && \
	cd gh-pages/root && \
	touch .nojekyll .gitignore && \
	git init && \
	git remote add origin $(GIT_REPO_SSH_URL) && \
	git branch -m 'gh-pages' && \
	echo "${GREEN}✔ GitHub Pages repository initialized${RESET}" && \
	echo "${MAGENTA}Note: Make sure gh-pages/ is in your main .gitignore${RESET}"

gh-pages-gitignore:
	@echo "${BLUE}Creating .gitignore for GitHub Pages...${RESET}"
	@cd $(ROOT_DIR) && mkdir -p gh-pages/root
	@echo "${CYAN}Filling .gitignore file...${RESET}"
	@echo "# Node.js" > $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "node_modules/" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "npm-debug.log" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "# Vite" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo ".vite/" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "*.local" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "# IDEs and editors" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo ".idea/" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo ".vscode/" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "*.sublime-workspace" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "*.sublime-project" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "# OS-specific files" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo ".DS_Store" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "Thumbs.db" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "# Environment" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo ".env" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "# Tests and vendors" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "test/" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "vendor/" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "# Hide gh-pages from PRs" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "*" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "!important/dist/" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "!important/.gitignore" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "!important/.nojekyll" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "!important/404.html" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "!important/catalog.html" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "!important/contacts.html" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "!important/favicon.ico" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "!important/index.html" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "!important/robots.txt" >> $(ROOT_DIR)/gh-pages/root/.gitignore
	@echo "${GREEN}✔ .gitignore successfully created in gh-pages/root/${RESET}"

