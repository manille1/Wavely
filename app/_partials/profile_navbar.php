<nav>
    <a href="/feed"><img  id="logo" src="../assets/img/logo_Wavely.png" alt="logo Wavely"></a>
    <div id="menuBtn">
        <a href="#"><i class="fa-solid fa-bars"></i></a> 
    </div>
</nav>

<section id="side-menu">
    <button id="closeMenuBtn">✖</button>
    <a id="deconnect_btn" href="/logout">Déconnexion</a>
    <?php if($_SERVER['REQUEST_URI'] !== '/profile?action=album') : ?>
        <a id="back_profile_btn" href="/profile?action=album">Retour au profile</a>
    <?php endif; ?>
    <a id="create_album_btn" href="/create-album?action=create"><img src="../assets/img/create_album.svg" alt="créer un album"></a>
</section>
