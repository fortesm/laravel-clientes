#!/bin/bash
set -e

echo ""
echo "========================================"
echo "  Inicializando ClientesCRM..."
echo "========================================"

# 1. Instala dependências se vendor/ não existir (volume local sobrescreve o build)
if [ ! -d "vendor" ]; then
    echo "[1/5] Instalando dependências (composer install)..."
    composer install --no-interaction --prefer-dist --no-scripts --quiet
    composer dump-autoload --optimize --quiet
else
    echo "[1/5] vendor/ já existe, pulando composer install."
fi

# 2. Gera APP_KEY se ainda não foi definida
if grep -q "^APP_KEY=$" .env 2>/dev/null || ! grep -q "^APP_KEY=" .env 2>/dev/null; then
    echo "[2/5] Gerando APP_KEY..."
    php artisan key:generate --no-interaction
else
    echo "[2/5] APP_KEY já definida, pulando."
fi

# 3. Aguarda o MySQL ficar disponível
echo "[3/5] Aguardando banco de dados..."
TRIES=0
until php -r "
    \$conn = @new mysqli(
        getenv('DB_HOST') ?: 'db',
        getenv('DB_USERNAME') ?: 'laravel',
        getenv('DB_PASSWORD') ?: 'secret',
        getenv('DB_DATABASE') ?: 'laravel_clientes',
        getenv('DB_PORT') ?: 3306
    );
    exit(\$conn->connect_error ? 1 : 0);
" 2>/dev/null; do
    TRIES=$((TRIES+1))
    if [ $TRIES -ge 20 ]; then
        echo "  -> Banco não respondeu após 60s. Verifique o container do MySQL."
        break
    fi
    echo "  -> Aguardando MySQL... ($((TRIES*3))s)"
    sleep 3
done

# 4. Roda migrations (seguro rodar múltiplas vezes — ignora o que já existe)
echo "[4/5] Executando migrations..."
php artisan migrate --force --no-interaction

# 5. Roda seeder somente se a tabela users estiver vazia
USER_COUNT=$(php artisan tinker --execute="echo App\Models\User::count();" 2>/dev/null | tail -1)
if [ "$USER_COUNT" = "0" ] || [ -z "$USER_COUNT" ]; then
    echo "[5/5] Criando usuário administrador..."
    php artisan db:seed --force --no-interaction
else
    echo "[5/5] Usuários já existem, pulando seeder."
fi

# Limpa caches
php artisan config:clear --quiet
php artisan view:clear --quiet

echo ""
echo "========================================"
echo "  Aplicação pronta!"
echo "  Acesse: http://localhost:8080"
echo "  Login:  admin@admin.com"
echo "  Senha:  password"
echo "========================================"
echo ""

# Inicia o PHP-FPM (processo principal do container)
exec php-fpm
