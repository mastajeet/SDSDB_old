use qcnat_sds_test;

INSERT INTO `inspection` (`IDInspection`, `IDEmploye`, `DateR`, `DateP`, `DateI`, `IDInstallation`, `Annee`, `IDResponsable`, `IDFacture`, `Mirador`, `SMU`, `Procedures`, `Perche`, `Bouees`, `Planche`, `Couverture`, `Registre`, `Chlore`, `ProfondeurPP`, `ProfondeurP`, `ProfondeurPente`, `Cercle`, `Verre`, `Bousculade`, `Maximum`, `EchellePP`, `EchelleX2P`, `Escalier`, `Cloture12`, `Cloture100`, `Maille38`, `Promenade`, `Fermeacle`, `Manuel`, `Antiseptique`, `Epingle`, `Pansement`, `BTria`, `Gaze50`, `Gaze100`, `Ouate`, `Gaze75`, `Compressif`, `Tape12`, `Tape50`, `Eclisses`, `Ciseau`, `Pince`, `Crayon`, `Masque`, `Gant`, `Envoye`, `Confirme`, `Materiel`, `MaterielPret`, `MaterielLivre`, `Notes`, `NotesMateriel`, `NotesAffichage`, `NotesConstruction`, `Chaloupe`, `ChaloupeRame`, `ChaloupeAncre`, `ChaloupeGilets`, `ChaloupeBouee`, `LigneBouee`, `BoueeProfond`, `Canotage`, `HeureSurveillance`, `LimitePlage`, `LongueurPlage`, `NotesBouees`) VALUES
(32, 2, NULL, 1244221200, 1244178000, 58, 2009, 67, 3664, 1, 1, 1, 1, 1, 1, 0, 0, 0, 100, 100, 100, 1, 25, 25, 150, 1, 1, 1, 1, 1, 1, 1, 1, 1, 20, 24, 10, 5, 2, 2, 4, 5, 0, 1, 1, 0, 0, 0, 0, 1, 0, 1, 1, 1, 1, 1, NULL, NULL, NULL, NULL, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, '');


INSERT INTO `client` (`IDClient`, `Nom`, `Cote`, `Facturation`, `FrequenceFacturation`, `Email`, `Fax`, `Tel`, `Adresse`, `RespP`, `RespF`, `Notes`, `Actif`, `TXH`, `Ferie`, `Piece`, `Balance`, `Depot`, `DepotP`, `Password`, `NBAcces`) VALUES
(1, 'Hôtels Jaro', '', 'E', 'H', 'payables@hotelsjaro.com;nhewitt@hotelsjaro.com ', '418', '4186585665', '', 33, 33, '', 1, 18.25, 1, 0, '0', 0, 0, 'mireille1', 40),
(17, 'Customer with Mensual Facture with outstanding Balance.', 'RMB', 'F', 'M', 'vigmgr@raamco.ca', '4506468141', '4504686200', '2480 Roland Therrien #210, Longueuil, Qc J4L4G1', 0, 0, '19.05', 1, 19.05, 1.5, 0, '0', 0, 0, 'admin', 3),
(17, 'Customer with Hebdo Facture with outstanding Balance.', 'RHB', 'F', 'H', 'vigmgr@raamco.ca', '4506468141', '4504686200', '2480 Roland Therrien #210, Longueuil, Qc J4L4G1', 0, 0, '19.05', 1, 19.05, 1.5, 0, '0', 0, 0, 'admin', 3),
(18, 'Customer with no outstanding balance.', 'RMN', 'F', 'M', 'vigmgr@raamco.ca', '4506468141', '4504686200', '2480 Roland Therrien #210, Longueuil, Qc J4L4G1', 0, 0, '19.05', 1, 19.05, 1.5, 0, '0', 0, 0, 'admin', 3),
(60, 'Customer many installation with different Cote.', 'TI', 'F', 'M', 'lolk@okay.com', '4188888888', '', '2020 du fin fin', 0, 0, '19.05', 1, 19.05, 1.5, 0, '0', 0, 0, 'admin', 3),
(65, 'Customer many 2 cote but 3 installation', 'TI1', 'F', 'M', 'lolk@okay.com', '4188888888', '', '', 0, 0, '19.05', 1, 19.05, 1.5, 0, '0', 0, 0, 'admin', 3),
(66, 'CustomerWithDefaultResponsible', 'DF2', 'F', 'M', 'lolk@okay.com', '4188888888', '', '2020 du fin fin', 1, 1, '19.05', 1, 19.05, 1.5, 0, '0', 0, 0, 'admin', 3),
(67, 'CustomerWithInstallationResponsible', 'DF3', 'F', 'M', 'lolk@okay.com', '4188888888', '', '2020 du fin fin', 1, 1, '19.05', 1, 19.05, 1.5, 0, '0', 0, 0, 'admin', 3);

