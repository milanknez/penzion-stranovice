<?php
require_once __DIR__ . '/../admin/includes/CMS.php';
CMS::getHeader();

$defaultImage = '/assets/img/trip_silhouette.svg';

$trips = [
    // 0 km (Přímo v areálu / ve vsi)
    [
        'id' => 'stranovice_bazen',
        'title' => 'Venkovní bazén Penzionu Straňovice',
        'category' => 'pesky koupani',
        'badge' => 'U penzionu',
        'distance' => 'Přímo u penzionu',
        'time' => '0 min',
        'image' => $defaultImage,
        'description' => 'Přímo v areálu našeho statku ve Straňovicích je pro ubytované hosty k dispozici osvěžující venkovní bazén pro letní relaxaci.',
        'highlights' => ['Venkovní bazén exkluzivně pro ubytované', 'Osvěžení v horkých letních dnech', 'Pohodlná lehátka a trávník okolo'],
        'lat' => 49.12386,
        'lng' => 13.89667
    ],
    [
        'id' => 'stranovice_ohniste',
        'title' => 'Venkovní ohniště a Posezení u Penzionu',
        'category' => 'pesky',
        'badge' => 'U penzionu',
        'distance' => 'Přímo u penzionu',
        'time' => '0 min',
        'image' => $defaultImage,
        'description' => 'Romantické venkovní ohniště s dřevem a posezením pro ubytované hosty. Ideální pro večerní opékání špekáčků a kytaru pod hvězdami.',
        'highlights' => ['Tradiční venkovní ohniště s posezením', 'Příprava dřeva na opékání', 'Klidné večerní posezení na statku'],
        'lat' => 49.12386,
        'lng' => 13.89667
    ],
    [
        'id' => 'stranovice_selske_baroko',
        'title' => 'Historická vesnička Straňovice – Selské baroko',
        'category' => 'pesky tradice',
        'badge' => 'Památková zóna',
        'distance' => 'Přímo ve vsi',
        'time' => '0–5 min procházka',
        'image' => $defaultImage,
        'description' => 'Malebná jihočeská vesnička vyhlášená vesnickou památkovou zónou díky výjimečně dochovanému souboru lidové architektury. Najdete zde nádherné usedlosti a statky ve stylu pošumavského selského baroka s klenutými branami a zdobenými štíty.',
        'highlights' => [
            'Výjimečně dochovaný soubor pošumavského selského baroka',
            'Vyhlášená vesnická památková zóna',
            'Klidná procházka malebnou návsí přímo od našeho statku'
        ],
        'lat' => 49.1245,
        'lng' => 13.8960
    ],
    [
        'id' => 'stranovicky_rybnik',
        'title' => 'Straňovický rybník u řeky Volyňky',
        'category' => 'pesky priroda',
        'badge' => 'Pěšky 2 min',
        'distance' => '200 m od penzionu',
        'time' => '2 min pěšky',
        'image' => $defaultImage,
        'description' => 'Odpočinková zóna u Straňovického rybníka na řece Volyňce. Ráj pro rybáře a klidná přírodní oáza pro krátkou večerní či ranní procházku.',
        'highlights' => ['Odpočinková rybářská zóna', 'Krásné přírodní prostředí u řeky Volyňky', 'Jen pár kroků od penzionu'],
        'lat' => 49.1255,
        'lng' => 13.8860
    ],
    [
        'id' => 'volynka_stezka',
        'title' => 'Malenice – Lčovice: Procházka a Cyklovýlet podél řeky Volyňky',
        'category' => 'pesky priroda',
        'badge' => 'Pěšky / Kolo (2–4 km)',
        'distance' => 'Od 1 km (trasa 2–4 km)',
        'time' => '30–60 min pěšky / 15 min na kole',
        'image' => $defaultImage,
        'description' => 'Krásná, nenáročná a malebná trasa podél meandrující řeky Volyňky vedoucí přímo ze Straňovic a Malenic do sousedních Lčovic. Ideální pro klidnou pěší procházku, běh, kočárky i rodinný cyklovýlet s možností zastávky na občerstvení ve Lčovicích (např. u stánku či zámku).',
        'highlights' => [
            'Romantická rovinatá trasa podél zurčící řeky Volyňky',
            'Ideální pro rodiny s dětmi, kočárky i rekreační cyklisty',
            'Možnost občerstvení ve Lčovicích a návrat pohodovou cestou'
        ],
        'lat' => 49.1260,
        'lng' => 13.8850
    ],

    // 2 km (Malenice)
    [
        'id' => 'malenice_fara',
        'title' => 'Opravená Fara v Malenicích a Letní kavárna',
        'category' => 'pesky tradice',
        'badge' => '2 km / Pěšky',
        'distance' => '2 km od penzionu',
        'time' => '20 min pěšky',
        'image' => $defaultImage,
        'description' => 'Krásně zrekonstruovaný objekt historické fary v Malenicích. Pořádají se zde sezónní výstavy, funguje tu letní kavárnička a zázemí s dětským hřištěm.',
        'highlights' => ['Letní kavárna a sezónní výstavy', 'Dětské hřiště v klidném dvoře fary', 'Historická architektura'],
        'lat' => 49.1292,
        'lng' => 13.8828
    ],
    [
        'id' => 'malenice_kostel_hrbitov',
        'title' => 'Kostel sv. Jakuba a památný hřbitov v Malenicích',
        'category' => 'pesky tradice',
        'badge' => '2 km / Památka a Historie',
        'distance' => '2 km od penzionu',
        'time' => '20 min pěšky',
        'image' => $defaultImage,
        'description' => 'Dominanta Malenic ze 14. století s dochovanými gotickými malbami, historickou zvonicí a tajemnou komnatou. Obklopuje jej unikátní památný hřbitov s arkádami – místo posledního odpočinku architekta Josefa Zítka (stavitele Národního divadla), režiséra Zdeňka Podskalského, herečky Jiřiny Jiráskové a kněze Františka Teplého.',
        'highlights' => [
            'Hroby Z. Podskalského, J. Jiráskové a architekta Josefa Zítka',
            'Gotický presbytář, nástěnné malby a tajná komnata',
            'Malebný památný hřbitov s arkádovou hřbitovní zdí'
        ],
        'lat' => 49.1292,
        'lng' => 13.8828
    ],
    [
        'id' => 'malenice_podskalsky_vila',
        'title' => 'Vila Zdeňka Podskalského v Malenicích',
        'category' => 'pesky tradice',
        'badge' => '2 km / Architektura',
        'distance' => '2 km',
        'time' => '20 min pěšky',
        'image' => $defaultImage,
        'description' => 'Stylová rodinná vila režiséra Zdeňka Podskalského v Malenicích. Objekt je v soukromém vlastnictví a lze si jej prohlédnout zvenčí při procházce obcí.',
        'highlights' => ['Rodinné sídlo slavného režiséra', 'Stylová architektura u řeky', 'Prohlídka zvenčí při procházce obcí'],
        'lat' => 49.1288,
        'lng' => 13.8820
    ],
    [
        'id' => 'malenicka_jeskyne',
        'title' => 'Malenická jeskyně (v Jiříčků skále)',
        'category' => 'pesky priroda',
        'badge' => '2 km / Přírodní zajímavost',
        'distance' => '2 km',
        'time' => '25 min pěšky',
        'image' => $defaultImage,
        'description' => 'Významná krasová jeskyně ve vápencovém masivu Jiříčkovy skály na okraji Malenic objevená v roce 1920. Významné paleontologické naleziště kostí zvířat z doby ledové (vstup do podzemí je nepřístupný z důvodu bezpečnosti, místo je zajímavé pro procházku a prohlídku skalního masivu).',
        'highlights' => ['Krasový útvar v masivu Jiříčkovy skály', 'Významné paleontologické naleziště z doby ledové', 'Přírodní zajímavost kousek od Malenic'],
        'lat' => 49.1302,
        'lng' => 13.8835
    ],
    [
        'id' => 'malenice_hriste',
        'title' => 'Víceúčelové sportovní hřiště Malenice',
        'category' => 'pesky',
        'badge' => '2 km / Sport',
        'distance' => '2 km',
        'time' => '4 min autem / 20 min pěšky',
        'image' => $defaultImage,
        'description' => 'Moderní víceúčelové sportovní hřiště v Malenicích ideální pro tenis, volejbal, nohejbal, malou kopanou a mičudové hry s rodinou či přáteli.',
        'highlights' => ['Kvalitní umělý povrch pro míčové sporty', 'Skvělé vyžití pro dospělé i děti', 'Pouhé 2 km od penzionu'],
        'lat' => 49.1275,
        'lng' => 13.8810
    ],
    [
        'id' => 'malenice_malinove_slavnosti',
        'title' => 'Malinové slavnosti v Malenicích',
        'category' => 'pesky tradice',
        'badge' => 'Červenec / Akce',
        'distance' => '2 km',
        'time' => 'Červencová sobota',
        'image' => $defaultImage,
        'description' => 'Tradiční červencová slavnost v Malenicích plná malinových specialit, KOLÁČŮ, řemeslného jarmarku, živé hudby a programu pro děti.',
        'highlights' => ['Tradiční červencová akce', 'Malinové koláče, dobroty a jarmark', 'Kulturní a hudební program'],
        'lat' => 49.1290,
        'lng' => 13.8825
    ],

    // 2.5 km (Malenice – vrcholy a stezky)
    [
        'id' => 'kaplicka_hurka',
        'title' => 'Kaplička sv. Václava na Hůrce',
        'category' => 'pesky rozhledny priroda',
        'badge' => 'Pěšky / Vyhlídka',
        'distance' => '2.5 km',
        'time' => '45 min pěšky',
        'image' => $defaultImage,
        'description' => 'Malebná kaplička sv. Václava na návrší Hůrka nad obcí Malenice s panoramatickým výhledem na údolí řeky Volyňky a šumavské podhůří.',
        'highlights' => ['Nádherný výhled na údolí řeky Volyňky', 'Klidné místo pro odpočinek a fotky', 'Trasa nad obcí směrem na Zlešice'],
        'lat' => 49.1350,
        'lng' => 13.8920
    ],
    [
        'id' => 'mechovous_stezka',
        'title' => 'Lišejníková stezka skřítka Mechovouse v Malenicích',
        'category' => 'pesky priroda',
        'badge' => '2.5 km / Pro rodiny s dětmi',
        'distance' => '2.5 km od penzionu',
        'time' => '45 min pěšky / 5 min autem',
        'image' => $defaultImage,
        'description' => 'Nová pohádkově laděná naučná stezka na Obecním kopci u Malenic. Hravou a interaktivní formou provede děti i dospělé světem lišejníků, mechorostů (mechů) a lesních zvířátek. Najdete zde dřevěné sochy skřítků, herní a balanční prvky, informační tabule i lesní altán s ohništěm.',
        'highlights' => [
            'Interaktivní stezka s herními a balančními prvky pro děti',
            'Dřevěné sochy skřítka Mechovouse a lesních zvířat',
            'Lesní altán, odpočinková místa a poznávání mechorostů a lišejníků'
        ],
        'lat' => 49.1360,
        'lng' => 13.8930
    ],

    // 4 – 4.5 km (Čkyně)
    [
        'id' => 'ckyne_synagoga',
        'title' => 'Čkyně – Židovská synagoga',
        'category' => 'tradice',
        'badge' => '4 km / Památka',
        'distance' => '4 km',
        'time' => '6 min autem / 15 min vlakem',
        'image' => $defaultImage,
        'description' => 'Unikátně zrenovovaná klasicistní židovská synagoga ve Čkyni s expozicí o židovské komunitě a kulturním sále.',
        'highlights' => ['Kompletně zrekonstruovaná synagoga', 'Expozice o židovské historii regionu', 'Kulturní přednášky a akce'],
        'lat' => 49.1120,
        'lng' => 13.8320
    ],
    [
        'id' => 'ckyne_hrbitov',
        'title' => 'Čkyně – Historický židovský hřbitov',
        'category' => 'tradice',
        'badge' => '4 km / Historie',
        'distance' => '4.5 km',
        'time' => '7 min autem',
        'image' => $defaultImage,
        'description' => 'Cenný historický židovský hřbitov ze 17. století u obce Čkyně obklopený kamennou zdí a vzrostlými stromy.',
        'highlights' => ['Náhrobky ze 17. až 20. století', 'Tiché a tajuplné pietní místo', 'Nedaleko židovské synagogy'],
        'lat' => 49.1140,
        'lng' => 13.8350
    ],

    // 8 km (Volyně, Sudslavice, Zálezly, Předslavice)
    [
        'id' => 'sudslavicky_okruh',
        'title' => 'Naučná stezka Sudslavický okruh (PR Opolenec)',
        'category' => 'priroda',
        'badge' => '8 km / Příroda & Skály',
        'distance' => '8 km od penzionu',
        'time' => '10 min autem',
        'image' => $defaultImage,
        'description' => 'Nádherná a dobrodružná okružní naučná stezka (cca 3 km) v Přírodní rezervaci Opolenec pod vrchem Opolenec u Sudslavic (mezi Čkyní a Vimperkem). Trasa vede vápencovým kaňonem s dřevěnými lávkami, schody a žebříky, kolem Sudslavické jeskyně, staré vápenky a památné 600leté Sudslavické lípy.',
        'highlights' => [
            'Dobrodružná stezka vápencovým kaňonem se žebříky a lávkami',
            'Památná 600letá Sudslavická lípa a Sudslavická jeskyně',
            'Bohatá vápencová flóra a historická vápenka v PR Opolenec'
        ],
        'lat' => 49.1432,
        'lng' => 13.7947
    ],
    [
        'id' => 'volyne_tvrz',
        'title' => 'Volyně – Gotická tvrz a Městské muzeum',
        'category' => 'hrady tradice',
        'badge' => '8 km / Muzeum',
        'distance' => '8 km',
        'time' => '8 min autem',
        'image' => $defaultImage,
        'description' => 'Historická gotická tvrz ve Volyni sídlící Městské muzeum s bohatými expozicemi etnografie, řemesel a sezónními výstavami.',
        'highlights' => ['Starobylá gotická tvrz', 'Městské muzeum Volyně', 'Celoroční výstavy a kulturní akce'],
        'lat' => 49.1660,
        'lng' => 13.8860
    ],
    [
        'id' => 'volyne_radnice',
        'title' => 'Volyně – Renesanční radnice a Náměstí',
        'category' => 'tradice',
        'badge' => '8 km / Památka',
        'distance' => '8 km',
        'time' => '8 min autem',
        'image' => $defaultImage,
        'description' => 'Starobylé renesanční náměstí ve Volyni s radnicí ze 16. století, mariánským sloupem a kavárničkami.',
        'highlights' => ['Renesanční radnice s věžními hodinami', 'Historické náměstí s mariánským sloupem', 'Kavárny a restaurace na náměstí'],
        'lat' => 49.1655,
        'lng' => 13.8855
    ],
    [
        'id' => 'volyne_koupaliste',
        'title' => 'Retro koupaliště Volyně',
        'category' => 'koupani',
        'badge' => '8 km / Koupaliště',
        'distance' => '8 km',
        'time' => '8 min autem',
        'image' => $defaultImage,
        'description' => 'Nejstarší dochované přírodní koupaliště v ČR z roku 1939. Nabízí neopakovatelnou prvorepublikovou atmosféru, dřevěné kabinky, čistou průtokovou vodu a stánek s občerstvením.',
        'highlights' => ['Nejstarší přírodní koupaliště v ČR (1939)', 'Prvorepublikové dřevěné kabinky', 'Čistá protékající přírodní voda'],
        'lat' => 49.1642,
        'lng' => 13.8872
    ],
    [
        'id' => 'predslavice_liva_muzeum',
        'title' => 'Muzeum venkovského života LIVA Předslavice (u Volyně)',
        'category' => 'tradice',
        'badge' => '8 km / Tradice a Technika',
        'distance' => '8 km od penzionu',
        'time' => '10 min autem',
        'image' => $defaultImage,
        'description' => 'Muzeum venkovského života v historickém areálu statku U Blumů v Předslavicích (pouze 5 km od Volyně). Vstup tvoří unikátní památkově chráněná brána Jakuba Bursy (selské baroko, 1848). Expozice nabízí bohatou sbírku historické zemědělské techniky, kočárů, selského nářadí a ukázek života našich předků.',
        'highlights' => [
            'Bohatá sbírka historické zemědělské techniky, traktorů a kočárů',
            'Památná barokní brána Jakuba Bursy z roku 1848',
            'Autentický statek U Blumů v Předslavicích nedaleko Volyně'
        ],
        'lat' => 49.1762,
        'lng' => 13.9145
    ],
    [
        'id' => 'zalezly_budilov',
        'title' => 'Zálezly (Kamenec) a Budilov',
        'category' => 'priroda',
        'badge' => '8 km / Procházka',
        'distance' => '8 km',
        'time' => '10 min autem',
        'image' => $defaultImage,
        'description' => 'Malebná trasa po šumavském podhůří ze Zálezel přes vrch Kamenec do Budilova. Klidná příroda bez davů turistů s kapličkami a výhledy.',
        'highlights' => ['Klidné šumavské podhůří', 'Trasa přes vrch Kamenec', 'Tradiční šumavské osady Zálezly a Budilov'],
        'lat' => 49.0950,
        'lng' => 13.8550
    ],

    // 10 – 11 km (Předgezdov, Hoslovice)
    [
        'id' => 'predgezdov_keltska',
        'title' => 'Keltská stezka Předgezdov (Předenice)',
        'category' => 'priroda tradice',
        'badge' => '10 km / Historie',
        'distance' => '10 km',
        'time' => '12 min autem',
        'image' => $defaultImage,
        'description' => 'Historická Keltská stezka v okolí Předgezdova a Předenic připomínající dávné keltské osídlení v údolí Volyňky.',
        'highlights' => ['Historické keltské lokality a hradiště', 'Příjemná naučná stezka v přírodě', 'Zajímavosti o dávné historii Šumavska'],
        'lat' => 49.1450,
        'lng' => 13.8750
    ],
    [
        'id' => 'hoslovice_mlyn',
        'title' => 'Středověký vodní mlýn Hoslovice',
        'category' => 'tradice',
        'badge' => '11 km / Památka a Tradice',
        'distance' => '11 km',
        'time' => '14 min autem',
        'image' => $defaultImage,
        'description' => 'Nejstarší a nejdochovanější funkční vodní mlýn v České republice s historií sahající do 14. století. Unikátní areál se skanzenem tradičního venkovského hospodaření, chovem hospodářských zvířat a řemeslnými dny pro celou rodinu.',
        'highlights' => [
            'Nejstarší dochovaný vodní mlýn v ČR (středověký původ)',
            'Autentický skanzen lidové architektury a řemesel',
            'Domácí hospodářská zvířata a akce pro rodiny s dětmi'
        ],
        'lat' => 49.1857,
        'lng' => 13.7690
    ],

    // 12 – 13 km (Vimperk, Lhová, Mářský vrch)
    [
        'id' => 'vimperk_zamek',
        'title' => 'Zámek Vimperk (Expozice sklářství a knihtisku)',
        'category' => 'hrady tradice',
        'badge' => '12 km / Zámek',
        'distance' => '12 km',
        'time' => '15 min autem / vlakem',
        'image' => $defaultImage,
        'description' => 'Monumentální zrekonstruovaný zámek Vimperk s novými prohlídkovými okruhy, expozicí sklářství a knihtiskařství.',
        'highlights' => ['Nově zrekonstruovaný zámecký areál', 'Expozice šumavského sklářství a tiskařství', 'Zámecká zahrada a vyhlídka'],
        'lat' => 49.0535,
        'lng' => 13.7825
    ],
    [
        'id' => 'vimperk_centrum',
        'title' => 'Historické centrum městečka Vimperk',
        'category' => 'tradice',
        'badge' => '12 km / Historie',
        'distance' => '12 km',
        'time' => '15 min autem',
        'image' => $defaultImage,
        'description' => 'Svažité historické náměstí ve Vimperku s městskými hradbami, Černou věží, kostelem sv. Bartoloměje a kavárnami.',
        'highlights' => ['Svažité náměstí s měšťanskými domy', 'Černá věž a pozůstatky hradeb', 'Restaurace a kavárničky'],
        'lat' => 49.0545,
        'lng' => 13.7820
    ],
    [
        'id' => 'sumavsky_pivovar_vimperk',
        'title' => 'Šumavský pivovar Vimperk (Minipivovar)',
        'category' => 'tradice',
        'badge' => '12 km / Minipivovar',
        'distance' => '12 km',
        'time' => '15 min autem',
        'image' => $defaultImage,
        'description' => 'Rodinný řemeslný minipivovar v historickém měšťanském domě v centru Vimperka (Steinbrenerova ulice). Vaří nefiltrovaná a nepasterizovaná piva tradiční českou metodou i pestrou škálu pivních speciálů. Možnost posezení v pivnici, nákupu lahvového piva i degustačních prohlídek.',
        'highlights' => [
            'Tradiční nefiltrovaná řemeslná piva i pestré sezónní speciály',
            'Útulná pivovarská pivnice v historickém domě pod náměstím',
            'Degustační prohlídky pivovaru a prodej piva s sebou'
        ],
        'lat' => 49.0538,
        'lng' => 13.7772
    ],
    [
        'id' => 'vimperk_np_sumava',
        'title' => 'Sídlo Správy Národního parku Šumava (Vimperk)',
        'category' => 'priroda',
        'badge' => '12 km / NP Šumava',
        'distance' => '12 km',
        'time' => '15 min autem',
        'image' => $defaultImage,
        'description' => 'Sídlo Správy NP Šumava ve Vimperku. Informační centrum s mapami, materiály a nabídkou programů v národním parku.',
        'highlights' => ['Informační středisko NP Šumava', 'Prodej turistických map a průvodců', 'Tipy na trasy a ekologický program'],
        'lat' => 49.0528,
        'lng' => 13.7830
    ],
    [
        'id' => 'lhova_muzeum',
        'title' => 'Zemědělské muzeum ve Lhově',
        'category' => 'tradice',
        'badge' => '12 km / Tradice',
        'distance' => '12 km',
        'time' => '14 min autem',
        'image' => $defaultImage,
        'description' => 'Expozice staré zemědělské techniky a náčiní ve Lhově (u Mladíkovic/Vacova). Ukázka venkovského života a práce našich předků.',
        'highlights' => ['Historické stroje a traktory', 'Ukázka tradičních venkovských řemesel', 'Zajímavá zastávka pro rodiny'],
        'lat' => 49.1350,
        'lng' => 13.7650
    ],
    [
        'id' => 'marsky_vrch',
        'title' => 'Rozhledna a kaple na Mářském vrchu',
        'category' => 'rozhledny priroda',
        'badge' => '13 km / Rozhledna',
        'distance' => '13 km',
        'time' => '15 min autem',
        'image' => $defaultImage,
        'description' => 'Kamenná rozhledna spojená s kaplí sv. Václava na Mářském vrchu (907 m n. m.) u Svaté Maří / Štítkova, postavená na popud malenického rodáka a kněze Františka Teplého. Unikátní kamenné moře a krásné výhledy do kraje.',
        'highlights' => ['Rozhledna spojená s kaplí sv. Václava', 'Přírodní památka Kamenné moře na vrcholu (907 m)', 'Iniciováno malenickým rodákem P. Františkem Teplým'],
        'lat' => 49.0728,
        'lng' => 13.8480
    ],

    // 18 km (Helfenburk, Boubín, Rohanov)
    [
        'id' => 'helfenburk',
        'title' => 'Zřícenina hradu Helfenburk',
        'category' => 'hrady rozhledny',
        'badge' => '18 km / Hrad',
        'distance' => '18 km',
        'time' => '22 min autem',
        'image' => $defaultImage,
        'description' => 'Mohutná a romantická zřícenina jednoho z největších jihočeských hradů. Z dochované věže je nádherný výhled na Šumavu a okolní krajinu.',
        'highlights' => ['Mohutné hradby a zachovalá hradní věž', 'Vyhlídka na šumavské podhůří', 'Krásná procházka lesem ke hradu'],
        'lat' => 49.1411,
        'lng' => 14.0042
    ],
    [
        'id' => 'boubin_prales',
        'title' => 'Boubínský prales a Boubínské jezírko',
        'category' => 'priroda',
        'badge' => '18 km / Prales',
        'distance' => '18 km',
        'time' => 'Celodenní výlet',
        'image' => $defaultImage,
        'description' => 'Svatoznámý prales se staletými smrky a jedlemi, chráněný již od roku 1858. Romantické Boubínské jezírko vybudované r. 1836 pro plavení dřeva.',
        'highlights' => ['Chráněný prales starý přes 160 let', 'Romantické Boubínské jezírko', 'Naučná stezka okolo pralesa'],
        'lat' => 48.9772,
        'lng' => 13.8117
    ],
    [
        'id' => 'boubin_rozhledna',
        'title' => 'Rozhledna na vrcholu Boubína (1362 m n. m.)',
        'category' => 'rozhledny priroda',
        'badge' => '18 km / Vrchol',
        'distance' => '18 km',
        'time' => 'Celodenní výlet',
        'image' => $defaultImage,
        'description' => 'Dřevěná rozhledna na páté nejvyšší hoře české části Šumavy (1362 m n. m.). Nádherný výhled na Šumavu a za jasného počasí až na Alpy.',
        'highlights' => ['Dřevěná rozhledna ve výšce 1362 m n. m.', 'Kruhový výhled na Šumavu a Alpy', 'Vrcholové výšlapy z Kubovy Huti či Kaplice'],
        'lat' => 48.9790,
        'lng' => 13.8150
    ],
    [
        'id' => 'rohanov',
        'title' => 'Přírodní koupaliště Rohanov',
        'category' => 'koupani priroda',
        'badge' => '18 km / Přírodní',
        'distance' => '18 km',
        'time' => '20 min autem',
        'image' => $defaultImage,
        'description' => 'Koupaliště Lhota nad Rohanovem pod Šumavou. Průzračně čistá přírodní nádrž bez chemie, obklopená šumavskými lesy a čistým horským vzduchem.',
        'highlights' => ['Přírodní nádrž s čistou vodou bez chemie', 'Krásné šumavské prostředí u lesa', 'Dětské hřiště a kiosek'],
        'lat' => 49.1415,
        'lng' => 13.6820
    ],

    // 22 km (Strakonice, Rozhledna Haniperk)
    [
        'id' => 'strakonice_hrad',
        'title' => 'Strakonický hrad a Věž Rumpál',
        'category' => 'hrady rozhledny tradice',
        'badge' => '22 km / Hrad',
        'distance' => '22 km',
        'time' => '20 min autem / vlakem',
        'image' => $defaultImage,
        'description' => 'Rozsáhlý hradní areál johanitů na soutoku Otavy a Volyňky s věží Rumpál a Muzeem středního Pootaví (expozice dudáctví a motocyklů ČZ).',
        'highlights' => ['Hradní věž Rumpál s vyhlídkou', 'Slavná expozice dudáctví a motocyklů ČZ', 'Kapitula a hradní nádvoří'],
        'lat' => 49.2588,
        'lng' => 13.9015
    ],
    [
        'id' => 'strakonice_pivovar_dudak',
        'title' => 'Měšťanský pivovar DUDÁK Strakonice',
        'category' => 'tradice',
        'badge' => '22 km / Pivovar a Tradice',
        'distance' => '22 km',
        'time' => '20 min autem',
        'image' => $defaultImage,
        'description' => 'Poslední pivovar v České republice ve vlastnictví města s tradicí od roku 1649. Areál na břehu Otavy nabízí komentované prohlídky pivovaru s degustací, pivovarskou prodejnu i vyhlášenou restauraci.',
        'highlights' => [
            'Jediný měšťanský pivovar v ČR (tradice od roku 1649)',
            'Komentované prohlídky pivovarského provozu s ochutnávkou',
            'Pivovarská prodejna a restaurace přímo u řeky Otavy'
        ],
        'lat' => 49.2570,
        'lng' => 13.9060
    ],
    [
        'id' => 'strakonice_minipivovar_hadak',
        'title' => 'Minipivovar Haďák (Pivnice U Hada Strakonice)',
        'category' => 'tradice',
        'badge' => '22 km / Minipivovar',
        'distance' => '22 km',
        'time' => '20 min autem',
        'image' => $defaultImage,
        'description' => 'Oblíbený řemeslný minipivovar na Palackého náměstí ve Strakonicích s vlastní útulnou pivnicí U Hada. Vaří poctivá nefiltrovaná piva českého typu i speciály.',
        'highlights' => [
            'Řemeslný rodinný minipivovar přímo ve Strakonicích',
            'Pivnice U Hada na Palackého náměstí',
            'Vlastní nefiltrovaná piva a prodej piva s sebou'
        ],
        'lat' => 49.2612,
        'lng' => 13.9025
    ],
    [
        'id' => 'strakonice_podskali',
        'title' => 'Naučná stezka Podskalí u Otavy (Strakonice)',
        'category' => 'priroda',
        'badge' => '22 km / Příroda',
        'distance' => '22 km',
        'time' => '20 min autem',
        'image' => $defaultImage,
        'description' => 'Oblíbený lesopark a romantická přírodní stezka podél řeky Otavy ve Strakonicích. Vhodné na odpočinkovou procházku i běh.',
        'highlights' => ['Lesopark a stezka podél řeky Otavy', 'Dětská hřiště a stánky s občerstvením', 'Klidná oáza ve Strakonicích'],
        'lat' => 49.2620,
        'lng' => 13.8980
    ],
    [
        'id' => 'strakonice_bazen_kryty',
        'title' => 'Krytý plavecký bazén Strakonice',
        'category' => 'koupani',
        'badge' => '22 km / Bazén',
        'distance' => '22 km',
        'time' => '20 min autem',
        'image' => $defaultImage,
        'description' => 'Krytý plavecký bazén ve Strakonicích s 25m dráhami, dětským bazénkem, tobogánem a vířivkami pro celoroční plavání.',
        'highlights' => ['Plavecký 25m bazén a tobogán', 'Dětský bazének a vířivky', 'Celoroční provoz'],
        'lat' => 49.2550,
        'lng' => 13.8950
    ],
    [
        'id' => 'strakonice_koupaliste_letni',
        'title' => 'Venkovní letní koupaliště Strakonice',
        'category' => 'koupani',
        'badge' => '22 km / Letní',
        'distance' => '22 km',
        'time' => '20 min autem',
        'image' => $defaultImage,
        'description' => 'Slunné venkovní letní koupaliště ve Strakonicích s velkým bazénem, tobogánem, travnatými plážemi a občerstvením.',
        'highlights' => ['Slunné travnaté pláže a velký bazén', 'Tobogán a dětské vodní atrakce', 'Stánky s občerstvením'],
        'lat' => 49.2555,
        'lng' => 13.8955
    ],
    [
        'id' => 'rozhledna_haniperk',
        'title' => 'Rozhledna Haniperk (Svobodná hora u Bavorova)',
        'category' => 'rozhledny priroda',
        'badge' => '22 km / Rozhledna',
        'distance' => '22 km',
        'time' => '25 min autem',
        'image' => $defaultImage,
        'description' => 'Moderní 24,5 metru vysoká dřevěná rozhledna na vrcholu Svobodná hora (640 m n. m.) u Bavorova a Vodňanských Svobodných Hor z roku 2019. Nabízí kruhový výhled na Šumavu, Novohradské hory, Blanský les i Helfenburk.',
        'highlights' => [
            'Dřevěná rozhledna s vyhlídkou ve výšce 21 metrů',
            'Kruhový rozhled na hřebeny Šumavy i hrad Helfenburk',
            'Příjemný výstup lesem z Vodňanských Svobodných Hor či Bavorova'
        ],
        'lat' => 49.1230,
        'lng' => 14.1167
    ],

    // 24 – 25 km (Javorník, Kašperk, Kašperské Hory, Prachatice, Zelené autobusy)
    [
        'id' => 'javornik',
        'title' => 'Klostermannova rozhledna na Javorníku',
        'category' => 'rozhledny priroda',
        'badge' => '24 km / Rozhledna',
        'distance' => '24 km',
        'time' => '28 min autem',
        'image' => $defaultImage,
        'description' => 'Kamenná rozhledna na vrcholu hora Javorník (1066 m n. m.). Nabízí neopakovatelný kruhový výhled na celou Šumavu a za dobré viditelnosti až na Alpy.',
        'highlights' => ['Vrchol Javorník (1066 m n. m.)', 'Úchvatný kruhový výhled na Šumavu', 'Naučná stezka K. Klostermanna'],
        'lat' => 49.1360,
        'lng' => 13.6550
    ],
    [
        'id' => 'kasperk_hrad',
        'title' => 'Královský hrad Kašperk',
        'category' => 'hrady rozhledny',
        'badge' => '25 km / Hrad',
        'distance' => '25 km',
        'time' => '30 min autem',
        'image' => $defaultImage,
        'description' => 'Nejvýše položený královský hrad v ČR založený Karlem IV. r. 1356. Prohlídkové okruhy, kostýmované akce pro rodiny a stezka na Pustý hrádek.',
        'highlights' => ['Nejvýše položený hrad založený Karlem IV.', 'Vyhlídky z hradních věží', 'Stezka na vyhlídku Pustý hrádek'],
        'lat' => 49.1561,
        'lng' => 13.5647
    ],
    [
        'id' => 'kasperske_hory',
        'title' => 'Historické městečko Kašperské Hory',
        'category' => 'tradice',
        'badge' => '25 km / Město',
        'distance' => '25 km',
        'time' => '30 min autem',
        'image' => $defaultImage,
        'description' => 'Malebné horské městečko pod hradem Kašperk s Muzeem Šumavy, Muzeem motocyklů, historickým náměstím a kavárnami.',
        'highlights' => ['Muzeum Šumavy a Muzeum motocyklů', 'Náměstí s barokní radnicí', 'Kavárny a výchozí bod na turistické trasy'],
        'lat' => 49.1440,
        'lng' => 13.5550
    ],
    [
        'id' => 'prachatice_bazen',
        'title' => 'Krytý plavecký bazén Prachatice',
        'category' => 'koupani',
        'badge' => '25 km / Bazén',
        'distance' => '25 km',
        'time' => '25 min autem',
        'image' => $defaultImage,
        'description' => 'Moderní krytý bazén v Prachaticích s divokou řekou, vířivkami, tobogánem a dětským bazénkem.',
        'highlights' => ['Divoká řeka a vířivky', 'Plavecký bazén a tobogán', 'Příjemné rodinné prostředí'],
        'lat' => 49.0125,
        'lng' => 13.9980
    ],
    [
        'id' => 'prachatice_sauny',
        'title' => 'Saunový svět a Wellness Prachatice',
        'category' => 'koupani',
        'badge' => '25 km / Sauny',
        'distance' => '25 km',
        'time' => '25 min autem',
        'image' => $defaultImage,
        'description' => 'Vyhlášený saunový svět v Prachaticích s finskou saunou, parní lázní, infrasaunou a ochlazovacím bazénkem.',
        'highlights' => ['Finská sauna, parní lázeň a infrasauna', 'Ochlazovací bazének a odpočívárna', 'Dokonalá relaxace i v zimě'],
        'lat' => 49.0128,
        'lng' => 13.9985
    ],
    [
        'id' => 'sumava_autobusy',
        'title' => 'Šumava NP a Zelené autobusy z Vimperka',
        'category' => 'priroda',
        'badge' => 'NP Šumava',
        'distance' => 'Od 25 km',
        'time' => 'Dle tras',
        'image' => $defaultImage,
        'description' => 'Během letní sezóny můžete z Vimperka využít ekologické Zelené autobusy NP Šumava (www.np.sumava.cz), které vás pohodlně vyvezou na šumavské hřebeny.',
        'highlights' => ['Ekologická doprava po hřebenech Šumavy', 'Spoje přímo z Vimperka', 'Informace na www.np.sumava.cz'],
        'lat' => 49.0530,
        'lng' => 13.7820
    ],

    // 26 – 28 km (Kubova Huť, Libín)
    [
        'id' => 'kubovahut',
        'title' => 'Ski areál Kubova Huť',
        'category' => 'zima',
        'badge' => '26 km / Lyže a Vlak',
        'distance' => '26 km',
        'time' => '28 min autem / vlakem',
        'image' => $defaultImage,
        'description' => 'Příjemné sjezdové lyžování pod vrcholem Boubína v nejvýše položené železniční stanici v ČR (995 m n. m.). Vhodné pro rodiny s dětmi.',
        'highlights' => ['Nejvýše položené vlakové nádraží v ČR (995 m)', 'Rodinné sjezdovky a dětský vlek', 'Nástup na běžecké trasy pod Boubínem'],
        'lat' => 48.9833,
        'lng' => 13.7833
    ],
    [
        'id' => 'libin_rozhledna',
        'title' => 'Rozhledna Libín u Prachatic (1096 m n. m.)',
        'category' => 'rozhledny priroda',
        'badge' => '28 km / Rozhledna',
        'distance' => '28 km',
        'time' => '30 min autem',
        'image' => $defaultImage,
        'description' => 'Impozantní 27 metrů vysoká kamenná rozhledna z roku 1883 na dominantním šumavském vrcholu Libín (1096 m n. m.). Nabízí dechberoucí kruhový výhled na celou Šumavu, Novohradské hory a za příznivých podmínek i rakouské Alpy. V areálu se nachází také oblíbený lesní lanový park.',
        'highlights' => [
            'Historická kamenná rozhledna na hoře Libín (1096 m)',
            'Panoramatický výhled na Šumavu i Alpy',
            'Lanový park a krásné lesní turistické stezky'
        ],
        'lat' => 48.9788,
        'lng' => 14.0118
    ],

    // 30 – 35 km (Kratochvíle, Churáňov, Křišťanovský rybník, Zadov, Soumarské rašeliniště)
    [
        'id' => 'kratochvile',
        'title' => 'Renesanční vodní zámek Kratochvíle',
        'category' => 'hrady',
        'badge' => '30 km / Zámek',
        'distance' => '30 km',
        'time' => '32 min autem',
        'image' => $defaultImage,
        'description' => 'Perla české renesance nedaleko Netolic. Kouzelný vodní zámek obklopený vodním příkopem a udržovanou italskou renesanční zahradou.',
        'highlights' => ['Unikátní vodní zámek v italském stylu', 'Nádherné renesanční zahrady', 'Bohatá výzdoba a zámecké prohlídky'],
        'lat' => 49.0592,
        'lng' => 14.1683
    ],
    [
        'id' => 'churanov_zadov_stezky',
        'title' => 'Churáňov a Zadov – Hřebenové turistické trasy',
        'category' => 'priroda rozhledny',
        'badge' => '30 km / Turistika a Výhledy',
        'distance' => '30 km',
        'time' => '32 min autem',
        'image' => $defaultImage,
        'description' => 'Vyhlášené horské středisko Churáňov a Zadov. Výchozí bod pro pěší hřebenové túry a cyklovýlety Národním parkem Šumava. Najdete zde Naučnou stezku Churáňov (cca 6,5 km), meteorologickou stanici, rozhlednu na skokanském můstku a lanový park.',
        'highlights' => [
            'Naučná stezka Churáňov (6,5 km) s výhledy do kraje',
            'Rozhledna na bývalém skokanském můstku na Zadově',
            'Výchozí bod na hřebenové trasy (Zlatá Studna, Horská Kvilda)'
        ],
        'lat' => 49.0702,
        'lng' => 13.6254
    ],
    [
        'id' => 'kristanovsky_rybnik',
        'title' => 'Křišťanovský rybník – Rašelinové koupání',
        'category' => 'koupani priroda',
        'badge' => '30 km / Rašelina',
        'distance' => '30 km',
        'time' => '30 min autem',
        'image' => $defaultImage,
        'description' => 'Přírodní rybník s léčivou rašelinovou vodou obklopený šumavskými lesy nedaleko Prachatic. Koupání s blahodárnými účinky na pokožku a klouby.',
        'highlights' => ['Léčivá rašelinová tmavá voda', 'Přírodní koupaliště v srdci přírody', 'Klidná lokalita bez davů'],
        'lat' => 48.9560,
        'lng' => 13.9680
    ],
    [
        'id' => 'zadov',
        'title' => 'Ski areál Zadov',
        'category' => 'zima',
        'badge' => '32 km / Sjezdovky',
        'distance' => '32 km',
        'time' => '35 min autem',
        'image' => $defaultImage,
        'description' => 'Hlavní šumavské lyžařské středisko. Sedačkové lanovky, sjezdovky pro začátečníky i zkušené lyžaře, večerní lyžování a vyhlídka na skokanském můstku.',
        'highlights' => ['Sedačkové lanovky a večerní lyžování', 'Lyžařská škola a půjčovna vybavení', 'Vyhřívaná rozhledna na skokanském můstku'],
        'lat' => 49.0667,
        'lng' => 13.6333
    ],
    [
        'id' => 'soumarske_raseliniste',
        'title' => 'Soumarské rašeliniště a Vyhlídková věž',
        'category' => 'priroda rozhledny',
        'badge' => '35 km / Rašeliniště',
        'distance' => '35 km',
        'time' => '38 min autem',
        'image' => $defaultImage,
        'description' => 'Unikátní revitalizované šumavské rašeliniště v údolí Teplé Vltavy u Soumarského Mostu (nedaleko Volar). Dřevěný povalový chodník (cca 1,5 km) s informačními panely vás provede tajemným světem rašeliníků, vřesů a masožravých rosnatek až k 10m dřevěné vyhlídkové věži.',
        'highlights' => [
            'Dřevěný povalový chodník tajemným rašeliništěm',
            'Dřevěná vyhlídková věž s rozhledem na rašeliniště a Boubín',
            'Vhodné pro rodiny s dětmi i pohodovou procházku v přírodě'
        ],
        'lat' => 48.9080,
        'lng' => 13.8290
    ],

    // 38 – 55 km (Kvilda Bílá stopa, Hrad Rabí, Pramen Vltavy, Český Krumlov)
    [
        'id' => 'kvilda',
        'title' => 'Kvilda a Běžecká Bílá stopa',
        'category' => 'zima',
        'badge' => '38 km / Běžky',
        'distance' => '38 km',
        'time' => '40 min autem',
        'image' => $defaultImage,
        'description' => 'Mekka šumavského běžeckého lyžování. Nástup na desítky kilometrů pravidelně upravovaných běžeckých okruhů Šumavské Bílé stopy (www.bilastopa.cz).',
        'highlights' => ['Pravidelně upravovaná Bílá stopa (bilastopa.cz)', 'Desítky km upravovaných hřebenových tras', 'Dětské sjezdové vleky na Kvildě'],
        'lat' => 49.0185,
        'lng' => 13.5802
    ],
    [
        'id' => 'rabi_hrad',
        'title' => 'Státní hrad Rabí',
        'category' => 'hrady rozhledny',
        'badge' => '40 km / Hrad',
        'distance' => '40 km',
        'time' => '45 min autem',
        'image' => $defaultImage,
        'description' => 'Nejrozsáhlejší hradní zřícenina v Čechách tyčící se nad řekou Otavou. Monumentální hradní areál spojený s husitským vojevůdcem Janem Žižkou, s mohutnou obytnou věží (donjonem) a nádhernými výhledy do pošumavské krajiny.',
        'highlights' => ['Největší hradní zřícenina v České republice', 'Vyhlídka z monumentální hradní věže (donjonu)', 'Místo spojené s Janem Žižkou a bohatá historie'],
        'lat' => 49.2788,
        'lng' => 13.6184
    ],
    [
        'id' => 'pramen_vltavy',
        'title' => 'Pramen Vltavy (Kvilda)',
        'category' => 'priroda',
        'badge' => '42 km / Šumavský symbol',
        'distance' => '42 km',
        'time' => '45 min autem',
        'image' => $defaultImage,
        'description' => 'Symbolické prameniště naší nejdelší národní řeky Vltavy pod Černou horou (1172 m n. m.). Z Kvildy vede k upravenému prameni s dřevěnou sochou a vyhlídkou oblíbená asfaltová stezka vhodná pro pěší túru i cyklovýlet.',
        'highlights' => [
            'Symbolický pramen nejvýznamnější české řeky Vltavy',
            'Nádherná horská příroda v I. zóně Národního parku Šumava',
            'Skvělá trasa z Kvildy (cca 6 km pěšky nebo na kole)'
        ],
        'lat' => 48.9785,
        'lng' => 13.5620
    ],
    [
        'id' => 'cesky_krumlov_zamek',
        'title' => 'Státní hrad a zámek Český Krumlov (UNESCO)',
        'category' => 'hrady tradice',
        'badge' => '55 km / UNESCO a Celodenní',
        'distance' => '55 km od penzionu',
        'time' => 'Celodenní výlet (55 min autem)',
        'image' => $defaultImage,
        'description' => 'Druhý největší hradní a zámecký komplex v ČR zapsaný na seznamu světového dědictví UNESCO. Monumentální Plášťový most, barokní divadlo, zámecká věž s neopakovatelným výhledem, zámecké zahrady s otáčivým hledištěm a kouzelné uličky historického města na meandru Vltavy. Skvělý tip na nezapomenutelný celodenní výlet.',
        'highlights' => [
            'Památka světového dědictví UNESCO a 2. největší zámek v ČR',
            'Unikátní Plášťový most, zámecká věž a barokní divadlo',
            'Zámecká zahrada s otáčivým hledištěm a historické centrum'
        ],
        'lat' => 48.8127,
        'lng' => 14.3167
    ]
];
?>

