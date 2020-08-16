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

    require_once('../common/common.php');
    //インクルードする（読み込む）

    $post = sanitize($_POST);

    //「try-catch」構文、データベースサーバーの障害対策、エラートラップ
    //通常時はtryのコードが実行され、エラーがなければcatch(err)は無視される
    //データベースサーバーにエラーが発生した場合、tryの実行が停止し、catch(err)へ
    try {

        $pro_code = $post['code'];
        $pro_name = $post['name'];
        $pro_price = $post['price'];
        $pro_image_name_old = $post['image_name_old'];
        $pro_image_name = $post['image_name'];

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

        //<--2.SQL文指令-->
        $sql = 'UPDATE mst_product SET name=?,price=?,image=? WHERE code=?';
        $stmt = $dbh->prepare($sql);
        //文を実行する準備を行い、文オブジェクトを返す
        $data[] = $pro_name;
        $data[] = $pro_price;
        $data[] = $pro_image_name;
        $data[] = $pro_code;
        $stmt->execute($data);
        //準備したプリペアドステートメントを実行

        //<--3.データベースから切断-->
        $dbh = null;

        if ($pro_image_name_old != $pro_image_name) {
            if ($pro_image_name_old != '') {
                unlink('./image/' . $pro_image_name_old);
                //古い画像があれば削除
            }
        }

        print '修正しました。<br/>';
    } catch (Exception $e) {
        print 'ただいま障害により大変ご迷惑をお掛けしております。';
        exit();
    }

    ?>

    <a href="pro_list.php"> 戻る </a>

</body>

</html>