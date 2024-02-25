# Kanext

> Improved and expanded theme for [kanboard](https://github.com/kanboard/kanboard), that alters both look and functionality.

## Important notice

- Version 3.x.x brings more fundamental changes to the project, thus please do not update if you are happy previous versions.
- The docker configuration is for development purposes only. Only use the theme in production!
- The issues are being taken into consideration. Due to this being a spare-spare time project and time limitations, PRs are welcome! 😺

## Kanext theme

`Kanext` is short for `Kanboard-Extended`. This plugin is supposed to change some parts of the templates kanboard uses (e.g. the dashboard) to increase productivity for small teams.

Other UI improvements are available as well:

- different menu structure;
- just another CSS theme;
- small changes in the overall functionality (e.g. close modal on outside click, close dropdown on second click in the anchor)

For now, `Kanext` contains a lot of functionality in one place. This is convenient, as it is rather easy to maintain. In the future, it might be broken into smaller plugins.

### Screenshot

This screenshot is made together with the **GreenWing** plugin/template, which we strongly recommend.

![Dashboard with GreenWing and Kanext](/.screenshots/dashboard.png?raw=true "Dashboard with GreenWing and Kanext")

### Development

An easy way to start a development environment is to use the docker configuration:

- `cd .docker`
- `docker compose up`

The app will be available at: [http://localhost:88](http://localhost:88/) with the `admin`/`admin` combination for username and password.

We use as base a [kanboard image from the docker hub](https://hub.docker.com/r/kanboard/kanboard/tags).

## Kanboard

- Kanboard provides the basic necessary functionality for handling kanban projects. Moreover, it is a popular piece of software with a lot of community support.
- Kanboard is currently at **1.2.13**.
