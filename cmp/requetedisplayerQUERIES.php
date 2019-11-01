<?php
	include ("fct/queryFcts.php");
	
	if (isset($_POST["queryChoiceIndex"]) ){
			
		$dbh = MYconnect_Serv($host, $login, $password);
            switch($_POST["queryChoiceIndex"]){
            	
                  case 1:     //La liste de tous les livres (titre_livre, genre, parution, nature, langue)


            		$sql = ("SELECT `titre_livre`, `genre`, `parution`, `nature`, `langue`  FROM MyBooks.Livre");
                        $tmp = $dbh->query($sql);
                        echo '<table>';
                        //Display Titles
                        echo '<tr>';
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> titre_livre</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> genre</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> parution</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> nature</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> langue</td>";
                        echo '</tr>';
                        // Display values
                        displayResult($tmp);
                        echo "</table>";
                        break;

            	case 2:    //La liste de tous les auteurs (nom_auteur, prénom_auteur, naissance, décès, nationalité)

            		$sql = ("SELECT `nom_auteur`, `prénom_auteur`, `naissance`, `décès`, `nationalité` FROM MyBooks.Auteur");
                        $tmp = $dbh->query($sql);
                        echo '<table>';
                        //Display Titles
                        echo '<tr>';
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> nom_auteur</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> prénom_auteur</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> naissance</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> décès</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> nationalité</td>";
                        echo '</tr>';
                        // Display values
                        displayResult($tmp);
                        echo "</table>";
                        //echo $sql;
            		break;
            	case 3:    //La liste de tous les éditeurs (nom_editeur, site_web)

            		$sql = ("SELECT `nom_editeur`, `site_web` FROM MyBooks.Editeur");
                        $tmp = $dbh->query($sql);
                        echo '<table>';
                        //Display Titles
                        echo '<tr>';
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> nom_editeur</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> site_web</td>";
                        echo '</tr>';
                        // Display values
                        displayResult($tmp);
                        echo "</table>";
                        //echo $sql;
            		break;

            	case 4: // Le titre et le nom de l’éditeur de tous les livres
                        //Interprétation -> Afficher même ceux n'ayant pas d'éditeur.
                        $sql =("SELECT MyBooks.Livre.titre_livre, MyBooks.Editeur.nom_editeur FROM MyBooks.Livre LEFT JOIN MyBooks.Edition on MyBooks.Livre.id_livre = MyBooks.Edition.id_livre LEFT JOIN MyBooks.Editeur on MyBooks.Editeur.id_editeur = MyBooks.Edition.id_editeur ORDER BY MyBooks.Livre.id_livre");
                        $tmp = $dbh->query($sql);
                        echo '<table>';
                        //Display Titles
                        echo '<tr>';
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> titre_livre</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> nom_editeur</td>";
                        echo '</tr>';
                        // Display values
                        displayResult($tmp);
                        echo "</table>";
            		
            		break;
            	
                  case 5: // Le titre, l’auteur et l’éditeur de tous les livres
            		//Interprétation -> Afficher même ceux n'ayant pas d'éditeur.
                        $sql =("SELECT MyBooks.Livre.titre_livre, MyBooks.Auteur.prénom_auteur, MyBooks.Auteur.nom_auteur, MyBooks.Editeur.nom_editeur FROM MyBooks.Livre LEFT JOIN MyBooks.Edition on MyBooks.Livre.id_livre = MyBooks.Edition.id_livre LEFT JOIN MyBooks.Editeur on MyBooks.Editeur.id_editeur = MyBooks.Edition.id_editeur LEFT JOIN MyBooks.Ecriture on MyBooks.Livre.id_livre = MyBooks.Ecriture.id_livre LEFT JOIN MyBooks.Auteur on MyBooks.Auteur.id_auteur = MyBooks.Ecriture.id_auteur ORDER BY MyBooks.Livre.id_livre");
                        $tmp = $dbh->query($sql);
                        echo '<table>';
                        //Display Titles
                        echo '<tr>';
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> titre_livre</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> prénom_auteur</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> nom_auteur</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> nom_editeur</td>";
                        echo '</tr>';
                        // Display values
                        displayResult($tmp);
                        echo "</table>";
            		break;

                  case 6:     //Le titre des livres dont l’auteur est "Isaac Asimov"

                        $sql =("SELECT MyBooks.Livre.titre_livre FROM MyBooks.Livre LEFT JOIN MyBooks.Ecriture on MyBooks.Livre.id_livre = MyBooks.Ecriture.id_livre LEFT JOIN MyBooks.Auteur on MyBooks.Auteur.id_auteur = MyBooks.Ecriture.id_auteur WHERE MyBooks.Auteur.nom_auteur='Asimov' AND MyBooks.Auteur.prénom_auteur='Isaac'");
                        $tmp = $dbh->query($sql);
                        echo '<table>';
                        //Display Titles
                        echo '<tr>';
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> titre_livre</td>";
                        echo '</tr>';
                        // Display values
                        displayResult($tmp);
                        echo "</table>";

                        break;

                  case 7: //Le nom des auteurs (sans doublons) publiés par l’éditeur "J’ai Lu"
                        $sql =("SELECT DISTINCT MyBooks.Auteur.nom_auteur FROM MyBooks.Auteur INNER JOIN MyBooks.Ecriture on MyBooks.Auteur.id_auteur = MyBooks.Ecriture.id_auteur INNER JOIN MyBooks.Livre on MyBooks.Ecriture.id_livre = MyBooks.Livre.id_livre INNER JOIN MyBooks.Edition on MyBooks.Livre.id_livre = MyBooks.Edition.id_livre INNER JOIN MyBooks.Editeur on MyBooks.Edition.id_editeur = MyBooks.Editeur.id_editeur WHERE MyBooks.Editeur.nom_editeur='J''ai lu' ");
                        $tmp = $dbh->query($sql);
                        echo '<table>';
                        //Display Titles
                        echo '<tr>';
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> nom_auteur</td>";
                        echo '</tr>';
                        // Display values
                        displayResult($tmp);
                        echo "</table>";

                        break;

                  case 8: //Le nombre de livres écrits par "Amélie Nothomb"

                        $sql =("SELECT COUNT(*) FROM MyBooks.Livre INNER JOIN MyBooks.Ecriture on MyBooks.Livre.id_livre = MyBooks.Ecriture.id_livre INNER JOIN MyBooks.Auteur on MyBooks.Ecriture.id_auteur = MyBooks.Auteur.id_auteur WHERE MyBooks.Auteur.nom_auteur='Nothomb' AND MyBooks.Auteur.prénom_auteur='Amélie'");
                        $tmp = $dbh->query($sql);
                        echo '<table>';
                        //Display Titles
                        echo '<tr>';
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> Nb Livres - Amélie Nothomb</td>";
                        echo '</tr>';
                        // Display values
                        displayResult($tmp);
                        echo "</table>";

                        break;

                  case 9: // Le nombre de livres publiés par Editeur
                        //Interprétation -> Afficher même ceux n'ayant pas d'éditeur
                        $sql =("SELECT MyBooks.Editeur.nom_editeur, COUNT(MyBooks.Edition.id_editeur) FROM MyBooks.Editeur LEFT JOIN MyBooks.Edition on MyBooks.Editeur.id_editeur = MyBooks.Edition.id_editeur LEFT JOIN MyBooks.Livre on MyBooks.Edition.id_livre = MyBooks.Livre.id_livre GROUP BY MyBooks.Editeur.nom_editeur");
                        $tmp = $dbh->query($sql);
                        echo '<table>';
                        //Display Titles
                        echo '<tr>';
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> nom_editeur </td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> Nb Livres par Editeur </td>";
                        echo '</tr>';
                        // Display values
                        displayResult($tmp);
                        echo "</table>";

                        break;

                  case 10: //Les Livres de science-fiction n’ayant pas été écrit par "Asimov Isaac"

                        $sql =("SELECT MyBooks.Livre.titre_livre FROM MyBooks.Livre INNER JOIN MyBooks.Ecriture on MyBooks.Livre.id_livre = MyBooks.Ecriture.id_livre INNER JOIN MyBooks.Auteur on MyBooks.Ecriture.id_auteur = MyBooks.Auteur.id_auteur WHERE MyBooks.Auteur.nom_auteur<>'Asimov' AND MyBooks.Auteur.prénom_auteur<>'Isaac' AND MyBooks.Livre.genre ='science-fiction'");
                        $tmp = $dbh->query($sql);
                        echo '<table>';
                        //Display Titles
                        echo '<tr>';
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">titre_livre</td>";
                        echo '</tr>';
                        // Display values
                        displayResult($tmp);
                        echo "</table>";

                        break;

                  case 11: // Les auteurs publiés par les mêmes éditeurs
                  // Interprétation -> Mail.
                        $sql =("SELECT MyBooks.Editeur.nom_editeur, GROUP_CONCAT( DISTINCT MyBooks.Auteur.prénom_auteur, ' ', MyBooks.Auteur.nom_auteur SEPARATOR ' , ' ) FROM MyBooks.Editeur INNER JOIN MyBooks.Edition on MyBooks.Edition.id_editeur = MyBooks.Editeur.id_editeur INNER JOIN MyBooks.Livre on MyBooks.Edition.id_livre = MyBooks.Livre.id_livre INNER JOIN MyBooks.Ecriture on MyBooks.Livre.id_livre = MyBooks.Ecriture.id_livre INNER JOIN MyBooks.Auteur on MyBooks.Ecriture.id_auteur = MyBooks.Auteur.id_auteur GROUP BY MyBooks.Editeur.nom_editeur");
                        $tmp = $dbh->query($sql);
                        echo '<table>';
                        //Display Titles
                        echo '<tr>';
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> nom_editeur</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> Auteurs</td>";
                        echo '</tr>';
                        // Display values
                        displayResult($tmp);
                        echo "</table>";
                        
                        break;

                  case 12: //Les nouvelles de science-fiction écrites par "Asimov Isaac" et non éditées par "Gallimard"
                        $sql =("SELECT MyBooks.Livre.titre_livre FROM MyBooks.Livre LEFT JOIN MyBooks.Edition on MyBooks.Livre.id_livre = MyBooks.Edition.id_livre LEFT JOIN MyBooks.Editeur on MyBooks.Editeur.id_editeur = MyBooks.Edition.id_editeur LEFT JOIN MyBooks.Ecriture on MyBooks.Livre.id_livre = MyBooks.Ecriture.id_livre LEFT JOIN MyBooks.Auteur on MyBooks.Auteur.id_auteur = MyBooks.Ecriture.id_auteur WHERE MyBooks.Livre.nature ='nouvelle' AND MyBooks.Livre.genre ='science-fiction' AND MyBooks.Auteur.nom_auteur='Asimov' AND MyBooks.Auteur.prénom_auteur='Isaac' AND MyBooks.Editeur.nom_editeur<>'Gallimard'");
                        $tmp = $dbh->query($sql);
                        echo '<table>';
                        //Display Titles
                        echo '<tr>';
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\"> titre_livre</td>";
                        echo '</tr>';
                        // Display values
                        displayResult($tmp);
                        echo "</table>";

                        break;

                  case 13: // Les livres écrits par des auteurs décédés
                        // Choix d'inscrit les vivants en décès NULL dans la base.
                        $sql =("SELECT MyBooks.Livre.titre_livre FROM MyBooks.Livre INNER JOIN MyBooks.Ecriture on MyBooks.Livre.id_livre = MyBooks.Ecriture.id_livre INNER JOIN MyBooks.Auteur on MyBooks.Ecriture.id_auteur = MyBooks.Auteur.id_auteur WHERE MyBooks.Auteur.décès IS NOT NULL ");
                        $tmp = $dbh->query($sql);
                        echo '<table>';
                        //Display Titles
                        echo '<tr>';
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">titre_livre</td>";
                        echo '</tr>';
                        // Display values
                        displayResult($tmp);
                        echo "</table>";
                        break;

                  case 14: //Les auteurs ayant écrit des livres de natures différentes

                        $sql =("SELECT MyBooks.Auteur.nom_auteur, MyBooks.Auteur.prénom_auteur FROM MyBooks.Auteur INNER JOIN MyBooks.Ecriture on MyBooks.Auteur.id_auteur = MyBooks.Ecriture.id_auteur INNER JOIN MyBooks.Livre on MyBooks.Ecriture.id_livre = MyBooks.Livre.id_livre GROUP BY MyBooks.Auteur.nom_auteur,MyBooks.Auteur.prénom_auteur  HAVING COUNT(MyBooks.Livre.nature) >1");
                        $tmp = $dbh->query($sql);
                        echo '<table>';
                        //Display Titles
                        echo '<tr>';
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">nom_auteur</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">prénom_auteur</td>";
                        echo '</tr>';
                        // Display values
                        displayResult($tmp);
                        echo "</table>";

                        break;

                  case 15: // Les auteurs ayant écrit au moins deux livres
                        $sql =("SELECT MyBooks.Auteur.nom_auteur, MyBooks.Auteur.prénom_auteur FROM MyBooks.Auteur INNER JOIN MyBooks.Ecriture on MyBooks.Auteur.id_auteur = MyBooks.Ecriture.id_auteur GROUP BY MyBooks.Auteur.nom_auteur,MyBooks.Auteur.prénom_auteur  HAVING COUNT(MyBooks.Ecriture.id_livre) >=2");
                        $tmp = $dbh->query($sql);
                        echo '<table>';
                        //Display Titles
                        echo '<tr>';
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">nom_auteur</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">prénom_auteur</td>";
                        echo '</tr>';
                        // Display values
                        displayResult($tmp);
                        echo "</table>";

                        break;

                  case 16: // Les auteurs décédés ayant écrit au moins un roman OU une nouvelle
                        $sql =("SELECT MyBooks.Auteur.nom_auteur, MyBooks.Auteur.prénom_auteur FROM MyBooks.Auteur INNER JOIN MyBooks.Ecriture on MyBooks.Auteur.id_auteur = MyBooks.Ecriture.id_auteur INNER JOIN MyBooks.Livre on MyBooks.Ecriture.id_livre = MyBooks.Livre.id_livre WHERE MyBooks.Auteur.décès IS NOT NULL AND(MyBooks.Livre.nature = 'nouvelle' OR MyBooks.Livre.nature ='roman') GROUP BY MyBooks.Auteur.nom_auteur,MyBooks.Auteur.prénom_auteur  HAVING COUNT(MyBooks.Livre.nature) >=1");
                        $tmp = $dbh->query($sql);
                        echo '<table>';
                        //Display Titles
                        echo '<tr>';
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">nom_auteur</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">prénom_auteur</td>";
                        echo '</tr>';
                        // Display values
                        displayResult($tmp);
                        echo "</table>";

                        break;
                  case 17: //  La première et dernière fois qu'un livre d'un membre de la famille d'Asimov  est paru.
                        $sql =("SELECT MyBooks.Auteur.nom_auteur, MIN(MyBooks.Livre.parution), MAX(MyBooks.Livre.parution) FROM MyBooks.Auteur INNER JOIN MyBooks.Ecriture on MyBooks.Auteur.id_auteur = MyBooks.Ecriture.id_auteur INNER JOIN MyBooks.Livre on MyBooks.Ecriture.id_livre = MyBooks.Livre.id_livre WHERE MyBooks.Auteur.nom_auteur = 'Asimov' GROUP BY MyBooks.Auteur.nom_auteur");
                        $tmp = $dbh->query($sql);
                        echo '<table>';
                        //Display Titles
                        echo '<tr>';
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">nom_auteur</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">Première parution</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">Dernière parution</td>";
                        echo '</tr>';
                        // Display values
                        displayResult($tmp);
                        echo "</table>";
                        break;
                  case 18: // Le titre et l'année de parution des livres ayant plus d'un éditeur
                        $sql =("SELECT MyBooks.Livre.titre_livre, MyBooks.Livre.parution FROM MyBooks.Livre INNER JOIN MyBooks.Edition on MyBooks.Livre.id_livre = MyBooks.Edition.id_livre GROUP BY MyBooks.Livre.titre_livre, MyBooks.Livre.parution  HAVING COUNT(MyBooks.Edition.id_editeur) >1");
                        $tmp = $dbh->query($sql);
                        echo '<table>';
                        //Display Titles
                        echo '<tr>';
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">nom_auteur</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">prénom_auteur</td>";
                        echo '</tr>';
                        // Display values
                        displayResult($tmp);
                        echo "</table>";

                        break;
                  case 19: // Le nom de l'auteur vivant le plus prolifique ainsi que le nombre de livre qu'il a écrit.

                        $sql =("
                              SELECT CompteNbLivreByAuthor.prénom_auteur, CompteNbLivreByAuthor.nom_auteur, maxCompteNbLivreByAuthor.maximum 
                              FROM (
                              SELECT MyBooks.Auteur.prénom_auteur, MyBooks.Auteur.nom_auteur, COUNT(*) AS num 
                              FROM MyBooks.Auteur 
                              INNER JOIN MyBooks.Ecriture 
                              ON MyBooks.Auteur.id_auteur = MyBooks.Ecriture.id_auteur 
                              GROUP BY MyBooks.Auteur.nom_auteur, MyBooks.Auteur.prénom_auteur) 
                              AS CompteNbLivreByAuthor 
                              INNER JOIN (
                              SELECT MAX(subCompteNbLivreByAuthor.num) AS maximum 
                              FROM(
                              SELECT COUNT(*) AS num 
                              FROM MyBooks.Auteur 
                              INNER JOIN MyBooks.Ecriture 
                              ON MyBooks.Auteur.id_auteur = MyBooks.Ecriture.id_auteur 
                              WHERE MyBooks.Auteur.Décès IS NULL 
                              GROUP BY MyBooks.Auteur.nom_auteur, MyBooks.Auteur.prénom_auteur) 
                              AS subCompteNbLivreByAuthor) 
                              AS maxCompteNbLivreByAuthor 
                              ON maxCompteNbLivreByAuthor.maximum = CompteNbLivreByAuthor.num");
                        $tmp = $dbh->query($sql);
                        echo '<table>';
                        //Display Titles
                        echo '<tr>';
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">prénom_auteur</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">nom_auteur</td>";
                              echo "<td width=\"150\" align=\"center\" bgcolor=\"#999999\">Nombre de livre(s)</td>";
                        echo '</tr>';
                        // Display values
                        displayResult($tmp);
                        echo "</table>";

                        break;

            	default:
            	echo "<p>It seems that this table does not exist.</p>";
            	break;
            }

	}
?>