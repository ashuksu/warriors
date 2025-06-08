.PHONY: help up kill build-prod up-prod kill-prod exec-php exec-vite monitor composer npm clean destroy

# --- Configuration ---
# Use standard docker-compose merging for dev environment
DEV_COMPOSE_ARGS := -f docker-compose.yml -f docker-compose-dev.yml
# Production environment uses only the base file
PROD_COMPOSE_ARGS := -f docker-compose.yml

# Path variables
ROOT_DIR		:= $(shell pwd)
PAGES_ROOT		:= $(ROOT_DIR)/gh-pages/root
PAGES_PUBLIC	:= $(ROOT_DIR)/gh-pages/public
APP_URL			:= http://localhost

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
	@echo '  make [command]'
	@echo ''
	@echo '${BLUE}Development Commands:${RESET}'
	@echo '  ${GREEN}make up${RESET}            	  - Start development environment (builds images if necessary).'
	@echo '  ${GREEN}make kill${RESET}           	  - Stop development environment.'
	@echo '  ${GREEN}make exec-php${RESET}     	  - Get a shell inside the PHP container (dev).'
	@echo '  ${GREEN}make exec-vite${RESET}    	  - Get a shell inside the Vite helper container (dev).'
	@echo '  ${GREEN}make composer [...args]${RESET} - Run any Composer command (e.g., "make composer require laravel/pint").'
	@echo '  ${GREEN}make npm [...args]${RESET}      - Run any NPM command (e.g., "make npm install lodash").'
	@echo '  ${GREEN}make monitor${RESET}            - Run any NPM command (e.g., "make npm install lodash").'
	@echo ''
	@echo '${BLUE}Production Commands:${RESET}'
	@echo '  ${CYAN}make build-prod${RESET}  	  - Build final, optimized production images.'
	@echo '  ${CYAN}make up-prod${RESET}     	  - Start production environment in detached mode.'
	@echo '  ${CYAN}make kill-prod${RESET}   	  - Stop production environment.'
	@echo ''
	@echo '${BLUE}Utility Commands:${RESET}'
	@echo '  ${YELLOW}make clean${RESET}       	  - Stop all services and remove all related containers, networks, and volumes (dev & prod).'
	@echo '  ${YELLOW}make destroy${RESET}     	  - Purge ALL Docker system resources (containers, images, volumes, cache not in use).'
	@echo '  ${YELLOW}make config${RESET}      	  - Copy .env.example to .env.'

# --- Development Targets ---

# Start development environment (and build if needed)
up: config
	@echo '${BLUE}Starting development environment...${RESET}'
	@docker compose $(DEV_COMPOSE_ARGS) up --build

# Stop development environment
kill:
	@echo '${BLUE}Stopping development environment...${RESET}'
	@docker compose $(DEV_COMPOSE_ARGS) down

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


# --- Production Targets ---

# Build final production images
build-prod:
	@echo '${BLUE}Building production images...${RESET}'
	@docker compose $(PROD_COMPOSE_ARGS) build

# Start production environment
up-prod:
	@echo '${BLUE}Starting production environment...${RESET}'
	@docker compose $(PROD_COMPOSE_ARGS) up -d

# Stop production environment
kill-prod:
	@echo '${BLUE}Stopping production environment...${RESET}'
	@docker compose $(PROD_COMPOSE_ARGS) down


# --- Generic Targets ---

# Create .env from .env.example
config:
	@if [ ! -f .env ]; then \
		echo '${BLUE}Creating .env file...${RESET}'; \
		cp .env.example .env; \
		echo '${GREEN}.env file created. Please review and edit it.${RESET}'; \
	else \
		echo '${YELLOW}.env file already exists. Skipping.${RESET}'; \
	fi

# Stop and remove everything: containers, networks, and VOLUMES
clean:
	@echo '${YELLOW}Cleaning up all project Docker resources...${RESET}'
	@docker compose $(DEV_COMPOSE_ARGS) down -v --remove-orphans 2>/dev/null || true
	@docker compose $(PROD_COMPOSE_ARGS) down -v --remove-orphans 2>/dev/null || true
	@echo '${GREEN}Cleanup complete.${RESET}'


