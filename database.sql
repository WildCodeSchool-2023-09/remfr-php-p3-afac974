USE 'afac974';

LOCK TABLES `artist` WRITE;

INSERT INTO  'artist' (email, roles, password , description, photoname, name, lastname ) VALUES
	('artiste1@gmail.com', 'artist', 'artiste1 ', 'NSP ', 'a', 'alric', 'Cazal '),
	('artiste2@gmail.com', 'artist', 'artiste2 ',
    'Artiste originaire et installée à l’Ile de La Reunion, NathM affectionne particulièrement les techniques d’art fluide (encres et acrylique) 
    entremêlées à différentes textures et volumes. Nathalie définit son art comme principalement guidé par l’expérience 
    primaire sensorielle, celle qui relie chacun de nous au corps et aux perceptions sensorielles mobilisées dans notre 
    rencontre avec le monde. ', 'b', 'Nathalie', 'Malet '),
	('artiste3@gmail.com', 'artist', 'artiste3 ', '"C’est l’histoire d’un homme qui se ballade. D’une contrée à l’autre, 
    de rencontre en rencontre, il évolue, adapte son regard aux situations et aux paysages qu’il traverse, s’arrète parfois 
    longuement pour contempler le monde qui se transforme lui aussi. C’est une histoire en impressions couleurs, les carnets 
    de route d’une aventure intèrieure, les instantanés d’une âme de vagabond.', 'c', 'Theophile', 'Delaine '),
	('artiste4@gmail.com', 'artist', 'artiste4 ', '"Z A M A K O Y habite à l ile de la Réunion, une île tropicale, volcanique, 
    isolée, dotée d une forte personnalité et d une population venue d Europe, d Afrique, de Madagascar, d Inde, de Chine, 
    réunie par une culture commune qui fait sa force et son originalité.', 'd', 'a', 'Zamako ');