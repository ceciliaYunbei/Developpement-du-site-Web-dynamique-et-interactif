<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
                      "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<!-- html -->
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>  
        <title>Oscars</title>
        <!-- meta-données -->
        <meta http-equiv= "content-type" content="text/html; charset=utf-8"/>
        <meta name="auteur" content="Yunbei"/>
        <meta name="description" content="projet-xhtml"/>
        <meta name="keyword" content="xhtml,inalco,projet"/>
    </head>
    <body>
    	<!--  css -->
		<style type="text/css">
			#table_annee_oscar table {
				width:100%;
				margin:15px 0;
				border:0;
			}
			table th {
				font-weight:bold;
				background-color:#e4f4fd;
				color:#44b2f7
			}
			#table_film {
				font-family: "Optima", "Arial";
				font-size:0.95em;
				text-align:left;
				padding:4px;
				border-collapse:collapse;
			}
			table th {
				border: 1px solid #e0e0eb;
				border-width:1px
			}
			table td {
				border: 1px solid #e0e0eb;
				border-width:1px
			}
			table tr {
				border: 1px solid #ffffff;
			}
			table tr:nth-child(odd){
				background-color:#f7f7f7;
			}
			table tr:nth-child(even){
				background-color:#ffffff;
			}
		</style>
	</body>
</html>

