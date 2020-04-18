<div id="alerts">
  <?php $errors = getErrorMessages();foreach ($errors as $error) { ?>
  <div class="alert-top alert-error">
    <div class="small-container">
      <p><?=$error?></p>
    </div>
  </div>
  <?php } ?>
  <?php $successes = getSuccessMessages();foreach ($successes as $success) { ?>
  <div class="alert-top alert-success">
    <div class="small-container">
      <p><?=$success?></p>
    </div>
  </div>
  <?php } clearMessages(); ?>
</div>