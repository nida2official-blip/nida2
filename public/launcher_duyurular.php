<?php
header('Content-Type: text/html; charset=UTF-8');

/*
|--------------------------------------------------------------------------
| VERİTABANI BAĞLANTISI
|--------------------------------------------------------------------------
| Kendi site veritabanı bilgilerine göre düzenle.
*/

$dbHost = '77.83.37.72';
$dbUser = 'root';
$dbPass = '123';
$dbName = 'account';

$mysqli = new mysqli($dbHost, $dbUser, $dbPass, $dbName);

if ($mysqli->connect_errno) {
    exit;
}

$mysqli->set_charset('utf8mb4');

/*
|--------------------------------------------------------------------------
| DUYURULAR
|--------------------------------------------------------------------------
| Örnek tablo:
|
| launcher_duyurular
| - id
| - baslik
| - tarih
| - aktif
| - link
*/

$sql = "
    SELECT id, baslik, tarih, link
    FROM launcher_duyurular
    WHERE aktif = 1
    ORDER BY tarih DESC, id DESC
    LIMIT 4
";

$result = $mysqli->query($sql);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <style>
        html,
        body {
            width: 232px;
            height: 113px;
            margin: 0;
            padding: 0;
            overflow: hidden;

            /*
             * Tam siyah kullanmıyoruz.
             * Eski patcher #000000 renginde parazit oluşturabiliyor.
             */
            background: #080604;

            color: #e8bd52;
            font-family: Georgia, "Times New Roman", serif;
        }

        * {
            margin: 0;
            padding: 0;
            border: 0;
        }

        .launcher-notices {
            width: 222px;
            height: 107px;
            padding: 4px 5px 2px 5px;
            overflow: hidden;
        }

        .launcher-notices h2 {
            height: 22px;
            margin: 0 5px 3px 5px;
            padding: 0 0 2px 0;

            color: #edc35c;
            font-size: 15px;
            font-weight: bold;
            line-height: 20px;
            letter-spacing: 1px;

            border-bottom: 1px solid #60451d;
        }

        .notice-list {
            width: 100%;
        }

        .notice-item {
            position: relative;
            height: 18px;
            padding-left: 14px;
            padding-right: 66px;

            color: #e6b949;
            font-size: 11px;
            font-weight: bold;
            line-height: 18px;

            white-space: nowrap;
            overflow: hidden;
        }

        .notice-bullet {
            position: absolute;
            left: 3px;
            top: 0;

            color: #c58b29;
            font-size: 10px;
        }

        .notice-title {
            display: block;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;

            color: #e6b949;
            text-decoration: none;
        }

        .notice-title:hover {
            color: #fff0a0;
        }

        .notice-date {
            position: absolute;
            top: 0;
            right: 3px;

            width: 60px;
            color: #c7a769;
            font-size: 9px;
            font-weight: normal;
            text-align: right;
        }

        .empty-notice {
            padding: 12px 8px;
            color: #b99a5d;
            font-size: 11px;
            text-align: center;
        }
    </style>
</head>

<body>

<div class="launcher-notices">

    <h2>DUYURULAR</h2>

    <div class="notice-list">

        <?php if ($result && $result->num_rows > 0): ?>

            <?php while ($row = $result->fetch_assoc()): ?>

                <?php
                $baslik = htmlspecialchars(
                    $row['baslik'],
                    ENT_QUOTES,
                    'UTF-8'
                );

                $link = !empty($row['link'])
                    ? htmlspecialchars($row['link'], ENT_QUOTES, 'UTF-8')
                    : '#';

                $tarih = date(
                    'd.m.Y',
                    strtotime($row['tarih'])
                );
                ?>

                <div class="notice-item">

                    <span class="notice-bullet">◆</span>

                    <a
                        class="notice-title"
                        href="<?php echo $link; ?>"
                        target="_blank"
                        title="<?php echo $baslik; ?>"
                    >
                        <?php echo $baslik; ?>
                    </a>

                    <span class="notice-date">
                        [<?php echo $tarih; ?>]
                    </span>

                </div>

            <?php endwhile; ?>

        <?php else: ?>

            <div class="empty-notice">
                Henüz duyuru bulunmuyor.
            </div>

        <?php endif; ?>

    </div>

</div>

</body>
</html>

<?php
$mysqli->close();
?>
