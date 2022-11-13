.DEFAULT_GOAL := help
install: ## Init project
	cp -n .env.example .env
	docker-compose build
	docker-compose up -d
	docker-compose exec php composer install
	$(MAKE) key-generate
	$(MAKE) db-create
	$(MAKE) db-seed

key-generate: ## Create application key
	docker-compose exec php php artisan key:generate

db-create: ## Run migration
	docker-compose exec php php artisan migrate

db-seed: ## Run seeders
	docker-compose run php php artisan db:seed

start: ## Run docker for a project
	docker-compose up -d

stop: ## Stop all containers for a project
	docker-compose down --remove-orphans

bash: ## Exec bash for php container
	docker-compose exec php bash

phpstan: ## Run static analysis a code for a php container
	docker-compose exec php composer phpstan

phpunit: ## Run tests for a php container
	docker-compose exec php composer test

cs-check: ## Run check for a linter
	docker-compose exec php composer cs:check

cs-fix: ## Run linter
	docker-compose exec php composer cs:fix

run-tests: ## Run stage for test
	$(MAKE) cs-check
	$(MAKE) phpunit

fix-permissions: ## Change permision for volumen a php container
	docker-compose exec php	usermod -u 1000 www-data

start-queue: ## Start work for queue
	docker-compose exec php php artisan queue:work

composer-update: ## Run composer update for php container
	docker-compose exec php composer update

redis-cli: ## Exec redis container cli
	docker-compose exec redis redis-cli

kill-all: ## Kill all running containers
	docker container kill $$(docker container ls -q)

retry-fails-jobs: ## Retry all fails jobs
    docker-compose exec php php artisan queue:retry all

openapi: ## Generate api documentation
    docker-compose exec php php artisan lrd:generate

.PHONY: help
help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'
