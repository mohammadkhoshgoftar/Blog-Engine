
echo "Starting Blog Engine project installation..."

if [ ! -f ".env" ]; then
    echo "Creating .env file from .env.example"
    cp .env.example .env
else
    echo ".env file already exists."
fi

echo "Starting Docker..."
docker compose up -d --build

echo "Waiting for BlogEngine container to be ready..."
until [ "$(docker inspect -f '{{.State.Running}}' $(docker compose ps -q laravel))" == "true" ]; do
  sleep 1
done

echo "Running Composer Install..."
docker compose exec laravel composer install --no-interaction --optimize-autoloader

echo "Generating APP_KEY..."
docker compose exec laravel php artisan key:generate

echo "install horizon..."
docker compose exec laravel php artisan horizon:install

echo "Running Migrations..."
docker compose exec laravel php artisan migrate --force

echo "Starting Horizon..."
docker compose exec laravel php artisan queue:restart
docker compose exec -d laravel php artisan horizon

echo "Project installation is complete! You can now use the application."
