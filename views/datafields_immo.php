<?php
/*
*	Liste des champs de données immobilières récupérés par le flux
*/
global $description_WPublfwParser;
$description_WPublfwParser =
	array(
		"ville" => "ville",
		"departement" => "département",
		"code_insee" => "code INSEE",
		"pays" => "pays",
		"zone_geo" => "géolocalisation",
		"communiquer_adresse_exacte",
		"surface" =>
			array("name"=>"surface", "unit"=>"<span class=\"surface_m2\">m&sup2;</span>"),
		"surface_cadastree" =>
			array("name"=>"surface cadastrée", "unit"=>"<span class=\"surface_m2\">m&sup2;</span>"),
		"surface_constructible" =>
			array("name"=>"surface constructible", "unit"=>"<span class=\"surface_m2\">m&sup2;</span>"),
		"surface_jardin" =>
			array("name"=>"surface du jardin", "unit"=>"<span class=\"surface_m2\">m&sup2;</span>"),
		"surface_terrain" =>
			array("name"=>"surface terrain", "unit"=>"<span class=\"surface_m2\">m&sup2;</span>"),
		"surface_sejour" =>
			array("name"=>"surface du séjour", "unit"=>"<span class=\"surface_m2\">m&sup2;</span>"),
		"climatise" =>
			"climatisé",
		"alur_nb_lots" =>
			array("name"=>"nbre de lots de la copropriété", "unit"=>false),
		"meuble" =>
			"meublé",
		"hauteur_plafond" =>
			"hauteur sous plafond",
		"jacuzzi" =>
			"jacuzzi",
		"acces_handicapes" =>
			"accès handicapés",
		"animaux_acceptes" =>
			"animaux acceptés",
		"surface_carrez" =>
			array("name"=>"surface Carrez", "unit"=>"<span class=\"surface_m2\">m&sup2;</span>"),
		"nb_caves" =>
			"nbre de caves",
		"surface_balcon" =>
			"surface du balcon",
		"etat_general" =>
			"état général",
		"chauffage" =>
			"chauffage",
		"chauffage_energie" =>
			"chauffage",
		"chauffage_type" =>
			"type de chauffage",
		"recent" =>
			"récent",
		"tv" =>
			"équipé télévision",
		"garage_longueur" =>
			"longueur du garage",
		"garage_hauteur" =>
			"hauteur du garage",
		"garage_bip" =>
			"bip d'ouverture du garage",
		"garage_carte_magnetique" =>
			"carte magnétique du garage",
		"raccorde_gaz" =>
			"raccordé au gaz",
		"nb_terrasses" =>
			"nbre de terrasses",
		"nb_balcons" =>
			"nbre de balcons",
		"caution_bip_garage" =>
			"caution pour le bip du garage",
		"dernier_etage" =>
			"dernier étage",
		"chauffage_mecanisme" =>
			"type de chauffage",
		"nombre_stationnement" =>
			"nbre de stationnements",
		"nb_garages" =>
			"nbre de garages",
		"nb_parkings" =>
			"nbre de parkings",
		"viabilise" =>
			"viabilisé",
		"raccorde_eau" =>
			"raccordé au réseau eau",
		"nb_appartements" =>
			"nombre d'appartements",
		"raccorde_electricite" =>
			"raccordé au réseau electricité",
		"raccorde_telephone" =>
			"raccordé au réseau téléphone",
		"assainissement" =>
			"assainissement",
		"cloture" =>
			"clôture",
		"etage" =>
			"étage",
		"nb_salles_de_bain" =>
			"nbre de salle de bains",
		"nb_salles_d_eau" =>
			"nbre de salle d'eau",
		"sous_sol" =>
			"sous-sol",
		"charges_copropriete" =>
			array("name"=>"charge de copropriété", "unit"=>"PRICE"),
		"cles_dispo_agence" =>
			"clefs disponible à l'agence",
		"nb_bien" =>
			"nbre de lots",
		"type_cuisine" =>
			"disposition de la cuisine",
		"type_stationnement" =>
			"stationnement principal",
		"surface_habitable" =>
			array("name"=>"surface habitable", "unit"=>"<span class=\"surface_m2\">m&sup2;</span>"),
		"surface_corrigee" =>
			"surface corrigée",
		"surface_utile" =>
			"surface utile",
		"surface_annexe" =>
			"surfaces des annexes",
		"programme_neuf_nom" =>
			"titre du programme neuf",
		"avec_stationnement" =>
			"avec stationnement",
		"nb_wc" =>
			"nbre de WC",
		"nombre_de_chambres" =>
			"nbre de chambres",
		"annee_construction" =>
			"année de construction",
		"exposition" =>
			"exposition",
		"prestige" =>
			"bien d'exception",
		"nb_pieces" =>
			"nbre de pièces",
		"date_disponibilite" =>
			"date disponibilité",
		"taxe_habitation" =>
			"taxe d'habitation",
		"taxe_fonciere" =>
			"axe foncière",
		"etat_interieur" =>
			"état intérieur",
		"commentaires_proche_transports" =>
			"transports à proximité",
		"commentaires_proche_ecoles" =>
			"établissements scolaires à proximité",
		"commentaires_proche_commerces" =>
			"commerces à proximité",
		"surface_dependances" =>
			"surface des dépendances",
		"toiture" =>
			"toiture",
		"vitrages" =>
			"vitrages",
		"cuisine_equipee" =>
			"cuisine équipée",
		"cuisine_amenagee" =>
			"cuisine aménagée",
		"grenier" =>
			"grenier",
		"nombre_etages" =>
			"nombre d'étages",
		"standing" =>
			"standing",
		"ascenseur" =>
			"ascenseur",
		"loggia" =>
			"loggia",
		"balcon" =>
			"balcon",
		"rapport_locatif" =>
			"rapport locatif",
		"vente_par_lots" =>
			"vendu par lots",
		"surface_libre_totale" =>
			"totale surface inoccupée",
		"surface_occupee_totale" =>
			"totale surface occupée",
		"surface_habitable_occupee" =>
			"surface habitable occupée",
		"surface_habitable_libre" =>
			"surface habitable libre",
		"surface_commerciale_libre" =>
			"surface commerciale libre",
		"surface_commerciale_occupee" =>
			"surface commerciale utilisée",
		"style_construction" =>
			"style de construction",
		"annee_renovation" =>
			"année de rénovation",
		"nombre_niveaux" =>
			"nbre de niveaux",
		"nombre_chambres_rdc" =>
			"nbre de chambres au RDC",
		"cave" =>
			"cave",
		"veranda" =>
			"véranda",
		"garage" =>
			"garage",
		"detail_dependances" =>
			"détail des dépendances",
		"dependances" =>
			"dépendances",
		"constructeur" =>
			"constructeur",
		"materiau_construction" =>
			"matériaux construction",
		"couverture" =>
			"matériaux couverture",
		"huisseries" =>
			"matériaux huisseries",
		"plancher" =>
			"matériaux du plancher",
		"mitoyennete" =>
			"mitoyenneté",
		"copropriete" =>
			"en copropriété",
		"surface_parc" =>
			"surface du parc",
		"tennis" =>
			"tennis",
		"piscine" =>
			"piscine",
		"logement_gardien" =>
			"logement gardien",
		"chauffage_central" =>
			"chauffage central",
		"declaration_achevement_travaux" =>
			"une déclaration achèvement et conformité des travaux déposée",
		"terrasse" =>
			"terrasse",
		"cheminee" =>
			"cheminée",
		"libre_a_la_vente" =>
			"libre à la vente",
		"raccorde" =>
			"Raccordé aux réseaux",
		"cos" =>
			"COS",
		"shon" =>
			"SHON",
		"facade" =>
			"Longueur du terrain en façace",
		"profondeur" =>
			"longueur du terrain à la perpendiculaire de la limite de façade",
		"certificat_urbanisme" =>
			"certificat d'urbanisme",
		"numero_reference_lot" =>
			"numero de référence du lot",
		"permis_construire" =>
			"permis de construire délivré",
		"hauteur_maximum" =>
			"hauteur max",
		"eau_chaude_distribution" =>
			"distribution eau chaude",
		"bail_date_expiration" =>
			"date d'expiration du Bail",
		"constructible" =>
			"constructible",
		"avec_pente" =>
			"terrain avec pente",
		"longueur_terrain" =>
			"longueur du terrain",
		"largeur_terrain" =>
			"largeur du terrain",
		"avec_vis_a_vis" =>
			"terrain avec vis-à-vis",
		"garage_emplacement" =>
			"emplacement du garage",
		"nb_couchages" =>
			"nbre de couchages",
		"nb_adultes_max" =>
			"nombre d'adultes maximum",
		"nb_enfants_max" =>
			"nombre d'enfants maximum autorisés",
		"nb_bebes_max" =>
			"nbre de bébés maximum autorisés",
		"nom_residence" =>
			"nom de la résidence",
		"wc_independant" =>
			"wc indépendant",
		"revetement_sol_principal" =>
			"revêtement sol principal",
		"servitude" =>
			"servitude du bien",
		"spc" =>
			"SPC",
		"alur_syndicat_statut" =>
			"statut provisoire du syndicat",
		"alur_copropriete_plan_de_sauvegarde" =>
			"la copropriété fait l’objet d’un plan de sauvegarde.",
		"nb_coproprietaires" =>
			"nbre des copropriétaires",
		"cuisine_etat" =>
			"état général de la cuisine",
		"possede_cajibi" =>
			"dispose d'un rangement/stockage",
		"buanderie" =>
			"dispose d'une buanderie",
		"piscine_type" =>
			"type de piscine",
		"equipements_sportifs" =>
			"équipements sportifs",
		"coin_bureau" =>
			"coin bureau",
		"surface_bureaux" =>
			"surface de bureaux",
		"entree_de_camion" =>
			"entrée de camion",
		"surface_facade" =>
			"surface de façade",
		"surface_construite" =>
			"surface totale construite",
		"bien_avec_chauffage" =>
			array("name"=>"équipement de chauffage présent", "unit"=>false),
		"placards_integres" =>
			"espace de rangement intégrés",
		"appartement_invites_independant" =>
			"logement indépendant",
		"sejour" =>
			"séjour",
		"nb_sejours" =>
			"nbre de séjours",
		"salle_a_manger" =>
			"salle à manger",
		"nb_salle_a_manger" =>
			"nbre de salles à manger",
		"surface_salle_a_manger" =>
			"Surface de la salle à manger",
		"degagement" =>
			"Dégagement ou non",
		"dressing" =>
			"Possède un dressing",
		"nb_dressing" =>
			"nbre de dressings",
		"surface_dressing" =>
			"Surface du dressing",
		"poele_a_bois" =>
			"Poêle à bois",
		"duplex" =>
			"Est un duplex",
		"triplex" =>
			"Est un triplex",
		"surface_cave" =>
			"Surface de la cave",
		"garage_porte_automatique" =>
			"garage avec porte automatique",
		"nombre_placards" =>
			"nbre de placards",
		"bien_avec_eau_chaude" =>
			"bien alimenté en eau chaude",
		"bioconstruction" =>
			"est une bioconstruction",
		"type_volet" =>
			"Type de volet",
		"volets_roulants_electriques" =>
			"volets roulants electriques",
		"forme_terrain" =>
			"forme du terrain",
		"surface_cuisine" =>
			"surface de la cuisine",
		"cave_a_vin" =>
			"dispose d'une cave à vin",
		"surface_cave_a_vin" =>
			"surface de la cave à vin",
		"sauna" =>
			"sauna",
		"salon_marocain" =>
			"salon marocain",
		"type_salon_marocain" =>
			"style salon marocain",
		"salon_europeen" =>
			"salon de style européen",
		"acces_internet" =>
			"accès internet",
		"acces_lan" =>
			"réseau local LAN",
		"capacite_accueil" =>
			"nbre de personnes maximum simultanées",
		"nb_cuisines" =>
			"nbre de cuisines",
		"faux_plafonds" =>
			"Possède faux plafonds",
		"fibre_optique" =>
			"fibre optique",
		"acces_wifi" =>
			"Wifi",
		"acces_internet_haut_debit" =>
			"ADSL",
		"surface_laboratoire" =>
			"surface de laboratoire",
		"nb_quais_chargement" =>
			"nbre de quais de chargement"
	);
