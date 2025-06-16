SHELL := /bin/bash

.PHONY: help up down restart up-prod down-prod build-prod restart-prod db-seed migrate seed clean destroy \
	env composer npm dev exec-php exec-vite monitor \
    deploy wget wget-preparation gh-pages-deploy live-server-kill \
    gh-pages gh-pages-push-public gh-pages-push-root gh-pages-init gh-pages-gitignore

# Configuration
DEV_COMPOSE_ARGS := -f docker-compose.yml -f docker-compose-dev.yml
PROD_COMPOSE_ARGS := -f docker-compose.yml

# Path variables
ROOT_DIR			:= $(shell pwd)
PUBLIC				:= $(ROOT_DIR)/public
PAGES_ROOT			:= $(ROOT_DIR)/gh-pages/root
PAGES_PUBLIC		:= $(ROOT_DIR)/gh-pages/public
APP_URL				:= http://localhost

# GitHub Pages URLs
GIT_REPO_SSH_URL	:= git@github.com:ashuksu/warriors.git
PROD_URL	:= https://ashuksu.github.io/warriors

# Colors for output
BLUE := $(shell tput -Txterm setaf 4)
GREEN := $(shell tput -Txterm setaf 2)
YELLOW := $(shell tput -Txterm setaf 3)
CYAN := $(shell tput -Txterm setaf 6)
RED := $(shell tput -Txterm setaf 1)
RESET := $(shell tput -Txterm sgr0)

# Default target
help:
	@echo '${BLUE}Usage:${RESET}'
	@echo '  ${YELLOW}make [command]${RESET}'
	@echo ''
	@echo '${BLUE}Development Commands:${RESET}'
	@echo '  ${GREEN}make up${RESET}                 - Start development environment (builds images if necessary).'
	@echo '  ${GREEN}make down${RESET}               - Stop development environment.'
	@echo '  ${GREEN}make restart${RESET}            - Restart development environment.'
	@echo '  ${GREEN}make exec-php${RESET}           - Get a shell inside the PHP container (dev).'
	@echo '  ${GREEN}make exec-vite${RESET}          - Get a shell inside the Vite helper container (dev).'
	@echo '  ${GREEN}make dev [...ARGS]${RESET}      - Start development environment with custom arguments (e.g., "make dev ARGS="up --build"").'
	@echo '  ${GREEN}make composer [...args]${RESET} - Run any Composer command (e.g., "make composer require laravel/pint").'
	@echo '  ${GREEN}make npm [...args]${RESET}      - Run any NPM command (e.g., "make npm install lodash").'
	@echo '  ${GREEN}make monitor${RESET}            - Monitor Docker containers (requires ctop image).'
	@echo '  ${GREEN}make db-seed${RESET}            - Run the database seeding script to create schema and initial data.'
	@echo '  ${GREEN}make migrate${RESET}            - Apply new database migrations.'
	@echo '  ${GREEN}make seed${RESET}               - Populate the database with initial data.'
	@echo ''
	@echo '${BLUE}Production Commands:${RESET}'
	@echo '  ${YELLOW}make build-prod${RESET}         - Build final, optimized production images.'
	@echo '  ${YELLOW}make up-prod${RESET}            - Start production environment in detached mode.'
	@echo '  ${YELLOW}make down-prod${RESET}          - Stop production environment.'
	@echo '  ${YELLOW}make restart-prod${RESET}       - Restart production environment (builds, stops, then starts).'
	@echo ''
	@echo '${BLUE}Static Site Generation & Deployment Commands (GitHub Pages):${RESET}'
	@echo '  ${CYAN}make deploy${RESET}             - Generate static site via Wget, then optionally deploy to GitHub Pages.'
	@echo '  ${CYAN}make wget-preparation${RESET}   - Prepare environment (build/up prod) for static site generation.'
	@echo '  ${CYAN}make wget${RESET}               - Generate static HTML files using Wget from the running prod env.'
	@echo '  ${CYAN}make live-server${RESET}        - Start a local preview server for the generated static site.'
	@echo '  ${CYAN}make live-server-kill${RESET}   - Stop the local preview server.'
	@echo '  ${CYAN}make gh-pages${RESET}           - Overall target: Initialize GH Pages repo, create .gitignore, push root files.'
	@echo '  ${CYAN}make gh-pages-init${RESET}      - Initialize the GitHub Pages repository structure.'
	@echo '  ${CYAN}make gh-pages-gitignore${RESET} - Create a .gitignore file for the GitHub Pages directory.'
	@echo '  ${CYAN}make gh-pages-push-root${RESET} - Push initial root files to the GitHub Pages branch.'
	@echo '  ${CYAN}make gh-pages-push-public${RESET} - Deploy the generated public static files to GitHub Pages.'
	@echo ''
	@echo '${BLUE}Utility Commands:${RESET}'
	@echo '  ${RED}make clean${RESET}              - Stop all services and remove project-related containers, networks, and volumes (dev & prod).'
	@echo '  ${RED}make destroy${RESET}            - Purge ALL Docker system resources (containers, images, volumes, cache not in use) - USE WITH EXTREME CAUTION!'
	@echo '  ${YELLOW}make env${RESET}                - Copy .env.example to .env (if it doesn''t exist).'
