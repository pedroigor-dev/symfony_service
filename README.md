# PetLove Backend

Backend de um sistema de gestão para clínicas veterinárias, desenvolvido com Symfony e API Platform. O projeto foi construído como portfólio técnico demonstrando domínio da stack PHP/Symfony, com deploy em produção na nuvem.

---

## Sobre o projeto

O sistema permite gerenciar tutores (owners), pets e consultas (appointments) por meio de uma API RESTful. O frontend consome essa API de forma independente, seguindo uma arquitetura desacoplada onde o backend é responsável exclusivamente pelos dados e regras de negócio.

A ideia surgiu como projeto de portfólio voltado para a stack usada pela SimplesVet (PHP, Symfony, Vue.js), e foi construído do zero com foco em aprendizado real: cada decisão técnica foi discutida e aplicada na prática.

---

## Stack utilizada

- PHP 8.4
- Symfony 8.0 (skeleton)
- Doctrine ORM 3.6 com Doctrine Migrations
- API Platform 4.2 (endpoints REST + Swagger UI automático)
- NelmioCorsBundle (controle de CORS)
- PostgreSQL 18 (produção via Render)
- MySQL (desenvolvimento local)
- Docker com PHP-FPM + Nginx + Supervisor
- Render.com (hospedagem do backend)

---

## Estrutura das entidades

**Owner** — representa o tutor do pet
- name, email, phone
- Relacionamento: um tutor pode ter vários pets

**Pet** — representa o animal
- name, species, breed, birthday
- Relacionamento: pertence a um tutor, pode ter várias consultas

**Appointment** — representa uma consulta veterinária
- date, description
- Relacionamento: pertence a um pet e a um tutor

---

## Como o projeto foi construído

O projeto começou com a instalação manual do PHP 8 e Composer no Windows, seguida da criação do projeto Symfony via `composer create-project symfony/skeleton`.

As entidades foram criadas com o MakerBundle (`make:entity`) e os relacionamentos foram definidos diretamente via linha de comando, explorando os tipos `ManyToOne` e `OneToMany` do Doctrine. As migrações foram geradas automaticamente pelo Doctrine Migrations.

A API RESTful foi habilitada simplesmente instalando o API Platform (`composer require api`) e adicionando a anotação `#[ApiResource]` nas entidades. Isso gerou automaticamente todos os endpoints CRUD com documentação Swagger acessível em `/api`.

---

## Docker e deploy

O deploy foi feito na plataforma Render.com usando Docker. O container utiliza a imagem `php:8.4-fpm-alpine` com Nginx servindo os arquivos estáticos e encaminhando as requisições PHP para o PHP-FPM. O Supervisor gerencia ambos os processos dentro do mesmo container.

Um script de inicialização (`docker/start.sh`) executa as migrations do banco de dados automaticamente a cada novo deploy, eliminando a necessidade de acesso manual ao servidor.

O banco de dados local (MySQL) foi substituído por PostgreSQL para compatibilidade com o Render, o que exigiu reescrever as migrations removendo a sintaxe exclusiva do MySQL (`AUTO_INCREMENT`, `DEFAULT CHARACTER SET`, `DROP FOREIGN KEY`) e adotando a equivalente do PostgreSQL (`SERIAL`, `TIMESTAMP WITHOUT TIME ZONE`, `DROP CONSTRAINT`).

---

## Desafios no processo

Durante o deploy surgiram alguns problemas que foram resolvidos iterativamente:

- O `.dockerignore` bloqueava a pasta `docker/`, impedindo que o Nginx e o Supervisor fossem configurados corretamente no container
- O Composer tentava executar scripts de pós-instalação (`cache:clear`, `assets:install`) durante o build, o que carregava o kernel do Symfony e falhava por tentar instanciar bundles de desenvolvimento que não estavam instalados em produção. A solução foi usar `--no-scripts` e executar os comandos necessários manualmente após o `composer install`
- A pasta `var/` não é copiada para o container (está no `.dockerignore`) e precisou ser criada explicitamente com `mkdir -p` antes do `chown`
- As migrations geradas com MySQL continham sintaxe incompatível com PostgreSQL, exigindo reescrita manual dos três arquivos de migração

---

## Configuração do ambiente

O backend espera as seguintes variáveis de ambiente:

```
APP_ENV=prod
APP_SECRET=sua_chave_secreta
DATABASE_URL=postgresql://usuario:senha@host:5432/banco
CORS_ALLOW_ORIGIN=^https://seu-frontend\.dominio\.com$
```

A variável `CORS_ALLOW_ORIGIN` aceita uma expressão regular por conta do `origin_regex: true` configurado no NelmioCorsBundle.

---

## Rodando localmente

```bash
composer install
php bin/console doctrine:migrations:migrate
symfony server:start
```

A API estará disponível em `http://localhost:8000/api` com o Swagger UI para explorar e testar os endpoints.

---

## API em produção

A API está disponível em:

```
https://petlove-backend-w5n4.onrender.com/api
```

Endpoints disponíveis: `/api/owners`, `/api/pets`, `/api/appointments`

O plano gratuito do Render pode causar um delay de até 50 segundos na primeira requisição após um período de inatividade, pois o container é pausado automaticamente. Esse comportamento é esperado no tier gratuito.
