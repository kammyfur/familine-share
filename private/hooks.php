<?php
/*
 * MIT License
 *
 * Copyright (c) 2022- Minteck
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

echo("\nLoading all profiles...");
$profiles = scandir("./profiles");
foreach ($profiles as $profile) {
    if ($profile !== "." && $profile !== ".." && $profile !== "_base.json") {
        echo("\nProcessing profile: " . $profile);
        $staging = json_decode(file_get_contents("./profiles/" . $profile), true);
        foreach ($staging['files'] as $index=>$file) {
            echo("\nProcessing file: " . $file['id']);
            $old = new DateTime($file['expiration']);
            $new = new DateTime();
            $oldd = $old->format("U");
            $newd = $new->format("U");
            if (($oldd - $newd) < 1) {
                echo("\nFile " . $file['id'] . " has expired, deleting it");
                unlink("./shares/" . $file['file']);
                if (array_search($file, $staging['files']) !== false) {
                    unset($staging['files'][array_search($file, $staging['files'])]);
                }
            } else {
                echo("\nFile " . $file['id'] . " still has " . ($oldd - $newd) . " seconds remaining before deleting");
            }
        }
        echo("\nSaving...");
        file_put_contents("./profiles/" . $profile, json_encode($staging, JSON_PRETTY_PRINT));
    }
}

$unused = [];

echo("\nCleaning orphan files...");
foreach (scandir("./shares") as $sfile) {
    if ($sfile !== "." && $sfile !== "..") {
        echo("\nProcessing file: " . $sfile);
        $fileIsUsed = false;
        foreach ($profiles as $profile) {
            if ($profile !== "." && $profile !== ".." && $profile !== "_base.json") {
                echo("\nProcessing profile: " . $profile);
                $staging = json_decode(file_get_contents("./profiles/" . $profile), true);
                foreach ($staging['files'] as $index=>$file) {
                    echo("\nProcessing file: " . $file['id']);
                    if (trim($file["file"]) === trim($sfile)) {
                        $fileIsUsed = true;
                    }
                }
            }
        }

        if (!$fileIsUsed) {
            echo("\nNo usage found, marking file as orphan");
            $unused[] = $sfile;
        }
    }
}

echo("\nDeleting " . count($unused) . " orphan file(s)...");
foreach ($unused as $file) {
    echo("\n  -> " . $file);
    unlink("./shares/" . $file);
}

echo("\nDone!\n");