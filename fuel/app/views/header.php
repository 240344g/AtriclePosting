    <header>
        <h1 class="header_name">記事アプリ</h1>
        <ul class="header_menu">
            <?php foreach ($contents as $item): ?>
                <li class="header_menu_contents"><?= HTML::anchor($item["href"], $item["str"]) ?></li>
            <?php endforeach ?>
        </ul>
    </header>