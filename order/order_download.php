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
    <title></title>
</head>

<body>

    <?php
    require_once('../common/common.php');
    //インクルードする（読み込む）
    ?>

    ダウンロードしたい注文日を選んでください。<br />
    <form method="post" action="order_download_done.php">
        <?php pulldown_year(); ?>
        　年
        <?php pulldown_month(); ?>
        月
        <?php pulldown_day(); ?>
        日<br />
        <br />
        <input type="submit" value="ダウンロードへ">
    </form>

</body>

</html>