<?php

/**
* 
*/
class Huffman {

  private $sText;

  private $aTree = array();

  private $aDictionary = array();
  
  function __construct() {}

  public function encode($sText) {

    if (!is_string($sText)) {
      throw new Exception("Texto a ser codificado não informado");
    }

    $this->sText = $sText;

    $aCharacters = $this->calcCharacters();
    $this->aTree = $this->makeTree($aCharacters);
    $this->makeDictionary($this->aTree[0][1]);

    /**
     * The header is the tree.
     */
    $sCompressedString = base64_encode(json_encode($this->aTree)) . PHP_EOL;

    for ($iChar = 0; isset($this->sText[$iChar]); ++$iChar ) {
      $sCompressedString .= $this->aDictionary[$this->sText[$iChar]];
    }

    return $sCompressedString;
  }

  public function decode($sText) {

    if (!is_string($sText)) {
      throw new Exception("Texto a ser decodificado não informado");
    } 

    /**
     * Separate the tree and the compressed text
     */
    $aText = split(PHP_EOL, $sText);
    $this->aTree = json_decode(base64_decode($aText[0]));
    $this->sText = $aText[1];
    
    $this->aTree = $this->aTree[0][1];

    $aAux     = array();
    $sDecoded = '';

    for ($iChar = 0; isset($this->sText[$iChar]); ++$iChar ) {

      $ibit = $this->sText[$iChar];


      if(!isset($aAux[0])) {
        $aAux = $this->aTree[$ibit][1];
      } else {
        $aAux = $aAux[$ibit][1];
      }

      if (is_string($aAux)) {
        $sDecoded .= $aAux; 
        $aAux      = array();
      }
    }

    return $sDecoded;
  }

  /**
   * return an array with the number of times that the characters appear
   * @return array $aCharacters ([2,A],[3,B])
   */
  private function calcCharacters() {

    $aCharacters = array();

    foreach (count_chars($this->sText, 1) as $sChar => $iCount ) {
      $aCharacters[]  = array($iCount, chr($sChar));
    }

    sort($aCharacters);

    return $aCharacters;
  }

  /**
   * make array representing a tree with its characters and their weights
   * 
   * @param array 
   * @return array $aCharacters
   */
  private function makeTree($aCharacters) {

    while(count($aCharacters) > 1) {

      $node1 = array_shift($aCharacters);
      $node2 = array_shift($aCharacters);

      $aCharacters[] = array($node1[0] + $node2[0], array($node1, $node2));
      sort($aCharacters);
    }

    return $aCharacters;
  }

  /**
   * Make a dictionary, with the path to the nodes.
   * EX.: [a] => 0
   *      [b] => 10
   */
  private function makeDictionary($aTree, $sValue = '') {

    if (!is_array($aTree[0][1])) {
      $this->aDictionary[$aTree[0][1]] = $sValue.'0';
    } else {
        $this->makeDictionary($aTree[0][1], $sValue.'0');
    }

    if (isset($aTree[1])) {
      if (!is_array($aTree[1][1])) {
        $this->aDictionary[$aTree[1][1]] = $sValue.'1';
      } else {
        $this->makeDictionary($aTree[1][1], $sValue.'1');
      }
    }
  }
}