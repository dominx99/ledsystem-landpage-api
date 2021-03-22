compose_file := "docker-compose.yml"
php_service := "php"

run:
	@docker-compose up -d

down:
	@docker-compose down

com:
	@docker-compose -f $(compose_file) exec $(php_service) composer $(CMD)

phinx:
	@docker-compose -f $(compose_file) exec $(php_service) composer phinx $(CMD)
