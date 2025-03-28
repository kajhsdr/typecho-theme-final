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
    <link rel="stylesheet" href="<?php $this->options->themeUrl(
        "style.css"
    ); ?>">

    <?php if (method_exists($this, "header")): ?>
        <?php $this->header(); ?>
    <?php endif; ?>

    <?php if ($this->options->addhead): ?>
        <?php echo $this->options->addhead; ?>
    <?php endif; ?>
</head>
<body class="home">
<header>

</header>