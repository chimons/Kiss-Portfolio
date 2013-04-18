CREATE TABLE "articles" (
  "id_article" integer PRIMARY KEY AUTOINCREMENT ,
  "id_rubrique" int(11) NOT NULL,
  "art_titre" varchar(255) ,
  "art_url" varchar(255) ,
  "art_type_lien" varchar(255) ,
  "art_texte" varchar(255) ,
  "art_position" tinyint(4) DEFAULT 0,
  "active" tinyint(4) DEFAULT 0,
  CONSTRAINT "articles_ibfk_1" FOREIGN KEY ("id_rubrique") REFERENCES "rubriques" ("id_rubrique")
);
CREATE TABLE "categories" (
  "id_cat" integer PRIMARY KEY AUTOINCREMENT,
  "cat_titre" varchar(255) ,
  "cat_chapeau" varchar(255) ,
  "cat_position" tinyint(4) DEFAULT 0,
  "active" tinyint(4) DEFAULT 0
);
CREATE TABLE "infos" (
  "id" integer PRIMARY KEY AUTOINCREMENT ,
  "auteur" varchar(50) NOT NULL DEFAULT 'auteur',
  "url" varchar(255) NOT NULL DEFAULT 'url',
  "nomdusite" varchar(255) NOT NULL DEFAULT 'nom du site',
  "footer" varchar(255) DEFAULT 'Portfolio 2013'
);
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
CREATE TABLE "types_liens" ("id" INTEGER PRIMARY KEY  NOT NULL  UNIQUE , "code" VARCHAR, "libelle" VARCHAR);
INSERT INTO "types_liens" VALUES(1,'pdf','Fichier PDF');
INSERT INTO "types_liens" VALUES(2,'word','Fichier DOC');
INSERT INTO "types_liens" VALUES(3,'zip','Archive');
INSERT INTO "types_liens" VALUES(4,'externe','Lien externe');
INSERT INTO "types_liens" VALUES(5,'aucun','Aucun');
CREATE INDEX "articles_id_rubrique" ON "articles" ("id_rubrique");
CREATE INDEX "articles_id_rubrique" ON "articles" ("id_rubrique");
CREATE INDEX "rubriques_id_cat" ON "rubriques" ("id_cat");
