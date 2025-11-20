<?php if (!defined("__TYPECHO_ROOT_DIR__")) {
    exit();
} ?>
<!DOCTYPE html>
<html lang="zh">
<head>
    <meta charset="<?php $this->options->charset(); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5">
    <title><?php
    $this->archiveTitle(
        [
            "category" => _t("分类 %s 下的文章"),
            "search" => _t("包含关键字 %s 的文章"),
            "tag" => _t("标签 %s 下的文章"),
            "author" => _t("%s 发布的文章"),
        ],
        "",
        " - "
    );
    $this->options->title();
    ?></title>
    <link rel="canonical" href="<?php $this->options->siteUrl(); ?>">
    <meta name="title" content="<?php $this->options->title(); ?>">
    <meta name="description" content="<?php echo $this->options->description(); ?>">
    <link rel="alternate" type="application/atom+xml" href="<?php $this->options->siteUrl(); ?>feed/">
    <link rel="shortcut icon" type="image/svg+xml" href="<?php $this->options->logoUrl(); ?>">

    <!-- 预连接外部资源，优化加载速度 -->
    <?php if ($this->options->cdnDomain): ?>
    <?php foreach (array_filter(array_map('trim', explode("\n", $this->options->cdnDomain))) as $domain): ?>
    <link rel="preconnect" href="<?php echo $domain; ?>" crossorigin>
    <link rel="dns-prefetch" href="<?php echo $domain; ?>">
    <?php endforeach; ?>
    <?php endif; ?>

    <!-- 预加载关键资源,优化LCP -->
    <link rel="preload" as="font" type="font/woff2" crossorigin>
    <meta name="format-detection" content="telephone=no">
    <meta name="theme-color" content="#ffffff">

    <!-- 关键 CSS 内联：首屏渲染所需的核心样式 -->
    <style>
        /* CSS 变量定义 */
        :root {
            --width: 720px;
            --font-scale: 1.1rem;
            --background-color: #fff;
            --heading-color: #222;
            --text-color: #222;
            --link-color: #222;
            --visited-color: #222;
            --code-background-color: #F0F0F0;
            --code-color: #222;
            --blockquote-color: #222;
            --gray-color: #666;
        }

        /* 深色模式 */
        [theme-mode="dark"] {
            --background-color: #1c1c1c;
            --heading-color: #e0e0e0;
            --text-color: #e0e0e0;
            --link-color: #e0e0e0;
            --visited-color: #e0e0e0;
            --code-background-color: #2d2d2d;
            --code-color: #e0e0e0;
            --blockquote-color: #e0e0e0;
            --gray-color: #aaa;
        }

        /* 亮色模式 */
        [theme-mode="light"] {
            --background-color: #fff;
            --heading-color: #222;
            --text-color: #222;
            --link-color: #222;
            --visited-color: #222;
            --code-background-color: #F0F0F0;
            --code-color: #222;
            --blockquote-color: #222;
            --gray-color: #666;
        }

        /* 护眼模式 */
        [theme-mode="read"] {
            --background-color: #F2F1EA;
            --heading-color: #474135;
            --text-color: #474135;
            --link-color: #4F6D96;
            --visited-color: #4F6D96;
            --code-background-color: #EBE9E0;
            --code-color: #474135;
            --blockquote-color: #594833;
            --gray-color: #594833;
        }

        /* 系统深色模式 */
        @media (prefers-color-scheme: dark) {
            :root {
                --background-color: #1c1c1c;
                --heading-color: #e0e0e0;
                --text-color: #e0e0e0;
                --link-color: #e0e0e0;
                --visited-color: #e0e0e0;
                --code-background-color: #2d2d2d;
                --code-color: #e0e0e0;
                --blockquote-color: #e0e0e0;
                --gray-color: #aaa;
            }
        }

        /* 基础布局和排版 */
        html {
            scroll-behavior: smooth;
        }

        body {
            font-size: var(--font-scale);
            margin: auto;
            max-width: var(--width);
            text-align: left;
            background-color: var(--background-color);
            word-wrap: break-word;
            overflow-wrap: break-word;
            line-height: 1.7;
            font-weight: 400;
            color: var(--text-color);
            font-family: sans-serif;
            word-break: break-all;
            font-display: swap; /* 优化字体加载,防止文本闪烁 */
            min-height: 100vh; /* 最小高度为视口高度,允许内容超出 */
            display: flex;
            flex-direction: column;
        }

        /* 标题 */
        h1, h2, h3, h4, h5, h6 {
            color: var(--heading-color);
            display: inherit;
            margin: 0.5em 0;
        }

        h1 { font-size: 1.8em; }
        h2 { font-size: 1.5em; }
        h3 { font-size: 1.3em; }

        /* 链接 */
        a {
            color: var(--link-color);
            cursor: pointer;
            text-decoration: none;
            border-bottom: 1px solid transparent;
        }

        a:hover, nav .current {
            color: var(--gray-color);
            text-decoration: underline;
        }

        /* 导航 */
        nav a {
            margin-right: 8px;
            font-size: 1.2em;
        }

        /* 文章链接 */
        article a {
            text-decoration: underline;
        }

        /* 主内容区 - 优化CLS: 明确最小高度 */
        main {
            margin-top: 30px;
            flex: 1; /* 自动扩展填充剩余空间 */
            box-sizing: border-box;
            contain: layout style; /* 优化渲染性能,隔离布局计算 */
        }

        /* 页眉页脚 */
        header, footer {
            padding: 10px 0;
        }

        /* 标题样式 - 优化LCP: 预留高度防止偏移 */
        .title h1, .title h2 {
            font-size: 2em;
            margin: 0;
            min-height: 1.2em; /* 预留标题高度 */
        }

        .title:hover {
            text-decoration: none;
        }

        /* 站点头部包装器 - 优化CLS: 固定高度 */
        .site-header-wrapper {
            min-height: 60px; /* 预留头部高度,防止布局偏移 */
            display: flex;
            align-items: center;
            justify-content: space-between;
            contain: layout style; /* 优化渲染性能 */
        }

        /* 时间和灰色文本 */
        time, .intro {
            color: var(--gray-color);
            font-family: consolas, monospace;
            font-style: normal;
        }

        /* 文章列表 - 优化CLS: 固定高度防止偏移 */
        .post-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            min-height: 1.7em; /* 预留最小高度,防止布局偏移 */
        }

        .post-item a {
            flex: 1;
        }

        .post-item time {
            margin-left: 10px;
            flex-shrink: 0;
        }

        /* 图片和视频 */
        img, video {
            max-width: 100%;
            height: auto;
            border-radius: 0.3rem;
        }

        video {
            display: block;
            margin: 20px auto;
        }

        /* 加粗文本 */
        strong, b {
            color: var(--heading-color);
        }
    </style>

    <!-- 异步加载完整样式表 -->
    <?php $styleVersion = filemtime(__DIR__ . '/style.css'); ?>
    <link rel="preload" href="<?php $this->options->themeUrl("style.css"); ?>?v=<?php echo $styleVersion; ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="<?php $this->options->themeUrl("style.css"); ?>?v=<?php echo $styleVersion; ?>"></noscript>

    <!-- 异步加载样式表的 polyfill -->
    <script>
        !function(e){"use strict";var t=function(t,n,r){var o,i=e.document,s=i.createElement("link");if(n)o=n;else{var a=(i.body||i.getElementsByTagName("head")[0]).childNodes;o=a[a.length-1]}var l=i.styleSheets;if(r)for(var d in r)r.hasOwnProperty(d)&&s.setAttribute(d,r[d]);s.rel="stylesheet",s.href=t,s.media="only x",function e(t){if(i.body)return t();setTimeout(function(){e(t)})}(function(){o.parentNode.insertBefore(s,n?o:o.nextSibling)});var f=function(e){for(var t=s.href,n=l.length;n--;)if(l[n].href===t)return e();setTimeout(function(){f(e)})};return s.addEventListener&&s.addEventListener("load",function(){this.media="all"}),s.onloadcssdefined=f,f(function(){s.media!=="all"&&(s.media="all")}),s};"undefined"!=typeof exports?exports.loadCSS=t:e.loadCSS=t}("undefined"!=typeof global?global:this);
    </script>

    <?php if (method_exists($this, "header")): ?>
        <?php $this->header(); ?>
    <?php endif; ?>

    <?php if ($this->options->addhead): ?>
        <?php echo $this->options->addhead; ?>
    <?php endif; ?>

    <?php if ($this->options->codeHighlight == 'yes'): ?>
    <!-- Prism 代码高亮样式（延迟加载，仅在有代码块时加载） -->
    <script>
        (function() {
            const themeMode = localStorage.getItem('theme-mode') || '<?php echo $this->options->defaultThemeMode ?>';
            const actualMode = themeMode === 'auto' ? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') : themeMode;
            const themes = {
                dark: '<?php $this->options->themeUrl("static/css/prism-tomorrow.min.css"); ?>',
                read: '<?php $this->options->themeUrl("static/css/prism-solarizedlight.min.css"); ?>',
                light: '<?php $this->options->themeUrl("static/css/prism.min.css"); ?>'
            };

            // 使用 createElement 替代 document.write，避免阻塞
            window.addEventListener('DOMContentLoaded', function() {
                // 仅在页面有代码块时才加载
                if (document.querySelector('pre code, code[class*="language-"]')) {
                    const link = document.createElement('link');
                    link.rel = 'stylesheet';
                    link.href = themes[actualMode] || themes.light;
                    link.setAttribute('data-prism-theme', actualMode);
                    document.head.appendChild(link);
                }
            });
        })();
    </script>
    <?php endif; ?>
</head>
<body class="home" theme-mode="">
<header>
</header>
