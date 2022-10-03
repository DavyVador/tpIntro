Question 1 : Qu'est ce que le dossier vendor ? 
    - Le dossier vendor contient toutes les librairies nécessaires au projet. (contient les sources de bundles tiers et de Symfony).

Question 2 : En examinant le contenu des fichiers et en cherchant sur le site de Symfony, expliquer l’utilité du dossier public/.
    - Le dossier public contient tout ce qui va être chargé par le navigateur (CSS, Javascript, images...). On y trouves également le fichier index.php.

Question 3 : Quel fichier dois-je modifier pour configurer les identifiants de bases de données afin que Symfony puisse accéder à la Base de données ?
 - Nous devons modifier le fichier .env pour configurer les identifiants de base de données.
 - avec .env.local, cela nous permet de travailler en local avec la base de donnée.
 - avec .env.prod, cela permet de publier le site sur le web.

Question 4 : Comment fait-on le lien entre une route (URL) de l’application et une action d’un contrôleur ?
    - Pour lier l'URL et l'application, il suffit de configurer sa route dans le contrôleur: (exemple:  #[Route("/helloRandom")]);

Question 5 : A quoi sert le fichier composer.json qui se trouve à la racine du projet ?
- Il appelle les dépendances dont le projet a besoin (ex.: phpUnit, twig...).

Questions 6 : Dans la classe de test HelloControllerTest expliquer ce que fait la méthode testHelloRandomRoute.
- La méthode testHelloRandomRoute() contient plusieurs fonctions, elle initialise une page web ou la fonction HelloRandom sera testée dans le fichier HelloController ou les erreurs seront signalées.

Question 7 : Dans la classe de test HelloControllerTest expliquer ce que fait la méthode testRandomNameGenerator.
- Dans La méthode testRandomNameGenerator, la méthode initialise une première variable qui lie le HelloController avec la fonction.
- La seconde variable vérifie que le nombre de lettres est supérieur à 1.
