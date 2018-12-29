<?php  if (count($positives) > 0) : ?>
  <div class="error">
  	<?php foreach ($positives as $error) : ?>
  	  <p><?php echo $error ?></p>
  	<?php endforeach ?>
  </div>
<?php  endif ?>