# Development Targets

# Start development environment (and build if needed)
up: env
	@echo '${BLUE}Starting development environment...${RESET}'
	@docker compose $(DEV_COMPOSE_ARGS) up --build

# Stop development environment
down:
	@echo '${BLUE}Stopping development environment...${RESET}'
	@docker compose $(DEV_COMPOSE_ARGS) down

# Restart development environment
restart:
	@$(MAKE) down
	@$(MAKE) up

# Starts production environment using existing images and volumes
up-prod:
	@echo '${BLUE}Starting production environment in detached mode...${RESET}'
	@docker compose $(PROD_COMPOSE_ARGS) up -d

# Stop production environment
down-prod:
	@echo '${BLUE}Stopping production services...${RESET}'
	@docker compose $(PROD_COMPOSE_ARGS) down --remove-orphans

# Build final, optimized production images
build-prod:
	@echo '${BLUE}Building final, optimized production images (using cache)...${RESET}'
	@$(MAKE) npm run build || echo "${RED}Some issues with ${YELLOW}'make npm run build'.${RESET}"
	@docker compose $(PROD_COMPOSE_ARGS) build

# Restart production environment
restart-prod: build-prod down-prod up-prod
	@echo '${GREEN}✔ Fresh production deployment complete.${RESET}'

# --- Database Commands ---

# Apply database migrations
migrate:
	@echo "${BLUE}Running database migrations...${RESET}"
	@docker compose $(DEV_COMPOSE_ARGS) exec php sh -c "composer dump-autoload && ./vendor/bin/phinx migrate -c phinx.php"

# Seed database
seed:
	@echo "${BLUE}Running database seeder...${RESET}"
	@docker compose $(DEV_COMPOSE_ARGS) exec php ./vendor/bin/phinx seed:run -c phinx.php

# Create a new migration `make create-migration name=MigrationName`
create-migration:
	@echo "${BLUE}Running database creating new migrations...${RESET}"
	@docker compose $(COMPOSE_ARGS) exec php ./vendor/bin/phinx create $(name) -c phinx.php

# --- DANGER ZONE ---

# Stop and remove all containers, networks, and VOLUMES for this project
clean:
	@echo '${RED}WARNING: This will remove all containers, networks, and project volumes!${RESET}'
	@read -p "Are you sure? [y/N] " ans && [ $${ans:-N} = y ] || (echo "Cancelled." && exit 1)
	@docker compose $(DEV_COMPOSE_ARGS) down -v --remove-orphans 2>/dev/null || true
	@docker compose $(PROD_COMPOSE_ARGS) down -v --remove-orphans 2>/dev/null || true
	@echo '${GREEN}✔ Project cleanup complete.${RESET}'

