COMPOSE = docker compose
ARGS ?=
FILE ?=
.DEFAULT_GOAL := help
.PHONY: help init build up down restart deploy ps logs shell composer cake migrate migration-status cache-clear recurring backup restore permissions
help: ## Prikazi ukaze
	@awk 'BEGIN {FS = ":.*## "} /^[a-z-]+:.*## / {printf "%-20s %s\n", $$1, $$2}' $(MAKEFILE_LIST)
init: ## Ustvari .env in salt, ohrani obstojece vrednosti
	@python3 docker/init.py
build: ## Izdelaj produkcijsko sliko
	$(COMPOSE) build --pull
up: permissions ## Zazeni v ozadju
	$(COMPOSE) up -d --wait
down: ## Ustavi in odstrani vsebnik, ohrani podatke
	$(COMPOSE) down
restart: permissions ## Ponovno zazeni
	$(COMPOSE) restart
ps: ## Stanje storitev
	$(COMPOSE) ps
logs: ## Spremljaj dnevnike
	$(COMPOSE) logs -f --tail=100
shell: ## Odpri lupino
	$(COMPOSE) exec app sh
composer: permissions ## Composer; ARGS="install --no-dev"
	$(COMPOSE) run --rm --no-deps app composer $(ARGS)
cake: permissions ## CakePHP CLI; ARGS="..."
	$(COMPOSE) run --rm --no-deps app php bin/cake.php $(ARGS)
migrate: permissions ## Izvedi migracije
	$(COMPOSE) run --rm --no-deps app php bin/cake.php migrations migrate
migration-status: permissions ## Stanje migracij
	$(COMPOSE) run --rm --no-deps app php bin/cake.php migrations status
cache-clear: permissions ## Pocisti predpomnilnik
	$(COMPOSE) run --rm --no-deps app php bin/cake.php cache clear_all
recurring: permissions ## Generiraj ponavljajoce stroske
	$(COMPOSE) run --rm --no-deps app php bin/cake.php recurring_expenses generate
backup: permissions ## Ustavi aplikacijo, arhiviraj podatke in jo po potrebi zazeni
	@sh docker/manage.sh backup
restore: ## Obnovi arhiv; FILE=/absolutna/pot/backup.tar.gz
	@sh docker/manage.sh restore "$(FILE)"
deploy: ## Izdelaj sliko, ustavi, shrani kopijo, migriraj in zazeni
	@sh docker/manage.sh deploy
permissions: ## Nastavi lastnistvo podatkovnih map za vsebnik (po build)
	$(COMPOSE) run --rm --no-deps --user root --entrypoint sh app -ec 'mkdir -p /app/tmp/sessions /app/tmp/cache/models /app/tmp/cache/persistent /app/tmp/cache/views; chown -R www-data:www-data /app/db /app/storage /app/logs /app/tmp'
