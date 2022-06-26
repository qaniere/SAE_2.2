# SAE_2.2

# Projet SAE 2.02 #

Ce projet se fait dans le cadre d'une SAE commune avec SAE 2.05 et SAE 2.06.

## Contexte ## 

Une entreprise se charge de faire l'intermédiaire entre les
particuliers et des entreprises (B2C) pour la vente de matériel
électronique (téléphone, tablette, ordinateur, objets connectés, ...)
et la reprise de matériel usagé. L'entreprise n'est pas un simple
intermédiaire. Sa valeur ajoutée repose principalement sur sa capacité
à recycler le matériel électronique en récupérant des éléments
valorisables, que ce soit des métaux précieux ou des composants qui
pourront être reconditionnés (batterie, écran tactile, disque ssd, RAM etc).


     +-----------+   vente (usagé)       +------------------+
     |  Client   | ------------------->  |                  |
     |           | <-------------------  + Entreprise B2C   |
     +-----------+   achat               |                  |
                     (neuf, recond)      |                  |
                                         |                  |
                                         |                  |
                      achat composants   |                  |
     +-------------+ <------------------ |                  |
     | Constructeur|                     |                  |
     | Samsung etc | ---------------->   |                  |
     |             | vente (neuf, recond)|                  |
     +-------------+                     +------------------+

### Exemple ###

https://www.bbc.com/future/article/20161017-your-old-phone-is-full-of-precious-metals

Smartphones are pocket-sized vaults of precious metals and rare earths. A typical iPhone is estimated to house around 0.034g of gold, 0.34g of silver, 0.015g of palladium and less than one-thousandth of a gram of platinum. It also contains the less valuable but still significant aluminium (25g) and copper (around 15g).



## La réalisation ##

Il s'agit de mettre en oeuvre un site web qui permet à un client
de suivre ses interactions avec l'entreprise.

Ainsi, le client peut suivre la *cagnotte* qu'il possède en fonction du nombre
et du reconditionnement des objets usagers qu'il a confié à l'entreprise.
Cette cagnotte représente un avoir sur ses achats futurs via l'entreprise que
ce soit pour des objets neufs (par exemple, un fairphone) ou reconditionnés.

Le client peut ainsi vendre des objets ou en acheter.

Le site permet d'afficher d'autre critères que seulement le prix de l'objet à acheter, 
ou son prix de vente, en particulier, le site doit permettre de réduire la distance de 
transport pour faciliter l'économie locale et solidaire.


## Existant ##

Une base de données.

##  À Faire ##

À partir d'un cahier des charges précis, mise en oeuvre du site revenant sur les aspects du premier semestre (HTML) mais surtout ceux
vu au second semestre (programmation côté serveur avec PHP / connexion avec la BdD).

Il faudra aussi essayer de rendre le site sécurisé (login, session, évitre les injections sql) et le rendre ergonomique (mise en forme avec un framework CSS nativement réactif W3 CSS).


## Éléments de la notation ##

Il s'agit d'un travail propre à chaque groupe, vous ne devez en aucun cas plagier.

L'équipe enseignante se réserve le droit d'organiser une soutenance et de donner des notes différentes aux membres du groupe.

Votre projet doit être disponible sur git sous forme d'un repo privé avec comme nom *BUT1-SAE-2.02-x-y-z* 
où x, y et z sont les noms des membres du projet. Vous devez donner accès à tous les enseignants intervenant dans la matière.
Pour Fontainebleau : Luc Dartois, Florent Madelaine et Denis Monnerat
Pour Sénart : Luc Dartois et William Gaudelier.

La racine de votre dossier comporte un fichier readme.md avec les prénoms et noms des membres du groupe.
Votre projet sera en ligne sur le site de l'IUT d'un des membres du groupe dont l'url sera dans ce readme.
Il conviendra de vérifier que vous avez bien géré les droits d'accès pour que n'importe qui (dont les correcteurs) puissent y avoir accès.

La racine de votre dossier comporte un fichier rapport.md, qui est un rapport au format markdown expliquant votre travail technique, ce qui a marché, ce qui n'a pas marché et mettant en avant une ou des réalisation particulièrement réussies. Vous terminer par une conclusion individuelle puis par une conclusion collective. Il ne s'agit pas d'un rapport extensif (3 ou 4 pages suffisent).

