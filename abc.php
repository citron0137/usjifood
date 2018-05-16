<?php
include "find.php";
$gubsik=find("12.8");

$gubsik = substr(json_encode($gubsik), 1, -1);

echo <<< EOD
    {
        "message": {
            "text": "$gubsik"
        }
    }
EOD;
?>