<main>
    <section id="friends_profile">
        <div class="friends_pp"></div>
        <div class="friends_pp"></div>
        <div class="friends_pp"></div>
        <div class="friends_pp"></div>
        <div class="friends_pp"></div>
        <div class="friends_pp"></div>
        <div class="friends_pp"></div>
        <div class="friends_pp"></div>
        <div class="friends_pp"></div>
        <div class="friends_pp"></div>
    </section>

    <section id="posts">
        <?php if (empty($photos_feed)) : ?>
            <p>Il y a eu une erreur lors de la récupération du contenu, veuillez recharger la page ou vous reconnécter.</p>
        <?php else : ?>
            <?php foreach ($photos_feed as $photo) : ?>
                <div class="post">
                    <img src="../<?= $photo['image_url']?>" alt="photo de <?= $photo['creator_id']?> créer le <?= $photo['date_upload']?>">
                    <div>
                        <h3><?= $photo['username']?></h3>
                        <p><i class="fa-solid fa-map-pin"></i> <?= $photo['location']?></p>
                        <p><?= $photo['date_only']?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>
</main>