# DANGER: Prune ALL Docker system resources (containers, images, volumes, cache not in use, etc.)
# USE WITH EXTREME CAUTION! This removes all Docker resources on your system, not just project-specific ones.
destroy:
	@$(MAKE) clean
	@echo; \
	echo "${RED}███ DANGER ZONE! ███"; \
	echo "${YELLOW}This will purge ALL unused Docker resources on your system, not just for this project.${RESET}"; \
	read -p "Are you absolutely sure you want to proceed? [y/N] " ans && [ $${ans:-N} = y ] || (echo "Cancelled." && exit 1)
	@echo "${BLUE}Starting system-wide Docker prune...${RESET}"
	@docker compose down --volumes --remove-orphans && echo "${CYAN}Docker Compose services, volumes, and orphans removed.${RESET}" || echo "${YELLOW}⚠ Docker Compose cleanup failed.${RESET}"
	@docker ps -qa | xargs -r docker rm -f && echo "${CYAN}All stopped and running containers forcefully removed.${RESET}" || echo "${YELLOW}⚠ No containers to remove.${RESET}"
	@docker images -qa | xargs -r docker rmi -f && echo "${CYAN}All Docker images forcefully removed.${RESET}" || echo "${YELLOW}⚠ No Docker images to remove or removal failed.${RESET}"
	@docker system prune -af --volumes && echo "${CYAN}Docker system pruned (images, containers, volumes, networks).${RESET}" || echo "${YELLOW}⚠ Docker system prune failed or nothing to prune.${RESET}"
	@docker builder prune -af && echo "${CYAN}Docker build cache pruned.${RESET}" || echo "${YELLOW}⚠ No Docker build cache to prune or prune failed.${RESET}"
	@docker buildx prune -af && echo "${CYAN}Docker Buildx cache pruned.${RESET}" || echo "${YELLOW}⚠ No Docker Buildx cache to prune or prune failed.${RESET}"
	@docker network prune -f && echo "${CYAN}Docker networks pruned again (redundant for safety).${RESET}" || echo "${YELLOW}⚠ No Docker networks to prune or prune failed.${RESET}"
	@echo "${GREEN}✔ Docker system prune complete.${RESET}"

# Helper Targets & Proxies

# Create .env file from .env.example if it doesn't exist
env:
	@if [ ! -f .env ]; then \
		echo '${BLUE}Creating .env file...${RESET}'; \
		cp .env.example .env; \
		echo '${GREEN}✔ .env file created. Please review and customize it.${RESET}'; \
	fi

# Run a Composer command (e.g., make composer require laravel/sanctum)
composer:
	@echo '${CYAN}Running: composer $(filter-out $@,$(MAKECMDGOALS))${RESET}'
	@docker compose $(DEV_COMPOSE_ARGS) run --rm php composer $(filter-out $@,$(MAKECMDGOALS))

# Run an NPM command (e.g., make npm install)
npm:
	@echo '${CYAN}Running: npm $(filter-out $@,$(MAKECMDGOALS))${RESET}'
	@docker compose $(DEV_COMPOSE_ARGS) run --rm vite npm $(filter-out $@,$(MAKECMDGOALS))

# This allows running 'make dev ARGS="build --no-cache"' or 'make dev ARGS="up -d --build"'
dev: env
	@echo '${BLUE}Starting development environment with custom arguments...${RESET}'
	@docker compose $(DEV_COMPOSE_FILES) $(ARGS)

# Production Targets

# Get a shell inside the PHP container
exec-php:
	@echo '${BLUE}Entering PHP container shell...${RESET}'
	@docker compose $(DEV_COMPOSE_ARGS) exec php sh

# Get a shell inside the Vite container
exec-vite:
	@echo '${BLUE}Entering Vite container shell...${RESET}'
	@docker compose $(DEV_COMPOSE_ARGS) exec vite sh

