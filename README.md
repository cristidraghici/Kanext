# Kanext

> Improved and expanded theme for [kanboard](https://github.com/kanboard/kanboard), that alters both look and functionality.

## Kanboard

Kanboard provides the basic necessary functionality for handling kanban projects. Moreover, it is a popular piece of software with a lot of community support.
Kanboard is currently at **1.2.11**.

## Development

- path assumptions:
  - `@/` is the root of `Kanboard`;
  - `~/` is the root of this repo;
  - `./` is an alias of `~/src`.
- the source code for the theme is in `~/src`; 
- `~/Plugin.php` a placeholder which only loads the main plugin file, in case the the install was done by cloning the repo.
- `Docker` / `docker-compose` required (these commands are assumed in `./docker/`):
  - ! Important notice ! This is a development only option;
  - start command: `docker-compose up --build --force-recreate` or `docker-compose start`; 
    - `kanboard` will be available at [http://localhost:88](http://localhost:88)
  - stop: `docker-compose stop`
