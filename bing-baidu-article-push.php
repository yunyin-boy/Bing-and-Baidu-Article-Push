<?php
/*
Plugin Name: Bing and Baidu Article Push
Description: Automatically push articles to Bing and Baidu with options for manual push, logging, and viewing content submission quota.
Version: 1.2
Author: Your Name
*/

if (!defined('WPINC')) {
    die;
}

// 添加后台菜单
add_action('admin_menu', 'bap_add_admin_menu');
function bap_add_admin_menu() {
    add_menu_page('Bing and Baidu Article Push', 'Bing and Baidu Article Push', 'manage_options', 'bing-baidu-article-push', 'bap_settings_page');
}

// 设置页面
function bap_settings_page() {
    $quota_info = bap_get_content_submission_quota();  // 获取配额信息
    ?>
    <div class="wrap">
        <h2>Bing and Baidu Article Push Settings</h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('bap_plugin_settings');
            do_settings_sections('bap_plugin_settings');
            submit_button();
            ?>
        </form>
        <h2>Content Submission Quota</h2>
        <p><?php echo $quota_info; ?></p>  <!-- 显示配额信息 -->
        <h2>Manual Push to Bing</h2>
        <form method="post">
            <input type="number" name="num_posts_bing" placeholder="Number of posts (default 10)">
            <input type="submit" name="bap_push_bing" value="Push Posts to Bing">
        </form>
        <h2>Manual Push to Baidu</h2>
        <form method="post">
            <input type="number" name="num_posts_baidu" placeholder="Number of posts (default 10)">
            <input type="submit" name="bap_push_baidu" value="Push Posts to Baidu">
        </form>
        <h2>Scheduled Push</h2>
        <form method="post" action="">
            <p>Set up to 5 different times for scheduled pushes (format: HH:MM):</p>
            <?php for ($i = 1; $i <= 5; $i++): ?>
                <input type="time" name="scheduled_time_<?php echo $i; ?>" value="<?php echo get_option('scheduled_time_' . $i); ?>">
            <?php endfor; ?>
            <input type="submit" name="set_schedule" value="Set Schedule">
        </form>
    </div>
    <?php
    if (isset($_POST['bap_push_bing'])) {
        bap_manual_push_bing();
    }
    if (isset($_POST['bap_push_baidu'])) {
        bap_manual_push_baidu();
    }
    if (isset($_POST['set_schedule'])) {
        bap_set_schedule();
    }
}

// 注册设置
add_action('admin_init', 'bap_register_settings');
function bap_register_settings() {
    register_setting('bap_plugin_settings', 'bap_api_key');
    add_settings_section('bap_plugin_main', 'Main Settings', 'bap_plugin_section_text', 'bap_plugin_settings');
    add_settings_field('bap_api_key', 'Bing API Key', 'bap_display_api_key_input', 'bap_plugin_settings', 'bap_plugin_main');
    
    register_setting('bap_plugin_settings', 'baidu_token');
    add_settings_field('baidu_token', 'Baidu Token', 'bap_display_baidu_token_input', 'bap_plugin_settings', 'bap_plugin_main');
    
    register_setting('bap_plugin_settings', 'baidu_site', 'bap_sanitize_baidu_site');
    add_settings_field('baidu_site', 'Baidu Site URL <br>(Do not put / after the URL)', 'bap_display_baidu_site_input', 'bap_plugin_settings', 'bap_plugin_main');
    
    for ($i = 1; $i <= 5; $i++) {
        register_setting('bap_plugin_settings', 'scheduled_time_' . $i);
    }
}

function bap_plugin_section_text() {
    echo '<p>Enter your Bing API Key, Baidu Token, and Baidu Site URL below:</p>';
}

function bap_display_api_key_input() {
    $option = get_option('bap_api_key');
    echo "<input type='text' name='bap_api_key' value='" . esc_attr($option) . "' />";
}

function bap_display_baidu_token_input() {
    $option = get_option('baidu_token');
    echo "<input type='text' name='baidu_token' value='" . esc_attr($option) . "' />";
}

function bap_display_baidu_site_input() {
    $option = get_option('baidu_site');
    echo "<input type='text' name='baidu_site' value='" . esc_attr($option) . "' />";
}

function bap_sanitize_baidu_site($input) {
    return rtrim($input, '/');
}

