<main>
  <h1>Modifier votre profile</h1>

  <form class="form" action="/update-profile-send" method="post" enctype="multipart/form-data">
        <label for="username">Pseudo</label>
        <input type="text" id="username" name="username" 
        placeholder="Le nom que les utilisateur verront ..." value="<?= $_SESSION['username'] ?>" required>

        <label for="profile_picture">Photo de profile (max 2Mo)</label>
        <input type="file" id="profile_picture" name="photo" accept="image/*" required>

        <label for="description">Description</label>
        <input type="textarea" id="description" name="description" 
        placeholder="Ce qui te décris ..." value="<?= $_SESSION['description'] ?>" required>
            
        <button type="submit">Mettre à jour</button>
    </form>
</main>

<script>
    const openBtn = document.getElementById('menuBtn')
    const closeBtn = document.getElementById('closeMenuBtn')
    const sideMenu = document.getElementById('side-menu')

    const form = document.querySelector('form')
    const imageInput = document.querySelector('input[type="file"][name="photo"]')
    const maxSize = 2 * 1024 * 1024 //2 Mo

    openBtn.addEventListener('click', () => {
        sideMenu.classList.add('open')
    })

    closeBtn.addEventListener('click', () => {
        sideMenu.classList.remove('open')
    })

    form.addEventListener('submit', (e) => {
        const image = imageInput.files[0]
        if (image && image.size > maxSize){
            e.preventDefault()
            alert('Votre photo est trop lourde ! Le serveur n\'a pas d\'assez gros bras !')
        }
    })
</script>