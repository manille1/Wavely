<main class="column_maker">
    <h1>Bienvenue sur Wavely !</h1>

    <div id="choice_auth_btn" class="column_maker">
        <div class="log_btn"><a href="#">Connectez-vous</a></div>
        <div class="register_btn"><a href="#">S'inscrire</a></div>
    </div>

    <div class="login_form_div">
        <form method="POST"  class="login_form" action="/login/submit">
            <label for="log_email">Email</label>
            <input type="email" id="log_email" name="email" placeholder="Email" required>
        
            <label for="log_pass">Mot de passe</label>
            <input type="password" id="log_pass" name="password" required>
            
            <button type="submit" name="valid_login" id="valid-login-btn" class="valid_btn">Connexion</button>
        </form>
    </div>

    <div class="register_form_div">
        <form method="POST"  class="register_form" action="/register/submit">
            <label for="regi_email">Email</label>
            <input type="email" id="regi_email" name="email" placeholder="Ton email" required>
            
            <label for="pass" class="form-label">Mot de passe</label>
            <input type="password" name="password" id="pass" class="form-control" required>

            <label for="confirmation" class="form-label">Confirmation du mot de passe</label>
            <input type="password" name="confirmation" id="confirmation" class="form-control" required>

            <label for="regi_username">Pseudo</label>
            <input type="text" id="regi_username" name="username" placeholder="Le nom que les utilisateur verront ..." required>

            <label for="profile_picture">Photo de profile</label>
            <input type="text" id="profile_picture" name="profile_picture" placeholder="Ta photo de profile">

            <label for="description">Description</label>
            <input type="textarea" id="description" name="description" placeholder="Ce qui te décris ..." required>
            
            <button type="submit" name="valid_register" id="valid-register-btn" class=" valid_btn">Créer un compte</button>
        </form>
    </div>
</main>

<script src="/assets/js/login.js"></script>