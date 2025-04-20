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

function l($fr, $en = null) {
    if (substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2) === "fr") {
        return $fr;
    } else return $en ?? $fr;
}

function fallback() { ?>

<!DOCTYPE html>
<html>

<head>
    <title><?= l("Erreur", "Error") ?> | Familine <?= l("Partage", "Share") ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="icon" href="/icns/22/application-x-core.svg">
    <link rel="stylesheet" href="/dark.css">
</head>

<body>
    <div style="margin-top:50px;text-align:center;padding-bottom:50px;" class="container">
        <img src="/icns/64/application-x-partial-download.svg" width="64px">
        <h1><?= l("Fichier inconnu", "Unknown file") ?></h1>
        <p><?= l("Nous ne parvenons pas à trouver le fichier, il a peut-être été supprimé ou a expiré. Si vous avez entré le lien par vous même, vérifiez l'ortographe.", "We couldn't find this file, it may have expired or has been deleted. If you entered the link by yourself, please check for spelling mistakes.") ?></p>
    </div>
</body>

</html>

<?php die();
}

if ($_SERVER['SERVER_NAME'] !== "viewer.familine.minteck.org") {
    header("Location: /");
    die();
}

if (isset($_GET['i'])) {
    $id = $_GET['i'];
} else {
    fallback();
}

$selected = null;
$profiles = scandir($_SERVER['DOCUMENT_ROOT'] . "/private/profiles");
foreach ($profiles as $profile) {
    if ($profile !== "." && $profile !== ".." && $profile !== "_base.json") {
        $staging = json_decode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/private/profiles/" . $profile), true);
        foreach ($staging['files'] as $file) {
            if ($file['id'] === $id) {
                $selected = $file;
                $puser = $staging;
            }
        }
    }
}

if ($selected === null) {
    fallback();
} else {
    if ($selected['mime'] === "audio/mpeg") {
        $selected['mime'] = "audio/mp3";
    }
    if ($selected['mime'] === "video/mpeg") {
        $selected['mime'] = "video/mp4";
    }
    if ($selected['mime'] === "image/svg") {
        $selected['mime'] = "image/svg+xml";
    }
    if ($selected['mime'] === "application/x-dosexec") {
        $selected['mime'] = "application/x-ms-dos-executable";
    }
    if ($selected['mime'] === "application/x-mach-binary") {
        $selected['mime'] = "application/x-macbinary";
    }
    $file = $selected;
}

$_SESSION["dlid"] = bin2hex(random_bytes(16)) . bin2hex(random_bytes(16)) . bin2hex(random_bytes(16)) . bin2hex(random_bytes(16));
$_SESSION["pvid"] = bin2hex(random_bytes(16)) . bin2hex(random_bytes(16)) . bin2hex(random_bytes(16)) . bin2hex(random_bytes(16));
$_SESSION['filename'] = $selected['file'];
$_SESSION['name'] = $selected['name'];

?>
<!DOCTYPE html>
<html>

<head>
    <!-- <?= $selected["mime"] ?> -->
    <title><?= $selected['name'] ?> | Familine <?= l("Partage", "Share") ?></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/dark.css">
    <link rel="icon" href="<?php

    $pmime = str_replace("/", "-", $selected['mime']);
    if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/icns/22/" . $pmime . ".svg")) {
        echo("/icns/22/" . $pmime . ".svg");
    } else {
        echo("/icns/22/unknown.svg");
    }

    ?>">
</head>

<style>
    @media (max-width: 700px) {
        #header {
            text-align: center;
            display: block !important;
            grid-template-columns: unset !important;
            font-size: 1.5rem !important;
        }
        #header * {
            font-size: 1.5rem !important;
        }
        #header img {
            width: 64px !important;
        }
        .container > div {
            width: 100% !important;
        }
    }
</style>

