<?php

class XmlWriterWrapper {

    public function GenerateXmlFromList($rootElementName, $list) {
        $writer = new XMLWriter();
        $writer->openMemory();
        $writer->setIndent(4);
        $writer->startDocument('1.0','UTF-8');
        $writer->startElement($rootElementName);

        foreach ($list as $listItem){
            $listItem->assembleXmlElement($writer);
        }

        $writer->endElement();
        $writer->endDocument();
        return $writer->outputMemory();
    }
} 