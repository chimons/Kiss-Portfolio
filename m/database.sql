DROP TABLE IF EXISTS "accueil";
CREATE TABLE "accueil" (
  "titre" varchar(255) ,
  "intro" varchar(255) ,
  "titre_colonne1" varchar(255) ,
  "texte_colonne1" varchar(255) ,
  "titre_colonne2" varchar(255) ,
  "texte_colonne2" varchar(255) ,
  "titre_colonne3" varchar(255),
  "texte_colonne3" varchar(255)
, "legende_image_1" VARCHAR, "legende_image_2" VARCHAR, "legende_image_3" VARCHAR, "url_image_1" VARCHAR, "url_image_2" VARCHAR, "url_image_3" VARCHAR);
INSERT INTO "accueil" VALUES(' Bienvenue',' Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tincidunt malesuada ipsum, quis tempor enim auctor sit amet. Phasellus sagittis felis in lorem placerat ultricies. Nam in dui ut tellus tristique pretium. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Morbi non mauris massa, vitae fringilla purus. Nullam at lacus tortor, ut faucibus erat. Vivamus gravida pharetra cursus. Quisque non orci quam',' Titre Colonne 1','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tincidunt malesuada ipsum, quis tempor enim auctor sit amet. Phasellus sagittis felis in lorem placerat ultricies. Nam in dui ut tellus tristique pretium. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos

 Morbi non mauris massa, vitae fringilla purus. Nullam at lacus tortor, ut faucibus erat. Morus. Nullam at lacus tortor, ut faucibus erat. bi non mauris massa, vitae fringilla purus. Nullam at lacus tortor, ut faucibus erat. ',' Titre Colonne 2','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tincidunt malesuada ipsum, quis tempor enim auctor sit amet. Pherat ultricies. Nam in dui ut tellus tristique pretium. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos

 Morbi non mauris massa, vitae fringilla purus. Nullam at lacus tortor, ut faucibus erat. Morbi non mauris massa, vitae frins. Nullam at lacus tortor, ut faucibus erat.  Nullam at lacus tortor, ut faucibus erat. ',' Titre Colonne 3','Lorem ipsum dolor sit amet, consectetur adipiscing elit. In tincidunt malesuada ipsum, quis tempor enim auctor sit amet. Phasellus  felis in lorem placerat ultricies. Nam in dui ut tellus tristique pretium. Class ap torquent per conubia nostra, per inceptos himenaeos
us. Nullam at lacus tortor, ut faucibus erat. 
 Morbi non mauris massa, vitae fringilla purus. Nullam at lacus tortor, ut faucibus erat. Morbi non mauris massa, vitae fringilla purus. Nullam at lacus tortor, ut faucibus erat. ','Légende image 1','Légende image 2','Légende image 3','slide1.png','slide2.png','slide3.png');
DROP TABLE IF EXISTS "articles";
CREATE TABLE "articles" (
  "id_article" integer PRIMARY KEY AUTOINCREMENT ,
  "id_rubrique" int(11) NOT NULL,
  "art_titre" varchar(255) ,
  "art_url" varchar(255) ,
  "art_type_lien" varchar(255) ,
  "art_texte" varchar(255) ,
  "art_position" tinyint(4) DEFAULT 0,
  "active" tinyint(4) DEFAULT 0, "art_lien_externe" INTEGER DEFAULT 0,
  CONSTRAINT "articles_ibfk_1" FOREIGN KEY ("id_rubrique") REFERENCES "rubriques" ("id_rubrique")
);
DROP TABLE IF EXISTS "categories";
CREATE TABLE "categories" (
  "id_cat" integer PRIMARY KEY AUTOINCREMENT,
  "cat_titre" varchar(255) ,
  "cat_chapeau" varchar(255) ,
  "cat_position" tinyint(4) DEFAULT 0,
  "active" tinyint(4) DEFAULT 0
);
DROP TABLE IF EXISTS "infos";
CREATE TABLE "infos" (
  "id" integer PRIMARY KEY AUTOINCREMENT ,
  "auteur" varchar(50) NOT NULL DEFAULT 'auteur',
  "url" varchar(255) NOT NULL DEFAULT 'url',
  "nomdusite" varchar(255) NOT NULL DEFAULT 'nom du site',
  "footer" varchar(255) DEFAULT 'Portfolio 2013'
);
DROP TABLE IF EXISTS "rubriques";
CREATE TABLE "rubriques" (
  "id_rubrique" integer PRIMARY KEY AUTOINCREMENT ,
  "id_cat" int(11) NOT NULL,
  "rub_titre" varchar(255) ,
  "rub_texte" text ,
  "rub_image" varchar(255) ,
  "rub_position" tinyint(4) DEFAULT 0,
  "active" tinyint(4) DEFAULT 0,
  CONSTRAINT "rubriques_ibfk_1" FOREIGN KEY ("id_cat") REFERENCES "categories" ("id_cat")
);
DROP TABLE IF EXISTS "types_liens";
CREATE TABLE "types_liens" ("id" INTEGER PRIMARY KEY  NOT NULL  UNIQUE , "code" VARCHAR, "libelle" VARCHAR);
INSERT INTO "types_liens" VALUES(0,'aucun','Aucun');
INSERT INTO "types_liens" VALUES(1,'pdf','Fichier PDF');
INSERT INTO "types_liens" VALUES(2,'word','Fichier DOC');
INSERT INTO "types_liens" VALUES(3,'zip','Archive');
INSERT INTO "types_liens" VALUES(4,'externe','Lien externe');
INSERT INTO "types_liens" VALUES(5,'image','Image');
CREATE INDEX "articles_id_rubrique" ON "articles" ("id_rubrique");
CREATE INDEX "rubriques_id_cat" ON "rubriques" ("id_cat");
