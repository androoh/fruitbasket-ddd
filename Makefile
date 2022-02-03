init:
	docker-compose build --force-rm --no-cache
	make up
up:
	docker-compose up -d
	echo "App is running at http://127.0.0.1:8030"

schema-update:
	docker exec -it fruit_basket /home/fruit_basket/bin/console doctrine:database:create --if-not-exists
	docker exec -it fruit_basket /home/fruit_basket/bin/console doctrine:schema:update --force
	docker exec -it fruit_basket /home/fruit_basket/bin/console doctrine:fixtures:load
