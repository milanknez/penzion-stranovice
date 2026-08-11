<?php
require_once __DIR__ . '/../admin/includes/CMS.php';
CMS::getHeader();

$trips = [
    // --- U PENZIONU & MALENICE ---
    [
        'id' => 'stranovice_bazen',
        'title' => 'Venkovní bazén Penzionu Straňovice',
        'category' => 'okoli',
        'badge' => 'U penzionu',
        'distance' => 'Přímo u penzionu',
        'time' => '0 min',
        'image' => '/assets/img/hero_statek.jpg',
        'description' => 'Přímo v areálu našeho statku ve Straňovicích je pro ubytované hosty k dispozici osvěžující venkovní bazén pro letní relaxaci.',
        'highlights' => ['Venkovní bazén exkluzivně pro ubytované', 'Osvěžení v horkých letních dnech', 'Pohodlná lehátka a trávník okolo'],
        'lat' => 49.12386,
        'lng' => 13.89667
    ],
    [
        'id' => 'stranovice_ohniste',
        'title' => 'Venkovní ohniště a Posezení u Penzionu',
        'category' => 'okoli',
        'badge' => 'U penzionu',
        'distance' => 'Přímo u penzionu',
        'time' => '0 min',
        'image' => '/assets/img/hero_statek.jpg',
        'description' => 'Romantické venkovní ohniště s dřevem a posezením pro ubytované hosty. Ideální pro večerní opékání špekáčků a kytaru pod hvězdami.',
        'highlights' => ['Tradiční venkovní ohniště s posezením', 'Příprava dřeva na opékání', 'Klidné večerní posezení na statku'],
        'lat' => 49.12386,
        'lng' => 13.89667
    ],
    [
        'id' => 'stranovicky_rybnik',
        'title' => 'Straňovický rybník u řeky Volyňky',
        'category' => 'okoli',
        'badge' => 'Pěšky 2 min',
        'distance' => '200 m od penzionu',
        'time' => '2 min pěšky',
        'image' => '/assets/img/hero_statek.jpg',
        'description' => 'Odpočinková zóna u Straňovického rybníka na řece Volyňce. Ráj pro rybáře a klidná přírodní oáza pro krátkou večerní či ranní procházku.',
        'highlights' => ['Odpočinková rybářská zóna', 'Krásné přírodní prostředí u řeky Volyňky', 'Jen pár kroků od penzionu'],
        'lat' => 49.1255,
        'lng' => 13.8860
    ],
    [
        'id' => 'malenice_fara',
        'title' => 'Opravená Fara v Malenicích a Letní kavárna',
        'category' => 'okoli',
        'badge' => '2 km / Pěšky',
        'distance' => '2 km od penzionu',
        'time' => '20 min pěšky',
        'image' => '/assets/img/map_malenice.png',
        'description' => 'Krásně zrekonstruovaný objekt historické fary v Malenicích. Pořádají se zde sezónní výstavy, funguje tu letní kavárnička a zázemí s dětským hřištěm.',
        'highlights' => ['Letní kavárna a sezónní výstavy', 'Dětské hřiště v klidném dvoře fary', 'Historická architektura'],
        'lat' => 49.1292,
        'lng' => 13.8828
    ],
    [
        'id' => 'malenice_kostel',
        'title' => 'Barokní kostel sv. Jakuba v Malenicích',
        'category' => 'okoli',
        'badge' => '2 km / Památka',
        'distance' => '2 km',
        'time' => '20 min pěšky',
        'image' => '/assets/img/map_malenice.png',
        'description' => 'Dominanta obce Malenice – barokní kostel sv. Jakuba ze 14. století s dochovaným historickým interiérem a zvonicí.',
        'highlights' => ['Barokní architektonická dominanta', 'Historický interiér kostela', 'V centru památkové zóny Malenic'],
        'lat' => 49.1292,
        'lng' => 13.8828
    ],
    [
        'id' => 'malenice_hrbitov',
        'title' => 'Památný hřbitov v Malenicích',
        'category' => 'okoli',
        'badge' => '2 km / Historie',
        'distance' => '2 km',
        'time' => '20 min pěšky',
        'image' => '/assets/img/map_malenice.png',
        'description' => 'Unikátní malenický hřbitov – místo posledního odpočinku architekta Josefa Zítka (stavitele Národního divadla), archiváře Františka Teplého, režiséra Zdeňka Podskalského a herečky Jiřiny Jiráskové.',
        'highlights' => ['Hrob režiséra Zdeňka Podskalského a Jiřiny Jiráskové', 'Hrob architekta Josefa Zítka (stavitel ND)', 'Památný archivář a kněz František Teplý'],
        'lat' => 49.1294,
        'lng' => 13.8830
    ],
    [
        'id' => 'malenice_podskalsky_vila',
        'title' => 'Vila Zdeňka Podskalského v Malenicích',
        'category' => 'okoli',
        'badge' => '2 km / Architektura',
        'distance' => '2 km',
        'time' => '20 min pěšky',
        'image' => '/assets/img/map_malenice.png',
        'description' => 'Stylová rodinná vila režiséra Zdeňka Podskalského v Malenicích. Objekt je v soukromém vlastnictví a lze si jej prohlédnout zvenčí při procházce obcí.',
        'highlights' => ['Rodinné sídlo slavného režiséra', 'Stylová architektura u řeky', 'Prohlídka zvenčí při procházce obcí'],
        'lat' => 49.1288,
        'lng' => 13.8820
    ],
    [
        'id' => 'malenice_malinove_slavnosti',
        'title' => 'Malinové slavnosti v Malenicích',
        'category' => 'okoli',
        'badge' => 'Červenec / Akce',
        'distance' => '2 km',
        'time' => 'Červencová sobota',
        'image' => '/assets/img/event.png',
        'description' => 'Tradiční červencová slavnost v Malenicích plná malinových specialit, KOLÁČŮ, řemeslného jarmarku, živé hudby a programu pro děti.',
        'highlights' => ['Tradiční červencová akce', 'Malinové koláče, dobroty a jarmark', 'Kulturní a hudební program'],
        'lat' => 49.1290,
        'lng' => 13.8825
    ],
    [
        'id' => 'malenice_hriste',
        'title' => 'Víceúčelové sportovní hřiště Malenice',
        'category' => 'okoli',
        'badge' => '2 km / Sport',
        'distance' => '2 km',
        'time' => '4 min autem / 20 min pěšky',
        'image' => '/assets/img/vylety_hero.png',
        'description' => 'Moderní víceúčelové sportovní hřiště v Malenicích ideální pro tenis, volejbal, nohejbal, malou kopanou a mičudové hry s rodinou či přáteli.',
        'highlights' => ['Kvalitní umělý povrch pro míčové sporty', 'Skvělé vyžití pro dospělé i děti', 'Pouhé 2 km od penzionu'],
        'lat' => 49.1275,
        'lng' => 13.8810
    ],
    [
        'id' => 'kaplicka_hurka',
        'title' => 'Kaplička sv. Václava na Hůrce',
        'category' => 'okoli',
        'badge' => 'Pěšky / Vyhlídka',
        'distance' => '2.5 km',
        'time' => '45 min pěšky',
        'image' => '/assets/img/vylety_hero.png',
        'description' => 'Malebná kaplička sv. Václava na návrší Hůrka nad obcí Malenice s panoramatickým výhledem na údolí řeky Volyňky a šumavské podhůří.',
        'highlights' => ['Nádherný výhled na údolí řeky Volyňky', 'Klidné místo pro odpočinek a fotky', 'Trasa nad obcí směrem na Zlešice'],
        'lat' => 49.1350,
        'lng' => 13.8920
    ],
    [
        'id' => 'mechorost',
        'title' => 'Naučná stezka Mechorost (Skalka nad Malenicemi)',
        'category' => 'okoli',
        'badge' => 'Pěšky / Příroda',
        'distance' => '2.5 km',
        'time' => '45 min pěšky',
        'image' => '/assets/img/vylety_hero.png',
        'description' => 'Naučná stezka Skalka – Mechorost vedoucí z Malenic směrem na Zlešice. Obsahuje tabule o fauně, flóře a historii zdejší krajiny.',
        'highlights' => ['Příjemná lesní naučná stezka', 'Informační tabule o přírodě Šumavska', 'Propojení na výhledy z Hůrky'],
        'lat' => 49.1360,
        'lng' => 13.8930
    ],
    [
        'id' => 'volynka_stezka',
        'title' => 'Procházka a Cyklostezka podél řeky Volyňky',
        'category' => 'okoli',
        'badge' => 'Pěšky / Kolo',
        'distance' => '1 - 6 km',
        'time' => 'Dle libosti',
        'image' => '/assets/img/hero.png',
        'description' => 'Romantická a nenáročná trasa podél meandrující řeky Volyňky ze Straňovic přes Malenice až do Lčovic nebo Volyně. Vhodné pro pěší procházky i cyklovýlety.',
        'highlights' => ['Klidná trasa podél zurčící řeky', 'Vhodné pro dospělé, děti i kočárky', 'Možnost zastávky na občerstvení po cestě'],
        'lat' => 49.1260,
        'lng' => 13.8850
    ],

    // --- PAMÁTKY V OKOLÍ ---
    [
        'id' => 'ckyne_synagoga',
        'title' => 'Čkyně – Židovská synagoga',
        'category' => 'okoli',
        'badge' => '4 km / Památka',
        'distance' => '4 km',
        'time' => '6 min autem / 15 min vlakem',
        'image' => '/assets/img/event.png',
        'description' => 'Unikátně zrenovovaná klasicistní židovská synagoga ve Čkyni s expozicí o židovské komunitě a kulturním sále.',
        'highlights' => ['Kompletně zrekonstruovaná synagoga', 'Expozice o židovské historii regionu', 'Kulturní přednášky a akce'],
        'lat' => 49.1120,
        'lng' => 13.8320
    ],
    [
        'id' => 'ckyne_hrbitov',
        'title' => 'Čkyně – Historický židovský hřbitov',
        'category' => 'okoli',
        'badge' => '4 km / Historie',
        'distance' => '4.5 km',
        'time' => '7 min autem',
        'image' => '/assets/img/event.png',
        'description' => 'Cenný historický židovský hřbitov ze 17. století u obce Čkyně obklopený kamennou zdí a vzrostlými stromy.',
        'highlights' => ['Náhrobky ze 17. až 20. století', 'Tiché a tajuplné pietní místo', 'Nedaleko židovské synagogy'],
        'lat' => 49.1140,
        'lng' => 13.8350
    ],
    [
        'id' => 'volyne_tvrz',
        'title' => 'Volyně – Gotická tvrz a Městské muzeum',
        'category' => 'okoli',
        'badge' => '6 km / Muzeum',
        'distance' => '6 km',
        'time' => '8 min autem',
        'image' => '/assets/img/prodej_hero.png',
        'description' => 'Historická gotická tvrz ve Volyni sídlící Městské muzeum s bohatými expozicemi etnografie, řemesel a sezónními výstavami.',
        'highlights' => ['Starobylá gotická tvrz', 'Městské muzeum Volyně', 'Celoroční výstavy a kulturní akce'],
        'lat' => 49.1660,
        'lng' => 13.8860
    ],
    [
        'id' => 'volyne_radnice',
        'title' => 'Volyně – Renesanční radnice a Náměstí',
        'category' => 'okoli',
        'badge' => '6 km / Památka',
        'distance' => '6 km',
        'time' => '8 min autem',
        'image' => '/assets/img/prodej_hero.png',
        'description' => 'Starobylé renesanční náměstí ve Volyni s radnicí ze 16. století, mariánským sloupem a kavárničkami.',
        'highlights' => ['Renesanční radnice s věžními hodinami', 'Historické náměstí s mariánským sloupem', 'Kavárny a restaurace na náměstí'],
        'lat' => 49.1655,
        'lng' => 13.8855
    ],
    [
        'id' => 'helfenburk',
        'title' => 'Zřícenina hradu Helfenburk',
        'category' => 'okoli',
        'badge' => '18 km / Hrad',
        'distance' => '18 km',
        'time' => '22 min autem',
        'image' => '/assets/img/chov_hero.png',
        'description' => 'Mohutná a romantická zřícenina jednoho z největších jihočeských hradů. Z dochované věže je nádherný výhled na Šumavu a okolní krajinu.',
        'highlights' => ['Mohutné hradby a zachovalá hradní věž', 'Vyhlídka na šumavské podhůří', 'Krásná procházka lesem ke hradu'],
        'lat' => 49.1411,
        'lng' => 14.0042
    ],
    [
        'id' => 'javornik',
        'title' => 'Klostermannova rozhledna na Javorníku',
        'category' => 'okoli',
        'badge' => '24 km / Rozhledna',
        'distance' => '24 km',
        'time' => '28 min autem',
        'image' => '/assets/img/vylety_hero.png',
        'description' => 'Kamenná rozhledna na vrcholu hora Javorník (1066 m n. m.). Nabízí neopakovatelný kruhový výhled na celou Šumavu a za dobré viditelnosti až na Alpy.',
        'highlights' => ['Vrchol Javorník (1066 m n. m.)', 'Úchvatný kruhový výhled na Šumavu', 'Naučná stezka K. Klostermanna'],
        'lat' => 49.1360,
        'lng' => 13.6550
    ],
    [
        'id' => 'kasperk_hrad',
        'title' => 'Královský hrad Kašperk',
        'category' => 'okoli',
        'badge' => '25 km / Hrad',
        'distance' => '25 km',
        'time' => '30 min autem',
        'image' => '/assets/img/map_kasperk.png',
        'description' => 'Nejvýše položený královský hrad v ČR založený Karlem IV. r. 1356. Prohlídkové okruhy, kostýmované akce pro rodiny a stezka na Pustý hrádek.',
        'highlights' => ['Nejvýše položený hrad založený Karlem IV.', 'Vyhlídky z hradních věží', 'Stezka na vyhlídku Pustý hrádek'],
        'lat' => 49.1561,
        'lng' => 13.5647
    ],
    [
        'id' => 'kasperske_hory',
        'title' => 'Historické městečko Kašperské Hory',
        'category' => 'okoli',
        'badge' => '25 km / Město',
        'distance' => '25 km',
        'time' => '30 min autem',
        'image' => '/assets/img/map_kasperk.png',
        'description' => 'Malebné horské městečko pod hradem Kašperk s Muzeem Šumavy, Muzeem motocyklů, historickým náměstím a kavárnami.',
        'highlights' => ['Muzeum Šumavy a Muzeum motocyklů', 'Náměstí s barokní radnicí', 'Kavárny a výchozí bod na turistické trasy'],
        'lat' => 49.1440,
        'lng' => 13.5550
    ],
    [
        'id' => 'kratochvile',
        'title' => 'Renesanční vodní zámek Kratochvíle',
        'category' => 'okoli',
        'badge' => '30 km / Zámek',
        'distance' => '30 km',
        'time' => '32 min autem',
        'image' => '/assets/img/event.png',
        'description' => 'Perla české renesance nedaleko Netolic. Kouzelný vodní zámek obklopený vodním příkopem a udržovanou italskou renesanční zahradou.',
        'highlights' => ['Unikátní vodní zámek v italském stylu', 'Nádherné renesanční zahrady', 'Bohatá výzdoba a zámecké prohlídky'],
        'lat' => 49.0592,
        'lng' => 14.1683
    ],
    [
        'id' => 'vimperk_zamek',
        'title' => 'Zámek Vimperk (Expozice sklářství a knihtisku)',
        'category' => 'okoli',
        'badge' => '12 km / Zámek',
        'distance' => '12 km',
        'time' => '15 min autem / vlakem',
        'image' => '/assets/img/prodej_hero.png',
        'description' => 'Monumentální zrekonstruovaný zámek Vimperk s novými prohlídkovými okruhy, expozicí sklářství a knihtiskařství.',
        'highlights' => ['Nově zrekonstruovaný zámecký areál', 'Expozice šumavského sklářství a tiskařství', 'Zámecká zahrada a vyhlídka'],
        'lat' => 49.0535,
        'lng' => 13.7825
    ],
    [
        'id' => 'vimperk_np_sumava',
        'title' => 'Sídlo Správy Národního parku Šumava (Vimperk)',
        'category' => 'okoli',
        'badge' => '12 km / NP Šumava',
        'distance' => '12 km',
        'time' => '15 min autem',
        'image' => '/assets/img/prodej_hero.png',
        'description' => 'Sídlo Správy NP Šumava ve Vimperku. Informační centrum s mapami, materiály a nabídkou programů v národním parku.',
        'highlights' => ['Informační středisko NP Šumava', 'Prodej turistických map a průvodců', 'Tipy na trasy a ekologický program'],
        'lat' => 49.0528,
        'lng' => 13.7830
    ],
    [
        'id' => 'vimperk_centrum',
        'title' => 'Historické centrum městečka Vimperk',
        'category' => 'okoli',
        'badge' => '12 km / Historie',
        'distance' => '12 km',
        'time' => '15 min autem',
        'image' => '/assets/img/prodej_hero.png',
        'description' => 'Svažité historické náměstí ve Vimperku s městskými hradbami, Černou věží, kostelem sv. Bartoloměje a kavárnami.',
        'highlights' => ['Svažité náměstí s měšťanskými domy', 'Černá věž a pozůstatky hradeb', 'Restaurace a kavárničky'],
        'lat' => 49.0545,
        'lng' => 13.7820
    ],
    [
        'id' => 'strakonice_hrad',
        'title' => 'Strakonický hrad a Věž Rumpál',
        'category' => 'okoli',
        'badge' => '22 km / Hrad',
        'distance' => '22 km',
        'time' => '20 min autem / vlakem',
        'image' => '/assets/img/hero.png',
        'description' => 'Rozsáhlý hradní areál johanitů na soutoku Otavy a Volyňky s věží Rumpál a Muzeem středního Pootaví (expozice dudáctví a motocyklů ČZ).',
        'highlights' => ['Hradní věž Rumpál s vyhlídkou', 'Slavná expozice dudáctví a motocyklů ČZ', 'Kapitula a hradní nádvoří'],
        'lat' => 49.2588,
        'lng' => 13.9015
    ],
    [
        'id' => 'strakonice_podskali',
        'title' => 'Naučná stezka Podskalí u Otavy (Strakonice)',
        'category' => 'okoli',
        'badge' => '22 km / Příroda',
        'distance' => '22 km',
        'time' => '20 min autem',
        'image' => '/assets/img/hero.png',
        'description' => 'Oblíbený lesopark a romantická přírodní stezka podél řeky Otavy ve Strakonicích. Vhodné na odpočinkovou procházku i běh.',
        'highlights' => ['Lesopark a stezka podél řeky Otavy', 'Dětská hřiště a stánky s občerstvením', 'Klidná oáza ve Strakonicích'],
        'lat' => 49.2620,
        'lng' => 13.8980
    ],
    [
        'id' => 'boubin_prales',
        'title' => 'Boubínský prales a Boubínské jezírko',
        'category' => 'okoli',
        'badge' => '18 km / Prales',
        'distance' => '18 km',
        'time' => 'Celodenní výlet',
        'image' => '/assets/img/map_boubin.png',
        'description' => 'Svatoznámý prales se staletými smrky a jedlemi, chráněný již od roku 1858. Romantické Boubínské jezírko vybudované r. 1836 pro plavení dřeva.',
        'highlights' => ['Chráněný prales starý přes 160 let', 'Romantické Boubínské jezírko', 'Naučná stezka okolo pralesa'],
        'lat' => 48.9772,
        'lng' => 13.8117
    ],
    [
        'id' => 'boubin_rozhledna',
        'title' => 'Rozhledna na vrcholu Boubína (1362 m n. m.)',
        'category' => 'okoli',
        'badge' => '18 km / Vrchol',
        'distance' => '18 km',
        'time' => 'Celodenní výlet',
        'image' => '/assets/img/map_boubin.png',
        'description' => 'Dřevěná rozhledna na páté nejvyšší hoře české části Šumavy (1362 m n. m.). Nádherný výhled na Šumavu a za jasného počasí až na Alpy.',
        'highlights' => ['Dřevěná rozhledna ve výšce 1362 m n. m.', 'Kruhový výhled na Šumavu a Alpy', 'Vrcholové výšlapy z Kubovy Huti či Kaplice'],
        'lat' => 48.9790,
        'lng' => 13.8150
    ],
    [
        'id' => 'sumava_autobusy',
        'title' => 'Šumava NP a Zelené autobusy z Vimperka',
        'category' => 'okoli',
        'badge' => 'NP Šumava',
        'distance' => 'Od 25 km',
        'time' => 'Dle tras',
        'image' => '/assets/img/vylety_hero.png',
        'description' => 'Během letní sezóny můžete z Vimperka využít ekologické Zelené autobusy NP Šumava (www.np.sumava.cz), které vás pohodlně vyvezou na šumavské hřebeny.',
        'highlights' => ['Ekologická doprava po hřebenech Šumavy', 'Spoje přímo z Vimperka', 'Informace na www.np.sumava.cz'],
        'lat' => 49.0530,
        'lng' => 13.7820
    ],
    [
        'id' => 'zalezly_budilov',
        'title' => 'Zálezly (Kamenec) a Budilov',
        'category' => 'okoli',
        'badge' => '8 km / Procházka',
        'distance' => '8 km',
        'time' => '10 min autem',
        'image' => '/assets/img/vylety_hero.png',
        'description' => 'Malebná trasa po šumavském podhůří ze Zálezel přes vrch Kamenec do Budilova. Klidná příroda bez davů turistů s kapličkami a výhledy.',
        'highlights' => ['Klidné šumavské podhůří', 'Trasa přes vrch Kamenec', 'Tradiční šumavské osady Zálezly a Budilov'],
        'lat' => 49.0950,
        'lng' => 13.8550
    ],
    [
        'id' => 'predgezdov_keltska',
        'title' => 'Keltská stezka Předgezdov (Předenice)',
        'category' => 'okoli',
        'badge' => '10 km / Historie',
        'distance' => '10 km',
        'time' => '12 min autem',
        'image' => '/assets/img/vylety_hero.png',
        'description' => 'Historická Keltská stezka v okolí Předgezdova a Předenic připomínající dávné keltské osídlení v údolí Volyňky.',
        'highlights' => ['Historické keltské lokality a hradiště', 'Příjemná naučná stezka v přírodě', 'Zajímavosti o dávné historii Šumavska'],
        'lat' => 49.1450,
        'lng' => 13.8750
    ],
    [
        'id' => 'lhova_muzeum',
        'title' => 'Zemědělské muzeum ve Lhově',
        'category' => 'okoli',
        'badge' => '12 km / Tradice',
        'distance' => '12 km',
        'time' => '14 min autem',
        'image' => '/assets/img/chov_hero.png',
        'description' => 'Expozice staré zemědělské techniky a náčiní ve Lhově (u Mladíkovic/Vacova). Ukázka venkovského života a práce našich předků.',
        'highlights' => ['Historické stroje a traktory', 'Ukázka tradičních venkovských řemesel', 'Zajímavá zastávka pro rodiny'],
        'lat' => 49.1350,
        'lng' => 13.7650
    ],

    // --- KOUPÁNÍ A WELLNESS ---
    [
        'id' => 'volyne_koupaliste',
        'title' => 'Retro koupaliště Volyně',
        'category' => 'koupanie',
        'badge' => '6 km / Koupaliště',
        'distance' => '6 km',
        'time' => '8 min autem',
        'image' => '/assets/img/trip_1786312326_151.jpg',
        'description' => 'Nejstarší dochované přírodní koupaliště v ČR z roku 1939. Nabízí neopakovatelnou prvorepublikovou atmosféru, dřevěné kabinky, čistou průtokovou vodu a stánek s občerstvením.',
        'highlights' => ['Nejstarší přírodní koupaliště v ČR (1939)', 'Prvorepublikové dřevěné kabinky', 'Čistá protékající přírodní voda'],
        'lat' => 49.1642,
        'lng' => 13.8872
    ],
    [
        'id' => 'rohanov',
        'title' => 'Přírodní koupaliště Rohanov',
        'category' => 'koupanie',
        'badge' => '18 km / Přírodní',
        'distance' => '18 km',
        'time' => '20 min autem',
        'image' => '/assets/img/hero.png',
        'description' => 'Koupaliště Lhota nad Rohanovem pod Šumavou. Průzračně čistá přírodní nádrž bez chemie, obklopená šumavskými lesy a čistým horským vzduchem.',
        'highlights' => ['Přírodní nádrž s čistou vodou bez chemie', 'Krásné šumavské prostředí u lesa', 'Dětské hřiště a kiosek'],
        'lat' => 49.1415,
        'lng' => 13.6820
    ],
    [
        'id' => 'strakonice_bazen_kryty',
        'title' => 'Krytý plavecký bazén Strakonice',
        'category' => 'koupanie',
        'badge' => '22 km / Bazén',
        'distance' => '22 km',
        'time' => '20 min autem',
        'image' => '/assets/img/room.png',
        'description' => 'Krytý plavecký bazén ve Strakonicích s 25m dráhami, dětským bazénkem, tobogánem a vířivkami pro celoroční plavání.',
        'highlights' => ['Plavecký 25m bazén a tobogán', 'Dětský bazének a vířivky', 'Celoroční provoz'],
        'lat' => 49.2550,
        'lng' => 13.8950
    ],
    [
        'id' => 'strakonice_koupaliste_letni',
        'title' => 'Venkovní letní koupaliště Strakonice',
        'category' => 'koupanie',
        'badge' => '22 km / Letní',
        'distance' => '22 km',
        'time' => '20 min autem',
        'image' => '/assets/img/room.png',
        'description' => 'Slunné venkovní letní koupaliště ve Strakonicích s velkým bazénem, tobogánem, travnatými plážemi a občerstvením.',
        'highlights' => ['Slunné travnaté pláže a velký bazén', 'Tobogán a dětské vodní atrakce', 'Stánky s občerstvením'],
        'lat' => 49.2555,
        'lng' => 13.8955
    ],
    [
        'id' => 'prachatice_bazen',
        'title' => 'Krytý plavecký bazén Prachatice',
        'category' => 'koupanie',
        'badge' => '25 km / Bazén',
        'distance' => '25 km',
        'time' => '25 min autem',
        'image' => '/assets/img/room.png',
        'description' => 'Moderní krytý bazén v Prachaticích s divokou řekou, vířivkami, tobogánem a dětským bazénkem.',
        'highlights' => ['Divoká řeka a vířivky', 'Plavecký bazén a tobogán', 'Příjemné rodinné prostředí'],
        'lat' => 49.0125,
        'lng' => 13.9980
    ],
    [
        'id' => 'prachatice_sauny',
        'title' => 'Saunový svět a Wellness Prachatice',
        'category' => 'koupanie',
        'badge' => '25 km / Sauny',
        'distance' => '25 km',
        'time' => '25 min autem',
        'image' => '/assets/img/room.png',
        'description' => 'Vyhlášený saunový svět v Prachaticích s finskou saunou, parní lázní, infrasaunou a ochlazovacím bazénkem.',
        'highlights' => ['Finská sauna, parní lázeň a infrasauna', 'Ochlazovací bazének a odpočívárna', 'Dokonalá relaxace i v zimě'],
        'lat' => 49.0128,
        'lng' => 13.9985
    ],
    [
        'id' => 'kristanovsky_rybnik',
        'title' => 'Křišťanovský rybník – Rašelinové koupání',
        'category' => 'koupanie',
        'badge' => '30 km / Rašelina',
        'distance' => '30 km',
        'time' => '30 min autem',
        'image' => '/assets/img/hero_statek.jpg',
        'description' => 'Přírodní rybník s léčivou rašelinovou vodou obklopený šumavskými lesy nedaleko Prachatic. Koupání s blahodárnými účinky na pokožku a klouby.',
        'highlights' => ['Léčivá rašelinová tmavá voda', 'Přírodní koupaliště v srdci přírody', 'Klidná lokalita bez davů'],
        'lat' => 48.9560,
        'lng' => 13.9680
    ],

    // --- LYŽOVÁNÍ A BĚŽKY ---
    [
        'id' => 'zadov',
        'title' => 'Ski areál Zadov',
        'category' => 'zima',
        'badge' => '32 km / Sjezdovky',
        'distance' => '32 km',
        'time' => '35 min autem',
        'image' => '/assets/img/hay_bales.png',
        'description' => 'Hlavní šumavské lyžařské středisko. Sedačkové lanovky, sjezdovky pro začátečníky i zkušené lyžaře, večerní lyžování a vyhlídka na skokanském můstku.',
        'highlights' => ['Sedačkové lanovky a večerní lyžování', 'Lyžařská škola a půjčovna vybavení', 'Vyhřívaná rozhledna na skokanském můstku'],
        'lat' => 49.0667,
        'lng' => 13.6333
    ],
    [
        'id' => 'kubovahut',
        'title' => 'Ski areál Kubova Huť',
        'category' => 'zima',
        'badge' => '26 km / Lyže a Vlak',
        'distance' => '26 km',
        'time' => '28 min autem / vlakem',
        'image' => '/assets/img/chov_hero.png',
        'description' => 'Příjemné sjezdové lyžování pod vrcholem Boubína v nejvýše položené železniční stanici v ČR (995 m n. m.). Vhodné pro rodiny s dětmi.',
        'highlights' => ['Nejvýše položené vlakové nádraží v ČR (995 m)', 'Rodinné sjezdovky a dětský vlek', 'Nástup na běžecké trasy pod Boubínem'],
        'lat' => 48.9833,
        'lng' => 13.7833
    ],
    [
        'id' => 'kvilda',
        'title' => 'Kvilda a Běžecká Bílá stopa',
        'category' => 'zima',
        'badge' => '38 km / Běžky',
        'distance' => '38 km',
        'time' => '40 min autem',
        'image' => '/assets/img/prodej_hero.png',
        'description' => 'Mekka šumavského běžeckého lyžování. Nástup na desítky kilometrů pravidelně upravovaných běžeckých okruhů Šumavské Bílé stopy (www.bilastopa.cz).',
        'highlights' => ['Pravidelně upravovaná Bílá stopa (bilastopa.cz)', 'Desítky km upravovaných hřebenových tras', 'Dětské sjezdové vleky na Kvildě'],
        'lat' => 49.0185,
        'lng' => 13.5802
    ],

    // --- GASTRO, HOSPŮDKY A NÁKUPY ---
    [
        'id' => 'coop_malenice',
        'title' => 'Jednota COOP 24/7 Malenice',
        'category' => 'gastro',
        'badge' => 'Nákupy 24/7',
        'distance' => '2 km od penzionu',
        'time' => '3 min autem / 20 min pěšky',
        'image' => '/assets/img/breakfast.png',
        'description' => 'Samoobslužná prodejna potravin s nepřetržitým provozem 24/7 (www.jednotavolyne.cz). Pomocí mobilní aplikace nebo bankovní identity nakoupíte čerstvé pečivo, potraviny a nápoje kdykoliv – i v noci.',
        'highlights' => ['Nákupy 24 hodin denně 7 dní v týdnu', 'Čerstvé pečivo, mléčné výrobky a nápoje', 'Pouhé 2 km od Penzionu Straňovice'],
        'lat' => 49.1285,
        'lng' => 13.8820
    ],
    [
        'id' => 'hospudka_namosti',
        'title' => 'Hospůdka Na Zámostí – Malenice',
        'category' => 'gastro',
        'badge' => 'Hospůdka / Pivo',
        'distance' => '2 km',
        'time' => '4 min autem / 25 min pěšky',
        'image' => '/assets/img/hero_statek.jpg',
        'description' => 'Oblíbená malenická hospůdka u řeky Volyňky. Nabízí skvěle ošetřené točené pivo, rychlé občerstvení a příjemnou venkovní terásku.',
        'highlights' => ['Točené pivo a chlazené nápoje', 'Teráska s venkovním posezením', 'Oblíbená zastávka místních i turistů'],
        'lat' => 49.1295,
        'lng' => 13.8840
    ],
    [
        'id' => 'malenicka_hospudka',
        'title' => 'Malenická hospůdka',
        'category' => 'gastro',
        'badge' => 'Tradiční hospoda',
        'distance' => '2 km',
        'time' => '4 min autem / 20 min pěšky',
        'image' => '/assets/img/breakfast.png',
        'description' => 'Klasický vesnický hostinec přímo v centru Malenic. Nabízí příjemné posezení, čepované pivo a tradiční pivní specialitky.',
        'highlights' => ['Příjemná vesnická atmosféra', 'Točené pivo a drobné občerstvení', 'V centru obci Malenice'],
        'lat' => 49.1288,
        'lng' => 13.8815
    ],
    [
        'id' => 'obcerstveni_pod_vencem',
        'title' => 'Kiosk Občerstvení Pod Věncem – Lčovice',
        'category' => 'gastro',
        'badge' => 'Cyklo / Kiosk',
        'distance' => '5 km',
        'time' => '7 min autem / cyklo',
        'image' => '/assets/img/vylety_hero.png',
        'description' => 'Populární cyklistický a turistický kiosk pod vrcholem Věnec u Lčovic podél řeky Volyňky. Klobásy z grilu, točené pivo, limo a posezení v přírodě.',
        'highlights' => ['Výborná zastávka při cyklovýletu', 'Grilované klobásky a točené pivo', 'Krásné prostředí u potoka a cyklostezky'],
        'lat' => 49.1170,
        'lng' => 13.8580
    ],
    [
        'id' => 'hospoda_na_hristi_ckyne',
        'title' => 'Hospoda Na Hřišti – Čkyně',
        'category' => 'gastro',
        'badge' => '4 km / Hospoda',
        'distance' => '4 km',
        'time' => '6 min autem / 15 min vlakem',
        'image' => '/assets/img/breakfast.png',
        'description' => 'Příjemná vesnická hospoda u hřiště ve Čkyni s točeným pivem, venkovním posezením na terase a přátelskou atmosférou.',
        'highlights' => ['Točené pivo a chlazené nápoje', 'Prostranná venkovní terasa', 'Pouhé 4 km od penzionu'],
        'lat' => 49.1105,
        'lng' => 13.8315
    ],
    [
        'id' => 'restaurace_votavka_ckyne',
        'title' => 'Restaurace Votavka – Čkyně',
        'category' => 'gastro',
        'badge' => '4 km / Restaurace',
        'distance' => '4 km',
        'time' => '6 min autem / 15 min vlakem',
        'image' => '/assets/img/breakfast.png',
        'description' => 'Tradiční česká restaurace ve Čkyni známá poctivou kuchyní, denním menu, minutkami a příjemnou obsluhou.',
        'highlights' => ['Tradiční česká kuchyně a hotovky', 'Příjemné prostředí s obsluhou', 'V centru obce Čkyně'],
        'lat' => 49.1120,
        'lng' => 13.8325
    ],
    [
        'id' => 'kavarna_lucie_ckyne',
        'title' => 'Bufet a Kavárna LUCIE – Čkyně',
        'category' => 'gastro',
        'badge' => '4 km / Kavárna',
        'distance' => '4 km',
        'time' => '6 min autem / 15 min vlakem',
        'image' => '/assets/img/breakfast.png',
        'description' => 'Útulný bufet a kavárna ve Čkyni na lahodnou kávu, čerstvé domáci zákusky, zmrzlinu a rychlé teplé i studené občerstvení.',
        'highlights' => ['Výborná káva a domáci zákusky', 'Svěží zmrzlina a rychlé občerstvení', 'Příjemné posezení ve Čkyni'],
        'lat' => 49.1115,
        'lng' => 13.8310
    ],
    [
        'id' => 'restaurace_u_postu_volyne',
        'title' => 'Restaurace U Poštů – Volyně',
        'category' => 'gastro',
        'badge' => '6 km / Vyhlášená',
        'distance' => '6 km',
        'time' => '8 min autem / 10 min vlakem',
        'image' => '/assets/img/breakfast.png',
        'description' => 'Vyhlášená rodinná restaurace ve Volyni s poctivou českou kuchyní, výbornými steaky, denním menu a přátelskou obsluhou.',
        'highlights' => ['Poctivá česká kuchyně a denní menu', 'Vyhlášená restaurace v regionu', 'Široký výběr jídel a nápojů'],
        'lat' => 49.1650,
        'lng' => 13.8865
    ],
    [
        'id' => 'hostinec_pod_radnici_volyne',
        'title' => 'Hostinec Pod Radnicí – Volyně',
        'category' => 'gastro',
        'badge' => '6 km / Náměstí',
        'distance' => '6 km',
        'time' => '8 min autem',
        'image' => '/assets/img/hero_statek.jpg',
        'description' => 'Tradiční hostinec přímo na historickém náměstí ve Volyni pod starobylou radnicí. Točené pivo a česká klasika.',
        'highlights' => ['Přímo na náměstí ve Volyni', 'Točené pivo a tradiční kuchyně', 'Historické prostředí u radnice'],
        'lat' => 49.1662,
        'lng' => 13.8858
    ],
    [
        'id' => 'pivnice_fefik_volyne',
        'title' => 'Pivnice Fefík – Volyně',
        'category' => 'gastro',
        'badge' => '6 km / Pivnice',
        'distance' => '6 km',
        'time' => '8 min autem',
        'image' => '/assets/img/breakfast.png',
        'description' => 'Oblíbená volyňská pivnice s výborně ošetřeným pivem, chladným občerstvením a přátelskou šumavskou atmosférou.',
        'highlights' => ['Skvěle ošetřené točené pivo', 'Klasická pivní atmosféra', 'Oblíbené místo místních štamgastů'],
        'lat' => 49.1645,
        'lng' => 13.8870
    ],
    [
        'id' => 'hospudka_na_nove_volyne',
        'title' => 'Hospůdka Na Nové – Volyně',
        'category' => 'gastro',
        'badge' => '6 km / Hospůdka',
        'distance' => '6 km',
        'time' => '8 min autem',
        'image' => '/assets/img/breakfast.png',
        'description' => 'Příjemná hospůdka ve Volyni s točeným pivem, venkovní teráskou a poctivým pivním občerstvením po výletě.',
        'highlights' => ['Točené pivo a chuťovky k pivu', 'Venkovní teráska s posezením', 'Klidná lokalita ve Volyni'],
        'lat' => 49.1670,
        'lng' => 13.8845
    ],
    [
        'id' => 'pivovar_vimperk',
        'title' => 'Zámecký minipivovar Vimperk',
        'category' => 'gastro',
        'badge' => '12 km / Minipivovar',
        'distance' => '12 km',
        'time' => '15 min autem',
        'image' => '/assets/img/breakfast.png',
        'description' => 'Řemeslný pivovar u zámku Vimperk s vlastními nefiltrovanými pivy a výbornou poctivou gastronomií.',
        'highlights' => ['Vlastní řemeslná nefiltrovaná piva', 'Výborná poctivá kuchyně', 'Krásné prostředí u zámku Vimperk'],
        'lat' => 49.0538,
        'lng' => 13.7820
    ],
    [
        'id' => 'vimperk_markety',
        'title' => 'Supermarkety a Nákupy Vimperk',
        'category' => 'gastro',
        'badge' => '12 km / Nákupy',
        'distance' => '12 km',
        'time' => '15 min autem',
        'image' => '/assets/img/breakfast.png',
        'description' => 'Pro větší nákupy potravin a zboží jsou ve Vimperku k dispozici supermarkety Penny, Billa a Tesco.',
        'highlights' => ['Supermarkety Penny, Billa a Tesco', 'Kompletní nákupní sortiment', 'Pouhých 15 minut autem'],
        'lat' => 49.0560,
        'lng' => 13.7840
    ],
    [
        'id' => 'hostinec_u_jiskru',
        'title' => 'Šumavský hostinec U Jiskrů – Kbelnice',
        'category' => 'gastro',
        'badge' => '20 km / Zájezdní hostinec',
        'distance' => '20 km',
        'time' => '18 min autem',
        'image' => '/assets/img/breakfast.png',
        'description' => 'Vyhlášený zájezdní hostinec šéfkuchaře Martina Jiskry v Kbelnici u Strakonic. Tradiční české recepty v nejvyšší kvalitě z lokálních surovin.',
        'highlights' => ['Vyhlášená gastronomie Martina Jiskry', 'Tradiční české recepty z lokálních surovin', 'Prvotřídní gurmánský zážitek'],
        'lat' => 49.2780,
        'lng' => 13.9280
    ],
    [
        'id' => 'sul_a_repa_strakonice',
        'title' => 'Restaurace Sůl a Řepa – Strakonice',
        'category' => 'gastro',
        'badge' => '22 km / Špičková gastronomie',
        'distance' => '22 km',
        'time' => '20 min autem',
        'image' => '/assets/img/breakfast.png',
        'description' => 'Moderní a vyhlášená restaurace ve Strakonicích zaměřená na sezónní lokální farmářské suroviny a moderní pojetí české gastronomie.',
        'highlights' => ['Moderní pohled na českou kuchyni', 'Sezónní a lokální farmářské suroviny', 'Ocenění v gastro průvodcích'],
        'lat' => 49.2615,
        'lng' => 13.9018
    ],
    [
        'id' => 'hostinec_sokolovna_strakonice',
        'title' => 'Hostinec Sokolovna – Strakonice',
        'category' => 'gastro',
        'badge' => '22 km / Tradiční',
        'distance' => '22 km',
        'time' => '20 min autem',
        'image' => '/assets/img/breakfast.png',
        'description' => 'Tradiční strakonická restaurace v budově Sokolovny s poctivou českou kuchyní, denním menu a čepovaným pivem.',
        'highlights' => ['Poctivá česká kuchyně a hotovky', 'Příjemné prostorné sály', 'Tradiční hospodské prostředí'],
        'lat' => 49.2600,
        'lng' => 13.9010
    ],
    [
        'id' => 'restaurace_zamecka_basta',
        'title' => 'Restaurace Zámecká bašta – Strakonice',
        'category' => 'gastro',
        'badge' => '22 km / U hradu',
        'distance' => '22 km',
        'time' => '20 min autem',
        'image' => '/assets/img/breakfast.png',
        'description' => 'Stylová restaurace v bezprostřední blízkosti strakonického hradu s příjemným posezením a bohatou nabídkou jídel.',
        'highlights' => ['Přímo u strakonického hradu', 'Stylový interiér i venkovní teráska', 'Příjemná obsluha a výborné jídlo'],
        'lat' => 49.2590,
        'lng' => 13.9025
    ],
    [
        'id' => 'restaurace_u_mesta_prahy',
        'title' => 'Restaurace U Města Prahy – Strakonice',
        'category' => 'gastro',
        'badge' => '22 km / Náměstí',
        'distance' => '22 km',
        'time' => '20 min autem',
        'image' => '/assets/img/breakfast.png',
        'description' => 'Tradiční restaurace v centru Strakonic nabízející české i mezinárodní speciality a čepované pivo.',
        'highlights' => ['V centru Strakonic', 'Poctivé české minuty a hotovky', 'Výborně ošetřené pivo'],
        'lat' => 49.2612,
        'lng' => 13.9022
    ],
    [
        'id' => 'restaurace_na_splavku',
        'title' => 'Restaurace Na Splávku – Strakonice',
        'category' => 'gastro',
        'badge' => '22 km / U řeky',
        'distance' => '22 km',
        'time' => '20 min autem',
        'image' => '/assets/img/breakfast.png',
        'description' => 'Oblíbená restaurace a pivnice u řeky Otavy ve Strakonicích s venkovní terasou a občerstvením.',
        'highlights' => ['Krásné prostředí u řeky Otavy', 'Venkovní terasa pro letní posezení', 'Točené pivo a minutková kuchyně'],
        'lat' => 49.2630,
        'lng' => 13.8990
    ],
    [
        'id' => 'pivovar_strakonice',
        'title' => 'Strakonický pivovar Nektar a Krabák',
        'category' => 'gastro',
        'badge' => '22 km / Pivovar',
        'distance' => '22 km',
        'time' => '20 min autem',
        'image' => '/assets/img/breakfast.png',
        'description' => 'Tradiční strakonický měšťanský pivovar s více než 370 lety historie. Ochutnejte pivní speciály Dudák i Krabák a navštivte pivovarskou pivnici.',
        'highlights' => ['Tradiční strakonické pivo Dudák a Krabák', 'Více než 370 let tradice vaření piva', 'Pivovarská prodejna a pivnice'],
        'lat' => 49.2602,
        'lng' => 13.9035
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
        padding: 0.75rem 1.5rem;
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
    .filter-btn:hover {
        border-color: var(--primary, #2d5a27);
        color: var(--primary, #2d5a27);
        transform: translateY(-2px);
    }
    .filter-btn.active {
        background: var(--primary, #2d5a27);
        color: #ffffff;
        border-color: var(--primary, #2d5a27);
        box-shadow: 0 4px 12px rgba(45, 90, 39, 0.25);
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
        <h2 class="hero-subtitle fadeIn">Objevujte krásy jižních Čech a Šumavy</h2>
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
                Penzion a statek ve Straňovicích je skvělým výchozím bodem pro pěší túry, cyklovýlety, lyžování, wellness i gurmánské zážitky. Vyberte si kategorii a naplánujte si perfektní den.
            </p>

            <!-- Filter Buttons -->
            <div class="trip-filters-wrapper">
                <button class="filter-btn active" data-filter="all">
                    <i data-lucide="grid"></i> Všechny tipy (<?= count($trips) ?>)
                </button>
                <button class="filter-btn" data-filter="okoli">
                    <i data-lucide="compass"></i> Okolí a Památky
                </button>
                <button class="filter-btn" data-filter="koupanie">
                    <i data-lucide="waves"></i> Koupání a Wellness
                </button>
                <button class="filter-btn" data-filter="zima">
                    <i data-lucide="snowflake"></i> Lyžování a Běžky
                </button>
                <button class="filter-btn" data-filter="gastro">
                    <i data-lucide="utensils"></i> Gastro a Nákupy
                </button>
            </div>
        </div>

        <!-- Trip Grid -->
        <div class="trip-grid" id="tripGrid">
            <?php foreach ($trips as $trip): 
                $gmapsUrl = 'https://www.google.com/maps/dir/?api=1&destination=' . urlencode($trip['lat'] . ',' . $trip['lng']);
                $imgSrc = (strpos($trip['image'], '/') === 0 || strpos($trip['image'], 'http') === 0) ? $trip['image'] : '/' . $trip['image'];
            ?>
            <div class="trip-card" data-category="<?= htmlspecialchars($trip['category']) ?>">
                <div class="trip-img-wrapper">
                    <img src="<?= htmlspecialchars($imgSrc) ?>" alt="<?= htmlspecialchars($trip['title']) ?>" class="trip-img">
                    <span class="trip-badge"><?= htmlspecialchars($trip['badge']) ?></span>
                </div>
                <div class="trip-content">
                    <div class="trip-meta">
                        <span><i data-lucide="map-pin"></i> <?= htmlspecialchars($trip['distance']) ?></span>
                        <span><i data-lucide="clock"></i> <?= htmlspecialchars($trip['time']) ?></span>
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
                <span class="distance-val">6 km</span>
                <span class="distance-label">Volyně</span>
            </div>
            <div class="distance-item">
                <span class="distance-val">12 km</span>
                <span class="distance-label">Vimperk</span>
            </div>
            <div class="distance-item">
                <span class="distance-val">22 km</span>
                <span class="distance-label">Strakonice</span>
            </div>
            <div class="distance-item">
                <span class="distance-val">25 km</span>
                <span class="distance-label">Kašperk a NP Šumava</span>
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
                Na recepci penzionu Straňovice Vám rádi zapůjčíme tištěné turistické a cyklistické mapy, doporučíme aktuální trasu nebo poradíme, kam zajít na nejlepší oběd.
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
                    const cardCategory = card.getAttribute('data-category');
                    if (filterValue === 'all' || cardCategory === filterValue) {
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