#!/bin/bash

# 脚本名称：install-simple-plugin.sh
# 功能：自动化安装简单插件
# 使用方法：./install-simple-plugin.sh

# 颜色定义
GREEN="\033[0;32m"
YELLOW="\033[1;33m"
RED="\033[0;31m"
NC="\033[0m" # No Color

# 插件目录
PLUGIN_DIR=$(pwd)

# 站点根目录
SITE_ROOT=$(dirname "$(dirname "$PLUGIN_DIR")")

# 输出信息函数
echo_info() {
    echo -e "${GREEN}[INFO]${NC} $1"
}

echo_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

echo_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# 检查命令是否存在
check_command() {
    if ! command -v $1 &> /dev/null; then
        echo_error "命令 $1 不存在，请安装后重试"
        exit 1
    fi
}

# 步骤1：检查环境
echo_info "步骤1：检查环境"

# 检查必要的命令
check_command "composer"
check_command "php"

# 检查插件目录是否存在
if [ ! -d "$PLUGIN_DIR" ]; then
    echo_error "插件目录 $PLUGIN_DIR 不存在，请先下载插件到该目录"
    exit 1
fi

# 检查Composer配置文件是否存在
if [ ! -f "$SITE_ROOT/composer.json" ]; then
    echo_error "Composer配置文件 $SITE_ROOT/composer.json 不存在"
    exit 1
fi

# 步骤2：修改Composer配置
echo_info "步骤2：修改Composer配置"

# 检查是否已经添加了仓库配置
if ! grep -q "simple-plugin" "$SITE_ROOT/composer.json"; then
    echo_info "添加仓库配置到 composer.json"
    # 备份原始文件
    cp "$SITE_ROOT/composer.json" "$SITE_ROOT/composer.json.bak"
    
    # 使用jq工具修改composer.json（如果存在）
    if command -v jq &> /dev/null; then
        # 添加repositories配置
        jq '.repositories += {"simple-plugin": {"type": "path", "url": "./packages/simple-plugin"}}' "$SITE_ROOT/composer.json" > "$SITE_ROOT/composer.json.tmp"
        mv "$SITE_ROOT/composer.json.tmp" "$SITE_ROOT/composer.json"
        
        # 添加autoload配置
        jq '.autoload.psr-4 += {"NexusPlugin\\SimplePlugin\\": "packages/simple-plugin/src/"}' "$SITE_ROOT/composer.json" > "$SITE_ROOT/composer.json.tmp"
        mv "$SITE_ROOT/composer.json.tmp" "$SITE_ROOT/composer.json"
        
        # 添加依赖配置
        jq '.require-dev += {"nexusphp/simple-plugin": "dev-main"}' "$SITE_ROOT/composer.json" > "$SITE_ROOT/composer.json.tmp"
        mv "$SITE_ROOT/composer.json.tmp" "$SITE_ROOT/composer.json"
    else
        echo_warning "jq工具不存在，跳过自动修改composer.json，请手动添加配置"
        echo_info "请在composer.json中添加以下配置："
        echo ""
        echo "repositories部分："
        echo "{"
        echo "    \"simple-plugin\": {"
        echo "        \"type\": \"path\","
        echo "        \"url\": \"./packages/simple-plugin\""
        echo "    }"
        echo "}"
        echo ""
        echo "autoload.psr-4部分："
        echo "{"
        echo "    \"NexusPlugin\\SimplePlugin\\\": \"packages/simple-plugin/src/\""
        echo "}"
        echo ""
        echo "require-dev部分："
        echo "{"
        echo "    \"nexusphp/simple-plugin\": \"dev-main\""
        echo "}"
        echo ""
        read -p "请确认已手动添加配置，按Enter键继续..."
    fi
else
    echo_info "Composer配置已存在，跳过修改"
fi

# 步骤3：安装插件
echo_info "步骤3：安装插件"

# 重新生成自动加载文件并清除缓存
echo_info "执行 composer dump-autoload"
composer dump-autoload

echo_info "执行 php artisan config:clear"
php artisan config:clear

echo_info "执行 php artisan cache:clear"
php artisan cache:clear

# 安装插件
echo_info "执行 composer require nexusphp/simple-plugin"
composer require nexusphp/simple-plugin

# 步骤4：复制公共文件
echo_info "步骤4：复制公共文件"

# 复制简单插件的公共文件到站点public目录
echo_info "复制公共文件到站点public目录"
cp -r "$PLUGIN_DIR/public/*" "$SITE_ROOT/public/"

# 确保文件权限正确
echo_info "设置文件权限"
chmod -R 755 "$SITE_ROOT/public/"

# 步骤5：清除缓存
echo_info "步骤5：清除缓存"

# 回到站点根目录
cd "$SITE_ROOT"

# 清除配置缓存
echo_info "执行 php artisan config:clear"
php artisan config:clear

# 清除缓存
echo_info "执行 php artisan cache:clear"
php artisan cache:clear

# 重新生成自动加载文件
echo_info "执行 composer dump-autoload"
composer dump-autoload

# 步骤6：显示安装结果
echo_info "步骤6：安装完成"
echo_info "简单插件安装成功！"
echo_info "\n使用说明："
echo_info "1. 访问 http://your-site.com/simple-plugin 查看插件页面"
echo_info "2. 在后台管理中查看 Simple Plugin 页面"
echo_info "3. 导航栏中已添加 Simple Plugin 链接"
echo_info "\n如果遇到问题，请检查安装过程中的错误信息"
