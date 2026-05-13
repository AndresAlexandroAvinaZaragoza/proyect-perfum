# Instalación

## Requisitos
- Docker Desktop

## Pasos

1. Clonar repositorio

git clone ...

2. Entrar al proyecto

cd proyecto

3. Levantar contenedores

docker-compose up -d --build

4. Instalar dependencias

docker exec -it laravel_app composer install

5. Ejecutar migraciones

docker exec -it laravel_app php artisan migrate --seed

6. Abrir navegador

http://localhost:8000
