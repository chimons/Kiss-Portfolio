<aside>
	<?php
	if (isset ($categories) AND !empty($categories) AND isset($rubriques) AND isset($articles)){ 
	?>
	<h2>Portfolio</h2>
		<ul class="link-list categorie" id="categories">
		<?php
			foreach ($categories as $cat){ ?>
				<li class="categorie"><a href="?module=categories&consulter&id=<?php echo $cat['id_cat']?>"><?php echo $cat['cat_titre']?></a></li>
				<ul class="link-list"  id="rubriques">
				<?php
				foreach ($rubriques as $rub){ 
					if ($rub['id_cat']==$cat['id_cat']){ ?>
						<li class="rubrique"><a href="?module=rubriques&consulter&id=<?php echo $rub['id_rubrique']?>"><?php echo $rub['rub_titre']?></a></li>
						<ul class="link-list"  id="articles">
						<?php
						if(isset($_GET['module']) AND $_GET['module']=="articles"){
							foreach ($articles as $art){ 
								if ($art['id_rubrique']==$rub['id_rubrique']){ ?>
									<li class="article"><a href="?module=articles&consulter&id=<?php echo $art['id_article']?>"><?php echo $art['art_titre']?></a></li>
						
						<?php }}} ?>
						</ul>
				<?php }  } ?>
				</ul>
		<?php } ?>
		</ul>
	<?php } ?>
</aside>
		
	<div id="footer">
	
		<p class="footer-text"><a href="http://chimon.fr/kiss-portfolio">Kiss Portfolio by <a href="http://github.com/chimons">Chimon S.</a></p> 
	
</div>		
</div>
</body>
</html>