// 手动推送到 Bing
function bap_manual_push_bing() {
    if (!empty($_POST['num_posts_bing'])) {
        $num_posts = intval($_POST['num_posts_bing']);
        $args = array(
            'posts_per_page' => $num_posts,
            'post_status' => 'publish',
            'post_type' => 'post'
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            include_once plugin_dir_path(__FILE__) . 'bing-push.php';
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();
                $result = bap_push_to_bing($post_id);
                echo '<p>Pushed "' . get_the_title($post_id) . '": Bing ' . ($result ? 'Success' : 'Failed') . '</p>';
            }
            wp_reset_postdata();
        } else {
            echo '<p>No posts found to push.</p>';
        }
    }
}

// 手动推送到 Baidu
function bap_manual_push_baidu() {
    if (!empty($_POST['num_posts_baidu'])) {
        $num_posts = intval($_POST['num_posts_baidu']);
        $args = array(
            'posts_per_page' => $num_posts,
            'post_status' => 'publish',
            'post_type' => 'post'
        );
        $query = new WP_Query($args);
        if ($query->have_posts()) {
            include_once plugin_dir_path(__FILE__) . 'baidu-push.php';
            while ($query->have_posts()) {
                $query->the_post();
                $post_id = get_the_ID();
                $result = bap_push_to_baidu($post_id);
                echo '<p>Pushed "' . get_the_title($post_id) . '": Baidu ' . ($result ? 'Success' : 'Failed') . '</p>';
            }
            wp_reset_postdata();
        } else {
            echo '<p>No posts found to push.</p>';
        }
    }
}

// 定时推送功能
function bap_set_schedule() {
    for ($i = 1; $i <= 5; $i++) {
        $time = sanitize_text_field($_POST['scheduled_time_' . $i]);
        update_option('scheduled_time_' . $i, $time);

        if ($time) {
            list($hour, $minute) = explode(':', $time);
            $timestamp = mktime($hour, $minute, 0);

            // 确保任务不会重复注册
            if (!wp_next_scheduled('bap_scheduled_push_' . $i)) {
                wp_schedule_event($timestamp, 'daily', 'bap_scheduled_push_' . $i);
            }
        }
    }
}

// 注册定时事件的钩子
for ($i = 1; $i <= 5; $i++) {
    add_action('bap_scheduled_push_' . $i, 'bap_scheduled_push');
}

function bap_scheduled_push() {
    $num_posts = 10; // 默认推送最新的10篇文章
    $args = array(
        'posts_per_page' => $num_posts,
        'post_status' => 'publish',
        'post_type' => 'post'
    );
    $query = new WP_Query($args);
    if ($query->have_posts()) {
        include_once plugin_dir_path(__FILE__) . 'bing-push.php';
        include_once plugin_dir_path(__FILE__) . 'baidu-push.php';
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $bing_result = bap_push_to_bing($post_id);
            $baidu_result = bap_push_to_baidu($post_id);
            // 记录日志或其他操作
        }
        wp_reset_postdata();
    }
}

// 获取内容提交配额
function bap_get_content_submission_quota() {
    $siteUrl = get_site_url();
    $apikey = get_option('bap_api_key');
    $api_endpoint = "https://ssl.bing.com/webmaster/api.svc/json/GetContentSubmissionQuota?siteUrl=$siteUrl&apikey=$apikey";

    $response = wp_remote_get($api_endpoint, array(
        'headers' => array(
            'Content-Type' => 'application/json; charset=utf-8'
        )
    ));

    if (is_wp_error($response)) {
        return 'Error retrieving quota: ' . $response->get_error_message();
    }

    $response_body = wp_remote_retrieve_body($response);
    $data = json_decode($response_body, true);

    if (isset($data['d'])) {
        $dailyQuota = isset($data['d']['DailyQuota']) ? $data['d']['DailyQuota'] : 'N/A';
        $dailyQuotaRemaining = isset($data['d']['DailyQuotaRemaining']) ? $data['d']['DailyQuotaRemaining'] : 'N/A';
        return 'Daily Quota: ' . $dailyQuota . ', Remaining: ' . $dailyQuotaRemaining;
    } else {
        return 'Failed to retrieve data';
    }
}

// 激活时设置
register_activation_hook(__FILE__, 'bap_activate');
function bap_activate() {
    if (!wp_next_scheduled('bap_cron_push')) {
        wp_schedule_event(time(), 'hourly', 'bap_cron_push');
    }
}

register_deactivation_hook(__FILE__, 'bap_deactivate');
function bap_deactivate() {
    wp_clear_scheduled_hook('bap_cron_push');
    for ($i = 1; $i <= 5; $i++) {
        wp_clear_scheduled_hook('bap_scheduled_push_' . $i);
    }
}

// 定时推送任务
add_action('bap_cron_push', 'bap_do_cron_push');
function bap_do_cron_push() {
    // 定时任务的逻辑可以与手动推送类似
}
?>
