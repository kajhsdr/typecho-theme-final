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

<!-- 主题模式切换悬浮按钮 -->
<?php if ($this->options->themeModeSelectStatus == 'yes' && $this->options->themeModeMinitoolStatus == 'yes'): ?>
<div class="minitool-group">
    <button class="vertical-btn themeMode-minitool">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sun" viewBox="0 0 16 16">
            <path d="M8 11a3 3 0 1 1 0-6 3 3 0 0 1 0 6m0 1a4 4 0 1 0 0-8 4 4 0 0 0 0 8M8 0a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 0m0 13a.5.5 0 0 1 .5.5v2a.5.5 0 0 1-1 0v-2A.5.5 0 0 1 8 13m8-5a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2a.5.5 0 0 1 .5.5M3 8a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1 0-1h2A.5.5 0 0 1 3 8m10.657-5.657a.5.5 0 0 1 0 .707l-1.414 1.415a.5.5 0 1 1-.707-.708l1.414-1.414a.5.5 0 0 1 .707 0m-9.193 9.193a.5.5 0 0 1 0 .707L3.05 13.657a.5.5 0 0 1-.707-.707l1.414-1.414a.5.5 0 0 1 .707 0m9.193 2.121a.5.5 0 0 1-.707 0l-1.414-1.414a.5.5 0 0 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .707M4.464 4.465a.5.5 0 0 1-.707 0L2.343 3.05a.5.5 0 1 1 .707-.707l1.414 1.414a.5.5 0 0 1 0 .708"/>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-moon-stars" viewBox="0 0 16 16">
            <path d="M6 .278a.77.77 0 0 1 .08.858 7.2 7.2 0 0 0-.878 3.46c0 4.021 3.278 7.277 7.318 7.277q.792-.001 1.533-.16a.79.79 0 0 1 .81.316.73.73 0 0 1-.031.893A8.35 8.35 0 0 1 8.344 16C3.734 16 0 12.286 0 7.71 0 4.266 2.114 1.312 5.124.06A.75.75 0 0 1 6 .278M4.858 1.311A7.27 7.27 0 0 0 1.025 7.71c0 4.02 3.279 7.276 7.319 7.276a7.32 7.32 0 0 0 5.205-2.162q-.506.063-1.029.063c-4.61 0-8.343-3.714-8.343-8.29 0-1.167.242-2.278.681-3.286"/>
            <path d="M10.794 3.148a.217.217 0 0 1 .412 0l.387 1.162c.173.518.579.924 1.097 1.097l1.162.387a.217.217 0 0 1 0 .412l-1.162.387a1.73 1.73 0 0 0-1.097 1.097l-.387 1.162a.217.217 0 0 1-.412 0l-.387-1.162A1.73 1.73 0 0 0 9.31 6.593l-1.162-.387a.217.217 0 0 1 0-.412l1.162-.387a1.73 1.73 0 0 0 1.097-1.097zM13.863.099a.145.145 0 0 1 .274 0l.258.774c.115.346.386.617.732.732l.774.258a.145.145 0 0 1 0 .274l-.774.258a1.16 1.16 0 0 0-.732.732l-.258.774a.145.145 0 0 1-.274 0l-.258-.774a1.16 1.16 0 0 0-.732-.732l-.774-.258a.145.145 0 0 1 0-.274l.774-.258c.346-.115.617-.386.732-.732z"/>
        </svg>
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
            <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783"/>
        </svg>
    </button>
</div>
<?php endif; ?>

