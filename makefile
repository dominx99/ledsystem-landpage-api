compose_file := "docker-compose.yml"
php_service := "php"

up:
	@docker-compose up -d

down:
	@docker-compose down

restart: down up

com:
	@docker-compose -f $(compose_file) exec $(php_service) composer $(CMD)

phinx:
	@docker-compose -f $(compose_file) exec $(php_service) composer phinx $(CMD)

dbrestart:
	@docker-compose -f $(compose_file) exec $(php_service) composer phinx rollback -- -t 0
	@docker-compose -f $(compose_file) exec $(php_service) composer phinx migrate
	@docker-compose -f $(compose_file) exec $(php_service) composer phinx seed:run
