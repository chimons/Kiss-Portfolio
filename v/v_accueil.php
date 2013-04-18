
	
	<?php
	if (isset($message)){
	?>
	<h3><mark><?php echo $message ?></mark></h3>
	<?php } ?>
	<h1>Accueil</h1>
		<form method="post" class="large" action="#">
			<div class="intro-box">
				<div>
					<label for="titre">Titre</label>
					<input name="titre" id="titre" class="ligne" type="text" value="<?php echo $texte['titre'] ?>" required/> 
				</div>
				<div>
					<label  for="intro">Texte d'introduction</label>
					<textarea name="intro" id="intro" class="ligne" required><?php echo $texte['intro'] ?></textarea> 
				</div>
			
			</div>
		<div class="slider-wrapper-form">
			<label for="legende_image_1">Légende image 1</label>
			<input name="legende_image_1" id="legende_image_1" class="" type="text" value="<?php echo $texte['legende_image_1'] ?>" required/> 
			<label for="url_image_1">Nom image 1</label>
			<input name="url_image_1" id="url_image_1" class="" type="text" value="<?php echo $texte['url_image_1'] ?>" required/> 
			<label for="legende_image_2">Légende image 2</label>
			<input name="legende_image_2" id="legende_image_2" class="" type="text" value="<?php echo $texte['legende_image_2'] ?>" required/> 
			<label for="url_image_2">Nom image 2</label>
			<input name="url_image_2" id="url_image_2" class="" type="text" value="<?php echo $texte['url_image_2'] ?>" required/> 
			<label for="legende_image_3">Légende image 3</label>
			<input name="legende_image_3" id="legende_image_3" class="" type="text" value="<?php echo $texte['legende_image_3'] ?>" required/> 
			<label for="url_image_3">Nom image 3</label>
			<input name="url_image_3" id="url_image_3" class="" type="text" value="<?php echo $texte['url_image_3'] ?>" required/> 
			

		</div>
		<div class="row no-bottom-margin">
			<section class="col" id="gauche">
				<label for="titre_colonne1">Titre Colonne 1</label>
				<input name="titre_colonne1" id="titre_colonne1" class="ligne" type="text" value="<?php echo $texte['titre_colonne1'] ?>" required/> 
			
				<label  for="texte_colonne1">Texte Colonne 1</label>
				<textarea name="texte_colonne1" id="texte_colonne1" class="ligne" required><?php echo $texte['texte_colonne1'] ?></textarea> 
			</section>
			<section class="col mid">
				<label for="titre_colonne2">Titre Colonne 2</label>
				<input name="titre_colonne2" id="titre_colonne2" class="ligne" type="text" value="<?php echo $texte['titre_colonne2'] ?>" required/> 
			
				<label  for="texte_colonne2">Texte Colonne 2</label>
				<textarea name="texte_colonne2" id="texte_colonne2" class="ligne" required><?php echo $texte['texte_colonne2'] ?></textarea> 
			</section>
			<section class="col" id="droite">
				<label for="titre_colonne3">Titre Colonne 3</label>
				<input name="titre_colonne3" id="titre_colonne3" class="ligne" type="text" value="<?php echo $texte['titre_colonne3'] ?>" required/> 
			
				<label  for="texte_colonne3">Texte Colonne 3</label>
				<textarea name="texte_colonne3" id="texte_colonne3" class="ligne" required><?php echo $texte['texte_colonne3'] ?></textarea> 
			</section>
			<div>	  
				<input type="hidden" name="poste" value="true" />
				<input type="submit" class="button" id="accueil" value="Valider" />
			</div>
		</div>
		</form>	

   	</section>
	</div>
			
