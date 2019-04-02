use qcnat_sds_test;

INSERT INTO `inspection` (`IDInspection`, `IDEmploye`, `DateR`, `DateP`, `DateI`, `IDInstallation`, `Annee`, `IDResponsable`, `IDFacture`, `Mirador`, `SMU`, `Procedures`, `Perche`, `Bouees`, `Planche`, `Couverture`, `Registre`, `Chlore`, `ProfondeurPP`, `ProfondeurP`, `ProfondeurPente`, `Cercle`, `Verre`, `Bousculade`, `Maximum`, `EchellePP`, `EchelleX2P`, `Escalier`, `Cloture12`, `Cloture100`, `Maille38`, `Promenade`, `Fermeacle`, `Manuel`, `Antiseptique`, `Epingle`, `Pansement`, `BTria`, `Gaze50`, `Gaze100`, `Ouate`, `Gaze75`, `Compressif`, `Tape12`, `Tape50`, `Eclisses`, `Ciseau`, `Pince`, `Crayon`, `Masque`, `Gant`, `Envoye`, `Confirme`, `Materiel`, `MaterielPret`, `MaterielLivre`, `Notes`, `NotesMateriel`, `NotesAffichage`, `NotesConstruction`, `Chaloupe`, `ChaloupeRame`, `ChaloupeAncre`, `ChaloupeGilets`, `ChaloupeBouee`, `LigneBouee`, `BoueeProfond`, `Canotage`, `HeureSurveillance`, `LimitePlage`, `LongueurPlage`, `NotesBouees`) VALUES
(32, 2, NULL, 1244221200, 1244178000, 58, 2009, 67, 3664, 1, 1, 1, 1, 1, 1, 0, 0, 0, 100, 100, 100, 1, 25, 25, 150, 1, 1, 1, 1, 1, 1, 1, 1, 1, 20, 24, 10, 5, 2, 2, 4, 5, 0, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '');