INSERT INTO `installation` (`IDInstallation`, `IDClient`, `IDResponsable`, `IDHoraire`, `IDSecteur`, `Cote`, `Nom`, `Tel`, `Lien`, `Adresse`, `Notes`, `Actif`, `IDType`, `Punch`, `Toilettes`, `Assistant`, `Cadenas`, `Balance`, `Saison`, `Seq`, `Seqc`, `Factname`, `ASFact`, `AdresseFact`, `PONo`) VALUES
(70, 66, 419, 35, 6, 'DF2', 'installation_pas_actif', '418', '', '4410, des Roses', '', 0, 'E', 0, '', 0, 1, 0, 1, 0, 0, '', '', '', ''),
(71, 67, 419, 35, 6, 'DF3', 'installation_pas_saison', '418', '', '4410, des Roses', '', 1, 'E', 0, '', 0, 1, 0, 0, 0, 0, 'CustomCustomerName', 'CustomResponsibleName', 'CustomAddress', ''),
(72, 67, 419, 35, 6, 'DF3', 'installation_rien_pantoute', '418', '', '4410, des Roses', '', 0, 'E', 0, '', 0, 1, 0, 0, 0, 0, 'CustomCustomerName', 'CustomResponsibleName', 'CustomAddress', ''),
                                                                                                                                                                                                                                                                                                                (1, 1, 443, 4, 15, 'QI', 'Québec Inn', '41887292310', 'http://maps.google.ca/maps?f=q&hl=fr&q=7175,++boul.+Hamel+,+Ancienne-Lorette&sll=46.802424,-71.332698&sspn=0.274492,0.752563&ie=UTF8&z=16&iwloc=addr&om=1', '7175, Boul Hamel Ouest\r\nSte-Foy, Qc\r\nG2G 1B6\r\nfax: 872-1336\r\nTéléphone direct : 418 872-9991*0', '<b> PUNCH </b> \r\n - Le PUNCH est obligatoire à l\'ouverture et à la fermeture de la piscine.  Le code est 402.\r\n - N\'oubliez pas de récupérer la clé de la piscine en arrivant à la réception.  \r\n\r\n<b> SITUATION EXCEPTIONNELLE ET PERSONNE CONTACT </b>\r\nPour toutes questions, situation avec un client, ajustement de la réglementation, vous devez toujours vous référer à : <b> SUPERVISEUR À LA RÉCEPTION </b>.  Si un membre du personnel de l\'hôtel vous demande d\'effectuer un accroc à la réglementation(ex. maximum de baigneurs, etc.), merci d\'accepter et d\'indiquer clairement au registre, la nature de la modification, le membre du personnel qui en fait la demande ainsi que la date et l\'heure.\r\n\r\n<b> Matériels et tâches du sauveteur </b>\r\n  - Vous n\'êtes pas responsable des tests d\'eau ni de l\'entretien.  La maintenance s\'en chargera.\r\n  - Le trousse de premiers soins et le registre sont dans le bacs à serviettes sur le bord de la piscine.  \r\n  - Un DEA est disponible au gym (appartient à M. Jérôme Trépanier du centre de santé La Source).\r\n  - Merci de vous installer près du bac à serviettes.\r\n  - Au besoin, nettoyer les tables et les chaises.\r\n  - Des employés du gym circulent régulièrement près de la piscine, lorsque vous manquez de serviette, informez les afin qu\'ils placent un appel à la réception.  Si le tout est tranquille, vous pouvez vous même vous déplacer au gym pour faire l\'appel de service.\r\n  - En cas d\'urgence, le téléphone à proximité est celui situé au gym.  Le téléphone jaune est quand à lui relié directement au restaurant.\r\n  - Merci de ne pas nourrir les poissons.\r\n\r\n\r\n<b> Règlements </b> \r\n Tous les règlements de bases s\'appliquent à cette piscine (course, verre, bousculade, etc.).  À cela s\'ajoute : \r\n   - Les enfants de 16 ans et moins doivent être accompagnés d\'un adulte (+18 ans). \r\n   - Seuls les enfants de plus de 6 ans ont accès au spa.\r\n   - Pour le spa, nous vous demandons d\'encourager les clients à faire une rotation aux 15 à 20 minutes afin de permettre à tous d\'y accéder.\r\n   - Les sauts et les \"bombes\" sont interdites. Ayez une tolérance pour les jeunes enfants qui sautent dans les bras de leur parent.\r\n   - L\'alcool est permis mais seulement dans des verres en plastiques.  Si vous n\'en avez plus, demander à la réception.\r\n   - Aucune nourriture n\'est permise sur le bord de la piscine.\r\n   - La piscine est accessible aux clients de l\'hôtel mais également à ceux du gym et du centre de soins.  Tous peuvent accéder au sauna (situé dans le gym).\r\n\r\n\r\n<i> N\'oubliez pas de vous référer au registre en tout temps.  D\'autres informations importantes y sont indiquées. </i>', 1, 'IS', 1, '', 0, 0, 0, 1, 205, 44, 'Les Immeubles Jacques Robitaille Inc.', 'Nancy Hewitt', '<b>Québec Inn</b>\r\n7175, Boul Hamel Ouest\r\nSte-Foy, Qc\r\nG2G 1B6', ''),
