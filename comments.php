<link rel="stylesheet" href="/usr/themes/final/comments.css">
<hr>
<h3>评论</h3>
<?php function threadedComments($comments, $options)
{
    $commentClass = "";
    if ($comments->authorId) {
        if ($comments->authorId == $comments->ownerId) {
            $commentClass .= " comment-by-author";
        } else {
            $commentClass .= " comment-by-user";
        }
    }

    $commentLevelClass =
        $comments->levels > 0 ? " comment-child" : " comment-parent";
    $depth = $comments->levels + 1;

    if ($comments->url) {
        $author =
            '<a href="' .
            $comments->url .
            '"target="_blank"' .
            ' rel="external nofollow">' .
            $comments->author .
            "</a>";
    } else {
        $author = $comments->author;
    }
    ?>

<li id="li-<?php $comments->theId(); ?>" class="comment-body<?php
if ($depth > 1 && $depth < 3) {
    echo " comment-child ";
    $comments->levelsAlt("comment-level-odd", " comment-level-even");
} elseif ($depth > 2) {
    echo " comment-child2";
    $comments->levelsAlt(" comment-level-odd", " comment-level-even");
} else {
    echo " comment-parent";
}
$comments->alt(" comment-odd", " comment-even");
?>">
    <div id="<?php $comments->theId(); ?>">
        <?php
        $host = "https://cravatar.cn/";
        $url = "/avatar/";
        $size = "80";
        $default = "mm";
        $rating = Helper::options()->commentsAvatarRating;
        $hash = md5(strtolower($comments->mail));
        $avatar =
            $host .
            $url .
            $hash .
            "?s=" .
            $size .
            "&r=" .
            $rating .
            "&d=" .
            $default;
        ?>
        <div class="comment-view" onclick="">
            <div class="comment-header">
                <img class="avatar" src="<?php echo $avatar; ?>" width="<?php echo $size; ?>" height="<?php echo $size; ?>" />
                <div style="display: grid;">
                    <span class="comment-author<?php echo $commentClass; ?>"><?php echo $author; ?></span>
                    <time class="comment-time"><?php $comments->date(
                        "Y-M-j"
                    ); ?></time>
                </div>
            </div>
            <div class="comment-content"> <?php $comments->content(); ?>
            </div>
            <div class="comment-meta">
                <span class="comment-reply" data-no-instant><?php $comments->reply(
                    "Reply"
                ); ?></span>
            </div>
        </div>
    </div>
    <?php if ($comments->children) { ?>
        <div class="comment-children">
            <?php $comments->threadedComments($options); ?>
        </div>
    <?php } ?>
</li>
<?php
} ?>

<div id="<?php $this->respondId(); ?>" class="comment-container">
    <div id="comments" class="clearfix">
        <?php $this->comments()->to($comments); ?>
        <?php if ($this->allow("comment")): ?>
        <form method="post" action="<?php $this->commentUrl(); ?>" id="comment-form" class="comment-form" role="form" onsubmit ="getElementById('misubmit').disabled=true;return true;">
            <?php if (!$this->user->hasLogin()): ?>
            <div style="display: flex; gap: 10px;">

            <input type="text" name="author" maxlength="12" id="author" class="form-control input-control clearfix" placeholder="您的称谓" value="" required>
            
            <input type="url" name="url" id="url" class="form-control input-control clearfix" placeholder="站点地址" value="" <?php if (
                $this->options->commentsRequireURL
            ): ?> required<?php endif; ?>>
            
            <input type="email" name="mail" id="mail" class="form-control input-control clearfix" placeholder="邮箱" value="" <?php if (
                $this->options->commentsRequireMail
            ): ?> required<?php endif; ?>>
            
            </div>
            
            <?php endif; ?>

            <textarea name="text" id="textarea" class="form-control" placeholder="评论内容" required ><?php $this->remember(
                "text",
                false
            ); ?></textarea>

            <button type="submit" class="submit" id="misubmit">提交你的评论</button>
            <?php $security = $this->widget("Widget_Security"); ?>
            <input type="hidden" name="_" value="<?php echo $security->getToken(
                $this->request->getReferer()
            ); ?>">
        </form>
        <?php else: ?>
            <span class="response">评论区暂时被关闭了</span>
        <?php endif; ?>

        <?php if ($comments->have()): ?>

        <?php $comments->listComments(); ?>

        <div class="lists-navigator clearfix">
            <?php $comments->pageNav("←", "→", "2", "..."); ?>
        </div>

        <?php endif; ?>
    </div>
</div>