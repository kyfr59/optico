<script>
jQuery(document).ready(function($) {

    var mention = loadFile("/wp-content/plugins/optico/mention.txt") // Charge la mention Optico depuis le fichier mention.txt

    var mentionsIds = new Array(); // Tableau qui stocke les IDs de zone optico ayant déjà la mention (pour éviter la double insertion de la mention liée l'évènement "DOMNodeInserted" )

    $(document).on('DOMNodeInserted', '[id^="optico-phone-"]', function() {

        var id = $(this).attr('id'); // Récupération de l'ID de la zone Optico

        if ( mentionsIds.indexOf(id) === -1) { // Si l'ID n'est pas dans le tableau

            $(this).after(mention); // On affiche la mention
            mentionsIds.push(id); // On ajoute l'ID dans le tableau
        }
    });

    $(document).on('click', '[id^="optico-phone-"]', function() { // Lors d'un clic sur un numéro Optio :

        $(this).wrap('<div class="optico"></div>'); // Enveloppe le numéro d'un div.optico pour pouvoir opérer de la mise en forme via CSS

        $('div.optico').addClass('cartouche'); // Ajoute l'attribut "cartouche"
    });

    console.log('Le code du plugin est chargé.');
});



/* Charge un fichier depuis le serveur */

function loadFile(filePath) {
  var result = null;
  var xmlhttp = new XMLHttpRequest();
  xmlhttp.open("GET", filePath, false);
  xmlhttp.send();
  if (xmlhttp.status==200) {
    result = xmlhttp.responseText;
  }
  return result;
}

</script>