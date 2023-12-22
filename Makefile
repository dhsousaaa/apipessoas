.PHONY: *

rebuild: ## Sobe o projeto inicial
	make down
	docker-compose up -d --build
	docker exec -ti web sh -c "composer install"
	docker exec -ti web sh -c "php artisan key:generate"

up: ## Inicia o docker compose
	docker-compose up -d --force-recreate

down: ## Remove o Cloud e MySQL
	docker-compose --file 'docker-compose.yml' stop

bash: ## Bash dentro do container Cloud web
	docker exec -ti api_web bash