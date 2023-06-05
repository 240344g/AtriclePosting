<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>記事投稿アプリ -ログイン-</title>
    <?= Asset::css("sanitize.css"); ?>
    <?= Asset::css("header.css"); ?>
    <?= Asset::css("login_sign_in.css"); ?>
</head>
<body>
    <?= $header ?>
    <div class="form_area">
        <form action="loginSignIn/loginCheck" method="post">
            <div class="form_user_name_area">
                <label for="user_name">ユーザネーム</label>
                <input id="user_name" name="user_name" type="text" placeholder="4~15文字" data-bind="value: user_name, valueUpdate: 'input'">
                <p class="error_message" data-bind="text: user_name_error_message"></p>
            </div>
            <div>
                <label for="password">パスワード</label>
                <input id="password" name="password" type="password" placeholder="8~15文字" data-bind="value: password, valueUpdate: 'input'">
                <p id="password_error_message" class="error_message" data-bind="text: password_error_message"></p>
            </div>
            <button class="submit_btn shadow" type="submit" data-bind="enable: submit_button, css: {'shadow': submit_button}">ログイン</button>
        </form>
    </div>


    <?php
    if (isset($password_error_message)) {
        $password_error_message_json = json_encode($password_error_message);
    ?>
        <script>
            let password_error_message = <?= $password_error_message_json ?>; 
        </script>
    <?php
    }
    ?>

    <?= Asset::js("knockout-3.5.1.js"); ?>
    <?= Asset::js("login.js"); ?>
</body>
</html>