# Setup Docker Laravel

### Passo a passo

### Clone Repositório

```sh
git clone -b laravel-12-with-php8.4 https://github.com/gustavogordoni/setup-docker-laravel.git
```

### Clone os Arquivos do Laravel
```sh
git clone https://github.com/laravel/laravel.git app_laravel
```

### Copie os arquivos docker-compose.yml, Dockerfile e o diretório docker/ para o seu projeto
```sh
cp -rf setup-docker-laravel/* app_laravel/
```

```sh
cd app_laravel
```

### Crie o Arquivo .env

```sh
cp .env.example .env
```

### Suba os containers com Docker

```sh
docker compose up -d
```

### Acesse o container da aplicação

```sh
docker compose exec app bash
```

### Instale as dependências do Laravel

```sh
composer install
```

### Gere a chave da aplicação

```sh
php artisan key:generate
```

### Rode as migrations

```sh
php artisan migrate
```

<!-- 
### Rode as seeds
```sh
php artisan db:seed 
```
-->

### Instale as dependências do frontend

```sh
npm install
```

### Compile os assets com Vite

```sh
npm run build
```

> Se estiver desenvolvendo, use `npm run dev` para recompilar automaticamente ao salvar os arquivos.

---

## Acesse o projeto

Abra no navegador: [http://localhost:8000](http://localhost:8000)