<!-- 主题模式切换脚本 -->
<?php if ($this->options->themeModeSelectStatus == 'yes'): ?>
<script>
    // 主题模式切换逻辑
    (function() {
        const body = document.querySelector('body');
        const themeModeSelect = document.getElementById('themeMode');
        const systemThemeModeMedia = window.matchMedia('(prefers-color-scheme: dark)');

        // 是否开启自动模式切换
        let isAutoThemeMode = false;

        <?php if ($this->options->codeHighlight == 'yes'): ?>
        // 代码高亮主题切换函数
        function updateCodeHighlightTheme(themeMode) {
            // 检查页面是否有代码块
            const hasCodeBlocks = document.querySelector('pre code, code[class*="language-"]');

            // 只有当页面有代码块时才加载代码高亮主题
            if (!hasCodeBlocks) {
                return;
            }

            // 移除现有的 Prism 主题 CSS
            const existingPrismCss = document.querySelector('link[data-prism-theme]');
            if (existingPrismCss) {
                existingPrismCss.remove();
            }

            // 根据主题模式选择代码高亮主题
            let prismThemeUrl = '';
            if (themeMode === 'dark') {
                // 深色模式使用 Tomorrow Night 主题
                prismThemeUrl = 'https://cdn.jsdelivr.net/npm/prismjs@1.29.0/themes/prism-tomorrow.min.css';
            } else if (themeMode === 'read') {
                // 护眼模式使用 Solarized Light 主题
                prismThemeUrl = 'https://cdn.jsdelivr.net/npm/prismjs@1.29.0/themes/prism-solarizedlight.min.css';
            } else {
                // 亮色模式使用默认主题
                prismThemeUrl = '<?php $this->options->themeUrl("assets/css/prism.min.css"); ?>';
            }

            // 加载新的主题 CSS
            const cssLink = document.createElement('link');
            cssLink.rel = 'stylesheet';
            cssLink.href = prismThemeUrl;
            cssLink.setAttribute('data-prism-theme', themeMode);
            document.head.appendChild(cssLink);
        }
        <?php endif; ?>

        // 系统主题模式切换
        systemThemeModeMedia.addEventListener('change', function () {
            if (isAutoThemeMode) {
                const newThemeMode = systemThemeModeMedia.matches ? 'dark' : 'light';
                setBodyThemeMode(newThemeMode);
            }
        });

        // 设置主题模式
        function setBodyThemeMode(themeMode) {
            body.setAttribute('theme-mode', themeMode);

            <?php if ($this->options->codeHighlight == 'yes'): ?>
            // 根据主题模式切换代码高亮主题
            updateCodeHighlightTheme(themeMode);
            <?php endif; ?>
        }

        // 保存主题模式到 localStorage
        function saveThemeMode(themeMode) {
            localStorage.setItem('theme-mode', themeMode);
        }

        // 获取当前主题模式
        function getCurrentThemeMode() {
            return localStorage.getItem('theme-mode') || '<?php echo $this->options->defaultThemeMode ?>';
        }

        // 初始化主题模式
        function initThemeMode() {
            const savedThemeMode = getCurrentThemeMode();

            // 同步下拉选择器（如果存在）
            if (themeModeSelect) {
                themeModeSelect.value = savedThemeMode;
            }

            if (savedThemeMode === 'auto') {
                isAutoThemeMode = true;
                const initialThemeMode = systemThemeModeMedia.matches ? 'dark' : 'light';
                setBodyThemeMode(initialThemeMode);
            } else {
                isAutoThemeMode = false;
                setBodyThemeMode(savedThemeMode);
            }
        }

        // 切换到指定主题模式
        function switchToThemeMode(themeMode) {
            saveThemeMode(themeMode);

            // 同步下拉选择器（如果存在）
            if (themeModeSelect) {
                themeModeSelect.value = themeMode;
            }

            if (themeMode === 'auto') {
                isAutoThemeMode = true;
                const currentSystemThemeMode = systemThemeModeMedia.matches ? 'dark' : 'light';
                setBodyThemeMode(currentSystemThemeMode);
            } else {
                isAutoThemeMode = false;
                setBodyThemeMode(themeMode);
            }
        }

        // 切换主题模式（下拉选择器）
        if (themeModeSelect) {
            themeModeSelect.addEventListener('change', function (e) {
                const selectedThemeMode = e.target.value;
                switchToThemeMode(selectedThemeMode);
            });
        }

        // 初始化主题模式
        initThemeMode();

        <?php if ($this->options->themeModeMinitoolStatus == 'yes'): ?>
        // 主题模式切换悬浮按钮
        const themeModeMinitool = document.querySelector('.themeMode-minitool');
        if (themeModeMinitool) {
            themeModeMinitool.addEventListener('click', function () {
                const bodyThemeMode = body.getAttribute('theme-mode');
                // 亮色、暗色、护眼三种主题轮换
                if (bodyThemeMode === 'light') {
                    switchToThemeMode('dark');
                } else if (bodyThemeMode === 'dark') {
                    switchToThemeMode('read');
                } else {
                    switchToThemeMode('light');
                }
            });
        }
        <?php endif; ?>
    })();
</script>
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

        // 不自动加载 CSS，CSS 由主题模式控制加载

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