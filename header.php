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

    <?php $styleVersion = filemtime(__DIR__ . '/style.css'); ?>
    <link rel="preload" href="<?php $this->options->themeUrl(
        "style.css"
    ); ?>?v=<?php echo $styleVersion; ?>" as="style">
    <link rel="stylesheet" href="<?php $this->options->themeUrl(
        "style.css"
    ); ?>?v=<?php echo $styleVersion; ?>">

    <?php if (method_exists($this, "header")): ?>
        <?php $this->header(); ?>
    <?php endif; ?>

    <?php if ($this->options->addhead): ?>
        <?php echo $this->options->addhead; ?>
    <?php endif; ?>

    <?php if ($this->options->codeHighlight == 'yes'): ?>
    <script>
        (function() {
            const themeMode = localStorage.getItem('theme-mode') || '<?php echo $this->options->defaultThemeMode ?>';
            const actualMode = themeMode === 'auto' ? (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light') : themeMode;
            const themes = {
                dark: 'https://cdn.jsdelivr.net/npm/prismjs@1.29.0/themes/prism-tomorrow.min.css',
                read: 'https://cdn.jsdelivr.net/npm/prismjs@1.29.0/themes/prism-solarizedlight.min.css',
                light: '<?php $this->options->themeUrl("static/css/prism.min.css"); ?>'
            };
            document.write('<link rel="stylesheet" href="' + (themes[actualMode] || themes.light) + '" data-prism-theme="' + actualMode + '">');
        })();
    </script>
    <?php endif; ?>
</head>
<body class="home" theme-mode="">
<header>
</header>
