.PHONY: help install config \
        composer-install autoload autoload-o \
        up dev build prod-up prod \
        docker-kill docker-clean docker-monitor \
		vite-build vite-kill \
		deploy clean-project \
		wget wget-preparation wget-generation \
		gh-pages gh-pages-init gh-pages-gitignore \
		gh-pages-push-root gh-pages-push-public


# Path variables
ROOT_DIR		:= $(shell pwd)
PAGES_ROOT		:= $(ROOT_DIR)/gh-pages/root
PAGES_PUBLIC	:= $(ROOT_DIR)/gh-pages/public
APP_URL			:= http://localhost

# GitHub Pages URLs
GIT_REPO_SSH_URL	:= git@github.com:ashuksu/warriors.git
PROD_URL	:= https://ashuksu.github.io/warriors


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
	@echo '${GREEN}make config${RESET}              - Create .env from .env.example'
	@echo '${GREEN}make install${RESET}             - Install all project dependencies (Composer, NPM), build Docker images, and frontend assets.'
	@echo '${GREEN}make up${RESET}                  - Start development environment (Docker containers + Vite dev server) (optimized for deployment).'
	@echo '${GREEN}make dev${RESET}                 - Build and start development environment (Docker images + Vite dev server) (optimized for deployment).'
	@echo '${GREEN}make build${RESET}               - Build Docker images and frontend assets (optimized for deployment).'
	@echo '${GREEN}make prod${RESET}                - Build optimized production Docker images and frontend assets.'
	@echo '${GREEN}make prod-up${RESET}             - Build optimized production Docker images and start them.'
	@echo '${GREEN}make kill${RESET}                - Force stop all running Docker containers and Vite servers.'
	@echo '${GREEN}make clean-project${RESET}       - Remove all temporary files, dependencies, and Docker artifacts.'
	@echo
	@echo '${BLUE}=== Docker Commands ===${RESET}'
	@echo '${CYAN}make docker-kill${RESET}         - Stop Docker containers for the current project.'
	@echo '${CYAN}make docker-clean${RESET}        - Perform a complete Docker system cleanup (containers, images, volumes, networks, cache).'
	@echo '${CYAN}make docker-monitor${RESET}      - Launch a Docker container monitoring tool (ctop).'
	@echo
	@echo '${BLUE}=== Asset Commands ===${RESET}'
	@echo '${CYAN}make vite-build${RESET}          - Build optimized frontend assets for production.'
	@echo '${CYAN}make vite-kill${RESET}           - Stop the Vite development server and associated ports.'
	@echo
	@echo '${BLUE}=== Composer Commands ===${RESET}'
	@echo '${CYAN}make composer-install${RESET}    - Install PHP dependencies based on composer.lock.'
	@echo '${CYAN}make autoload${RESET}            - Update Composer autoloader (for development).'
	@echo '${CYAN}make autoload-o${RESET}          - Update Composer autoloader with optimization (for production).'
	@echo
	@echo '${BLUE}=== Deployment (GitHub Pages) ===${RESET}'
	@echo '${MAGENTA}make deploy${RESET}              - Build and deploy project to GitHub Pages.'
	@echo '${MAGENTA}make wget${RESET}                - Generate static site using wget and preview locally.'
	@echo '${MAGENTA}make gh-pages${RESET}            - Initialize GitHub Pages repository.'
	@echo '${YELLOW}  (See Makefile for more specific gh-pages commands)${RESET}'


# Environment setup
config:
	@echo '${BLUE}Setting up environment...${RESET}'
	@cd $(ROOT_DIR) && cp .env.example .env && echo '${GREEN}✔ .env copied from .env.example.${RESET}' || echo '${RED}Error: Failed to copy .env.example to .env.${RESET}'
	@echo '${MAGENTA}Please set up your environment variables in the .env file.${RESET}'


install: composer-install
	@echo '${BLUE}Installing NPM dependencies...${RESET}'
	@npm install && echo '${GREEN}✔ NPM dependency installation complete.${RESET}' || echo '${RED}Error: NPM dependency installation failed.${RESET}'
	@echo '${BLUE}Starting project build for initial setup...${RESET}'
	@make build
	@echo '${GREEN}✔ Initial project build completed.${RESET}'


# Development
up: kill autoload
	@echo '${BLUE}Starting Docker development environment at ${APP_URL}...${RESET}'
	@docker compose -f docker-compose.yml -f docker-compose-dev.yml up && echo '${GREEN}✔ Docker services are up.${RESET}' || echo '${RED}Error: Docker services failed to start.${RESET}'


