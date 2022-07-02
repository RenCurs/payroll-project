
CONSOLE=bin/console

up: deps migration fixtures

deps:
	docker-compose run --rm app composer install

migration:
	docker-compose run --rm app $(CONSOLE) do:mi:mi --no-interaction

fixtures:
	docker-compose run --rm app $(CONSOLE) do:fi:lo --no-interaction

generate_routes:
	php $(CONSOLE) fos:js-routing:dump --format=json --target=assets/fos_js_routes.json