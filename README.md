# ClientesCRM — Cadastro de Clientes
Data : 06/04/2026

Aplicação web para gerenciamento de clientes desenvolvida com **PHP 8.2 + Laravel 11**, com autenticação de usuários, consulta automática de CEP e ambiente totalmente containerizado via Docker.

---

## Funcionalidades

- Autenticação de usuários com controle de acesso (login/logout)
- CRUD completo de clientes: criar, listar, editar e excluir
- Consulta automática de endereço pelo CEP via [ViaCEP](https://viacep.com.br)
- Busca e filtro de clientes por nome, e-mail ou cidade
- Paginação da listagem
- Validações de formulário no backend
- Interface responsiva com Bootstrap 5

---

## Tecnologias utilizadas

| Camada         | Tecnologia            |
|----------------|-----------------------|
| Backend        | PHP 8.2 + Laravel 11  |
| Frontend       | Bootstrap 5 + Blade   |
| Banco de dados | MySQL 8.0             |
| Servidor web   | Nginx (Alpine)        |
| Infraestrutura | Docker + Compose      |

---

## Pré-requisitos

Antes de começar, você precisa ter instalado apenas:

- [Docker Desktop para Windows](https://www.docker.com/products/docker-desktop/) — inclui o Docker Compose
- [Git for Windows](https://git-scm.com/download/win) — ou qualquer cliente Git de sua preferência

Não é necessário instalar PHP, Composer, MySQL ou Nginx na máquina. Tudo roda dentro dos containers.

---

## Como executar o projeto

### 1. Clonar o repositório

```bash
git clone https://github.com/SEU_USUARIO/laravel-clientes.git
cd laravel-clientes
```

Se preferir usar o **TortoiseGit**: clique com botão direito na pasta desejada → Git Clone → informe a URL do repositório.

---

### 2. Configurar o arquivo de ambiente

```bash
# Linux/Mac/Git Bash
cp .env.example .env

# Windows (Prompt de Comando)
copy .env.example .env
```

Não é necessário alterar nenhuma configuração. O arquivo já vem preparado para o ambiente Docker.

---

### 3. Subir os containers

Com o **Docker Desktop aberto e rodando**, execute na pasta do projeto:

```bash
docker compose up -d --build
```

Isso é tudo. O container irá automaticamente:

- Instalar as dependências PHP via Composer
- Gerar a chave da aplicação
- Aguardar o banco de dados inicializar
- Criar todas as tabelas via migrations
- Criar o usuário administrador padrão

Acompanhe o progresso com:

```bash
docker compose logs -f app
```

Aguarde até aparecer a mensagem **"Aplicação pronta!"** nos logs.

---

### 4. Acessar a aplicação

Abra o navegador e acesse:

```
http://localhost:8080
```

**Credenciais de acesso padrão:**

| Campo  | Valor           |
|--------|-----------------|
| E-mail | admin@admin.com |
| Senha  | password        |

---

## Estrutura dos containers

| Container       | Função          | Porta local |
|-----------------|-----------------|-------------|
| `laravel_app`   | PHP-FPM 8.2     | —           |
| `laravel_nginx` | Servidor web    | 8080        |
| `laravel_db`    | MySQL 8.0       | 3306        |

A porta 3306 fica disponível localmente para conexão com ferramentas como DBeaver ou MySQL Workbench:

- Host: `localhost`
- Usuário: `laravel`
- Senha: `secret`
- Banco: `laravel_clientes`

---

## Comandos do dia a dia

```bash
# Iniciar os containers (após reiniciar o PC, por exemplo)
docker compose up -d

# Parar os containers
docker compose down

# Ver logs em tempo real
docker compose logs -f app

# Acessar o terminal do container da aplicação
docker compose exec app bash

# Rodar migrations manualmente
docker compose exec app php artisan migrate

# Limpar cache de configuração
docker compose exec app php artisan config:clear
```

---

## Estrutura do projeto

```
laravel-clientes/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── AuthController.php       ← Login e logout
│   │   │   ├── ClienteController.php    ← CRUD + consulta de CEP
│   │   │   └── Controller.php           ← Classe base
│   │   └── Requests/
│   │       └── ClienteRequest.php       ← Validações dos formulários
│   └── Models/
│       ├── Cliente.php
│       └── User.php
├── database/
│   ├── migrations/                      ← Estrutura das tabelas
│   └── seeders/
│       └── DatabaseSeeder.php           ← Usuário administrador padrão
├── docker/
│   ├── nginx/default.conf               ← Configuração do Nginx
│   └── php/
│       ├── Dockerfile                   ← Imagem PHP personalizada
│       └── entrypoint.sh                ← Inicialização automática
├── resources/views/
│   ├── auth/login.blade.php
│   ├── clientes/                        ← Telas do CRUD
│   └── layouts/app.blade.php
├── routes/web.php                       ← Definição das rotas
├── docker-compose.yml
└── .env.example
```

---

## Solução de problemas comuns

**Porta 8080 já está em uso**
Altere no `docker-compose.yml` a linha `"8080:80"` para outra porta disponível, como `"8888:80"`, e rode `docker compose up -d` novamente.

**Erro de permissão no storage**
```bash
docker compose exec app chmod -R 775 storage bootstrap/cache
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
```

**A mensagem "Aplicação pronta!" não aparece nos logs**
```bash
docker compose logs db
```
Verifique se o container do banco subiu corretamente. Na primeira execução, o MySQL pode demorar até 40 segundos para inicializar.

**Página em branco ou erro 500 após o build**
```bash
docker compose exec app php artisan key:generate
docker compose exec app php artisan config:clear
```

---

## Licença

Este projeto foi desenvolvido para fins de avaliação técnica e está disponível para uso e consulta. Autor Marcelo Fortes.