# Purge ALL Docker system resources (containers, images, volumes, cache not in use)
# USE WITH EXTREME CAUTION! This removes *all* Docker resources on your system, not just project-specific ones.
destroy:
	@bash -c '\
			echo; \
			echo "${RED}WARNING!"; \
			echo; \
    		echo "${YELLOW}This will purge ALL Docker system resources. Use with extreme caution!${RESET}"; \
    		echo; \
    		echo "${RED}You are sure? ${CYAN}(Y=yes, Any key=no)${RESET}"; \
    		read -n 1 -s key; \
    		if [[ "$$key" == "y" || "$$key" == "Y" || "$$key" == "н" || "$$key" == "Н" ]]; then \
    			echo -e "\r${GREEN}✔ Cleaning selected${RESET}"; \
    			make docker-clean; \
    			echo -e "\r${BLUE}Cleaning project files...${RESET}"; \
    			echo -e "\r${BLUE}Cleaning Docker system...${RESET}"; \
				docker compose down --volumes --remove-orphans && echo "${CYAN}Docker Compose services, volumes, and orphans removed.${RESET}" || echo "${YELLOW}⚠ Docker Compose cleanup failed.${RESET}"; \
				docker ps -qa | xargs -r docker rm -f && echo "${CYAN}All stopped and running containers forcefully removed.${RESET}" || echo "${YELLOW}⚠ No containers to remove.${RESET}"; \
				docker images -qa | xargs -r docker rmi -f && echo "${CYAN}All Docker images forcefully removed.${RESET}" || echo "${YELLOW}⚠ No Docker images to remove or removal failed.${RESET}"; \
				docker system prune -af --volumes && echo "${CYAN}Docker system pruned (images, containers, volumes, networks).${RESET}" || echo "${YELLOW}⚠ Docker system prune failed or nothing to prune.${RESET}"; \
				docker builder prune -af && echo "${CYAN}Docker build cache pruned.${RESET}" || echo "${YELLOW}⚠ No Docker build cache to prune or prune failed.${RESET}"; \
				docker buildx prune -af && echo "${CYAN}Docker Buildx cache pruned.${RESET}" || echo "${YELLOW}⚠ No Docker Buildx cache to prune or prune failed.${RESET}"; \
				docker network prune -f && echo "${CYAN}Docker networks pruned again (redundant for safety).${RESET}" || echo "${YELLOW}⚠ No Docker networks to prune or prune failed.${RESET}"; \
				echo -e "\r${GREEN}✔ Docker system cleaned.${RESET}"; \
    		else \
    			echo -e "\r${YELLOW}Cleaning cancelled by user${RESET}"; \
    		fi \
    	'

# --- Command Proxies ---

# This allows running 'make composer require package' or 'make composer update'
composer:
	@echo '${CYAN}Running Composer command inside PHP container...${RESET}'
	@docker compose $(DEV_COMPOSE_ARGS) run --rm php composer $(filter-out $@,$(MAKECMDGOALS))

# This allows running 'make npm install package' or 'make npm run build'
npm:
	@echo '${CYAN}Running NPM command inside Vite container...${RESET}'
	@docker compose $(DEV_COMPOSE_ARGS) run --rm vite npm $(filter-out $@,$(MAKECMDGOALS))

# Catch-all for undefined targets to prevent errors and show help
%::
	@echo "Target '$@' not defined."
	@$(MAKE) help




# Deployment to GitHub Pages
deploy: wget
	@bash -c '\
		echo "${YELLOW}Would you like to deploy? (Enter=yes, Any key=no)${RESET}"; \
		read -n 1 -s key; \
		if [[ -z "$$key" ]]; then \
			make kill; \
			echo -e "\r${GREEN}✔ Deploy selected${RESET}"; \
			make gh-pages-push-public; \
		else \
			make kill; \
			echo -e "\r${YELLOW}Deploy cancelled by user${RESET}"; \
			echo "${YELLOW}You can now:${RESET}"; \
			echo "- ${YELLOW}make deploy${RESET} to push to GitHub Pages"; \
		fi \
	'


# WGET commands
wget: wget-preparation wget-generation
	@echo "${GREEN}Generation completed successfully${RESET}"
	@echo "${BLUE}Starting preview server...${RESET}"
	@live-server gh-pages/public --port=9000 --open=. > /dev/null 2>&1 &
	@echo "${CYAN}Preview server running on http://localhost:9000${RESET}"

wget-preparation: kill build-prod
	@make npm run build
	@make up-prod && echo '${GREEN}✔ Docker production environment is up and running at ${APP_URL} in background!${RESET}' || echo '${RED}Error: Docker production environment failed to start.${RESET}'
	@echo
	@echo '${BLUE}Preparing project for WGET...${RESET}'
	@cd $(ROOT_DIR) && \
	if [ ! -d "gh-pages/root" ]; then \
		echo '${RED}Error: gh-pages/root/ not found${RESET}'; \
		echo '${YELLOW}See docs/deployment.md for Git branch setup${RESET}'; \
		exit 1; \
	fi && \
	if [ ! -f "gh-pages/root/.gitignore" ] || [ ! -f "gh-pages/root/.nojekyll" ]; then \
		echo '${RED}Error: Missing required files in gh-pages/root/${RESET}'; \
		echo '${YELLOW}See docs/deployment.md for Git branch setup${RESET}'; \
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
	echo "${YELLOW}Note: Make sure gh-pages/ is in your main .gitignore${RESET}"

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
