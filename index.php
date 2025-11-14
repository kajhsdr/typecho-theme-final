<?php
/**
 * 或许是你的最终选择，接下来请专心写作吧。
 * Your final choice. Please focus on writing next.
 *
 * @package final
 * @author HoytZhang
 * @version 1.6
 * @link https://banzhuanriji.com
 */
if (!defined("__TYPECHO_ROOT_DIR__")) {
    exit();
}
$this->need("header.php");
?>
<a class="title" href="/">
    <h1><?php $this->options->title(); ?></h1>
</a>
<main id="main">

<?php if ($this->have()): ?>
<?php while ($this->next()): ?>
    <div class="post-item">
    <a href="<?php $this->permalink(); ?>"><?php $this->title(); ?></a><time datetime="<?php $this->date(
    "c"
); ?>" itemprop="datePublished"><?php $this->date(); ?></time>
    </div>
<?php endwhile; ?>

<?php if ($this->is("archive") || $this->is("index")) { ?>
<div class="post-pagination">
<?php $this->pageNav("&nbsp;←&nbsp;", "&nbsp;→&nbsp;", "5", "…"); ?>
</div>
<?php } ?>
<?php else: ?><article><em>空空如也 ...</em></article><?php endif; ?>

</main>
<?php $this->need("footer.php"); ?>
