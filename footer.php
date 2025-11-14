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

<?php if ($this->options->pjaxStatus == 'yes'): ?>
<!-- PJAX 加载进度条 -->
<div id="pjax-progress"></div>
<?php endif; ?>

<!-- 初始化 -->
<script>
    <?php if ($this->options->codeHighlight == 'yes'): ?>
    // 代码高亮按需加载
    let prismLoaded = false;

    function loadPrism(callback) {
        if (prismLoaded) {
            callback && callback();
            return;
        }

        // 加载 CSS
        const cssLink = document.createElement('link');
        cssLink.rel = 'stylesheet';
        cssLink.href = '<?php $this->options->themeUrl("assets/css/prism.min.css"); ?>';
        document.head.appendChild(cssLink);

        // 加载 JS
        const script = document.createElement('script');
        script.src = '<?php $this->options->themeUrl("assets/js/prism.min.js"); ?>';
        script.onload = function() {
            // 加载自动加载器插件
            const autoloader = document.createElement('script');
            autoloader.src = '<?php $this->options->themeUrl("assets/js/prism-autoloader.min.js"); ?>';
            autoloader.onload = function() {
                prismLoaded = true;
                callback && callback();
            };
            document.body.appendChild(autoloader);
        };
        document.body.appendChild(script);
    }

    function highlightCode() {
        // 检查页面是否有代码块
        const hasCodeBlocks = document.querySelector('pre code, code[class*="language-"]');

        if (hasCodeBlocks) {
            loadPrism(function() {
                if (typeof Prism !== 'undefined') {
                    Prism.highlightAll();
                }
            });
        }
    }
    <?php endif; ?>

    // 初始化main容器
    function initMain() {
        <?php if ($this->options->codeHighlight == 'yes'): ?>
        // 检查并高亮代码块
        highlightCode();
        <?php endif; ?>
        console.log('页面已加载');
    }

    <?php if ($this->options->pjaxStatus == 'yes'): ?>
    // 原生 JavaScript PJAX 实现
    (function() {
        const siteUrl = '<?php $this->options->siteUrl(); ?>';
        const mainContainer = document.getElementById('main');
        const progressBar = document.getElementById('pjax-progress');

        // 进度条控制
        const progress = {
            start: function() {
                if (progressBar) {
                    progressBar.style.width = '0%';
                    progressBar.classList.add('active');
                }
            },
            done: function() {
                if (progressBar) {
                    progressBar.style.width = '100%';
                    setTimeout(() => {
                        progressBar.classList.remove('active');
                    }, 200);
                }
            }
        };

        // 加载页面内容
        function loadPage(url, pushState = true) {
            progress.start();

            fetch(url, {
                headers: {
                    'X-PJAX': 'true',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                // 提取 #main 内容
                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');
                const newMain = doc.getElementById('main');

                if (newMain) {
                    mainContainer.innerHTML = newMain.innerHTML;

                    // 更新标题
                    const newTitle = doc.querySelector('title');
                    if (newTitle) {
                        document.title = newTitle.textContent;
                    }

                    // 更新历史记录
                    if (pushState) {
                        history.pushState({ url: url }, '', url);
                    }

                    // 滚动到顶部或锚点
                    if (url.includes('#')) {
                        const hash = url.split('#')[1];
                        const target = document.getElementById(hash);
                        if (target) {
                            target.scrollIntoView({ behavior: 'smooth' });
                        }
                    } else {
                        window.scrollTo({ top: 0, behavior: 'smooth' });
                    }

                    // 初始化页面
                    initMain();
                }
            })
            .catch(error => {
                console.error('PJAX 加载失败:', error);
                window.location.href = url;
            })
            .finally(() => {
                progress.done();
            });
        }

        // 处理评论表单提交
        function handleCommentSubmit(form) {
            const formData = new FormData(form);
            const url = form.action;

            progress.start();

            fetch(url, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-PJAX': 'true',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.text())
            .then(html => {
                // 提取提示消息
                const match = html.match(/<div class="container">\s*([\s\S]*?)\s*<\/div>/i);
                if (match && match[1].trim()) {
                    alert(match[1].trim());
                }

                // 重新加载当前页面到评论区
                const currentUrl = window.location.href.split('#')[0] + '#comments';
                loadPage(currentUrl, false);
            })
            .catch(error => {
                console.error('评论提交失败:', error);
            })
            .finally(() => {
                progress.done();
            });
        }

        // 事件委托: 拦截链接点击
        document.addEventListener('click', function(e) {
            const link = e.target.closest('a');

            if (link &&
                link.href &&
                link.href.startsWith(siteUrl) &&
                !link.hasAttribute('target') &&
                !link.hasAttribute('no-pjax') &&
                !link.href.endsWith('.xml') &&
                !link.href.endsWith('.pdf')) {

                e.preventDefault();
                loadPage(link.href);
            }
        });

        // 事件委托: 拦截评论表单提交
        document.addEventListener('submit', function(e) {
            const form = e.target;

            if (form.id === 'comment-form') {
                e.preventDefault();
                handleCommentSubmit(form);
            }
        });

        // 浏览器前进后退
        window.addEventListener('popstate', function(e) {
            if (e.state && e.state.url) {
                loadPage(e.state.url, false);
            } else {
                loadPage(window.location.href, false);
            }
        });

        // 初始化当前页面状态
        history.replaceState({ url: window.location.href }, '', window.location.href);

        // 页面加载完成
        document.addEventListener('DOMContentLoaded', function() {
            initMain();
        });
    })();
    <?php else: ?>
    // 非PJAX,直接初始化main容器
    document.addEventListener('DOMContentLoaded', function() {
        initMain();
    });
    <?php endif; ?>
</script>

</body>

</html>