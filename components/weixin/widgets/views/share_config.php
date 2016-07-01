<?php if($HTMLBlock): ?>
<script src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
<script>
    wx.config(<?=$config?>);
</script>
<?php else: ?>
wx.config(<?=$config?>);
<?php endif; ?>
