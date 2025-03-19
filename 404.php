<?php
if (!defined("__TYPECHO_ROOT_DIR__")) {
    error_log("__TYPECHO_ROOT_DIR__ is not defined.");
    exit();
}

if (!function_exists("_e")) {
    function _e($text)
    {
        return $text;
    }
}

$this->need("header.php");
?>
<main>
    <h1> 404 - <?php _e("页面没找到"); ?></h1>
    <h3> <?php _e("你想查看的页面已被转移或删除了"); ?></h3>
</main>
<?php $this->need("footer.php");
?>
