<main>
  <h1><?= $_GET['action'] === 'create' ? 'Créer un nouvel ' : 'Modifier l\''; ?>album</h1>

  <form id="form_album" class="form" action="/<?= $_GET['action'] ?>-album-send" 
  method="post" enctype="multipart/form-data">
    <?php if ($_GET['action'] === 'update') : ?>
      <input type="hidden" name="album_id" value="<?= htmlspecialchars($album_id) ?>">
    <?php endif; ?>

    <input type="text" id="album_title" name="album_title" placeholder="Titre" 
    <?= $_GET['action'] === 'create' ? '' : 'value="' . $album['name'] . '"'; ?> 
    required>

    <textarea id="album_description" name="album_description" rows="5" placeholder="Description" 
    required><?= $_GET['action'] === 'create' ? '' : htmlspecialchars($album['description']); ?></textarea>

    <label for="input_photo">L'image de présentation de votre album (max 2Mo)</label>
    <input type="file" id="input_photo" name="photo" accept="image/*">

    <?php if($_GET['action'] === 'create') : ?>
      <label for="albums_photos">Ajoutez maintenant une photos à votre album :</label>
      <input type="checkbox" id="albums_photos" name="add_photos" value="photos">
    <?php endif; ?>

    <label for="visibility">Visibilité</label>
    <select id="visibility" name="visibility">
      <option value="public" <?= $_GET['action'] === 'update' && $isSelected === 'public' ? 'selected' : ''; ?>>Public</option>
      <option value="private" <?= $_GET['action'] === 'update' && $isSelected === 'private' ? 'selected' : ''; ?>>Privé</option>
      <option value="restrected" <?= $_GET['action'] === 'update' && $isSelected === 'restructed' ? 'selected' : ''; ?>>Groupe d'amis</option>
    </select>

    <button type="submit">
      <?= $_GET['action'] === 'create' ? 'Créer un nouvel ' : 'Modifier l\''; ?>album
    </button>
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