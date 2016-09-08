<?php

// TODO: Annotate this code
function projectListModel() {
	include 'db.model.php';

	$projectArray = sql($db, "SELECT ProjName, ProjLink, ProjKeyImg, ProjKeyImgUrl FROM project_nfo;", array(), "rows");

	return $projectArray;
}

function projectDetailModel() {
	include 'db.model.php';

	$p = $_GET['p'];

	$projectDetail = sql($db, "SELECT * FROM project_nfo p JOIN project_img i ON p.PID = i.fk_PID WHERE p.ProjLink = ?", array($p), "rows");

	$pid = $projectDetail[0]['PID'];

	$prevProject = sql($db, "SELECT ProjLink, ProjName FROM project_nfo WHERE PID > ? ORDER BY PID LIMIT 1", array($pid), "prev");
	$nextProject = sql($db, "SELECT ProjLink, ProjName FROM project_nfo WHERE PID > ? ORDER BY PID LIMIT 1", array($pid), "next");

	return array("detail" => $projectDetail, "previous" => $prevProject, "next" => $nextProject);

}

