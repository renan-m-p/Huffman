<?php
require_once('Huffman.php');

$sCommand = $argv[1];
$sFile    = $argv[2];

try {

  if (!is_string($sCommand)) {
    throw new Exception("Informe um comando válido, [-e] encode [-d] decode");
  }

  if (!file_exists($sFile)) {
    throw new Exception("Arquivo não informado ou não existe");
  }

  $sContent = file_get_contents($sFile);
  $sName    = basename($sFile);

  $oHuffman = new Huffman();

  switch ($sCommand) {
    case '-e':

      $sCompressedString = $oHuffman->encode($sContent);
      file_put_contents('compressed/'.$sName, $sCompressedString);

      echo 'Texto original:' . PHP_EOL .$sContent;
      echo 'Texto codificado:' . PHP_EOL .$sCompressedString;
      echo 'Arquivo:' . PHP_EOL . 'compressed/'.$sName;

      break;
    case '-d':

      $sString = $oHuffman->decode($sContent);
      echo 'Texto descompactado:' . PHP_EOL .$sString;

      break;
    default:
      throw new Exception("Comando inválido");
      break;
  }
} catch (Exception $e) {
  echo $e->getMessage();
}