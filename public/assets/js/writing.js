let form_view_model = {
    // 入力内容
    writing_contents_form_title_area_title: ko.observable(),
    writing_contents_form_explanation_area_explanation: ko.observable(),
    writing_contents_form_body_area_body: ko.observable(),

    // エラーメッセージ
    writing_contents_form_title_area_title_error_message: ko.observable(),
    writing_contents_form_explanation_area_explanation_error_message: ko.observable(),
    writing_contents_form_body_area_body_error_message: ko.observable(),

    // ボタン
    submit_button: ko.observable(false),
    is_post: ko.observable(true),
    is_edit: ko.observable(false)
};

// 入力内容が正しいか
let title_is_correct = false;
let explanation_is_correct = false;
let body_is_correct = false;

// 記事のjsonデータを取得
if (document.getElementById('articl_data') !== null) {
    const article_data_element = document.getElementById('articl_data');
    const article_data_json = article_data_element.getAttribute('data-json');

    // 記事のjsonデータをデコード
    const article_data = JSON.parse(article_data_json);

    // 入力欄に書いておく
    form_view_model.writing_contents_form_title_area_title(article_data.title);
    form_view_model.writing_contents_form_explanation_area_explanation(article_data.explanation);
    form_view_model.writing_contents_form_body_area_body(article_data.body);

    // ボタンを変える
    form_view_model.is_post(false);
    form_view_model.is_edit(true);

    // ボタンを押せるようにする
    title_is_correct = true;
    explanation_is_correct = true;
    body_is_correct = true;
    form_view_model.submit_button(true);
}

// 題名の判定
form_view_model.writing_contents_form_title_area_title.subscribe(() => {
    // 入力された題名
    const title = form_view_model.writing_contents_form_title_area_title();

    // 判定
    if (title.length < 1 || title.length > 25) {
        // 文字数制限
        form_view_model.writing_contents_form_title_area_title_error_message("1〜25文字");
        title_is_correct = false;
    } else {
        form_view_model.writing_contents_form_title_area_title_error_message("");
        title_is_correct = true;
    }

    // ボタンの制御
    if (title_is_correct && explanation_is_correct && body_is_correct) {
        form_view_model.submit_button(true);
    } else {
        form_view_model.submit_button(false);
    }
});

// 説明の判定
form_view_model.writing_contents_form_explanation_area_explanation.subscribe(() => {
    // 入力された説明
    const explanation = form_view_model.writing_contents_form_explanation_area_explanation();

    // 判定
    if (explanation.length < 1 || explanation.length > 75) {
        // 文字数制限
        form_view_model.writing_contents_form_explanation_area_explanation_error_message("1〜75文字");
        explanation_is_correct = false;
    } else {
        form_view_model.writing_contents_form_explanation_area_explanation_error_message("");
        explanation_is_correct = true;
    }

    // ボタンの制御
    if (title_is_correct && explanation_is_correct && body_is_correct) {
        form_view_model.submit_button(true);
    } else {
        form_view_model.submit_button(false);
    }
});

// 記事の判定
form_view_model.writing_contents_form_body_area_body.subscribe(() => {
    // 入力された記事
    const body = form_view_model.writing_contents_form_body_area_body();

    // 判定
    if (body.length < 1 || body.length > 1500) {
        // 文字数制限
        form_view_model.writing_contents_form_body_area_body_error_message("1〜1500文字");
        body_is_correct = false;
    } else {
        form_view_model.writing_contents_form_body_area_body_error_message("");
        body_is_correct = true;
    }

    // ボタンの制御
    if (title_is_correct && explanation_is_correct && body_is_correct) {
        form_view_model.submit_button(true);
    } else {
        form_view_model.submit_button(false);
    }
});

ko.applyBindings(form_view_model);