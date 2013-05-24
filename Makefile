test:
	bin/phpunit
	bin/behat
	bin/behat -p end-to-end

init:
	mkdir -p storage
	touch storage/data.db
	php src/YoloWeb/console.php init
	php src/YoloWeb/console.php sql "INSERT INTO auctions (id, name, ending_at, currency) VALUES (null, 'YOLO glasses', '2013-06-02', 'GBP')"
	php src/YoloWeb/console.php create-user user "Luis Cordova" "cordovla@gmail.com" "FOOBAR"

web: .PHONY
	php -S localhost:8080 -t web web/dev.php

web-prod:
	php -S localhost:8080 -t web web/prod.php

.PHONY: