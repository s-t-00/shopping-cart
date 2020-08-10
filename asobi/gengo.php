<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title></title>
</head>
<body>

<?php

require_once('../common/common.php');
//インクルードする（読み込む）

$seireki = $_POST['seireki'];

$wareki=gengo($seireki);
print $wareki;

?>

</body>
</html>