# Rapport SAÉ 2.2

Le premier problème que nous avons rencontré est la diversité des environnements : Nous développons tous sur XAMPP, notre serveur de production (https://coff-it.store) est contenu dans une image Docker. 

Tous ces environnements n'ont pas une base de données au même endroit, avec les mêmes identifiants. Il devient alors compliqué d'inclure les identifiants de connexion directement dans le code qui sera poussé sur le dépôt git. 

Nous avons donc choisi d'utiliser un fichier .env, qui contient ces identifiants et qui ne sera jamais poussé sur le dépôt git. Ainsi, chaque environnement à son fichier .env, ce qui permet de faciliter le travail d'équipe et la mise en production. Ce fichier est lu par notre script PHP de connexion à la base de données : chaque clé devient une variable qui sa valeur.

Voici un exemple de fichier .env :

```
DB_URL=localhost
DB_LOGIN=root
DB_PASSWORD=
DB_NAME=coff_it
```

Une fois ce fichier lu par PHP, on peut utiliser la variable "$DB_URL" qui vaut "localhost"