<?php
$dbms='mysql';  //type de database
$serveur='localhost'; // nom de serveur
$bd='Oscars'; // nom de database
$user='root'; // nom d'utilisateur connnect2
$pass='root'; //mdp
try {
    $sql = new PDO('mysql:host='.$serveur.';dbname='.$bd, $user, $pass, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8")) ; // initiation un objet PDO, connexion a la database
    //echo "connection réussite<br/><br/>";
}

catch(PDOException $e) {
     echo "Erreur de connexion à la base de données " . $e->getMessage();
     die();
}



// 			##################### Recherche par annee d'Oscars ######################




// si le name de <input> est "rechercher1" 
if(isset($_GET["rechercher1"])) {
	// récupérer value de <option> dans un <select> qui est pour name "annee_oscar"
	$val = $_GET["annee_oscar"];
	// si value de <option> = "Année d'obtention d'Oscars"
	if ($val == "Année d'obtention d'Oscars"){
		// message d'alerte
		echo "<script language=\"javascript\">alert(\"Veuillez choisir un item !\");location.replace(\"recherche.html\");</script>";
	}
	// definition de requete
	// requete des infos de films avec award_year=:val de table oscars_films et faire la jointure avec la table films_info,
	$req1 = $sql->prepare("SELECT * FROM oscars_films INNER JOIN films_info ON oscars_films.id_film=films_info.id_film WHERE award_year = :val");
	// définition des paramètres 
	$req1->bindParam(':val', $val);
	// Exécution de la requête
	$resultat1 = $req1->execute();
	// compte le nombre de résultats renvoyés
	$compteur = $req1->rowCount();
	//  s'il y a aucun résultat qui concerne la requete
	if (empty($compteur)){
		echo "<script language=\"javascript\">alert(\"Le film que vous cherchez n'existe pas !\");location.replace(\"recherche.html\");</script>";
	}
	
	// écrire une entete de tableau html 
	echo "<div id='table_film'>
			<table border='1' style='width:100%'>
				<tr>
					<th>Année d'Oscars</th>
    				<th>Identifiant du film</th>
    				<th>Titre du film</th>
    				<th>Nombre d'Oscars obtenus</th> 
    				<th>Type_oscars_obtenus</th>
    				<th>Année de sortie</th>
    				<th>Pays</th>
    				<th>Catégorie</th>
    				<th>Directeurs</th>
    				<th>Acteurs</th>
    				<th>Résumé</th>
  				</tr>";
  	// Récupération des résultats
	while($row = $req1->fetch(PDO::FETCH_OBJ)) {
		// écrit dans le tableau html
		echo "<tr>
					<td>".$row->award_year."</td>
  					<td>".$row->id_film."</td>
  					<td>".$row->title."</td>
  					<td>".$row->nb_oscars_obtained."</td>
  					<td>".$row->type_oscars_obtained."</td>
  					<td>".$row->release_year."</td>
  					<td>".$row->country."</td>
  					<td>".$row->category."</td>
  					<td>".$row->directors."</td>
  					<td>".$row->actors."</td>
  					<td>".$row->plot."</td>
  				</tr>";
	}
	echo "</table></div>";
}



// 			##################### recherche par le type d'Oscars obtenus  ##############




// si le name de <input> est "rechercher2"
if(isset($_GET["rechercher2"])) {
	// récupérer value de option dans un <select> qui est pour name "type_oscar"
	$rechlettre= $_GET["type_oscar"];
	if ($rechlettre == "tous_type_oscar"){
		echo "<script language=\"javascript\">alert(\"Veuillez choisir un item !\");location.replace(\"recherche.html\");</script>";
	}
	$rechlettre = "%".$rechlettre."%";
	// si dans colonne type_oscars_obtained contient le motif, selectionne tous de oscars_films et faire la jointure à films_info
	$req2 = $sql->prepare("SELECT * FROM oscars_films INNER JOIN films_info ON oscars_films.id_film=films_info.id_film WHERE type_oscars_obtained LIKE :rechlettre");
	$req2->bindParam(':rechlettre', $rechlettre);
	$resultat2 = $req2->execute();
	// compte le nombre de résultats renvoyés
	$compteur = $req2->rowCount();
	//  s'il y a aucun résultat qui concerne la requete
	if (empty($compteur)){
		echo "<script language=\"javascript\">alert(\"Le film que vous cherchez n'existe pas !\");location.replace(\"recherche.html\");</script>";
	}

	echo "<div id='table_film'>
			<table border='1' style='width:100%'>
				<tr>
    				<th>Année d'Oscars</th>
    				<th>Identifiant du film</th>
    				<th>Titre du film</th>
    				<th>Nombre d'Oscars obtenus</th> 
    				<th>Type_oscars_obtenus</th>
    				<th>Année de sortie</th>
    				<th>Pays</th>
    				<th>Catégorie</th>
    				<th>Directeurs</th>
    				<th>Acteurs</th>
    				<th>Résumé</th>
  				</tr>";
	while($row2 = $req2->fetch(PDO::FETCH_OBJ)) {
		echo "<tr>
					<td>".$row2->award_year."</td>
					<td>".$row2->id_film."</td>
					<td>".$row2->title."</td>
					<td>".$row2->nb_oscars_obtained."</td>
					<td>".$row2->type_oscars_obtained."</td>
					<td>".$row2->release_year."</td>
					<td>".$row2->country."</td>
					<td>".$row2->category."</td>
					<td>".$row2->directors."</td>
					<td>".$row2->actors."</td>
					<td>".$row2->plot."</td>
				</tr>";
	}
	echo "</table></div>";
}



/// 	#####################  recherche par le nb d'Oscars obtenues ##################### 




if(isset($_GET["rechercher3"])) {
	// récupérer value de option dans un <select> qui est pour name "nb_oscar"
	$val1 = $_GET["nb_oscar"];
	// si value de <option> est "1"
	if ($val1 == "1"){
		// chercher des films ayant obtenu 5 ou plus d'oscars
		$req3 = $sql->prepare("SELECT * FROM oscars_films INNER JOIN films_info ON oscars_films.id_film=films_info.id_film WHERE nb_oscars_obtained >=5 ORDER BY nb_oscars_obtained DESC");
	}
	// si value de <option> est "2"
	elseif ($val1 == "2"){
		// extrait des films ayant obtenu <5 d oscars
		$req3 = $sql->prepare("SELECT * FROM oscars_films INNER JOIN films_info ON oscars_films.id_film=films_info.id_film WHERE nb_oscars_obtained <5 ORDER BY nb_oscars_obtained DESC");
	}
	// alerte
	else{
		echo "<script language=\"javascript\">alert(\"Veuillez choisir un item !\");location.replace(\"recherche.html\");</script>";
	}
	$req3->bindParam(':val1', $val1);
	$resultat3 = $req3->execute();
	// compte le nombre de résultats renvoyés
	$compteur = $req3->rowCount();
	//  s'il y a aucun résultat qui concerne la requete
	if (empty($compteur)){
		echo "<script language=\"javascript\">alert(\"Le film que vous cherchez n'existe pas !\");location.replace(\"recherche.html\");</script>";
	}

	echo "<div id='table_film'>
			<table border='1' style='width:100%'>
				<tr>
					<th>Année d'Oscars</th>
    				<th>Identifiant du film</th>
    				<th>Titre du film</th>
    				<th>Nombre d'Oscars obtenus</th> 
    				<th>Type_oscars_obtenus</th>
    				<th>Année de sortie</th>
    				<th>Pays</th>
    				<th>Catégorie</th>
    				<th>Directeurs</th>
    				<th>Acteurs</th>
    				<th>Résumé</th>
  				</tr>";
	while($row3 = $req3->fetch(PDO::FETCH_OBJ)) {
		echo "<tr>
  					<td>".$row3->award_year."</td>
  					<td>".$row3->id_film."</td>
  					<td>".$row3->title."</td>
  					<td>".$row3->nb_oscars_obtained."</td>
  					<td>".$row3->type_oscars_obtained."</td>
  					<td>".$row3->release_year."</td>
  					<td>".$row3->country."</td>
  					<td>".$row3->category."</td>
  					<td>".$row3->directors."</td>
  					<td>".$row3->actors."</td>
  					<td>".$row3->plot."</td>
  				</tr>";
	}
	echo "</table></div>";
}



/// 	#####################   recherche par annee de sortie du film #####################




if(isset($_GET["rechercher4"])) {
	// récupérer value de option dans un <select> qui est pour name "annee_film"
	$val = $_GET["annee_film"];
	if ($val == "tous_ans_film"){
		echo "<script language=\"javascript\">alert(\"Veuillez choisir un item !\");location.replace(\"recherche.html\");</script>";
	}
	// requete des infos de films avec release_year=:val de table oscars_films et faire la jointure avec la table films_info
	$req4 = $sql->prepare("SELECT * FROM films_info INNER JOIN oscars_films ON films_info.id_film=oscars_films.id_film WHERE release_year = :val");

	$req4->bindParam(':val', $val);
	$resultat4 = $req4->execute();
	// compte le nombre de résultats renvoyés
	$compteur = $req4->rowCount();
	//  s'il y a aucun résultat qui concerne la requete
	if (empty($compteur)){
		echo "<script language=\"javascript\">alert(\"Le film que vous cherchez n'existe pas !\");location.replace(\"recherche.html\");</script>";
	}


	echo "<div id='table_film'>
			<table border='1' style='width:100%'>
				<tr>
					<th>Année d'Oscars</th>
    				<th>Identifiant du film</th>
    				<th>Titre du film</th>
    				<th>Nombre d'Oscars obtenus</th> 
    				<th>Type_oscars_obtenus</th>
    				<th>Année de sortie</th>
    				<th>Pays</th>
    				<th>Catégorie</th>
    				<th>Directeurs</th>
    				<th>Acteurs</th>
    				<th>Résumé</th>
  				</tr>";
	while($row4 = $req4->fetch(PDO::FETCH_OBJ)) {
		echo "<tr>
					<td>".$row4->award_year."</td>
  					<td>".$row4->id_film."</td>
  					<td>".$row4->title."</td>
  					<td>".$row4->nb_oscars_obtained."</td>
  					<td>".$row4->type_oscars_obtained."</td>
  					<td>".$row4->release_year."</td>
  					<td>".$row4->country."</td>
  					<td>".$row4->category."</td>
  					<td>".$row4->directors."</td>
  					<td>".$row4->actors."</td>
  					<td>".$row4->plot."</td>
  				</tr>";
	}
	echo "</table></div>";
}



/// 			#####################  recherche par le pays d'origine ##################### 




if(isset($_GET["rechercher5"])) {
	// récupérer value de option dans un <select> qui est pour name "pays"
	$val= $_GET["pays"];
	if ($val == "tous_les_pays"){
		echo "<script language=\"javascript\">alert(\"Veuillez choisir un item !\");location.replace(\"recherche.html\");</script>";
	}
	$val = "%".$val."%";
	// extrait les infos de film si le motif est present dans sa liste de pays sortie de table films_info en lien la table oscars_films
	$req5 = $sql->prepare("SELECT * FROM films_info INNER JOIN oscars_films ON films_info.id_film=oscars_films.id_film WHERE country LIKE :val");
	$req5->bindParam(':val', $val);
	$resultat5 = $req5->execute();
	// compte le nombre de résultats renvoyés
	$compteur = $req5->rowCount();
	//  s'il y a aucun résultat qui concerne la requete
	if (empty($compteur)){
		echo "<script language=\"javascript\">alert(\"Le film que vous cherchez n'existe pas !\");location.replace(\"recherche.html\");</script>";
	}

	echo "<div id='table_film'>
			<table border='1' style='width:100%'>
				<tr>
					<th>Année d'Oscars</th>
    				<th>Identifiant du film</th>
    				<th>Titre du film</th>
    				<th>Nombre d'Oscars obtenus</th> 
    				<th>Type_oscars_obtenus</th>
    				<th>Année de sortie</th>
    				<th>Pays</th>
    				<th>Catégorie</th>
    				<th>Directeurs</th>
    				<th>Acteurs</th>
    				<th>Résumé</th>
  				</tr>";
	while($row5 = $req5->fetch(PDO::FETCH_OBJ)) {
		echo "<tr>
					<td>".$row5->award_year."</td>
  					<td>".$row5->id_film."</td>
  					<td>".$row5->title."</td>
  					<td>".$row5->nb_oscars_obtained."</td>
  					<td>".$row5->type_oscars_obtained."</td>
  					<td>".$row5->release_year."</td>
  					<td>".$row5->country."</td>
  					<td>".$row5->category."</td>
  					<td>".$row5->directors."</td>
  					<td>".$row5->actors."</td>
  					<td>".$row5->plot."</td>
  				</tr>";
	}
	echo "</table></div>";
}




/// 		#####################  recherche par tous les criteres choisis ##################### 




if(isset($_GET["rechercher6"])) {
	$val_1 = $_GET["annee_oscar"];
	$val_2= $_GET["type_oscar"];
	$val_3 = $_GET["nb_oscar"];
	$val_4 = $_GET["annee_film"];
	$val_5 = $_GET["pays"];

	// il faut selectionner une valeur pour tous les menus deroulants, sinon alerte
	if($val_1 == "Année d'obtention d'Oscars" || $val_2 == "tous_type_oscar" || $val_3 == "tous_nb_oscar" || $val_4 == "tous_ans_film" || $val_5 == "tous_les_pays"){
		echo "<script language=\"javascript\">alert(\"Veuillez remplir tous les champs !\");location.replace(\"recherche.html\");</script>";
	}

	$val_2 = "%".$val_2."%";
	// condition :  nb oscars >=5, type_oscars_obtained contient le motif val_2, award_year = val_1, release_year = val_4, country =val_5
	if ($val_3 == "1"){
	$req6 = $sql->prepare("SELECT * FROM films_info INNER JOIN oscars_films ON films_info.id_film=oscars_films.id_film WHERE type_oscars_obtained LIKE :val_2 and award_year=:val_1 and release_year=:val_4 and country=:val_5 and nb_oscars_obtained >=5");
	}
	elseif ($val_3 == "2"){
	$req6 = $sql->prepare("SELECT * FROM films_info INNER JOIN oscars_films ON films_info.id_film=oscars_films.id_film WHERE type_oscars_obtained LIKE :val_2 and award_year=:val_1 and release_year=:val_4 and country=:val_5 and nb_oscars_obtained <5");
	}

	else{
		$req6 = $sql->prepare("SELECT * FROM films_info INNER JOIN oscars_films ON films_info.id_film=oscars_films.id_film WHERE type_oscars_obtained LIKE :val_2 and award_year=:val_1 and release_year=:val_4 and country=:val_5 and nb_oscars_obtained=:val_3");
	}

	$req6->bindParam(':val_1', $val_1);
	$req6->bindParam(':val_2', $val_2);
	$req6->bindParam(':val_4', $val_4);
	$req6->bindParam(':val_5', $val_5);

	$resultat6 = $req6->execute();
	$compteur = $req6->rowCount();
	// si $compteur est non null
	if($compteur){
		echo "<div id='table_film'>
				<table border='1' style='width:100%'>
					<tr>
						<th>Année d'Oscars</th>
	    				<th>Identifiant du film</th>
	    				<th>Titre du film</th>
	    				<th>Nombre d'Oscars obtenus</th> 
	    				<th>Type_oscars_obtenus</th>
	    				<th>Année de sortie</th>
	    				<th>Pays</th>
	    				<th>Catégorie</th>
	    				<th>Directeurs</th>
	    				<th>Acteurs</th>
	    				<th>Résumé</th>
	  				</tr>";

		while($row6 = $req6->fetch(PDO::FETCH_OBJ)) {
			echo "<tr>
						<td>".$row6->award_year."</td>
	  					<td>".$row6->id_film."</td>
	  					<td>".$row6->title."</td>
	  					<td>".$row6->nb_oscars_obtained."</td>
	  					<td>".$row6->type_oscars_obtained."</td>
	  					<td>".$row6->release_year."</td>
	  					<td>".$row6->country."</td>
	  					<td>".$row6->category."</td>
	  					<td>".$row6->directors."</td>
	  					<td>".$row6->actors."</td>
	  					<td>".$row6->plot."</td>
	  				</tr>";
		}
		echo "</table></div>";
	}
	else{
		// alert
		echo "<script language=\"javascript\">alert(\"Le film que vous cherchez n'existe pas !\");location.replace(\"recherche.html\");</script>";}
}



//		 		########################### supprime #########################



// si name de <input> = "supprime1"
elseif(isset($_GET["supprime1"])) {
	$val = $_GET["annee_oscar"];
	if ($val == "Année d'obtention d'Oscars"){
		echo "<script language=\"javascript\">alert(\"Veuillez choisir un item !\");location.replace(\"recherche.html\");</script>";
	}
	// si award_year = val, on supprimer la ligne de donnee dans table oscars_films
	$req = $sql->prepare("DELETE FROM oscars_films WHERE award_year = :val");
	try {
	    $req->bindParam(':val', $val);
	    $resultat = $req->execute();
	    $compteur = $req->rowCount();
		//  s'il y a aucun résultat qui concerne la requete
		if(empty($compteur)){
			echo "<script language=\"javascript\">alert(\"Le film que vous cherchez n'existe pas !\");location.replace(\"recherche.html\");</script>";
		}
	    elseif($resultat) {
	        echo "<script language=\"javascript\">alert(\"Suppression réussite !\");location.replace(\"recherche.html\");</script>";
	    }
	}
	catch( Exception $e ) {
   		echo 'Erreur de requète : ', $e->getMessage();
	}
}

// si name de <input> = "supprime2"
elseif(isset($_GET["supprime2"])) {
	$val= $_GET["type_oscar"];
	if ($val == "tous_type_oscar"){
		echo "<script language=\"javascript\">alert(\"Veuillez choisir un item !\");location.replace(\"recherche.html\");</script>";
	}
	$val = "%".$val."%";
	$req = $sql->prepare("DELETE FROM oscars_films WHERE type_oscars_obtained LIKE :val");
	try {
	    $req->bindParam(':val', $val);
	    $resultat = $req->execute();
	    $compteur = $req->rowCount();
		//  s'il y a aucun résultat qui concerne la requete
		if(empty($compteur)){
			echo "<script language=\"javascript\">alert(\"Le film que vous cherchez n'existe pas !\");location.replace(\"recherche.html\");</script>";
		}
	    elseif($resultat) {
	        echo "<script language=\"javascript\">alert(\"Suppression réussite !\");location.replace(\"recherche.html\");</script>";
	    }
	}
	catch( Exception $e ) {
   		echo 'Erreur de requète : ', $e->getMessage();
	}
}

// si name de <input> = "supprime3"
elseif(isset($_GET["supprime3"])) {
	$val = $_GET["nb_oscar"];
	if ($val == "0"){
		$req = $sql->prepare("DELETE FROM oscars_films WHERE nb_oscars_obtained <1 ORDER BY nb_oscars_obtained DESC");
	}
	if ($val == "1"){
		$req = $sql->prepare("DELETE FROM oscars_films WHERE nb_oscars_obtained >=5 ORDER BY nb_oscars_obtained DESC");
	}
	elseif ($val == "2"){
		$req = $sql->prepare("DELETE FROM oscars_films WHERE nb_oscars_obtained <5 ORDER BY nb_oscars_obtained DESC");
	}	
	else{
		echo "<script language=\"javascript\">alert(\"Veuillez choisir un item !\");location.replace(\"recherche.html\");</script>";
	}
	try {
	    $req->bindParam(':val', $val);
	    $resultat = $req->execute();
	    $compteur = $req->rowCount();
		//  s'il y a aucun résultat qui concerne la requete
		if(empty($compteur)){
			echo "<script language=\"javascript\">alert(\"Le film que vous cherchez n'existe pas !\");location.replace(\"recherche.html\");</script>";
		}
	    elseif($resultat) {
	        echo "<script language=\"javascript\">alert(\"Suppression réussite !\");location.replace(\"recherche.html\");</script>";
	    }
	}
	catch( Exception $e ) {
   		echo 'Erreur de requète : ', $e->getMessage();
	}
}

// si name de <input> = "supprime4"
elseif(isset($_GET["supprime4"])) {
	$val = $_GET["annee_film"];
	if ($val == "tous_ans_film"){
		echo "<script language=\"javascript\">alert(\"Veuillez choisir un item !\");location.replace(\"recherche.html\");</script>";
	}
	$req = $sql->prepare("DELETE FROM films_info WHERE release_year = :val");
	try {
	    $req->bindParam(':val', $val);
	    $resultat = $req->execute();
	    $compteur = $req->rowCount();
		//  s'il y a aucun résultat qui concerne la requete
		if(empty($compteur)){
			echo "<script language=\"javascript\">alert(\"Le film que vous cherchez n'existe pas !\");location.replace(\"recherche.html\");</script>";
		}
	    elseif($resultat) {
	        echo "<script language=\"javascript\">alert(\"Suppression réussite !\");location.replace(\"recherche.html\");</script>";
	    }
	}
	catch( Exception $e ) {
   		echo 'Erreur de requète : ', $e->getMessage();
	}
}

// si name de <input> = "supprime5"
elseif(isset($_GET["supprime5"])) {
	$val= $_GET["pays"];
	if ($val == "tous_les_pays"){
		echo "<script language=\"javascript\">alert(\"Veuillez choisir un item !\");location.replace(\"recherche.html\");</script>";
	}
	$val = "%".$val."%";

	$req = $sql->prepare("DELETE FROM films_info WHERE country LIKE :val");
	try {
	    $req->bindParam(':val', $val);
	    $resultat = $req->execute();
	    $compteur = $req->rowCount();
		//  s'il y a aucun résultat qui concerne la requete
		if(empty($compteur)){
			echo "<script language=\"javascript\">alert(\"Le film que vous cherchez n'existe pas !\");location.replace(\"recherche.html\");</script>";
		}
	    elseif($resultat) {
	        echo "<script language=\"javascript\">alert(\"Suppression réussite !\");location.replace(\"recherche.html\");</script>";
	    }
	}
	catch( Exception $e ) {
   		echo 'Erreur de requète : ', $e->getMessage();
	}
}


// ############################## ajouter des commentaires #############################



// si le name de <input> = "ajouter"
elseif(isset($_GET["ajouter"])) {
	// si un formulaire a un name "ajout_com", on récupère sa valeur
	$comments =$_GET["ajout_com"];
	if (!empty($comments)){
		// "ajout" est name de <input>, $ajout est name de <select>
		$ajout=$_GET["ajout"];
	}
	// si un de l'année oscars, titre du film et commentaire est vide
	if (empty($ajout)){
		echo "<script language=\"javascript\">alert(\"Vous devez sélectionner un bouton, un titre, et ajouter un commentaire !\");location.replace(\"commentaire.html\");</script>";
	}

	$key=$ajout;
	// $ket est name de <select>, $val est value de <option>
	$val=$_GET[$key];
	if ($val == "defaut"){
		echo "<script language=\"javascript\">alert(\"Veuillez choisir un titre de film !\");location.replace(\"commentaire.html\");</script>";
	}
	// inserer value de <option>, commentaire dans les colonnes id_film et comment de la table commentaire
	$req = $sql->prepare("INSERT INTO commentaire (id_film, comment) VALUES(:val, :comments)");
	try {
	    // Définition des paramètres
	    $req->bindParam(':val', $val);
	    $req->bindParam(':comments', $comments);

	    // Exécution de la requête
	    $resultat = $req->execute();

	    if($resultat) {
	    	echo "<script language=\"javascript\">alert(\"Ajout du comment réussi !\");location.replace(\"commentaire.html\");</script>";
	    }
	}
	catch( Exception $e ) {
   		echo 'Erreur de requète : ', $e->getMessage();
	}
}

// 	############################## afficher des commentaires #############################


elseif(isset($_GET["afficher"])) {	
	
	$req = $sql->prepare("SELECT* FROM commentaire INNER JOIN films_info ON commentaire.id_film=films_info.id_film");

	$resultat = $req->execute();
	// compte le nombre de résultats renvoyés
	echo "<div id='table_film'>
			<table border='1' style='width:100%'>
				<tr>
    				<th>Identifiant du film</th>
    				<th>Titre du film</th>
    				<th>Commentaires</th>
  				</tr>";
	while($row = $req->fetch(PDO::FETCH_OBJ)) {
		echo "<tr>
					<td>".$row->id_film."</td>
  					<td>".$row->title."</td>
  					<td>".$row->comment."</td>
  				</tr>";
	}
	echo "</table></div>";
}
?>