<?php

checkIfOnline();
checkRank("guardian", "coder", "builder", "junior_admin", "senior_admin");

$do = array_key_exists("do", $_GET) ? $_GET["do"] : "report";

if ($do == "report") {
    if (!array_key_exists("id", $_GET)) {
        header('Location: /index.php');
        exit;
    }

    $id = $_GET["id"];

    $action = $_POST["action"];
    $duration = array_key_exists("duration", $_POST) ? $_POST["duration"] : "";
    $text = $_POST["text"];

    $duration = $duration ? strtotime($duration) : strtotime("+3 days");

    if (!hasRank("junior_admin", "senior_admin")) {
        $action = "comment";
    }

    if ($action == "comment") {
        $duration = null;
    }

    $sql  = "INSERT INTO player_report (subject_id, issuer_id, report_action, "
          . "report_message, report_timestamp, report_validuntil) ";
    $sql .= "VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute(array($id, $_SESSION["id"], $action, $text, time(), $duration));
}
else if ($do == "cancel") {
    checkRank("junior_admin", "senior_admin");

    if (!array_key_exists("reportid", $_GET)) {
        header('Location: /index.php');
        exit;
    }

    $reportId = $_GET["reportid"];

    $sql = "SELECT * FROM player_report WHERE report_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute(array($reportId));

    $report = $stmt->fetch(PDO::FETCH_ASSOC);

    $stmt->closeCursor();

    $type = $report["report_action"] == "ban" ||
            $report["report_action"] == "softwarn" ||
            $report["report_action"] == "hardwarn";

    if (!$report || !$type) {
        header('Location: /index.php');
        exit;
    }

    $id = $report["subject_id"];

    $sql  = "UPDATE player_report SET report_validuntil = null ";
    $sql .= "WHERE report_id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->execute(array($reportId));

    $text = ucfirst($report["report_action"]) . " cancelled.";

    $sql  = "INSERT INTO player_report (subject_id, issuer_id, report_action, "
          . "report_message, report_timestamp, report_validuntil) ";
    $sql .= "VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->execute(array($report["subject_id"], $_SESSION["id"], "comment", $text, time(), null));
}

header('Location: /index.php/player/report?id='.$id);
