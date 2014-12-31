<?php

/**
 * @author Rodrigo Prado de Jesus - <royopa@gmail.com>
 */

namespace Extractor;

class Extractor
{
    private $nodeValues;

    public function __construct($nodeValues)
    {
        $this->nodeValues = $nodeValues;
    }

    private function clean(\ArrayIterator $files)
    {
        foreach ($files as $key => $value) {
            if (is_null($value[0])) {
                $files->offsetUnset($key);
                continue;
            }
        }

        return $files;
    }

    /**
     * Função que extrai os nomes de arquivos que ainda faltam serem traduzidos
     * @access public
     */
    public function build()
    {
        $files = new \ArrayIterator();

        foreach ($this->nodeValues as $key => $value) {
            $files->append(
                array(
                    $this->getPath($value[0]),
                    $value[0],
                    $value[1]
                )
            );
        }

        return $this->clean($files);
    }


    public function getFullNames()
    {
        $files     = $this->build();
        $fullNames = new \ArrayIterator();
        
        foreach ($files as $key => $value) {
            $fullNames->append(ltrim($value[0], '/') . '/' . $value[1]);
        }

        return $fullNames;
    }

    private function getPath($xmlName)
    {
        foreach ($this->nodeValues as $key => $value) {
            if ($xmlName == $value[0]) {
                for ($i = $key; $i; --$i) {
                    if(stristr($this->nodeValues[$i][0], '/') !== FALSE) {
                        return $this->nodeValues[$i][0];
                    }
                }
            }
        }
    }
}