(25, 1, 29, 73, 0, 'ASF', 'L\\\'auberge Sir Wilfrid', '4186512440', 'http://maps.google.ca/maps?f=q&hl=fr&q=3055+Boulevard+Laurier,+Sainte-Foy,+Communaut%C3%A9-Urbaine-de-Qu%C3%A9bec,+Qu%C3%A9bec&sll=46.78462,-71.361551&sspn=0.008581,0.023518&ie=UTF8&om=1&cd=1&geocode=FUeTyQIdzSjA-w&split=0&z=16&iwloc=A', '3055 Boul. Laurier\r\nQuébec, Qc\r\nG1V 4X2', 'PUNCH obligatoire à l\\\'ouverture et à la fermeture de la piscine.  Le code est 713.\r\nDE PLUS, vous devrez remplir une feuille de temps en y mettant vos initiales.\r\nClés, trousse, punch et registre à la réception. \r\n*téléphone le plus près : dans le couloir entre la réception et la piscine', 1, 'E', 1, 'près de la réception', 0, 0, 0, 1, 50, 17, 'Les Immeubles Jacques Robitaille Inc.', 'Nancy Hewitt', '<b>Auberge Québec</b>\r\n3055 Boul. Laurier\r\nQuébec (QC)\r\nGiV 2X4', ''),
(21, 35, 446, 58, 0, 'IR', '3500 Maricourt', '418', 'http://maps.google.ca/maps?f=q&hl=fr&q=3500+Avenue+Maricourt,+Sainte-Foy,+Communaut%C3%A9-Urbaine-de-Qu%C3%A9bec,+Qu%C3%A9bec&sll=46.869402,-71.193992&sspn=0.008567,0.023518&ie=UTF8&om=1&cd=1&geocode=FS2ByQIdGcW_-w&split=0&z=16&iwloc=r0', '3500 ave Maricourt\r\nSainte-Foy', 'Les clefs pour l\'Immeuble et la porte de rangement (SS gauche 3499) se trouve dans le cadena. Les clefs de la piscine et de la porte du filteur (SS droite 3499) avec le registre où se trouve le rangement.\r\n si vous devez quittez pour aller a la salle de bain ou remplir votre gourde d\'eau svp laissez une note comme quoi vous serez de retour dans 5 min à la piscine.\r\nIl n\'y a pas de concierge sur place. En cas de besoin, contacter le bureau de SDS. ', 1, 'E', 0, 'toilette 3499 au sous-sol', 0, 1, 0, 1, 0, 0, '', '', '', ''),
(17, 17, 446, 58, 0, 'RMB', '3500 Maricourt', '418', 'http://maps.google.ca/maps?f=q&hl=fr&q=3500+Avenue+Maricourt,+Sainte-Foy,+Communaut%C3%A9-Urbaine-de-Qu%C3%A9bec,+Qu%C3%A9bec&sll=46.869402,-71.193992&sspn=0.008567,0.023518&ie=UTF8&om=1&cd=1&geocode=FS2ByQIdGcW_-w&split=0&z=16&iwloc=r0', '3500 ave Maricourt\r\nSainte-Foy', 'Les clefs pour l\'Immeuble et la porte de rangement (SS gauche 3499) se trouve dans le cadena. Les clefs de la piscine et de la porte du filteur (SS droite 3499) avec le registre où se trouve le rangement.\r\n si vous devez quittez pour aller a la salle de bain ou remplir votre gourde d\'eau svp laissez une note comme quoi vous serez de retour dans 5 min à la piscine.\r\nIl n\'y a pas de concierge sur place. En cas de besoin, contacter le bureau de SDS. ', 1, 'E', 0, 'toilette 3499 au sous-sol', 0, 1, 0, 1, 0, 0, '', '', '', ''),
 (58, 62, 419, 35, 6, 'LO', 'Îlot St-Pierre', '418', 'https://www.google.ca/maps/place/4410+Rue+des+Roses,+Ville+de+Qu%C3%A9bec,+QC+G1G+1P2/@46.8824046,-71.2832669,19z/data=!3m1!4b1!4m5!3m4!1s0x4cb8bd2cc5ea0e09:0xd7149c6508e89c86!8m2!3d46.8824046!4d-71.2827197?hl=fr', '4410, des Roses', '<b>Les locataires auront une carte à montrer pour accéder à la piscine  à compter du 6 juillet : pas de carte d\'accès, pas de baignade...soyez strict!! \r\nMaximum 2 invités par locataire </b>\r\n\r\nLe matériel des sauveteurs est dans le cabanon près de la piscine. \r\n Merci de sortir le matériel à votre arrivée, et de le ranger quand vous quittez.\r\n Les sauveteurs sont en charge de l\'entretien (balayeuse, backwash, cerne et ajout de produits). \r\n En cas de besoin, contactez le concierge :  M. Stéphane Despins 418-609-3989.\r\n\r\n Maximum 2 invités par locataire. ', 1, 'E', 0, 'l’appartement des concierges au 4298 des Roses appartement 404.', 0, 1, 0, 1, 0, 0, '', '', '', ''),

 (60, 60, 419, 35, 6, 'TI', 'installation_1', '418', 'https://www.google.ca/maps/place/4410+Rue+des+Roses,+Ville+de+Qu%C3%A9bec,+QC+G1G+1P2/@46.8824046,-71.2832669,19z/data=!3m1!4b1!4m5!3m4!1s0x4cb8bd2cc5ea0e09:0xd7149c6508e89c86!8m2!3d46.8824046!4d-71.2827197?hl=fr', '4410, des Roses', '<b>Les locataires auront une carte à montrer pour accéder à la piscine  à compter du 6 juillet : pas de carte d\'accès, pas de baignade...soyez strict!! \r\nMaximum 2 invités par locataire </b>\r\n\r\nLe matériel des sauveteurs est dans le cabanon près de la piscine. \r\n Merci de sortir le matériel à votre arrivée, et de le ranger quand vous quittez.\r\n Les sauveteurs sont en charge de l\'entretien (balayeuse, backwash, cerne et ajout de produits). \r\n En cas de besoin, contactez le concierge :  M. Stéphane Despins 418-609-3989.\r\n\r\n Maximum 2 invités par locataire. ', 1, 'E', 0, 'l’appartement des concierges au 4298 des Roses appartement 404.', 0, 1, 0, 1, 0, 0, '', '', '', ''),
 (65, 65, 419, 35, 6, 'TI1', 'installation_1', '418', 'https://www.google.ca/maps/place/4410+Rue+des+Roses,+Ville+de+Qu%C3%A9bec,+QC+G1G+1P2/@46.8824046,-71.2832669,19z/data=!3m1!4b1!4m5!3m4!1s0x4cb8bd2cc5ea0e09:0xd7149c6508e89c86!8m2!3d46.8824046!4d-71.2827197?hl=fr', '4410, des Roses', '<b>Les locataires auront une carte à montrer pour accéder à la piscine  à compter du 6 juillet : pas de carte d\'accès, pas de baignade...soyez strict!! \r\nMaximum 2 invités par locataire </b>\r\n\r\nLe matériel des sauveteurs est dans le cabanon près de la piscine. \r\n Merci de sortir le matériel à votre arrivée, et de le ranger quand vous quittez.\r\n Les sauveteurs sont en charge de l\'entretien (balayeuse, backwash, cerne et ajout de produits). \r\n En cas de besoin, contactez le concierge :  M. Stéphane Despins 418-609-3989.\r\n\r\n Maximum 2 invités par locataire. ', 1, 'E', 0, 'l’appartement des concierges au 4298 des Roses appartement 404.', 0, 1, 0, 1, 0, 0, '', '', '', ''),
 (61, 60, 419, 35, 6, 'POM', 'installation_2', '418', 'https://www.google.ca/maps/place/4410+Rue+des+Roses,+Ville+de+Qu%C3%A9bec,+QC+G1G+1P2/@46.8824046,-71.2832669,19z/data=!3m1!4b1!4m5!3m4!1s0x4cb8bd2cc5ea0e09:0xd7149c6508e89c86!8m2!3d46.8824046!4d-71.2827197?hl=fr', '4410, des Roses', '<b>Les locataires auront une carte à montrer pour accéder à la piscine  à compter du 6 juillet : pas de carte d\'accès, pas de baignade...soyez strict!! \r\nMaximum 2 invités par locataire </b>\r\n\r\nLe matériel des sauveteurs est dans le cabanon près de la piscine. \r\n Merci de sortir le matériel à votre arrivée, et de le ranger quand vous quittez.\r\n Les sauveteurs sont en charge de l\'entretien (balayeuse, backwash, cerne et ajout de produits). \r\n En cas de besoin, contactez le concierge :  M. Stéphane Despins 418-609-3989.\r\n\r\n Maximum 2 invités par locataire. ', 1, 'E', 0, 'l’appartement des concierges au 4298 des Roses appartement 404.', 0, 1, 0, 1, 0, 0, '', '', '', ''),
 (66, 65, 419, 35, 6, 'TI1', 'installation_2', '418', 'https://www.google.ca/maps/place/4410+Rue+des+Roses,+Ville+de+Qu%C3%A9bec,+QC+G1G+1P2/@46.8824046,-71.2832669,19z/data=!3m1!4b1!4m5!3m4!1s0x4cb8bd2cc5ea0e09:0xd7149c6508e89c86!8m2!3d46.8824046!4d-71.2827197?hl=fr', '4410, des Roses', '<b>Les locataires auront une carte à montrer pour accéder à la piscine  à compter du 6 juillet : pas de carte d\'accès, pas de baignade...soyez strict!! \r\nMaximum 2 invités par locataire </b>\r\n\r\nLe matériel des sauveteurs est dans le cabanon près de la piscine. \r\n Merci de sortir le matériel à votre arrivée, et de le ranger quand vous quittez.\r\n Les sauveteurs sont en charge de l\'entretien (balayeuse, backwash, cerne et ajout de produits). \r\n En cas de besoin, contactez le concierge :  M. Stéphane Despins 418-609-3989.\r\n\r\n Maximum 2 invités par locataire. ', 1, 'E', 0, 'l’appartement des concierges au 4298 des Roses appartement 404.', 0, 1, 0, 1, 0, 0, '', '', '', ''),

 (62, 60, 419, 35, 6, 'POR', 'installation_3', '418', 'https://www.google.ca/maps/place/4410+Rue+des+Roses,+Ville+de+Qu%C3%A9bec,+QC+G1G+1P2/@46.8824046,-71.2832669,19z/data=!3m1!4b1!4m5!3m4!1s0x4cb8bd2cc5ea0e09:0xd7149c6508e89c86!8m2!3d46.8824046!4d-71.2827197?hl=fr', '4410, des Roses', '<b>Les locataires auront une carte à montrer pour accéder à la piscine  à compter du 6 juillet : pas de carte d\'accès, pas de baignade...soyez strict!! \r\nMaximum 2 invités par locataire </b>\r\n\r\nLe matériel des sauveteurs est dans le cabanon près de la piscine. \r\n Merci de sortir le matériel à votre arrivée, et de le ranger quand vous quittez.\r\n Les sauveteurs sont en charge de l\'entretien (balayeuse, backwash, cerne et ajout de produits). \r\n En cas de besoin, contactez le concierge :  M. Stéphane Despins 418-609-3989.\r\n\r\n Maximum 2 invités par locataire. ', 1, 'E', 0, 'l’appartement des concierges au 4298 des Roses appartement 404.', 0, 1, 0, 1, 0, 0, '', '', '', ''),
 (67, 65, 419, 35, 6, 'TI2', 'installation_3', '418', 'https://www.google.ca/maps/place/4410+Rue+des+Roses,+Ville+de+Qu%C3%A9bec,+QC+G1G+1P2/@46.8824046,-71.2832669,19z/data=!3m1!4b1!4m5!3m4!1s0x4cb8bd2cc5ea0e09:0xd7149c6508e89c86!8m2!3d46.8824046!4d-71.2827197?hl=fr', '4410, des Roses', '<b>Les locataires auront une carte à montrer pour accéder à la piscine  à compter du 6 juillet : pas de carte d\'accès, pas de baignade...soyez strict!! \r\nMaximum 2 invités par locataire </b>\r\n\r\nLe matériel des sauveteurs est dans le cabanon près de la piscine. \r\n Merci de sortir le matériel à votre arrivée, et de le ranger quand vous quittez.\r\n Les sauveteurs sont en charge de l\'entretien (balayeuse, backwash, cerne et ajout de produits). \r\n En cas de besoin, contactez le concierge :  M. Stéphane Despins 418-609-3989.\r\n\r\n Maximum 2 invités par locataire. ', 1, 'E', 0, 'l’appartement des concierges au 4298 des Roses appartement 404.', 0, 1, 0, 1, 0, 0, '', '', '', ''),
 (68, 66, 419, 35, 6, 'DF2', 'installation_3', '418', '', '4410, des Roses', '', 1, 'E', 0, '', 0, 1, 0, 1, 0, 0, '', '', '', ''),
 (69, 67, 419, 35, 6, 'DF3', 'installation_3', '418', '', '4410, des Roses', '', 1, 'E', 0, '', 0, 1, 0, 1, 0, 0, 'CustomCustomerName', 'CustomResponsibleName', 'CustomAddress', ''),
 (73, 67, 419, 35, 6, 'CT1', 'cote_1_installation_1', '418', '', '4410, des Roses', '', 1, 'E', 0, '', 0, 1, 0, 1, 0, 0, 'CustomCustomerName', 'CustomResponsibleName', 'CustomAddress', ''),
 (74, 67, 419, 35, 6, 'CT1', 'cote_1_installation_2', '418', '', '4410, des Roses', '', 1, 'E', 0, '', 0, 1, 0, 1, 0, 0, 'CustomCustomerName', 'CustomResponsibleName', 'CustomAddress', ''),
 (75, 67, 419, 35, 6, 'CT2', 'cote_2_installation_1', '418', '', '4410, des Roses', '', 1, 'E', 0, '', 0, 1, 0, 1, 0, 0, 'CustomCustomerName', 'CustomResponsibleName', 'CustomAddress', '');

 ;


