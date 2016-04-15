<?php namespace App\Virl;

use Illuminate\Support\Facades\File;

class VirlParser
{

    private $folder;

    private $virlInput;


    public function __construct($folder)
    {
        $this->virlInput = base_path('virl-configs/virl.base.virl');
        $this->folder    = $folder;
    }


    public function injectFiles()
    {
        $dom = new \DOMDocument('1.0', 'utf-8');
        $dom->load($this->virlInput);
        $elements = $dom->getElementsByTagName('node');
        foreach ($elements as $e) {
            $currentFile = $this->folder . '/' . $e->getAttribute('name') . '.txt';

            $extension             = $dom->createElement("extensions");
            $entry                 = $dom->createElement("entry");
            $key_attribute         = $dom->createAttribute('key');
            $type_attribute        = $dom->createAttribute('type');
            $key_attribute->value  = "config";
            $type_attribute->value = "String";
            $entry->appendChild($key_attribute);
            $entry->appendChild($type_attribute);


            if (file_exists($currentFile)) {
                $entry->appendChild($dom->createTextNode(str_replace(array( "\r\n", "\r" ), "\n",
                    File::get($currentFile))));
                $extension->appendChild($entry);
                $e->insertBefore($extension, $e->firstChild);
            } elseif(file_exists(strtolower($currentFile))){
                $entry->appendChild($dom->createTextNode(str_replace(array( "\r\n", "\r" ), "\n",
                    File::get(strtolower($currentFile)))));
                $extension->appendChild($entry);
                $e->insertBefore($extension, $e->firstChild);
            }
        }

        File::put($this->folder . '.virl', $dom->saveXML());

        return $this->folder.".virl";
    }
}