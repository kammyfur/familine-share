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

function fallback() {
    header("Location: /files");
    die();
}

if (isset($_GET['i'])) {
    $id = $_GET['i'];
} else {
    fallback();
}

$selected = null;
foreach ($_CONF_USP['files'] as $file) {
    if ($file['id'] === $_GET['i']) {
        $selected = $file;
    }
}

if ($selected === null) {
    fallback();
} else {
    $file = $selected;
}

$_TITLE = "Supprimer " . $selected['name']; require_once $_SERVER['DOCUMENT_ROOT'] . "/private/head.php";
$_SESSION['csrf_token'] = bin2hex(random_bytes(32));

?>

<div class="container" style="padding-bottom:50px;margin-top: 50px;">
    <div style="text-align:center;">
        <h1>Supprimer « <?= $file['name'] ?> » ?</h1>
        <p>Voulez-vous vraiment supprimer le fichier « <?= $file['name'] ?> » ? Il deviendra innaccessible à toutes les personnes possédant le lien.</p>
        <?php

        $used = allfilessize();
        $total = 200000000;

        $usedm = ($used/1000)/1000;
        $totalm = ($total/1000)/1000;
        $perc = ($used/$total)*100;

        $usedmp = round(($used/1000)/1000, 2);
        $totalmp = round(($total/1000)/1000, 2);
        $percp = round(($used/$total)*100, 2);

        $thisf = ($file['size']/1000)/1000;
        $thisp = (($file['size']/$total)*100);
        $thisfp = round($thisf, 2);
        $thispp = round($thisp, 2);

        ?>
        <div class="progress" style="max-width:50%;margin-left:auto;margin-right:auto;">
            <div class="progress-bar bg-primary" style="width:<?= $perc-$thisp ?>%"></div>
            <div class="progress-bar bg-danger" style="width:<?= $thisp ?>%"></div>
        </div>
        <p>La suppression de ce fichier permettra de récupérer <b><?= $thisfp ?> Mo</b> de stockage.</p>
        <div class="btn-group">
            <a type="button" class="btn btn-dark" href="/files">Annuler</a>
            <a type="button" class="btn btn-danger" href="/delete/confirm/?csrf=<?= $_SESSION['csrf_token'] ?>&i=<?= $_GET['i'] ?>">Supprimer</a>
        </div>
    </div>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/private/foot.php"; ?>