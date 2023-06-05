<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>記事投稿アプリ -執筆ページ-</title>
    <?= Asset::css("sanitize.css"); ?>
    <?= Asset::css("header.css"); ?>
    <?= Asset::css("writing.css"); ?>
</head>
<body>
    <?= $header ?>
    <div class="writing_contents">
        <form action="afterLogin/PostArticle" method="post" class="writing_contents_form">
            <div class="writing_contents_form_title_area">
                <label for="writing_contents_form_title_area_title">題名</label>
                <input class="writing_contents_form_title_area_title" id="writing_contents_form_title_area_title" name="writing_contents_form_title_area_title" type="text" placeholder="1~25文字" data-bind="value: writing_contents_form_title_area_title, valueUpdate: 'input'">
                <p class="error_message" data-bind="text: writing_contents_form_title_area_title_error_message">エラーメッセージ</p>
            </div>
            <div class="writing_contents_form_explanation_area">
                <label for="writing_contents_form_explanation_area_explanation">説明</label>
                <textarea class="writing_contents_form_explanation_area_explanation" id="writing_contents_form_explanation_area_explanation" name="writing_contents_form_explanation_area_explanation" type="writing_contents_form_explanation_area_explanation" placeholder="1~75文字" data-bind="value: writing_contents_form_explanation_area_explanation, valueUpdate: 'input'"></textarea>
                <p class="error_message" data-bind="text: writing_contents_form_explanation_area_explanation_error_message">エラーメッセージ</p>
            </div>
            <hr class="writing_contents_form_line">
            <div class="writing_contents_form_body_area">
                <label for="writing_contents_form_body_area_body">記事</label>
                <textarea class="writing_contents_form_body_area_body" id="writing_contents_form_body_area_body" name="writing_contents_form_body_area_body" placeholder="1~1500文字" data-bind="value: writing_contents_form_body_area_body, valueUpdate: 'input'"></textarea>
                <p class="error_message" data-bind="text: writing_contents_form_body_area_body_error_message">エラーメッセージ</p>
            </div>

            <?php
            if (isset($article_data_json)):
            ?>
                <div id="articl_data" data-json='<?php echo $article_data_json; ?>' style="display:none;"></div>
                <button class="submit_btn shadow" type="submit" name="article_id" value=<?= $article_id ?> data-bind="enable: submit_button, css: {'shadow': submit_button}, visible: is_edit">完了</button>
            <?php
            endif
            ?>

            <button class="submit_btn shadow" type="submit" data-bind="enable: submit_button, css: {'shadow': submit_button}, visible: is_post">投稿</button>
        </form>
    </div>

    <?= Asset::js("knockout-3.5.1.js"); ?>
    <?= Asset::js("writing.js"); ?>
</body>
</html>