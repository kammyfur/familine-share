<?php $_TITLE = "Mon quota"; require_once $_SERVER['DOCUMENT_ROOT'] . "/private/head.php";
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

function bysize($a, $b) {
    return $a["size"] - $b["size"];
}

?>

    <div class="container" style="padding-bottom:50px;margin-top: 50px;">
        <div style="text-align:center;">
            <h1>Utilisation du quota</h1>
            <?php if (count($_CONF_USP['files']) < 1): ?>
                <p>Vous n'avez encore rien partagé. Vous avez droit à 200 Mo gratuitement, alors profitez-en !</p>
                <a class="btn btn-primary" href="/share">Commencer</a>
            <?php else: ?>
            <p>Familine Partage vous donne accès à 200 Mo de stockage total pour tous vos fichiers. Si vous atteignez cette limite, vous ne pourrez plus partager de fichiers tant que vos anciens fichiers n'ont pas expirés ou que vous n'avez pas supprimé des fichiers.</p>
        </div>

        <?php

        $used = allfilessize();
        $total = 200000000;

        $usedm = ($used/1000)/1000;
        $totalm = ($total/1000)/1000;
        $perc = ($used/$total)*100;

        $usedmp = round(($used/1000)/1000, 2);
        $totalmp = round(($total/1000)/1000, 2);
        $percp = round(($used/$total)*100, 2);

        ?>
        <div class="progress">
            <div class="progress-bar bg-primary" style="width:<?= $perc ?>%"><?= "{$usedmp} Mo utilisés sur {$totalmp} Mo ({$percp}%)" ?></div>
        </div>


        <?php

        if ($perc >= 75): ?>
            <p><div class="alert alert-warning">
                <strong>Attention :</strong> Vous utilisez plus de 75% de votre stockage Familine Partage, vous devrez peut-être supprimer des fichiers pour continuer à partager.
            </div></p>
        <?php endif;

        usort($_CONF_USP['files'], "bysize");
        $_CONF_USP['files'] = array_reverse($_CONF_USP['files']);

        ?>

        <p>
            <ul class="list-group">
                <?php foreach ($_CONF_USP['files'] as $file): ?>
                    <li class="list-group-item"><b><?= round($file['size']/(1000*1000), 2) ?> Mo <i>(<?= round(($file['size']/$used)*100, 2) ?> %)</i></b> <?= $file['name'] ?></li>
                <?php endforeach; ?>
            </ul>
        </p>

        <div style="padding-bottom:50px;">
            <?php endif; ?>
        </div>
    </div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/private/foot.php"; ?>