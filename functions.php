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
            if (!$text || !$widget instanceof Widget_Archive || !self::isEnabled()) {
                return $text;
            }

            $pattern = self::get_shortcode_regex(['LivePhoto']);
            return preg_replace_callback("/$pattern/", [__CLASS__, 'parseCallback'], $text);
        }

        public static function parseCallback($matches)
        {
            $attrs = self::shortcode_parse_atts($matches[3]);

            if (isset($attrs['photo']) && !isset($attrs['video'])) {
                $ratio = isset($attrs['ratio']) ? $attrs['ratio'] : '4/3';
                return sprintf(
                    '<div style="width: auto; aspect-ratio: %s; margin: auto;" id="files">
                        <div><img src="%s" alt="Motion Photo" style="width: 100%%; height: auto;"></div>
                    </div>',
                    $ratio,
                    $attrs['photo']
                );
            } elseif (isset($attrs['photo']) && isset($attrs['video'])) {
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