<style>
    .trip-filters-wrapper {
        display: flex;
        justify-content: center;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 2.5rem;
        margin-bottom: 2rem;
    }
    .filter-btn {
        background: #ffffff;
        color: var(--text-dark, #2d3748);
        border: 2px solid var(--border, #e2e8f0);
        padding: 0.7rem 1.4rem;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.95rem;
        cursor: pointer;
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        box-shadow: 0 2px 5px rgba(0,0,0,0.05);
    }
    .filter-btn .filter-count {
        background: rgba(0, 0, 0, 0.07);
        color: inherit;
        font-size: 0.8rem;
        padding: 0.15rem 0.55rem;
        border-radius: 20px;
        margin-left: 0.25rem;
        font-weight: 700;
        transition: all 0.3s ease;
    }
    .filter-btn i,
    .filter-btn svg {
        color: inherit;
        stroke: currentColor;
    }
    .filter-btn:hover {
        background: var(--primary, #8B5E3C) !important;
        border-color: var(--primary, #8B5E3C) !important;
        color: #ffffff !important;
        transform: translateY(-2px);
    }
    .filter-btn:hover *,
    .filter-btn:hover .filter-count,
    .filter-btn:hover i,
    .filter-btn:hover svg {
        color: #ffffff !important;
        stroke: #ffffff !important;
    }
    .filter-btn:hover .filter-count {
        background: rgba(255, 255, 255, 0.25) !important;
    }
    .filter-btn.active {
        background: var(--primary, #8B5E3C) !important;
        color: #ffffff !important;
        border-color: var(--primary, #8B5E3C) !important;
        box-shadow: 0 4px 12px rgba(139, 94, 60, 0.35);
    }
    .filter-btn.active *,
    .filter-btn.active .filter-count,
    .filter-btn.active i,
    .filter-btn.active svg {
        color: #ffffff !important;
        stroke: #ffffff !important;
    }
    .filter-btn.active .filter-count {
        background: rgba(255, 255, 255, 0.25) !important;
    }
    
    .trip-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        margin-top: 2rem;
    }
    .trip-card {
        background: #ffffff;
        border-radius: 18px;
        overflow: hidden;
        box-shadow: var(--shadow, 0 4px 20px rgba(0,0,0,0.08));
        transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
        border: 1px solid var(--border, #e2e8f0);
        display: flex;
        flex-direction: column;
        width: 100%;
        opacity: 1;
        transform: scale(1);
    }
    .trip-card.is-hidden {
        display: none !important;
    }
    .trip-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px rgba(0,0,0,0.12);
    }
    .trip-img-wrapper {
        position: relative;
        height: 220px;
        overflow: hidden;
        width: 100%;
        background: #f8fafc;
    }
    .trip-img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }
    .trip-card:hover .trip-img {
        transform: scale(1.08);
    }
    .trip-badge {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: var(--primary, #2d5a27);
        backdrop-filter: blur(4px);
        color: #ffffff;
        padding: 0.4rem 1rem;
        border-radius: 50px;
        font-size: 0.85rem;
        font-weight: 600;
        box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        z-index: 10;
    }
    .trip-content {
        padding: 1.75rem;
        flex-grow: 1;
        display: flex;
        flex-direction: column;
    }
    .trip-meta {
        display: flex;
        flex-wrap: wrap;
        gap: 1.25rem;
        margin-bottom: 1rem;
        color: var(--text-light, #718096);
        font-size: 0.9rem;
        font-weight: 500;
    }
    .trip-meta span {
        display: flex;
        align-items: center;
        gap: 0.4rem;
    }
    .trip-title {
        margin-bottom: 0.75rem;
        font-size: 1.3rem;
        color: var(--text-dark, #1a202c);
        line-height: 1.35;
        font-weight: 700;
    }
    .trip-description {
        color: var(--text-muted, #4a5568);
        line-height: 1.6;
        margin-bottom: 1.25rem;
        font-size: 0.95rem;
    }
    .trip-highlights {
        margin-bottom: 1.5rem;
        padding-left: 0;
        list-style: none;
        color: var(--text-muted, #4a5568);
        font-size: 0.9rem;
        line-height: 1.6;
    }
    .trip-highlights li {
        position: relative;
        padding-left: 1.5rem;
        margin-bottom: 0.4rem;
    }
    .trip-highlights li::before {
        content: "✓";
        position: absolute;
        left: 0;
        color: var(--primary, #2d5a27);
        font-weight: bold;
    }
    .trip-footer {
        margin-top: auto;
        padding-top: 1.25rem;
        border-top: 1px solid var(--border, #edf2f7);
    }
    .btn-gmaps {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.6rem;
        background: var(--primary, #2d5a27);
        color: #ffffff;
        font-weight: 600;
        font-size: 0.95rem;
        padding: 0.75rem 1.25rem;
        border-radius: 12px;
        text-decoration: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 12px rgba(45, 90, 39, 0.25);
        width: 100%;
        border: none;
        cursor: pointer;
    }
    .btn-gmaps:hover {
        background: #1e3d1a;
        color: #ffffff;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(45, 90, 39, 0.35);
    }
    
    .distance-section {
        background: var(--bg-light, #f8fafc);
        border-radius: 24px;
        padding: 4rem 2rem;
        margin: 4rem 0;
        border: 1px solid var(--border, #e2e8f0);
    }
    .distance-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
        gap: 1.5rem;
        margin-top: 2.5rem;
    }
    .distance-item {
        background: #ffffff;
        padding: 2rem 1.25rem;
        border-radius: 16px;
        text-align: center;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
        border: 1px solid var(--border, #e2e8f0);
        transition: transform 0.3s ease;
    }
    .distance-item:hover {
        transform: translateY(-4px);
    }
    .distance-val {
        display: block;
        font-size: 2.3rem;
        font-weight: 800;
        color: var(--primary, #2d5a27);
        margin-bottom: 0.4rem;
        line-height: 1;
    }
    .distance-label {
        font-weight: 600;
        color: var(--text-dark, #2d3748);
        font-size: 1rem;
    }
</style>

<!-- Hero Section -->
<section class="hero" style="height: 55vh; min-height: 420px;">
    <div class="hero-bg" style="background-image: url(/assets/img/vylety_hero.png);"></div>
    <div class="hero-overlay"></div>
    <div class="container hero-content">
        <h2 class="hero-subtitle fadeIn">Krásy Pošumavska</h2>
        <h1 class="hero-title fadeInDelay">Tipy na výlety a okolí</h1>
    </div>
</section>

<!-- Main Content -->
<section class="section-padding">
    <div class="container">
        <div class="text-center" style="max-width: 800px; margin-inline: auto;">
            <span class="section-tag">Kam vyrazit</span>
            <h2 class="section-title">Co navštívit v okolí Straňovic</h2>
            <p class="section-description">
                Penzion a statek ve Straňovicích je skvělým výchozím bodem pro pěší túry, cyklovýlety, lyžování, wellness i objevování památek. Vyberte si kategorii a naplánujte si perfektní den.
            </p>

            <!-- Filter Buttons -->
            <div class="trip-filters-wrapper">
                <button class="filter-btn active" data-filter="all">
                    <i data-lucide="grid"></i> Všechny výlety <span class="filter-count">38</span>
                </button>
                <button class="filter-btn" data-filter="pesky">
                    <i data-lucide="footprints"></i> U penzionu a Pěšky <span class="filter-count">13</span>
                </button>
                <button class="filter-btn" data-filter="hrady">
                    <i data-lucide="landmark"></i> Hrady a Zámky <span class="filter-count">8</span>
                </button>
                <button class="filter-btn" data-filter="rozhledny">
                    <i data-lucide="binoculars"></i> Rozhledny a Vyhlídky <span class="filter-count">10</span>
                </button>
                <button class="filter-btn" data-filter="priroda">
                    <i data-lucide="trees"></i> Příroda a NP Šumava <span class="filter-count">16</span>
                </button>
                <button class="filter-btn" data-filter="tradice">
                    <i data-lucide="archive"></i> Muzea a Tradice <span class="filter-count">16</span>
                </button>
                <button class="filter-btn" data-filter="koupani">
                    <i data-lucide="waves"></i> Koupání a Wellness <span class="filter-count">7</span>
                </button>
                <button class="filter-btn" data-filter="zima">
                    <i data-lucide="snowflake"></i> Zima a Běžky <span class="filter-count">3</span>
                </button>
            </div>
        </div>

        <!-- Trip Grid -->
        <div class="trip-grid" id="tripGrid">
            <?php foreach ($trips as $trip): 
                $gmapsUrl = 'https://www.google.com/maps/dir/?api=1&destination=' . urlencode($trip['lat'] . ',' . $trip['lng']);
                $imgSrc = !empty($trip['image']) ? $trip['image'] : $defaultImage;
                if (strpos($imgSrc, '/') !== 0 && strpos($imgSrc, 'http') !== 0) {
                    $imgSrc = '/' . $imgSrc;
                }
            ?>
            <div class="trip-card" data-category="<?= htmlspecialchars($trip['category']) ?>">
                <div class="trip-img-wrapper">
                    <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($trip['title']) ?>" class="trip-img" loading="lazy">
                    <span class="trip-badge"><?= htmlspecialchars($trip['badge']) ?></span>
                </div>
                <div class="trip-content">
                    <div class="trip-meta">
                        <span><i data-lucide="map-pin"></i> <?= htmlspecialchars($trip['distance']) ?></span>
                        <?php 
                            $rawTime = $trip['time'];
                            $timeStr = mb_strtolower($rawTime, 'UTF-8');
                            
                            // Detekce kombinované trasy pěšky a autem
                            if (strpos($timeStr, 'pěšky') !== false && strpos($timeStr, 'autem') !== false) {
                                // Např. "45 min pěšky / 5 min autem" nebo "4 min autem / 20 min pěšky"
                                preg_match('/(\d+(?:[–-]\d+)?\s*min)\s*pěšky/iu', $rawTime, $mFoot);
                                preg_match('/(\d+(?:[–-]\d+)?\s*min)\s*autem/iu', $rawTime, $mCar);
                                $footTime = !empty($mFoot[1]) ? $mFoot[1] : '';
                                $carTime = !empty($mCar[1]) ? $mCar[1] : '';
                            ?>
                                <?php if ($footTime): ?>
                                    <span><i data-lucide="footprints" title="Pěšky"></i> <?= htmlspecialchars($footTime) ?></span>
                                <?php endif; ?>
                                <?php if ($carTime): ?>
                                    <span><i data-lucide="car" title="Autem"></i> <?= htmlspecialchars($carTime) ?></span>
                                <?php endif; ?>
                            <?php 
                            } else {
                                $hasFoot = (strpos($timeStr, 'pěšky') !== false || strpos($timeStr, 'procházka') !== false);
                                $hasTrain = (strpos($timeStr, 'vlakem') !== false);
                                $hasCar = (strpos($timeStr, 'autem') !== false || (! $hasFoot && strpos($timeStr, 'min') !== false));
                                
                                // Očistíme slova "pěšky", "autem", "procházka" z textu pro čistší vzhled
                                $cleanedTime = preg_replace('/\s*(pěšky|autem|procházka)\s*/iu', '', $rawTime);
                                $cleanedTime = trim($cleanedTime);
                                if (empty($cleanedTime)) {
                                    $cleanedTime = $rawTime;
                                }
                            ?>
                                <span>
                                    <?php if ($hasFoot): ?>
                                        <i data-lucide="footprints" title="Pěšky"></i>
                                    <?php elseif ($hasTrain): ?>
                                        <i data-lucide="train" title="Vlakem"></i>
                                    <?php elseif ($hasCar): ?>
                                        <i data-lucide="car" title="Autem"></i>
                                    <?php else: ?>
                                        <i data-lucide="calendar" title="Čas"></i>
                                    <?php endif; ?>
                                    <?= htmlspecialchars($cleanedTime) ?>
                                </span>
                            <?php } ?>
                    </div>
                    <h3 class="trip-title"><?= htmlspecialchars($trip['title']) ?></h3>
                    <p class="trip-description"><?= htmlspecialchars($trip['description']) ?></p>
                    
                    <?php if (!empty($trip['highlights'])): ?>
                    <ul class="trip-highlights">
                        <?php foreach ($trip['highlights'] as $highlight): ?>
                            <li><?= htmlspecialchars($highlight) ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>

                    <div class="trip-footer">
                        <a href="<?= $gmapsUrl ?>" target="_blank" rel="noopener noreferrer" class="btn-gmaps">
                            <i data-lucide="map-pin"></i> Navigovat
                        </a>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<!-- Distances Section -->
<section class="container">
    <div class="distance-section">
        <div class="text-center">
            <span class="section-tag">Dostupnost</span>
            <h2 class="section-title">Vše podstatné nadosah ze Straňovic</h2>
        </div>
        <div class="distance-grid">
            <div class="distance-item">
                <span class="distance-val">1 - 2 km</span>
                <span class="distance-label">Malenice a Fara</span>
            </div>
            <div class="distance-item">
                <span class="distance-val">5 km</span>
                <span class="distance-label">Čkyně</span>
            </div>
            <div class="distance-item">
                <span class="distance-val">8 km</span>
                <span class="distance-label">Volyně</span>
            </div>
            <div class="distance-item">
                <span class="distance-val">13 - 14 km</span>
                <span class="distance-label">Vimperk</span>
            </div>
            <div class="distance-item">
                <span class="distance-val">19 - 20 km</span>
                <span class="distance-label">Strakonice</span>
            </div>
            <div class="distance-item">
                <span class="distance-val">23 - 25 km</span>
                <span class="distance-label">Prachatice a NP Šumava</span>
            </div>
        </div>
    </div>
</section>

<!-- Map CTA -->
<section class="section-padding text-center" style="padding-top: 0;">
    <div class="container">
        <div class="cta-box" style="background: var(--text-dark, #1a202c); color: white; padding: 4rem 2rem; border-radius: 24px;">
            <h2 style="color: white; margin-bottom: 1.5rem;">Potřebujete osobní tip nebo tištěnou mapu?</h2>
            <p style="margin-bottom: 2.5rem; opacity: 0.85; max-width: 650px; margin-inline: auto; font-size: 1.1rem; line-height: 1.6;">
                Na recepci penzionu Straňovice Vám rádi zapůjčíme tištěné turistické a cyklistické mapy, doporučíme aktuální trasu nebo poradíme, kam vyrazit za zážitky.
            </p>
            <a href="index.php#contact" class="btn btn-primary">Kontaktujte nás</a>
        </div>
    </div>
</section>

<!-- JS Filtering Script -->
<script>
(function() {
    function initFilters() {
        const filterBtns = document.querySelectorAll('.filter-btn');
        const tripCards = document.querySelectorAll('#tripGrid .trip-card');
        if (!filterBtns.length || !tripCards.length) return;

        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');

                const filterValue = this.getAttribute('data-filter');

                tripCards.forEach(card => {
                    const cardCategory = card.getAttribute('data-category') || '';
                    const categories = cardCategory.split(' ');
                    if (filterValue === 'all' || categories.includes(filterValue)) {
                        card.classList.remove('is-hidden');
                        card.style.display = 'flex';
                        card.style.opacity = '1';
                    } else {
                        card.classList.add('is-hidden');
                        card.style.display = 'none';
                    }
                });
            });
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initFilters);
    } else {
        initFilters();
    }
})();
</script>

<?php CMS::getFooter(); ?>