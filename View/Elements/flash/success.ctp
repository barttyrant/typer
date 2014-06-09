<?php
$customClasses = is_array($class) ? join(' ', $class) : $class;
$autohideClass = '';
if (!empty($autohide)) {
    $delay = is_numeric($autohide) ? $autohide : 3000;
    $autohideClass = 'autohide hide_' . $delay;
}
$classes = array('flashMessage', trim($type), trim($customClasses), trim($autohideClass));
?>
<div class="<?php echo join(' ', $classes); ?>" id="<?php echo $divId; ?>">
    <p class="flashMessageContent">
        <?php echo $message; ?>
    <span class="closeButton">
        <img src="/img/icons/close.png" alt="close it" title="close it" />
    </span>
</p>    
</div>