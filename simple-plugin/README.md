# Simple Plugin for NexusPHP

## 插件简介

Simple Plugin 是一个为 NexusPHP 打造的简单插件示例，演示了如何开发 NexusPHP 插件，包括导航栏链接添加、后台设置页面创建、首页内容显示以及位置控制等功能。

## 功能特点

- **导航栏链接**：在 NexusPHP 导航栏中添加插件链接
- **后台设置页面**：通过 Filament 表单创建插件设置页面
- **首页内容显示**：在首页显示插件内容，支持多种位置选择
- **位置控制**：支持在多个位置显示插件内容，包括：
  - 顶部（最近消息上方）
  - 趣味盒
  - 群聊区
  - 投票
  - 站点数据
  - 服务器负载
  - 免责条款
  - 友情链接
  - 底部（所有内容下方）
- **元素未找到处理**：当目标位置元素不存在时，自动使用默认位置
- **响应式设计**：适配不同的页面结构和设备

## 安装说明

### 方法一：使用安装脚本

```bash
chmod +x install-simple-plugin.sh
./install-simple-plugin.sh
```

### 方法二：手动安装

1. 将插件目录复制到 NexusPHP 的 `packages` 目录中
2. 在 `composer.json` 中添加插件配置
3. 运行 `composer dump-autoload` 命令更新自动加载文件
4. 刷新 NexusPHP 页面，插件将自动注册

## 配置选项

插件提供以下配置选项：

### 首页显示设置
- **首页显示位置**：选择插件在首页的显示位置，插件将显示在所选元素的上方（底部位置除外）
  - 顶部（最近消息上方）
  - 趣味盒
  - 群聊区
  - 投票
  - 站点数据
  - 服务器负载
  - 免责条款
  - 友情链接
  - 底部（所有内容下方）
  - 禁用

### 插件设置
- **启用插件**：关闭后插件将不可访问

## 使用方法

1. **访问插件**：通过导航栏中的 "Simple Plugin" 链接访问插件页面
2. **配置插件**：在 NexusPHP 后台的 "简单插件" 设置标签页中配置插件选项
3. **查看效果**：根据配置的位置，插件内容将显示在首页的对应位置

## 代码结构

### 核心文件

- **`src/SimplePluginServiceProvider.php`**：插件服务提供者，负责注册插件到 Laravel 容器
- **`src/SimplePluginRepository.php`**：插件核心逻辑，实现导航栏链接、后台设置和首页内容显示
- **`public/js/simple-plugin.js`**：前端 JavaScript 代码，处理 DOM 操作和位置控制
- **`public/simple-plugin.php`**：插件前端页面
- **`src/Filament/Pages/SimplePluginPage.php`**：插件后台页面
- **`resources/views/filament/pages/simple-plugin.blade.php`**：插件后台页面视图

### 目录结构

```
simple-plugin/
├── composer.json          # 插件配置文件
├── install-simple-plugin.sh  # 安装脚本
├── public/                # 公共文件目录
│   ├── js/               # JavaScript 文件目录
│   │   └── simple-plugin.js  # 前端 JavaScript 代码
│   ├── simple-plugin.php # 插件前端页面
│   └── test-nav-link.php # 测试导航链接
├── resources/            # 资源文件目录
│   └── views/            # 视图文件目录
│       └── filament/      # Filament 视图目录
│           └── pages/     # 页面视图目录
│               └── simple-plugin.blade.php # 插件后台页面视图
├── src/                  # 源代码目录
│   ├── Filament/         # Filament 相关代码
│   │   └── Pages/        # 页面代码目录
│   │       └── SimplePluginPage.php # 插件后台页面
│   ├── SimplePluginServiceProvider.php # 插件服务提供者
│   └── SimplePluginRepository.php # 插件核心逻辑
└── vendor/               # 依赖库目录
```

## 优化说明

### 代码结构优化
- **移除冗余代码**：删除了不必要的 SimplePlugin 类
- **代码分离**：将 JavaScript 代码分离到单独的文件中，提高代码可维护性

### 性能优化
- **DOM 元素查找逻辑优化**：使用 `querySelectorAll` 代替 `getElementsByTagName`，减少遍历次数
- **遍历逻辑优化**：使用 for 循环而不是 forEach，提高性能
- **防抖函数**：添加了防抖函数，优化频繁的 DOM 操作

### 功能优化
- **位置控制**：实现了多种位置选择，支持在不同位置显示插件内容
- **元素未找到处理**：当目标位置元素不存在时，自动使用默认位置
- **响应式设计**：适配不同的页面结构和设备

## 常见问题

### 问题：插件内容未显示

**解决方案**：
1. 检查插件是否已启用
2. 检查选择的显示位置是否存在对应元素
3. 尝试选择不同的显示位置
4. 检查浏览器控制台是否有 JavaScript 错误

### 问题：导航栏链接未显示

**解决方案**：
1. 检查插件是否已启用
2. 刷新页面，确保 DOM 已完全加载
3. 检查浏览器控制台是否有 JavaScript 错误

### 问题：后台设置页面未显示

**解决方案**：
1. 检查插件是否已正确注册
2. 运行 `composer dump-autoload` 更新自动加载文件
3. 检查是否有错误信息

## 贡献指南

欢迎对插件进行改进和扩展！如果您有任何建议或问题，请通过以下方式联系我们：

1. **提交 Issue**：在插件仓库中提交 Issue，描述您的问题或建议
2. **提交 Pull Request**：如果您已经实现了改进，可以提交 Pull Request
3. **联系我们**：通过邮件或其他方式联系插件维护者

## 许可证

本插件使用 GPL-2.0-only 许可证，详见 LICENSE 文件。

## 版本历史

### v1.0.0
- 初始版本
- 实现导航栏链接添加
- 实现后台设置页面
- 实现首页内容显示，支持多种位置选择
- 实现位置控制功能
- 实现元素未找到处理
- 实现响应式设计

## 致谢

感谢以下项目和工具对本插件的帮助：

- **NexusPHP**：优秀的 PT 站点管理系统
- **Laravel**：优雅的 PHP 框架
- **Filament**：美观的管理面板框架
- **JavaScript**：强大的前端脚本语言

---

**Simple Plugin** - 一个简单但功能完整的 NexusPHP 插件示例
