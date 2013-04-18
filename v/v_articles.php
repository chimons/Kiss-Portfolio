
	
	<?php
	if (isset($message)){
	?>
	<h3><mark><?php echo $message ?></mark></h3>
	<?php } ?>
	
	<h1>Articles</h1>
			<aside>
				<a href="?module=articles&ajouter" class="download-btn">Nouvel article</a>
			</aside>
            <div class="primary">
				<?php switch ($action){
					case "ajouter": 
					case "modifier":
				?>
				<form method="post" action="#" class="normal">
					<div>
						<h2><?php echo ($action=="ajouter" ? "Nouvel article" :  "Editer l'article"); ?></h2>
					</div>
					<div>
						<label for="rubrique_parente">Rubrique parente</label>
						<select name="rubrique_parente" id="rubrique_parente" class="ligne" required>
							<?php
							foreach ($rubriques as $rub){ ?>
								<option value="<?php echo $rub['id_rubrique']?>"<?php if($rub['id_rubrique']==$id_rubrique_parente) echo " selected " ?>><?php echo $rub['rub_titre']?></option>
						<?php } ?>
						</select>
					</div>
					<div>		
						<label for="titre">Titre de l'article</label>
						<input name="titre" id="titre" class="ligne" type="text" value="<?php echo $titre ?>" required/> 
					</div>
					<div>		
						<label for="url">Adresse du lien (Chemin absolu)<label>
						<input name="url" id="url" class="ligne" type="text" value="<?php echo $url ?>" required/> 
					</div>
					<div>
						<label  for="type_lien">Type de lien</label>
						<select name="type_lien" id="type_lien" class="ligne" required> 
							<?php
							foreach ($types_liens as $tl){ ?>
								<option value="<?php echo $tl['code']?>"<?php if($tl['code']==$id_type_lien) echo " selected " ?>><?php echo $tl['libelle']?></option>
							<?php } ?>
						</select>
					</div>
					<div>
						<label  for="texte">Texte d'explication</label>
						<textarea name="texte" id="texte" class="ligne" required><?php echo $titre ?></textarea> 
						<p>Vous pouvez utiliser les balises HTML pour le formattage du texte.</p>
					</div>
					<div>
						<label for="active" class="checkbox-lbl">Publier sur le portfolio? </label>
						<input name="active" id="active" class="checkbox" type="checkbox" <?php echo ($active==1? "checked" : "")?> />
					</div>
					<div>	  
						<input type="hidden" name="poste" value="true" />
						<?php if ($action=="modifier"){?><input type="hidden" name="id" value="<?php echo $le_article['id_article'] ?>" /><?php } ?>
						<input type="hidden" name="action" value="<?php echo ($action=="ajouter" ? "ajouter" :  "modifier"); ?>" />
						<input type="submit" class="button" value="Valider" />
					</div>
				</form>	
				<?php break; ?>
				
				<?php case "consulter" :  ?>
				<div class="panneau">
					<div>
						<p>
							<h3>Rubrique : <?php echo $titre_rubrique_parente ?></h3>
						</p>
						<p>
							<h2><?php echo $le_article['art_titre'] ?> (<?php if($le_article['active']) echo "Publié"; else echo "Non publié";?>)</h2>
						</p>
						<p>
							URL : <?php echo $le_article['art_url'] ?>
						</p>
						<p>
							Type de lien : <?php echo $libelle_type_lien ?>
						</p>
						<p>
							<?php echo $le_article['art_texte'] ?>
						</p>
						
						
						<p>
							<a href="?module=articles&modifier&id=<?php echo $le_article['id_article'] ?>" class="bouton">Editer</a>
							<a href="?module=articles&supprimer&id=<?php echo $le_article['id_article'] ?>" class="bouton"  onclick="return confirm('L\'article sera supprimé. Cette action est irréversible.')">Supprimer</a>
							<a href="?module=articles&ajouter" class="bouton">Nouvel article</a>
						</p>
						
						
					</div>
				</div>
				<?php break; 
				default:
					?>
					<div>
					<h2>Illustration</h2>
					<p>
						<img src="images/captures/articles_legende.png" />
					</p>
					</div>
					<?php
					break;
				
				}?>
            </div>
			<?php /*
			<aside>
				<h2>Articles</h2>
					<ul class="link-list">
					<?php
						foreach ($articles as $art){ ?>
							<li><a href="?module=articles&consulter&id=<?php echo $art['id_article']?>"><?php echo $art['art_titre']?></a></li>
					<?php } ?>
                    </ul>
				<a href="?module=articles&ajouter" class="download-btn">Nouvel article</a>
             </aside>	
				*/?>