INSERT INTO `paiement` (`IDPaiement`, `Cote`, `Montant`, `Date`, `PayableYear`,`Notes`) VALUES
  (99 , 'TDF', 344.92, 1509220851,2017, ''),                 # date de 2017
  (98 , 'TDF', 114.97, 1530629972,2017, ' Paye:~TDF-1~'),    # paye une invoice de 2017 en 2018
  (100, 'TDF', 344.92, 1530629973,2018, ' Paye:~TDF-3~'),    # paiement complet invoice normale
  (101, 'TDF', 114.97, 1530629974,2018, ' Paye:~TDF-5~'),    # paiement complet invoice materiel
  (102, 'TDF', 200, 1530629975,2018, ' Paye:~TDF-7~'),       # paiement partiel invoice normale
  (103, 'TDF', 200, 1530627800,2018, ' Paye:~TDF-9~TDF-10'), # paiement partiel pour deux factures
  (97, 'TDF', 200, 1530629972,2019, ''),                    # paiement d'avance pour 2019...

  (104, 'TDF', 200, 1584014405,2020, ' Paye:~TDF-12~'), # paiement recu en mars 2020
  (105, 'TDF', 400, 1587384005,2020, ' Paye:~TDF-15~'), # paiement reçu en avril 2020

  (204, 'TPM', 114.98, 1530629972,2018, ' Paye:~TPM-1~'), # paiement total pour 1 invoice
  (205, 'TPM', 919.8, 1530629972,2018, ' Paye:~TPM-2~TPM-3'), # paiement total pour deux factures
  (206, 'TPM', 200, 1530629972,2018, ' Paye:~TPM-4~'), # paiement partiel pour une factures
  (207, 'TPM', 300, 1530629972,2018, ' Paye:~TPM-5~TPM-6'), # paiement partiel pour deux factures

  (308, 'TF', 100, 1530629972, 2018,' Paye:~TF-1~'),    # paiement complet invoice normale
  (309, 'TF', 200, 1530629972, 2018,' Paye:~TF-3~'),    # paiement complet invoice normale

  # (110, 'TPS', 100,1529812800, 2018,'  Paye:~TPS-1~')             # Placeholder pour le ID 110 (genere dans un test)
  (411, 'TPS', 100,1530629972, 2018,'  Paye:~TPS-1~'),             # Placeholder pour le ID 110 (genere dans un test)
  (412, 'TPS', 200,1530629972, 2018,'  Paye:~TPS-2~'),            # Placeholder pour le ID 110 (genere dans un test)

  (606, 'PCV', 3692.43, 1530645750, 2018,' Paye:~PCV-13~');

