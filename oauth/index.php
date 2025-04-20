<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Connexion à Familine</title>
    <?= strpos($_SERVER['HTTP_USER_AGENT'], "+Familine/") !== false ? '<script>const $ = require(\'jquery\');jQuery = require(\'jquery\');</script>' : '<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>' ?>
    <link rel="icon" href="/favicon.png">
</head>
<body style="font-family:sans-serif;">
    <span id="msg">Veuillez activer JavaScript sur votre navigateur</span>
    <script>document.getElementById('msg').innerText = "Veuillez patienter...";</script>

    <script>
        if (location.hash.split("&")[0].startsWith("#access_token=")) {
            token = location.hash.split("&")[0].substr(14);
            $.ajax({
                url: "/api/login/",
                dataType: 'text',
                method: 'post',
                data: {
                    session: token
                },
                cache: false,
                success: (data) => {
                    console.info(data);
                    if (data === "ok") {
                        document.getElementById('msg').innerText = "Redirection...";
                        location.href = "/";
                    } else {
                        document.getElementById('msg').innerText = "Erreur, veuillez fermer cette page et réessayer";
                    }
                },
                error: (data) => {
                    console.error(data);
                    document.getElementById('msg').innerText = "Erreur, veuillez fermer cette page et réessayer";
                }
            })
        }
    </script>
</body>
</html>