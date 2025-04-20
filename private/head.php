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

if ($_SERVER['SERVER_NAME'] === "viewer.familine.minteck.org") {
    header("Location: /f");
    die();
}

require_once $_SERVER['DOCUMENT_ROOT'] . "/private/session.php";
require_once $_SERVER['DOCUMENT_ROOT'] . "/private/space.php";

global $_FULLNAME;
global $_SUID;

$_CONF_URN = $_FULLNAME;
$_CONF_UID = $_SUID;

if (!file_exists($_SERVER['DOCUMENT_ROOT'] . "/private/profiles/" . $_CONF_UID . ".json")) {
    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/private/profiles/" . $_CONF_UID . ".json", file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/private/profiles/_base.json"));
}
$_CONF_USP = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/private/profiles/" . $_CONF_UID . ".json"), true);

if (count($_CONF_USP['strikes']) > 2): ?>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Profil bloqué | Familine Partage</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="/dark.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <link rel="icon" href="/icns/22/application-x-core.svg">
    </head>

    <body style="padding-bottom:50px;">
    <div style="margin-top:50px;text-align:center;" class="container">
        <h1>Votre profil a été bloqué</h1>
    </div>
    <div class="container">
        <p>Bonjour <?= $_CONF_URN ?>,</p>
        <p>Nous sommes au regret de devoir vous annoncer que votre profil Familine Partage, ainsi que tous les documents qui ont été partagés par le biais de ce dernier, ont été définitivement supprimés pour cause d'abus.</p>
        <p>Vous aviez droit à 3 chances pour vous reprendre, mais vous n'en avez pas profité et vous avez continué d'abuser du système, et c'est interdit. 3 réprimandations = 1 sanction, et nous n'offrons pas de déblocage, pour quelque somme que ce soit.</p>
        <p>Ce qu'il va se passer ensuite :
        <ul>
            <li><b>Si il s'agit juste d'une infraction aux règles de Familine Partage,</b> le reste de votre compte Familine reste entièrement utilisable, mais vos documents partagés sur Familine Partage sont supprimés.</li>
            <li><b>Si il s'agit d'un manquement aux lois,</b> des poursuites judiciaires seront effectuées, et votre accès à l'intégralité du réseau de Familine et de Minteck.org a été suspendu définitivement (par exemple : si vous avez un compte Minteck, celui-ci sera supprimé).</li>
        </ul></p>
        <p>Ce que vous pouvez faire :
        <ul>
            <li>Si vous pensez qu'il s'agit d'une erreur, et <b>seulement</b> si vous êtes sûr, vous pouvez <a href="mailto:nekostarfan@gmail.com">contacter le support technique</a> pour qu'il réactive votre profil. Si le motif de votre blocage s'avère être légitime, tout votre compte Familine pourrait être affecté</li>
            <li>Si il ne s'agit pas d'une erreur, vous ne pouvez rien faire. Il vous est <b>strictement interdit</b> d'utiliser le compte de quelqu'un d'autre pour partager vos fichiers</li>
        </ul></p>
        <p>Nous espérons que votre expérience avec Familine Partage aura été des plus plaisantes.</p>
        <p>Cordialement,<br>L'équipe Confiance et Sécurité de Familine</p>
        <?php if (count($_CONF_USP['strikes']) >= 1): ?>
            <hr>
            <h1 style="text-align: center;">Rappel de vos avertissements</h1>
            <ul class="list-group">
                <li class="list-group-item text-info"><?= $_CONF_USP['strikes'][0] ?></li>
                <?php if (count($_CONF_USP['strikes']) >= 2): ?> <li class="list-group-item text-warning"><?= $_CONF_USP['strikes'][1] ?></li> <?php endif; ?>
                <?php if (count($_CONF_USP['strikes']) >= 3): ?> <li class="list-group-item text-danger"><b><?= $_CONF_USP['strikes'][2] ?></b></li> <?php endif; ?>
            </ul>
        <?php endif; ?>
    </div>
    </body>

    </html>
<?php
die();
endif;
?>
<!DOCTYPE html>
<html>

<head>
    <title><?= $_TITLE ?? "Familine Partage" ?> | Familine Partage</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="icon" href="https://familine.minteck.org/icns/familine-share.svg">
    <link rel="stylesheet" href="/dark.css">
    <style>
        :root {
            --primary-color: #6021a3;
            --shadow-color: rgba(94, 0, 255, 0.25);
            --border-color: #b980ff;
            --primary: var(--primary-color);
        }

        .btn-primary, .alert-primary, .bg-primary, .table-primary, .badge-primary {
            background-color: var(--primary-color) !important;
        }

        .border-primary, .btn-primary {
            border-color: var(--primary-color) !important;
        }

        .text-primary, .nav-link, .navbar-brand {
            color: var(--primary-color) !important;
        }

        a:not(.navbar-brand):not(.dropdown-item):not(.btn):not(.nav-link), a:not(.navbar-brand):not(.dropdown-item):not(.btn):not(.nav-link):hover, a:not(.navbar-brand):not(.dropdown-item):not(.btn):not(.nav-link):active, a:not(.navbar-brand):not(.dropdown-item):not(.btn):not(.nav-link):focus {
            color: var(--primary-color) !important;
        }

        a:not(.navbar-brand):not(.dropdown-item):not(.btn):not(.nav-link):hover {
            opacity: .75;
        }

        a:not(.navbar-brand):not(.dropdown-item):not(.btn):not(.nav-link):active, a:not(.navbar-brand):not(.dropdown-item):not(.btn):not(.nav-link):focus {
            opacity: .5;
        }

        .form-control:focus, .btn:focus {
            border-color: var(--border-color) !important;
            box-shadow: 0 0 0 .2rem var(--shadow-color) !important;
        }

        @media (prefers-color-scheme: dark) {
            .nav-link, .navbar-brand {
                color: var(--border-color) !important;
            }
        }
    </style>
</head>

<body>
    <nav class="navbar navbar-expand-md bg-light">

        <a class="navbar-brand" href="/">Familine Partage</a>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="/files/">Mes fichiers</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/usage/">Mon quota</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/strikes/">Mes avertissements <?php

                        if (count($_CONF_USP['strikes']) > 0) {
                            if (count($_CONF_USP['strikes']) > 1) {
                                echo('<span class="badge badge-pill badge-danger">2</span>');
                            } else {
                                echo('<span class="badge badge-pill badge-warning">1</span>');
                            }
                        }

                        ?></a>
                </li>
            </ul>

            <span class="navbar-text" style="margin-left: auto;">
                <?= $_CONF_URN ?> (<?= $_CONF_UID ?>)
            </span>
            <a class="btn btn-primary" href="/share/" style="margin-left:5px;">Partager un fichier</a>
        </div>

    </nav>
