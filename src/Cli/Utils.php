<?php

namespace Sophy\Cli;

trait Utils
{
    private function rcopy($source, $target)
    {
        if (is_dir($source)) {
            @mkdir($target, 0777, true);
            $d = dir($source);
            while (FALSE !== ($entry = $d->read())) {
                if ($entry == '.' || $entry == '..') {
                    continue;
                }
                $Entry = $source . '/' . $entry;
                if (is_dir($Entry)) {
                    $this->rcopy($Entry, $target . '/' . $entry);
                    continue;
                }
                copy($Entry, $target . '/' . $entry);
            }

            $d->close();
        } else {
            copy($source, $target);
        }
    }

    private function replaceFileContent($target, $replacement, $valueToChange = 'objectbase')
    {
        $content1 = file_get_contents($target);
        if ($valueToChange == 'objectbase') {
            $content2 = preg_replace("/" . 'Objectbase' . "/", ucfirst($replacement), $content1);
            $content3 = preg_replace("/" . 'objectbase' . "/", $replacement, $content2);
        } else {
            $content3 = preg_replace("/" . $valueToChange . "/", $replacement, $content1);
        }
        file_put_contents($target, $content3);
    }

    function _writeFile($fClass, $fName)
    {

        if (!$handle = fopen($fName, 'w')) {
            exit;
        }

        if (fwrite($handle, $fClass) === FALSE) {
            exit;
        }
        fclose($handle);

    }

}