global $diagnostic_WPublfwParser;
$diagnostic_WPublfwParser = 
	array(
		"soumis_dpe" =>
			"soumis au DPE",
		"dpe_etiquette_conso" =>
			"Etiquette DPE",
		"dpe_etiquette_ges" =>
			"Etiquette GES",
		"dpe_valeur_conso" =>
			array("name"=>"DPE", "unit"=>"<span class=\"dpe_units\">kWh/m2.an</span>"),
		"dpe_valeur_ges" =>
			array("name"=>"GES", "unit"=>"<span class=\"ges_units\">Kg&nbsp;eq&nbsp;cO2/m2.an</span>")
	);
/*
$diagnostic_WPublfwParser = 
	array(
		"dpe_etiquette_conso" =>
			"Etiquette DPE",
		"dpe_etiquette_ges" =>
			"Etiquette GES",
		"dpe_valeur_conso" =>
			array("name"=>"DPE", "unit"=>"<span class=\"dpe_units\">kWh/m2.an</span>"),
		"dpe_valeur_ges" =>
			array("name"=>"GES", "unit"=>"<span class=\"ges_units\">Kg&nbsp;eq&nbsp;cO2/m2.an</span>"),
		"certificat_plomb" =>
			"Certificat de risque d'exposition au plomb",
		"dpe_date_realisation" =>
			"date de réalisation du DPE",
		"diagnostic_amiante" =>
			"diagnostic amiante",
		"soumis_dpe" =>
			"soumis au DPE",
		"dpe_vierge" =>
			"DPE non réalisable",
		"dpe_reference_certificat" =>
			"Numéro DPE",
		"dpe_conso_valeur_total" =>
			"Consommation DPE",
		"citerne_mazout_certif_reference" =>
			"Numéro du certificat du dernier contrôle de la citerne à mazout",
		"citerne_mazout_certif_validite" =>
			"Date de fin de validité du dernier certificat de contrôle de citerne à mazout",
		"certificat_controle_electrique" =>
			"certificat contrôle électrique",
		"attestation_conformite_electrique" =>
			"attestation conformité électrique",
		"attestation_conformite_electrique_date" =>
			"date attestation conformité électrique",
		"attestation_conformite_electrique_echeance" =>
			"échéance attestation conformité électrique",
		"dpe_date_echeance" =>
			"date d'écheance DPE",
		"attestation_conformite_electrique_reference" =>
			"Réference de l'attestation de conformité électrique",
		"peb_co2_valeur" =>
			"Valeur CO2 DPE belge"
	);
*/
global $description_commmerce_WPublfwParser;
$description_commmerce_WPublfwParser = 
	array(
		"nb_salaries" =>
			"nbre de salariés",
		"capital_societe" =>
			"capital de la société",
		"regime_juridique" =>
			"régime judiciaire",
		"benefices_indus_et_comm_annee_n" =>
			"bénéfices industriels et commerciaux année n",
		"benefices_indus_et_comm_annee_n_moins_1" =>
			"bénéfices industriels et commerciaux année n-1",
		"benefices_indus_et_comm_annee_n_moins_2" =>
			"bénéfices industriels et commerciaux année n-2",
		"valeur_comptable" =>
			"valeur comptable",
		"cashflow" =>
			"cashflow",
		"type_bail" =>
			"type de bail",
		"chiffre_d_affaires_annee_n" =>
			"total des ventes de biens et de services facturés sur le dernier exercice comptable",
		"chiffre_d_affaires_annee_n_moins_1" =>
			"CA n-1",
		"chiffre_d_affaires_annee_n_moins_2" =>
			"CA n-2",
		"rcs" =>
			"RCS",
		"masse_salariale" =>
			"masse salariale",
		"raison_sociale" =>
			"raison sociale",
		"enseigne" =>
			"enseigne",
		"personnel" =>
			"Nb d'employés.",
		"surface_divisible_minimum" =>
			"surface divisible minimum",
		"surface_divisible" =>
			"surface divisible",
		"longueur_vitrine" =>
			"longueur de la vitrine",
		"surface_reserve" =>
			"surface de la réserve",
		"surface_logement" =>
			"surface du logement",
		"local_archives" =>
			"local à archives"
	);
