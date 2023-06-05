<?php

class Controller_LoginSignIn extends Controller {
    public function before() {
        $session = Session::get();

        if (count($session) !== 0) {
            Session::destroy();
        }        
    }

    // ログインベージ
    public function action_login() {
        // ヘッダーのaタグ
        $header_menu = array(
            "contents" => array(
                "sign_in" => array(
                    "href" => "sign_in",
                    "str" => "新規登録"
                )
            )
        );

        // ヘッダー
        $layout = array(
            "header" => View::forge("header", $header_menu),
            "password_error_message" => "",
        );

        return Response::forge(View::forge("login", $layout));
    }

    // ログインページ（リダイレクト用）
    public function action_login_re() {
        // ヘッダーのaタグ
        $header_menu = array(
            "contents" => array(
                "sign_in" => array(
                    "href" => "sign_in",
                    "str" => "新規登録"
                )
            )
        );

        // ヘッダー
        $layout = array(
            "header" => View::forge("header", $header_menu),
            "password_error_message" => "ユーザネームかパスワードが違います",
        );

        return Response::forge(View::forge("login", $layout));
    }

    // ログインページのフォーム送信時
    public function post_loginCheck() {
        // フォームの内容
        $form = array(
            "user_name" => Input::post("user_name"),
            "password" => Input::post("password")
        );

        // ユーザ情報を取得
        $model_select = new Model_Select();
        $user_data = $model_select->select("*", "user", [
            "name" => $form["user_name"],
            "password" => $form["password"]
        ]);

        // ユーザ情報の個数が1つだけの時ログインする
        if (count($user_data) === 1) {
            // セッション
            Session::start();
            Session::set("user_id", $user_data[0]["id"]);
            Session::set("user_name", $user_data[0]["name"]);
            Session::set("logged_in", true);

            // トップページに飛ぶ
            return Response::redirect("top");
        } else {
            // ログインページ（リダイレクト用）に飛ぶ
            return Response::redirect("login_re");
        }
    }

    // 新規登録ページ
    public function action_sign_in() {
        // ヘッダーのaタグ
        $header_menu = array(
            "contents" => array(
                "login" => array(
                    "href" => "login",
                    "str" => "ログイン"
                )
            )
        );

        // ヘッダー
        $layout = array(
            "header" => View::forge("header", $header_menu),
            "password_error_message" => "",
        );

        return Response::forge(View::forge('sign_in', $layout));
    }

    // 新規登録ページ（リダイレクト用）
    public function action_sign_in_re() {
        // ヘッダーのaタグ
        $header_menu = array(
            "contents" => array(
                "login" => array(
                    "href" => "login",
                    "str" => "ログイン"
                )
            )
        );

        // ヘッダー
        $layout = array(
            "header" => View::forge("header", $header_menu),
            "password_error_message" => "このパスワードは使用されています",
        );

        return Response::forge(View::forge('sign_in', $layout));
    }

    // 新規登録ページのフォーム送信時
    public function post_signInInsert() {
        // フォームの内容
        $form = array(
            "user_name" => Input::post("user_name"),
            "password" => Input::post("password")
        );

        // ユーザ名とパスワードのセットの個数を取得するモデルを呼び出す
        $model_check = new Model_Check();
        $data_num = $model_check->check($form);

        if ($data_num === 0) {
            // ユーザデータをデータベースに挿入するモデルを呼び出す
            $model_insert = new Model_Insert();
            $model_insert->user_data_insert($form);

            return Response::redirect("login");
        } else {
            return Response::redirect("sign_in_re");
        }
    }
}