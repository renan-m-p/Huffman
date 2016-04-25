<?php



$string = 'bom esse bombom';


/**
 * Calculamos a probabilidade de cada um dos caracteres
 */
$aProbability = array();

foreach (count_chars($string, 1) as $asc => $count ) {
  $aProbability[chr($asc)]  = $count;
}


/**
 * Ordenamos o array de forma crescente.
 */
asort($aProbability);

$aTree = array();



foreach ($aProbability as $char => $key) {
  $aTree[][$key] = $char;
}

while (count($aTree) > 1) {
  $aTree = doThehand($aTree);
}



function doTheHand($aTree) {


  $t1 = $aTree[0];
  $t2 = $aTree[1];

  $weight = (int) array_keys($t1)[0] + array_keys($t2)[0];
  
  

  $aAux = array();

  $aAux[0] =  $t1;
  $aAux[1] =  $t2;

  $r = array();

  $r[$weight] = $aAux;

  unset($aTree[0]);
  unset($aTree[1]);

  $aTree[] = $r;

  sort($aTree);

  return $aTree;
}

print_r($aTree);