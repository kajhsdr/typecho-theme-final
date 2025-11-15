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
<?php if ($this->options->icpBeian): ?> | <a href="https://beian.miit.gov.cn/" target="_blank" rel="noopener"><?php $this->options->icpBeian(); ?></a><?php endif; ?>
</span>

<span style="margin-top:10px;display:flex;gap:15px;justify-content:center">
<?php if ($this->options->github): ?>
<a href="<?php $this->options->github(); ?>" target="_blank" rel="noopener" title="GitHub">
<svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"/></svg>
</a>
<?php endif; ?>
<?php if ($this->options->weibo): ?>
<a href="<?php $this->options->weibo(); ?>" target="_blank" rel="noopener" title="微博">
<svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M9.68 8.43c-.17.12-.36.22-.56.3-.2.08-.42.12-.64.12-.43 0-.82-.15-1.13-.42-.32-.28-.48-.65-.48-1.09 0-.25.05-.48.16-.69.1-.21.25-.39.43-.54.18-.14.39-.25.62-.33.23-.07.47-.11.72-.11.44 0 .83.14 1.15.41.32.27.48.63.48 1.06 0 .26-.06.5-.17.71-.11.21-.27.4-.48.55zm3.8-2.36c-.14-.43-.37-.81-.68-1.13-.31-.32-.68-.57-1.1-.74-.42-.17-.87-.26-1.35-.26-.69 0-1.33.16-1.91.47-.58.31-1.05.74-1.4 1.28-.35.54-.53 1.15-.53 1.82 0 .5.1.97.29 1.41.19.44.46.82.81 1.14.35.32.76.57 1.22.75.46.18.95.27 1.47.27.68 0 1.31-.15 1.88-.46.57-.31 1.03-.73 1.37-1.27.34-.54.51-1.14.51-1.81 0-.49-.09-.96-.28-1.39zM16 8c0 .74-.14 1.44-.42 2.09-.28.65-.67 1.22-1.17 1.7-.5.48-1.09.86-1.76 1.13-.67.27-1.39.41-2.15.41-1.04 0-2-.21-2.88-.62-.88-.41-1.62-.98-2.22-1.7C4.8 10.29 4.33 9.47 4 8.56c-.33-.91-.5-1.87-.5-2.88 0-.74.14-1.44.42-2.09.28-.65.67-1.22 1.17-1.7.5-.48 1.09-.86 1.76-1.13C7.52.49 8.24.35 9 .35c1.04 0 2 .21 2.88.62.88.41 1.62.98 2.22 1.7.6.72 1.07 1.54 1.4 2.45.33.91.5 1.87.5 2.88z"/></svg>
</a>
<?php endif; ?>
<?php if ($this->options->twitter): ?>
<a href="<?php $this->options->twitter(); ?>" target="_blank" rel="noopener" title="Twitter">
<svg width="20" height="20" fill="currentColor" viewBox="0 0 16 16"><path d="M12.6.75h2.454l-5.36 6.142L16 15.25h-4.937l-3.867-5.07-4.425 5.07H.316l5.733-6.57L0 .75h5.063l3.495 4.633L12.601.75Zm-.86 13.028h1.36L4.323 2.145H2.865l8.875 11.633Z"/></svg>
</a>
<?php endif; ?>
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

<?php
$commentAreaEnabled = !isset($this->options->commentAreaStatus) || $this->options->commentAreaStatus !== 'no';
$livePhotoEnabled = isset($this->options->livePhotoStatus) && $this->options->livePhotoStatus === 'yes';
?>


<!-- DOM 批量调度器，降低强制同步布局 -->
<script>
    (function() {
        if (window.DomBatch) {
            return;
        }

        const queues = { read: [], write: [] };
        let scheduled = false;

        function runQueue(type) {
            const tasks = queues[type].splice(0, queues[type].length);
            tasks.forEach(function(task) {
                try {
                    task();
                } catch (err) {
                    console.error('DOM 批量任务异常', err);
                }
            });
        }

        function scheduleFlush() {
            if (scheduled) {
                return;
            }

            scheduled = true;
            requestAnimationFrame(function() {
                runQueue('read');
                runQueue('write');
                scheduled = false;

                if (queues.read.length || queues.write.length) {
                    scheduleFlush();
                }
            });
        }

        function enqueue(type, task) {
            if (typeof task !== 'function') {
                return;
            }

            queues[type].push(task);
            scheduleFlush();
        }

        window.DomBatch = {
            read: function(task) {
                enqueue('read', task);
            },
            write: function(task) {
                enqueue('write', task);
            }
        };
    })();
</script>

