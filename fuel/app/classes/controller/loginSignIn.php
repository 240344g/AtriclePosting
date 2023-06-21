<?php

use Login\CheckUserInfo;
use SignIn\InsertUserInfo;

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
        $user_data = CheckUserInfo::check($form);

        // ユーザ情報が取得できたらログインする
        if (!is_null($user_data)) {
            // セッション
            Session::start();
            Session::set("user_id", $user_data["id"]);
            Session::set("user_name", $user_data["name"]);
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

        // ユーザ名とパスワードのセットが既にあるか確認
        $user_data = CheckUserInfo::check($form);

        // ユーザ情報がなければサインインする
        if (is_null($user_data)) {
            // ユーザデータをデータベースに挿入するモデルを呼び出す
            InsertUserInfo::insert($form);

            return Response::redirect("login");
        } else {
            // 再入力させる
            return Response::redirect("sign_in_re");
        }
    }
}