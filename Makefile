.PHONY: up down logs status start-local stop-local cs-fix cs-check psalm test test-unit test-integration test-application test-single test-coverage create-migration migrate migrate-test create-db-test load-fixtures load-fixtures-test pre-commit-install help
.DEFAULT_GOAL := help
run-docker-compose = docker compose -f docker-compose.yml
run-cs-fixer = PHP_CS_FIXER_IGNORE_ENV=1 php ./vendor/bin/php-cs-fixer
run-psalm = php ./vendor/bin/psalm
run-phpunit = php -c ./disable-xdebug.ini ./vendor/bin/phpunit
run-phpunit-xdebug-cov = XDEBUG_MODE=coverage php ./vendor/bin/phpunit
run-php-console = php -c ./disable-xdebug.ini bin/console
run-symfony = symfony
run-npm = npm run

up: # Start containers and tail logs
	$(run-docker-compose) up -d
	make logs

down: # Stop all containers
	$(run-docker-compose) down

logs: # Tail container logs
	$(run-docker-compose) logs -f db

status: # Show status of all containers
	$(run-docker-compose) ps

start-local: # Start local server
	$(run-symfony) server:start

stop-local: # Stop local server
	$(run-symfony) server:stop

cs-check: # Check coding standards
	$(run-cs-fixer) fix --dry-run --diff

cs-fix: # Fix code style
	$(run-cs-fixer) fix

psalm: # Run psalm
	$(run-psalm)

test: test-unit test-integration test-application # Run all tests

test-unit: # Run unit tests
	$(run-phpunit) --testsuite=Unit

test-integration: # Run integration tests
	$(run-phpunit) --testsuite=Integration

test-application: create-db-test migrate-test load-fixtures-test # Run application tests
	$(run-phpunit) --testsuite=Application

test-single: # Run single test
	$(run-phpunit) --filter=$(filter)

test-coverage: create-db-test migrate-test load-fixtures-test # Run all tests with coverage
	$(run-phpunit-xdebug-cov) --testsuite=All --coverage-text

create-migration: # Create migration
	$(run-php-console) make:migration

migrate: # Run migrations
	$(run-php-console) doctrine:migrations:migrate

create-db-test: # Create test database
	$(run-php-console) doctrine:database:drop --env=test --force
	$(run-php-console) doctrine:database:create --env=test

migrate-test: # Run migrations for test environment
	$(run-php-console) doctrine:migrations:migrate --env=test --no-interaction

load-fixtures: # Load fixtures
	$(run-php-console) doctrine:fixtures:load --no-interaction

load-fixtures-test: # Load fixtures for test environment
	$(run-php-console) doctrine:fixtures:load --env=test --no-interaction

pre-commit-install: # Install pre-commit hook
	$(run-npm) prepare

help: # make help
	@awk 'BEGIN {FS = ":.*#"; printf "\nUsage:\n  make \033[36m<target>\033[0m\n"} /^[a-zA-Z0-9_-]+:.*?#/ { printf "  \033[36m%-27s\033[0m %s\n", $$1, $$2 } /^##@/ { printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)
