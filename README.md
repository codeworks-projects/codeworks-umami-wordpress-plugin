# CodeWorks Umami: WordPress Umami Analytics Integration

Seamlessly integrate [Umami Analytics](https://umami.is/) with your WordPress site, enabling privacy-focused, self-hosted web analytics without modifying your theme files.

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [License](#license)
- [Credits](#credits)

## Features

*   **Easy Integration**: Seamlessly adds Umami tracking code to your WordPress site.
*   **Admin Settings Page**: Configure your Umami Website ID and Script URL directly from the WordPress dashboard.
*   **Optimized Script Loading**: Loads the Umami script with `async` and `defer` attributes for better performance.
*   **Clean Uninstallation**: Removes all plugin-related options from your database upon uninstallation.
*   **Developer-Friendly**: Built with modern PHP practices, namespaces, and WordPress best practices.

## Installation

1.  **Download** the plugin ZIP file from the [releases page](https://github.com/codeworks-projects/codeworks-umami-wordpress-plugin/releases).
2.  **Upload** the plugin to your WordPress site via `Plugins > Add New > Upload Plugin`.
3.  **Activate** the plugin through the 'Plugins' menu in WordPress.

## Configuration

1.  After activating the plugin, navigate to `Settings > Umami Analytics` in your WordPress admin dashboard.
2.  **Umami Website ID**: Enter the Website ID provided by your Umami Analytics instance. This is a unique identifier (e.g., `xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx`).
3.  **Umami Script URL**: Enter the full URL to your Umami tracking script (e.g., `https://your-umami-instance.com/script.js`).
4.  **Save Changes**: Click the 'Save Changes' button.

The Umami tracking script will now be automatically added to the footer of your website's frontend pages.

## Usage

Once configured, the plugin operates automatically, sending your website's traffic data to your specified Umami Analytics instance. You can verify proper integration by checking your Umami Analytics dashboard for incoming data.

## License

This project is licensed under the MIT License. See the [LICENSE](./LICENSE) file for details.

---

**Codeworks:** [https://codeworks.build](https://codeworks.build)

**Luca Visciola:** [https://github.com/melasistema](https://github.com/melasistema)
