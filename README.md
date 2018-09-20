# Piscine-2018

  Bienvenue jeune developpeur !  à la fin de ce readme tu comprendras qu'il y a du boulot mais que tout va bien se passer :)
  
Evidemment vu qu'il y aura des questions et que notre note en dépend: je frapperai ceux qui ne répondront pas correctement à mes questions dans 1-2 mois.

ps: **je frappe fort** mais étant donné que c'est coefficient 3 cette année **je frapperai donc 3 fois plus fort.**

# O) Avancement du projet
##### 0%
   - [ ] : Lire ce ReadMe et poser des questions.
   - [ ] : installer les outils qui nous permettrons de developper un site RÉ-VO-LU-TIO-NAIRE.
   - [ ] : Avoir un MCD validé.
   - [x] : Trouver les technologies à utiliser (Laravel/MySQL/Heroku).
   - [ ] : créer la base de données.
   - [ ] : Respecter les regles de conventions de PHP.
##### 5%
- [ ] : Faire un bon MVC des familles avec Laravel.
  Mais aussi:
  - [ ] : des commentaires.
  - [ ] : des objets.
  - [ ] : des variables explicites.
  - [ ] : un minimum de sécurité.
  - [ ] : un site scalable.
  - [ ] : un site responsive.
##### 50%
   - [ ] : Discuter de notre site avec les clients et faire les modifications qu'ils desirent.
   - [ ] : Offrir un café aux clients pour obtenir un mail.
##### 65%
   - [ ] : un site totalement responsive.
##### 70%
   - [ ] : Héberger le site.
   - [ ] : Corriger toutes les erreurs suite à l'hebergement.
##### 95%
   - [ ] : Préparer la présentation du 8 janvier.
##### 97%
   - [ ] : Réviser pour le quizz de Mr Fiorio.
   - [ ] : Frapper ceux qui répondent mal.
##### 100%
  
# I) Composer :
*Laravel* utilise des composants d'autres sources, plutot que de le faire manuellement, *Laravel* utilise
un **gestionnaire de dépendance**(:*Composer*) qui nous épargne :
  - de telecharger les composants
  - traquer les éventuels conflits de nommage entre les librairies,
  - mettre à jour manuellement les librairies quand c'est nécessaire,
  - prévoir le code pour charger les classes à utiliser
		
  ##### lien pour le télécharger Composer : https://getcomposer.org/download/


# II) Laragon : pour creer son environement de developpement pour le web (windows) 
  
 **Avantage** : permet d'installer tous les outils dont on peut avoir besoin en une seule fois	
	
 #### Il utilise:
 - **Apache**  => Un serveur web c'est à dire un « simple » logiciel capable d'interpréter les requêtes HTTP arrivant sur le port associ au protocole HTTP (par défaut le port 80), et de fournir une réponse avec ce même protocole. 
 - **MySQL**   => un système de gestion de bases de données relationnelles
 - **PhP 7.2** => PHP(**Hypertext Preprocessor**) est un langage de scripts généraliste orienté OBJET spécialement conçu pour le développement d'applications web
  ###### /!\ PHP est un langage synchrone (on peut utilisé ReactPHP pour le rendre asynchrone)

  #####  lien pour telecharger *Laragon* : https://sourceforge.net/projects/laragon/files/releases/3.2/laragon-wamp.exe/download	

#### Aide pour l'utilisation :
1. une fois *Laragon* ouvert on clique sur "tout démarrer"
2. on doit ensuite avoir récupérer sur *gitHub* la version *Laravel* du fichier(vous pourrez sauter l'étape 3) ou le faire soit meme           indiqué dans l'étape d'apres
3. pour créer son projet laravel on utilisera dans l'invite de commande 
		 verifiez que votre invite de commande est dans le fichier "www" de Laragon C:\laragon\www puis entrez la commande suivante :
			"composer create-project --prefer-dist laravel/laravel Piscine"
4. Dans l'executable Laragon, cliquez sur "Web"
5. specifiez l'url du dossier "Piscine/Public" de notre projet comme ceci dans l'url : http://localhost/piscine/public/
- pourquoi public ? car c'est dans ce dossier que Laravel contient le fichier index.php 
- wtf index.php ? c'est le premier fichier php que notre site utilisera par defaut 

# III) Laravel : Compréhension des différents dossiers.
		
  On va essayer de découvrir l'utilité de chacun des dossiers qui composent ce framework:
	
  il existe une page magnifique pour cela : 
		https://www.formation-laravel.fr/articles/decouverte/2017-11-04-explications-sur-les-fichiers-et-les-dossiers-de-laravel.html
		
# IV) Les règles pour coder 
	
- Commenter son code, expliquer le role d'une fonction, la technique utilisée, l'idée qu'on voulait 	appliquer.
- Les noms de classes doivent être écrits en StudlyCaps. (regle de PSR-1)
- Les constantes s’écrivent en majuscule. (regle de PSR-1)
- Les méthodes s’écrivent en camelCase. (regle de PSR-1)
- bref tout ce qui est PSR-0 PSR-1 PSR-2 etc


# V) Utiliser GitHub:

  #### 1) les bases avant de se servir de GitHub	

- Git est un formidable outil qui permet à une équipe de travailler ensemble.
	##### (Attention il faut différencier github qui est un site web de stockage de donnée utilisant l’outil git)
- GitHub créer une version de ton travail et te permet à n’importe quel moment de revenir en arrière à une 		version précédente ce qui nous sauvera plusieurs fois je pense.
- Github facilite également le travail en groupe, car il permet à plusieurs personnes de travailler plus 		facilement sur un même projet grâce à son système de branche.
- Contexte : Je travail sur la page principale d’une application et mon collègue travail sur une popup qui doit apparaître quand on clique sur un bouton de ma page, il va donc créer une branche et donc à un moment X il ne reçoit plus mes mises à jour sur la page principale et peut travailler sur sa popup sans être embêté par des conflits qui pourrait intervenir avec mes modifications. Ainsi quand son travail est terminé nous pouvons effectuer un *MERGE* (fusionner nos branches) ensemble afin de résoudre tout conflit qui pourrait avoir lieu.

#### 2) push/pull manuellement c'est pour les fragiles vive GitHub Desktop :

  On utilisera le logiciel **GitHub Desktop** il suffira de lui donner les identifiants de ton compte GitHub pour qu'il fasse tout le boulot pour envoyer nos modifications dans notre repository commun
	


# VI) Bootstrap
   A suivre...


ps : n'oublie pas que je frappe **très fort**
