<?php

/*
Plugin Name: Optico
Description: Gère l'affichage des numéros Optico
Version:     1.0
Author:      Franck Dupont
Author URI:  http://franck-dupont.me
License:     GPL2
*/


// Inclus les scripts JS & CSS
add_action( 'wp_footer', 'optico_load_optico_script_in_footer' );
function optico_load_optico_script_in_footer() {

  // Inclusion du code Optico
  $file_code_optico = __DIR__ . '/code-optico.js';
    if (is_file($file_code_optico)) {
    echo file_get_contents($file_code_optico);
  }

 // Inclusion du code Javascript du plugin
 $file_code_du_plugin = __DIR__ . '/code-du-plugin.js';
  if (is_file($file_code_du_plugin)) {
    echo file_get_contents($file_code_du_plugin);
  }

  // Inclusion du code CSS
 $file_css = __DIR__ . '/mise-en-forme.css';
  if (is_file($file_css)) {
    echo file_get_contents($file_css);
  }
}


// Crée la zone "Numéro d'origine"
add_action( 'admin_init', 'optico_create_numero_metabox' );
function optico_create_numero_metabox() {
  add_meta_box( 'optico_numero_metabox', 'Numéro de téléphone d\'origine', 'optico_display_numero_metabox', ['page', 'post'], 'side', 'low');
}


// Affiche la zone "Numéro d'origine"
function optico_display_numero_metabox() {

  global $post;
  $numero_optico = get_post_meta($post->ID, 'numero_optico', true);
  echo '<p>Pour être remplacé par Optico, le numéro doit compoter 10 chiffres sans espaces.</p>';
  echo '<input type="text" name="numero_optico" value="'.$numero_optico.'" />';
}


// Gère la sauvegarde du numéro d'origine
add_action( 'save_post', 'optico_save_numero');
function optico_save_numero() {

  global $post;
  global $wpdb;

  $numero_optico = $_POST['numero_optico'];

  if (metadata_exists( 'post', $post->ID, 'numero_optico' ) ) {
    update_post_meta($post->ID, 'numero_optico', $numero_optico);
  } else {
    add_post_meta( $post->ID, 'numero_optico', $numero_optico );
  }
}

/*

function opposition_optico($content) {

  if (get_post_type() == 'page' || get_post_type() == 'post') {

  global $post;

  $html  = <<<HTML
<div class="optico-mention">
  Ce numéro n'est pas le numéro direct du destinataire mais celui d'un service valable depuis la France métropole pour obtenir directement le numéro de téléphone de ce dernier.
</div>
HTML;

return $html.$content;
  }

  return $content;
}
add_action( 'the_content', 'opposition_optico' );

*/




