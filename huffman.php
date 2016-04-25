<?php



$string = 'bom esse bombom';


/**
 * Calculamos a probabilidade de cada um dos caracteres
 */
$aTree = array();

foreach (count_chars($string, 1) as $asc => $count ) {
  $aTree[]  = array($count, chr($asc));
}

/**
 * Ordenamos o array de forma crescente.
 */
asort($aProbability);

while (count($aTree) > 1) {
  $aTree = doThehand($aTree);
}

function doTheHand($aTree) {

  $t1 = array_shift($aTree);
  $t2 = array_shift($aTree);

  $aTree[] = array($t1[0] + $t2[0], array($t1, $t2));

  sort($aTree);
  return $aTree;
}

print_r($aTree);


echo "=======================" . PHP_EOL;
print_r(array_search("b", $aTree));
