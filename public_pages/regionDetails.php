<?php
session_start();
include("../database_connection.php");

// 1. التأكد من وجود معرف المنطقة في الرابط لضمان عدم حدوث خطأ
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: regionsGallary.php");
    exit();
}

$region_id = (int)$_GET['id'];

// 2. جلب معلومات المنطقة الأساسية (الاسم، العنوان، الوصف، الصورة)
$region_query = "SELECT * FROM Regions WHERE region_id = $region_id";
$region_result = mysqli_query($conn, $region_query);
$region_data = mysqli_fetch_assoc($region_result);

if (!$region_data) {
    die("عذراً، هذه المنطقة غير موجودة في قاعدة البيانات.");
}

// 3. جلب المعالم السياحية المرتبطة بهذه المنطقة
$landmarks_query = "SELECT landmark FROM Landmarks WHERE region_id = $region_id";
$landmarks_res = mysqli_query($conn, $landmarks_query);

// 4. جلب الأنشطة المرتبطة بهذه المنطقة
$activities_query = "SELECT activity FROM Activities WHERE region_id = $region_id";
$activities_res = mysqli_query($conn, $activities_query);

// 5. جلب كافة الصور الإضافية من جدول الصور
$images_query = "SELECT image_path FROM Images WHERE region_id = $region_id";
$images_res = mysqli_query($conn, $images_query);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>استكشف | <?php echo $region_data['region_name']; ?></title>
    <link rel="stylesheet" href="../style.css">
</head>
<body>

    <header>
        <nav>
                <ul>
                    <li><a href="../index.php">الرئيسية</a></li>
                    <li><a href="regionsGallary.php">معرض المناطق</a></li>
                    <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                        <li><a href="../admin_pages/dashboard.php">لوحة تحكم المشرف</a></li>
                        <li><a href="../admin_pages/logout.php">تسجيل خروج</a></li>
                    <?php else: ?>
                        <li><a href="../admin_pages/AdminLogin.php">دخول المشرف</a></li>
                    <?php endif; ?>
                </ul>
        </nav>
    </header>

    <main class="details-container">
        
        <div class="main-image-wrapper">
            <img src="../image/<?php echo $region_data['icon_path']; ?>" class="main-img" alt="<?php echo $region_data['region_name']; ?>">
        </div>
        
        <div class="info-section">
            <h1 style="color: #08482d; font-size: 2.8rem; font-weight: 800; margin-bottom: 10px;">
                <?php echo $region_data['region_name']; ?>
            </h1>
            <p style="color: #2b6cb0; font-size: 1.3rem; font-weight: 600;">
                <?php echo $region_data['headline']; ?>
            </p>
        </div>

        <div class="info-section">
            <h3>عن المنطقة</h3>
            <p style="font-size: 1.1rem; color: #4a5568; text-align: justify;">
                <?php echo nl2br($region_data['description']); ?>
            </p>
        </div>

        <div class="info-section">
            <h3>أبرز المعالم السياحية</h3>
            <ul class="grid-list">
                <?php 
                if(mysqli_num_rows($landmarks_res) > 0) {
                    while($row = mysqli_fetch_assoc($landmarks_res)) {
                        echo "<li>" . htmlspecialchars($row['landmark']) . "</li>";
                    }
                } else {
                    echo "<p style='color:#a0aec0;'>لا توجد معالم مضافة حالياً.</p>";
                }
                ?>
            </ul>
        </div>

        <div class="info-section">
            <h3>الأنشطة المقترحة</h3>
            <ul class="grid-list">
                <?php 
                if(mysqli_num_rows($activities_res) > 0) {
                    while($row = mysqli_fetch_assoc($activities_res)) {
                        echo "<li>" . htmlspecialchars($row['activity']) . "</li>";
                    }
                } else {
                    echo "<p style='color:#a0aec0;'>لا توجد أنشطة مضافة حالياً.</p>";
                }
                ?>
            </ul>
        </div>

        <div class="info-section">
            <h3>معرض الصور</h3>
            <div class="extra-images">
                <?php 
                if(mysqli_num_rows($images_res) > 0) {
                    while($row = mysqli_fetch_assoc($images_res)) { ?>
                        <img src="../image/<?php echo $row['image_path']; ?>" alt="صورة إضافية لـ <?php echo $region_data['region_name']; ?>">
                    <?php } 
                } else {
                    echo "<p style='color:#a0aec0;'>لا توجد صور إضافية لهذه المنطقة.</p>";
                }
                ?>
            </div>
        </div>

        <div style="text-align: center; margin-top: 50px;">
            <a href="regionsGallary.php" class="gallery-explore-btn" style="display: inline-block; padding: 15px 40px; border-radius: 50px; text-decoration: none;">
                العودة لمعرض المناطق
            </a>
        </div>
    </main>

    <footer>
        <p>استكشف جمال المملكة &copy; 2026 | جامعة الملك سعود</p>
    </footer>

</body>
</html>