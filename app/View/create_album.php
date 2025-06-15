<main>
  <h1>Créer un nouvel album</h1>

  <form id="create_album_form" class="create_form" action="/create-album-send" method="post" enctype="multipart/form-data">
    <input type="text" id="album_title" name="album_title" placeholder="Titre" required>

    <textarea id="album_description" name="album_description" rows="5" placeholder="Description" required></textarea>

    <label for="albums_photos">Vos photos</label>
    <input type="checkbox" id="albums_photos" name="add_photos" value="photos">

    <label for="visibility">Visibilité</label>
    <select id="visibility" name="visibility">
      <option value="public">Public</option>
      <option value="private">Privé</option>
      <option value="restrected">Groupe d'amis</option>
    </select>

    <button type="submit">Créer l’album</button>
  </form>
</main>

<script>
    const openBtn = document.getElementById('menuBtn');
    const closeBtn = document.getElementById('closeMenuBtn');
    const sideMenu = document.getElementById('side-menu');

    openBtn.addEventListener('click', () => {
        sideMenu.classList.add('open');
    });

    closeBtn.addEventListener('click', () => {
        sideMenu.classList.remove('open');
    });
</script>