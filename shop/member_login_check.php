<?php

require_once('../common/common.php');
//インクルードする（読み込む）

try
{
    //前の画面で入力されたデータ（「form」=>「postメソッド」の中）を$_POST（POSTリクエスト）で取り出し、変数にコピー
    //・GETリクエスト：データがURLにも引き渡される
    //・POSTリクエスト：データがURLには引き渡されない
    //よって、パスワード等を含む場合は「POSTリクエスト」を使用
    $post = sanitize($_POST);
    $member_email = $post['email'];
    $member_pass = $post['pass'];

    $member_pass = md5($member_pass);
    //「md5」はパスワードの暗号化
    //「hidden」typeを使うとしてもソースコードでは見えてしまう


//<--1.データベースに接続（PDO）-->
//staff_add_doneと同じ
$dsn = 'mysql:dbname=shop;host=localhost';
$user = 'root';
$password = '';
$dbh = new PDO($dsn, $user, $password);
$dbh->query('SET NAMES utf8');

//<--2.SQL文指令-->
$sql = 'SELECT code,name FROM dat_member WHERE email=? AND password=?';
//「スタッフの名前とパスワードを取り出せ」
$stmt = $dbh->prepare($sql);
    $data[] = $member_email;
    $data[] = $member_pass;
    $stmt->execute($data);

//<--3.データベースから切断-->
$dbh = null;

    $rec = $stmt->fetch(PDO::FETCH_ASSOC);
    //$stmtから1レコード取り出す
    if($rec==false)
    {
        print'メールアドレスかパスワードが間違っています。<br />';
        print'<a href="member_login.html">戻る</a>';
    }else{
        session_start();
        // 自動で合言葉を設定
        $_SESSION['member_login'] = 1;
        // ログインOKの証拠を残す
        $_SESSION['member_code'] = $rec['code'];
        $_SESSION['member_name'] = $rec['name'];
        header('Location: shop_list.php');
    }

}
catch (Exception $e)
{
    print 'ただいま障害により大変ご迷惑をお掛けしております。';
    exit();
}

?>