
echo "Starting Blog Engine project installation..."

if [ ! -f ".env" ]; then
    echo "Creating .env file from .env.example"
    cp .env.example .env
else
    echo ".env file already exists."
fi

echo "Starting Docker..."
docker compose up -d --build

echo "Running Composer Install..."
docker compose exec BlogEngine composer install --no-interaction --optimize-autoloader

echo "Generating APP_KEY..."
docker compose exec BlogEngine php artisan key:generate

echo "install horizon..."
docker compose exec BlogEngine php artisan horizon:install

echo "Running Migrations..."
docker compose exec BlogEngine php artisan migrate --force

echo "Project installation is complete! You can now use the application."
