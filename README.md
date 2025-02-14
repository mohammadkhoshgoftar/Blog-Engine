# Laravel Blog Engine Project

## Setup & Installation

### Prerequisites
Ensure you have the following installed:
- **Docker** & **Docker Compose**

### Installation Steps
1. Clone the repository:
   ```sh
   git clone https://github.com/mohammadkhoshgoftar/Blog-Engine.git
   cd Blog-Engine
   ```

2. Run the installation script:
   ```sh
   chmod +x install.sh
   ./install.sh
   ```

### What Happens When You Run the Installation Script?
When you execute the installation script (`./install.sh`), the following steps occur:
- **Check and create the `.env` file**: If it doesn't exist, it copies `.env.example` to `.env`.
- **Start Docker containers**: It runs `docker-compose up -d --build` to build and start necessary containers.
- **Install Composer dependencies**: Inside the Docker container, it runs `composer install` to set up Laravel dependencies.
- **Generate the application key**: It executes `php artisan key:generate` to secure the application.
- **Run database migrations**: It applies Laravel database migrations using `php artisan migrate --force`.

After these steps, your Laravel application is fully set up and ready to use.

### Running the Project
Once the installation is complete, your project should be up and running.

- **Access the application**:
  ```sh
  http://localhost:8080
  ```

- **View running containers**:
  ```sh
  docker ps
  ```

- **Stop the application**:
  ```sh
  docker-compose down
  ```

- **Restart the application**:
  ```sh
  docker-compose up -d
  ```

