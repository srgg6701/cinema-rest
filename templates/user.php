<?php echo "<h3>".Common::$resources_links[$segments[1]]."</h3>";?>
<br>
<div class="floatLeft" id="user-content">
<?php echo $content; ?>
</div>
<div class="floatLeft" id="vertical-menu">
    <menu>
    <?php echo Common::getUserOptions(true);?>
    </menu>
</div>