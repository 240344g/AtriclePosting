<?php
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
        $model_select = new Model_Select();
        $article_data = $model_select->select("*", "article");

        // 各記事の執筆者名とハート数を取得
        $model_count = new Model_Count();
        for ($i = 0; $i < count($article_data); $i++) {
            // 執筆者名取得
            $user_name = $model_select->select("name", "user", ["id" => $article_data[$i]["user_id"]]);
            $article_data[$i]["user_name"] = $user_name[0]["name"];

            // ハート数取得
            $hearts = $model_count->count_heart($article_data[$i]["id"]);
            $article_data[$i]["hearts"] = $hearts;
        }

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
        $model_select = new Model_Select();
        $my_article_data = $model_select->select("*", "article", ["user_id" => Session::get("user_id")]);

        // ユーザ名の追加と各記事の執筆者名とハート数を取得
        $model_count = new Model_Count();
        for ($i = 0; $i < count($my_article_data); $i++) {
            // 執筆者名情報追加
            $my_article_data[$i]["user_name"] = Session::get("user_name");

            // ハート数取得
            $hearts = $model_count->count_heart($my_article_data[$i]["id"]);
            $my_article_data[$i]["hearts"] = $hearts;
        }

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

        // 同じユーザ名とパスワードのアカウントがないか確認
        $data = [
            "name" => $form["user_name"],
            "password" => $form["password"]
        ];
        $model_select = new Model_Select();
        $user_data = $model_select->select("*", "user", $data);

        if (count($user_data) !== 1) {
            // アップデート
            $model_update = new Model_Update();
            $model_update->update("user", $data, ["id" => Session::get("user_id")]);

            return Response::forge(true);
        } else {
            return Response::forge(false);
        }
    }

    public function get_deleteAccount() {
        $model_delete = new Model_Delete();

        // ユーザが記事に押したハートを削除
        $model_delete->delete("heart", ["user_id" => Session::get("user_id")]);

        // ユーザが書いた記事のIDを取得
        $model_select = new Model_Select();
        $my_article_id = $model_select->select("id", "article", ["user_id" => Session::get("user_id")]);

        // ユーザが書いた記事のハートを削除
        foreach ($my_article_id as $column_value) {
            $model_delete->delete("heart", ["article_id" => $column_value["id"]]);
        }

        // ユーザが書いた記事を削除
        $model_delete->delete("article", ["user_id" => Session::get("user_id")]);

        // アカウント削除
        $model_delete->delete("user", ["id" => Session::get("user_id")]);

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
            Session::set("edit_article_data", $edit_or_delete);

            return Response::redirect("writing");
        } else {
            // 削除する記事のIDを取得
            $article_id = $edit_or_delete["article_id"];

            // 記事に押されたハートを削除
            $model_delete = new Model_Delete();
            $model_delete->delete("heart", ["article_id" => $article_id]);

            // 記事を削除
            $model_delete->delete("article", ["id" => $article_id]);

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
            $model_insert = new Model_Insert();
            $model_insert->insert("article", $article_data);
        } else {
            // 記事のデータを更新
            $model_update = new Model_Update();
            $model_update->update("article", $article_data, ["id" => Input::post("article_id")]);
        }

        return Response::redirect("my_page");
    }

    // 記事ページ
    public function action_article() {
        // 記事のID取得
        $article_id = Session::get("show_article_id");

        // 記事の情報を取得
        $model_select = new Model_Select();
        $article_data = $model_select->select("*", "article", ["id" => $article_id]);

        // 記事の執筆者名を取得
        $user_name = $model_select->select("name", "user", ["id" => $article_data[0]["user_id"]]);
        $article_data[0]["user_name"] = $user_name[0]["name"];

        // 記事のハート情報取得
        $heart = $model_select->select("*", "heart", [
            "user_id" => Session::get("user_id"),
            "article_id" => $article_id
        ]);

        if (count($heart) > 0) {
            $article_data[0]["is_pushed"] = true;
        } else {
            $article_data[0]["is_pushed"] = false;
        }
        
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
        // ハートを追加する記事のID取得
        $article_id = Input::post("param");

        // データベースにハートを追加
        $model_insert = new Model_Insert;
        $model_insert->insert("heart", [
            "user_id" => Session::get("user_id"),
            "article_id" => $article_id
        ]);

        return;
    }

    // 記事のハートを削除
    public function post_subHeart() {
        // ハートを追加する記事のID取得
        $article_id = Input::post("param");

        // データベースにハートを追加
        $model_delete = new Model_Delete;
        $model_delete->delete("heart", [
            "user_id" => Session::get("user_id"),
            "article_id" => $article_id
        ]);

        return;
    }
}