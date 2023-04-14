<?php

// On déconnecte l'utilisateur
Session::logout();

// On le redirige vers l'accueil
header('Location: ' . buildUrl('home'));

exit;