INSERT INTO `installation` (`IDInstallation`, `IDClient`, `IDResponsable`, `IDHoraire`, `IDSecteur`, `Cote`, `Nom`, `Tel`, `Lien`, `Adresse`, `Notes`, `Actif`, `IDType`, `Punch`, `Toilettes`, `Assistant`, `Cadenas`, `Balance`, `Saison`, `Seq`, `Seqc`, `Factname`, `ASFact`, `AdresseFact`, `PONo`) VALUES (1, 1, 443, 4, 15, 'QI', 'Québec Inn', '41887292310', 'http://maps.google.ca/maps?f=q&hl=fr&q=7175,++boul.+Hamel+,+Ancienne-Lorette&sll=46.802424,-71.332698&sspn=0.274492,0.752563&ie=UTF8&z=16&iwloc=addr&om=1', '7175, Boul Hamel Ouest\r\nSte-Foy, Qc\r\nG2G 1B6\r\nfax: 872-1336\r\nTéléphone direct : 418 872-9991*0', '<b> PUNCH </b> \r\n - Le PUNCH est obligatoire à l\'ouverture et à la fermeture de la piscine.  Le code est 402.\r\n - N\'oubliez pas de récupérer la clé de la piscine en arrivant à la réception.  \r\n\r\n<b> SITUATION EXCEPTIONNELLE ET PERSONNE CONTACT </b>\r\nPour toutes questions, situation avec un client, ajustement de la réglementation, vous devez toujours vous référer à : <b> SUPERVISEUR À LA RÉCEPTION </b>.  Si un membre du personnel de l\'hôtel vous demande d\'effectuer un accroc à la réglementation(ex. maximum de baigneurs, etc.), merci d\'accepter et d\'indiquer clairement au registre, la nature de la modification, le membre du personnel qui en fait la demande ainsi que la date et l\'heure.\r\n\r\n<b> Matériels et tâches du sauveteur </b>\r\n  - Vous n\'êtes pas responsable des tests d\'eau ni de l\'entretien.  La maintenance s\'en chargera.\r\n  - Le trousse de premiers soins et le registre sont dans le bacs à serviettes sur le bord de la piscine.  \r\n  - Un DEA est disponible au gym (appartient à M. Jérôme Trépanier du centre de santé La Source).\r\n  - Merci de vous installer près du bac à serviettes.\r\n  - Au besoin, nettoyer les tables et les chaises.\r\n  - Des employés du gym circulent régulièrement près de la piscine, lorsque vous manquez de serviette, informez les afin qu\'ils placent un appel à la réception.  Si le tout est tranquille, vous pouvez vous même vous déplacer au gym pour faire l\'appel de service.\r\n  - En cas d\'urgence, le téléphone à proximité est celui situé au gym.  Le téléphone jaune est quand à lui relié directement au restaurant.\r\n  - Merci de ne pas nourrir les poissons.\r\n\r\n\r\n<b> Règlements </b> \r\n Tous les règlements de bases s\'appliquent à cette piscine (course, verre, bousculade, etc.).  À cela s\'ajoute : \r\n   - Les enfants de 16 ans et moins doivent être accompagnés d\'un adulte (+18 ans). \r\n   - Seuls les enfants de plus de 6 ans ont accès au spa.\r\n   - Pour le spa, nous vous demandons d\'encourager les clients à faire une rotation aux 15 à 20 minutes afin de permettre à tous d\'y accéder.\r\n   - Les sauts et les \"bombes\" sont interdites. Ayez une tolérance pour les jeunes enfants qui sautent dans les bras de leur parent.\r\n   - L\'alcool est permis mais seulement dans des verres en plastiques.  Si vous n\'en avez plus, demander à la réception.\r\n   - Aucune nourriture n\'est permise sur le bord de la piscine.\r\n   - La piscine est accessible aux clients de l\'hôtel mais également à ceux du gym et du centre de soins.  Tous peuvent accéder au sauna (situé dans le gym).\r\n\r\n\r\n<i> N\'oubliez pas de vous référer au registre en tout temps.  D\'autres informations importantes y sont indiquées. </i>', 1, 'IS', 1, '', 0, 0, 0, 1, 205, 44, 'Les Immeubles Jacques Robitaille Inc.', 'Nancy Hewitt', '<b>Québec Inn</b>\r\n7175, Boul Hamel Ouest\r\nSte-Foy, Qc\r\nG2G 1B6', ''),(25, 1, 29, 73, 0, 'ASF', 'L\\\'auberge Sir Wilfrid', '4186512440', 'http://maps.google.ca/maps?f=q&hl=fr&q=3055+Boulevard+Laurier,+Sainte-Foy,+Communaut%C3%A9-Urbaine-de-Qu%C3%A9bec,+Qu%C3%A9bec&sll=46.78462,-71.361551&sspn=0.008581,0.023518&ie=UTF8&om=1&cd=1&geocode=FUeTyQIdzSjA-w&split=0&z=16&iwloc=A', '3055 Boul. Laurier\r\nQuébec, Qc\r\nG1V 4X2', 'PUNCH obligatoire à l\\\'ouverture et à la fermeture de la piscine.  Le code est 713.\r\nDE PLUS, vous devrez remplir une feuille de temps en y mettant vos initiales.\r\nClés, trousse, punch et registre à la réception. \r\n*téléphone le plus près : dans le couloir entre la réception et la piscine', 1, 'E', 1, 'près de la réception', 0, 0, 0, 1, 50, 17, 'Les Immeubles Jacques Robitaille Inc.', 'Nancy Hewitt', '<b>Auberge Québec</b>\r\n3055 Boul. Laurier\r\nQuébec (QC)\r\nGiV 2X4', ''),
(21, 35, 446, 58, 0, 'IR', '3500 Maricourt', '418', 'http://maps.google.ca/maps?f=q&hl=fr&q=3500+Avenue+Maricourt,+Sainte-Foy,+Communaut%C3%A9-Urbaine-de-Qu%C3%A9bec,+Qu%C3%A9bec&sll=46.869402,-71.193992&sspn=0.008567,0.023518&ie=UTF8&om=1&cd=1&geocode=FS2ByQIdGcW_-w&split=0&z=16&iwloc=r0', '3500 ave Maricourt\r\nSainte-Foy', 'Les clefs pour l\'Immeuble et la porte de rangement (SS gauche 3499) se trouve dans le cadena. Les clefs de la piscine et de la porte du filteur (SS droite 3499) avec le registre où se trouve le rangement.\r\n si vous devez quittez pour aller a la salle de bain ou remplir votre gourde d\'eau svp laissez une note comme quoi vous serez de retour dans 5 min à la piscine.\r\nIl n\'y a pas de concierge sur place. En cas de besoin, contacter le bureau de SDS. ', 1, 'E', 0, 'toilette 3499 au sous-sol', 0, 1, 0, 1, 0, 0, '', '', '', ''),
(58, 62, 419, 35, 6, 'LO', 'Îlot St-Pierre', '418', 'https://www.google.ca/maps/place/4410+Rue+des+Roses,+Ville+de+Qu%C3%A9bec,+QC+G1G+1P2/@46.8824046,-71.2832669,19z/data=!3m1!4b1!4m5!3m4!1s0x4cb8bd2cc5ea0e09:0xd7149c6508e89c86!8m2!3d46.8824046!4d-71.2827197?hl=fr', '4410, des Roses', '<b>Les locataires auront une carte à montrer pour accéder à la piscine  à compter du 6 juillet : pas de carte d\'accès, pas de baignade...soyez strict!! \r\nMaximum 2 invités par locataire </b>\r\n\r\nLe matériel des sauveteurs est dans le cabanon près de la piscine. \r\n Merci de sortir le matériel à votre arrivée, et de le ranger quand vous quittez.\r\n Les sauveteurs sont en charge de l\'entretien (balayeuse, backwash, cerne et ajout de produits). \r\n En cas de besoin, contactez le concierge :  M. Stéphane Despins 418-609-3989.\r\n\r\n Maximum 2 invités par locataire. ', 1, 'E', 0, 'l’appartement des concierges au 4298 des Roses appartement 404.', 0, 1, 0, 1, 0, 0, '', '', '', '');

