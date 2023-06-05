<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>記事投稿アプリ -トップ-</title>
    <?= Asset::css("sanitize.css"); ?>
    <?= Asset::css("header.css"); ?>
    <?= Asset::css("root.css"); ?>
</head>
<body>
    <?= $header ?>
    <div id="articl_data" data-json='<?php echo $article_data_json; ?>' style="display:none;"></div>
    <div id="root"></div>

    <script src="assets/ArticlePostingApp/src/top.bundle.js"></script>
</body>
</html>