monitor:
	@echo '${BLUE}Monitoring Docker containers (requires ctop image)...${RESET}'
	@docker run --rm -ti --name=ctop -v /var/run/docker.sock:/var/run/docker.sock quay.io/vektorlab/ctop:latest && echo '${GREEN}✔ ctop exited.${RESET}' || echo '${RED}Error: ctop failed to run or exited abnormally.${RESET}'

# Catch-all for undefined targets to prevent errors and show help
#%::
	@#echo "Target '$@' not defined."
	@#$(MAKE) help

# Static Site Generation & Deployment

# Deployment
deploy: wget-preparation wget
	@echo '${BLUE}Deployment Decision${RESET}'
	@echo
	@bash -c '\
		echo "${YELLOW}Would you like to deploy the generated static site to GitHub Pages?${RESET}"; \
		echo ; \
		echo "${CYAN}Press: ${YELLOW}Enter=yes, Any other key=no${RESET}"; \
		read -n 1 -s key; \
		if [[ -z "$$key" ]]; then \
			printf "\r${GREEN}✔ Deploy selected.${RESET}\n"; \
			make live-server-kill; \
			make down; \
			make gh-pages-push-public; \
			echo "${CYAN}${GREEN}✔ Static site generation and deployment process completed!${RESET}"; \
		else \
			printf "\r${YELLOW}Deploy cancelled by user.${RESET}\n"; \
			make live-server-kill; \
			make down; \
			echo "${CYAN}${GREEN}✔ Static site generation!${RESET}"; \
			echo "${CYAN}You can now manually deploy by running: ${YELLOW}make gh-pages-push-public${RESET}"; \
		fi \
	'

# Static Generation
wget:
	@echo '${BLUE}Static Generation: WGET process${RESET}'
	@cd $(ROOT_DIR)
	@echo '${BLUE}Starting WGET static files generation...${RESET}'
	@wget --convert-links --adjust-extension --page-requisites --no-parent --output-file=logs/wget.log -P gh-pages/public -nH \
			${APP_URL}/contacts \
			${APP_URL}/catalog \
			${APP_URL}/404 \
			${APP_URL} || echo "${RED}WGET failed. Check logs/wget.log for details.${RESET}"
	@echo '${GREEN}✔ WGET static files generated successfully in "$(PAGES_PUBLIC)" directory.${RESET}'
	@echo '${CYAN}WGET log saved to logs/wget.log${RESET}'
	@$(MAKE) live-server || echo "${RED}Can't start live-server${RESET}"