INSERT INTO `client` (`IDClient`, `Nom`, `Cote`, `Facturation`, `FrequenceFacturation`, `Email`, `Fax`, `Tel`, `Adresse`, `RespP`, `RespF`, `Notes`, `Actif`, `TXH`, `Ferie`, `Piece`, `Balance`, `Depot`, `DepotP`, `Password`, `NBAcces`) VALUES
(1, 'Hôtels Jaro', '', 'E', 'H', 'payables@hotelsjaro.com;nhewitt@hotelsjaro.com ', '418', '4186585665', '', 33, 33, '', 1, 18.25, 1, 0, '0', 0, 0, 'mireille1', 40),
(17, 'Customer with Mensual Facture with outstanding Balance.', 'RMB', 'F', 'M', 'vigmgr@raamco.ca', '4506468141', '4504686200', '2480 Roland Therrien #210, Longueuil, Qc J4L4G1', 0, 0, '19.05', 1, 19.05, 1.5, 0, '0', 0, 0, 'admin', 3),
(18, 'Customer with no outstanding balance.', 'RMN', 'F', 'M', 'vigmgr@raamco.ca', '4506468141', '4504686200', '2480 Roland Therrien #210, Longueuil, Qc J4L4G1', 0, 0, '19.05', 1, 19.05, 1.5, 0, '0', 0, 0, 'admin', 3);

