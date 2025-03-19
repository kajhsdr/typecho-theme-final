<?php if (!defined("__TYPECHO_ROOT_DIR__")) {
    exit();
} ?>
<?php $this->need("header.php"); ?>
<main>
    <h1><?php $this->title(); ?></h1>
    <p>
        <i>
            <time datetime="<?php $this->date("c"); ?>">
                <?php $this->date("Y-m-d H:i"); ?>
            </time>
        </i>
    </p>
    <article>
    <?php if ($this->content): ?>
        <?php $this->content(); ?>
    <?php else: ?>
        <p>此页面内容尚未发布。</p>
    <?php endif; ?>
    </article>
</main>
<?php $this->need("footer.php"); ?>