<!-- 主题模式切换脚本 -->
<?php if ($this->options->themeModeSelectStatus == 'yes'): ?>
<script>
    (function() {
        const domBatch = window.DomBatch || {
            read: function(task) { task && task(); },
            write: function(task) { task && task(); }
        };

        const body = document.querySelector('body');
        const themeModeSelect = document.getElementById('themeMode');
        const systemThemeModeMedia = window.matchMedia('(prefers-color-scheme: dark)');

        // 是否开启自动模式切换
        let isAutoThemeMode = false;

        <?php if ($this->options->codeHighlight == 'yes'): ?>
        // 代码高亮主题切换
        function updateCodeHighlightTheme(themeMode) {
            if (!document.querySelector('pre code, code[class*="language-"]')) return;

            const existing = document.querySelector('link[data-prism-theme]');
            if (existing) existing.remove();

            const themes = {
                dark: 'https://cdn.jsdelivr.net/npm/prismjs@1.29.0/themes/prism-tomorrow.min.css',
                read: 'https://cdn.jsdelivr.net/npm/prismjs@1.29.0/themes/prism-solarizedlight.min.css',
                light: '<?php $this->options->themeUrl("static/css/prism.min.css"); ?>'
            };

            const link = document.createElement('link');
            link.rel = 'stylesheet';
            link.href = themes[themeMode] || themes.light;
            link.setAttribute('data-prism-theme', themeMode);
            document.head.appendChild(link);
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
            const actualThemeMode = savedThemeMode === 'auto'
                ? (systemThemeModeMedia.matches ? 'dark' : 'light')
                : savedThemeMode;

            // 同步下拉选择器（如果存在）
            if (themeModeSelect) {
                themeModeSelect.value = savedThemeMode;
            }

            isAutoThemeMode = savedThemeMode === 'auto';
            body.setAttribute('theme-mode', actualThemeMode);

            <?php if ($this->options->codeHighlight == 'yes'): ?>
            updateCodeHighlightTheme(actualThemeMode);
            <?php endif; ?>
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
    (function() {
        const domBatch = window.DomBatch || {
            read: function(task) { task && task(); },
            write: function(task) { task && task(); }
        };
    <?php if ($this->options->codeHighlight == 'yes'): ?>
        // 代码高亮按需加载
        let prismLoaded = false;

    function highlightCode() {
        if (!document.querySelector('pre code, code[class*="language-"]')) return;
        if (prismLoaded) { Prism.highlightAll(); return; }

        const script = document.createElement('script');
        script.src = '<?php $this->options->themeUrl("static/js/prism.min.js"); ?>';
        script.onload = () => {
            const autoloader = document.createElement('script');
            autoloader.src = '<?php $this->options->themeUrl("static/js/prism-autoloader.min.js"); ?>';
            autoloader.onload = () => { prismLoaded = true; Prism.highlightAll(); };
            document.body.appendChild(autoloader);
        };
        document.body.appendChild(script);
    }
    <?php endif; ?>

    <?php if ($livePhotoEnabled): ?>
        // Live Photo 按需加载
        let livePhotoLoaded = false;

    function initializeLivePhotos() {
        const livePhotos = document.querySelectorAll('[data-live-photo]');
        if (!livePhotos.length) return;
        if (livePhotoLoaded) {
            livePhotos.forEach(el => !el.classList.contains('lpk-live-photo-player') && LivePhotosKit.augmentElementAsPlayer(el));
            window.finalThemeInitMotionPhoto?.();
            return;
        }

        const lpkScript = document.createElement('script');
        lpkScript.src = 'https://static.jdaa.xyz/js/livephotoskit.js';
        lpkScript.onload = () => {
            const motionScript = document.createElement('script');
            motionScript.src = '<?php $this->options->themeUrl("static/js/motionphoto.js"); ?>';
            motionScript.onload = () => {
                livePhotoLoaded = true;
                livePhotos.forEach(el => LivePhotosKit.augmentElementAsPlayer(el));
                window.finalThemeInitMotionPhoto?.();
            };
            document.body.appendChild(motionScript);
        };
        document.body.appendChild(lpkScript);
    }
    <?php endif; ?>

        // 初始化main容器
        function initMain() {
        <?php if ($this->options->codeHighlight == 'yes'): ?>
            // 检查并高亮代码块
            highlightCode();
        <?php endif; ?>
        <?php if ($livePhotoEnabled): ?>
            // 检查并初始化 Live Photos
            initializeLivePhotos();
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
                    domBatch.write(function() {
                        progressBar.style.width = '0%';
                        progressBar.classList.add('active');
                    });
                }
            },
            done: function() {
                if (progressBar) {
                    domBatch.write(function() {
                        progressBar.style.width = '100%';
                    });
                    setTimeout(() => {
                        domBatch.write(function() {
                            progressBar.classList.remove('active');
                        });
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
                    const newContent = newMain.innerHTML;
                    const newTitle = doc.querySelector('title');
                    const newTitleText = newTitle ? newTitle.textContent : '';
                    const hashIndex = url.indexOf('#');
                    const hash = hashIndex > -1 ? url.slice(hashIndex + 1) : null;

                    domBatch.write(function() {
                        mainContainer.innerHTML = newContent;
                        if (newTitleText) {
                            document.title = newTitleText;
                        }
                    });

                    if (pushState) {
                        history.pushState({ url: url }, '', url);
                    }

                    domBatch.write(function() {
                        if (hash) {
                            const target = document.getElementById(hash);
                            if (target) {
                                target.scrollIntoView({ behavior: 'smooth' });
                            } else {
                                window.scrollTo({ top: 0, behavior: 'smooth' });
                            }
                        } else {
                            window.scrollTo({ top: 0, behavior: 'smooth' });
                        }
                        initMain();
                    });
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

        <?php if ($commentAreaEnabled): ?>
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
        <?php endif; ?>

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

        <?php if ($commentAreaEnabled): ?>
        // 事件委托: 拦截评论表单提交
        document.addEventListener('submit', function(e) {
            const form = e.target;

            if (form.id === 'comment-form') {
                e.preventDefault();
                handleCommentSubmit(form);
            }
        });
        <?php endif; ?>

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
    })();
</script>

</body>

</html>
