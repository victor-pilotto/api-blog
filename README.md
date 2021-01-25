# Backend

### Requisitos

- [Docker](https://docs.docker.com/install/linux/docker-ce/ubuntu/)
- [Docker Compose](https://docs.docker.com/compose/install/)

### Instalação

- Iniciando as docker

  `docker-compose up -d --build`

- Instalando dependências

  `docker-compose run --rm php-fpm composer install`

- Criando tabelas do banco de dados

  `docker-compose run --rm php-fpm vendor/bin/doctrine orm:schema-tool:create`

- Executar CodeSniffer, PHPUnit e PHPStan

  `docker-compose run --rm php-fpm composer check`

