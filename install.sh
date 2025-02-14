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

echo "Waiting for MySQL to be ready..."
until docker compose exec mysql mysqladmin ping -h "localhost" --silent; do
    sleep 2
done

echo "Running Composer Install..."
docker compose exec laravel composer install --no-interaction --optimize-autoloader

echo "Checking if vendor exists..."
docker compose exec laravel sh -c "[ -d /var/www/html/vendor ] || composer install --no-interaction --optimize-autoloader"

echo "Generating APP_KEY..."
docker compose exec laravel php artisan key:generate

echo "Installing Horizon..."
docker compose exec laravel php artisan horizon:install

echo "Running Migrations..."
docker compose exec laravel php artisan migrate --force

echo "Clearing Cache..."
docker compose exec laravel php artisan cache:clear
docker compose exec laravel php artisan config:clear
docker compose exec laravel php artisan queue:restart

echo "Ensuring Horizon stays running..."
docker compose exec laravel php artisan horizon:terminate
docker compose exec -d laravel php artisan horizon

echo "Project installation is complete! You can now use the application."
