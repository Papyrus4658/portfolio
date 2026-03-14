<?php
try {
    // $db = new PDO("mysql:dbname=ss418755_portfolio;host=127.0.0.1;charset=utf8", "mono", "vivehodie");

    $db = new PDO(
        "mysql:dbname=if0_40489090_portfolio;host=sql305.infinityfree.com;charset=utf8",
        "if0_40489090",
        "83O1NNHckcw"
    );
} catch (PDOException $e) {
    echo "DB接続エラー" . $e->getMessage();
}

if (!function_exists("nt")) {
    function nt($str)
    {
        return htmlspecialchars($str, ENT_QUOTES);
    }
}

if (!function_exists("deleteFilesInDirectory")) {
    /**
     * 指定されたディレクトリ内の全ファイルとサブディレクトリを削除する関数
     *
     * @param string $dir 削除対象のディレクトリパス
     */
    function deleteFilesInDirectory($dir)
    {
        if (is_dir($dir)) {
            $files = scandir($dir); // ディレクトリ内の全ファイルを取得
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $filePath = $dir . DIRECTORY_SEPARATOR . $file; // ファイルパスを構築
                    if (is_dir($filePath)) {
                        deleteFilesInDirectory($filePath); // サブディレクトリを再帰的に削除
                        rmdir($filePath); // サブディレクトリを削除
                    } else {
                        unlink($filePath); // ファイルを削除
                    }
                }
            }
        }
    }
}
