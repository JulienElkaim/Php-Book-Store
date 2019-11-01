<?php

// --------------------------------------------------------------------------------------------------------------------------
// Se connecte à la DB
// Paramètres : nom de la base -> $name_DB
function connexion_DB($name_DB) {
// Déclaration des paramètres de connexion
	$host = "localhost";  
	$user = "root";
	$bdd = $name_DB;
	$passwd  = "";
// Connexion au serveur
	mysql_connect($host, $user,$passwd) or die("erreur de connexion au serveur");
	mysql_select_db($bdd) or die("erreur de connexion a la base de donnees");
}

// --------------------------------------------------------------------------------------------------------------------------
// Deconnection de la DB
function deconnexion_DB() {
	mysql_close();
}

// --------------------------------------------------------------------------------------------------------------------------
// Exécute une requète SQL. Si la requête ne passe pas, renvoir le message d'erreur MySQL
// Paramètres : chaine SQL -> $strSQL
// Renvoie : enregistrements correspondants -> $result
function requete_SQL($strSQL) {
	$result = mysql_query($strSQL);
	if (!$result) {
		$message  = 'Erreur SQL : ' . mysql_error() . "<br>\n";
		$message .= 'SQL string : ' . $strSQL . "<br>\n";
		$message .= "Merci d'envoyer ce message au webmaster";
		die($message);
	}
	return $result;
}

// --------------------------------------------------------------------------------------------------------------------------
// Récupère les informations de la page concernée
function extraction_infos_DB() {
	$strSQL = 'SELECT * FROM `pages` WHERE `Id_page` = '.$_ENV['id_page'];
	$resultat = requete_SQL($strSQL);
	$tabl_result = mysql_fetch_array($resultat);
	$_ENV['mots_cles'] = $tabl_result['Mots_cles'];
	$_ENV['description'] = $tabl_result['Description'];
	$_ENV['titre'] = $tabl_result['Titre'];
	$_ENV['contenu'] = $tabl_result['Contenu'];
	$_ENV['id_parent'] = $tabl_result['Id_parent'];
}


// --------------------------------------------------------------------------------------------------------------------------
// Affiche le chemin de fer.
// Paramètres : id de la page en cours -> $idpage
// Renvoie : chemin complet -> $chemin_complet
function affiche_chemin_fer($idpage) {
	// on définit la variable pour éviter le warning
	$chemin_complet = "";
	// Si l'id de la page en cours est différent de 0 
	// (0 = page parente de la page racine = inexistante)
	if ($idpage != 0) {
		// on récupère les informations de la page en cours dans la DB
		$strSQL = 'SELECT `Titre`, `Id_parent` FROM `pages` WHERE `Id_page` = '.$idpage;
		$resultat = requete_SQL($strSQL);
		$tabl_result = mysql_fetch_array($resultat);
		
		$titrepage = $tabl_result['Titre'];
		$idparent = $tabl_result['Id_parent'];
		
		// création du lien vers la page en cours
		$chemin_page_en_cours = ' -> <a href="index.php?id_page='.$idpage.'">'.$titrepage.'</a>';
		
		// Concaténation du lien de la page N-1 et
		// du lien de la page en cours
		$chemin_complet = affiche_chemin_fer($idparent).$chemin_page_en_cours;
	}
	// renvoie le chemin complet
	return $chemin_complet;
}

// --------------------------------------------------------------------------------------------------------------------------
// Affiche les menus.
// Paramètres : id de la page -> $idpage 
// (id de la page en cours pour le menu de gauche, id de la page racine (1) pour le menu du haut)
// Renvoie : le menu sous forme de liste -> $menu_retour
function affiche_menu($idpage) {
	// Sélectionne toutes les pages filles de la page en cours
	$strSQL = 'SELECT `Id_page`, `Titre` FROM `pages` WHERE `Id_parent` = '.$idpage;
	$resultat = requete_SQL($strSQL);
	// Si la page n'a pas de page fille, alors on modifie la requète pour obtenir ses pages soeurs.
	if (mysql_num_rows($resultat) == 0) {
		$strSQL = 'SELECT `Id_page`, `Titre` FROM `pages` WHERE `Id_parent` = '.$_ENV['id_parent'];
		$resultat = requete_SQL($strSQL);
	}
	$menu_retour = '<ul>';
	while ($tabl_result = mysql_fetch_array($resultat)) {
		$menu_retour .= '<li>';
		$menu_retour .= '<a href="index.php?id_page='.$tabl_result['Id_page'].'">';
		$menu_retour .= $tabl_result['Titre'];
		$menu_retour .= '</a>';
		$menu_retour .= '</li>';
	}
	$menu_retour .= '</ul>';
	return $menu_retour;
}

?>