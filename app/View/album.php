<main>
    <img id="preview_album_photo" src="../uploads/250615.jpg" alt="van">

    <section id="album_presentation">
        <h1><?= $album['name'] ?></h1>
        <p><?= $album['description'] ?></p>
        <a href="/create-photo?album_id=<?= $album['id'] ?>">Créer une photo</a>
    </section>

    <section id="photos">
        <?php if (empty($photos)) : ?>
            <p>L'album est vide.</p>
        <?php else : ?>
            <?php foreach ($photos as $photo) : ?>
                <div id="photo">
                    <img src="../<?= $photo['image_url']?>" alt="photo de <?= $photo['creator_id']?> créer le <?= $photo['date_upload']?>">
                    <p><?= $photo['name'] ?></p>
                    <p><i class="fa-solid fa-map-pin"></i><?= $photo['location']?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>