#------------------------------------------------------------
#        Script MySQL.
#------------------------------------------------------------


#------------------------------------------------------------
# Table: vendeurs
#------------------------------------------------------------

CREATE TABLE vendeurs(
        mailVendeur   Varchar (100) NOT NULL ,
        nomVendeur    Varchar (20) NOT NULL ,
        prenomVendeur Varchar (20) NOT NULL ,
        mdpVendeur    Char (60) NOT NULL ,
        telvendeur    Char (10) NOT NULL
	,CONSTRAINT vendeurs_PK PRIMARY KEY (mailVendeur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: commerces
#------------------------------------------------------------

CREATE TABLE commerces(
        numSiretCommerce   Char (14) NOT NULL ,
        nomCommerce        Varchar (50) NOT NULL ,
        libelleCommerce    Varchar (255) ,
        adresseCommerce    Varchar (80) NOT NULL ,
        villeCommerce      Varchar (30) NOT NULL ,
        codePostalCommerce Char (5) NOT NULL ,
        telCommerce        Char (10) NOT NULL ,
        codeReduction      Varchar (10) NOT NULL
	,CONSTRAINT commerces_PK PRIMARY KEY (numSiretCommerce)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: Jours
#------------------------------------------------------------

CREATE TABLE Jours(
        nomJour             Varchar (8) NOT NULL ,
        heureOuvertureMatin Char (2) ,
        heureFermetureMatin Char (2) ,
        heureOuvertureAprem Char (2) ,
        heureFermetureAprem Char (2)
	,CONSTRAINT Jours_PK PRIMARY KEY (nomJour)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: tags
#------------------------------------------------------------

CREATE TABLE tags(
        numTag Int  Auto_increment  NOT NULL ,
        nomTag Varchar (20) NOT NULL
	,CONSTRAINT tags_PK PRIMARY KEY (numTag)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: typeProduits
#------------------------------------------------------------

CREATE TABLE typeProduits(
        numTypeProduit     Int  Auto_increment  NOT NULL ,
        libelleTypeProduit Varchar (255) NOT NULL ,
        couleur            Varchar (10) NOT NULL ,
        taille             Varchar (10) NOT NULL ,
        marque             Varchar (15) NOT NULL ,
        tempsReservation   Varchar (15) NOT NULL
	,CONSTRAINT typeProduits_PK PRIMARY KEY (numTypeProduit)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: appartenir
#------------------------------------------------------------

CREATE TABLE appartenir(
        numSiretCommerce Char (14) NOT NULL ,
        mailVendeur      Varchar (100) NOT NULL
	,CONSTRAINT appartenir_PK PRIMARY KEY (numSiretCommerce,mailVendeur)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: ouvrir
#------------------------------------------------------------

CREATE TABLE ouvrir(
        nomJour          Varchar (8) NOT NULL ,
        numSiretCommerce Char (14) NOT NULL
	,CONSTRAINT ouvrir_PK PRIMARY KEY (nomJour,numSiretCommerce)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: produits
#------------------------------------------------------------

CREATE TABLE produits(
        numProduit           Int  Auto_increment  NOT NULL ,
        nomProduit           Varchar (50) NOT NULL ,
        libelleProduit       Varchar (50) NOT NULL ,
        qteStockProduit      Varchar (10) NOT NULL ,
        qteStockDispoProduit Varchar (10) NOT NULL ,
        livraisonProduit     Bool NOT NULL ,
        prixProduit          Varchar (10) NOT NULL ,
        qte2                 Varchar (5) NOT NULL ,
        qte1                 Varchar (5) NOT NULL ,
        numSiretCommerce     Char (14) NOT NULL ,
        numTypeProduit       Int NOT NULL ,
        numCommande          Int ,
        numReservation       Int
	,CONSTRAINT produits_PK PRIMARY KEY (numProduit)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: commandes
#------------------------------------------------------------

CREATE TABLE commandes(
        numCommande        Int  Auto_increment  NOT NULL ,
        prixCommande       Varchar (5) NOT NULL ,
        prixReduitCommande Varchar (5) NOT NULL ,
        paiementEnLigne    Bool NOT NULL ,
        dateCommande       Date NOT NULL ,
        numSiretCommerce   Char (14) NOT NULL ,
        numPanier          Int NOT NULL
	,CONSTRAINT commandes_PK PRIMARY KEY (numCommande)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: reservations
#------------------------------------------------------------

CREATE TABLE reservations(
        numReservation  Int  Auto_increment  NOT NULL ,
        dateReservation Date NOT NULL ,
        mailClient      Varchar (100) NOT NULL
	,CONSTRAINT reservations_PK PRIMARY KEY (numReservation)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: avis
#------------------------------------------------------------

CREATE TABLE avis(
        numAvis         Int  Auto_increment  NOT NULL ,
        commentaireAvis Varchar (255) NOT NULL ,
        noteAvis        Char (1) NOT NULL ,
        dateAvis        Date NOT NULL ,
        numProduit      Int NOT NULL ,
        mailClient      Varchar (100) NOT NULL
	,CONSTRAINT avis_PK PRIMARY KEY (numAvis)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: reductions
#------------------------------------------------------------

CREATE TABLE reductions(
        numReduction       Int  Auto_increment  NOT NULL ,
        pointsReduction    Varchar (5) NOT NULL ,
        dateDebutReduction Date NOT NULL ,
        dateFinReduction   Date NOT NULL ,
        mailClient         Varchar (100) NOT NULL
	,CONSTRAINT reductions_PK PRIMARY KEY (numReduction)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: paniers
#------------------------------------------------------------
CREATE TABLE paniers(
        numPanier        Int  Auto_increment  NOT NULL ,
        datePanier       Date NOT NULL ,
        prixPanier       Varchar (5) NOT NULL ,
        prixReduitPanier Varchar (5) NOT NULL ,
        qtePointsAcquis  Varchar (5) NOT NULL ,
        mailClient       Varchar (100) NOT NULL
	,CONSTRAINT paniers_PK PRIMARY KEY (numPanier)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: clients
#------------------------------------------------------------

CREATE TABLE clients(
        mailClient       Varchar (100) NOT NULL ,
        nomClient        Varchar (20) NOT NULL ,
        prenomClient     Varchar (20) NOT NULL ,
        mdpClient        Char (60) NOT NULL ,
        adresseClient    Varchar (80) NOT NULL ,
        villeClient      Varchar (30) NOT NULL ,
        codePostalClient Char (5) NOT NULL ,
        telClient        Char (5) NOT NULL ,
        numReduction     Int NOT NULL
	,CONSTRAINT clients_PK PRIMARY KEY (mailClient)
)ENGINE=InnoDB;


#------------------------------------------------------------
# Table: inclure
#------------------------------------------------------------

CREATE TABLE inclure(
        numTag     Int NOT NULL ,
        numProduit Int NOT NULL
	,CONSTRAINT inclure_PK PRIMARY KEY (numTag,numProduit)
)ENGINE=InnoDB;
