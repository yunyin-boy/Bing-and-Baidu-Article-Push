<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bing and Baidu Article Push</title>
</head>
<body>
    <h1>Bing and Baidu Article Push</h1>
    <p>Automatically push articles to Bing and Baidu with options for manual push, logging, and viewing content submission quota. This plugin allows you to manually push articles to Bing and Baidu, set scheduled pushes, and manage API keys and site URLs from the WordPress admin panel.</p>
    
    <h2>Features</h2>
    <ul>
        <li><strong>Manual Push</strong>: Push selected articles to Bing and Baidu manually.</li>
        <li><strong>Scheduled Push</strong>: Schedule up to 5 different times for daily pushes to Bing and Baidu.</li>
        <li><strong>API Key Management</strong>: Manage your Bing API Key and Baidu Token from the settings page.</li>
        <li><strong>Site URL Configuration</strong>: Configure the Baidu Site URL from the settings page.</li>
        <li><strong>Quota Information</strong>: View your Bing content submission quota.</li>
    </ul>
    
    <h2>Installation</h2>
    <ol>
        <li>Download the plugin files.</li>
        <li>Upload the plugin folder to the <code>/wp-content/plugins/</code> directory.</li>
        <li>Activate the plugin through the 'Plugins' menu in WordPress.</li>
    </ol>
    
    <h2>Usage</h2>
    <h3>Configuration</h3>
    <ol>
        <li>Go to the WordPress admin panel.</li>
        <li>Navigate to <strong>Bing and Baidu Article Push</strong> in the admin menu.</li>
        <li>Enter your Bing API Key, Baidu Token, and Baidu Site URL (without trailing slash).</li>
        <li>Click <strong>Save Changes</strong> to store the settings.</li>
    </ol>
    
    <h3>Manual Push</h3>
    <ol>
        <li>Navigate to <strong>Bing and Baidu Article Push</strong> in the admin menu.</li>
        <li>Under <strong>Manual Push to Bing</strong>, enter the number of posts you want to push (default is 10).</li>
        <li>Click <strong>Push Posts to Bing</strong>.</li>
        <li>Repeat the same steps for <strong>Manual Push to Baidu</strong>.</li>
    </ol>
    
    <h3>Scheduled Push</h3>
    <ol>
        <li>Navigate to <strong>Bing and Baidu Article Push</strong> in the admin menu.</li>
        <li>Under <strong>Scheduled Push</strong>, set up to 5 different times for scheduled pushes (format: HH:MM).</li>
        <li>Click <strong>Set Schedule</strong>.</li>
    </ol>
    
    <h3>Viewing Quota</h3>
    <ol>
        <li>Navigate to <strong>Bing and Baidu Article Push</strong> in the admin menu.</li>
        <li>View your Bing content submission quota under <strong>Content Submission Quota</strong>.</li>
    </ol>
    
    <h2>Log Files</h2>
    <p>The plugin creates log files for Bing and Baidu pushes, located in the plugin directory:</p>
    <ul>
        <li><code>bing_push_log.txt</code></li>
        <li><code>baidu_push_log.txt</code></li>
    </ul>
    
    <h2>Changelog</h2>
    <h3>Version 1.2</h3>
    <ul>
        <li>Added support for Baidu site URL configuration.</li>
        <li>Enhanced error handling and logging.</li>
        <li>Implemented scheduled push functionality.</li>
        <li>Updated the settings page to include time configuration for scheduled pushes.</li>
    </ul>
    
    <h2>License</h2>
    <p>This plugin is licensed under the GPL v2.0. See the <code>LICENSE</code> file for more information.</p>
    
    <h2>Support</h2>
    <p>For support and feature requests, please contact the plugin author at <a href="mailto:your-email@example.com">your-email@example.com</a>.</p>
</body>
</html>
