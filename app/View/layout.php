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

    <?php if(!empty($_SESSION['errors'])): ?>
            <?php foreach ($_SESSION['errors'] as $error): ?>
                <div class="toast error">
                    <p><?= htmlspecialchars($error) ?></p>
                </div>
            <?php endforeach; ?>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <?php if(!empty($_SESSION['success'])): ?>
            <?php foreach ($_SESSION['success'] as $success): ?>
                <div class="toast success">
                    <p><?= htmlspecialchars($success) ?></p>
                </div>
            <?php endforeach; ?>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?= $content; ?>

    <script src="/assets/js/main.js"></script>
    <script>
        const toasts = document.querySelectorAll('.toast')
        toasts.forEach(toast => {
            toast.classList.add('display')

            setTimeout(() => {
                toast.classList.remove('display')
            }, 5000);
        });
    </script>
    
</body>
</html>