INSERT INTO `facture` (`IDFacture`, `Cote`, `Sequence`, `BonAchat`, `TPS`, `TVQ`, `STotal`, `Debit`, `Credit`, `Notes`, `Semaine`, `Paye`, `Utilise`, `EnDate`, `Materiel`, `AvanceClient`,`Interest`,`Monthly`,`Weekly`) VALUES
(2256, 'PCV', 13, '', 0.05, 0.095, 3692.43, 1,0, '1st installment for lifeguard pool service contract', 1527393600, 1,0, 1527535405, 0, 0, 0, 0,0),
(2298, 'PCV', 14, '', 0.05, 0.095, 100.51, 1,0, '', 1529812800, 0, 0,1530627972, 0, 0, 0, 0,0),
(23  , 'ABC', 68, '', 0.05, 0.095, 100.51, 1,0, '', 1529812800, 0, 0,1530627972, 0, 0, 0, 0,0),

(1336, 'TDF', 1,  '', 0.05, 0.095, 100, 1,0, '', 1509220851, 1,0, 1509220851, 0, 0, 0, 1,0), # date de 2017 # Monthly
(1337, 'TDF', 1,  '', 0.05, 0.095, 100, 1,0, '', 1509220851, 1,0, 1509220851, 0, 0, 0, 0,1), # date de 2017 # Weekly
(1338, 'TDF', 2,  '', 0.05, 0.095, 200, 1,0, '', 1529812800, 0,0, 1530627972, 0, 0, 0, 0,0), # normale
(1339, 'TDF', 3,  '', 0.05, 0.095, 300, 1,0, '', 1529812800, 1,0, 1530627973, 0, 0, 0, 0,0), # normale-payee
(1340, 'TDF', 4,  '', 0.05, 0.095,  10, 1,0, '', 1529812800, 0,0, 1530627974, 0, 0, 0, 0,0), # materiel
(1341, 'TDF', 5,  '', 0.05, 0.095, 100, 1,0, '', 1529812800, 1,0, 1530627975, 0, 0, 0, 0,0), # materiel-payee
(1342, 'TDF', 6,  '', 0.05, 0.095, 400, 1,0, '', 1529812800, 0,0, 1530627976, 0, 0, 0, 0,0), # normale-creditee
(1343, 'TDF', 7,  '', 0.05, 0.095, 500, 1,0, '', 1529812800, 1,0, 1530627977, 0, 0, 0, 0,0), # normale partiellement-payee
(1344, 'TDF', 8,  '', 0.05, 0.095, 500, 1,0, '', 1529812800, 0,0, 1530627978, 0, 0, 0, 0,0), # normale partiellement-creditee
(1345, 'TDF', 9,  '', 0.05, 0.095, 100, 1,0, '', 1529812800, 1,0, 1530627978, 0, 0, 0, 0,0), # normale payee dans un pmt a 2 invoice avec debalance
(1346, 'TDF', 10, '', 0.05, 0.095, 100, 1,0, '', 1529812800, 1,0, 1530627978, 0, 0, 0, 0,0), # normale payee dans un pmt a 2 invoice avec debalance

