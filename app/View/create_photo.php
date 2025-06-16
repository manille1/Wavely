<main>
  <h1>Créer une nouvel photo</h1>

  <form id="create_photo_form" class="create_form" action="/create-photo-send" method="post" enctype="multipart/form-data">
    <input type="hidden" name="album_id" value="<?= htmlspecialchars($album_id) ?>">

    <label for="photo_title">Titre</label>
    <input type="text" id="photo_title" name="photo_title" placeholder="Titre" required>

    <label for="input_photo">Votre photo</label>
    <input type="file" id="input_photo" name="photo" accept="image/*" required>

    <label for="photo_description">Description</label>
    <textarea id="photo_description" name="photo_description" rows="4" placeholder="Description" required></textarea>

    <label for="photo_location">Lieu</label>
    <input type="text" id="photo_location" name="photo_location" placeholder="Lieu">

    <label for="visibility">Visibilité</label>
    <select id="visibility" name="visibility">
      <option value="public">Public</option>
      <option value="private">Privé</option>
      <option value="restrected">Groupe d'amis</option>
    </select>

    <button type="submit">Créer la photo</button>
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