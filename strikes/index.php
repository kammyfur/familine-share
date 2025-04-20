<?php $_TITLE = "Mes avertissements"; require_once $_SERVER['DOCUMENT_ROOT'] . "/private/head.php";
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

?>

    <div class="container" style="padding-bottom:50px;margin-top: 50px;">
        <div style="text-align:center;">
            <h1>Avertissements</h1>
            <?php if (count($_CONF_USP['files']) < 1): ?>
                <p>Vous n'avez encore rien partagé. Vous avez droit à 200 Mo gratuitement, alors profitez-en !</p>
                <a class="btn btn-primary" href="/share">Commencer</a>
            <?php else: ?>
            <p>Vous recevez des avertissements lorsque vous commettez une infraction au règlement de Familine ou aux lois. Vous recevrez par exemple un avertissement si vous utilisez Familine Partage pour partager des programmes malveillants ou des documents illégaux.</p>
            <div style="display:grid;grid-template-columns: 1fr 1fr 1fr;width: 256px;margin-left: auto;margin-right: auto;">
                <div>
                    <img src="/strikes/state0.png" width="64px" style="<?php if (count($_CONF_USP['strikes']) > 0) { echo('filter:grayscale(1);'); } ?>">
                    <?php if (count($_CONF_USP['strikes']) === 0) {echo('<img id="strike-indicator" src="/strikes/indicator.svg" width="24px" style="transform:rotate(-90deg)">');} ?>
                </div>
                <div>
                    <img src="/strikes/state1.png" width="64px" style="<?php if (count($_CONF_USP['strikes']) !== 1) { echo('filter:grayscale(1);'); } ?>">
                    <?php if (count($_CONF_USP['strikes']) === 1) {echo('<img id="strike-indicator" src="/strikes/indicator.svg" width="24px" style="transform:rotate(-90deg)">');} ?>
                </div>
                <div>
                    <img src="/strikes/state2.png" width="64px" style="<?php if (count($_CONF_USP['strikes']) !== 2) { echo('filter:grayscale(1);'); } ?>">
                    <?php if (count($_CONF_USP['strikes']) === 2) {echo('<img id="strike-indicator" src="/strikes/indicator.svg" width="24px" style="transform:rotate(-90deg)">');} ?>
                </div>
            </div>
            <?php endif; ?>
            <hr>
            <?php if (count($_CONF_USP['strikes']) === 0): ?>
            <h1>Vous n'avez <b>aucun avertissement</b></h1>
            <p>C'est parfait ! Vous n'avez jamais partagé de contenu illégal ou interdit par Familine, merci ! Vous utilisez Familine Partage comme il se doit, et c'est très bien. Continuez à rester attentif à ce que vous partagez et pensez à supprimer tout partage qui s'avère être inutile.</p>
            <?php endif; ?>
            <?php if (count($_CONF_USP['strikes']) === 1): ?>
                <h1>Vous avez <b>1 avertissement</b></h1>
                <p>Vous avez droit à l'erreur, c'est normal de se tromper. Cependant, soyez prudent la prochaine fois et évitez d'enfreindre les règles une seconde fois. Vous risquerez d'être sévèrement réprimandé si vous enfreignez de nouveau les conditions de Familine.</p>
            <?php endif; ?>
            <?php if (count($_CONF_USP['strikes']) === 2): ?>
                <h1>Vous avez <b>2 avertissements</b></h1>
                <p>Bon, vous l'avez un peu cherché cette fois. Merci d'arrêter de détourner le fonctionnement de Familine Partage et de l'utiliser correctement et sans enfreindre les lois ou les règles de Familine. Si vous recommencez encore une fois, votre profil Familine Partage sera définitivement désactivé, ainsi que tous les documents que vous avez partagé ; réfléchissez-y donc à deux fois avant de partager quelque chose à présent.</p>
            <?php endif; ?>
            <?php if (count($_CONF_USP['strikes']) >= 1): ?>
            <hr>
            <h1>Les motifs de vos avertissements</h1>
            <ul class="list-group" style="text-align:left;">
                <li class="list-group-item text-info"><?= $_CONF_USP['strikes'][0] ?></li>
                <?php if (count($_CONF_USP['strikes']) >= 2): ?> <li class="list-group-item text-warning"><?= $_CONF_USP['strikes'][1] ?></li> <?php endif; ?>
            </ul>
            <?php endif; ?>
        </div>
    </div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/private/foot.php"; ?>