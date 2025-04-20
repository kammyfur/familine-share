<?php $_TITLE = "Nouveau fichier"; require_once $_SERVER['DOCUMENT_ROOT'] . "/private/head.php"; ?>

    <div class="container" style="padding-bottom:50px;margin-top: 50px;">
        <form method="post">
            <h1 style="text-align:center;">Partager un fichier</h1>
            <p>
                <b>1. </b> Importez votre fichier<br>
                <input type="file" name="file" style="display:none;">
                <input type="hidden" name="filename" value="undefined">
                <button class="btn btn-primary" type="button" onclick="document.getElementsByName('file')[0].click();">Sélectionner</button> &nbsp; <span id="filename">(aucun fichier)</span>
                <div class="progress" style="width:50%;">
                    <div class="progress-bar bg-primary" id="diskUsed" style="width:0;"></div>
                    <div class="progress-bar bg-secondary" id="diskWill" style="width:0;"></div>
                </div>
                <script>
                    used = <?= allfilessize(); ?>;
                    total = 200000000;

                    setInterval(() => {
                        document.getElementById('diskUsed').style.width = ((used/total)*100) + "%";
                        try {
                            current = document.getElementsByName('file')[0].files[0].size;
                            document.getElementById('diskWill').style.width = ((current/total)*100) + "%";
                            if ((((used/total)*100) + ((current/total)*100)) > 100) {
                                $('#ifokay').hide(200);
                                $('#ifnotokay').show(200);
                                document.getElementById('reduceof').innerText = ((current - (total - used))/1000/1000).toFixed(2);
                                document.getElementById('diskWill').classList.remove('bg-secondary');
                                document.getElementById('diskWill').classList.add('bg-danger');
                            } else {
                                $('#ifokay').show(200);
                                $('#ifnotokay').hide(200);
                                document.getElementById('diskWill').classList.add('bg-secondary');
                                document.getElementById('diskWill').classList.remove('bg-danger');
                            }
                        } catch (e) {
                            $('#ifnotokay').hide(200);
                            document.getElementById('diskWill').style.width = "0%";
                            document.getElementById('diskWill').classList.add('bg-secondary');
                            document.getElementById('diskWill').classList.remove('bg-danger');
                        }
                    }, 1000)
                </script>
            </p>
            <div id="ifnotokay" style="display:none;">
                <div class="alert alert-danger">
                    <strong>Erreur :</strong> Il ne vous reste plus assez de place dans votre stockage pour partager ce fichier. Votre fichier doit être de moins de <script>document.write(((total - used)/1000/1000).toFixed(2));</script> Mo, vous devez donc le réduire de <span id="reduceof">rien</span> Mo.
                </div>
            </div>
            <div id="ifokay" style="display:none;">
                <p>
                    <b>2. </b> Choisissez quand votre fichier expire<br>
                    Votre fichier expirera
                    <select name="expirity" onchange="if(document.getElementsByName('expirity')[0].value==='-1'){(document.getElementsByName('announce')[0].checked=true;}">
                        <option value="1">dans 1 heure</option>
                        <option value="2">dans 2 heures</option>
                        <option value="5">dans 5 heures</option>
                        <option value="10">dans 10 heures</option>
                        <option value="12">dans 12 heures</option>
                        <option value="15">dans 15 heures</option>
                        <option value="18">dans 18 heures</option>
                        <option value="24">dans 1 jour</option>
                        <option value="48">dans 2 jours</option>
                        <option value="72">dans 3 jours</option>
                        <option value="96">dans 4 jours</option>
                        <option value="120">dans 5 jours</option>
                        <option value="144">dans 6 jours</option>
                        <option value="168" selected>dans 1 semaine</option>
                        <option value="336">dans 2 semaines</option>
                        <option value="504">dans 3 semaines</option>
                        <option value="720">dans 1 mois</option>
                        <option value="1440">dans 2 mois</option>
                        <option value="2160">dans 3 mois</option>
                    </select>
                    ou si vous le supprimez manuellement.<br>
                </p>
                <p>
                    <b>3. </b> Décrivez votre fichier<br>
                    <input type="checkbox" name="slug" onchange="if(document.getElementsByName('slug')[0].checked){$('#privacynote').modal();}">
                    <label for="slug">Donner une adresse simple à mon fichier</label><br>

                    <textarea rows="4" name="description" placeholder="Entrez une description pour votre fichier, ou laissez vide si vous n'avez rien à dire"></textarea>
                </p>
                <p>
                    <b>4. </b> Sélectionnez le niveau de confidentialité<br>
                    <select name="anon" onchange="if (document.getElementsByName('anon')[0].value==='none'){$('#anonymity').modal();}">
                        <option value="full" selected>Afficher mon nom complet</option>
                        <option value="lastf">Afficher mon nom de famille et la première lettre de mon prénom</option>
                        <option value="last">Afficher mon nom de famille</option>
                        <option value="firstl">Afficher mon prénom et la première lettre de mon nom de famile</option>
                        <option value="first">Afficher mon prénom</option>
                        <option value="none">Ne pas afficher mon nom (non recommendé)</option>
                    </select>
                </p>
                <button class="btn btn-primary" onclick="submitForm()" type="button" id="uploadbtn" disabled>Partager</button>
            </div>
        </form>
    </div>

    <div class="modal fade" id="privacynote">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Note sur la confidentialité</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <p>
                        Malgré que cela rende le partage de votre lien plus facile, utiliser une adresse plus simple expose votre fichier a être trouvé par hasard par une personne malintentionnée testant plusieurs adresses. Préférez donc utiliser cette option uniquement pour les fichiers qui sont destinés à être vus par le public.
                    </p>
                    <p>L'adresse qui vous sera donnée sera constituée d'un adjectif et du nom d'un animal en anglais, par exemple : <code>https://flsh.minteck.org/f/sticky-squirrel-1f45dc</code></p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="document.getElementsByName('slug')[0].checked=false;">Annuler</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal">Compris</button>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="anonymity">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Soyez sur de ce que vous faites !</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                    <p>
                        Par défaut, Familine partage votre nom aux personnes téléchargeant votre fichier afin d'éviter des abus ainsi que la transmission de contenu illégal. Vous comprenez donc qu'il s'agit d'une mesure de sécurité.
                    </p>
                    <p>Familine vérifie parfois les fichiers mis en ligne sous votre nom, mais vérifie systématiquement tous les fichiers que vous publiez sans révéler votre nom. <b>Tout abus <u>QUEL QU'IL SOIT</u> fera immédiatement fermer et de façon irrévocable votre compte Familine et peut mener à des poursuites judiciaires</b>, assurez-vous que le fichier est totalement légal et autorisé par Familine avant de le publier</p>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Je suis sur de ce que je fais</button>
                    <button type="button" class="btn btn-success" data-dismiss="modal" onclick="document.getElementsByName('anon')[0].value='full';">Annuler</button>
                </div>

            </div>
        </div>
    </div>

    <script>
        setInterval(() => {
            document.getElementById('filename').innerText = document.getElementsByName('file')[0].files[0].name;
            document.getElementsByName('filename')[0].value = document.getElementsByName('file')[0].files[0].name;
        }, 1000)
    </script>

    <div class="modal fade" id="progress" data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Partage du fichier</h4>
                </div>

                <div class="modal-body">
                </p>
                    <p>
                        Le fichier est en cours d'envoi vers le serveur. Ne quittez pas cette page tant que l'envoi du fichier n'est pas totalement terminé.
                    </p>
                    <p>
                        <b>État : </b> <span id="upload-status">Initialisation...</span>
                        <div class="progress"><div class="progress-bar progress-bar-striped progress-bar-animated" style="width:100%"></div></div>
                    </p>
                </div>

            </div>
        </div>
    </div>

    <script>

        var progressInterval;
        function submitForm() {
            var filename = $('[name=file]').val();
            if (!filename) return;

            $('#progress').modal();
            document.getElementById('upload-status').innerText = "Traitement en cours...";

            $.ajax({
                url:'upload.php',
                type: 'post',
                data: new FormData($("form")[0]),
                processData: false,
                contentType: false,
                success: function(data) {
                    if (data !== "ok") {
                        document.getElementById('progress').innerHTML = `<div class="modal-dialog">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title">Partage du fichier</h4>
                    <button type="button" class="close" data-dismiss="modal" onclick="location.reload();">&times;</button>
                </div>

                <div class="modal-body">
                    <div class="alert alert-danger">
                        <strong>Erreur : </strong>${data}
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal" onclick="location.reload();">Fermer</button>
                </div>

            </div>
</div>`;
                        document.getElementById('progress').setAttribute('data-keyboard', '');
                        document.getElementById('progress').setAttribute('data-backdrop', 'false');
                    } else {
                        console.log(data);
                        document.getElementById('upload-status').innerText = "Terminé, veuillez patienter...";
                        location.href = "/files/";
                    }
                },
                error:function(err){
                    console.log(err);
                }
            });
        }

        setInterval(() => {
            var filename = $('[name=file]').val();
            if (!filename) {
                document.getElementById('uploadbtn').disabled = true;
            } else {
                document.getElementById('uploadbtn').disabled = false;
            }
        }, 1000)

    </script>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . "/private/foot.php"; ?>