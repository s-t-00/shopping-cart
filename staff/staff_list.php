<?php
session_start();
// 自動で合言葉を設定
session_regenerate_id(true);
//合言葉を毎回変更
if (isset($_SESSION['login']) == false) {
    print 'ログインされていません。<br />';
    print '<a href="../staff_login/staff_login.html">ログイン画面へ</a>';
    exit();
} else {
    print $_SESSION['staff_name'];
    print 'さんログイン中<br />';
    print '<br />';
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>サンプル</title>
</head>

<body>

    <?php

    try {

        //<--1.データベースに接続（PDO）-->
        //staff_add_doneと同じ
        $dsn = 'mysql:dbname=shop;host=localhost';
        $user = 'root';
        $password = '';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->query('SET NAMES utf8');

        //<--2.SQL文指令-->
        $sql = 'SELECT code,name FROM mst_staff WHERE 1';
        //「スタッフの名前を全て取り出せ」
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        //<--3.データベースから切断-->
        $dbh = null;

        print 'スタッフ一覧<br/><br/>';

        print '<form method="post" action="staff_branch.php">';
        //フォームを設置（飛び先は一箇所）
        while (true) {
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            //$stmtから1レコード取り出す
            if ($rec == false) {
                break;
                //もうデータが無ければ、ループから脱出
            }
            print '<input type="radio" name="staffcode" value="' . $rec['code'] . '">';
            //飛び先にスタッフコードを渡すラジオボタンを設置
            //飛び先ページでは$staff_code=$_POST['staffcode'];でvalueが受け取れる
            print $rec['name'];
            print '</br>';
        }
        print '<input type="submit" name="disp" value="参照">';
        print '<input type="submit" name="add" value="追加">';
        print '<input type="submit" name="edit" value="修正">';
        print '<input type="submit" name="delete" value="削除">';
        //postを実行するボタンを設置
        print '</form>';
    } catch (Exception $e) {
        print 'ただいま障害により大変ご迷惑をお掛けしております。';
        exit();
    }

    ?>

    <br />
    <a href="../staff_login/staff_top.php">トップメニューへ</a><br />


</body>

</html>