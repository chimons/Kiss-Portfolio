
	<?php
	if (isset($message)){
	?>
	<h3><mark><?php echo $message ?></mark></h3>
	<?php } ?>
	
	
	<h1>Catégories</h1>
			<aside>
				<a href="?module=categories&ajouter" class="download-btn">Nouvelle catégorie</a>
			</aside>
	
            <div class="primary">
				
				<?php switch ($action){
					case "ajouter": 
					case "modifier":
				?>
				<form method="post" action="#" class="normal">
					<div>
						<h2><?php echo ($action=="ajouter" ? "Nouvelle catégorie" :  "Editer la catégorie"); ?></h2>
					</div>
					<div>		
						<label for="titre">Titre de la catégorie</label>
						<input name="titre" id="titre" class="ligne" type="text" value="<?php echo $titre ?>" required/> 
					</div>
					<div>
						<label  for="chapeau">Chapeau (Cette description appraîtra entre le titre de la catégorie et les vignettes des rubriques)</label>
						<textarea name="chapeau" id="chapeau" class="ligne" required><?php echo $chapeau ?></textarea> 
						<p>Vous pouvez utiliser les balises HTML pour le formattage du texte.</p>
					</div>
					<div>
						<label for="active" class="checkbox-lbl">Publier sur le portfolio? </label>
						<input name="active" id="active" class="checkbox" type="checkbox" <?php echo ($active==1? "checked" : "")?> />
					</div>
					<div>	  
						<input type="hidden" name="poste" value="true" />
						<?php if ($action=="modifier"){?><input type="hidden" name="id" value="<?php echo $la_categorie['id_cat'] ?>" /><?php } ?>
						<input type="hidden" name="action" value="<?php echo ($action=="ajouter" ? "ajouter" :  "modifier"); ?>" />
						<input type="submit" class="button" value="Valider" />
					</div>
				</form>
				<?php break; ?>
				
				<?php case "consulter" :  ?>
				<div class="panneau">
					<div>
						<h2><?php echo $la_categorie['cat_titre'] ?> (<?php if($la_categorie['active']) echo "Publiée"; else echo "Non publiée";?>)</h2>
						<p>
							<?php echo $la_categorie['cat_chapeau'] ?>
						</p>
						<p>
						<h2>Rubriques</h2>
						
							<ol>
								<?php
								if (!empty($cat_rubriques)){
									foreach ($cat_rubriques as $rub){ ?>
										<li><a href="?module=rubriques&consulter&id=<?php echo $rub['id_rubrique']?>"><?php echo $rub['rub_titre']?></a></li>
								<?php }
								}
								else{
									?>Aucune rubrique. <a href="?module=rubriques&ajouter">Ajouter une rubrique</a><?php
								}?>
							</ol>
						</p>
						<p>
							
							
							<a href="?module=categories&modifier&id=<?php echo $la_categorie['id_cat']?>" class="bouton">Editer</a>
							<?php if (empty($cat_rubriques)){ ?>
							<a href="?module=categories&supprimer&id=<?php echo $la_categorie['id_cat']?>" class="bouton" onclick="return confirm('La catégorie sera supprimée. Cette action est irréversible.')">Supprimer</a>
							<?php } ?>
							<a href="?module=rubriques&ajouter&id=<?php echo $la_categorie['id_cat']?>" class="bouton">Ajouter une rubrique</a>
						</p>
						
						
					</div>
				</div>
				<?php break; 
								default:
					?>
					<div>
					<h2>Illustration</h2>
					<p>
						<img src="images/captures/categories_legende.png" />
					</p>
					</div>
					<?php
					break;
				}?>
            </div>
						