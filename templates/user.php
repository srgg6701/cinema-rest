<?php echo "<h3>".User::$resources_links[$segments[1]]."</h3>";?>
<br>
<div class="floatLeft" id="user-content">
<?php echo $content; ?>
</div>
<div class="floatLeft" id="vertical-menu">
    <menu>
    <?php echo User::getUserOptions(true);?>
    </menu>
</div>