<?php

namespace NexusPlugin\SimplePlugin;

use Nexus\Plugin\BasePlugin;
use Filament\Forms\Components\Tabs\Tab;

class SimplePluginRepository extends BasePlugin
{
    /**
     * 插件ID
     */
    const ID = 'simple-plugin';
    
    /**
     * 获取插件ID
     */
    public function getId(): string
    {
        return self::ID;
    }
    
    /**
     * 插件版本
     */
    const VERSION = '1.0.0';
    
    /**
     * 兼容的NexusPHP版本
     */
    const COMPATIBLE_NP_VERSION = '1.7.21';

    /**
     * 插件安装时执行
     */
    public function install(): void
    {
        do_log("Simple Plugin installed successfully!");
    }

    /**
     * 插件启动时执行
     */
    public function boot(): void
    {
        $this->registerHooks();
        do_log("Simple Plugin booted!");
    }

    /**
     * 注册Hook
     */
    protected function registerHooks(): void
    {
        global $hook;
        
        // 添加导航栏链接
        $hook->addAction('nexus_header', [$this, 'addSimplePluginLink'], 10, 0);
        
        // 添加首页内容
        $hook->addAction('nexus_footer', [$this, 'addHomePageContent'], 10, 0);
        
        // 添加设置标签页
        $hook->addFilter('nexus_setting_tabs', [$this, 'addSettingTab'], 10, 1);
    }

    /**
     * 添加设置标签页
     */
    public function addSettingTab(array $tabs): array
    {
        try {
            $tabs[] = Tab::make('简单插件')
                ->id('simple-plugin')
                ->schema([
                    \Filament\Forms\Components\Section::make('首页显示设置')
                        ->schema([
                            \Filament\Forms\Components\Select::make('simple_plugin.homepage_position')
                                ->label('首页显示位置')
                                ->options([
                                    'top' => '顶部（最近消息上方）',
                                    'fun_box' => '趣味盒',
                                    'chat_box' => '群聊区',
                                    'vote' => '投票',
                                    'site_data' => '站点数据',
                                    'server_load' => '服务器负载',
                                    'disclaimer' => '免责条款',
                                    'friend_links' => '友情链接',
                                    'bottom' => '底部（所有内容下方）',
                                    'disable' => '禁用'
                                ])
                                ->default('chat_box')
                                ->helperText('选择插件在首页的显示位置，插件将显示在所选元素的上方（底部位置除外）'),
                        ])
                        ->columns(1),
                    
                    \Filament\Forms\Components\Section::make('插件设置')
                        ->schema([
                            \Filament\Forms\Components\Toggle::make('simple_plugin.enabled')
                                ->label('启用插件')
                                ->default(true)
                                ->helperText('关闭后插件将不可访问'),
                        ])
                        ->columns(1),
                ]);
            return $tabs;
        } catch (\Exception $e) {
            do_log("Simple Plugin: addSettingTab() failed: " . $e->getMessage());
            return $tabs;
        }
    }

    /**
     * 获取插件设置
     */
    public function getSettings(): array
    {
        try {
            $sql = "SELECT name, value FROM settings WHERE name LIKE 'simple_plugin.%'";
            $results = \Nexus\Database\NexusDB::select($sql);

            $settings = [];
            foreach ($results as $result) {
                $key = str_replace('simple_plugin.', '', $result['name']);
                $settings[$key] = $result['value'];
            }
        } catch (\Exception $e) {
            $settings = [];
        }

        $defaults = [
            'enabled' => true,
            'homepage_position' => 'middle',
            'homepage_title' => '简单插件'
        ];

        return array_merge($defaults, $settings);
    }

    /**
     * 添加简单插件链接到菜单末尾
     */
    public function addSimplePluginLink(): void
    {
        $settings = $this->getSettings();
        if (!$settings['enabled'] ?? true) {
            return;
        }

        echo '<script src="/plugins/simple-plugin/js/simple-plugin.js"></script>
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            addSimplePluginLink();
        });
        </script>';
    }

    /**
     * 添加首页内容
     */
    public function addHomePageContent(): void
    {
        $settings = $this->getSettings();
        $currentScript = $_SERVER['SCRIPT_NAME'] ?? '';
        if (!str_contains($currentScript, 'index.php') && $currentScript !== '/') {
            return;
        }

        // 检查插件是否启用
        if (!$settings['enabled'] ?? true) {
            return;
        }

        echo $this->renderHomePageContent($settings);
    }

    /**
     * 渲染首页内容
     */
    public function renderHomePageContent(array $settings): string
    {
        $position = $settings['homepage_position'] ?? 'chat_box';
        
        if ($position === 'disable') {
            return '';
        }

        $content = '<h2>🎯 简单插件 <font class="small"> - [<a class="altlink" href="simple-plugin.php"><b>查看详情</b></a>]</font></h2>
                    <table width="100%">
                        <tbody><tr><td class="text">
                            <div style="padding: 15px; background: #f9f9f9; border-radius: 4px;">
                                <p>这是一个简单的 NexusPHP 插件示例，演示了如何：</p>
                                <ul style="margin: 10px 0; padding-left: 20px;">
                                    <li>在导航栏添加链接</li>
                                    <li>在首页显示内容</li>
                                    <li>创建后台管理页面</li>
                                    <li>集成到系统设置中</li>
                                </ul>
                                <p style="margin-top: 10px;">插件状态：<span style="color: green; font-weight: bold;">已启用</span></p>
                            </div>
                        </td></tr>
                        </tbody></table>';

        return '<script src="/plugins/simple-plugin/js/simple-plugin.js"></script>
        <script>
        document.addEventListener("DOMContentLoaded", function() {
            initializeSimplePlugin("' . $position . '", `' . addslashes($content) . '`);
        });
        </script>';
    }

    /**
     * 插件卸载时执行
     */
    public function uninstall(): void
    {
        do_log("Simple Plugin uninstalled successfully!");
    }
}