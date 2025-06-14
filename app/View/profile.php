<main>
    <section id="user_profile">
        <img src="../assets/img/<?php echo $_SESSION['profile_picture']; ?>" alt="your profile's picture">
        <div class="username"><h2><?php echo $_SESSION['username']; ?></h2></div>
        <div id="user_description">
            <p><?php echo $_SESSION['description']; ?></p>
        </div>
        <div class="flex-end">
            <select id="filterBtn" name="filterBtn">
                <option value="default" selected>Filtrer</option>
                <option value="album">Album</option>
                <option value="photo">Photo</option>
            </select>
        </div>
    </section>

    <section id="album_section">
        <div>
            <img src="../assets/img/album.svg" alt="alnum">
            <a href="./album.html"><p>Mykonos</p></a> 
        </div>
        <div>
            <img src="../assets/img/album.svg" alt="alnum">
            <a href="./album.html"><p>Deauville en 2024</p></a>
        </div>
        <div>
            <img src="../assets/img/album.svg" alt="alnum">
            <a href="./album.html"><p>Corée du Sud 2025</p></a>
        </div>

        <?php if (empty($albums)) : ?>
            <p>Vous n’avez pas encore d’albums.</p>
        <?php else : ?>
            <?php foreach ($albums as $album) : ?>
                <div class="album-card">
                    <img src="../assets/img/album.svg" alt="album">
                    <a href="/album?id=<?= $album['id'] ?>"><p><?= $album['name'] ?></p></a>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>

<script>
    const openBtn = document.getElementById('menuBtn');
    const closeBtn = document.getElementById('closeMenuBtn');
    const sideMenu = document.getElementById('side-menu');

    openBtn.addEventListener('click', () => {
        sideMenu.classList.add('open');
    });

    closeBtn.addEventListener('click', () => {
        sideMenu.classList.remove('open');
    });
</script>
