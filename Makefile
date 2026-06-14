plugin=Kanext
version?=latest

all:
	@ echo "Build archive for plugin ${plugin} version=${version}"
	@ git archive --worktree-attributes HEAD --prefix=${plugin}/ --format=zip -o ${plugin}-${version}.zip

lint: lint-php lint-frontend check-translations

lint-php:
	./vendor/bin/php-cs-fixer fix --dry-run --diff

lint-frontend:
	npx prettier --check .

format: format-php format-frontend

format-php:
	./vendor/bin/php-cs-fixer fix

format-frontend:
	npx prettier --write .

init:
	@ echo "Configure Git hooks"
	@ git config core.hooksPath .githooks

check-translations:
	php .tools/check-translations.php

update-translations:
	php .tools/update-translations.php
	$(MAKE) format-php