(1347, 'TDF', 1, '', 0.05, 0.095, -400, 0,1, '', 1529812800, 1,0, 1530627977, 0, 0, 0, 0,0), # credit pour TDF-6
(1348, 'TDF', 2, '', 0.05, 0.095, -400, 0,1, '', 1529812800, 1,0, 1530627979, 0, 0, 0, 0,0), # credit pour TDF-8
(2349, 'TDF', 11, '', 0.05, 0.095, 100, 1,0, '', 1583625600, 0,0, 1584014400, 0, 0, 0, 0,0), # 12/3/2020
(2350, 'TDF', 12, '', 0.05, 0.095, 200, 1,0, '', 1583625600, 1,0, 1584014400, 0, 0, 0, 0,0), # 12/3/2020
(2351, 'TDF', 13, '', 0.05, 0.095, 300, 1,0, '', 1583625600, 0,0, 1584014400, 0, 0, 0, 0,0), # 12/3/2020
(2352, 'TDF', 14, '', 0.05, 0.095, 400, 1,0, '', 1587254400, 0,0, 1587384000, 0, 0, 0, 0,0), # 20/4/2020
(2353, 'TDF', 15, '', 0.05, 0.095, 500, 1,0, '', 1587254400, 1,0, 1587384000, 0, 0, 0, 0,0), # 20/4/2020

(2000, 'TDF', 1, '', 0, 0, 200, 0,0, '', 1529812800, 0,0, 1530627972, 0, 1, 0, 0,0), # AvanceClient non utilisee
(2001, 'TDF', 2, '', 0, 0, 400, 0,0, '', 1529812800, 0,1, 1530627972, 0, 1, 0, 0,0), # AvanceClient utilisee

