<main>
    <img id="preview_album_photo" src="../<?= $album['album_cover_url'] ? $album['album_cover_url'] : 'assets/img/default-pp.jpg'; ?>" alt="cover album">

    <section id="album_presentation">
        <h1><?= $album['name'] ?></h1>
        <p><?= $album['description'] ?></p>
        <a href="/create-photo?album_id=<?= $album['id'] ?>">Créer une photo</a>
        <a href="/delete-album?album_id=<?= $album['id'] ?>">Supprimer l'album</a>
    </section>

    <section id="photos">
        <?php if (empty($photos)) : ?>
            <p>L'album est vide.</p>
        <?php else : ?>
            <?php foreach ($photos as $photo) : ?>
                <div class="photo">
                    <img src="../<?= $photo['image_url']?>" alt="photo de <?= $photo['creator_id']?> créer le <?= $photo['date_upload']?>">
                    <p><?= $photo['name'] ?></p>
                    <p><i class="fa-solid fa-map-pin"></i><?= $photo['location']?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>