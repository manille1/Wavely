<main>
  <h1>Créer un nouvel album</h1>

  <form id="create_album_form" action="/create-album-send" method="post" enctype="multipart/form-data">
    <input type="text" id="album_title" name="album_title" placeholder="Titre" required>

    <textarea id="album_description" name="album_description" rows="5" placeholder="Description" required></textarea>

    <label for="albums_photos">Vos photos</label>
    <input type="checkbox" id="albums_photos" name="add_photos" value="photos">
    <!-- <input type="file" id="album_photos" name="album_photos" multiple> -->

    <label for="visibility">Visibilité</label>
    <select id="visibility" name="visibility">
      <option value="public">Public</option>
      <option value="private">Privé</option>
      <option value="restrected">Groupe d'amis</option>
    </select>

    <button type="submit">Créer l’album</button>
  </form>
</main>