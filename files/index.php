<?php $_TITLE = "Mes fichiers"; require_once $_SERVER['DOCUMENT_ROOT'] . "/private/head.php"; ?>

    <div class="container" style="padding-bottom:50px;margin-top: 50px;">
        <div style="text-align:center;">
            <h1>Mes fichiers partagés</h1>
            <?php if (count($_CONF_USP['files']) < 1): ?>
                <p>Vous n'avez encore rien partagé. Vous avez droit à 200 Mo gratuitement, alors profitez-en !</p>
                <a class="btn btn-primary" href="/share/">Commencer</a>
            <?php else: ?>
            <p>Voici la liste de tous les fichiers partagés qui sont actuellement en circulation. Les fichiers expirés ne sont pas affichés ici et il n'y a aucun moyen de les récupérer.</p>
        </div>

        <table class="table table-striped table-bordered">
            <thead>
            <tr>
                <th>Nom du fichier</th>
                <th>Expiration</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($_CONF_USP['files'] as $file): ?>
                <tr>
                    <td style="vertical-align: middle;"><?= $file['name'] ?></td>
                    <td style="vertical-align: middle;">Dans <?php

                        $old = new DateTime($file['expiration']);
                        $new = new DateTime();
                        $diff = $new->diff($old, true);

                        if ($diff->m > 0) {
                            echo($diff->m . " mois");
                        } else if ($diff->d > 0) {
                            if ($diff->d > 1) {
                                echo($diff->d . " jours");
                            } else {
                                echo($diff->d . " jour");
                            }
                        } else if ($diff->h > 0) {
                            if ($diff->h > 1) {
                                echo($diff->h . " heures");
                            } else {
                                echo($diff->h . " heure");
                            }
                        } else if ($diff->i > 0) {
                            if ($diff->i > 1) {
                                echo($diff->i . " minutes");
                            } else {
                                echo($diff->i . " minute");
                            }
                        } else {
                            echo("moins d'une minute");
                        }

                        ?></td>
                    <td style="vertical-align: middle;">
                        <div class="btn-group">
                            <a target="_blank" href="https://flsh.minteck.org/f/<?= $file['id'] ?>" type="button" class="btn btn-success">Voir</a>
                            <input id="link-<?= $file['id'] ?>" value="https://flsh.minteck.org/f/<?= $file['id'] ?>" type="text" style="opacity: 0;pointer-events: none;position:fixed;">
                            <a onclick="copylink('<?= $file['id'] ?>');" type="button" class="btn btn-primary">Copier</a>
                            <a href="/delete/?i=<?= $file['id'] ?>" type="button" class="btn btn-danger">Supprimer</a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

        <script>
            function copylink(link) {
                var copyText = document.getElementById("link-" + link);

                copyText.select();
                copyText.setSelectionRange(0, 99999);

                document.execCommand("copy");

                alert("Lien copié : " + copyText.value);
            }
        </script>

        <div style="padding-bottom:50px;">
            <?php endif; ?>
        </div>
    </div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/private/foot.php"; ?>
