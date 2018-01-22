<?php
##################################################
# ja
##################################################

$lang=array(

##################################################
# ./core/auto_dropzone.php
##################################################
     "Drop your files here or click to select a local file" => "ファイルをここにドロップするか、ここをクリックしてローカルファイルを選択してください。",
     "Error, max filelength:" => "エラー：ファイルが大きすぎます。",
     ": Error, forbidden file format !" => "エラー：不正なファイルフォーマットです。",
#     "The file to big for the server\'s config" => "",
#     "The file to big for this page" => "",
#     "There was a problem during upload (file was truncated)" => "",
#     "No file upload" => "",
#     "No temp folder" => "",
#     "Write error on server" => "",
#     "The file doesn\'t fit" => "",
     "Upload error" => "アップロードエラー",

##################################################
# ./core/auto_restrict.php
##################################################
     "Account created:" => "アカウントが作成されました：",
     "New password saved for " => "新しいパスワードが保存されました：",
     "Error saving new password for " => "新しいパスワードの保存に失敗しました：",
     "Changes saved" => "変更を保存しました",

##################################################
# ./core/commands_GET_vars.php
##################################################
#     "Rss feed of stats" => "",

##################################################
# ./core/config_form_help.php
##################################################
     "The language used by default" => "デフォルトの言語",
#     " " => "",
     "The way Bozon displays the files by default" => "デフォルトのファイル表示方法",
     "The mode by default: links or view" => "デフォルトのモード：links または view",
     "in pixels" => "ピクセルで指定",
     "Displays the back button and the . and .. options" => "'戻る'ボタンおよび'.'と'..'を表示する",
#     "The maximum entries in the stat page" => "",
#     "The maximum entries in stat file" => "",
#     "How much files bozon displays before the «load more» button" => "",
#     "Allow Bozon to calculate the folders\'size (disable in case of slow down with a lot of files)" => "",
#     "Visitor can access to RSS feed" => "",
#     "Visitor can access to JSON feed" => "",
#     "Visitor can access to download" => "",
#     "When the user clicks on the file, download it instead of open" => "",
#     "Updates and checks the ID base on every refresh. Disable if you see a slowdown" => "",
#     "Allow the upload of unknown files types" => "",
#     "Use lightbox or open pictures in a new tab" => "",
#     "When you click on renew id for a shared file, this file is no longer shared." => "",
     "List of files to open directly in your browser (separate with commas)" => "直接ブラウザで開くファイルの一覧（カンマ区切り）",
     "List of files to display as a text file (separate with commas)" => "テキストファイルとして表示するファイルの一覧（カンマ区切り）",

##################################################
# ./core/core.php
##################################################
#     "Private folder is not writable" => "",
#     "Private folder is not readable" => "",
#     "Temp folder is not writable" => "",
#     "Temp folder is not readable" => "",
#     "Problem accessing tree folder: not readable" => "",
#     "Problem accessing tree/folder file: not writable" => "",
#     "Problem accessing " => "",
#     ": folder not readable" => "",
#     ": folder not writable" => "",
#     "is not installed on this server" => "",
#     "More info" => "",
#     "Problem accessing ID file: not readable" => "",
#     "Problem accessing ID file: not writable" => "",
#     "Problem accessing stats file: not readable" => "",
#     "Problem accessing stats file: not writable" => "",
     "Logout" => "ログアウト",
     "Connection" => "接続",
     "See as icon" => "アイコン表示",
     "See as file list" => "リスト表示",
     "Manage files" => "ファイル管理",
     "Manage links" => "リンク管理",
#     "Deleted" => "",
     "free" => "空き",
     "Yes" => "はい",
     "No" => "いいえ",
#     "text" => "",

##################################################
# ./core/GET_POST_admin_data.php
##################################################
#     "is not writable" => "",
     "created" => "が作成されました。",
#     "Problem accessing remote file." => "",
#     "moved to" => "",
#     "Changes saved" => "",

##################################################
# ./core/listfiles.php
##################################################
     "The user can access this only one time" => "このファイルに一度だけアクセス可能",
     "The user can access this only with the password" => "このファイルにアクセスするにはパスワードが必要",
#     "View this share" => "",
     "View this file" => "このファイルを参照する",
     "Edit this file" => "このファイルを編集する",
     "Share this item with another user" => "他のユーザーと共有する",
     "Convert this zip file to folder" => "このZIPファイルをフォルダに変換する",
     "Check all" => "すべて選択",
     "Filename" => "ファイル名",
     "Filesize" => "サイズ",
     "Filetype" => "形式",
     "Foldersize" => "フォルダ サイズ",
#     "Load" => "",
#     "more" => "",
     "No file or folder" => "ファイルやフォルダがありません",

##################################################
# ./core/share.php
##################################################
     "This share is protected, please type the correct password:" => "この共有はロックされています。正しいパスワードを入力してください。",
#     "This page in" => "",
#     "Download a zip from this folder" => "",
     "This link is no longer available, sorry." => "申し訳ありません。このリンクは利用できません。",
#     "Rss feed of " => "",

##################################################
# ./core/templates.php
##################################################
     "Delete this file" => "このファイルを削除する",
     "Get the share link" => "共有リンクを表示する",
     "Get the qrcode of this link" => "QRコードを表示する",
     "Rename this file (share link will not change)" => "ファイル名を変更する（共有リンクは変更されません）",
     "Put a password on this share" => "共有パスワードを設定する",
     "Turn this share into a burn after access share" => "バーンモードで共有する",
     "Regen the share link" => "共有リンクを再生成する",
     "Download a zip from this folder" => "このフォルダをZIPでダウンロードする",
     "Move file or folder" => "ファイルまたはフォルダを移動する",
#     "Move to" => "",
     "Move" => "移動元",
     "To" => "移動先",
     "Lock access" => "アクセスをロックする",
     "Please give a password to lock access to this file" => "このファイルをロックするパスワードを入力してください。",
     "Rename this file?" => "このファイルの名前を変更しますか？",
     "Rename this item?" => "この項目の名前を変更しますか？",
     "Rename" => "名前を変更",
     "Delete this item?" => "この項目を削除しますか？",
     "Delete" => "削除",
     "Share item" => "項目を共有",
     "Share link" => "リンクを共有",
#     "Select the users you want to share with" => "",
     "Copy this share link" => "この共有リンクをコピーしてください",
#     "Yes" => "",
     "Move this file to another directory" => "このファイルをほかのフォルダに移動する",
     "Create a subfolder" => "サブフォルダを作成する",
     "Create a subfolder in this folder" => "このフォルダにサブフォルダを作成する",
     "New folder" => "新規フォルダ",
     "Paste a file's URL" => "URLを貼り付け",
     "Paste a file's URL to get it on this server" => "このサーバに取り込むURLを貼り付け",
#     "Read m3u playlist" => "",
#     "Force local filename (leave empty=no change)" => "",
#     "filename (optionnal)" => "",

##################################################
# ./index.php
##################################################
#     "Click to remove" => "",

##################################################
# ./templates/default/admin.php
##################################################
     "Choose a folder" => "フォルダを選択",
     "Root:" => "ルート：",
#     "Filter:" => "",
     "Create a subfolder in this folder" => "このフォルダにサブフォルダを作成する",
     "Paste a file\'s URL to get it on this server" => "このサーバに取り込むURLを貼り付け",
     "Delete selected items" => "選択済みの項目を削除する",
     "Zip and download selected items" => "選択済みの項目をZIPでダウンロードする",

##################################################
# ./templates/default/editor.php
##################################################
     "Path:" => "パス：",
     "Write" => "編集",
     "See" => "表示",
     "Help" => "ヘルプ",
     "Filename" => "ファイル名",
     "Save" => "保存",
    "markdown_help" => "# Title  1
		## Title  2
		### Title  3
		#### Title  4
		##### Title  5
		###### Title  6

		*italic* or _italic_
		**bold** or __bold__
		**_bold italic_**
		~~strike~~

		1. First ordered list item
		2. Another item
		⋅⋅* Unordered sub-list. 
		1. Actual numbers doesn't matter, just that it's a number
		⋅⋅1. Ordered sub-list
		4. And another item.
		⋅⋅⋅You can have properly indented paragraphs within list items. Notice the blank line above, and the leading spaces (at least one, but we'll use three here to also align the raw Markdown).

		⋅⋅⋅To have a line break without a paragraph, you will need to use two trailing spaces.⋅⋅
		⋅⋅⋅Note that this line is separate, but within the same paragraph.⋅⋅
		⋅⋅⋅(This is contrary to the typical GFM line break behaviour, where trailing spaces are not required.)

		* Unordered list can use asterisks
		- Or minuses
		+ Or pluses

		Links
		[I'm an inline-style link](https://www.google.com)

		[I'm an inline-style link with title](https://www.google.com 'Google's Homepage')

		[I'm a reference-style link][Arbitrary case-insensitive reference text]

		[I'm a relative reference to a repository file](../blob/master/LICENSE)

		[You can use numbers for reference-style link definitions][1]

		Or leave it empty and use the [link text itself].

		URLs and URLs in angle brackets will automatically get turned into links. 
		http://www.example.com or <http://www.example.com> and sometimes 
		example.com (but not on Github, for example).

		Some text to show that the reference links can follow later.

		[arbitrary case-insensitive reference text]: https://www.mozilla.org
		[1]: http://slashdot.org
		[link text itself]: http://www.reddit.com

		Images
		Inline-style: 
		![alt text](https://github.com/adam-p/markdown-here/raw/master/src/common/images/icon48.png 'Logo Title Text 1')

		Reference-style: 
		![alt text][logo]

		[logo]: https://github.com/adam-p/markdown-here/raw/master/src/common/images/icon48.png 'Logo Title Text 2'

		Code
		```javascript
		var s = 'JavaScript syntax highlighting';
		alert(s);
		```

		| Tables        | Are           | Cool  |
		| ------------- |:-------------:| -----:|
		| col 3 is      | right-aligned | $1600 |
		| col 2 is      | centered      |   $12 |
		| zebra stripes | are neat      |    $1 |

		> Blockquotes are very handy in email to emulate reply text.
		> This line is part of the same quote.

		Horizontal rules
		Three or more...

		---	Hyphens
		***	Asterisks
		___	Underscores
		",

##################################################
# ./templates/default/edit_profiles.php
##################################################
#     "New profile" => "",

##################################################
# ./templates/default/footer.php
##################################################
#     "Fork me on github" => "",

##################################################
# ./templates/default/header.php
##################################################
     "Drag, drop, share." => "ドラッグ、ドロップ、シェア。",
     "Home" => "ホーム",
     "Edit profiles rights" => "プロファイル権限の設定",
     "Configure Bozon" => "BoZoNの設定",
     "Users list" => "ユーザー一覧",
     "New user" => "新規ユーザー",
     "Access log file" => "アクセスログ",
     "Change password" => "パスワードを変更",
#     "Rebuild base" => "",
     "Text editor" => "テキストエディタ",
     "Click or dragover to reveal dropzone" => "クリックまたはドラッグオーバーでドロップゾーンを表示",
     "Upload" => "アップロード",
     "Connect" => "接続",
     "Search in the uploaded files" => "アップロード済みファイルを検索",
     "Filter" => "フィルタ",
     "Markdown editor" => "Markdownエディタ",
     "Access log" => "アクセスログ",
     "Create an account" => "アカウントを作成",
     "Please, login" => "ログインしてください",
     "Users profiles" => "ユーザー設定",
     "Configure profiles rights" => "プロファイル権限の設定",
     "Manage links" => "リンク管理",
     "Manage files" => "ファイル管理",

##################################################
# ./templates/default/header_markdown.php
##################################################
     "Drag, drop, share." => "ドラッグ、ドロップ、シェア。",

##################################################
# ./templates/default/home.php
##################################################
     "BoZoN is a simple filesharing app." => "BoZoNはシンプルなファイル共有アプリです。",
     "Easy to install, free and opensource" => "簡単にインストールでき、フリーでオープンソースです。",
     "Just copy BoZoN's files onto your server. That's it." => "BoZoNのファイルをあなたのサーバにコピーするだけ。以上。",
     "You can freely fork BoZoN and use it as specified in the AGPL licence" => "AGPLライセンスに従って、あなたはBoZoNを自由にフォークしたり使ったりできます。",
     "More info" => "詳しく",
     "Easy to use!" => "使い方は簡単！",
     "Drag the file you want to share to upload it to the server" => "共有したいファイルをドラッグすれば、サーバにアップロードできます",
     "Share the link with your friends" => "リンクを友人と共有できます",
     "BoZoN can do more!" => "BoZoNなら、もっとできます！",
     "No database required: easy to backup or move to a new server." => "データベース不要：バックアップやサーバ移行も簡単です。",
     "Lock the access to the file/folder with a password." => "ファイルやフォルダへのアクセスをパスワードでロックできます。",
     "Share a file or a folder with a unique access link with the «burn mode»:" => "ファイルやフォルダを単一のアクセスリンクで「🔥バーンモード」で共有できます。",
     "Renew a share link with a single click" => "クリックひとつで共有リンクを更新できます",
     "Download a folder's contents into a zip" => "フォルダの中身をZIPでダウンロードできます。",
     "Access BoZoN on a smartphone without an app: your browser is enough" => "スマホでも、アプリ要らず：ブラウザで充分です。",
     "Use a qrcode to share your link with smartphone users." => "QRコードでリンクを共有できます。",
     "Add and remove users as well as manage their rights." => "ユーザーの追加、削除、権限管理ができます。",
     "To upload a folder, just zip and upload it: with one click it will be turned into a folder on the server." => "フォルダをZIPで圧縮してアップロード：クリックひとつで、サーバ上でZIPファイルをフォルダに展開できます",
     "Modify the templates & style to make your own BoZoN" => "テンプレートやスタイルを修正して、あなただけのBoZoNを作れます。",

##################################################
# ./templates/default/login.php
##################################################
     "Login" => "ログイン",
     "New account" => "新規アカウント",
#     "Change password" => "",
     "Please, login" => "ログインしてください",
#     "This login is not available, please try another one" => "",
#     "Wrong combination login/pass" => "",
#     "Problem with admin password." => "",
#     "Account created:" => "",
#     "Password changed" => "",
     "User:" => "ユーザー：",
     "Old password" => "古いパスワード",
     "Password" => "パスワード",
     "Repeat password" => "パスワードを再入力",
     "Stay connected" => "接続を維持する",

##################################################
# ./templates/default/stats.php
##################################################
     "No stats" => "ログがありません",
     "Date" => "日時",
     "File" => "ファイル",
     "Owner" => "所有者",
#     "IP" => "",
     "Origin" => "参照元",
     "Host" => "ホスト",
     "Delete all stat data" => "すべてのログを削除する",
     "Export log:" => "ログをエクスポート：",

##################################################
# ./templates/default/users.php
##################################################
     "Delete" => "削除",
     "Status" => "状態",
     "Space" => "容量",
     "Password" => "パスワード",
     "Check users to delete account and files" => "アカウントとファイルを削除するユーザーをチェックしてください。",
     "Select new status for the users" => "ユーザーの状態を選択します。",
#     "User" => "",
#     "Admin" => "",
     "Configure folders max size" => "フォルダの最大容量を設定します。",
     "Change users'passwords" => "ユーザーのパスワードを変更します。",
     "Double-clic to generate a password" => "ダブルクリックすると、パスワードを自動生成します",

);
?>
