<nav>
    <a href="/feed"><img id="logo" src="../assets/img/logo_Wavely.png" alt="logo Wavely"></a>
    <a href="/profile">
        <div id="my_profile">
            <div class="username"><p><?php echo $_SESSION['username']; ?></p></div>
            <img src="../<?php echo $_SESSION['profile_picture']; ?>" alt="your profile's picture">
        </div>
    </a>
</nav>