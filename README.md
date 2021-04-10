# Plugin Optico

Example 

Le plugin Optico gère l'affichage des numéros Optico dans Wordpress. Une fois activé, il remplace les numéros de téléphone de notre site par des numéros surtaxés et affiche une mention et un cartouche.

Le présent plugin a donc 2 fonctions :
 * Intégrer dans Wordpress le code Javascript fourni par Optico (qui va remplacer les numéros automatiquement)
 * Enjoliver les numéros cliquables : afficher une mention légale et un cartouche lorsque les numéros sont cliqués.

## Personnalisation du plugin

Le plugin est conçu pour être souple et hautement personnalisable.

Il est possible :

* D'insérer un code Optico personnalisé
* De modifier la mention légale affichée sous les numéros
* De changer l'image des numéros cartouches pour les versions desktop et mobile
* De personnaliser l'affichage via du code CSS

### Insertion d'un code Optico personnalisé

Le code fourni par Optico sera toujours sensiblement le même. Lors de l'activation du plugin, un code Optico par défaut sera activé. Ce code se trouve dans le fichier `code-optico.js` du plugin.

Pour insérer un code personnalisé, il suffit de remplacer le code par défaut du fichier `code-optico.js` par votre code. Il est nécessaire d'inclure les balises <script> et </script>.

La nuance entre les différents codes Optico se fera sur l'attribut `pattern` (ligne 14) qui est une expression régulière représentant le format des numéros à remplacer (tous les numéros à 10 chiffres commençants par 03, 04, mais pas les 06 par exemple).

Pour modifier ce format, l'intervention d'un développeur est préférable.

### Modification de la mention légale

La mention légale affichée automatiquement se trouve dans le fichier `mention.txt` à la racine du plugin. Il suffit de remplacer le texte tout en prenant soin de conserver la balise `<p class="mention-optico">` afin de pouvoir gérer la mise en forme via CSS.

### Remplacement des images cartouches

Les fonds des numéros cartouches sont stockés à la racine du plugin, il s'agit des fichiers `cartouche.png` et `cartouche-mobile.png` respectivement pour les versions desktop et mobile.

Il suffit de remplacer ces images pour changer le fond. Veillez à vider le cache navigateur (CTRL+F5) et Wp-Rocket pour tester.

Il est préférable de remplacer ces images par des images ayant les mêmes dimensions, si la taille des images diffère il faudra ajuster le code CSS (proprité `div.optico` dans le CSS).

### Personnalisation graphique via le CSS

Le fichier `mise-en-forme.css` contient le code CSS du plugin. Des commentaires permettent une prise en main facile de la feuille de style. Comme pour les images il faut veuiller à vider les caches lors des tests.

Chaque propriété CSS contient une bordure volontairement invisible définie par : `border: 0px solid`. Il ne faut pas hésiter à activer les bordures des zones (**div** et **span**) en passant la propriété à  `border: 1px solid`. Cela permet un positionnement plus précis sur la page. Chaque bordure est différente, soit par la couleur soit par le style de trait, pour les versions desktop et mobile.

La feuille de style gère tout le desgin des numéros Optico, sauf la couleur du numéro surtaxé, celle-ci se configure dans le [backoffice Optico](https://www.optico.fr/settings.html).

### Remarques

* Le fichier `code-du-plugin.js` contient le code Javascript nécessaire au bon fonctionnement du plugin, il est donc déconseillé d'y toucher.
* Penser à faire une sauvegarde des fichiers avant de les modifier (en les renommant `fichier.js.old` par exemple).