# Static Preparation
wget-preparation: down build-prod up-prod
	@echo '${GREEN}✔ Docker production environment is up and running at ${APP_URL} in background!${RESET}'
	@$(MAKE) npm run build || echo "${RED}Some issues with ${YELLOW}'make npm run build'.${RESET}"
	@echo '${GREEN}✔ Production assets built.${RESET}'
	@echo '${BLUE}Preparation: cleaning and copying static files...${RESET}'
	@cd $(ROOT_DIR) && \
	if [ ! -d "$(PAGES_ROOT)" ]; then \
		echo '${RED}Error: $(PAGES_ROOT) not found.${RESET}'; \
		echo '${YELLOW}See docs/deployment.md for Git branch setup.${RESET}'; \
		exit 1; \
	fi && \
	if [ ! -f "$(PAGES_ROOT)/.gitignore" ] || [ ! -f "$(PAGES_ROOT)/.nojekyll" ]; then \
		echo '${RED}Error: Missing required files in $(PAGES_ROOT)/.${RESET}'; \
		echo '${YELLOW}See docs/deployment.md for Git branch setup.${RESET}'; \
		exit 1; \
	fi && \
	mkdir -p $(ROOT_DIR)/logs && echo '${CYAN}Created logs/ folder.${RESET}' || true && \
	rm -rf $(PAGES_PUBLIC) || { echo '${RED}Failed to delete gh-pages/public/'; exit 1; } && \
	mkdir -p $(PAGES_PUBLIC) || { echo '${RED}Failed to create gh-pages/public/.${RESET}'; exit 1; } && \
	echo '${CYAN}Cleaned and recreated $(PAGES_PUBLIC).${RESET}'
	@cp -a $(PAGES_ROOT)/. $(PAGES_PUBLIC)/ || { echo '${RED}Failed to copy root files from gh-pages/root/.${RESET}'; exit 1; }
	@echo '${CYAN}Root files copied.${RESET}'
	@cp -r $(PUBLIC)/dist $(PAGES_PUBLIC)/ || { echo '${RED}Failed to copy gh-pages/public/dist.${RESET}'; exit 1; }
	@echo '${CYAN}Production assets copied.${RESET}'
	@rm -rf $(PAGES_PUBLIC)/dist/.vite 2>/dev/null && echo '${CYAN}Cleaned .vite directory from gh-pages/public/dist/.${RESET}' || true
	@cp $(PUBLIC)/broken-image.svg $(PAGES_PUBLIC)/ || { echo '${RED}Failed to copy gh-pages/public/broken-image.svg.${RESET}'; exit 1; }
	@cp $(PUBLIC)/favicon.ico $(PAGES_PUBLIC)/ || { echo '${RED}Failed to copy gh-pages/public/favicon.ico.${RESET}'; exit 1; }
	@echo '${CYAN}Special static files copied.${RESET}'
	@echo '${GREEN}✔ Preparation completed.${RESET}'

live-server: live-server-kill
	@echo '${BLUE}Starting local preview server...${RESET}'
	@live-server $(PAGES_PUBLIC) --port=9000 --open=. > /dev/null 2>&1 &
	@echo '${GREEN}✔ Preview server running on ${APP_URL}:${LIVE_SERVER_PORT}${RESET}'
	@echo '${YELLOW}make live-server-kill ${CYAN}to stop live-server process ${RESET}'

live-server-kill:
	@echo '${BLUE}Stopping local preview server...${RESET}'
	@lsof -t -i :9000 | xargs -r kill 2>/dev/null || true
	@fuser -k 9000/tcp || true
	@echo '${GREEN}✔ Preview server stopped.${RESET}'

# GitHub Pages Targets

# Overall target for setting up the GitHub Pages repository
gh-pages: gh-pages-init gh-pages-gitignore gh-pages-push-root
	@echo "${YELLOW}Next steps:${RESET}" && \
	echo "${YELLOW}1. Go to GitHub repository settings${RESET}" && \
	echo "${YELLOW}2. In the Build and deployment block:${RESET}" && \
	echo "   ${CYAN}- Source: Deploy from a branch${RESET}" && \
	echo "   ${CYAN}- Branch: gh-pages${RESET}" && \
	echo "   ${CYAN}- Folder: / (root)${RESET}" && \
	echo "${GREEN}After enabling push, site will be available at: ${PROD_URL}${RESET}"

gh-pages-push-public:
	@echo "${BLUE}Deploying to GitHub Pages...${RESET}"
	@cd $(PAGES_PUBLIC) && \
	git add . -f && \
	git commit -am "Update GH-Pages build $(shell date +%F\ %T)" || true && \
	git push -u origin gh-pages --force && \
	echo "${GREEN}✔ Successfully deployed to GitHub Pages${RESET}" && \
	echo "${CYAN}Site will be available at: ${PROD_URL}${RESET}"

gh-pages-push-root:
	@echo "${BLUE}Pushing root files to GitHub Pages...${RESET}"
	@cd $(PAGES_ROOT) && \
	git add . -f && \
	git commit -am "Initial GH-Pages root commit $(shell date +%F\ %T)" || true && \
	git push -u origin gh-pages --force && \
	echo "${GREEN}✔ Root changes successfully pushed to gh-pages${RESET}"

