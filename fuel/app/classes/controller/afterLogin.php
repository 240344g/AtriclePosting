<?php

use Top\GetArticles;
use MyPage\GetMyArticles;
use MyPage\UpdateUserInfo;
use MyPage\DeleteAccount;
use MyPage\DeleteArticle;
use Login\CheckUserInfo;
use Writing\PostArticle;
use Writing\UpdateArticle;
use Article\GetArticleContents;
use Article\CheckHeart;
use Article\AddHeart;
use Article\DeleteHeart;

class Controller_AfterLogin extends Controller {
    public function before() {
        $session = Session::get();

        if (count($session) === 0) {
            Response::redirect("login");
        }
    }

    // トップページ
    public function action_top() {
        // 記事の情報を取得
        $article_data = GetArticles::get();

        // 記事のデータをjsonにする
        $article_data_json = json_encode($article_data);
        
        // ヘッダーのaタグ
        $header_menu = array(
            "contents" => array(
                "my_page" => array(
                    "href" => "my_page",
                    "str" => "マイページ"
                ),
                "post" => array(
                    "href" => "writing",
                    "str" => "投稿する"
                )
            )
        );

        // ヘッダー
        $layout["header"] = View::forge("header", $header_menu);

        // 記事のデータ
        $layout["article_data_json"] = $article_data_json;

        return Response::forge(View::forge("top", $layout));
    }

    // マイページ
    public function action_my_page() {
        // 記事の情報を取得
        $my_article_data = GetMyArticles::get(Session::get("user_id"));

        // 記事のデータをjsonにする
        $my_article_data_json = json_encode($my_article_data);

        // ヘッダーのaタグ
        $header_menu = array(
            "contents" => array(
                "top" => array(
                    "href" => "top",
                    "str" => "トップページ"
                ),
                "post" => array(
                    "href" => "writing",
                    "str" => "投稿する"
                )
            )
        );

        // ヘッダー
        $layout["header"] = View::forge("header", $header_menu);

        // 記事のデータ
        $layout["my_article_data_json"] = $my_article_data_json;

        // ユーザ名
        $layout["user_name"] = Session::get("user_name");

        return Response::forge(View::forge("my_page", $layout));
    }

    // マイページでユーザ情報を変更したとき
    public function post_updateMyData() {
        // フォームの内容取得
        $form_json = Input::post("param");
        $form = json_decode($form_json, true);

        // // 同じユーザ名とパスワードのアカウントがないか確認
        $user_data = CheckUserInfo::check($form);

        // // ユーザ情報がなければアップデートする
        if (is_null($user_data)) {
            UpdateUserInfo::update($form, Session::get("user_id"));

            return Response::forge(true);
        } else {
            return Response::forge(false);
        }
    }

    // アカウントを削除
    public function get_deleteAccount() {
        // ユーザが書いた記事を取得
        $my_articles = GetMyArticles::get(Session::get("user_id"));

        // ユーザが書いた記事を削除
        foreach ($my_articles as $column_value) {
            DeleteArticle::delete($column_value["id"]);
        }

        // アカウント削除
        DeleteAccount::delete(Session::get("user_id"));

        // セッション破棄
        Session::destroy();

        return;
    }

    // 記事を編集か削除するメソッド
    public function post_EditOrDeleteMyArticle() {
        // 編集か削除かを取得
        $edit_or_delete_json = Input::post("edit_or_delete");
        $edit_or_delete = json_decode($edit_or_delete_json, true);

        if ($edit_or_delete["order"] === "edit") {
            // 執筆ページで編集する
            Session::set("edit_article_data", $edit_or_delete);

            return Response::redirect("writing");
        } else {
            // 削除する記事のIDを取得
            $article_id = $edit_or_delete["article_id"];

            // 記事を削除
            DeleteArticle::delete($article_id);

            return Response::redirect("my_page");
        }
    }

    // 執筆ページ
    public function action_writing() {
        // ヘッダーのaタグ
        $header_menu = array(
            "contents" => array(
                "my_page" => array(
                    "href" => "my_page",
                    "str" => "マイページ"
                ),
                "top" => array(
                    "href" => "top",
                    "str" => "トップページ"
                ),
            )
        );

        // ヘッダー
        $layout["header"] = View::forge("header", $header_menu);

        // 記事の編集からきた場合
        if (Session::get("edit_article_data") !== null) {
            // 記事の情報を取得
            $article_data = Session::get("edit_article_data");

            // 記事のセッションを削除
            Session::delete("edit_article_data");

            // jsonに変換
            $article_data_json = json_encode($article_data);

            $layout["article_data_json"] = $article_data_json;
            $layout["article_id"] = $article_data["article_id"];
        }

        return Response::forge(View::forge("writing", $layout));
    }

    // 記事を投稿か編集
    public function post_PostArticle() {
        // 記事の情報
        $article_data = array(
            "title" => Input::post("writing_contents_form_title_area_title"),
            "explanation" => Input::post("writing_contents_form_explanation_area_explanation"),
            "body" => Input::post("writing_contents_form_body_area_body"),
            "date" => Date::time()->format('mysql_date'),
            "user_id" => Session::get("user_id")
        );

        if (Input::post("article_id") === null) {
            // 記事ををデータベースに追加
            PostArticle::insert($article_data);
        } else {
            // 記事のデータを更新
            UpdateArticle::update($article_data, Input::post("article_id"));
        }

        return Response::redirect("my_page");
    }

    // 記事ページ
    public function action_article() {
        // 記事のID取得
        $article_id = Session::get("show_article_id");

        // 記事の情報を取得
        $article_data = GetArticleContents::get($article_id);

        // 閲覧する記事に既にハートを押したかの確認
        $article_data[0]["is_pushed"] = CheckHeart::check(Session::get("user_id"), $article_id);
        
        // ヘッダーのaタグ
        $header_menu = array(
            "contents" => array(
                "my_page" => array(
                    "href" => "my_page",
                    "str" => "マイページ"
                ),
                "top" => array(
                    "href" => "top",
                    "str" => "トップページ"
                ),
            )
        );

        // ヘッダー
        $layout["header"] = View::forge("header", $header_menu);

        // 記事のデータ
        $layout["article_data_json"] = json_encode($article_data[0]);

        return Response::forge(View::forge("article", $layout));
    }

    // 記事を開く処理
    public function post_OpenArticle() {
        // 記事のID取得
        $article_id = Input::post("article_id");

        // // セッションに記事のIDをセット
        Session::set("show_article_id", $article_id);

        return Response::redirect("article");
    }

    // 記事のハートを追加
    public function post_addHeart() {
        // 追加するハートのデータ
        $heart_info = array(
            "user_id" => Session::get("user_id"),
            "article_id" => Input::post("param")
        );

        // データベースにハートを追加
        AddHeart::add($heart_info);

        return;
    }

    // 記事のハートを削除
    public function post_subHeart() {
        // ハートを削除
        DeleteHeart::delete(Session::get("user_id"), Input::post("param"));

        return;
    }
}