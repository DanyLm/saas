
SOURCE_DIR = `pwd`
BIN_DIR = ${SOURCE_DIR}/vendor/bin

LINT_DIR =  ${SOURCE_DIR}/app \
			${SOURCE_DIR}/config \
            ${SOURCE_DIR}/routes \
            ${SOURCE_DIR}/bootstrap \
            ${SOURCE_DIR}/wave \
            ${SOURCE_DIR}/database

define printSection
	@printf "\033[36m\n==================================================\n\033[0m"
	@printf "\033[36m $1 \033[0m"
	@printf "\033[36m\n==================================================\n\033[0m"
endef

#  _   _      _
# | | | |    | |
# | |_| | ___| |_ __
# |  _  |/ _ \ | '_ \
# | | | |  __/ | |_) |
# \_| |_/\___|_| .__/
#              | |
#              |_|

.PHONY: help
help: ## Liste les commandes présentes
	$(call printSection,HELP)
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) \
	| sort \
	| awk 'BEGIN {FS = ":.*?## "}; {printf "${_GREEN}%-20s${_END} %s\n", $$1, $$2}' \
	| sed -e 's/##//'


#  _____            _
# /  __ \          | |
# | /  \/ __ _  ___| |__   ___
# | |    / _` |/ __| '_ \ / _ \
# | \__/\ (_| | (__| | | |  __/
# \____/\__,_|\___|_| |_|\___|

.PHONY: clear-laravel
clear-laravel:  ## Vide les caches laravel
	$(call printSection,CLEAR CACHE LARAVEL)
	php ${SOURCE_DIR}/artisan cache:clear \
    	&& php ${SOURCE_DIR}/artisan clear-compiled \
		&& php ${SOURCE_DIR}/artisan route:clear \
		&& php ${SOURCE_DIR}/artisan view:clear \
		&& php ${SOURCE_DIR}/artisan config:clear \
		&& php ${SOURCE_DIR}/artisan event:clear

.PHONY: clear-phpstan
clear-phpstan:  ## Vide les caches et relance phpstan
	$(call printSection,CLEAR CACHE PHPSTAN)
	rm -R ${SOURCE_DIR}/storage/tmp/phpstan
	make phpstan

#  _____             _ _ _
# |  _  |           | (_) |
# | | | |_   _  __ _| |_| |_ _   _
# | | | | | | |/ _` | | | __| | | |
# \ \/' / |_| | (_| | | | |_| |_| |
#  \_/\_\\__,_|\__,_|_|_|\__|\__, |
#                             __/ |
#                            |___/

.PHONY: phpstan
phpstan:  ## Lance l'analyse de code
	$(call printSection,PHPSTAN)
	${BIN_DIR}/phpstan.phar analyse -c phpstan.neon.dist --memory-limit=1G

.PHONY: fix
fix:  ## Lance le formatage du code
	$(call printSection,DUSTER)
	${BIN_DIR}/duster fix ${LINT_DIR}

.PHONY: fix-dirty
fix-dirty:  ## Lance le formatage du code en mode dirty
	$(call printSection,DIRTY DUSTER)
	${BIN_DIR}/duster fix --dirty

.PHONY: rector
rector: ## Lance l'analyse de la refactorisation de la base de code
	$(call printSection,RECTOR)
	${BIN_DIR}/rector process

#  _____ _____
# /  __ \_   _|
# | /  \/ | |
# | |     | |
# | \__/\_| |_
# \____/\___/

.PHONY: ci-lint
ci-lint:
	$(call printSection,DUSTER)
	${BIN_DIR}/duster lint ${LINT_DIR}

.PHONY: ci
ci: ci-lint phpstan

