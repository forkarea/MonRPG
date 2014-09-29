<?php

defined( 'SYSPATH' ) OR die( 'No direct access allowed.' );

$config['version'] = '1.0.9'; //Version de votre jeu

$config['name'] = 'Créer mon jeu'; //Nom de votre jeu

$config['debug'] = FALSE; //Afficher la partie debug

$config['cache'] = FALSE; //Activer ou non le cache

$config['money'] = '$'; // money du jeu

$config['id_article_preambule'] = 67; //Article par defaut qui presente le jeu tout au début - Si FALSE, il n'y aura pas de préambule

$config['initialPosition'] = array( 'x' => 6, 'y' => 6, 'region' => 5 ); //position initial lors de la création d'un joueur

$config['initialArgent'] = 1000; //Argent que le joueur possède lors de son initialisation

$config['initialAvatar'] = 'default.png'; //Avatar que le joueur possède lors de son initialisation

$config['initialHP'] = 100; //HP que le joueur possède lors de son initialisation (ATTENTION la valeur vaut pour le max hp et la valeur de celui du joueur (100% au final))

$config['initialMP'] = 10; //MP que le joueur possède lors de son initialisation (ATTENTION la valeur vaut pour le max hp et la valeur de celui du joueur (100% au final))

$config['description'] = '<h2>Un éditeur de MMORPG en ligne</h2><p>Bienvenue sur l\'éditeur de jeux <strong>Mon RPG</strong>, vous avez toujours rêvé de faire votre jeu multijoueurs sans aucune connaissance en programmation ?</p><p><strong>Mon RPG</strong> possède des outils intuitifs et très simples à prendre en mains. De nombreuses ressources vous sont également proposés afin que vous puissiez créer le jeu de vos rêves. De nombreux modules en constantes évolutions vous sont accèssible dans la partie administration pour vous permettre de proposé à vos joueurs une expérience de jeu riche et unique.<p>'; //Description du jeu
?>