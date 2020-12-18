## セットアップ手順

1. このリポジトリの master ブランチをチェックアウトする

1. php コンテナのユーザ ID をホスト側と合わせるためのファイル .env を作成する

   1. どこでもよいのでコマンドラインで下記のコマンドを実行する

      ```
      id -u
      ```

   1. docker-compose.yml があるディレクトリで、下記のコマンドの 1000 の値を id -u で調べた値に書き換えて実行する

      ```
      # 1000 の値を id -u で調べた値に書き換えて実行する
      echo DOCKER_UID=1000 > .env
      ```

   - docker-compose.yml があるディレクトリに .env ファイルが作成されたら成功

     ```
     # .env は隠しファイルなので ls -a で視認できる
     ls -a
     .  ..  .env  .git  .gitignore  README.md  docker  docker-compose.yml  html
     ```

   - Linux ではユーザ ID が異なるとコンテナで作成したファイルをホスト側で編集できなくなる
   - Mac はユーザ権限が独特なためユーザ ID を一致させる必要はないとの説もある
   - Windows の人は WSL (Windows Subsystem for Linux) を使おう

1. docker-compose.yml があるディレクトリで下記のコマンドを実行する。初回起動には時間がかかる

   ```
   docker-compose up -d
   ```

   - 下記のようなメッセージが出たら成功

     ```
     Creating network "quelcode-cakephp_default" with the default driver
     Creating quelcode-cakephp_phpmyadmin_1 ... done
     Creating quelcode-cakephp_nginx_1      ... done
     Creating quelcode-cakephp_mysql_1      ... done
     Creating quelcode-cakephp_php_1        ... done
     ```

1. 起動中の php コンテナの bash を実行する

   ```
   docker-compose exec php bash
   ```

   - 下記のようなプロンプトに切り替われば成功

     ```
     docker@df8275e6f1f9:/var/www/html$
     ```

1. php コンテナの bash で cakephp を install する

   1. php コンテナの bash で /var/www/html/mycakeapp に移動する

      ```
      docker@df8275e6f1f9:/var/www/html$ cd mycakeapp
      docker@df8275e6f1f9:/var/www/html/mycakeapp$
      ```

   1. composer install を実行する

      ```
      docker@e6e656dc2f0d:/var/www/html/mycakeapp$ composer install
      ```

      - こちらも時間がかかる。質問プロンプトが出たら Y と回答する

        ```
        Set Folder Permissions ? (Default to Y) [Y,n]? Y
        ```

1. cakephp アプリをブラウザで表示する

   - http://localhost:10380 にアクセスして cakephp の赤いページが表示されたらセットアップ成功
   - このセットアップ手順により CakePHP 超入門 Chapter1 の環境構築作業を飛ばせる

## 備考

- ホスト側で quelcode-cakephp/html 配下のファイルを編集すれば php コンテナに反映される
  - docker のボリュームマウントという仕組みを使っているため
- composer コマンドや bake コマンドを使うときは前述の php コンテナの bash を通じて行う
  - ユーザ id を一致させているためコンテナで生成したファイルをホスト側で編集可能

## 起動中のコンテナの bash を終了する方法

- コンテナの bash で下記のショートカットキーを入力する

  ```
  ctrl + p + q
  ```

  - コンテナの bash で exit コマンドを打つとコンテナ自体が終了してしまう恐れがあるので非推奨

## migration を行う方法

- php コンテナの bash で /var/www/html/mycakeapp に移動して下記のコマンドを実行する

  ```
  docker@e6e656dc2f0d:/var/www/html/mycakeapp$ ./bin/cake migrations migrate
  ```

  - 同様に bake 等も実行可能

## ブラウザで テキストに記載されている url にアクセスする方法

- 下記のように port を指定し、mycakeapp を省略してアクセスする
  - http://localhost/mycakeapp/hello.html ⇒ http://localhost:10380/hello.html
  - http://localhost/mycakeapp/auction/add ⇒ http://localhost:10380/auction/add

## ブラウザで オークションアプリを表示する方法(課題用のブランチにおいて)

- http://localhost:10380/auction にアクセスする
  - http://localhost:10380/users/add からユーザを作成できる
  - clone 直後の master ブランチには存在しない。課題用のブランチにおいて migration を行う必要がある

## ブラウザで phpMyAdmin を表示する方法

- http://localhost:10381 にアクセスする
  - root 権限で操作可能

## nginx のドキュメントルートを変更する方法

- docker/nginx/default.conf を例えば下記のように編集すると、mylaravelapp のウェブルートディレクトリを nginx のドキュメントルートに設定できる

  ```diff
  server {
  - root  /var/www/html/mycakeapp/webroot;
  + root  /var/www/html/mylaravelapp/public;
    index index.php index.html;
    ...
  ```