INSERT INTO `facture` (`IDFacture`, `Cote`, `Sequence`, `BonAchat`, `TPS`, `TVQ`, `STotal`, `Debit`, `Credit`, `Notes`, `Semaine`, `Paye`, `Utilise`, `EnDate`, `Materiel`, `AvanceClient`) VALUES
  (2256, 'PCV', 13, '', 0.05, 0.095, 3692.43, 1,0, '1st installment for lifeguard pool service contract', 1527393600, 1,0, 1527535405, 0, 0),
  (2298, 'PCV', 14, '', 0.05, 0.095, 100.51, 1,0, '', 1529812800, 0, 0,1530627972, 0, 0),
  (23  , 'ABC', 68, '', 0.05, 0.095, 100.51, 1,0, '', 1529812800, 0, 0,1530627972, 0, 0),

  (1337, 'TDF', 1,  '', 0.05, 0.095, 100, 1,0, '', 1509220851, 0,0, 1509220851, 0, 0), # date de 2017
  (1338, 'TDF', 2,  '', 0.05, 0.095, 200, 1,0, '', 1529812800, 0,0, 1530627972, 0, 0), # normale
  (1339, 'TDF', 3,  '', 0.05, 0.095, 300, 1,0, '', 1529812800, 0,0, 1530627973, 0, 0), # normale-payee
  (1340, 'TDF', 4,  '', 0.05, 0.095,  10, 1,0, '', 1529812800, 0,0, 1530627974, 0, 0), # materiel
  (1341, 'TDF', 5,  '', 0.05, 0.095, 100, 1,0, '', 1529812800, 0,0, 1530627975, 0, 0), # materiel-payee
  (1342, 'TDF', 6,  '', 0.05, 0.095, 400, 1,0, '', 1529812800, 0,0, 1530627976, 0, 0), # normale-creditee
  (1343, 'TDF', 7,  '', 0.05, 0.095, 500, 1,0, '', 1529812800, 1,0, 1530627977, 0, 0), # normale partiellement-payee
  (1344, 'TDF', 8,  '', 0.05, 0.095, 500, 1,0, '', 1529812800, 0,0, 1530627978, 0, 0), # normale partiellement-creditee
  (1345, 'TDF', 9,  '', 0.05, 0.095, 100, 1,0, '', 1529812800, 0,0, 1530627978, 0, 0), # normale payee dans un pmt a 2 facture avec debalance
  (1346, 'TDF', 10, '', 0.05, 0.095, 100, 1,0, '', 1529812800, 0,0, 1530627978, 0, 0), # normale payee dans un pmt a 2 facture avec debalance

  (1347, 'TDF', 1, '', 0.05, 0.095, -400, 0,1, '', 1529812800, 1,0, 1530627977, 0, 0), # credit pour TDF-6
  (1348, 'TDF', 2, '', 0.05, 0.095, -400, 0,1, '', 1529812800, 1,0, 1530627979, 0, 0), # credit pour TDF-8

  (2000, 'TDF', 1, '', 0, 0, 200, 0,0, '', 1529812800, 0,0, 1530627972, 0, 1), # AvanceClient non utilisee
  (2001, 'TDF', 2, '', 0, 0, 400, 0,0, '', 1529812800, 0,1, 1530627972, 0, 1), # AvanceClient utilisee

  (1349, 'TF', 1, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0), # Test Facture - Facture payee
  (1350, 'TF', 2, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 0,0, 1530627972, 0, 0), # Test Facture - Facture non payee
  (1353, 'TF', 3, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0), # Test Facture - Facture payee
  (1359, 'TF', 4, '', 0.05, 0.095, 100, 1,0, '', 1529812800, 0,0, 1530627972, 1, 0), # Test Facture - Materiel non payée
  (1351, 'TF', 1, '', 0.05, 0.095, -400,0,1, '', 1529812800, 1,0, 1530627972, 0, 0), # Test Facture - credit

  (1353, 'TPM', 1, '', 0.05, 0.095, 100, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0), # Test Payment - paye total (1/1)
  (1354, 'TPM', 2, '', 0.05, 0.095, 200, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0), # Test Payment - paye total (1/2)
  (1355, 'TPM', 4, '', 0.05, 0.095, 300, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0), # Test Payment - paye partiel (1/1)
  (1356, 'TPM', 5, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0), # Test Payment - paye partiel (1/2)
  (1357, 'TPM', 6, '', 0.05, 0.095, 500, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0), # Test Payment - paye partiel (2/2)
  (1358, 'TPM', 3, '', 0.05, 0.095, 600, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0), # Test Payment - paye total (2/2)
  # (1359, 'TF', 4, '', 0.05, 0.095, 100, 1,0, '', 1529812800, 1,0, 1530627972, 1, 0), # Test Facture - Facture payee

  (3000, 'TFS', 1, '', 0.05, 0.095, 100, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0), # Facture Shift 1
  (3001, 'TFS', 2, '', 0.05, 0.095, 200, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0), # Facture Materiel 1
  (3002, 'TFS', 3, '', 0.05, 0.095, 600, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0), # Facture Materiel 2
  (3003, 'TFS', 4, '', 0.05, 0.095, 300, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0), # Facture Shift 2
  (3004, 'TFS', 1, '', 0.05, 0.095, -400, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0), # Credit 1
  (3005, 'TFS', 2, '', 0.05, 0.095, -500, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0), # Credit 2

  (3006, 'TFS', 1, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0), # Avance Client 1
  (3007, 'TPS', 1, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0), # Facture payee par le paiement

  (3010, 'TFF', 1, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 0,0, 1530627972, 0, 0), # Facture shift
  (3011, 'TFF', 2, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 0,0, 1530627972, 1, 0), # Facture materiel
  (3012, 'TFF', 3, '', 0.05, 0.095, -400, 1,1, '', 1529812800, 0,0, 1530627972, 0, 0), # credit
  (3013, 'TFF', 4, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 0,0, 1530627972, 0, 1), # avance client

  (3014, 'RMB', 4, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 0,0, 1530627972, 0, 1); # Facture pour client avec outstading Balance

