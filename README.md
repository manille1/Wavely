# 🌊 Wavely — Application de gestion d'albums photo

**Wavely** est un projet scolaire développé en PHP sans framework, avec une architecture MVC.  
L’application permet aux utilisateurs de créer, gérer et partager des albums photo de manière intuitive.

## Fonctionnalités principales

- Création de compte avec photo de profil
- Connexion sécurisée avec sessions PHP
- Création, modification et suppression d’albums
- Ajout de photos aux albums, avec gestion des formats/images
- Modification et suppression de photos
- Gestion des droits d’accès (visibilité publique/privée)
- Page de profil avec informations utilisateur
- Fil d’actualité avec photos visibles pour l'utilisateur
- Responsive design (mobile/tablette/desktop)
- Système de notification simple via toasts JavaScript
- Système de gestion d’erreurs centralisé

## Technologies utilisées

- PHP 8+
- MySQL
- JavaScript (vanilla + DOM)
- HTML5 / CSS3 (sans framework)
- POO / MVC sans framework
- Apache / Virtual Hosts
- WAMP (Windows Apache MySQL PHP)

## Structure du projet

```
C:.
├───app
│ ├───config
│ ├───Controller
│ ├───core
│ ├───Model
│ ├───View
│ └───_partials
└───public
├───assets
│ ├───css
│ ├───img
│ └───js
└───uploads
```


## 🚀 Lancer le projet en local

### 1. Pré-requis

- PHP 8+
- MySQL (ou MariaDB)
- Apache avec `mod_rewrite` activé
- WAMP, XAMPP ou tout serveur LAMP/LAMP-like

### 2. Cloner le projet

```bash
git clone https://gitlab.com/ton-compte/wavely.git
cd wavely
```

## 🛠️ VHOST & Configuration locale (WAMP)

### Configuration VirtualHost (WAMP)

Pour utiliser `wavely.local` au lieu de `localhost/wavely/public`, vous pouvez configurer un VirtualHost avec WAMP :

1. **Éditer le fichier** `httpd-vhosts.conf` :  
   (En général situé dans `C:\wamp64\bin\apache\apache2.x.x\conf\extra\httpd-vhosts.conf`)

```apache
<VirtualHost *:80>
    ServerName wavely.local
    DocumentRoot "c:/wamp64/www/wavely/public"
    <Directory "c:/wamp64/www/wavely/public/">
        Options +Indexes +Includes +FollowSymLinks +MultiViews
        AllowOverride All
        Require local
    </Directory>
</VirtualHost>
```

2. **Éditer le fichier hosts de Windows :**
(Ouvrir C:\Windows\System32\drivers\etc\hosts en tant qu’administrateur)

Ajouter à la fin du fichier :
```
127.0.0.1 wavely.local
```

3. **Redémarrer WAMP pour prendre en compte le nouveau vhost.**

4. **Accéder à l’application via :**
👉 http://wavely.local

### Configuration de base
- Le fichier app/config/config.php contient les paramètres de connexion à la base de données.
- Le fichier .htaccess (dans public/) permet la réécriture des URL via Apache.

## 🧩 Perspectives d'évolution
- Le système de groupes d’amis et de visibilité restreinte est partiellement préparé en base mais non implémenté.
- Possibilité d’ajouter un système de commentaires, une recherche par tags ou encore une galerie plus dynamique avec JavaScript.
- Un back-office complet pourra être ajouté à partir des rôles utilisateurs déjà en place.

 ## 📚 Projet scolaire
Ce projet a été réalisé dans le cadre d’un projet d’un cursus de développement web.
Il respecte les contraintes suivantes :
- Sans framework
- Architecture MVC maison
- Programmation orientée objet
- Gestion basique des erreurs et des routes
- Utilisation de PHP, MySQL, HTML, CSS et JS uniquement
