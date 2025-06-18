<main>
    <section id="user_profile">
        <img src="../<?= $profile_picture; ?>" alt="your profile's picture">
        <div class="username"><h2><?= $username; ?></h2></div>
        <div id="user_description">
            <p><?= $description; ?></p>
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
        <?php if (empty($albums)) : ?>
            <p class="void_case">Aucun album</p>
        <?php else : ?>
            <?php foreach ($albums as $album) : ?>
                <?php if ($album['owner_id'] === $_SESSION['id'] || $album['visibility'] === 'public') : ?>
                    <div class="album-card">
                        <a href="/album?id=<?= $album['id'] ?>">
                            <img class="album_icon" src="../<?= $album['album_cover_url'] ? $album['album_cover_url'] : 'assets/img/album.svg'; ?>" alt="album">
                            <p><?= $album['name'] ?></p>
                        </a>
                    </div>
                <?php endif; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>

<script>
    const openBtn = document.getElementById('menuBtn')
    const closeBtn = document.getElementById('closeMenuBtn')
    const sideMenu = document.getElementById('side-menu')

    openBtn.addEventListener('click', () => {
        sideMenu.classList.add('open')
    })

    closeBtn.addEventListener('click', () => {
        sideMenu.classList.remove('open')
    })
</script>
