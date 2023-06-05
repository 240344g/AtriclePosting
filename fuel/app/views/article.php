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
    <script src="https://kit.fontawesome.com/e06fe93cc1.js" crossorigin="anonymous"></script>
</head>
<body>
    <?= $header ?>
    <div id="articl_data" data-json='<?php echo $article_data_json; ?>' style="display:none;"></div>
    <div id="root"></div>

    <script src="assets/ArticlePostingApp/src/article.bundle.js"></script>
</body>
</html>