<?php
$_SESSION = array();
//セッション変数（秘密文書）を空にする
if (isset($_COOKIE[session_name()]) == true) {
    setcookie(session_name(), '', time() - 42000, '/');
    // パソコン側のセッションID（合言葉）をクッキーから削除する
}
@session_destroy();
//セッションを破棄

?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<body>

    カートを空にしました。<br />

</body>

</html>