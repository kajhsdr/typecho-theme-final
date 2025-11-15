<?php if (!defined("__TYPECHO_ROOT_DIR__")) {
    exit();
} ?>
<?php $this->need("header.php"); ?>
<main id="main">
    <h1><a href="<?php $this->options->siteUrl(); ?>"><?php $this->title(); ?></a></h1>
    <p>
        <i>
            <time datetime="<?php $this->date("c"); ?>">
                <?php $this->date("Y-m-d H:i"); ?>
            </time>
            · 
        </i>
        <?php $this->category(" · "); ?>
    </p>
    <article>
    <?php if ($this->content): ?>
        <?php FinalTheme_LivePhotoHelper::renderContent($this); ?>
    <?php else: ?>
        <p>此文章内容尚未发布。</p>
    <?php endif; ?>
    </article>
    <p class="tags">
        <?php $this->tags(" · ", true, " "); ?>
    </p>
    <?php if (!isset($this->options->commentAreaStatus) || $this->options->commentAreaStatus !== 'no'): ?>
        <?php $this->need('comments.php'); ?>
    <?php endif; ?>
</main>
<?php $this->need("footer.php"); ?>