(1349, 'TF', 1, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0, 0, 0,0), # Test Facture - Facture payee
(1350, 'TF', 2, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 0,0, 1530627972, 0, 0, 0, 0,0), # Test Facture - Facture non payee
(1353, 'TF', 3, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0, 0, 0,0), # Test Facture - Facture payee
(1359, 'TF', 4, '', 0.05, 0.095, 100, 1,0, '', 1529812800, 0,0, 1530627972, 1, 0, 0, 0,0), # Test Facture - Materiel non payée
(1351, 'TF', 1, '', 0.05, 0.095, -400,0,1, '', 1529812800, 1,0, 1530627972, 0, 0, 0, 0,0), # Test Facture - credit
(1360, 'TF', 7, '', 0.05, 0.095, 0, 1,0, '', 1529812800, 0,0, 1530627972, 1, 0, 0, 0,0), # Facture Materiel avec mauvais solde (0 vs 510,0)

(1353, 'TPM', 1, '', 0.05, 0.095, 100, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0, 0, 0,0), # Test Payment - paye total (1/1)
(1354, 'TPM', 2, '', 0.05, 0.095, 200, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0, 0, 0,0), # Test Payment - paye total (1/2)
(1355, 'TPM', 4, '', 0.05, 0.095, 300, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0, 0, 0,0), # Test Payment - paye partiel (1/1)
(1356, 'TPM', 5, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0, 0, 0,0), # Test Payment - paye partiel (1/2)
(1357, 'TPM', 6, '', 0.05, 0.095, 500, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0, 0, 0,0), # Test Payment - paye partiel (2/2)
(1358, 'TPM', 3, '', 0.05, 0.095, 600, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0, 0, 0,0), # Test Payment - paye total (2/2)

(3000, 'TFS', 1, '', 0.05, 0.095, 100, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0, 0, 0,0), # Facture Shift 1
(3001, 'TFS', 2, '', 0.05, 0.095, 200, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0, 0, 0,0), # Facture Materiel 1
(3002, 'TFS', 3, '', 0.05, 0.095, 600, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0, 0, 0,0), # Facture Materiel 2
(3003, 'TFS', 4, '', 0.05, 0.095, 300, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0, 0, 0,0), # Facture Shift 2
(3004, 'TFS', 1, '', 0.05, 0.095, -400, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0, 0, 0,0), # Credit 1
(3005, 'TFS', 2, '', 0.05, 0.095, -500, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0, 0, 0,0), # Credit 2

(3006, 'TFS', 1, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0, 0, 0,0), # Avance Client 1
(3007, 'TPS', 1, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 1,0, 1530627972, 0, 0, 0, 0,0), # Facture payee par le paiement

(3010, 'TFF', 1, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 0,0, 1530627972, 0, 0, 0, 0,0), # Facture shift
(3011, 'TFF', 2, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 0,0, 1530627972, 1, 0, 0, 0,0), # Facture materiel
(3012, 'TFF', 3, '', 0.05, 0.095, -400, 1,1, '', 1529812800, 0,0, 1530627972, 0, 0, 0, 0,0), # credit
(3013, 'TFF', 4, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 0,0, 1530627972, 0, 1, 0, 0,0), # avance client
(3015, 'TFF', 5, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 0,0, 1530627972, 0, 0, 1, 0,0), # Facture Intérêt
(3014, 'RMB', 1, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 0,0, 1530627972, 0, 0, 0, 1,0), # Facture pour client mensuel avec outstading Balance
(3016, 'RHB', 4, '', 0.05, 0.095, 400, 1,0, '', 1529812800, 0,0, 1530627972, 0, 0, 0, 0,0), # Facture pour client hebdo avec outstading Balance

(4001, 'TII', 1, '', 0.05, 0.095, 300, 1,0, '', 1583625600, 0,0, 1584014400, 0, 0, 0, 0,0), # Facture de temps avec 3 invoice items
(4002, 'TII', 1, '', 0.05, 0.095, 400, 1,0, '', 1583625600, 0,0, 1584014400, 1, 0, 1, 0,0), # Facture de matériel avec 3 invoice items

(5001, 'TMI', 1, '', 0.05, 0.095, 400, 1,0, '', 1596240000, 0,0, 1597180411, 1, 0, 1, 0,0), # Aout 2020 qui commence un samedi
(5002, 'TMI', 2, '', 0.05, 0.095, 400, 1,0, '', 1595721600, 0,0, 1597180411, 1, 0, 1, 0,0); # Mars 2020 qui commence un dimanche

