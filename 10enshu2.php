<?php
// データベース接続設定
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "your_database";

// データベース接続
$conn = new mysqli($servername, $username, $password, $dbname);

// 接続確認
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>投稿検索</title>
</head>
<body>
    <form method="GET" action="">
        <input type="text" name="search" placeholder="本文を検索" value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
        <button type="submit">検索</button>
        <a href="search_posts.php">検索解除</a> <!-- 検索解除リンク -->
    </form>

    <?php
    if (isset($_GET['search']) && !empty($_GET['search'])) {
        $search = $_GET['search'];

        // サニタイズ
        $search = $conn->real_escape_string($search);

        // LIKE句を使用したSQLクエリ
        $sql = "SELECT * FROM posts WHERE body LIKE '%$search%'";

        // クエリ実行
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // 結果を表示
            while($row = $result->fetch_assoc()) {
                echo "<p>" . htmlspecialchars($row["body"]) . "</p>";
            }
        } else {
            echo "一致する投稿が見つかりませんでした。";
        }
    } else {
        echo "検索キーワードを入力してください。";
    }

    // データベース接続を閉じる
    $conn->close();
    ?>
</body>
</html>
