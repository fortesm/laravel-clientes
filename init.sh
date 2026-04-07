#!/bin/bash
# =============================================================
# Script de inicialização do ambiente Laravel + Docker
# Executar DENTRO do container app:
#   docker compose exec app bash init.sh
# =============================================================

set -e

echo "=============================="
echo "  Inicializando aplicação..."
echo "=============================="

# 1. Copia .env se não existir
if [ ! -f .env ]; then
    echo "[1/6] Copiando .env.example para .env..."
    cp .env.example .env
else
    echo "[1/6] .env já existe, pulando."
fi

# 2. Gera APP_KEY
echo "[2/6] Gerando APP_KEY..."
php artisan key:generate --no-interaction

# 3. Aguarda o MySQL estar pronto
echo "[3/6] Aguardando banco de dados..."
until php artisan migrate:status > /dev/null 2>&1; do
    echo "  -> Banco ainda não disponível. Aguardando 3s..."
    sleep 3
done

# 4. Executa migrations
echo "[4/6] Executando migrations..."
php artisan migrate --force --no-interaction

# 5. Executa seeders (cria usuário admin)
echo "[5/6] Executando seeders..."
php artisan db:seed --force --no-interaction

# 6. Limpa e otimiza caches
echo "[6/6] Otimizando aplicação..."
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan cache:clear

echo ""
echo "=============================="
echo "  ✅ Aplicação pronta!"
echo "  Acesse: http://localhost:8080"
echo "  Login:  admin@admin.com"
echo "  Senha:  password"
echo "=============================="
