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

if (isset($_POST['session'])) {
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL,"https://familine.jetbrains.space/api/http/team-directory/profiles/me");
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Authorization: Bearer ' . $_POST['session']
    ));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_VERBOSE, false);

    $server_output = curl_exec($ch);
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    $data = json_decode($server_output, true);

    if (isset($data["error"])) {
        die("no");
    }

    if ($data["left"] != null) {
        die("no");
    }

    if ($data["leftAt"] != null) {
        die("no");
    }

    if ($data["archived"] != false) {
        die("no");
    }

    if ($data["notAMember"] != false) {
        die("no");
    }

    $token = openssl_random_pseudo_bytes(32);
    $token = bin2hex($token);

    file_put_contents($_SERVER['DOCUMENT_ROOT'] . "/private/tokens/" . str_replace(".", "", str_replace("/", "", $token)) . ".json", json_encode($data));
    $exp = (new DateTime('tomorrow'))->format("U");
    if (isset($_SERVER["HTTP_REFERER"]) && strpos($_SERVER["HTTP_REFERER"], "fl4-network-proxy.alwaysdata.net") !== false) {
        setcookie("FL_SESSION_TOKEN", $token, $exp, "/", "fl4-network-proxy.alwaysdata.net", true, true);
    } else {
        setcookie("FL_SESSION_TOKEN", $token, $exp, "/", "famishare.ddns.net", true, true);
    }

    die("ok");
} else {
    die("no");
}
