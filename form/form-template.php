<? $url = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']; ?>
<form class="contact-form" id="form_<?=$form_id?>">
  <input type="hidden" name="key" value="" class="form-key">
  <input type="hidden" name="form_id" value="<?=$form_id?>">
  <input type="hidden" name="site-name" value="<?=get_option('formsender_from_name')?>">
  <input type="hidden" name="url" value="<?=$url?>">
  <div>
    <?=get_field('form_content', $form_id)?>
  </div>
  <div class="form-result"></div>
</form>
<script>
$(document).ready(function() {
  $(window).on("mousemove click", function(){ 
    $(".form-key").val("<?=md5('secretkey')?>");
  });
});
</script>