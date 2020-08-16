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

    $post = sanitize($_POST);

    //前の画面で入力されたデータ（「form」=>「postメソッド」の中）を$_POST（POSTリクエスト）で取り出し、変数にコピー
    //・GETリクエスト：データがURLにも引き渡される
    //・POSTリクエスト：データがURLには引き渡されない
    //よって、パスワード等を含む場合は「POSTリクエスト」を使用
    $onamae = $post['onamae'];
    $email = $post['email'];
    $postal1 = $post['postal1'];
    $postal2 = $post['postal2'];
    $address = $post['address'];
    $tel = $post['tel'];
    $chumon = $post['chumon'];
    $pass = $post['pass'];
    $pass2 = $post['pass2'];
    $sex = $post['sex'];
    $birth = $post['birth'];

    $okflg=true;

    if ($onamae == '') {
        print 'お名前が入力されていません。<br/><br/>';
        $okflg = false;

    }else{
        print 'お名前<br/>';
        print $onamae;
        print '<br/><br/>';
    }

    // if (preg_match('/^[¥w¥-¥.]+¥@[¥w¥-¥.]+¥.([a-z]+)$/', $email) == 0) {
    if (preg_match('/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/', $email) == 0) {
        //preg_match => 正なら１，誤なら０を返す
        //perl互換の正規表現（regex）
        print 'メールアドレスを正確に入力してください。<br/><br/>';
        $okflg = false;
    } else {
        print 'メールアドレス<br/>';
        print $email;
        print '<br/><br/>';
    }

    if (preg_match('/^[0-9]+$/', $postal1) == 0) {
        //もし半角数字じゃなかったら
        //preg_match => 正なら１，誤なら０を返す
        //perl互換の正規表現（regex）
        print '郵便番号は半角数字で入力してください。<br/><br/>';
        $okflg = false;
    } else {
        print '郵便番号<br/>';
        print $postal1;
        print '-';
        print $postal2;
        print '<br/><br/>';
    }

    if (preg_match('/^[0-9]+$/', $postal2) == 0) {
        print '郵便番号は半角数字で入力してください。<br/><br/>';
        $okflg = false;
    }

    if ($address == '') {
        print '住所が入力されていません。<br/><br/>';
        $okflg = false;
    } else {
        print '住所<br/>';
        print $address;
        print '<br/><br/>';
    }


    if (preg_match('/^\d{2,5}-?\d{2,5}-?\d{4,5}$/', $tel) == 0) {
        print '電話番号は半角数字で入力してください。<br/><br/>';
        $okflg = false;
    } else {
        print '電話番号<br/>';
        print $tel;
        print '<br/><br/>';
    }

    if ($chumon=='chumontouroku') {
        if ($pass == '') {
            print 'パスワードが入力されていません。<br/><br/>';
            $okflg = false;
        }

        if ($pass != $pass2) {
            print 'パスワードが一致しません。<br/><br/>';
            $okflg = false;
        }

        print '性別<br/>';
        if ($sex == 'male') {
            print '男性';
        }
        else {
            print '女性';
        }
        print '<br/><br/>';

        print '生まれ年<br/>';
        print $birth;
        print '年代';
        print '<br/><br/>';

    }

    if($okflg == true){
        print '<form method="post" action="shop_form_done.php">';
        print '<input type="hidden" name="onamae" value="' . $onamae . '">';
        print '<input type="hidden" name="email" value="' . $email . '">';
        print '<input type="hidden" name="postal1" value="' . $postal1 . '">';
        print '<input type="hidden" name="postal2" value="' . $postal2 . '">';
        print '<input type="hidden" name="address" value="' . $address . '">';
        print '<input type="hidden" name="tel" value="' . $tel . '">';
        print '<input type="hidden" name="chumon" value="' . $chumon . '">';
        print '<input type="hidden" name="pass" value="' . $pass . '">';
        print '<input type="hidden" name="sex" value="' . $sex . '">';
        print '<input type="hidden" name="birth" value="' . $birth . '">';
        print '<input type="button" onclick="history.back()" value="戻る">';
        print '<input type="submit" value="OK"><br/>';
        //「submit」が、押された瞬間送信するのに対し（無条件で「form」の「action」を実行）
        //「button」は、押した時の処理を自分で記述しない限り送信されない（自分で動作を作成）
        print '</form>';
    }else{
        print '<form>';
        print '<input type="button" onclick="history.back()" value="戻る">';
        print '</form>';
    }

    ?>


</body>

</html>