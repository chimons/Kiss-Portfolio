
	<?php
	if (!empty($messages)){
		foreach ($messages as $msg){
	?>
		<h3><mark><?php echo $msg ?></mark></h3>
	<?php } }?>
	
	<h1>Rubriques</h1>
		<aside>
			<a href="?module=rubriques&ajouter" class="download-btn">Nouvelle rubrique</a>
        </aside> 
		   <div class="primary">
			
				<?php switch ($action){
					case "invite_ajouter_categorie";
				?>
					<div class="panneau">
					<div>
						
						<h3>Le portfolio ne contient aucune catégorie.</h3>
						<p>Vous devez <a href="admin.php?module=categories&ajouter">créer une catégorie</a> avant de pouvoir ajouter une rubrique.</p>
						<a href="?module=categories&ajouter" class="download-btn">Nouvelle catégorie</a>
					</div>
					</div>
						
				
				<?php
					break;
					case "ajouter": 
					case "modifier":
				?>
				<form method="post" action="#"  class="normal"  enctype="multipart/form-data">
					<div>
						<h2><?php echo ($action=="ajouter" ? "Nouvelle rubrique" :  "Editer la rubrique"); ?></h2>
					</div>
					<div>
						<label for="categorie_parente">Catégorie parente</label>
						<select name="categorie_parente" id="categorie_parente" class="ligne" required>
							<?php
							
							foreach ($categories as $cat){ ?>
								<option value="<?php echo $cat['id_cat']?>"<?php if($cat['id_cat']==$id_categorie_parente) echo " selected " ?>><?php echo $cat['cat_titre']?></option>
						<?php } ?>
						</select>
					</div>
					<div>		
						<label for="titre">Titre de la rubrique</label>
						<input name="titre" id="titre" class="ligne" type="text" value="<?php echo $titre ?>" required /> 
					</div>
					<div>
						<label  for="texte">Texte (Texte de présentation de la rubrique)</label>
						<textarea name="texte" id="texte" class="ligne" required ><?php echo $texte ?></textarea> 
						<p style="margin-top:-15px">Vous pouvez utiliser les balises HTML pour le formattage du texte.</p>
					</div>
					<div>		
						<label for="miniature">Miniature (Taille max <?php echo taille_max_upload() ?> mo)</label>
						<input name="miniature" id="miniature" class="ligne" type="file" /> 
						<p style="margin-top:-15px">Laissez vide pour utiliser l'image par défaut.</p>
					</div>
					<div>
						<label for="active" class="checkbox-lbl">Publier sur le portfolio? </label>
						<input name="active" id="active" class="checkbox" type="checkbox" <?php echo ($active==1? "checked" : "")?> />
					</div>
					<div>	  
						<input type="hidden" name="poste" value="true" />
						<input type="hidden" name="MAX_FILE_SIZE" value="15" />
						<?php if ($action=="modifier"){?><input type="hidden" name="id" value="<?php echo $la_rubrique['id_rubrique'] ?>" /><?php } ?>
						<input type="hidden" name="action" value="<?php echo ($action=="ajouter" ? "ajouter" :  "modifier")?>" />
						<input type="submit" class="button" value="Valider" />
					</div>
				</form>	
				<?php break; ?>
				
				<?php case "consulter" :  ?>
				<div class="panneau">
					<div>
						<p>
							<h3>Catégorie : <?php echo $titre_categorie_parente ?></h3>
						</p>
						<p>
							<h2><?php echo $la_rubrique['rub_titre'] ?> (<?php if($la_rubrique['active']) echo "Publiée"; else echo "Non publiée";?>)</h2>
						</p>
						<p>
							<?php echo $la_rubrique['rub_texte'] ?>
						</p>
						<p>
							<img src="images/thumbs/<?php echo $la_rubrique['rub_image'] ?>" title="<?php echo $la_rubrique['rub_image']?>" />
						</p>
						<p>
						<h2>Articles</h2>
						
							<ol>
								<?php
								if (!empty($rub_articles)){
									foreach ($rub_articles as $art){ ?>
										<li><a href="?module=articles&consulter&id=<?php echo $art['id_article']?>"><?php echo $art['art_titre']?></a></li>
								<?php }
								}
								else{
									?>Aucun article. <a href="?module=articles&ajouter">Ajouter un article.</a><?php
								}?>
							</ol>
						</p>
						<p>
							<a href="?module=rubriques&modifier&id=<?php echo $la_rubrique['id_rubrique']?>" class="bouton">Editer</a>
							<?php if (empty($rub_articles)){ ?>
							<a href="?module=rubriques&supprimer&id=<?php echo $la_rubrique['id_rubrique']?>" class="bouton"  onclick="return confirm('La rubrique sera supprimée. Cette action est irréversible.')">Supprimer</a>
							<?php } ?>
							<a href="?module=articles&ajouter&id=<?php echo $la_rubrique['id_rubrique']?>" class="bouton">Ajouter un article</a>

						</p>
						
						
					</div>
				</div>
				<?php break; 
					default:
					?>
					<div>
					<h2>Illustration</h2>
					<p>
						<img src="images/captures/rubriques_legende.png" />
					</p>
					</div>
					<?php
					break;
				}?>
				
            </div>
			<?php /*
			<aside>
				<h2>Rubriques</h2>
					<ul class="link-list">
					<?php
						foreach ($rubriques as $rub){ ?>
							<li><a href="?module=rubriques&consulter&id=<?php echo $rub['id_rubrique']?>"><?php echo $rub['rub_titre']?></a></li>
					<?php } ?>
                    </ul>
				<a href="?module=rubriques&ajouter" class="download-btn">Nouvelle rubrique</a>
            </aside>		   
			 */?>