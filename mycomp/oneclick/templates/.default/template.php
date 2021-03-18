<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>
<div class="oneclick">
    <div class="button call_form"><?=GetMessage("MY_COMP_ONE_CLICK_BUTTON_NAME")?></div>
</div>
<script>
    const oneclickTemplateFolder = "<?=$templateFolder?>";
    const oneclickParams = <?=json_encode($arParams)?>;
</script>