dev: kill vite-build autoload
	@echo '${BLUE}Building and starting Docker development environment at ${APP_URL}...${RESET}'
	@docker compose -f docker-compose.yml -f docker-compose-dev.yml up --build && echo '${GREEN}✔ Docker services built and started.${RESET}' || echo '${RED}Error: Docker services failed to build and start.${RESET}'


# Build Production (optimized for deployment)
build: kill vite-build autoload-o
	@echo '${BLUE}Building optimized for deployment Docker images...${RESET}'
	@docker compose -f docker-compose.yml -f docker-compose-dev.yml build && echo '${GREEN}✔ Docker images built.${RESET}' || echo '${RED}Error: Docker image build failed.${RESET}'
	@echo '${GREEN}✔ Project build (optimized for deployment) completed (optimized autoloader, Vite assets, Docker images).${RESET}'

## Build Production (optimized for pprod)
prod: kill vite-build autoload-o
	@echo '${BLUE}Building optimized production Docker images...${RESET}'
	@docker compose build && echo '${GREEN}✔ Docker images built for production.${RESET}' || echo '${RED}Error: Docker image build failed.${RESET}'
	@echo '${GREEN}✔ Project build completed (optimized autoloader, Vite assets, Docker images)...${RESET}'

## Build Production (optimized for pprod) with Up
prod-up: kill vite-build autoload-o
	@echo '${BLUE}Building optimized production Docker images...${RESET}'
	@docker compose up --build && echo '${GREEN}✔ Docker production environment is up and running at ${APP_URL}!${RESET}' || echo '${RED}Error: Docker production environment failed to start.${RESET}'


# Kill services
kill: vite-kill docker-kill
	@echo '${GREEN}✔ All services stopped.${RESET}'


# Composer commands
composer-install:
	@echo '${BLUE}Installing Composer dependencies...${RESET}'
	@composer install && echo '${GREEN}✔ Composer dependency installation complete.${RESET}' || echo '${RED}Error: Composer dependency installation failed.${RESET}'

autoload:
	@echo '${BLUE}Updating Composer autoloader...${RESET}'
	@composer dump-autoload && echo '${GREEN}✔ Composer autoloader updated.${RESET}' || echo '${RED}Error: Composer autoloader update failed.${RESET}'

autoload-o:
	@echo '${BLUE}Updating optimized Composer autoloader...${RESET}'
	@composer dump-autoload -o && echo '${GREEN}✔ Optimized Composer autoloader updated.${RESET}' || echo '${RED}Error: Optimized Composer autoloader update failed.${RESET}'


# Docker commands
docker-kill:
	@echo '${BLUE}Stopping Docker services...${RESET}'
	@docker compose down && echo '${CYAN}Docker Compose services stopped.${RESET}' || echo '${YELLOW}⚠ Docker Compose services may not have been stopped.${RESET}'
	@docker ps -q | xargs -r docker stop && echo '${CYAN}Running containers not managed by Compose forcefully stopped.${RESET}' || echo '${YELLOW}⚠ No other running containers to stop.${RESET}'
	@docker network prune -f && echo '${CYAN}Docker networks pruned.${RESET}' || echo '${YELLOW}⚠ No Docker networks to prune or prune failed.${RESET}'
	@echo '${GREEN}✔ Docker services stopped.${RESET}'

docker-clean:
	@echo '${BLUE}Cleaning Docker system...${RESET}'
	@docker compose down --volumes --remove-orphans && echo '${CYAN}Docker Compose services, volumes, and orphans removed.${RESET}' || echo '${YELLOW}⚠ Docker Compose cleanup failed.${RESET}'
	@docker ps -qa | xargs -r docker rm -f && echo '${CYAN}All stopped and running containers forcefully removed.${RESET}' || echo '${YELLOW}⚠ No containers to remove.${RESET}'
	@docker images -qa | xargs -r docker rmi -f && echo '${CYAN}All Docker images forcefully removed.${RESET}' || echo '${YELLOW}⚠ No Docker images to remove or removal failed.${RESET}'
	@docker system prune -af --volumes && echo '${CYAN}Docker system pruned (images, containers, volumes, networks).${RESET}' || echo '${YELLOW}⚠ Docker system prune failed or nothing to prune.${RESET}'
	@docker builder prune -af && echo '${CYYAN}Docker build cache pruned.${RESET}' || echo '${YELLOW}⚠ No Docker build cache to prune or prune failed.${RESET}'
	@docker buildx prune -af && echo '${CYAN}Docker Buildx cache pruned.${RESET}' || echo '${YELLOW}⚠ No Docker Buildx cache to prune or prune failed.${RESET}'
	@docker network prune -f && echo '${CYAN}Docker networks pruned again (redundant for safety).${RESET}' || echo '${YELLOW}⚠ No Docker networks to prune or prune failed.${RESET}'
	@echo '${GREEN}✔ Docker system cleaned.${RESET}'

