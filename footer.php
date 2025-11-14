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

<script src="//static-lab.6os.net/jquery/3.6.0/jquery.min.js"></script>
<?php if ($this->options->pjaxStatus == 'yes'): ?>
    <script src="//static-lab.6os.net/jquery-pjax/2.0.1/jquery.pjax.min.js"></script>
    <script src="//static-lab.6os.net/nprogress/0.2.0/nprogress.min.js"></script>
    <link rel="stylesheet" href="//static-lab.6os.net/nprogress/0.2.0/nprogress.min.css">
<?php endif; ?>
<!-- 初始化 -->
<script>
    // 初始化main容器
    function initMain() {
        // 在这里可以添加页面初始化逻辑
        console.log('页面已加载');
    }

    <?php if ($this->options->pjaxStatus == 'yes'): ?>
    // PJAX实现
    $(document).pjax('a[href^="<?php $this->options->siteUrl(); ?>"]:not(a[target="_blank"], a[no-pjax])', {
        container: '#main',
        fragment: '#main',
        timeout: 7000
    }).on('pjax:send', function () {
        // 显示进度条
        NProgress.start();
    }).on('submit', 'form[id=comment-form]', function (event) {
        // 评论表单提交,替换为PJAX提交
        event.preventDefault();
        $.pjax.submit(event, {
            container: '#main',
            fragment: '#main'
        });
    }).on('pjax:beforeReplace', function (event) {
        if (event.state.url.endsWith('/comment')) {
            // 评论提交后,替换为PJAX跳转到评论页
            $.pjax({
                url: /#(comments|comment-\d+)$/.test(event.previousState.url) ? event.previousState.url : event.previousState.url + '#comments',
                container: '#main',
                fragment: '#main'
            });
        }
    }).on('pjax:complete', function (event, data, status, xhr, options) {
        if (event.relatedTarget) {
            if (event.relatedTarget.tagName === 'FORM' && event.relatedTarget.id === 'comment-form') {
                // 如果PJAX来源是评论表单,则显示提示信息
                let message = (data.responseText.match(/<div class="container">\s*([\s\S]*?)\s*<\/div>/i) || [, ''])[1].trim();
                if (message) {
                    alert(message);
                    $.pjax({
                        url: xhr.url.replace(/\/comment$/, '/#comments'),
                        container: '#main',
                        fragment: '#main'
                    });
                }
            }
        }

        // PJAX完成,初始化main容器
        initMain();
    }).on('pjax:end', function () {
        // 隐藏进度条
        NProgress.done();
    });

    $(function () {
        // 页面加载完成(直接访问),触发PJAX完成事件
        $(document).trigger('pjax:complete');
    });

    $(window).on('popstate', function () {
        // 历史记录状态发生变化时(前进后退),触发PJAX完成事件
        $(document).trigger('pjax:complete');
    });
    <?php else: ?>
    // 非PJAX,直接初始化main容器
    initMain();
    <?php endif; ?>
</script>

</body>

</html>