<?php
if (!defined("__TYPECHO_ROOT_DIR__")) {
    exit();
}

function themeConfig($form)
{
    // 基础配置
    $form->addInput(new \Typecho\Widget\Helper\Form\Element\Text(
        'logoUrl', null, 'default-logo.png',
        _t('站点 LOGO 地址'), _t('在这里填入一个图片 URL 地址')
    ));

    // ICP 备案号
    $form->addInput(new \Typecho\Widget\Helper\Form\Element\Text(
        'icpBeian', null, null,
        _t('ICP 备案号'), _t('填写网站 ICP 备案号，如：京ICP备12345678号')
    ));

    // 社交媒体链接
    $form->addInput(new \Typecho\Widget\Helper\Form\Element\Text(
        'github', null, null,
        _t('GitHub 链接'), _t('填写完整的 GitHub 主页地址')
    ));

    $form->addInput(new \Typecho\Widget\Helper\Form\Element\Text(
        'weibo', null, null,
        _t('微博链接'), _t('填写完整的微博主页地址')
    ));

    $form->addInput(new \Typecho\Widget\Helper\Form\Element\Text(
        'twitter', null, null,
        _t('Twitter 链接'), _t('填写完整的 Twitter 主页地址')
    ));

    // DNS 预解析配置
    $form->addInput(new \Typecho\Widget\Helper\Form\Element\Textarea(
        'cdnDomain', null, 'https://cdn.jsdelivr.net',
        _t('DNS 预解析域名'), _t('每行一个域名，如：<br>https://cdn.jsdelivr.net<br>https://example.com')
    ));

    // 功能开关
    $form->addInput(new \Typecho\Widget\Helper\Form\Element\Radio(
        'pjaxStatus', ['yes' => '是', 'no' => '否'], 'no',
        '是否启用全站 PJAX', '开启后,全站页面实现 PJAX 无刷新跳转'
    ));

    $form->addInput(new \Typecho\Widget\Helper\Form\Element\Radio(
        'codeHighlight', ['yes' => '是', 'no' => '否'], 'yes',
        '是否启用代码高亮', '开启后,使用 Prism.js 实现代码语法高亮'
    ));

    $form->addInput(new \Typecho\Widget\Helper\Form\Element\Radio(
        'livePhotoStatus', ['yes' => '是', 'no' => '否'], 'no',
        '是否启用 Live Photo/Motion Photo', '开启后，可通过短代码 [LivePhoto photo=\"\" video=\"\"] 在文章中插入 Live Photo'
    ));

    // 图片懒加载配置
    $form->addInput(new \Typecho\Widget\Helper\Form\Element\Radio(
        'imageLazyloadStatus', ['yes' => '是', 'no' => '否'], 'yes',
        '是否启用图片懒加载', '开启后，文章内的图片仅在用户即将浏览到时才加载，提升页面加载速度'
    ));

    // 评论开关
    $form->addInput(new \Typecho\Widget\Helper\Form\Element\Radio(
        'commentAreaStatus', ['yes' => '是', 'no' => '否'], 'yes',
        '是否启用评论区', '关闭后不会渲染评论模板与相关样式脚本'
    ));

    // 自定义代码
    $form->addInput(new \Typecho\Widget\Helper\Form\Element\Textarea(
        'addhead', null, null,
        _t('头部代码'), _t('可填写自定义 CSS、JS 代码等')
    ));

    $form->addInput(new \Typecho\Widget\Helper\Form\Element\Textarea(
        'addfoot', null, null,
        _t('页脚代码'), _t('支持 HTML，可填写备案、统计等信息')
    ));

    // 主题模式配置
    $form->addInput(new \Typecho\Widget\Helper\Form\Element\Radio(
        'themeModeSelectStatus', ['yes' => '是', 'no' => '否'], 'yes',
        '是否启用主题模式切换', '开启后，全站支持切换亮色/深色/跟随系统模式。关闭后，以下所有主题模式相关配置将失效'
    ));

    $form->addInput(new \Typecho\Widget\Helper\Form\Element\Radio(
        'defaultThemeMode',
        ['auto' => '跟随系统', 'light' => '亮色模式', 'dark' => '深色模式', 'read' => '护眼模式'],
        'auto', '默认主题模式', '用户首次访问或未手动切换时使用的主题模式（需先启用主题模式切换）'
    ));

    $form->addInput(new \Typecho\Widget\Helper\Form\Element\Radio(
        'themeModeHeaderSelectStatus', ['yes' => '是', 'no' => '否'], 'no',
        '是否在页面顶部显示主题模式选择器', '开启后，在页面顶部显示主题模式下拉选择器（需先启用主题模式切换）'
    ));

    $form->addInput(new \Typecho\Widget\Helper\Form\Element\Radio(
        'themeModeMinitoolStatus', ['yes' => '是', 'no' => '否'], 'no',
        '是否启用主题模式切换悬浮按钮', '开启后，在网页右下角显示主题模式切换按钮（需先启用主题模式切换）'
    ));
}

