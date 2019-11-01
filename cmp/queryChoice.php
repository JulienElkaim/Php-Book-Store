
<th>
	<form action="" method="post">
		<select class="form-control form-control-lg" name='queryChoiceIndex' onchange='if(this.value != 0) { this.form.submit(); }'>
		    <option value='0'>Choisissez votre requête...</option>
		    <option value='1'>1. La liste de tous les livres (titre_livre, genre, parution, nature, langue).</option>
		    <option value='2'>2. La liste de tous les auteurs (nom_auteur, prénom_auteur, naissance, décès, nationalité).</option>
		    <option value='3'>3. La liste de tous les éditeurs (nom_editeur, site_web).</option>
		    <option value='4'>4. Le titre et le nom de l’éditeur de tous les livres.</option>
		    <option value='5'>5. Le titre, l’auteur et l’éditeur de tous les livres.
</option>
		    <option value='6'>6. Le titre des livres dont l’auteur est "Isaac Asimov".</option>
		    <option value='7'>7. Le nom des auteurs (sans doublons) publiés par l’éditeur "J’ai Lu".</option>
		    <option value='8'>8. Le nombre de livres écrits par "Amélie Nothomb".</option>
		    <option value='9'>9. Le nombre de livres publiés par Editeur.
</option>
		    <option value='10'>10. Les Livres de science-fiction n’ayant pas été écrit par "Asimov Isaac".</option>
		    <option value='11'>11. Les auteurs publiés par les mêmes éditeurs.
</option>
		    <option value='12'>12. Les nouvelles de science-fiction écrites par "Asimov Isaac" et non édi- tées par "Gallimard".</option>
		    <option value='13'>13. Les livres écrits par des auteurs décédés.</option>
		    <option value='14'>14. Les auteurs ayant écrit des livres de natures différentes.</option>
		    <option value='15'>15. Les auteurs ayant écrit au moins deux livres.</option>
		    <option value='16'>16. 1st Additional query: Les auteurs morts ayant écrit au moins un roman ou une nouvelle.</option>
		    <option value='17'>17. 2nd Additional query: La première et dernière parution d'un livre d'un membre de la famille d'Asimov.</option>
		    <option value='18'>18. 3th Additional query: Le titre et l'année de parution des livre multi publiés (ayant plus d'un éditeur).</option>
		    <option value='19'>19. 4th Additional query: Le nom de(s) auteur(s) vivant(s) le(s) plus prolifique(s), ainsi que le nombre de livre(s) écrits.</option>
		</select>
	</form>
</th>

