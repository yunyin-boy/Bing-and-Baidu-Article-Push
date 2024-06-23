<?php

// Baidu 推送功能
function bap_push_to_baidu($post_ID) {
    $url = get_permalink($post_ID);
    $token = get_option('baidu_token');
    $site = get_option('baidu_site');
    $api_endpoint = "http://data.zz.baidu.com/urls?site=$site&token=$token";

    $body = $url . "\n";

    $response = wp_remote_post($api_endpoint, array(
        'headers' => array(
            'Content-Type' => 'text/plain'
        ),
        'body' => $body,
        'method' => 'POST'
    ));

    $log_entry = '[' . date('Y-m-d H:i:s') . '] Baidu URL: ' . $url . PHP_EOL;

    if (is_wp_error($response)) {
        $error_message = 'Baidu Article Push Error: ' . $response->get_error_message();
        error_log($error_message);
        $log_entry .= $error_message . PHP_EOL;
        file_put_contents(plugin_dir_path(__FILE__) . 'baidu_push_log.txt', $log_entry, FILE_APPEND);
        return false;
    }

    $response_code = wp_remote_retrieve_response_code($response);
    $response_body = wp_remote_retrieve_body($response);

    if ($response_code != 200) {
        $error_message = "Baidu Article Push Failed, HTTP Status Code: $response_code. Body: $response_body";
        error_log($error_message);
        $log_entry .= $error_message . PHP_EOL;
        file_put_contents(plugin_dir_path(__FILE__) . 'baidu_push_log.txt', $log_entry, FILE_APPEND);
        return false;
    }

    $log_entry .= "Successfully pushed URL to Baidu. Response: $response_body" . PHP_EOL;
    file_put_contents(plugin_dir_path(__FILE__) . 'baidu_push_log.txt', $log_entry, FILE_APPEND);

    return true;
}
?>
