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

        if (isset($_SESSION['cart']) == true) {
            $cart = $_SESSION['cart'];
            $quantity = $_SESSION['quantity'];
            //保管していたカートの中身を戻す
            $max = count($cart);
        } else {
            $max = 0;
        }

        if ($max == 0) {
            print 'カートに商品が入っていません。<br />';
            print '<br />';
            print '<a href="shop_list.php">商品一覧へ戻る</a>';
            exit();
        }


        //<<--1.データベースに接続（PDO）-->>
        //pro_add_doneと同じ
        $dsn = 'mysql:dbname=shop;host=localhost';
        $user = 'root';
        $password = '';
        $dbh = new PDO($dsn, $user, $password);
        $dbh->query('SET NAMES utf8');

        foreach ($cart as $key => $val) {
            //<<--2.SQL文指令-->>
            $sql = 'SELECT code,name,price,image FROM mst_product WHERE code=?';
            //1件のレコードに絞られる為、この後whileループは使わない
            $stmt = $dbh->prepare($sql);
            $data[0] = $val;
            $stmt->execute($data);

            $rec = $stmt->fetch(PDO::FETCH_ASSOC);
            //$stmtから1レコード取り出す
            $pro_name[] = $rec['name'];
            $pro_price[] = $rec['price'];

            if ($rec['image'] == '') {
                $pro_image[] = '';
            } else {
                $pro_image[] = '<img src="../product/image/' . $rec['image'] . '">';
                //もし画像があれば、表示するためのHTMLタグを準備
            }
        }

        //<<--3.データベースから切断-->>
        $dbh = null;
    } catch (Exception $e) {
        print 'ただいま障害により大変ご迷惑をお掛けしております。';
        exit();
    }

    ?>

    カートの中身<br />
    <br />

    <table border="1">
        <tr>
            <td>商品</td>
            <td>商品画像</td>
            <td>価格</td>
            <td>数量</td>
            <td>小計</td>
            <td>削除</td>
        </tr>

        <form method="post" action="quantity_change.php">
            <?php
            for ($i = 0; $i < $max; $i++) {
            ?>
                <tr>
                    <td><?php print $pro_name[$i]; ?></td>
                    <td><?php print $pro_image[$i]; ?></td>
                    <td><?php print $pro_price[$i]; ?>円</td>
                    <td><input type="text" name="quantity<?php print $i; ?>" value="<?php print $quantity[$i]; ?>"></td>
                    <td><?php print $pro_price[$i] * $quantity[$i]; ?>円</td>
                    <td><input type="checkbox" name="delete<?php print $i; ?>"></td>
                </tr>
            <?php
            }
            ?>
    </table>
    <input type="hidden" name="max" value="<?php print $max; ?>">
    <input type="submit" value="数量変更"><br />
    <input type="button" onclick="history.back()" value="戻る">
    </form>
    <br />
    <a href="shop_form.html">ご購入手続きへ進む</a><br />

    <?php
    if (isset($_SESSION['member_login']) == true) {
        print '<a href="shop_kantan_check.php">会員かんたん注文へ進む</a><br />';
    }
    ?>

</body>

</html>