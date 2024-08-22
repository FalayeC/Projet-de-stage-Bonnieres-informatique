<?php
//Fonction de débugage
function debug($variable){
    echo '<pre>'.print_r($variable,true).'</pre>';
}

function noAccent($text){
     // Convertit toutes les lettres du texte en minuscules en utilisant l'encodage UTF-8
    $text = mb_strtolower($text, 'UTF-8');
    // Remplace les caractères accentués par leurs équivalents non accentués
    $text = str_replace(
        array(
            'à', 'â', 'ä', 'á', 'ã', 'å',
            'î', 'ï', 'ì', 'í',
            'ô', 'ö', 'ò', 'ó', 'õ', 'ø',
            'ù', 'û', 'ü', 'ú',
            'é', 'è', 'ê', 'ë',
            'ç', 'ÿ', 'ñ', ' ',
        ),
        array(
            'a', 'a', 'a', 'a', 'a', 'a',
            'i', 'i', 'i', 'i',
            'o', 'o', 'o', 'o', 'o', 'o',
            'u', 'u', 'u', 'u',
            'e', 'e', 'e', 'e',
            'c', 'y', 'n', '-',
        ),
        $text
    );
	  // Remplace les caractères non alphanumériques (hors points) par des tirets
      $text = preg_replace('#([^.a-z0-9]+)#i', '-', $text);

      // Remplace les occurrences de plusieurs tirets consécutifs par un seul tiret
      $text = preg_replace('#-{2,}#', '-', $text);
  
      // Supprime les tirets à la fin de la chaîne
      $text = preg_replace('#-$#', '', $text);
  
      // Supprime les tirets au début de la chaîne
      $text = preg_replace('#^-#', '', $text);
  
      // Retourne la chaîne transformée
      return $text;
  }