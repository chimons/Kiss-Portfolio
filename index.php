<?php 
session_start();
require_once('m/Bdd.php');
$texte=get_texte_accueil();
include('v/v_header.php');
include('v/static.php');

$infos=get_infos();



?>


		<div class="intro-box">
		   <h1><?php echo $texte['titre'] ?></h1>

		  <p class="intro"><?php echo $texte['intro'] ?></p>
		  		  
		</div>

		<div class="slider-wrapper">
			<div id="slider" class="nivoSlider">
				<img src="images/slides/<?php echo $texte['url_image_1'] ?>" width="383" height="198" alt="" title="#s1"/>
				<img src="images/slides/<?php echo $texte['url_image_2'] ?>" width="383" height="198" alt="" title="#s2"/>
				<img src="images/slides/<?php echo $texte['url_image_3'] ?>" width="383" height="198" alt="" title="#s3"/>
			</div>
			<div id="s1" class="nivo-html-caption">
				<?php echo $texte['legende_image_1'] ?>
			</div>			
			<div id="s2" class="nivo-html-caption">
				<?php echo $texte['legende_image_2'] ?>
			</div>			
			<div id="s3" class="nivo-html-caption">
				<?php echo $texte['legende_image_3'] ?>
			</div>
		</div>

		<div class="row no-bottom-margin">

			<section class="col" id="gauche">
				<h2><?php echo $texte['titre_colonne1'] ?></h2>
				<p><?php echo $texte['texte_colonne1'] ?></p>
			</section>
			<section class="col mid">
				<h2><?php echo $texte['titre_colonne2'] ?></h2>
				<p><?php echo $texte['texte_colonne2'] ?></p>
			</section>
			<section class="col" id="droite">
				<h2><?php echo $texte['titre_colonne3'] ?></a></h2>
				<p><?php echo $texte['texte_colonne3'] ?></p>
			</section>
		</div>

		

	</section>
	</div>


	<div class="dark-bg">
	  <!-- portfolio -->
	  <section id="portfolio" class="section-wrap">

			<h1>Portfolio.</h1>
			
			<?php
			if ($categories=get_categories_publiees()){ //On vérifie s'il existe des catégories
			foreach ($categories as $categorie) { //on parcours les catégories
				echo "<h2>$categorie[cat_titre]</h2>";
				echo "<p>$categorie[cat_chapeau]</p>";
							
				if ($rubriques=get_rubriques_publiees($categorie['id_cat'])){ //on vérifie si la catégorie dispose de rubriques
				echo '<ul class="folio-list clearfix">';
				foreach ($rubriques as $rubrique){ //on parcours les rubriques
					?>
					<li class="folio-thumb">
					<div class="thumb">
						<?php //echo '<a class="show-portfolio-text" href="#rub'.$rubrique['id_rubrique'].'><img src="images/thumbs/'.$rubrique['rub_image'].' alt="" width="258" height="168"/> </a>'; ?>
						<a class="show-portfolio-text" href="#rub<?php echo $rubrique['id_rubrique']?>"><img src="images/thumbs/<?php echo $rubrique['rub_image']?>" alt="" width="258" height="168"/> </a>
					</div>
					<h3 class="entry-title"><?php echo $rubrique['rub_titre'];?></h3>
					
					
					<div style="display:none;">
						<div id="rub<?php echo $rubrique['id_rubrique']?>" class="portfoliodetail">
							<div>
								<h1 class="titre"><?php echo $rubrique['rub_titre'];?></h1>
								<p><?php echo $rubrique['rub_texte'];?></p>
								<?php
								if ($articles=get_articles_publies($rubrique['id_rubrique'])){ //on vérifie si la rubrique dispose d'articles
									echo '<h4>Fiches d\'activité et productions </h4><ul>';
									foreach ($articles as $article){ //on parcours les articles
									?>
										<li><a href="<?php echo $article['art_url'];?>" target="_blank"><?php echo $article['art_titre'];?></a><span class="link-<?php echo $article['art_type_lien'];?>"></span><br />
										<?php echo $article['art_texte'];?>
										</li>
									<?php
									}
									
									echo '</ul>';
								}
								?>
							
							</div>
						</div>
					</div>
				</li>
				<?php
				}
				echo '</ul>';
				

				} 
				else echo "<i>Aucune rubrique</i>";
			}

			}
			else echo "<i>Aucune catégorie</i>";
			?>
			

				

	  </section>
	</div>
	  
	  
	  
	

<!-- footer -->
<footer>
	<div class="footer-content">
		<ul class="footer-menu">
			<li><a href="#main">Accueil</a></li>
			<li><a href="#portfolio">Portfolio</a></li>
			<!--<li><a href="#cv">CV</a></li>-->
		</ul>
		<p class="footer-text">Kiss Portfolio by <a href="http://studioc-web.com">Chimon Sultan</a>. Design by <a href="http://www.Styleshout.com">E. Aligam</a></p> 
		<p class="footer-text"><a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/deed.fr" target="_blank"><img alt="Creative Commons License" style="border-width:0" src="images/cc-by-sa.png"/></a> L'ensemble du contenu de ce site est mis à disposition selon les termes de la licence <a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/deed.fr" target="_blank">Creative Commons by-SA 3.0</a>.</p>
	</div>

</footer>
</div>

	<script src="js/jquery-1.6.1.min.js" ></script>
	<script src="js/jquery.nivo.slider.pack.js"></script>
	<script src="js/jquery.fancybox-1.3.4.pack.js"></script>
    <script>
	$(window).load(function() {
    $('#slider').nivoSlider({directionNavHide:false});
	});

	$(document).ready(function(){
		$("a.show-portfolio-text").fancybox({ 
        'height'                :'auto' ,
		'transitionIn'			: 'elastic',
		'transitionOut'			: 'elastic',
        'titlePosition'     	: 'inside'
        });	
		return false;
   });
	</script>

 </body>
</html>
