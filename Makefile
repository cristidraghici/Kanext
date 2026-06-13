plugin=Kanext

all:
	@ echo "Build archive for plugin ${plugin} version=${version}"
	@ git archive HEAD --prefix=${plugin}/ --format=zip -o ${plugin}-${version}.zip

lint:
	./vendor/bin/php-cs-fixer fix --dry-run --diff

format:
	./vendor/bin/php-cs-fixer fix
