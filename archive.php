<?php if (!defined("__TYPECHO_ROOT_DIR__")) {
    exit();
} ?>
<?php $this->need("header.php"); ?>
<main>
<h3 style="margin-bottom:0"><?php $this->archiveTitle(
    [
        "category" => _t("分类 %s 下的文章"),
        "search" => _t("包含关键字 %s 的文章"),
        "tag" => _t("标签 %s 下的文章"),
        "author" => _t("%s 发布的文章"),
    ],
    "",
    ""
); ?></h3>
<ul class="blog-posts">
<?php if ($this->have()): ?>
    <?php while ($this->next()): ?>
        <li>
            <span>
                <i>
                    <time datetime="<?php $this->date("c"); ?>">
                        <?php $this->date(); ?>
                    </time>
                </i>
            </span>
            <a href="<?php $this->permalink(); ?>"><?php $this->title(); ?></a>
        </li>
    <?php endwhile; ?>
<?php else: ?>
    <article class="post">
        <h2 class="post-title"><?php _e("没有找到内容"); ?></h2>
    </article>
<?php endif; ?>
</ul>

<?php if ($this->is("archive") || $this->is("index")) { ?>
<div class="post-pagination">
<?php $this->pageNav("&nbsp;←&nbsp;", "&nbsp;→&nbsp;", "5", "…"); ?>
</div>
<?php } ?>


</main>
<?php $this->need("footer.php"); ?>