INSERT INTO `employe` (`IDEmploye`, `Prenom`, `Nom`, `HName`, `NAS`, `Adresse`, `CodePostal`, `DateNaissance`, `DateEmbauche`, `IDSecteur`, `Ville`, `TelP`, `TelA`, `Cell`, `Paget`, `Email`, `Session`, `Status`, `Engage`, `Cessation`, `Notes`, `Raison`, `SalaireB`, `SalaireS`, `SalaireA`, `Ajustement`, `LastVisited`, `EAssistant`) VALUES
  (2, 'Julie', 'Fortin', 'Ju in the sky', '281302976', '4385, des Sarcelles', 'G1G4W5', 471848400, 993960000, '22', 'Québec', '4189973876', '', '4189973876', '418', 'julie.fortin.16@ulaval.ca', 'E11', 'Bureau', 1, 0, 'SN expire: 12/2011', '', 11.4, 11.4, 10.9, 0, 1530129400, 0),
  (90, 'Jean-Thomas', 'Baillargeon', 'JT', '281659714', '3305, boul Hawey', 'G1E1N8', 510987600, 1051761600, '1', 'Québec', '4186601934', '418', '418', '418', 'jtbaillargeon@hotmail.com', 'E11', 'Temps plein', 1, 0, '', '', 12, 14.3, 13.7, 0, 1331060074, 0);


INSERT INTO `factsheet` (`IDFactsheet`, `IDFacture`, `Start`, `End`, `TXH`, `Notes`, `Jour`) VALUES
(1, 4001, 32400, 43200, 50, 'Note 1', 0), #3 h 150 $
(2, 4001, 54000, 72000, 2, 'Note 2', 0), #5 h 10 $
(3, 4001, 28800, 79200, 10, 'Note 3', 1), #14 h 140 $
(4, 4002, 0, 1, 100, '1 items a 100$', 0), #1 x 100$
(5, 4002, 0, 2, 150, '2 items a 150$', 0), #2 x 150$
(6, 1360, 0, 1, 10, '1 items a 15$', 0), #1 x 10$
(7, 1360, 0, 2, 250, '2 items a 250$', 0), #2 x 250$
(8, 1347, 0, 3600, -400  ,'credit d\'une heure', 0); #1 x 400


INSERT INTO `shift` (`IDShift`, `IDInstallation`, `IDEmploye`, `TXH`, `Salaire`, `Start`, `End`, `Jour`, `Semaine`, `Assistant`, `Commentaire`, `Warn`, `Confirme`, `Empconf`, `Facture`, `Paye`, `Message`) VALUES
  (1337, 21, 2, 16.75, 0, 34200, 75600, 0, 1497153600, 0, '', '', 1, 1, 1, 0, 'Vers 14h30, il est important de contacter le chef réceptionniste avant de confirmer l\\\'heure de fin.  Si tu termines bien à 15h, tu n\\\'auras techniquement pas à faire de démontage.'),
  (1338, 21, 2, 16.75, 0, 34200, 75600, 0, 1497153600, 0, '', '', 1, 1, 1, 0, 'Vers 14h30, il est important de contacter le chef réceptionniste avant de confirmer l\\\'heure de fin.  Si tu termines bien à 15h, tu n\\\'auras techniquement pas à faire de démontage.'),
  (247735,351 ,0, 21.55 ,       0 , 61200 , 68400 ,    2 , 1593316800 ,         0 ,''             ,''      ,        0 ,       0 ,       0 ,    0 ,''),
(1339,21 ,2, 21.55 ,       0 , 61200 , 68400 ,    2 , 2543122000 ,         0 ,''             ,''      ,        0 ,       0 ,       0 ,    0 ,''),
(1340,21 ,2, 21.55 ,       0 , 61200 , 68400 ,    2 , 2543122000 ,         0 ,''             ,''      ,        0 ,       0 ,       0 ,    0 ,'');



INSERT INTO `vars` (`Nom`, `Valeur`, `Type`) VALUES
  ('Saison', 'E18', 'string'),
  ('TPS', '0.050', 'float'),
  ('TVQ', '0.095', 'float'),
  ('Augmentation', '0.03', 'float'),
  ('NoteFacture', 'Merci, bonne semaine', 'string'),
  ('Boniyear', '2018', 'int'),
  ('MP', '07818b79ae41658fa619c47b86731ab6', 'string'),
  ('TVQShown', '9.975', 'String'),
  ('interest', '0.03', 'float'),
  ('super_admin_password', 'a97a058d8601fd45d561f8ce1262abb6', 'string');


INSERT INTO `responsable` (`IDResponsable`, `Titre`, `Prenom`, `Nom`, `Tel`, `Cell`, `Appartement`, `Resp`) VALUES
(0, 'M.', 'prenom', 'nom', '4186536672', '418', '', ''),
(1, 'M.', 'prenom', 'nom', '4186536672', '418', '', ''),
(33, 'Mme', 'lolk', 'Roboto', '41865856654234', '418', '', '');

INSERT INTO `item` (`IDItem`, `Description`, `Fournisseur`, `Prix1`, `NBForfait`, `PrixForfait`, `Actif`) VALUES
(1, 'Manuel de secourisme', 'Secourisme PME', 7.3, 1, 7.3, 1),
(2, 'Tampons Antiseptiques', 'Secourisme PME', 0.15, 12, 1.3, 1),
(3, 'Épingles de sureté', 'Secourisme PME', 0.1, 12, 1.1, 1),
(4, 'Pansements adhésifs', 'Secourisme PME', 0.15, 25, 4.2, 1),
(5, 'Bandages Triangulaires', 'Secourisme PME', 1.8, 6, 9.3, 0);


INSERT INTO `vacances` (`IDVacances`, `IDEmploye`, `DebutVacances`, `FinVacances`, `Raison`) VALUES
(1, 90, 1596240000, 1598918400, 'raison de vacances'); #1er juillet 2020 au 1 aout 2020 (minuit GMT)