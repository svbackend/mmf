### MyMiniFactory Test Task

### Prerequisites

* Docker
* Docker Compose

### Installation

`cp .env.dist .env`

`docker compose up -d`

`docker compose run php composer install`

`docker compose run php bin/console doctrine:migrations:migrate -n`

Navigate to http://localhost:8080/api/doc

Login using /api/v1/login (grab token from response and use it in "Authorize" button on SwaggerUI, top right corner)

### Frontend (a.k.a SwaggerUI)

http://localhost:8080/api/doc

### Existing users

* Admin: admin@mmf.loc / 123456
* User: user@mmf.loc / 123456
