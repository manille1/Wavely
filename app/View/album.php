<main>
    <img id="preview_album_photo" src="../assets/img/tokyo_street.jpg" alt="van">

    <section id="album_description">
        <h1><?= $album['name'] ?></h1>
        <p><?= $album['description'] ?></p>
    </section>

    <section id="photos">
        <div id="photo">
            <img src="../assets/img/little_tokyo_street.jpg" alt="little tokyo street">
            <p>Tokyo la nuit</p>
            <p><i class="fa-solid fa-map-pin"></i> Tokyo, Japon</p>
        </div>
        <div id="photo">
            <img src="../assets/img/temple.jpg" alt="little tokyo street">
            <p>Tokyo la nuit</p>
            <p><i class="fa-solid fa-map-pin"></i> Chine</p>
        </div>
        <?php if (empty($photos)) : ?>
            <p>L'album est vide.</p>
        <?php else : ?>
            <?php foreach ($photos as $photo) : ?>
                <div id="photo">
                    <img src="<?= $photo['image_url']?>" alt="photo de <?= $photo['creator_id']?> créer le <?= $photo['date_upload']?>">
                    <p><?= $photo['name'] ?></p>
                    <p><i class="fa-solid fa-map-pin"></i><?= $photo['location']?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>