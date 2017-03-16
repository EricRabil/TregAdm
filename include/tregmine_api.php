<?php
function tregmine_online_players() {

    $host = TREGMINE_API_HOST;
    $path = "/playerlist";
    $query = "";

    $signingKey = $path;
    $url = "http://" . $host . $path;
    if ($query) {
        $signingKey .= "?" . $query;
        $url .= "?" . $query;
    }

    $signingKey = base64_encode(hash_hmac("sha1", $signingKey, TREGMINE_API_KEY, true));

    $headers = array("Authorization: " . $signingKey);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($curl);

    $players = array();
    if ($data) {
        $players = json_decode($data, true);
    }

    return $players;
}

function tregmine_kick_player($subjectId, $issuerId, $message) {
    $host = TREGMINE_API_HOST;
    $path = "/playerkick";
    $query = sprintf("subjectId=%d&issuerId=%d&message=%s",
            $subjectId,
            $issuerId,
            urlencode($message));

    $signingKey = $path;
    $url = "http://" . $host . $path;
    if ($query) {
        $signingKey .= "?" . $query;
        $url .= "?" . $query;
    }

    $signingKey = base64_encode(hash_hmac("sha1", $signingKey, TREGMINE_API_KEY, true));
    $headers = array("Authorization: " . $signingKey);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($curl);

    return json_decode($data, true);
}
function tregmine_push_notification($sendTo, $sentFrom, $type){
	$host = TREGMINE_API_HOST;
	$path = "/push";
	$query = sprintf("pushTo=%d&pushFrom=%d&type=%s", $sendTo, $sentFrom, $type);
	    $signingKey = $path;
    $url = "http://" . $host . $path;
    if ($query) {
        $signingKey .= "?" . $query;
        $url .= "?" . $query;
    }

    $signingKey = base64_encode(hash_hmac("sha1", $signingKey, TREGMINE_API_KEY, true));
    $headers = array("Authorization: " . $signingKey);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($curl);

    return json_decode($data, true);
}
function tregmine_auth($id) {
    $host = TREGMINE_API_HOST;
    $path = "/auth";
    $query = sprintf("id=%d", $id);

    $signingKey = $path;
    $url = "http://" . $host . $path;
    if ($query) {
        $signingKey .= "?" . $query;
        $url .= "?" . $query;
    }

    $signingKey = base64_encode(hash_hmac("sha1", $signingKey, TREGMINE_API_KEY, true));

    $headers = array("Authorization: " . $signingKey);

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    $data = curl_exec($curl);

    return json_decode($data, true);
}
