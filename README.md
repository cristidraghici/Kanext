# Kanext

An extended theme and feature plugin for
[Kanboard](https://github.com/kanboard/kanboard) designed to boost productivity
for small teams.

## Features

Kanext alters both the look and core functionality of Kanboard, providing:

- **Custom Dashboards**: Redesigned overviews to quickly see tasks, activities,
  and comments.
- **UI Enhancements**: Restructured menus, refined CSS styling, and
  quality-of-life UX improvements (e.g., closing modals by clicking outside
  them).
- **Task Management**: Advanced capabilities to limit tasks within swimlanes and
  enforce global team conventions.

## Screenshot

_Shown running alongside the recommended **GreenWing** theme plugin:_

![Dashboard with GreenWing and Kanext](.screenshots/dashboard.png?raw=true 'Dashboard with GreenWing and Kanext')

## Development Environment

We provide a zero-configuration Docker setup using the official Kanboard image
to make contributing incredibly easy.

1. Start the container from the project root:
   ```bash
   docker compose up -d
   ```
2. Open your browser to [http://localhost:88](http://localhost:88).
3. Log in using the default credentials (`admin` / `admin`).

PHP caching is automatically disabled in this environment, so your code changes
will immediately reflect upon refreshing the browser.
