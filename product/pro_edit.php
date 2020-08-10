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

        $pro_code = $_GET['procode'];
        //入力枠からではない為、サニタイジングは不必要

        //<<--1.データベースに接続（PDO）-->>
        //pro_add_doneと同じ
        $dsn = 'mysql:dbname=shop;host=localhost';
        $user = 'root';
        $password = '';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->query('SET NAMES utf8');

        //<<--2.SQL文指令-->>
        $sql = 'SELECT name,price,image FROM mst_product WHERE code=?';
        //1件のレコードに絞られる為、この後whileループは使わない
        $stmt = $dbh->prepare($sql);
        $data[] = $pro_code;
        $stmt->execute($data);

        $rec = $stmt->fetch(PDO::FETCH_ASSOC);
        //$stmtから1レコード取り出す
        $pro_name = $rec['name'];
        $pro_price = $rec['price'];
        $pro_image_name_old = $rec['image'];

        //<<--3.データベースから切断-->>
        $dbh = null;

        if ($pro_image_name_old == '') {
            $disp_image = '';
        } else {
            $disp_image = '<img src="./image/' . $pro_image_name_old . '">';
            //もし画像があれば、表示するためのHTMLタグを準備
        }
    } catch (Exception $e) {
        print 'ただいま障害により大変ご迷惑をお掛けしております。';
        exit();
    }

    ?>

    商品修正<br />
    <br />
    商品コード<br />
    <?php print $pro_code; ?>
    <br />
    <br />
    <form method="post" action="pro_edit_check.php" enctype="multipart/form-data">
        <input type="hidden" name="code" value="<?php print $pro_code; ?>">
        <input type="hidden" name="image_name_old" value="<?php print $pro_image_name_old; ?>">
        <!-- PHPの変数に入っているものを表示する（これは非表示） -->
        商品名<br />
        <input type="text" name="name" style="width:200px" value="<?php print $pro_name; ?>"><br />
        <!-- 名前は入力済み（valueにセットした値が初期値）（初期化） -->
        価格<br />
        <input type="text" name="price" style="width:50px" value="<?php print $pro_price; ?>">円<br />
        <br />
        <?php print $disp_image; ?>
        <br />
        画像を選んでください。<br />
        <input type="file" name="image" style="width:400px"><br />
        <br />
        <input type="button" onclick="history.back()" value="戻る">
        <input type="submit" value="OK">
    </form>

</body>

</html>