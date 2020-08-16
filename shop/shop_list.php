<?php
session_start();
// 自動で合言葉を設定
session_regenerate_id(true);
//合言葉を毎回変更
if (isset($_SESSION['member_login']) == false) {
    print 'ようこそゲスト様　';
    print '<a href="member_login.html">会員ログイン</a><br />';
    print '<br />';
} else {
    print 'ようこそ';
    print $_SESSION['member_name'];
    print '様　';
    print '<a href="member_logout.php">ログアウト</a><br />';
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
        //pro_add_doneと同じ
        $dsn = 'mysql:dbname=shop;host=localhost';
        $user = 'root';
        $password = '';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->query('SET NAMES utf8');

        //<--2.SQL文指令-->
        $sql = 'SELECT code,name,price FROM mst_product WHERE 1';
        //「商品の名前を全て取り出せ」
        $stmt = $dbh->prepare($sql);
        $stmt->execute();

        //<--3.データベースから切断-->
        $dbh = null;

        print '商品一覧<br/><br/>';

        while (true) {
            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            //$stmtから1レコード取り出す
            if ($rec == false) {
                break;
                //もうデータが無ければ、ループから脱出
            }
            print '<a href="shop_product.php?procode=' . $rec['code'] . '">';
            //リンクを設置
            print $rec['name'] . '---';
            print $rec['price'] . '円';
            print '</a>';
            print '</br>';
        }

        print '</br>';
        print '<a href="shop_cartlook.php">カートを見る</a><br />';

    } catch (Exception $e) {
        print 'ただいま障害により大変ご迷惑をお掛けしております。';
        exit();
    }

    ?>


</body>

</html>