INSERT INTO `paiement` (`IDPaiement`, `Cote`, `Montant`, `Date`, `PayableYear`,`Notes`) VALUES
  (99 , 'TDF', 344.92, 1509220851,2017, ''),                 # date de 2017
  (98 , 'TDF', 114.97, 1530629972,2017, ' Paye:~TDF-1~'),    # paye une facture de 2017 en 2018
  (100, 'TDF', 344.92, 1530629973,2018, ' Paye:~TDF-3~'),    # paiement complet facture normale
  (101, 'TDF', 114.97, 1530629974,2018, ' Paye:~TDF-5~'),    # paiement complet facture materiel
  (102, 'TDF', 200, 1530629975,2018, ' Paye:~TDF-7~'),       # paiement partiel facture normale
  (103, 'TDF', 200, 1530627800,2018, ' Paye:~TDF-9~TDF-10'), # paiement partiel pour deux factures
  (97, 'TDF', 200, 1530629972,2019, ''),                    # paiement d'avance pour 2019...

  (104, 'TPM', 114.98, 1530629972,2018, ' Paye:~TPM-1~'), # paiement total pour 1 facture
  (105, 'TPM', 919.8, 1530629972,2018, ' Paye:~TPM-2~TPM-3'), # paiement total pour deux factures
  (106, 'TPM', 200, 1530629972,2018, ' Paye:~TPM-4~'), # paiement partiel pour une factures
  (107, 'TPM', 300, 1530629972,2018, ' Paye:~TPM-5~TPM-6'), # paiement partiel pour deux factures

  (108, 'TF', 100, 1530629972, 2018,' Paye:~TF-1~'),    # paiement complet facture normale
  (109, 'TF', 200, 1530629972, 2018,' Paye:~TF-3~'),    # paiement complet facture normale

  # (110, 'TPS', 100,1529812800, 2018,'  Paye:~TPS-1~')             # Placeholder pour le ID 110 (genere dans un test)
  (111, 'TPS', 100,1530629972, 2018,'  Paye:~TPS-1~'),             # Placeholder pour le ID 110 (genere dans un test)
  (112, 'TPS', 200,1530629972, 2018,'  Paye:~TPS-2~'),            # Placeholder pour le ID 110 (genere dans un test)

  (606, 'PCV', 3692.43, 1530645750, 2018,' Paye:~PCV-13~');

INSERT INTO `employe` (`IDEmploye`, `Prenom`, `Nom`, `HName`, `NAS`, `Adresse`, `CodePostal`, `DateNaissance`, `DateEmbauche`, `IDSecteur`, `Ville`, `TelP`, `TelA`, `Cell`, `Paget`, `Email`, `Session`, `Status`, `Engage`, `Cessation`, `Notes`, `Raison`, `SalaireB`, `SalaireS`, `SalaireA`, `Ajustement`, `LastVisited`, `EAssistant`) VALUES
  (2, 'Julie', 'Fortin', 'Ju in the sky', '281302976', '4385, des Sarcelles', 'G1G4W5', 471848400, 993960000, '22', 'Québec', '4189973876', '', '4189973876', '418', 'julie.fortin.16@ulaval.ca', '', 'Bureau', 1, 0, 'SN expire: 12/2011', '', 11.4, 11.4, 10.9, 0, 1530129400, 0),
  (90, 'Jean-Thomas', 'Baillargeon', 'JT', '281659714', '3305, boul Hawey', 'G1E1N8', 510987600, 1051761600, '1', 'Québec', '4186601934', '418', '418', '418', 'jtbaillargeon@hotmail.com', '', 'Temps plein', 1, 0, '', '', 12, 14.3, 13.7, 0, 1331060074, 0);

INSERT INTO `shift` (`IDShift`, `IDInstallation`, `IDEmploye`, `TXH`, `Salaire`, `Start`, `End`, `Jour`, `Semaine`, `Assistant`, `Commentaire`, `Warn`, `Confirme`, `Empconf`, `Facture`, `Paye`, `Message`) VALUES
  (1337, 21, 2, 16.75, 0, 34200, 75600, 0, 1497153600, 0, '', '', 1, 1, 1, 0, 'Vers 14h30, il est important de contacter le chef réceptionniste avant de confirmer l\\\'heure de fin.  Si tu termines bien à 15h, tu n\\\'auras techniquement pas à faire de démontage.');

INSERT INTO `vars` (`Nom`, `Valeur`, `Type`) VALUES
  ('Saison', 'E18', 'string'),
  ('TPS', '0.050', 'float'),
  ('TVQ', '0.095', 'float'),
  ('Augmentation', '0.03', 'float'),
  ('NoteFacture', 'Merci, bonne semaine', 'string'),
  ('Boniyear', '2018', 'int'),
  ('MP', '07818b79ae41658fa619c47b86731ab6', 'string'),
  ('TVQShown', '9.975', 'String'),
  ('super_admin_password', 'a97a058d8601fd45d561f8ce1262abb6', 'string');


INSERT INTO `responsable` (`IDResponsable`, `Titre`, `Prenom`, `Nom`, `Tel`, `Cell`, `Appartement`, `Resp`) VALUES
(0, 'M.', 'prenom', 'nom', '4186536672', '418', '', ''),
(33, 'Mme', 'lolk', 'Roboto', '41865856654234', '418', '', '');
