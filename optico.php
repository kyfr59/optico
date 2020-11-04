<?php

/*
Plugin Name: Optico
Description: Gère l'affichage des numéros Optico
Version:     1.1
Author:      Franck Dupont
Author URI:  http://franck-dupont.me
License:     GPL2
*/

$t_remplacements[0] =  ['label' => 'Numéros à 4 chiffres commençants par 39 (exemple : 3949)',
                        'pattern' => '([3][9]\d{2})'
                       ];
$t_remplacements[1] =  ['label' => 'Numéros à 10 chiffres commençants par 0 (exemple : 0145877788)',
                        'pattern' => '([0]\d{9})'
                       ];
$t_remplacements[2] =  ['label' => 'Numéros à 10 chiffres commençants par 0, séparés par un point (exemple : 01.45.87.77.88)',
                        'pattern' => '([0]\d{1}\.\d{2}\.\d{2}\.\d{2}\.\d{2})'
                       ];
$t_remplacements[3] =  ['label' => 'Numéros à 10 chiffres commençants par 0, séparés par un espace (exemple : 01 45 87 77 88)',
                        'pattern' => '([0]\d{1}\ \d{2}\ \d{2}\ \d{2}\ \d{2})'
                       ];
$t_remplacements[4] =  ['label' => 'Numéros à 10 chiffres commençants par 0, séparés par un tiret (exemple : 01-45-87-77-88)',
                        'pattern' => '([0]\d{1}\-\d{2}\-\d{2}\-\d{2}\-\d{2})'
                       ];
$t_remplacements[5] =  ['label' => 'Numéros à 10 chiffres commençants par 0, séparés par un slash (exemple : 01/45/87/77/88)',
                        'pattern' => '([0]\d{1}\/\d{2}\/\d{2}\/\d{2}\/\d{2})'
                       ];

// Inclus les scripts JS & CSS
add_action( 'wp_footer', 'optico_load_optico_script_in_footer' );
function optico_load_optico_script_in_footer() {

  global $t_remplacements;

  // Inclusion du code Optico
  $file_code_optico = __DIR__ . '/code-optico.js';
  if (is_file($file_code_optico)) {

    $code_optico = file_get_contents($file_code_optico);
    $remplacements = json_decode(get_option('optico_remplacements'));

    if (count($remplacements) == 0) {
      $patterns[] = $t_remplacements[1]['pattern']; // Remplacement par défaut
    } else {
      foreach($remplacements as $remplacement) {
        $patterns[] = $t_remplacements[$remplacement]['pattern'];
      }
    }
    $pattern = implode('|', $patterns);
    echo $code_optico = str_replace('__PATTERN__',   '/'.$pattern.'/g', $code_optico);
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


// Gère l'affichage du numéro d'origine sur les pages du front
add_action( 'the_content', 'optico_affiche_numero_origine' );
function optico_affiche_numero_origine($content) {

  if ( is_admin() ) return $content;

  if (get_post_type() != 'page' && get_post_type() != 'post') return $content;

  global $post;

  $numero_optico = trim(get_post_meta($post->ID,'numero_optico',true));

  // Vérification du format :
  //  - numéros à 10 chiffres commençants par un 0
  //  - numéros à 4 chiffres commençants par 39
  preg_match('/([0]\d{9})|([3][9]\d{2})/', $numero_optico, $matches);
  if (!isset($matches[0]))  return $content;

  $html  = '<p>';
  $html .=    $numero_optico;
  $html .= '</p>';

  return $html . $content;
}


// Ajoute le lien "Réglages" dans la liste des extensions
add_filter( 'plugin_action_links_'.plugin_basename( __FILE__ ), 'optico_add_settings_link', 10, 2 );
function optico_add_settings_link( $links, $file ) {
    array_unshift( $links, '<a href="' . admin_url( 'admin.php?page=optico/settings.php' ) . '">' . __( 'Settings' ) . '</a>' );
    return $links;
}


// Déclare la page des réglages Optico
add_action( 'admin_menu', 'optico_declare_settings_page' );
function optico_declare_settings_page() {
    add_menu_page(
        __( 'Optico settings', 'textdomain' ),
        'optico settings',
        'manage_options',
        'optico/settings.php',
        '',
        null,
        6
    );
}

// Supprime lien lien vers la page dans le menu du backoffice
add_action( 'admin_init', 'optico_remove_settings_link_from_menu' );
function optico_remove_settings_link_from_menu() {
    remove_menu_page( 'optico/settings.php' );
}