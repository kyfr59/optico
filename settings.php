<br /><br /><h1>Configuration du plugin Optico</h1>

<?php
  if (is_array($_POST) && is_array($_POST['remplacements'])) {
    update_option( 'optico_remplacements', json_encode($_POST['remplacements']));
  }
  $remplacements = json_decode(get_option('optico_remplacements'));
  foreach($remplacements as $remplacement) {
    $checked[$remplacement] = " checked ";
  }
?>

<div>
  <form method="post" action="#">
    <br />
    <h3>Type de remplacement</h3>
    <p>
      <ul>
        <?php foreach ($t_remplacements as $key => $remplacement): ?>
          <li><input <?php echo $checked[$key] ?> type="checkbox" name="remplacements[]" value="<?php echo $key ?>">&nbsp;<?php echo $remplacement['label'] ?></li>
         <?php endforeach; ?>
      </ul>
    </p>
    <br /><br /><input type="submit" name="submit" id="submit" class="button button-primary" value="Enregistrer les modifications">
   </form>
</div>

