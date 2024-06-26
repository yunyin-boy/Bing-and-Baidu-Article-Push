# Bing and Baidu Article Push
 [中文介绍](README-zh.md).
- Automatically push articles to Bing and Baidu with options for manual push, logging, and viewing content submission quota. This plugin allows you to manually push articles to Bing and Baidu, set scheduled pushes, and manage API keys and site URLs from the WordPress admin panel.

## Features

- **Manual Push**: Push selected articles to Bing and Baidu manually.
- **Scheduled Push**: Schedule up to 5 different times for daily pushes to Bing and Baidu.
- **API Key Management**: Manage your Bing API Key and Baidu Token from the settings page.
- **Site URL Configuration**: Configure the Baidu Site URL from the settings page.
- **Quota Information**: View your Bing content submission quota.

## Installation

1. Download the plugin files.
2. Upload the plugin folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.

## Usage

### Configuration

1. Go to the WordPress admin panel.
2. Navigate to **Bing and Baidu Article Push** in the admin menu.
3. Enter your Bing API Key, Baidu Token, and Baidu Site URL (without trailing slash).
4. Click **Save Changes** to store the settings.

### Manual Push

1. Navigate to **Bing and Baidu Article Push** in the admin menu.
2. Under **Manual Push to Bing**, enter the number of posts you want to push (default is 10).
3. Click **Push Posts to Bing**.
4. Repeat the same steps for **Manual Push to Baidu**.

### Scheduled Push

1. Navigate to **Bing and Baidu Article Push** in the admin menu.
2. Under **Scheduled Push**, set up to 5 different times for scheduled pushes (format: HH:MM).
3. Click **Set Schedule**.

### Viewing Quota

1. Navigate to **Bing and Baidu Article Push** in the admin menu.
2. View your Bing content submission quota under **Content Submission Quota**.

## Log Files

The plugin creates log files for Bing and Baidu pushes, located in the plugin directory:

- `bing_push_log.txt`
- `baidu_push_log.txt`

## Changelog

### Version 1.2
- Added support for Baidu site URL configuration.
- Enhanced error handling and logging.
- Implemented scheduled push functionality.
- Updated the settings page to include time configuration for scheduled pushes.

## License

This plugin is licensed under the GPL v2.0. See the [LICENSE](LICENSE) file for more information.

## Support

For support and feature requests, please contact the plugin author at [jojhaaa@gmail.com](jojhaaa@gmail.com).