docker-monitor:
	@echo '${BLUE}Monitoring Docker containers (requires ctop image)...${RESET}'
	@docker run --rm -ti --name=ctop -v /var/run/docker.sock:/var/run/docker.sock quay.io/vektorlab/ctop:latest && echo '${GREEN}✔ ctop exited.${RESET}' || echo '${RED}Error: ctop failed to run or exited abnormally.${RESET}'


# Vite commands
vite-build:
	@echo '${BLUE}Starting Vite frontend assets build...${RESET}'
	@vite build && echo '${GREEN}✔ Vite build completed.${RESET}' || echo '${RED}Error: Vite build failed. Check Vite output above.${RESET}'

vite-kill:
	@echo '${BLUE}Stopping Vite development server and associated ports...${RESET}'
	@kill-port 4173 5173 8080 9000 || true
	@echo '${GREEN}✔ Ports 4173, 5173, 8080, 9000 killed.${RESET}'


# Cleaning
clean-project:
	@bash -c '\
    		echo "${MAGENTA}Would you like to ${RED}CLEAN? ${MAGENTA}(Y=yes, Any key=no)${RESET}"; \
    		read -n 1 -s key; \
    		if [[ "$$key" == "y" || "$$key" == "Y" || "$$key" == "н" || "$$key" == "Н" ]]; then \
    			echo -e "\r${GREEN}✔ Cleaning selected${RESET}"; \
    			make docker-clean; \
    			echo -e "\r${BLUE}Cleaning project files...${RESET}"; \
    			rm -rf public/dist && echo "${CYAN}Removed public/dist.${RESET}" || echo "${YELLOW}⚠ public/dist not found or failed to remove.${RESET}"; \
				rm -rf node_modules && echo "${CYAN}Removed node_modules.${RESET}" || echo "${YELLOW}⚠ node_modules not found or failed to remove.${RESET}"; \
				rm -rf vendor && echo "${CYAN}Removed vendor directory.${RESET}" || echo "${YELLOW}⚠ vendor directory not found or failed to remove.${RESET}"; \
				rm -rf gh-pages/public && echo "${CYAN}Removed gh-pages/public.${RESET}" || echo "${YELLOW}⚠ gh-pages/public not found or failed to remove.${RESET}"; \
				rm -rf .cache && echo "${CYAN}Removed .cache directory.${RESET}" || echo "${YELLOW}⚠ .cache directory not found or failed to remove.${RESET}"; \
    			echo -e "\r${GREEN}✔ Project files cleaned.${RESET}"; \
    		else \
    			echo -e "\r${YELLOW}Cleaning cancelled by user${RESET}"; \
    		fi \
    	'


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

wget-preparation: composer-install kill vite-build autoload-o
	@echo '${BLUE}Building optimized production Docker images...${RESET}'
	@docker compose up -d --build && echo '${GREEN}✔ Docker production environment is up and running at ${APP_URL} in background!${RESET}' || echo '${RED}Error: Docker production environment failed to start.${RESET}'
	@echo '${CYAN}Docker runs in background on ${APP_URL}.${RESET}'
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
		${APP_URL}/contacts \
		${APP_URL}/catalog \
		${APP_URL}/404 \
		${APP_URL}
	@echo '${GREEN}✔ WGET static files generated successfully${RESET}'


# GitHub Pages
gh-pages: gh-pages-init gh-pages-gitignore gh-pages-push-root
	echo "${YELLOW}Next steps:${RESET}" && \
	echo "${MAGENTA}1. Go to GitHub repository settings${RESET}" && \
	echo "${MAGENTA}2. In the Build and deployment block:${RESET}" && \
	echo "   ${CYAN}- Source: Deploy from a branch${RESET}" && \
	echo "   ${CYAN}- Branch: gh-pages${RESET}" && \
	echo "   ${CYAN}- Folder: / (root)${RESET}" && \
	echo "${GREEN}After enabling push, site will be available at: ${PROD_URL}${RESET}"

gh-pages-push-public:
	@echo "${BLUE}Deploying to GitHub Pages...${RESET}"
	@cd $(PAGES_PUBLIC) && \
	git add . -f && \
	git commit -m "Update GH-Pages build $(shell date +%F\ %T)" && \
	git push -u origin gh-pages --force && \
	echo "${GREEN}✔ Successfully deployed to GitHub Pages${RESET}" && \
	echo "${CYAN}Site will be available at: ${PROD_URL}${RESET}"

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

