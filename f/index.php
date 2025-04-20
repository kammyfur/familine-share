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

if ($_SERVER['SERVER_NAME'] !== "viewer.familine.minteck.org") {
    header("Location: /");
    die();
}

function l($fr, $en = null) {
    if (substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) === "fr") {
        return $fr;
    } else return $en ?? $fr;
}

?>
<!DOCTYPE html>
<html>

<head>
    <title><?= l("Accueil | Familine Partage", "Home | Familine Share") ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</head>

<body>
<div style="margin-top:50px;text-align:center;" class="container">
    <h1><?= l("Bienvenue sur Familine Partage !", "Welcome to Familine Share!") ?></h1>
    <p><?= l("Familine Partage est une plateforme privée", "Familine Share is a private") ?><sup>1</sup><?= l(" de partage de fichiers. Si vous n'avez pas de code pour télécharger un fichier, vous pouvez utiliser votre compte Familine si vous en avez un. Si vous n'avez pas de compte Familine, vous ne pouvez pas utiliser Familine Partage", " file sharing platform. If you don't have the code of a file you want to download, you can use your Familine account if you have one. If you don't have one, you can't use Familine Share"); ?><sup>2</sup>.</p>
    <h2><?= l("Je dispose d'un code", "I have a code") ?></h2>
    <div class="input-group mb-3" style="max-width:550px;margin-left:auto;margin-right:auto;font-size:26px;">
        <input type="text" class="form-control" id="fd" placeholder="<?= l("Code du fichier", "File code") ?>" style="font-size:26px;">
        <div class="input-group-append">
            <button class="btn btn-success" style="font-size:26px;" type="submit" onclick="location.href='/f/'+document.getElementById('fd').value;"><?= l("Continuer", "Continue") ?></button>
        </div>
    </div>
    <style>
        #fd {
            font-family: var(--font-family-monospace) !important;
            font-size: 18px !important;
            padding: 26px .75rem;
        }
        #fd::placeholder {
            font-family: var(--font-family-sans-serif) !important;
            font-size: 26px;
        }
    </style>
    <h2><?= l("Je ne dispose pas d'un code, mais j'ai un compte Familine", "I don't have a code, but I have a Familine account") ?></h2>
    <p><?= l("Si vous avez un compte Familine, vous pouvez partager de nouveaux fichiers et voir les fichiers que vous avez partagés depuis le", "If you have a Familine account, you can share new files and access files you're sharing from the") ?> <a href="https://share.familine.minteck.org"><?= l("tableau de bord Familine Partage", "Familine Share dashboard") ?></a>.</p>
</div>
<div class="container">
    <hr style="width:10%;margin-left:0;margin-top:50px;">
    <small>
        <sup>1</sup><?= l("L'utilisation de la plateforme est réservée aux personnes possédant un compte Familine et ne permet de partager que 200 Mo de fichiers à la fois.", "The use of this platform is reserved to people with a Familine account and can only share 200 MB of files at a time.") ?><br>
        <sup>2</sup><?= l("Pour obtenir un compte Familine, vous devez envoyer une demande de création de compte ", "To get a Familine account, you need to send an account creation request ") ?><a href="https://familine.minteck.org"><?= l("depuis le site officiel de Familine", "from the official Familine website") ?></a>.
    </small>
</div>
</body>

</html>
