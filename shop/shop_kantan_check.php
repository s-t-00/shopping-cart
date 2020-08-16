<?php
session_start();
// 自動で合言葉を設定
session_regenerate_id(true);
//合言葉を毎回変更
if (isset($_SESSION['member_login']) == false) {
    print 'ログインされていません。<br />';
    print '<a href="shop_list.php">商品一覧へ</a>';
    exit();
}
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title></title>
</head>

<body>

    <?php

    $code=$_SESSION['member_code'];

    //<--1.データベースに接続（PDO）-->
    $dsn = 'mysql:dbname=shop;host=localhost';
    //（dsn = DataSourceName）
    $user = 'root';
    $password = '';
    $dbh = new PDO($dsn, $user, $password);
    //（dbh = DataBase-Handle）
    //（PDO = PHP Data Objects、PHP拡張モジュール、データベースの内容をPHPのオブジェクト(抽象物)のように扱える）
    //PDOクラス(設計図)の作成
    //new演算子の後にクラス名(引数)を記してインスタンス(完成車)を作成し、変数に代入
    $dbh->query('SET NAMES utf8');
    //文字コードをutf-8に
    //１回だけ使用するようなSQL文指令をデータベースに送信する際は、PDOで用意されているquery(問い合わせ)メソッドを実行
    //引数に指定したSQL文をデータベースに対して発行し、PDOStatementオブジェクトを返す
    //（PDOStatementオブジェクトから実際の値を取り出すには、fetch(取ってくる)メソッドを使用）
    //（:: = スコープ(範囲)定義演算子...
    //      クラス(設計図)(static(=静的<=>dynamic)を付ける)のプロパティ(パーツ)・メソッド(動き方)を取り出す）
    //（-> = アロー(矢印)演算子...
    //      インスタンス(完成車)のプロパティ(パーツ)・メソッド(動き方)を取り出す）

    //<<--2.SQL文指令-->>
    $sql = 'SELECT name,email,postal1,postal2,address,tel FROM dat_member WHERE code=?';
    $stmt = $dbh->prepare($sql);
    $data[] = $code;
    $stmt->execute($data);
    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    //$stmtから1レコード取り出す

    //<<--3.データベースから切断-->>
    $dbh = null;

    $onamae = $rec['name'];
    $email = $rec['email'];
    $postal1 = $rec['postal1'];
    $postal2 = $rec['postal2'];
    $address = $rec['address'];
    $tel = $rec['tel'];

        print 'お名前<br/>';
        print $onamae;
        print '<br/><br/>';

        print 'メールアドレス<br/>';
        print $email;
        print '<br/><br/>';

        print '郵便番号<br/>';
        print $postal1;
        print '-';
        print $postal2;
        print '<br/><br/>';

        print '住所<br/>';
        print $address;
        print '<br/><br/>';

        print '電話番号<br/>';
        print $tel;
        print '<br/><br/>';

    print '<form method="post" action="shop_kantan_done.php">';
    print '<input type="hidden" name="onamae" value="' . $onamae . '">';
    print '<input type="hidden" name="email" value="' . $email . '">';
    print '<input type="hidden" name="postal1" value="' . $postal1 . '">';
    print '<input type="hidden" name="postal2" value="' . $postal2 . '">';
    print '<input type="hidden" name="address" value="' . $address . '">';
    print '<input type="hidden" name="tel" value="' . $tel . '">';
    print '<input type="button" onclick="history.back()" value="戻る">';
    print '<input type="submit" value="OK"><br/>';
    //「submit」が、押された瞬間送信するのに対し（無条件で「form」の「action」を実行）
    //「button」は、押した時の処理を自分で記述しない限り送信されない（自分で動作を作成）
    print '</form>';

    ?>


</body>

</html>