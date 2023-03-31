<?php

function recursiveCopy($source, $target) {
    if (is_dir($source)) {
        @mkdir($target, 0777, true);
        $d = dir($source);
        while (false !== ($entry = $d->read())) {
            if ($entry == '.' || $entry == '..') {
                continue;
            }
            $entryDir = $source . '/' . $entry;
            if (is_dir($entryDir)) {
                recursiveCopy($entryDir, $target . '/' . $entry);
                continue;
            }
            copy($entryDir, $target . '/' . $entry);
        }

        $d->close();
    } else {
        copy($source, $target);
    }
}

function replaceFileContent($target, $replacement, $valueToChange = 'objectbase') {
    $content1 = file_get_contents($target);
    if ($valueToChange == 'objectbase') {
        $content2 = preg_replace("/" . 'Objectbase' . "/", ucfirst($replacement), $content1);
        $content3 = preg_replace("/" . 'objectbase' . "/", $replacement, $content2);
    } else {
        $content3 = preg_replace("/" . $valueToChange . "/", $replacement, $content1);
    }
    file_put_contents($target, $content3);
}

function writeFile($fClass, $fName) {
    if (!$handle = fopen($fName, 'w')) {
        exit;
    }

    if (fwrite($handle, $fClass) === false) {
        exit;
    }
    fclose($handle);
}

function stringInFileFound($path, $valueFind) {
    $handle = fopen($path, 'r');
    $valid = false;

    while (($buffer = fgets($handle)) !== false) {
        if (strpos($buffer, $valueFind) !== false) {
            $valid = $valueFind;
            break;
        }
    }
    fclose($handle);

    return $valid;
}
