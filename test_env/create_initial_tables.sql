use qcnat_sds_test;
CREATE TABLE `client` (
  `IDClient` int(11) NOT NULL,
  `Nom` varchar(255) NOT NULL DEFAULT '',
  `Cote` char(3) NOT NULL DEFAULT '',
  `Facturation` char(1) NOT NULL DEFAULT '',
  `FrequenceFacturation` char(1) NOT NULL DEFAULT 'H' COMMENT 'H= Hebdomadaire; M=Mensuel',
  `Email` varchar(255) NOT NULL DEFAULT '',
  `Fax` varchar(10) NOT NULL DEFAULT '',
  `Tel` varchar(10) NOT NULL DEFAULT '',
  `Adresse` text NOT NULL,
  `RespP` int(11) NOT NULL DEFAULT '0',
  `RespF` int(11) NOT NULL DEFAULT '0',
  `Notes` text NOT NULL,
  `Actif` tinyint(4) NOT NULL DEFAULT '1',
  `TXH` float NOT NULL DEFAULT '0',
  `Ferie` float NOT NULL DEFAULT '1',
  `Piece` tinyint(4) NOT NULL DEFAULT '0',
  `Balance` decimal(10,0) NOT NULL DEFAULT '0',
  `Depot` int(11) NOT NULL DEFAULT '0',
  `DepotP` tinyint(4) NOT NULL DEFAULT '0',
  `Password` varchar(30) NOT NULL DEFAULT 'admin',
  `NBAcces` smallint(6) NOT NULL DEFAULT '3'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


CREATE TABLE `inspection` (
  `IDInspection` int(11) NOT NULL,
  `IDEmploye` int(11) NOT NULL DEFAULT '0',
  `DateR` bigint(20) DEFAULT NULL,
  `DateP` bigint(20) DEFAULT NULL,
  `DateI` bigint(20) DEFAULT NULL,
  `IDInstallation` int(11) NOT NULL DEFAULT '0',
  `Annee` int(11) NOT NULL DEFAULT '0',
  `IDResponsable` int(11) DEFAULT NULL,
  `IDFacture` int(11) DEFAULT NULL,
  `Mirador` tinyint(4) NOT NULL DEFAULT '0',
  `SMU` tinyint(4) NOT NULL DEFAULT '0',
  `Procedures` tinyint(4) NOT NULL DEFAULT '0',
  `Perche` tinyint(4) NOT NULL DEFAULT '0',
  `Bouees` tinyint(4) NOT NULL DEFAULT '0',
  `Planche` tinyint(4) NOT NULL DEFAULT '0',
  `Couverture` tinyint(4) NOT NULL DEFAULT '0',
  `Registre` tinyint(4) NOT NULL DEFAULT '0',
  `Chlore` tinyint(4) NOT NULL DEFAULT '0',
  `ProfondeurPP` smallint(6) NOT NULL DEFAULT '0',
  `ProfondeurP` smallint(6) NOT NULL DEFAULT '0',
  `ProfondeurPente` smallint(6) NOT NULL DEFAULT '0',
  `Cercle` tinyint(4) NOT NULL DEFAULT '0',
  `Verre` smallint(6) NOT NULL DEFAULT '0',
  `Bousculade` smallint(6) NOT NULL DEFAULT '0',
  `Maximum` smallint(4) NOT NULL DEFAULT '0',
  `EchellePP` tinyint(4) NOT NULL DEFAULT '0',
  `EchelleX2P` tinyint(4) NOT NULL DEFAULT '0',
  `Escalier` tinyint(4) NOT NULL DEFAULT '0',
  `Cloture12` tinyint(4) NOT NULL DEFAULT '0',
  `Cloture100` tinyint(4) NOT NULL DEFAULT '0',
  `Maille38` tinyint(4) NOT NULL DEFAULT '0',
  `Promenade` tinyint(4) NOT NULL DEFAULT '0',
  `Fermeacle` tinyint(4) NOT NULL DEFAULT '0',
  `Manuel` smallint(6) NOT NULL DEFAULT '0',
  `Antiseptique` smallint(6) NOT NULL DEFAULT '0',
  `Epingle` smallint(6) NOT NULL DEFAULT '0',
  `Pansement` smallint(6) NOT NULL DEFAULT '0',
  `BTria` smallint(6) NOT NULL DEFAULT '0',
  `Gaze50` smallint(6) NOT NULL DEFAULT '0',
  `Gaze100` smallint(6) NOT NULL DEFAULT '0',
  `Ouate` smallint(6) NOT NULL DEFAULT '0',
  `Gaze75` smallint(6) NOT NULL DEFAULT '0',
  `Compressif` smallint(6) NOT NULL DEFAULT '0',
  `Tape12` smallint(6) NOT NULL DEFAULT '0',
  `Tape50` smallint(6) NOT NULL DEFAULT '0',
  `Eclisses` smallint(6) NOT NULL DEFAULT '0',
  `Ciseau` smallint(6) NOT NULL DEFAULT '0',
  `Pince` smallint(6) NOT NULL DEFAULT '0',
  `Crayon` smallint(6) NOT NULL DEFAULT '0',
  `Masque` smallint(6) NOT NULL DEFAULT '0',
  `Gant` smallint(6) NOT NULL DEFAULT '0',
  `Envoye` tinyint(4) NOT NULL DEFAULT '0',
  `Confirme` tinyint(4) NOT NULL DEFAULT '0',
  `Materiel` tinyint(4) NOT NULL DEFAULT '0',
  `MaterielPret` tinyint(4) NOT NULL DEFAULT '0',
  `MaterielLivre` tinyint(4) NOT NULL DEFAULT '0',
  `Notes` text,
  `NotesMateriel` text,
  `NotesAffichage` text,
  `NotesConstruction` text,
  `Chaloupe` tinyint(4) DEFAULT NULL,
  `ChaloupeRame` tinyint(4) DEFAULT NULL,
  `ChaloupeAncre` tinyint(4) DEFAULT NULL,
  `ChaloupeGilets` tinyint(4) DEFAULT NULL,
  `ChaloupeBouee` tinyint(4) DEFAULT NULL,
  `LigneBouee` tinyint(4) DEFAULT NULL,
  `BoueeProfond` tinyint(4) DEFAULT NULL,
  `Canotage` tinyint(4) DEFAULT NULL,
  `HeureSurveillance` tinyint(4) DEFAULT NULL,
  `LimitePlage` tinyint(4) DEFAULT NULL,
  `LongueurPlage` tinyint(4) DEFAULT NULL,
  `NotesBouees` text
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE `installation` (
  `IDInstallation` int(11) NOT NULL,
  `IDClient` int(11) NOT NULL DEFAULT '0',
  `IDResponsable` int(11) NOT NULL DEFAULT '0',
  `IDHoraire` int(11) DEFAULT NULL,
  `IDSecteur` int(11) NOT NULL DEFAULT '0',
  `Cote` char(3) NOT NULL DEFAULT '',
  `Nom` varchar(255) NOT NULL DEFAULT '',
  `Tel` varchar(15) NOT NULL DEFAULT '',
  `Lien` mediumtext NOT NULL,
  `Adresse` mediumtext NOT NULL,
  `Notes` mediumtext NOT NULL,
  `Actif` tinyint(1) NOT NULL DEFAULT '1',
  `IDType` char(2) NOT NULL DEFAULT '',
  `Punch` smallint(6) NOT NULL DEFAULT '0',
  `Toilettes` mediumtext NOT NULL,
  `Assistant` smallint(6) NOT NULL DEFAULT '0',
  `Cadenas` smallint(1) NOT NULL DEFAULT '0',
  `Balance` float NOT NULL DEFAULT '0',
  `Saison` tinyint(4) NOT NULL DEFAULT '1',
  `Seq` int(11) NOT NULL DEFAULT '0',
  `Seqc` int(11) NOT NULL DEFAULT '0',
  `Factname` varchar(255) NOT NULL DEFAULT '',
  `ASFact` varchar(255) NOT NULL DEFAULT '',
  `AdresseFact` mediumtext NOT NULL,
  `PONo` varchar(50) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `facture` (
  `IDFacture` int(11) NOT NULL,
  `Cote` char(3) NOT NULL DEFAULT '0',
  `Sequence` float NOT NULL DEFAULT '0',
  `BonAchat` varchar(255) NOT NULL DEFAULT '',
  `TPS` float NOT NULL DEFAULT '0',
  `TVQ` float NOT NULL DEFAULT '0',
  `STotal` float NOT NULL DEFAULT '0',
  `Credit` tinyint(4) NOT NULL DEFAULT '0',
  `Notes` text NOT NULL,
  `Semaine` bigint(20) NOT NULL DEFAULT '0',
  `Paye` tinyint(4) NOT NULL DEFAULT '0',
  `EnDate` bigint(20) NOT NULL DEFAULT '0',
  `Materiel` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `paiement` (
  `IDPaiement` int(11) NOT NULL,
  `Cote` char(3) NOT NULL DEFAULT '',
  `Montant` float NOT NULL DEFAULT '0',
  `Date` bigint(20) NOT NULL DEFAULT '0',
  `PayableYear` int(11) NOT NULL DEFAULT '0',
  `Notes` varchar(255) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

CREATE TABLE `employe` (
  `IDEmploye` int(11) NOT NULL,
  `Prenom` varchar(255) NOT NULL DEFAULT '',
  `Nom` varchar(255) NOT NULL DEFAULT '',
  `HName` varchar(25) NOT NULL DEFAULT '',
  `NAS` varchar(9) NOT NULL DEFAULT '',
  `Adresse` mediumtext NOT NULL,
  `CodePostal` varchar(6) NOT NULL DEFAULT '',
  `DateNaissance` bigint(20) NOT NULL DEFAULT '0',
  `DateEmbauche` bigint(20) NOT NULL DEFAULT '0',
  `IDSecteur` varchar(255) NOT NULL DEFAULT '',
  `Ville` varchar(50) NOT NULL DEFAULT 'QC',
  `TelP` varchar(10) NOT NULL DEFAULT '',
  `TelA` varchar(10) NOT NULL DEFAULT '',
  `Cell` varchar(10) NOT NULL DEFAULT '',
  `Paget` varchar(10) NOT NULL DEFAULT '',
  `Email` varchar(255) NOT NULL DEFAULT '',
  `Session` char(3) NOT NULL DEFAULT '',
  `Status` varchar(255) NOT NULL DEFAULT '',
  `Engage` tinyint(4) NOT NULL DEFAULT '1',
  `Cessation` tinyint(4) NOT NULL DEFAULT '0',
  `Notes` mediumtext NOT NULL,
  `Raison` mediumtext NOT NULL,
  `SalaireB` float NOT NULL DEFAULT '0',
  `SalaireS` float NOT NULL DEFAULT '0',
  `SalaireA` float NOT NULL DEFAULT '0',
  `Ajustement` float NOT NULL DEFAULT '0',
  `LastVisited` bigint(20) NOT NULL DEFAULT '0',
  `EAssistant` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `employe`
  ADD PRIMARY KEY (`IDEmploye`);

ALTER TABLE `employe`
  MODIFY `IDEmploye` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12347;

CREATE TABLE `shift` (
  `IDShift` int(11) NOT NULL,
  `IDInstallation` int(11) NOT NULL DEFAULT '0',
  `IDEmploye` int(11) DEFAULT '0',
  `TXH` float NOT NULL DEFAULT '0',
  `Salaire` float NOT NULL DEFAULT '0',
  `Start` bigint(20) NOT NULL DEFAULT '0',
  `End` bigint(20) NOT NULL DEFAULT '0',
  `Jour` int(11) NOT NULL DEFAULT '0',
  `Semaine` bigint(20) NOT NULL DEFAULT '0',
  `Assistant` tinyint(4) NOT NULL DEFAULT '0',
  `Commentaire` mediumtext NOT NULL,
  `Warn` mediumtext NOT NULL,
  `Confirme` tinyint(4) NOT NULL DEFAULT '0',
  `Empconf` tinyint(4) NOT NULL DEFAULT '0',
  `Facture` tinyint(4) NOT NULL DEFAULT '0',
  `Paye` tinyint(4) NOT NULL DEFAULT '0',
  `Message` mediumtext NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

ALTER TABLE `shift`
  ADD PRIMARY KEY (`IDShift`);

ALTER TABLE `shift`
  MODIFY `IDShift` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=202808;


CREATE TABLE `vars` (
  `Nom` varchar(50) NOT NULL DEFAULT '',
  `Valeur` varchar(255) NOT NULL DEFAULT '',
  `Type` varchar(25) NOT NULL DEFAULT ''
) ENGINE=MyISAM DEFAULT CHARSET=latin1;
