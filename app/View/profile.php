<main>
    <section id="user_profile">
        <img src="../<?= $_SESSION['profile_picture']; ?>" alt="your profile's picture">
        <div class="username"><h2><?= $_SESSION['username']; ?></h2></div>
        <div id="user_description">
            <p><?= $_SESSION['description']; ?></p>
        </div>
        <div class="space-btw">
            <a id="update-user-btn" class="green-btn" href="/update-profile?id=<?= $_SESSION['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
            <select id="filterBtn" class="green-btn" name="filterBtn">
                <option value="" disabled selected>Filtrer</option>
                <option id="filterAlbum" value="album">Album</option>
                <option id="filterPhoto" value="photo">Photo</option>
            </select>
        </div>
    </section>

    <?php if (isset($_GET['action']) && $_GET['action'] === 'photo') : ?>
        <section class="posts">
            <?php if (empty($photos)) : ?>
                <p class="void_case">Aucune photo</p>
            <?php else : ?>
                <?php foreach ($photos as $photo) : ?>
                    <?php if ($photo['creator_id'] === $_SESSION['id'] || $photo['visibility'] === 'public') : ?>
                        <div class="card">
                            <div class="post">
                                <img src="../<?= $photo['image_url'] ?? '/assets/img/default-pp.jpg' ?>" alt="photo de <?= $photo['creator_id']?> créer le <?= $photo['date_upload']?>">
                                <div>
                                    <h3><?= $photo['name']?></h3>
                                    <p><?= $_SESSION['username'] ?></p>
                                    <p><i class="fa-solid fa-map-pin"></i> <?= $photo['location']?></p>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    <?php else : ?>
        <section id="album_section">
            <?php if (empty($albums)) : ?>
                <p class="void_case">Aucun album</p>
            <?php else : ?>
                <?php foreach ($albums as $album) : ?>
                    <?php if ($album['owner_id'] === $_SESSION['id'] || $album['visibility'] === 'public') : ?>
                        <div class="card">
                            <a href="/album?id=<?= $album['id'] ?>">
                                <img class="album_icon" src="../<?= $album['album_cover_url'] ? $album['album_cover_url'] : 'assets/img/album.svg'; ?>" alt="album">
                                <p><?= $album['name'] ?></p>
                            </a>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </section>
    <?php endif; ?>

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

    document.getElementById('filterBtn').addEventListener('change', function () {
        const value = this.value;
        if (value) {
        window.location.href = `/profile?action=${value}`;
        }
    });
</script>
