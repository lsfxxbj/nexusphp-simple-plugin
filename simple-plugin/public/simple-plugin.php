<?php
require_once(dirname(__FILE__) . '/../../../include/bittorrent.php');
dbconn();

stdhead("Simple Plugin");

if (!$CURUSER) {
    stdmsg("错误", "请先登录后访问。");
    stdfoot();
    exit;
}

try {
    $repo = new \NexusPlugin\SimplePlugin\SimplePluginRepository();
    
    // 检查插件是否启用
    $settings = $repo->getSettings();
    if (!$settings['enabled'] ?? true) {
        stdmsg("错误", "插件已被禁用。");
        stdfoot();
        exit;
    }
    
    echo '<div class="main_column">';
    echo '<h1>Simple Plugin</h1>';
    echo '<div class="text">';
    echo '<p>欢迎使用 Simple Plugin！</p>';
    echo '<p>这是一个简单的插件示例，用于演示如何开发 NexusPHP 插件。</p>';
    echo '<p>插件版本：' . $repo::VERSION . '</p>';
    echo '<p>兼容 NexusPHP 版本：' . $repo::COMPATIBLE_NP_VERSION . '</p>';
    echo '</div>';
    echo '</div>';
    
} catch (\Exception $e) {
    stdmsg("错误", "加载插件时出错: " . $e->getMessage());
}

stdfoot();
?>