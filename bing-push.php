<?php

// Bing 推送功能
function bap_push_to_bing($post_ID) {
    $siteUrl = get_site_url();
    $url = get_permalink($post_ID);
    $apikey = get_option('bap_api_key');
    $api_endpoint = "https://ssl.bing.com/webmaster/api.svc/json/SubmitUrl?apikey=$apikey";

    $body = json_encode(array(
        'siteUrl' => $siteUrl,
        'url' => $url
    ));

    $response = wp_remote_post($api_endpoint, array(
        'headers' => array(
            'Content-Type' => 'application/json; charset=utf-8'
        ),
        'body' => $body,
        'method' => 'POST',
        'data_format' => 'body'
    ));

    $log_entry = '[' . date('Y-m-d H:i:s') . '] Bing URL: ' . $url . PHP_EOL;

    if (is_wp_error($response)) {
        $error_message = 'Bing Article Push Error: ' . $response->get_error_message();
        error_log($error_message);
        $log_entry .= $error_message . PHP_EOL;
        file_put_contents(plugin_dir_path(__FILE__) . 'bing_push_log.txt', $log_entry, FILE_APPEND);
        return false;
    }

    $response_code = wp_remote_retrieve_response_code($response);
    $response_body = wp_remote_retrieve_body($response);

    if ($response_code != 200) {
        $error_message = "Bing Article Push Failed, HTTP Status Code: $response_code. Body: $response_body";
        error_log($error_message);
        $log_entry .= $error_message . PHP_EOL;
        file_put_contents(plugin_dir_path(__FILE__) . 'bing_push_log.txt', $log_entry, FILE_APPEND);
        return false;
    }

    $log_entry .= "Successfully pushed URL to Bing. Response: $response_body" . PHP_EOL;
    file_put_contents(plugin_dir_path(__FILE__) . 'bing_push_log.txt', $log_entry, FILE_APPEND);

    return true;
}
?>
