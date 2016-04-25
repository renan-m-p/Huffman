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
asort($aTree);

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

// print_r($aTree);

doTheHando2($aTree);
$aCArinha = array();

function doTheHando2($aTree, $sValue = '') {
  if (!is_array($aTree[0][1])) {
      $aCArinha[$aTree[0][1]] = $sValue.'0';
  } else {
      doTheHando2($aTree[0][1], $sValue.'0');
  }

  if (isset($aTree[1])) {
    if (!is_array($aTree[1][1])) {
      $aCArinha[$aTree[1][1]] = $sValue.'1';
    } else {
      doTheHando2($aTree[1][1], $sValue.'1');
    }
  }
  print_r($aCArinha);
}
