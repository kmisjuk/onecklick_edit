<?ob_start()?>
<div class="oneclick modal_background">
    <div class="modal_form">
        <div class="close_form" title="<?=GetMessage("MY_COMP_ONE_CLICK_CLOSE")?>">x</div>
        <p class="title_form"><?=GetMessage("MY_COMP_ONE_CLICK_FORM_TITLE")?></p>
        <div class="form_window">
            <input type="number" autocomplete="off" id="phone_number" placeholder="<?=GetMessage("MY_COMP_ONE_CLICK_PHONE_NUMBER")?>" name="phone_number"/>
            <div class="error_form"></div>
        </div>
        <div class="submit_button"><div class="button"><?=GetMessage("MY_COMP_ONE_CLICK_SUBMIT")?></div></div>
    </div>
</div>
<?
$result = ob_get_contents();
ob_end_clean();
return $result;
?>