if (!class_exists('FinalTheme_LivePhotoHelper')) {
    class FinalTheme_LivePhotoHelper
    {
        private static $enabled = null;

        public static function bootstrap()
        {
            if (!self::isEnabled()) {
                return;
            }

            Typecho_Plugin::factory('Widget_Abstract_Contents')->contentEx = [__CLASS__, 'parse'];
            Typecho_Plugin::factory('Widget_Abstract_Contents')->excerptEx = [__CLASS__, 'parse'];
            Typecho_Plugin::factory('admin/write-post.php')->bottom = [__CLASS__, 'addEditorButton'];
            Typecho_Plugin::factory('admin/write-page.php')->bottom = [__CLASS__, 'addEditorButton'];
        }

        public static function parse($text, $widget, $lastResult)
        {
            $text = empty($lastResult) ? $text : $lastResult;
            return self::processContent($widget, $text);
        }

        public static function renderContent($widget, $method = 'content', ...$args)
        {
            if (!method_exists($widget, $method)) {
                return;
            }

            ob_start();
            call_user_func_array([$widget, $method], $args);
            $content = ob_get_clean();
            echo self::processContent($widget, $content);
        }

        private static function processContent($widget, $text)
        {
            if (!$text || !$widget instanceof Widget_Archive) {
                return $text;
            }

            $text = self::parseGallery($text);

            // 应用图片懒加载
            $text = self::applyImageLazyload($text);

            if (!self::isEnabled()) {
                return $text;
            }

            $pattern = self::get_shortcode_regex(['LivePhoto']);
            return preg_replace_callback("/$pattern/", [__CLASS__, 'parseCallback'], $text);
        }

        private static function parseGallery($text)
        {
            $pattern = self::get_shortcode_regex(['Gallery']);
            static $galleryIndex = 0; // 为每个相册生成唯一 ID

            return preg_replace_callback("/$pattern/", function($matches) use (&$galleryIndex) {
                $attrs = self::shortcode_parse_atts($matches[3]);
                $content = isset($matches[5]) ? $matches[5] : '';

                // 支持的属性：
                // - columns: 列数（默认 auto）
                // - gap: 间距（默认 10px）
                // - height: 图片高度（默认 200px）
                $columns = isset($attrs['columns']) ? intval($attrs['columns']) : 0;
                $gap = isset($attrs['gap']) ? $attrs['gap'] : '10px';
                $height = isset($attrs['height']) ? $attrs['height'] : '200px';

                // 从内容中提取 URL
                // 支持：纯 URL、<a> 链接、换行分隔的多个 URL
                preg_match_all('/<a[^>]+href=["\']([^"\']+)["\'][^>]*>.*?<\/a>|https?:\/\/[^\s\]<]+/', $content, $matches_urls);

                $urls = [];
                foreach ($matches_urls[0] as $index => $match) {
                    if (strpos($match, '<a') === 0) {
                        // 从 <a> 标签提取 href
                        if (!empty($matches_urls[1][$index])) {
                            $urls[] = trim($matches_urls[1][$index]);
                        }
                    } else {
                        // 纯 URL
                        $urls[] = trim($match);
                    }
                }

                // 去重
                $urls = array_unique($urls);

                if (empty($urls)) {
                    return $matches[0];
                }

                // 生成唯一的相册组 ID
                $galleryId = 'gallery-' . (++$galleryIndex);

                // 构建样式
                $gridColumns = $columns > 0
                    ? "grid-template-columns: repeat($columns, 1fr);"
                    : "grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));";

                $style = sprintf(
                    'display: grid; %s gap: %s; margin: 20px 0;',
                    $gridColumns,
                    $gap
                );

                // 生成 HTML
                $html = sprintf('<div class="gallery" data-gallery-id="%s" style="%s">',
                    htmlspecialchars($galleryId, ENT_QUOTES, 'UTF-8'),
                    htmlspecialchars($style, ENT_QUOTES, 'UTF-8')
                );

                foreach ($urls as $url) {
                    $escapedUrl = htmlspecialchars($url, ENT_QUOTES, 'UTF-8');

                    // Gallery 图片使用懒加载占位符，让后续的 applyImageLazyload 处理
                    // 这样可以显著提升包含大量图片的相册加载速度
                    $html .= sprintf(
                        '<a href="%s" class="glightbox" data-gallery="%s" style="display: block; overflow: hidden; border-radius: 4px;">
                            <img src="%s" alt="Gallery Image" style="width: 100%%; height: %s; object-fit: cover; transition: transform 0.3s;">
                        </a>',
                        $escapedUrl,
                        $galleryId,
                        $escapedUrl,
                        htmlspecialchars($height, ENT_QUOTES, 'UTF-8')
                    );
                }
                $html .= '</div>';

                return $html;
            }, $text);
        }

        public static function parseCallback($matches)
        {
            $attrs = self::shortcode_parse_atts($matches[3]);

            if (isset($attrs['photo']) && !isset($attrs['video'])) {
                // 只有图片，作为普通图片处理（用于 Motion Photo 格式图片）
                $ratio = isset($attrs['ratio']) ? $attrs['ratio'] : '4/3';
                return sprintf(
                    '<div style="width: auto; aspect-ratio: %s; margin: auto;" id="files">
                        <div><img src="%s" alt="Motion Photo" style="width: 100%%; height: auto;"></div>
                    </div>',
                    $ratio,
                    $attrs['photo']
                );
            } elseif (isset($attrs['photo']) && isset($attrs['video'])) {
                // Live Photo 格式（同时有图片和视频）
                $ratio = isset($attrs['ratio']) ? $attrs['ratio'] : '4/3';
                return sprintf(
                    '<div style="width: auto; aspect-ratio: %s; margin: auto;"
                          data-live-photo
                          data-photo-src="%s"
                          data-video-src="%s">
                    </div>',
                    $ratio,
                    $attrs['photo'],
                    $attrs['video']
                );
            }

            return $matches[0];
        }

        /**
         * 应用图片懒加载
         */
        private static function applyImageLazyload($text)
        {
            $options = Helper::options();

            // 检查是否启用图片懒加载
            if (!isset($options->imageLazyloadStatus) || $options->imageLazyloadStatus !== 'yes') {
                return $text;
            }

            // Base64 占位图 (1x1 白色 PNG)
            $placeholderImage = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP8/5+hHgAHggJ/PchI7wAAAABJRU5ErkJggg==';

            // 简化的正则：匹配 <img 标签
            $pattern = '/<img([^>]+)>/i';

            $text = preg_replace_callback($pattern, function($matches) use ($placeholderImage, $text) {
                $imgTag = $matches[0];
                $attributes = $matches[1];

                // 如果已经有 data-src 或 src 是 base64，跳过
                if (strpos($attributes, 'data-src=') !== false) {
                    return $imgTag;
                }

                // 检查是否在 LivePhoto/MotionPhoto 容器内（通过查找附近的标记）
                // 查找图片标签前后是否有 data-live-photo 或 id="files"
                $offset = strpos($text, $imgTag);
                if ($offset !== false) {
                    // 向前查找 200 个字符，看是否有 LivePhoto 标记
                    $before = substr($text, max(0, $offset - 200), 200);
                    if (strpos($before, 'data-live-photo') !== false ||
                        strpos($before, 'id="files"') !== false ||
                        strpos($before, 'alt="Motion Photo"') !== false) {
                        return $imgTag; // 跳过 LivePhoto 图片
                    }
                }

                // 提取 src 属性
                if (preg_match('/src=["\']([^"\']+)["\']/i', $attributes, $srcMatch)) {
                    $originalSrc = $srcMatch[1];

                    // 跳过 base64 图片
                    if (strpos($originalSrc, 'data:') === 0) {
                        return $imgTag;
                    }

                    // 替换 src 为占位图，添加 data-src 和 class
                    $newAttributes = preg_replace(
                        '/src=["\']([^"\']+)["\']/i',
                        'src="' . $placeholderImage . '" data-src="$1"',
                        $attributes
                    );

                    // 添加或追加 lazyload class
                    if (preg_match('/class=["\']([^"\']*)["\']/', $newAttributes)) {
                        $newAttributes = preg_replace(
                            '/class=["\']([^"\']*)["\']/',
                            'class="$1 lazyload"',
                            $newAttributes
                        );
                    } else {
                        $newAttributes .= ' class="lazyload"';
                    }

                    return '<img' . $newAttributes . '>';
                }

                return $imgTag;
            }, $text);

            return $text;
        }

        private static function isEnabled()
        {
            if (null === self::$enabled) {
                $options = Helper::options();
                self::$enabled = isset($options->livePhotoStatus) && $options->livePhotoStatus === 'yes';
            }

            return self::$enabled;
        }

        public static function addEditorButton()
        {
            echo <<<HTML
<script>
window.addEventListener('load', function() {
    var buttonRow = document.getElementById('wmd-button-row');
    if (!buttonRow || document.getElementById('wmd-livephoto-button')) {
        return;
    }

    var button = document.createElement('li');
    button.className = 'wmd-button';
    button.id = 'wmd-livephoto-button';
    button.title = '插入Live Photo/Motion图';
    button.innerHTML = '<span class="wmd-livephoto-icon">Live</span>';
    buttonRow.appendChild(button);

    button.addEventListener('click', function() {
        if (document.getElementById('LivePhotoPanel')) {
            return;
        }

        var panel = document.createElement('div');
        panel.id = 'LivePhotoPanel';
        panel.innerHTML =
            '<div class="wmd-prompt-background" style="position:absolute;top:0;z-index:1000;opacity:0.5;height:100%;left:0;width:100%;"></div>' +
            '<div class="wmd-prompt-dialog">' +
                '<div>' +
                    '<p><b>插入Live Photo/Motion图</b></p>' +
                    '<p>请输入图片URL:</p>' +
                    '<p><input type="text" id="photo-url"></p>' +
                    '<p>请输入视频URL (仅Live Photo需要):</p>' +
                    '<p><input type="text" id="video-url" placeholder="留空则视为Motion图"></p>' +
                    '<p>请输入宽高比(格式如 4/3):</p>' +
                    '<p><input type="text" id="aspect-ratio" placeholder="留空默认为4/3"></p>' +
                '</div>' +
                '<form>' +
                    '<button type="button" class="btn btn-s primary" id="livephoto-ok">确定</button>' +
                    '<button type="button" class="btn btn-s" id="livephoto-cancel">取消</button>' +
                '</form>' +
            '</div>';
        document.body.appendChild(panel);

        document.getElementById('livephoto-cancel').addEventListener('click', function() {
            panel.remove();
            var textarea = document.getElementById('text');
            if (textarea) {
                textarea.focus();
            }
        });

        document.getElementById('livephoto-ok').addEventListener('click', function() {
            var photoUrl = document.getElementById('photo-url').value.trim();
            var videoUrl = document.getElementById('video-url').value.trim();
            var ratio = document.getElementById('aspect-ratio').value.trim();

            if (!photoUrl) {
                return;
            }

            var shortcode = '[LivePhoto photo="' + photoUrl + '"';
            if (videoUrl) {
                shortcode += ' video="' + videoUrl + '"';
            }
            if (ratio && ratio !== '4/3') {
                shortcode += ' ratio="' + ratio + '"';
            }
            shortcode += ']';

            var textarea = document.getElementById('text');
            if (textarea && typeof textarea.value === 'string') {
                var start = textarea.selectionStart || 0;
                var end = textarea.selectionEnd || 0;
                var value = textarea.value;
                textarea.value = value.slice(0, start) + shortcode + value.slice(end);
                textarea.selectionStart = textarea.selectionEnd = start + shortcode.length;
                textarea.focus();
            }

            panel.remove();
        });
    });
});
</script>
<style>
.wmd-livephoto-icon {
    display: inline-block;
    color: #999;
    font-size: 12px;
    line-height: 20px;
}
</style>
HTML;
        }

        private static function shortcode_parse_atts($text)
        {
            $atts = [];
            $pattern = '/([\\w-]+)\\s*=\\s*\"([^\"]*)\"(?:\\s|$)|([\\w-]+)\\s*=\\s*\\\'([^\\\']*)\\\'(?:\\s|$)|([\\w-]+)\\s*=\\s*([^\\s\\\'\"]+)(?:\\s|$)|\"([^\"]*)\"(?:\\s|$)|(\\S+)(?:\\s|$)/';
            $text = preg_replace("/[\\x{00a0}\\x{200b}]+/u", " ", $text);

            if (preg_match_all($pattern, $text, $match, PREG_SET_ORDER)) {
                foreach ($match as $m) {
                    if (!empty($m[1])) {
                        $atts[strtolower($m[1])] = stripcslashes($m[2]);
                    } elseif (!empty($m[3])) {
                        $atts[strtolower($m[3])] = stripcslashes($m[4]);
                    } elseif (!empty($m[5])) {
                        $atts[strtolower($m[5])] = stripcslashes($m[6]);
                    }
                }
            }

            return $atts;
        }

        private static function get_shortcode_regex($tagnames = null)
        {
            $tagregexp = join('|', array_map('preg_quote', $tagnames));
            return '\\[(\\[?)(' . $tagregexp . ')(?![\\w-])([^\\]\\/]*(?:\\/(?!\\])[^\\]\\/]*)*?)(?:(\\/)\\]|\\](?:([^\\[]*+(?:\\[(?!\\/\\2\\])[^\\[]*+)*+)\\[\\/\\2\\])?)(\\]?)';
        }
    }

    FinalTheme_LivePhotoHelper::bootstrap();
}