En annexe du rapport, il conviendra de lister très précisément des cas de tests illustrant le bon fonctionnement de votre site.

Une seconde annexe du rapport, par exemple sous forme d'une ou plusieurs diagrammes svg ou d'une ou de photos avec une bonne résolution, il faudra donner le wireflow de votre projet.
(il est toléré que votre livrable final soit différent de votre wireflow initial, en prenant soin d'expliquer dans le rapport pourquoi il y a cette différence, par exemple partie non effectuée, partie améliorée etc).

Nous vous invitons à utiliser trello ou un outil similaire de suivi de projet pour vous organiser.

La racine de votre dossier comportera un dossier source/ dans lequel il y aura une copie de votre site.
Le code sera indenté au mieux et commenté.

### Notation indicative pour la partie technique ###
 
* (2 pts) page du client indiquant son login, sa cagnotte et le métal récupéré par la vente de ces objets.
* (6 pts) page de vente, permettant au client de chercher l'objet qu'il souhaite vendre, de trouver si une entreprise souhaite l'acheter, de choisir si possible une telle entreprise et de mettre à jour les données.
* (4 pts) page d'achat, permettant au client d'acheter un objet.
* (2 pts) gestion de la connexion du client au site.
* (2 pts) gestion de la session du client.
* (2 pts) front-end, réactivité du site et ergonomie des pages (utilisation de W3 CSS).
* (2 pts) évolution de la base de données et du site pour permettre un suivi plus fin des actions du clients (historique achat et vente du client et évolution de sa cagnotte).

### Notation indicative pour le reste ###
* suivi des consignes (malus plus ou moins importants)
* (5 pts) clarté du plan et de la forme du rapport 
* (5 pts) contenu du rapport 
* (5 pts) wireflow
* (5 pts) cas de tests

### jalons indicatifs pour les livrables ###

1. wireflow (2 semaines)
2. page du client (2 semaines)
3. esquisse du rapport (2 semaines)
3. page de vente (4 semaines)
4. connexion et session (4 semaines)
5. front-end (à faire en dernier)


## Détails BdD ##

Une bonne partie de la base de données est fournie.

Il y a une table pour les entreprises (Business)
une table pour les clients (Customer) 
et une table pour les objets qui peuvent être échangés (TypeItem).

Il y a une table contenant des détails sur les objets (TypeItemDetails) 
et une table contenant des donnes personnelles des clients (CustomerProtectedData).

Les objets peuvent être retraités pour en extraire des éléments, en particulier des métaux. La table Mendeleiev détaille les éléments. La table ExtractionFromTypeItem indique la quantité en mg de chaque élément qu'on peut espérer extraire d'un objet.

Les entreprises peuvent soit être à la recherche d'un objet (BusinessBuy) ou en vendre (BusinessSell).

Pour chaque client, on stocke les éléments extraits des objets qu'ils ont vendu (CustomerExtraction).

## Présentation de chaque page ##

Toutes les pages sont en PHP et vont reprendre la même structure en incluant des squelettes.
* squelette de header (metadonnées adaptées, titre, etc)
* squelette de menu ou autre ingrédient de navigation 
* squelettre de footer (pas sûr que ce soit nécessaire).

Au préalable le haut de chaque page PHP va définir un certain nombre de variables, dont celles qui sont utilisées par les squelettes ci-dessus.

À terme il conviendra d'ajouter du W3 CSS pour donner un front-end intéressant.
Cette partie n'est pas prioritaire! 
(regardez attentivement le barème indicatif).

## Autres Fonctionalités ##

### Retraitement ou reconditionnement###
Pour l'instant je suis parti sur un retraitement intégral de l'objet.
En pratique, il y a
1. retraitement, génération de composants, extraction d'éléments dont des métaux.
2. reconditionnement avec ajout éventuel de poèce neuve puis revente

Vous pourriez faire en sorte de gérer ces deux cas.

* cas 2. pas d'information en plus de remis sur le circuit.
* cas 1. information sur composants/métaux récupérés dans l'esprit de ce qui est fait actuellement.


### import massif de données ###
Vous pourriez ajouter une page spéciale (backend) permettant d'ajouter des données dans la base.
Par exemple des objets avec ces composants et l'extraction qu'on pourrait en faire.
On peut envisager que ce soit par téléversement d'un fichier csv ou json.
Évidemment cette page serait protégée par mot de passe.
