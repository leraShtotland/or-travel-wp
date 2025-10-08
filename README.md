# OR Travel WordPress Environment

This repository contains the custom WordPress theme and supporting assets for the OR Travel site. The WordPress core files are not committed to source control, so the project includes a Docker based development environment that provisions WordPress, MySQL, and phpMyAdmin locally.

## Prerequisites

Before you begin, make sure the following tools are installed:

- [Docker Desktop](https://www.docker.com/products/docker-desktop/) (or Docker Engine on Linux)
- [Docker Compose](https://docs.docker.com/compose/) v2 or newer (comes bundled with recent Docker Desktop releases)

## 1. Clone the repository

```bash
git clone https://github.com/<your-org>/or-travel-wp.git
cd or-travel-wp
```

## 2. Start the local stack

From the repository root run:

```bash
docker compose up --build
```

The first run will download the WordPress, MySQL, and phpMyAdmin images. Once the containers start:

- WordPress will be available at **http://localhost:8000**
- phpMyAdmin (optional database management UI) will be available at **http://localhost:8080**

> **Tip:** Use `docker compose up -d` to start the containers in detached mode. To stop the stack run `docker compose down`.

## 3. Complete the WordPress installer

Because the WordPress core files are provided by the Docker image, you must complete the standard installation flow the first time the containers are started:

1. Browse to [http://localhost:8000](http://localhost:8000)
2. Select the language and click **Continue**
3. Provide the site title, admin username, password, and email
4. Click **Install WordPress** and then log in using the credentials you just created

The database credentials used in the installer must match the defaults defined in `docker-compose.yml`:

- **Database host:** `db`
- **Database name:** `wordpress`
- **Username:** `wordpress`
- **Password:** `wordpress`

These values are prefilled automatically, but you can adjust them if you modify the compose file.

## 4. Activate the theme

After logging into the WordPress dashboard:

1. Navigate to **Appearance → Themes**
2. Locate the **OR Travel Child** theme
3. Click **Activate**

The repository mounts `wp-content` into the container, so any changes you make to the theme locally are reflected immediately inside WordPress. Version control should only track the `wp-content/themes/or-travel-child` directory.

## 5. Managing the database

The stack provisions a persistent Docker volume named `db_data` for MySQL storage. Use the following commands during development:

- `docker compose down` – stops containers but keeps data
- `docker compose down --volumes` – stops containers and **removes** the database volume (destroys data)
- `docker compose exec db /usr/bin/mysqldump -u wordpress -pwordpress wordpress > backup.sql` – creates a database dump

You can also manage the database via phpMyAdmin at [http://localhost:8080](http://localhost:8080) using the same credentials (`wordpress` / `wordpress`).

## 6. Common tasks

### Accessing WP-CLI

```bash
docker compose run --rm wordpress wp <command>
```

Example: `docker compose run --rm wordpress wp plugin list`

### Viewing logs

```bash
docker compose logs -f wordpress
```

### Updating WordPress core or plugins

The WordPress container ships with the latest core files for the specified image tag. To upgrade:

1. Update the `image` tag in `docker-compose.yml`
2. Run `docker compose pull`
3. Restart the stack with `docker compose up -d`

### Installing additional plugins or uploads

By default, uploads and plugins are not committed to the repository. Install them within the running WordPress instance. If you need to persist plugins in version control, update `.gitignore` accordingly.

## 7. Troubleshooting

- **Port already in use:** Adjust the exposed ports in `docker-compose.yml` (e.g., change `8000:80` to `8088:80`).
- **Resetting the environment:** Run `docker compose down --volumes` to remove the database, then start the stack again and rerun the installer.
- **File permission errors on macOS/Linux:** Ensure the repository is owned by your user and not `root`. You can fix permissions with `sudo chown -R $(whoami) .` if necessary.

## 8. Cleaning up

When you are finished working:

```bash
docker compose down
```

This stops all services while leaving the database volume intact for the next session.
