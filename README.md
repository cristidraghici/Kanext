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

Fyi: the latest version of GreenWing has an error and after installing, you need
to manually rename the plugin folder from `Greenwing-1.3.2` to `Greenwing`.

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

### Git Hooks

Before committing code, initialize the local repository hooks:

```bash
make init
```

This ensures Kanext's custom `.githooks` are active, which will automatically
run the code formatter before every commit and the syntax linter before every
push.

### Pre-Push Checklist

Before pushing your commits to the repository, please verify the following,
which is not an exhaustive list:

- [ ] **Format the Code**: Run `make format` to ensure both PHP and frontend
      code adhere to the project's formatting rules.
- [ ] **Run Linters**: Execute `make lint` to run the language checkers,
      catching syntax errors and coding standard violations.
- [ ] **Check Translations**: Ensure all new translation strings are added and
      correct (this is included in `make lint` via `make check-translations`).
- [ ] **Run Tests**: Ensure all PHPUnit tests in the `Test/` directory pass
      successfully.
- [ ] **Manual Testing**: Verify UI/UX changes locally in the browser via the
      Docker environment.
- [ ] **Documentation**: Update the `README.md` if any new features or
      configurations were added.
- [ ] **Dependencies**: Ensure `composer.lock` or `package-lock.json` are
      committed if you added or updated any dependencies.
- [ ] **Versioning**: Update the plugin version number in `Plugin.php` if
      preparing for a new release.
- [ ] **Follow Guidelines**: Make sure your changes follow the project's coding
      guidelines and conventions.
- [ ] **Update `.gitattributes`**: If you added new folders or files at the root
      directory that shouldn't be included in the final release build, remember
      to add them to `.gitattributes` (with `export-ignore`) to avoid having
      them in the build.
