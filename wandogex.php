<?php
// お天気取得ロジック
$apiKey = "YOUR_API_KEY";
$city = isset($_GET['city']) ? $_GET['city'] : "Tokyo";
$apiUrl = "https://api.openweathermap.org/data/2.5/forecast?q=$city&appid=$apiKey&units=metric&lang=ja";

// APIからデータを取得
$json = file_get_contents($apiUrl);
$data = json_decode($json, true);

// 現在の天気
$current = $data['list'][0];
$temp = $current['main']['temp'];
$desc = $current['weather'][0]['description'];

// お散歩判定
function getAdvice($t) {
    if ($t >= 30) return ["level" => "危険", "msg" => "アチチだワン！夜まで待って！", "color" => "#ff4d4d"];
    if ($t >= 25) return ["level" => "注意", "msg" => "日陰を選んで歩こうね", "color" => "#ffa500"];
    if ($t <= 10) return ["level" => "寒い", "msg" => "お洋服を着て散歩しよ！", "color" => "#1e90ff"];
    return ["level" => "最適", "msg" => "最高のお散歩日和だワン！", "color" => "#32cd32"];
}
$advice = getAdvice($temp);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ワンワン予報</title>
    <style>
        body { font-family: sans-serif; text-align: center; background: #fdf5e6; margin: 0; padding: 20px; }
        .card { background: white; border-radius: 20px; padding: 20px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); }
        .advice-box { background: <?= $advice['color'] ?>; color: white; padding: 15px; border-radius: 10px; margin: 20px 0; }
        .dog-img { width: 150px; }
        .forecast { display: flex; justify-content: space-around; margin-top: 20px; }
        input { padding: 10px; border-radius: 5px; border: 1px solid #ccc; }
    </style>
</head>
<body>
    <div class="card">
        <form method="GET">
            <input type="text" name="city" placeholder="都市名を英語で">
            <button type="submit">検索</button>
        </form>

        <h2><?= $city ?> の天気</h2>
        <img src="m_dach_gold.png" class="dog-img" alt="Mダックス">
        <h1><?= round($temp) ?>℃</h1>
        <p><?= $desc ?></p>

        <div class="advice-box">
            <h3><?= $advice['level'] ?></h3>
            <p><?php echo $advice['msg']; ?></p>
        </div>

        <div style="border: 1px dashed #ccc; padding: 10px;">
            <p style="font-size: 12px;">今日のおすすめ</p>
            <a href="AMAZON_LINK">ひんやり肉球クリーム 🔗</a>
        </div>
    </div>
</body>
</html>