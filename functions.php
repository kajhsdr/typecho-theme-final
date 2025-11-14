<?php
if (!defined("__TYPECHO_ROOT_DIR__")) {
    exit();
}

function themeConfig($form)
{
    $logoUrl = new \Typecho\Widget\Helper\Form\Element\Text(
        "logoUrl",
        null,
        "default-logo.png",
        _t("站点 LOGO 地址"),
        _t("在这里填入一个图片 URL 地址")
    );
    $form->addInput($logoUrl);

    $pjaxStatus = new \Typecho\Widget\Helper\Form\Element\Radio(
        'pjaxStatus',
        [
            'yes'   => '是',
            'no'    => '否'
        ],
        'no',
        '是否启用全站 PJAX',
        '开启后,全站页面实现 PJAX 无刷新跳转'
    );
    $form->addInput($pjaxStatus);

    $codeHighlight = new \Typecho\Widget\Helper\Form\Element\Radio(
        'codeHighlight',
        [
            'yes'   => '是',
            'no'    => '否'
        ],
        'yes',
        '是否启用代码高亮',
        '开启后,使用 Prism.js 实现代码语法高亮'
    );
    $form->addInput($codeHighlight);

    $addhead = new \Typecho\Widget\Helper\Form\Element\Textarea(
        "addhead",
        null,
        null,
        _t("头部代码"),
        _t("可填写自定义 CSS、JS 代码等")
    );
    $form->addInput($addhead);

    $addfoot = new \Typecho\Widget\Helper\Form\Element\Textarea(
        "addfoot",
        null,
        null,
        _t("页脚代码"),
        _t("支持 HTML，可填写备案、统计等信息")
    );
    $form->addInput($addfoot);
}