<body>
    <div style="color:white;background:#111;padding-bottom:50px;padding-top:50px;">
        <div class="container" id="header" style="display:grid;grid-template-columns: 50% 50%;">
            <div>
                <img src="<?php

                $pmime = str_replace("/", "-", $selected['mime']);
                if (file_exists($_SERVER['DOCUMENT_ROOT'] . "/icns/22/" . $pmime . ".svg")) {
                    echo("/icns/64/" . $pmime . ".svg");
                } else {
                    echo("/icns/64/unknown.svg");
                }

                ?>" width="96px">
                <h1 style="overflow: hidden;text-overflow: ellipsis;" title="<?= strip_tags(str_replace("\"", "''", $selected['name'])) ?>"><?= $selected['name'] ?></h1>
            </div>
        </div>
    </div>
    <div style="margin-top:50px;text-align:center;margin-bottom: 50px;" class="container">
        <p><?= !$selected['anonymous'] ? "<b>" . $selected['author'] . "</b>" : l("Quelqu'un", "Someone") ?> <?php

            if (!$selected['anonymous'] && isset($puser['staff'])) {
                echo('<span title="'.l("Équipe d'administration système de Familine", "Familine system administrators team").'" style="cursor:help;background: none;color: purple;border: 1px solid purple;" class="badge badge-pill badge-primary">STAFF</span> ');
            }

         ?><?= l("vous partage un fichier de type :", "shares with you a file of the following type:") ?> <b><?php

                $done = true;
                switch ($selected['mime']) {
                    case 'directory':
                        $icon = "folder";
                        $pretty = l("Dossier", "Directory");
                        break;
                    case 'text/plain':
                        $icon = "text_snippet";
                        $pretty = l("Fichier texte", "Text file");
                        break;
                    case 'application/octet-stream':
                        $icon = "help_center";
                        $pretty = l("Fichier binaire", "Binary file");
                        break;
                    case 'application/pdf':
                    case 'application/vnd.oasis.opendocument.text':
                    case 'application/rtf':
                    case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                    case 'application/msword':
                    case 'application/x-abiword':
                        $icon = "description";
                        $pretty = l("Document texte", "Text document");
                        break;
                    case 'application/vnd.visio':
                    case 'application/vnd.openxmlformats-officedocument.presentationml.presentation':
                    case 'application/vnd.ms-powerpoint':
                    case 'application/vnd.oasis.opendocument.presentation':
                        $icon = "analytics";
                        $pretty = l("Présentation", "Presentation");
                        break;
                    case 'application/epub+zip':
                    case 'application/vnd.amazon.ebook':
                        $icon = "book";
                        $pretty = l("Livre électronique", "Electronical book");
                        break;
                    case 'text/x-mup':
                    case 'application/zip':
                    case 'application/gzip':
                    case 'application/x-7z-compressed':
                    case 'application/x-tar':
                    case 'application/x-bzip':
                    case 'application/x-bzip2':
                    case 'application/vnd.rar':
                    case 'application/x-freearc':
                        $icon = "archive";
                        $pretty = l("Archive compressée", "Compressed archive");
                        break;
                    case 'application/x-cd-image':
                        $icon = "album";
                        $pretty = l("Image de disque", "Disk image");
                        break;
                    case 'application/x-sh':
                    case 'application/x-cshell':
                        $icon = "request_quote";
                        $pretty = l("Programme d'interpréteur", "Interpreted script");
                        break;
                    case 'font/woff2':
                    case 'font/woff':
                    case 'font/ttf':
                    case 'font/otf':
                    case 'application/vnd.ms-fontobject':
                        $icon = "font_download";
                        $pretty = l("Typographie", "Font");
                        break;
                    case 'application/xhtml+xml':
                    case 'application/xml':
                    case 'text/xml':
                    case 'text/html':
                    case 'application/json':
                    case 'application/ld+json':
                    case 'text/javascript':
                    case 'text/css':
                        $icon = "code";
                        $pretty = l("Code source", "Source code");
                        break;
                    case 'text/calendar':
                        $icon = "event";
                        $pretty = l("Calendrier", "Calendar");
                        break;
                    case 'application/vnd.mozilla.xul+xml':
                    case 'application/x-shockwave-flash':
                    case 'application/x-sharedlib':
                    case 'application/vnd.android.package-archive':
                    case 'application/x-msi':
                    case 'application/x-ms-dos-executable':
                    case 'application/vnd.apple.installer+xml':
                    case 'application/java-archive':
                    case 'application/x-macbinary':
                    case 'application/x-mach-binary':
                        $icon = "open_in_browser";
                        $pretty = l("Exécutable", "Application");
                        break;
                    case 'application/vnd.oasis.opendocument.spreadsheet':
                    case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                    case 'application/vnd.ms-excel':
                    case 'text/csv':
                        $icon = "table_view";
                        $pretty = l("Feuille de calcul", "Spreadsheet");
                        break;
                    case 'application/vnd.oasis.opendocument.graphics':
                        $pretty = l("Composition graphique", "Graphical composition");
                        break;
                    case 'application/ogg':
                        $icon = "headset";
                        $pretty = l("Fichier audio", "Audio file");
                        break;
                    default:
                        $done = false;
                        break;
                }

                if (substr($selected['mime'], 0, 6) == "audio/") {
                    $icon = "headset";
                    $pretty = l("Fichier audio", "Audio file");
                    $done = true;
                }

                if (substr($selected['mime'], 0, 6) == "video/") {
                    $icon = "videocam";
                    $pretty = l("Fichier vidéo", "Video file");
                    $done = true;
                }

                if (substr($selected['mime'], 0, 6) == "image/") {
                    $icon = "insert_photo";
                    $pretty = l("Image", "Picture");
                    $done = true;
                }

                if ($done) {
                    echo($pretty);
                } else {
                    echo(ucwords(implode(" ► ", explode("/", $selected['mime']))));
                }

                ?></b></p>

        <p>
            <a class="btn btn-primary" href="/d/<?= $_SESSION['dlid'] ?>" style="font-size:32px;"><?= l("Télécharger", "Download") ?></a>
        </p>

        <p><?= l("Taille du fichier :", "File size:") ?> <?php

            $size = $selected['size'];

            if ($size > 1000) {
                if ($size > (1000 * 1000)) {
                    echo(round(($size / (1000 * 1000))) . " ". l("Mo", "MB"));
                } else {
                    echo(round(($size / 1000)) . " ". l("Ko", "KB"));
                }
            } else {
                echo($size . " ". l("octets", "bytes"));
            }

            ?><br><?= l("Somme de contrôle MD5 :", "MD5 checksum:") ?> <code><?= md5_file($_SERVER['DOCUMENT_ROOT'] . "/private/shares/" . $selected['file']) ?></code><br><?= l("Expire dans", "Expires in") ?> <?php

            $old = new DateTime($selected['expiration']);
            $new = new DateTime();
            $diff = $new->diff($old, true);

            if ($diff->m > 0) {
                if ($diff->m > 1) {
                    echo($diff->m . " " . l("mois", "months"));
                } else {
                    echo($diff->m . " " . l("mois", "month"));
                }
            } else if ($diff->d > 0) {
                if ($diff->d > 1) {
                    echo($diff->d . " " . l("jours", "days"));
                } else {
                    echo($diff->d . " " . l("jour", "day"));
                }
            } else if ($diff->h > 0) {
                if ($diff->h > 1) {
                    echo($diff->h . " " . l("heures", "hours"));
                } else {
                    echo($diff->h . " " . l("heure", "hour"));
                }
            } else if ($diff->i > 0) {
                if ($diff->i > 1) {
                    echo($diff->i . " " . l("minutes", "minutes"));
                } else {
                    echo($diff->i . " " . l("minute", "minute"));
                }
            } else {
                echo(l("moins d'une minute", "less than a minute"));
            }

            ?></p>

        <hr>
        <?php if (trim($selected['message']) !== ""): ?>
        <b>Description<?= l(" ", "") ?>:</b><br>
            <?= str_replace("\n", "<br>", str_replace(">", "&gt;", str_replace("<", "&lt;", $selected['message']))) ?>
        <hr>
        <?php endif; ?>
        <h3><?= l("Prévisualisation", "Preview") ?></h3>
        <p><?= l("Ayez un aperçu du fichier avant même de le télécharger.", "Get a preview of this file before even downloading it.") ?></p>
        <?php

        $mime = $selected['mime'];
        $nothing = true;
        if (strpos($mime, "audio/") !== false): ?>
            <audio id="instant" controls style="max-width:100%;max-height:100vh;">
                <source src="/p/<?= $_SESSION["pvid"] ?>">
            </audio>
        <?php $nothing = false; endif; if (strpos($mime, "video/") !== false): ?>
            <video id="instant" controls style="max-width:100%;max-height:100vh;">
                <source src="/p/<?= $_SESSION["pvid"] ?>">
            </video>
        <?php $nothing = false; endif; if (strpos($mime, "image/svg") !== false): ?>
            <img id="instant" src="data:image/svg+xml;base64,<?= base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/private/shares/" . $selected['file'])) ?>" style="max-width:100%;max-height:100vh;">
        <?php $nothing = false; endif; if (strpos($mime, "image/") !== false && $nothing): ?>
            <img id="instant" src="/p/<?= $_SESSION["pvid"] ?>" style="max-width:100%;max-height:100vh;">
        <?php $nothing = false; endif; if (strpos($mime, "application/pdf") !== false): ?>
            <iframe id="instant" src="/p/<?= $_SESSION["pvid"] ?>" style="width:100%;height:100vh;"></iframe>
        <?php $nothing = false; endif; if (strpos($mime, "text/html") !== false): ?>
            <iframe id="instant" src="/p/<?= $_SESSION["pvid"] ?>" style="width:100%;height:100vh;"></iframe>
        <?php $nothing = false; endif; if (strpos($mime, "text/xml") !== false): ?>
            <iframe id="instant" src="/p/<?= $_SESSION["pvid"] ?>" style="width:100%;height:100vh;"></iframe>
        <?php $nothing = false; endif; if (strpos($mime, "application/x-executable") !== false || strpos($mime, "application/x-sharedlib") !== false || strpos($mime, "application/x-pie-executable") !== false): ?>
            <div id="instant" style="max-width:100%;max-height:100vh;"><p>
                <b><?= l("Programme Linux", "Linux executable") ?></b>
                <p><?php

                $parts = explode(", ", exec("file -b \"" . $_SERVER['DOCUMENT_ROOT'] . "/private/shares/" . $selected['file'] . "\""));
                foreach ($parts as $part) {
                    echo("<li>{$part}</li>");
                }

                ?></p>
            </p></div>
        <?php $nothing = false; endif; if (strpos($mime, "application/x-dosexec") !== false || strpos($mime, "application/x-ms-dos-executable") !== false): ?>
            <div id="instant" style="max-width:100%;max-height:100vh;"><p>
                <b><?= l("Programme DOS/Windows", "DOS/Windows executable") ?></b>
                <p><?php

                $parts = explode(", ", exec("file -b \"" . $_SERVER['DOCUMENT_ROOT'] . "/private/shares/" . $selected['file'] . "\""));
                foreach ($parts as $part) {
                    echo("<li>{$part}</li>");
                }

                ?></p>
            </p></div>
        <?php $nothing = false; endif; if (strpos($mime, "application/x-mach-binary") !== false || strpos($mime, "application/x-macbinary") !== false): ?>
            <div id="instant" style="max-width:100%;max-height:100vh;"><p>
                <b><?= l("Programme macOS/OpenDarwin", "macOS/OpenDarwin executable") ?></b>
                <p><?php

                $parts = explode(", ", exec("file -b \"" . $_SERVER['DOCUMENT_ROOT'] . "/private/shares/" . $selected['file'] . "\""));
                foreach ($parts as $part) {
                    echo("<li>{$part}</li>");
                }

                ?></p>
            </p></div>
        <?php $nothing = false; endif; if (strpos($mime, "text/") !== false && $nothing): ?>
            <textarea id="instant" disabled style="background:white; color: black;font-family: var(--font-family-monospace) !important;cursor:text;width:100%;height:100vh;"><?php
                $file = file_get_contents($_SERVER['DOCUMENT_ROOT'] . "/private/shares/" . $selected['file']);
                echo(substr($file, 0, 50000));
                if (strlen($file) > 50000) {
                    echo("\n\n**********\n" . l("Fichier tronqué, téléchargez pour récupérer le fichier complet.", "File is truncated, download it to get the whole file."));
                }
            ?></textarea>
        <?php $nothing = false; endif; if ($nothing): ?>
            <i id="instant"><?= l("Prévisualisation indisponible pour ce type de fichier", "Preview not available for this type of file") ?></i>
        <?php endif;

        ?>
    </div>
</body>

</html>