/*
$fields =
	array(
		"reference"	=> "Référence",
		"texte" => "Description",
		"code_postal" => "Code Postal",
		"ville" => "Ville",
		"departement" => "Département",
		"code_insee" => "Code INSEE",
		"vente_prix_reel" => "Prix",
		"prix_vendu_net" => "Prix Hors Frais d'agence",
		"prix_vendu_fai" => "Prix FAI",
		"honoraires_negociation" => "Frais d'agence",
		"mandat_type"
			=> array(
				"Type de mandat"
					=> array(
						"exclusif",
						"simple"
					)
				),
		"code_postal_reel" => "Code Postal",
		"numero_voie" => "N°",
		"type_voie"
			=> array(
				"Type de voie"
					=> array(
						"allée",
						"avenue",
						"boulevard",
						"chaussée",
						"chemin",
						"cité",
						"cours",
						"impasse",
						"lieu-dit",
						"lotissement",
						"passage",
						"place",
						"quai",
						"route",
						"rue",
						"résidence",
						"square",
						"venelle",
						"villa"
					)
				),
		"nom_voie" => "Nom de la voie",
		"adresse2" => "Complément d'adresse",
		"ville_reelle" => "Ville",
		"titre" => "Titre",
		"date_saisie" => "Date saisie initiale",
		"visite_virtuelle" => "Visite Virtuelle",
		//"texte_papier",
		"mandat_numero" => "Numéro de Mandat",
		"texte_long" => "Description longue",
		"affichage_privilegie",
		"afficher_telephone",
		"atouts",
		"titre_pt",
		"texte_pt",
		"pac_inclus",
		"date_debut_travaux",
		"nb_salons",
		"commentaire_defauts_connus",
		"prix" => "Prix de vente TTC",
		"disponible_immediatement",
		"cause_vente",
		"montant_travaux",
		"taxe_professionnelle",
		"occupant_nom",
		"occupant_telephone",
		"occupant_fax",
		"viager",
		"frais_notaire",
		"taux_tva",
		"pour_investisseur",
		"pour_habiter",
		"dommage_ouvrage",
		"frais_annexes",
		"prix_est_fai",
		"valeur_locative",
		"alur_pourcentage_honoraires_ttc",
		"honoraires_charge_acquereur",
		"prix_maison_seule",
		"url_annonce_sur_site_annonceur",
		"surface",
		"climatise",
		"meuble",
		"hauteur_plafond",
		"jacuzzi",
		"acces_handicapes",
		"animaux_acceptes",
		"surface_carrez",
		"nb_caves",
		"surface_balcon",
		"etat_general",
		"chauffage_energie"
			=> array(
				"Energie de chauffage"
					=> array(
						"aérothermie",
						"bois",
						"climatisation réversible",
						"fuel",
						"gaz",
						"géothermie",
						"pompe à chaleur",
						"électricité"
					)
				),
		"chauffage_type"
			=> array(
				"Type de chauffage"
					=> array(
						"collectif",
						"individuel"
					)
				),
		"recent",
		"tv",
		"garage_longueur",
		"garage_hauteur",
		"garage_bip",
		"garage_carte_magnetique",
		"raccorde_gaz",
		"nb_terrasses",
		"nb_balcons",
		"caution_bip_garage",
		"dernier_etage",
		"surface_jardin",
		"chauffage_mecanisme"
			=> array(
				"Mécanisme de chauffage"
					=> array(
						"au sol",
						"cheminée",
						"convecteur",
						"insert",
						"poêle",
						"radiateur"
					)
				),
		"nombre_stationnement",
		"nb_garages",
		"nb_parkings",
		"viabilise",
		"raccorde_eau",
		"nb_appartements",
		"raccorde_electricite",
		"raccorde_telephone",
		"assainissement"
			=> array(
				"Assainissement"
				=> array(
					"fosse septique",
					"fosse toutes eaux",
					"non",
					"oui",
					"puits perdu",
					"tout à l'égout"
				)
			),
		"cloture" 
			=> array(
				"Cloture"
					=> array(
						"haie",
						"non",
						"oui"
					)
				),
		"etage",
		"surface_cadastree",
		"nb_salles_de_bain",
		"nb_salles_d_eau",
		"sous_sol",
		"charges_copropriete",
		"cles_dispo_agence",
		"nb_bien",
		"type_cuisine",
		"type_stationnement",
		"surface_habitable",
		"surface_corrigee",
		"surface_utile",
		"surface_annexe",
		"programme_neuf_nom",
		"avec_stationnement",
		"nb_wc",
		"surface_sejour" => "Surface de séjour",
		"nombre_de_chambres",
		"annee_construction",
		"exposition" 
			=> array(
				"Exposition"
				=> array(
					"est",
					"est-ouest",
					"nord",
					"nord-est",
					"nord-est / sud-ouest",
					"nord-ouest",
					"nord-ouest / sud-est",
					"nord-sud",
					"ouest",
					"sud",
					"sud-est",
					"sud-ouest",
					"traversant",
					"traversant est-ouest",
					"traversant nord-sud"
				)
			),
		"prestige",
		"nb_pieces_logement",
		"date_disponibilite",
		"taxe_habitation",
		"taxe_fonciere",
		"etat_interieur",
		"commentaires_proche_transports",
		"commentaires_proche_ecoles",
		"commentaires_proche_commerces",
		"surface_dependances",
		"toiture",
		"vitrages",
		"cuisine_equipee",
		"cuisine_amenagee",
		"grenier",
		"nombre_etages",
		"standing",
		"ascenseur",
		"loggia",
		"balcon",
		"rapport_locatif",
		"vente_par_lots",
		"surface_libre_totale",
		"surface_occupee_totale",
		"surface_habitable_occupee",
		"surface_habitable_libre",
		"surface_commerciale_libre",
		"surface_commerciale_occupee",
		"style_construction",
		"annee_renovation",
		"nombre_niveaux",
		"nombre_chambres_rdc",
		"cave",
		"veranda",
		"garage",
		"detail_dependances",
		"dependances",
		"constructeur",
		"materiau_construction",
		"couverture"
			=> array( 
				"Couverture"
				=> array(
					"ardoise",
					"ardoise naturelle",
					"chaume",
					"fibrociment",
					"tuile",
					"tuile mécanique",
					"tuiles naturelle",
					"tôle"
				)
			),
		"huisseries",
		"plancher",
		"mitoyennete",
		"copropriete",
		"surface_parc",
		"tennis",
		"piscine",
		"logement_gardien",
		"chauffage_central",
		"declaration_achevement_travaux",
		"terrasse",
		"cheminee",
		"libre_a_la_vente",
		"raccorde",
		"cos",
		"shon",
		"facade",
		"profondeur",
		"certificat_urbanisme",
		"numero_reference_lot",
		"permis_construire",
		"hauteur_maximum",
		"eau_chaude_distribution"
			=> array(
				"Mode de distribution de l'eau chaude"
				=> array(
					"ballon électrique",
					"chaudière",
					"chauffage central",
					"collective",
					"fioul",
					"gaz",
					"individuelle",
					"production géothermique",
					"production solaire"
				)
			),
		"bail_date_expiration",
		"constructible",
		"avec_pente",
		"longueur_terrain",
		"largeur_terrain",
		"avec_vis_a_vis",
		"garage_emplacement",
		"nb_couchages",
		"nb_adultes_max",
		"nb_enfants_max",
		"nb_bebes_max",
		"nom_residence",
		"wc_independant",
		"revetement_sol_principal",
		"servitude",
		"spc",
		"nb_coproprietaires",
		"cuisine_etat",
		"possede_cajibi",
		"buanderie",
		"piscine_type",
		"equipements_sportifs",
		"coin_bureau",
		"surface_bureaux",
		"entree_de_camion",
		"surface_facade",
		"surface_construite",
		"bien_avec_chauffage",
		"placards_integres",
		"appartement_invites_independant",
		"sejour",
		"nb_sejours",
		"salle_a_manger",
		"nb_salle_a_manger",
		"surface_salle_a_manger",
		"degagement",
		"dressing",
		"nb_dressing",
		"surface_dressing",
		"poele_a_bois",
		"duplex",
		"triplex",
		"surface_cave",
		"surface_constructible",
		"garage_porte_automatique",
		"nombre_placards",
		"bien_avec_eau_chaude",
		"bioconstruction",
		"type_volet",
		"volets_roulants_electriques",
		"forme_terrain"
			=> array(
				"Forme du terrain"
				=> array(
					"carre",
					"pipe",
					"rectangle",
					"trapeze",
					"triangle"
				)
			),
		"surface_cuisine",
		"cave_a_vin",
		"surface_cave_a_vin",
		"sauna",
		"salon_marocain",
		"type_salon_marocain",
		"salon_europeen",
		"acces_internet",
		"acces_lan",
		"capacite_accueil",
		"nb_cuisines",
		"faux_plafonds",
		"fibre_optique",
		"acces_wifi",
		"acces_internet_haut_debit",
		"surface_laboratoire",
		"nb_quais_chargement",
		"quartier",
		"latitude",
		"longitude",
		"pays",
		"zone_geo",
		"communiquer_adresse_exacte",
		"quartier_of",
		"precision_coordonnees",
		"proche_aeroport",
		"proche_sortie_autoroute",
		"proche_college",
		"proche_commerces",
		"proche_ecole_primaire",
		"proche_lycee",
		"proche_universite",
		"proche_centre_commercial",
		"proche_za_zi",
		"proche_centre_ville",
		"proche_gare",
		"chasse",
		"vue_sur_mer",
		"vue_generale",
		"proche_adresse",
		"proche_bus",
		"proche_tram",
		"nom_proche_aeroport",
		"nom_proche_sortie_autoroute",
		"nom_proche_college",
		"nom_proche_commerces",
		"nom_proche_ecole_primaire",
		"nom_proche_lycee",
		"nom_proche_universite",
		"nom_proche_centre_commercial",
		"nom_proche_za_zi",
		"nom_proche_gare",
		"nom_proche_bus",
		"nom_proche_tram",
		"espaces_verts",
		"lotissement",
		"environnement"
			=> array(
				"Environnement"
				=> array(
					"campagne",
					"centre ville",
					"montagne",
					"océan",
					"ville"
				)
			),
		"belle_vue",
		"situe_centre_affaires",
		"proche_ski",
		"vue_sur_montagne",
		"proche_metro",
		"nom_proche_metro",
		"proche_creche",
		"est_calme",
		"eco_quartier",
		"proche_parking",
		"terrasse_surface",
		"vigne",
		"avec_toit_terrasse",
		"avec_jardin",
		"surface_terrain" => "Surface terrain",
		"possede_etendue_eau",
		"surface_etendue_eau",
		"surface_terrasse",
		"type_jardin",
		"digicode",
		"gardien",
		"videophone",
		"telesurveille",
		"interphone",
		"alarme_habitation",
		"porte_blindee",
		"videosurveillance",
		"systeme_extraction_fumee",
		"nb_salaries",
		"capital_societe",
		"regime_juridique",
		"benefices_indus_et_comm_annee_n",
		"benefices_indus_et_comm_annee_n_moins_1",
		"benefices_indus_et_comm_annee_n_moins_2",
		"valeur_comptable",
		"cashflow",
		"type_bail",
		"chiffre_d_affaires_annee_n",
		"chiffre_d_affaires_annee_n_moins_1",
		"chiffre_d_affaires_annee_n_moins_2",
		"rcs",
		"masse_salariale",
		"raison_sociale",
		"enseigne",
		"personnel",
		"surface_divisible_minimum",
		"surface_divisible",
		"longueur_vitrine",
		"surface_reserve",
		"surface_logement",
		"local_archives",
		"ca",
		"ebe",
		"loto",
		"pmu",
		"surface_commerciale",
		"surface_activite",
		"ebe_annee_n_moins_1",
		"commentaire_fermeture_hebdo",
		"avec_vitrine",
		"vestiaires",
		"surface_restauration",
		"surface_chambres_froides",
		"charges_avec_eau_chaude",
		"charges_avec_chauffage",
		"loyer_mensuel",
		"charges_locatives",
		"tarif_hebdo_basse_saison",
		"tarif_hebdo_moyenne_saison",
		"tarif_hebdo_haute_saison",
		"honoraires_location",
		"droit_bail",
		"depot_garantie",
		"commentaire_basse_saison",
		"commentaire_moyenne_saison",
		"commentaire_haute_saison",
		"preference_duree_location",
		"colocation_acceptee",
		"loyer_est_cc",
		"montant_assurance_multirisque",
		"location_option_achat",
		"loyer_avec_eau",
		"loyer_avec_electricite",
		"loyer_avec_taxe_ordure",
		"loyer_avec_charge_copro",
		"fumeurs_acceptes",
		"nettoyage_inclus",
		"contact_a_afficher",
		"telephone_a_afficher",
		"email_a_afficher",
		"telephone_mobile_a_afficher",
		"adresse_contact_a_afficher",
		"code_postal_contact_a_afficher",
		"ville_contact_a_afficher",
		"horaires_a_afficher",
		"bureau_vente_adresse",
		"dpe_etiquette_conso" 
			=> array(
				"Echelle de la consommation énergétique"
				=> array(
					"A",
					"B",
					"C",
					"D",
					"E",
					"F",
					"G"
				)
			),
		"dpe_etiquette_ges"
			=> array(
				"Echelle de l'émission de gaz à effet de serre"
				=> array(
					"A",
					"B",
					"C",
					"D",
					"E",
					"F",
					"G",
				)
			),
		"dpe_valeur_conso",
		"dpe_valeur_ges",
		"certificat_plomb",
		"dpe_date_realisation",
		"diagnostic_amiante",
		"soumis_dpe",
		"dpe_vierge",
		"dpe_reference_certificat",
		"dpe_conso_valeur_total",
		"citerne_mazout_certif_reference",
		"citerne_mazout_certif_validite",
		"certificat_controle_electrique",
		"attestation_conformite_electrique",
		"attestation_conformite_electrique_date",
		"attestation_conformite_electrique_echeance",
		"dpe_date_echeance",
		"attestation_conformite_electrique_reference",
		"peb_co2_valeur",
		"defisc_loi_besson",
		"defisc_loi_robien",
		"defisc_loi_robien_recentree",
		"defisc_loi_borloo",
		"defisc_loi_girardin_paul",
		"defisc_loi_demessine",
		"defisc_statut_lmp",
		"defisc_statut_lmnp",
		"defisc_loi_malraux",
		"defisc_loi_mh",
		"defisc_nue_propriete_demembrement",
		"defisc_residence_services",
		"defisc_residence_tourisme_classee",
		"defisc_regime_micro_bic",
		"pret_locatif_social",
		"loi_scellier",
		"compatible_ptz_plus",
		"zone_fiscale_robien_borloo" 
			=> array(
				"zone de défiscalisation du régime Robien-Borloo"
				=> array(
					"A",
					"A bis",
					"B1",
					"B2",
					"C"
				)
			),
		"defisc_statut_zrr",
		"defisc_statut_mapad",
		"defisc_statut_epad",
		"pass_foncier_collectif",
		"pass_foncier_individuel",
		"defisc_zone_anru",
		"defisc_loi_duflot",
		"defisc_loi_censi_bouvard",
		"defisc_regime_scpi",
		"compatible_psla",
		"defisc_loi_pinel",
		"label_hqe",
		"label_bbc",
		"label_hpe",
		"label_thpe",
		"label_he",
		"label_qualitel",
		"label_promotelec",
		"label_iso9001",
		"label_iso9002",
		"label_iso9003",
		"label_he_effinergie",
		"label_bepas",
		"label_bepos",
		"label_hpe_enr",
		"label_thpe_enr",
		"label_nf_maison_individuelle",
		"label_qualibat",
		"label_ce",
		"label_acermi",
		"label_maison_de_qualite",
		"label_maison_de_confiance",
		"rt_2012",
		"financement_mensualites",
		"financement_duree",
		"financement_taux",
		"financement_apport",
		"financement_cout_total",
		"financement_montant",
		"viager_rente",
		"viager_age_tete1",
		"viager_age_tete2",
		"viager_valeur_venale",
		"viager_vente_a_terme",
		"viager_duree",
		"enchere_mise_a_prix",
		"enchere_estimation",
		"enchere_date_vente",
		"enchere_code_postal_salle",
		"enchere_ville_salle",
		"enchere_adresse_salle",
		"enchere_vente_en_ligne",
		"enchere_increment_minimum",
		"enchere_consignation",
		"enchere_avec_prix_reserve",
		"enchere_origine",
		"offre_titre",
		"offre_texte",
		"offre_mentions_legales",
		"offre_type",
		"offre_date_debut",
		"offre_date_fin",
		"equipe_four",
		"equipe_microondes",
		"equipe_frigo",
		"equipe_lave_vaisselle",
		"equipe_robot_cuisine",
		"equipe_grille_pain",
		"equipe_appareil_raclette",
		"equipe_cafetiere",
		"equipe_machine_expresso",
		"equipe_plaque_cuisson",
		"equipe_congelateur",
		"equipe_hifi",
		"equipe_radio",
		"equipe_lecteur_dvd",
		"equipe_lecteur_blu_ray",
		"equipe_console_jeux",
		"equipe_tennis_table",
		"equipe_billard",
		"equipe_babyfoot",
		"equipe_chaise_haute",
		"equipe_lit_bebe",
		"equipe_lit_gigogne",
		"avec_linge_maison",
		"nb_lits_simples",
		"nb_lits_doubles",
		"equipe_seche_cheveux",
		"equipe_fer_repasser",
		"equipe_lave_linge",
		"barbecue",
		"trampoline",
		"aire_de_jeu",
		"velos",
	);
*/
?>