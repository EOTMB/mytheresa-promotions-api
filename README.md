# Mytheresa Promotions API

## Symfony 7

### Requirements:
- [Docker & Docker Compose](https://docs.docker.com/engine/install/)

### The project is runnable with 1 simple command from any machine:
- `make setup` to start the application.

### Explanations on decisions taken:

- [README.md](./docs/README.md)

### Tests should be runnable with 1 command:
Test are a must. Code must be testable without requiring networking or the filesystem.
- `make tests` to run the test suite.

### Endpoints:
- Api platform Docs: [/api/doc](http://localhost/api/doc)
- Products Docs: [/products](http://localhost/products)

### Stack:
- `NGINX 1.19` container
- `PHP 8.2 FPM` container
- `MySQL 8.0` container + `volume`

### Optionals Command:
- `make build` to build the docker environment
- `make run` to spin up containers
- `make prepare` to install dependencies and run migrations
- `make ssh-be` to access the PHP container bash
- `make be-logs` to tail dev logs
- `make code-style` to run PHP-CS-FIXER on src and tests
- `make restart` to stop and start containers