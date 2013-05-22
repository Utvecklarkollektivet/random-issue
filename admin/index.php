<?php

	require_once "Issue.php";

	if(isset($_POST["submit"])) {
		$id = $_POST["issue_id"];
		$issue = Issue::find($id);
		$issue->close();
	}

	$issue = Issue::getActive();

	if($issue) {
?>

	<h3><?= $issue->title ?></h3>
	<p>
		<?= $issue->text ?>
	</p>

	<form action="index.php" method="post">
		<input type="hidden" name="issue_id" value="<?= $issue->id ?>" />
		<input type="submit" name="submit" value="Close Issue" />
	</form>

<?php
	}
	else {
		echo "No open issues";
	}
?>