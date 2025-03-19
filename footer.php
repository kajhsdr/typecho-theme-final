<?php if (!defined("__TYPECHO_ROOT_DIR__")) {
    exit();
} ?>

<footer style="margin:50px 0px">

<span id="footer-directive">
<nav>
       <a href="<?php $this->options->siteUrl(); ?>"><?php _e("首页"); ?></a>
       <?php \Widget\Contents\Page\Rows::alloc()->to($pages); ?>
       <?php while ($pages->next()): ?>
           <a<?php if (
               $this->is("page", $pages->slug)
           ): ?> <?php endif; ?> href="<?php $pages->permalink(); ?>" title="<?php $pages->title(); ?>"><?php $pages->title(); ?></a>
       <?php endwhile; ?>
</nav>
<?php $this->options->addfoot(); ?>

</span>

<span>
&copy; 2024 <a href="<?php $this->options->siteUrl(); ?>"><?php $this->options->title(); ?></a>
</span>

</footer>

</body>

</html>