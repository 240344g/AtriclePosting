let form_view_model = {
    // 入力内容
    user_name: ko.observable(),
    password: ko.observable(),

    // エラーメッセージ
    user_name_error_message: ko.observable(),
    password_error_message: ko.observable(password_error_message),

    // ボタン
    submit_button: ko.observable(false)
};

// ユーザネームとパスワードが正しいか
let user_name_is_correct = false;
let password_is_correct = false;

// ユーザネームの判定
form_view_model.user_name.subscribe(() => {
    // 入力されたユーザネーム
    const user_name = form_view_model.user_name();

    // 正規表現
    const user_name_regex = /^[ぁ-んァ-ヶ一-龠0-9a-zA-Z-_ー]*$/;

    // 判定
    if (!user_name_regex.test(user_name)) {
        // 文字制限
        form_view_model.user_name_error_message("英数字、ひらがな、カタカナ、漢字のみ");
        user_name_is_correct = false;
    } else if (user_name.length < 4 || user_name.length > 15) {
        // 文字数制限
        form_view_model.user_name_error_message("4〜15文字");
        user_name_is_correct = false;
    } else {
        form_view_model.user_name_error_message("");
        user_name_is_correct = true;
    }

    // ボタンの制御
    if (user_name_is_correct && password_is_correct) {
        form_view_model.submit_button(true);
    } else {
        form_view_model.submit_button(false);
    }
});

// パスワードの判定
form_view_model.password.subscribe(() => {
    // 入力されたパスワード
    const password = form_view_model.password();

    // 正規表現
    const password_regex = /^[0-9a-zA-Z]*$/;

    // 判定
    if (!password_regex.test(password)) {
        // 文字制限
        form_view_model.password_error_message("英数字のみ");
        password_is_correct = false;
    } else if (password.length < 8 || password.length > 15) {
        // 文字数制限
        form_view_model.password_error_message("8〜15文字");
        password_is_correct = false;
    } else {
        form_view_model.password_error_message("");
        password_is_correct = true;
    }

    // ボタンの制御
    if (user_name_is_correct && password_is_correct) {
        form_view_model.submit_button(true);
    } else {
        form_view_model.submit_button(false);
    }
});

ko.applyBindings(form_view_model);