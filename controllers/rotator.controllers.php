<?php

include '/models/db.model.php';

$rotatorArray = sql($db, "SELECT ProjName, ProjLink, ProjKeyImg, ProjKeyImgUrl, ProjDescShort FROM project_nfo WHERE ProjFeatured = ?", array("1"), "rows");
