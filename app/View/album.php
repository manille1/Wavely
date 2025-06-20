<main>
    <img id="preview_album_photo" src="../<?= $album['album_cover_url'] ? $album['album_cover_url'] : 'assets/img/default-image.jpg'; ?>" alt="cover album">

    <section id="album_presentation">
        <h1><?= $album['name'] ?></h1>
        <p><?= $album['description'] ?></p>
        <?php if ($album['owner_id'] === $_SESSION['id']) : ?>
            <a class="link_functions" href="/create-photo?action=create&album_id=<?= $album['id'] ?>"><i class="fa-solid fa-plus"></i><i class="fa-solid fa-camera-retro"></i></a>
            <a class="link_functions" href="/update-album?action=update&id=<?= $album['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
            <a class="link_functions" href="/delete-album?album_id=<?= $album['id'] ?>"><i class="fa-solid fa-trash-can"></i></a>
        <?php endif; ?>
    </section>

    <section id="photos">
        <?php if (empty($photos)) : ?>
            <p>L'album est vide.</p>
        <?php else : ?>
            <?php foreach ($photos as $photo) : ?>
                <div class="photo">
                    <img src="../<?= $photo['image_url']?>" alt="photo de <?= $photo['creator_id']?> créer le <?= $photo['date_upload']?>">
                    <div>
                        <p><?= $photo['name'] ?></p>
                        <p><i class="fa-solid fa-map-pin"></i><?= $photo['location']?></p>
                        <?php if($album['owner_id'] === $_SESSION['id']) : ?>
                            <a class="link_functions" href="/delete-photo?photo_id=<?= $photo['id'] ?>"><i class="fa-solid fa-trash-can"></i></a>
                            <a class="link_functions" href="/update-photo?action=update&id=<?= $photo['id'] ?>&album-id=<?= $album['id'] ?>"><i class="fa-solid fa-pen-to-square"></i></a>
                        <?php endif; ?>
                    <div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>