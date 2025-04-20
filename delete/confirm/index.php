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

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . "/private/session.php";

$_CONF_URN = $_FULLNAME;
$_CONF_UID = $_SUID;
$_CONF_USP = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/private/profiles/" . $_CONF_UID . ".json"), true);

function fb() {
    if (isset($_GET['i'])) {
        header("Location: /delete/?i=" . $_GET['i']);
        die();
    } else {
        header("Location: /files/");
        die();
    }
}

if (isset($_GET['csrf']) && isset($_SESSION['csrf_token']) && $_GET['csrf'] === $_SESSION['csrf_token']) {
    $selected = null;
    foreach ($_CONF_USP['files'] as $file) {
        if ($file['id'] === $_GET['i']) {
            $selected = $file;
        }
    }

    if ($selected === null) {
        fb();
    } else {
        $file = $selected;
    }
} else {
    fb();
}

unlink("./shares/" . $file['file']);
if (array_search($file, $_CONF_USP['files']) !== false) {
    unset($_CONF_USP['files'][array_search($file, $_CONF_USP['files'])]);
}
file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/private/profiles/" . $_CONF_UID . ".json", json_encode($_CONF_USP, JSON_PRETTY_PRINT));
header("Location: /files/");
die();