// 视频插入辅助类（独立功能）
if (!class_exists('FinalTheme_VideoHelper')) {
    class FinalTheme_VideoHelper
    {
        public static function bootstrap()
        {
            // 为编辑器添加视频插入按钮
            Typecho_Plugin::factory('admin/write-post.php')->bottom = [__CLASS__, 'addEditorButton'];
            Typecho_Plugin::factory('admin/write-page.php')->bottom = [__CLASS__, 'addEditorButton'];
        }

        public static function addEditorButton()
        {
            echo <<<HTML
<script>
window.addEventListener('load', function() {
    var buttonRow = document.getElementById('wmd-button-row');
    if (!buttonRow || document.getElementById('wmd-video-button')) {
        return;
    }

    var videoButton = document.createElement('li');
    videoButton.className = 'wmd-button';
    videoButton.id = 'wmd-video-button';
    videoButton.title = '插入视频';
    videoButton.innerHTML = '<span class="wmd-video-icon">▶</span>';
    buttonRow.appendChild(videoButton);

    videoButton.addEventListener('click', function() {
        if (document.getElementById('VideoPanel')) {
            return;
        }

        var panel = document.createElement('div');
        panel.id = 'VideoPanel';
        panel.innerHTML =
            '<div class="wmd-prompt-background" style="position:absolute;top:0;z-index:1000;opacity:0.5;height:100%;left:0;width:100%;"></div>' +
            '<div class="wmd-prompt-dialog">' +
                '<div>' +
                    '<p><b>插入视频</b></p>' +
                    '<p>请输入视频URL:</p>' +
                    '<p><input type="text" id="video-src" placeholder="支持 MP4/WebM 或 YouTube/Bilibili 链接"></p>' +
                    '<p>视频封面图 (可选):</p>' +
                    '<p><input type="text" id="video-poster" placeholder="留空则不显示封面"></p>' +
                    '<p>视频类型:</p>' +
                    '<p>' +
                        '<select id="video-type">' +
                            '<option value="html5">HTML5 视频 (MP4/WebM)</option>' +
                            '<option value="youtube">YouTube</option>' +
                            '<option value="bilibili">Bilibili</option>' +
                        '</select>' +
                    '</p>' +
                '</div>' +
                '<form>' +
                    '<button type="button" class="btn btn-s primary" id="video-ok">确定</button>' +
                    '<button type="button" class="btn btn-s" id="video-cancel">取消</button>' +
                '</form>' +
            '</div>';
        document.body.appendChild(panel);

        document.getElementById('video-cancel').addEventListener('click', function() {
            panel.remove();
            var textarea = document.getElementById('text');
            if (textarea) {
                textarea.focus();
            }
        });

        document.getElementById('video-ok').addEventListener('click', function() {
            var videoSrc = document.getElementById('video-src').value.trim();
            var videoPoster = document.getElementById('video-poster').value.trim();
            var videoType = document.getElementById('video-type').value;

            if (!videoSrc) {
                alert('请输入视频URL');
                return;
            }

            var html = '';

            if (videoType === 'html5') {
                // HTML5 视频标签
                html = '<video controls';
                if (videoPoster) {
                    html += ' poster="' + videoPoster + '"';
                }
                html += ' style="width: 100%; max-width: 100%; height: auto;">';
                html += '<source src="' + videoSrc + '" type="video/mp4">';
                html += '您的浏览器不支持 video 标签。';
                html += '</video>';
            } else if (videoType === 'youtube') {
                // YouTube iframe
                var youtubeId = videoSrc;
                // 尝试从完整 URL 提取视频 ID
                var match = videoSrc.match(/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\s]+)/);
                if (match) {
                    youtubeId = match[1];
                }
                html = '<div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">';
                html += '<iframe src="https://www.youtube.com/embed/' + youtubeId + '" ';
                html += 'style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" ';
                html += 'frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>';
                html += '</iframe></div>';
            } else if (videoType === 'bilibili') {
                // Bilibili iframe
                var bvid = videoSrc;
                // 尝试从完整 URL 提取 BV 号或 AV 号
                var bvMatch = videoSrc.match(/(?:bilibili\.com\/video\/)?(BV[a-zA-Z0-9]+)/);
                var avMatch = videoSrc.match(/(?:bilibili\.com\/video\/)?av(\d+)/);
                if (bvMatch) {
                    bvid = bvMatch[1];
                } else if (avMatch) {
                    bvid = 'av' + avMatch[1];
                }
                html = '<div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden;">';
                html += '<iframe src="https://player.bilibili.com/player.html?bvid=' + bvid + '&page=1" ';
                html += 'style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;" ';
                html += 'frameborder="0" scrolling="no" allowfullscreen>';
                html += '</iframe></div>';
            }

            var textarea = document.getElementById('text');
            if (textarea && typeof textarea.value === 'string') {
                var start = textarea.selectionStart || 0;
                var end = textarea.selectionEnd || 0;
                var value = textarea.value;
                textarea.value = value.slice(0, start) + '\\n' + html + '\\n' + value.slice(end);
                textarea.selectionStart = textarea.selectionEnd = start + html.length + 2;
                textarea.focus();
            }

            panel.remove();
        });
    });
});
</script>
<style>
.wmd-video-icon {
    display: inline-block;
    color: #999;
    font-size: 14px;
    line-height: 20px;
}
</style>
HTML;
        }
    }

    // 自动启用视频插入功能
    FinalTheme_VideoHelper::bootstrap();
}
