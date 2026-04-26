# Beihai Blog Theme

Beihai Blog 是一个简约现代的 WordPress 个人博客主题，适合直接复制到 WordPress 的 `wp-content/themes/` 目录中启用。

- Theme Name: Beihai Blog
- Version: 1.4.1
- Text Domain: beihai-blog
- License: GPL v2 or later

## 安装

1. 将整个 `beihai-theme` 文件夹复制到 WordPress 的 `wp-content/themes/` 目录。
2. 登录 WordPress 后台。
3. 进入“外观 -> 主题”。
4. 找到 “Beihai Blog” 并启用。

## 主要功能

- 固定顶部导航栏
- 桌面端和移动端搜索
- 时间问候语横幅
- 作者信息悬浮框
- 日间/夜间模式切换
- 现代评论区样式
- 页脚归档、备案和站外链接区域
- 响应式布局

## 主题设置

启用后可在 WordPress 后台“外观 -> 自定义”中配置：

- 横幅背景、标题、描述和问候语显示
- 作者名称、头像、简介和随笔栏
- 备案信息和社交链接
- 站点 Logo

菜单位置包括：

- 主导航菜单
- 页脚归档菜单
- 页脚站外链接菜单

## 文件结构

```text
beihai-theme/
├── README.md
├── style.css
├── functions.php
├── index.php
├── header.php
├── footer.php
├── single.php
├── page.php
├── archive.php
├── search.php
├── searchform.php
├── comments.php
├── 404.php
├── assets/
│   └── js/
│       └── main.js
└── inc/
    └── template-tags.php
```

## 兼容性

- WordPress 5.8+
- PHP 7.4+
- Chrome、Firefox、Safari、Edge 等现代浏览器

## 开发说明

当前主题不需要构建步骤。修改 PHP、CSS 或 JavaScript 文件后，在 WordPress 前台页面和后台自定义器中检查效果即可。
