<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!--Font-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Salsa&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    
    <title>Wavely.</title>
    <link rel="stylesheet" href="/assets/css/login.css">
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <header>
        <?= $navbar; ?>
    </header>

    <!--error-->
    <?php if(!empty($_SESSION['errors'])): ?>
        <div class="error_message_div">
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <p class="error_message"><?= htmlspecialchars($error) ?></p>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <!--success-->
    <?php if(!empty($_SESSION['success'])): ?>
        <div class="success_message_div">
            <?php foreach ($_SESSION['success'] as $success): ?>
                <p class="success_message"><?= htmlspecialchars($success) ?></p>
            <?php endforeach; ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?= $content; ?>
    
</body>
</html>
