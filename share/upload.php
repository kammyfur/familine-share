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

require_once $_SERVER['DOCUMENT_ROOT'] . "/private/session.php";

$_CONF_URN = $_FULLNAME;
$_CONF_UID = $_SUID;
$_CONF_USP = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/private/profiles/" . $_CONF_UID . ".json"), true);

// Exceed
require_once $_SERVER['DOCUMENT_ROOT'] . "/private/space.php";
if (allfilessize() > 200000000) {
    die("Dépassement de la capacité de stockage maximale");
}

// UUID v4 Function
function uuid($data = null) {
    $data = $data ?? random_bytes(16);
    assert(strlen($data) == 16);

    $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
    $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

    return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
}

// Checks
if (isset($_POST['description'])) {
    $desc = $_POST['description'];
} else {
    die('"description" manquant');
}
if (isset($_POST['filename'])) {
    $name = str_replace(">", "-", str_replace("|", "-", str_replace("/", "-", str_replace("<", "-", str_replace("<", "-", $_POST['filename'])))));
} else {
    die('"filename" manquant');
}
if (isset($_POST['expirity'])) {
    if ($_POST['expirity'] === "1"
        || $_POST['expirity'] === "2"
        || $_POST['expirity'] === "5"
        || $_POST['expirity'] === "10"
        || $_POST['expirity'] === "12"
        || $_POST['expirity'] === "15"
        || $_POST['expirity'] === "18"
        || $_POST['expirity'] === "24"
        || $_POST['expirity'] === "48"
        || $_POST['expirity'] === "72"
        || $_POST['expirity'] === "96"
        || $_POST['expirity'] === "120"
        || $_POST['expirity'] === "144"
        || $_POST['expirity'] === "168"
        || $_POST['expirity'] === "336"
        || $_POST['expirity'] === "504"
        || $_POST['expirity'] === "720"
        || $_POST['expirity'] === "1440"
        || $_POST['expirity'] === "2160"
    ) {
        $hours = (int)$_POST['expirity'];
    } else {
        die('"expirity" invalide');
    }
} else {
    die('"expirity" manquant');
}
if (isset($_POST['anon'])) {
    switch ($_POST['anon']) {
        case "full":
        default:
            $anonymous = false;
            $authorDisplay = $_CONF_URN;
            break;

        case "lastf":
            $anonymous = false;
            $authorDisplay = explode(" ", $_CONF_URN)[0] . " " . substr(explode(" ", $_CONF_URN)[1], 0, 1) . ".";
            break;

        case "firstl":
            $anonymous = false;
            $authorDisplay = explode(" ", $_CONF_URN)[1] . " " . substr(explode(" ", $_CONF_URN)[0], 0, 1) . ".";
            break;

        case "last":
            $anonymous = false;
            $authorDisplay = explode(" ", $_CONF_URN)[0];
            break;

        case "first":
            $anonymous = false;
            $authorDisplay = explode(" ", $_CONF_URN)[1];
            break;

        case "none":
            $anonymous = true;
            $authorDisplay = null;
            break;
    }
} else {
    $anonymous = false;
    $authorDisplay = $_CONF_URN;
}
if (isset($_POST['slug'])) {
    $guessable = true;
} else {
    $guessable = false;
}
if ($_FILES['file']['error'] != "0") {
    die("Le fichier n'a pas été transmis, erreur " . $_FILES['file']['error']);
}

// ID
$sid = bin2hex(random_bytes(16));
if ($guessable) {
    require_once $_SERVER['DOCUMENT_ROOT'] . "/private/naming.php";
    $sid = generateName();
}

// File
$fid = uuid();
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/private/shares/" . $fid, file_get_contents($_FILES['file']['tmp_name']));
unlink($_FILES['file']['tmp_name']);

// Expirity
$date=date_create();
date_add($date,date_interval_create_from_date_string($hours . " hours"));
$expiration = date_format($date,"c");

// Metadata
$arr = [
    "id" => $sid,
    "name" => $name,
    "author" => $authorDisplay,
    "real_author" => $_CONF_URN,
    "anonymous" => $anonymous,
    "message" => $desc,
    "expiration" => $expiration,
    "file" => $fid,
    "mime" => mime_content_type($_SERVER['DOCUMENT_ROOT'] . "/private/shares/" . $fid),
    "size" => filesize($_SERVER['DOCUMENT_ROOT'] . "/private/shares/" . $fid)
];

array_push($_CONF_USP['files'], $arr);

file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/private/profiles/" . $_CONF_UID . ".json", json_encode($_CONF_USP, JSON_PRETTY_PRINT));
die("ok");