gh-pages-init:
	@echo "${BLUE}Initializing GitHub Pages repository...${RESET}"
	@cd $(ROOT_DIR) && mkdir -p $(PAGES_ROOT) && \
	cd $(PAGES_ROOT) && \
	touch .nojekyll .gitignore && \
	git init && \
	git remote add origin $(GIT_REPO_SSH_URL) && \
	git branch -m 'gh-pages' && \
	echo "${GREEN}✔ GitHub Pages repository initialized at $(PAGES_ROOT)${RESET}" && \
	echo "${YELLOW}Note: Make sure gh-pages/ is in your main .gitignore${RESET}"

gh-pages-gitignore:
	@echo "${BLUE}Creating .gitignore for GitHub Pages...${RESET}"
	@cd $(ROOT_DIR) && mkdir -p $(PAGES_ROOT)
	@echo "${CYAN}Filling .gitignore file...${RESET}"
	@echo "# Node.js" >> $(PAGES_ROOT)/.gitignore
	@echo "node_modules/" >> $(PAGES_ROOT)/.gitignore
	@echo "npm-debug.log" >> $(PAGES_ROOT)/.gitignore
	@echo "" >> $(PAGES_ROOT)/.gitignore
	@echo "# Vite" >> $(PAGES_ROOT)/.gitignore
	@echo ".vite/" >> $(PAGES_ROOT)/.gitignore
	@echo "*.local" >> $(PAGES_ROOT)/.gitignore
	@echo "" >> $(PAGES_ROOT)/.gitignore
	@echo "# IDEs and editors" >> $(PAGES_ROOT)/.gitignore
	@echo ".idea/" >> $(PAGES_ROOT)/.gitignore
	@echo ".vscode/" >> $(PAGES_ROOT)/.gitignore
	@echo "*.sublime-workspace" >> $(PAGES_ROOT)/.gitignore
	@echo "*.sublime-project" >> $(PAGES_ROOT)/.gitignore
	@echo "" >> $(PAGES_ROOT)/.gitignore
	@echo "# OS-specific files" >> $(PAGES_ROOT)/.gitignore
	@echo ".DS_Store" >> $(PAGES_ROOT)/.gitignore
	@echo "Thumbs.db" >> $(PAGES_ROOT)/.gitignore
	@echo "" >> $(PAGES_ROOT)/.gitignore
	@echo "# Environment" >> $(PAGES_ROOT)/.gitignore
	@echo ".env" >> $(PAGES_ROOT)/.gitignore
	@echo "" >> $(PAGES_ROOT)/.gitignore
	@echo "# Tests and vendors" >> $(PAGES_ROOT)/.gitignore
	@echo "test/" >> $(PAGES_ROOT)/.gitignore
	@echo "vendor/" >> $(PAGES_ROOT)/.gitignore
	@echo "" >> $(PAGES_ROOT)/.gitignore
	@echo "# Hide gh-pages from PRs" >> $(PAGES_ROOT)/.gitignore
	@echo "*" >> $(PAGES_ROOT)/.gitignore
	@echo "!important/dist/" >> $(PAGES_ROOT)/.gitignore
	@echo "!important/.gitignore" >> $(PAGES_ROOT)/.gitignore
	@echo "!important/.nojekyll" >> $(PAGES_ROOT)/.gitignore
	@echo "!important/404.html" >> $(PAGES_ROOT)/.gitignore
	@echo "!important/catalog.html" >> $(PAGES_ROOT)/.gitignore
	@echo "!important/contacts.html" >> $(PAGES_ROOT)/.gitignore
	@echo "!important/favicon.ico" >> $(PAGES_ROOT)/.gitignore
	@echo "!important/index.html" >> $(PAGES_ROOT)/.gitignore
	@echo "!important/robots.txt" >> $(PAGES_ROOT)/.gitignore
	@echo "${GREEN}✔ .gitignore successfully created in $(PAGES_ROOT)/${RESET}"