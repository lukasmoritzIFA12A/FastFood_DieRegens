<?php

require_once __DIR__ . '/vendor/autoload.php';

use App\datenbank\Entitaeten\Admin;
use App\datenbank\Entitaeten\Adresse;
use App\datenbank\Entitaeten\Bestellstatus;
use App\datenbank\Entitaeten\Bild;
use App\datenbank\Entitaeten\Energiewert;
use App\datenbank\Entitaeten\Kunde;
use App\datenbank\Entitaeten\Login;
use App\datenbank\Entitaeten\Menue;
use App\datenbank\Entitaeten\Produkt;
use App\datenbank\Entitaeten\Rabatt;
use App\datenbank\Entitaeten\Zahlungsart;
use App\datenbank\Entitaeten\Zutat;
use App\datenbank\EntityManagerFactory;
use App\datenbank\Repositories\AdminRepository;
use App\datenbank\Repositories\BestellstatusRepository;
use App\datenbank\Repositories\KundeRepository;
use App\datenbank\Repositories\LoginRepository;
use App\datenbank\Repositories\MenueRepository;
use App\datenbank\Repositories\RabattRepository;
use App\datenbank\Repositories\ZahlungsartRepository;
use App\datenbank\Repositories\ZutatRepository;
use App\validation\PasswortHash;
use Doctrine\Common\Collections\ArrayCollection;

try {
    set_error_handler(function ($severity, $message, $file, $line) {
        throw new ErrorException($message, 0, $severity, $file, $line);
    });

    $entityManagerFactory = new EntityManagerFactory();
    $entityManager = $entityManagerFactory->createEntityManager();

    EntityManagerFactory::dropSchema($entityManager);
    echo "Momentanes Datenbank Schema wurde gelöscht...\n";

    EntityManagerFactory::updateSchema($entityManager);
    echo "Momentanes Datenbank Schema wurde aufgesetzt...\n";

    /*
     * Zahlungsarten hinzufügen
     */
    $zahlungsartGooglePay = new Zahlungsart();
    $zahlungsartGooglePay->setArt("Google Pay");
    $zahlungsartGooglePay->setBild(new Bild(file_get_contents("assets/sample/payment/google-pay.png")));

    $zahlungsartKlarna = new Zahlungsart();
    $zahlungsartKlarna->setArt("Klarna");
    $zahlungsartKlarna->setBild(new Bild(file_get_contents("assets/sample/payment/klarna.png")));

    $zahlungsartMastercard = new Zahlungsart();
    $zahlungsartMastercard->setArt("Mastercard");
    $zahlungsartMastercard->setBild(new Bild(file_get_contents("assets/sample/payment/mastercard.png")));

    $zahlungsartPayPal = new Zahlungsart();
    $zahlungsartPayPal->setArt("PayPal");
    $zahlungsartPayPal->setBild(new Bild(file_get_contents("assets/sample/payment/paypal.png")));

    $zahlungsartVisa = new Zahlungsart();
    $zahlungsartVisa->setArt("Visa");
    $zahlungsartVisa->setBild(new Bild(file_get_contents("assets/sample/payment/visa.png")));

    $zahlungsartRepository = new ZahlungsartRepository($entityManager);
    $zahlungsartRepository->save($zahlungsartGooglePay);
    $zahlungsartRepository->save($zahlungsartKlarna);
    $zahlungsartRepository->save($zahlungsartMastercard);
    $zahlungsartRepository->save($zahlungsartPayPal);
    $zahlungsartRepository->save($zahlungsartVisa);

    echo "Zahlungsarten wurden hinzugefügt...\n";

    /*
     * Zutaten hinzufügen
     */
    $zutatRepository = new ZutatRepository($entityManager);
    $zutatRepository->save($zutatVollkornbroetchen = new Zutat("Vollkornbrötchen"));
    $zutatRepository->save($zutatRindfleisch = new Zutat("Rindfleisch"));
    $zutatRepository->save($zutatCheddar = new Zutat("Cheddar"));
    $zutatRepository->save($zutatTomate = new Zutat("Tomate"));
    $zutatRepository->save($zutatSalat = new Zutat("Salat"));
    $zutatRepository->save($zutatHaehnchen = new Zutat("Hähnchen"));
    $zutatRepository->save($zutatJoghurtDressing = new Zutat("Joghurt-Dressing"));
    $zutatRepository->save($zutatBackfisch = new Zutat("Backfisch"));
    $zutatRepository->save($zutatRemoulade = new Zutat("Remoulade"));
    $zutatRepository->save($zutatRucola = new Zutat("Rucola"));
    $zutatRepository->save($zutatGemuesePatty = new Zutat("Gemüse-Patty"));
    $zutatRepository->save($zutatGouda = new Zutat("Gouda"));
    $zutatRepository->save($zutatSenfsosse = new Zutat("Senfsoße"));
    $zutatRepository->save($zutatKartoffeln = new Zutat("Kartoffeln"));
    $zutatRepository->save($zutatSonnenblumenoel = new Zutat("Sonnenblumenöl"));
    $zutatRepository->save($zutatSalz = new Zutat("Salz"));
    $zutatRepository->save($zutatOlivenoel = new Zutat("Olivenöl"));
    $zutatRepository->save($zutatPaprika = new Zutat("Paprika"));
    $zutatRepository->save($zutatPfeffer = new Zutat("Pfeffer"));
    $zutatRepository->save($zutatMais = new Zutat("Mais"));
    $zutatRepository->save($zutatButter = new Zutat("Butter"));
    $zutatRepository->save($zutatBlattsalat = new Zutat("Blattsalat"));
    $zutatRepository->save($zutatGurke = new Zutat("Gurke"));
    $zutatRepository->save($zutatEssigOelDressing = new Zutat("Essig-Öl-Dressing"));
    $zutatRepository->save($zutatKarotten = new Zutat("Karotten"));
    $zutatRepository->save($zutatNaturreis = new Zutat("Naturreis"));
    $zutatRepository->save($zutatBrokkoli = new Zutat("Brokkoli"));
    $zutatRepository->save($zutatVollkornspaghetti = new Zutat("Vollkornspaghetti"));
    $zutatRepository->save($zutatBasilikum = new Zutat("Basilikum"));
    $zutatRepository->save($zutatKnoblauch = new Zutat("Knoblauch"));
    $zutatRepository->save($zutatVollkornTortilla = new Zutat("Vollkorn-Tortilla"));
    $zutatRepository->save($zutatBanane = new Zutat("Banane"));
    $zutatRepository->save($zutatErdbeere = new Zutat("Erdbeere"));
    $zutatRepository->save($zutatNaturjoghurt = new Zutat("Naturjoghurt"));
    $zutatRepository->save($zutatHonig = new Zutat("Honig"));
    $zutatRepository->save($zutatWasser = new Zutat("Wasser"));
    $zutatRepository->save($zutatFruchtsaft = new Zutat("Fruchtsaft"));
    $zutatRepository->save($zutatMineralwasser = new Zutat("Mineralwasser"));
    $zutatRepository->save($zutatMandeln = new Zutat("Mandeln"));
    $zutatRepository->save($zutatWalnuesse = new Zutat("Walnüsse"));
    $zutatRepository->save($zutatHaferflocken = new Zutat("Haferflocken"));
    $zutatRepository->save($zutatApfel = new Zutat("Apfel"));
    $zutatRepository->save($zutatAnanas = new Zutat("Ananas"));
    $zutatRepository->save($zutatMelone = new Zutat("Melone"));
    $zutatRepository->save($zutatTrauben = new Zutat("Trauben"));
    $zutatRepository->save($zutatBeeren = new Zutat("Beeren"));
    $zutatRepository->save($zutatSchwarzerTee = new Zutat("Schwarzer Tee"));
    $zutatRepository->save($zutatZitronensaft = new Zutat("Zitronensaft"));
    $zutatRepository->save($zutatMinze = new Zutat("Minze"));
    $zutatRepository->save($zutatMilch = new Zutat("Milch"));
    $zutatRepository->save($zutatProteinpulver = new Zutat("Proteinpulver"));
    $zutatRepository->save($zutatBanane = new Zutat("Banane"));
    $zutatRepository->save($zutatKakaopulver = new Zutat("Kakaopulver"));
    $zutatRepository->save($zutatKaffeebohnen = new Zutat("Kaffeebohnen"));
    $zutatRepository->save($zutatEier = new Zutat("Eier"));
    $zutatRepository->save($zutatKraeuter = new Zutat("Kräuter"));

    echo "Zutaten wurden hinzugefügt...\n";

    /*
     * Rabatte hinzufügen
     */
    $rabattNeu = new Rabatt();
    $rabattNeu->setCode("Neu");
    $rabattNeu->setMinderung("10");

    $rabatt2025 = new Rabatt();
    $rabatt2025->setCode("2025");
    $rabatt2025->setMinderung("25");

    $rabattMacApple = new Rabatt();
    $rabattMacApple->setCode("MacAPPLE");
    $rabattMacApple->setMinderung("50");

    $rabattRepository = new RabattRepository($entityManager);
    $rabattRepository->save($rabattNeu);
    $rabattRepository->save($rabatt2025);
    $rabattRepository->save($rabattMacApple);

    echo "Rabatte wurden hinzugefügt...\n";

    /*
     * Menüs mit deren Produkten hinzufügen
     */

    //Menü 1
    $menueClassicChicken = new Menue();
    $menueClassicChicken->setTitel("Classic Chicken Menü");
    $menueClassicChicken->setBeschreibung("Perfekte Wahl für Hähnchen-Liebhaber: Gegrillt, leicht und voller Geschmack!");
    $menueClassicChicken->setPreis("9.50");
    $menueClassicChicken->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Classic Chicken Menü.jpg")));

    $produktGegrilltesHaehnchenSandwich = new Produkt();
    $produktGegrilltesHaehnchenSandwich->setTitel("Gegrilltes Hähnchen-Sandwich");
    $produktGegrilltesHaehnchenSandwich->setBeschreibung("Saftige Hähnchenbrust in einem Vollkornbrötchen mit knackigem Salat und leichter Joghurt-Soße.");
    $produktGegrilltesHaehnchenSandwich->setPreis("4.80");
    $produktGegrilltesHaehnchenSandwich->setZutat(new ArrayCollection([
        $zutatVollkornbroetchen, $zutatHaehnchen, $zutatJoghurtDressing, $zutatSalat, $zutatTomate
    ]));
    $energiewertGegrilltesHaehnchenSandwich = new Energiewert();
    $energiewertGegrilltesHaehnchenSandwich->setPortionSize("170g");
    $energiewertGegrilltesHaehnchenSandwich->setKalorien("420");
    $energiewertGegrilltesHaehnchenSandwich->setFett("12");
    $energiewertGegrilltesHaehnchenSandwich->setKohlenhydrate("38");
    $energiewertGegrilltesHaehnchenSandwich->setZucker("5");
    $energiewertGegrilltesHaehnchenSandwich->setEiweiss("32");
    $produktGegrilltesHaehnchenSandwich->setEnergiewert($energiewertGegrilltesHaehnchenSandwich);
    $produktGegrilltesHaehnchenSandwich->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Gegrilltest Hähnchen-Sandwich.jpg")));
    $produktGegrilltesHaehnchenSandwich->setAusverkauft(false);

    $produktKartoffelWedges = new Produkt();
    $produktKartoffelWedges->setTitel("Kartoffel-Wedges");
    $produktKartoffelWedges->setBeschreibung("Knusprige, goldbraun gebackene Kartoffelecken mit wenig Öl.");
    $produktKartoffelWedges->setPreis("3.00");
    $produktKartoffelWedges->setZutat(new ArrayCollection([
        $zutatKartoffeln, $zutatOlivenoel, $zutatPaprika, $zutatSalz, $zutatPfeffer
    ]));
    $energiewertKartoffelWedges = new Energiewert();
    $energiewertKartoffelWedges->setPortionSize("150g");
    $energiewertKartoffelWedges->setKalorien("340");
    $energiewertKartoffelWedges->setFett("12");
    $energiewertKartoffelWedges->setKohlenhydrate("48");
    $energiewertKartoffelWedges->setZucker("1");
    $energiewertKartoffelWedges->setEiweiss("6");
    $produktKartoffelWedges->setEnergiewert($energiewertKartoffelWedges);
    $produktKartoffelWedges->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Kartoffel-Wedges.jpg")));
    $produktKartoffelWedges->setAusverkauft(false);

    $produktEistee = new Produkt();
    $produktEistee->setTitel("Eistee");
    $produktEistee->setBeschreibung("Frisch und ohne Zucker, perfekt zum Durstlöschen.");
    $produktEistee->setPreis("2.50");
    $produktEistee->setZutat(new ArrayCollection([
        $zutatSchwarzerTee, $zutatZitronensaft, $zutatMinze, $zutatWasser
    ]));
    $energiewertEistee = new Energiewert();
    $energiewertEistee->setPortionSize("300ml");
    $energiewertEistee->setKalorien("5");
    $energiewertEistee->setFett("0");
    $energiewertEistee->setKohlenhydrate("1");
    $energiewertEistee->setZucker("0");
    $energiewertEistee->setEiweiss("0");
    $produktEistee->setEnergiewert($energiewertEistee);
    $produktEistee->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Eistee.jpg")));
    $produktEistee->setAusverkauft(false);

    $menueClassicChicken->setProdukte(new ArrayCollection([
        $produktGegrilltesHaehnchenSandwich, $produktKartoffelWedges, $produktEistee
    ]));

    //Menü 2
    $menueCheeseburgerLight = new Menue();
    $menueCheeseburgerLight->setTitel("Cheeseburger Light Menü");
    $menueCheeseburgerLight->setBeschreibung("Ein echter Burger-Klassiker – mit weniger Fett & mehr Geschmack!");
    $menueCheeseburgerLight->setPreis("8.80");
    $menueCheeseburgerLight->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Cheeseburger Light Menü.jpg")));

    $produktVollkornCheeseburger = new Produkt();
    $produktVollkornCheeseburger->setTitel("Vollkorn-Cheeseburger");
    $produktVollkornCheeseburger->setBeschreibung("Rinderpatty aus magerem Fleisch, dazu Cheddar, Tomate, Salat und Senf-Ketchup-Soße im Vollkornbrötchen.");
    $produktVollkornCheeseburger->setPreis("4.50");
    $produktVollkornCheeseburger->setZutat(new ArrayCollection([
        $zutatVollkornbroetchen, $zutatRindfleisch, $zutatCheddar, $zutatTomate, $zutatSalat
    ]));
    $energiewertVollkornCheeseburger = new Energiewert();
    $energiewertVollkornCheeseburger->setPortionSize("180g");
    $energiewertVollkornCheeseburger->setKalorien("450");
    $energiewertVollkornCheeseburger->setFett("18");
    $energiewertVollkornCheeseburger->setKohlenhydrate("40");
    $energiewertVollkornCheeseburger->setZucker("6");
    $energiewertVollkornCheeseburger->setEiweiss("28");
    $produktVollkornCheeseburger->setEnergiewert($energiewertVollkornCheeseburger);
    $produktVollkornCheeseburger->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Vollkorn-Cheeseburger.jpg")));
    $produktVollkornCheeseburger->setAusverkauft(false);

    $produktKleinePortionPommes = new Produkt();
    $produktKleinePortionPommes->setTitel("Kleine Portion Pommes");
    $produktKleinePortionPommes->setBeschreibung("Leicht gesalzen, knusprig und nicht in Fett ertränkt.");
    $produktKleinePortionPommes->setPreis("2.50");
    $produktKleinePortionPommes->setZutat(new ArrayCollection([
        $zutatKartoffeln, $zutatSonnenblumenoel, $zutatSalz
    ]));
    $energiewertKleinePortionPommes = new Energiewert();
    $energiewertKleinePortionPommes->setPortionSize("150g");
    $energiewertKleinePortionPommes->setKalorien("320");
    $energiewertKleinePortionPommes->setFett("10");
    $energiewertKleinePortionPommes->setKohlenhydrate("50");
    $energiewertKleinePortionPommes->setZucker("0");
    $energiewertKleinePortionPommes->setEiweiss("5");
    $produktKleinePortionPommes->setEnergiewert($energiewertKleinePortionPommes);
    $produktKleinePortionPommes->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Kleine Portion Pommes.jpg")));
    $produktKleinePortionPommes->setAusverkauft(false);

    $produktApfelschorle = new Produkt();
    $produktApfelschorle->setTitel("Apfelschorle");
    $produktApfelschorle->setBeschreibung("Fruchtig-frisch mit 50 % Saftanteil und ohne künstlichen Zucker.");
    $produktApfelschorle->setPreis("3.00");
    $produktApfelschorle->setZutat(new ArrayCollection([
        $zutatFruchtsaft, $zutatMineralwasser
    ]));
    $energiewertApfelschorle = new Energiewert();
    $energiewertApfelschorle->setPortionSize("300ml");
    $energiewertApfelschorle->setKalorien("90");
    $energiewertApfelschorle->setFett("0");
    $energiewertApfelschorle->setKohlenhydrate("22");
    $energiewertApfelschorle->setZucker("18");
    $energiewertApfelschorle->setEiweiss("0");
    $produktApfelschorle->setEnergiewert($energiewertApfelschorle);
    $produktApfelschorle->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Apfelschorle.jpg")));
    $produktApfelschorle->setAusverkauft(false);

    $menueCheeseburgerLight->setProdukte(new ArrayCollection([
        $produktVollkornCheeseburger, $produktKleinePortionPommes, $produktApfelschorle
    ]));

    //Menü 3
    $menueVeggie = new Menue();
    $menueVeggie->setTitel("Veggie Menü");
    $menueVeggie->setBeschreibung("Frische Zutaten für ein rundum gesundes, leckeres Geschmackserlebnis!");
    $menueVeggie->setPreis("9.20");
    $menueVeggie->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Veggie Menü.jpg")));

    $produktGemueseBurgerMitKaese = new Produkt();
    $produktGemueseBurgerMitKaese->setTitel("Gemüse-Burger mit Käse");
    $produktGemueseBurgerMitKaese->setBeschreibung("Herzhaftes Gemüse-Patty mit Gouda, knackigem Salat und cremiger Avocado-Soße.");
    $produktGemueseBurgerMitKaese->setPreis("4.50");
    $produktGemueseBurgerMitKaese->setZutat(new ArrayCollection([
        $zutatVollkornbroetchen, $zutatGemuesePatty, $zutatGouda, $zutatSalat, $zutatSenfsosse
    ]));
    $energiewertGemueseBurgerMitKaese = new Energiewert();
    $energiewertGemueseBurgerMitKaese->setPortionSize("180g");
    $energiewertGemueseBurgerMitKaese->setKalorien("410");
    $energiewertGemueseBurgerMitKaese->setFett("14");
    $energiewertGemueseBurgerMitKaese->setKohlenhydrate("45");
    $energiewertGemueseBurgerMitKaese->setZucker("7");
    $energiewertGemueseBurgerMitKaese->setEiweiss("18");
    $produktGemueseBurgerMitKaese->setEnergiewert($energiewertGemueseBurgerMitKaese);
    $produktGemueseBurgerMitKaese->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Gemüse-Burger mit Käse.jpg")));
    $produktGemueseBurgerMitKaese->setAusverkauft(false);

    $produktBeilagensalat = new Produkt();
    $produktBeilagensalat->setTitel("Beilagensalat");
    $produktBeilagensalat->setBeschreibung("Frische Gurken, Tomaten, Blattsalat mit Essig-Öl-Dressing.");
    $produktBeilagensalat->setPreis("3.50");
    $produktBeilagensalat->setZutat(new ArrayCollection([
        $zutatBlattsalat, $zutatGurke, $zutatTomate, $zutatEssigOelDressing, $zutatKarotten
    ]));
    $energiewertBeilagensalat = new Energiewert();
    $energiewertBeilagensalat->setPortionSize("120g");
    $energiewertBeilagensalat->setKalorien("80");
    $energiewertBeilagensalat->setFett("5");
    $energiewertBeilagensalat->setKohlenhydrate("6");
    $energiewertBeilagensalat->setZucker("4");
    $energiewertBeilagensalat->setEiweiss("3");
    $produktBeilagensalat->setEnergiewert($energiewertBeilagensalat);
    $produktBeilagensalat->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Beilagensalat.jpg")));
    $produktBeilagensalat->setAusverkauft(false);

    $produktFrischerOrangensaft = new Produkt();
    $produktFrischerOrangensaft->setTitel("Frischer Orangensaft");
    $produktFrischerOrangensaft->setBeschreibung("Direkt gepresst, ohne Zuckerzusätze.");
    $produktFrischerOrangensaft->setPreis("3.00");
    $produktFrischerOrangensaft->setZutat(new ArrayCollection([
        $zutatFruchtsaft, $zutatMineralwasser
    ]));
    $energiewertFrischerOrangensaft = new Energiewert();
    $energiewertFrischerOrangensaft->setPortionSize("300ml");
    $energiewertFrischerOrangensaft->setKalorien("90");
    $energiewertFrischerOrangensaft->setFett("0");
    $energiewertFrischerOrangensaft->setKohlenhydrate("22");
    $energiewertFrischerOrangensaft->setZucker("18");
    $energiewertFrischerOrangensaft->setEiweiss("0");
    $produktFrischerOrangensaft->setEnergiewert($energiewertFrischerOrangensaft);
    $produktFrischerOrangensaft->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Frischer Orangensaft.jpg")));
    $produktFrischerOrangensaft->setAusverkauft(false);

    $menueVeggie->setProdukte(new ArrayCollection([
        $produktGemueseBurgerMitKaese, $produktBeilagensalat, $produktFrischerOrangensaft
    ]));

    //Menü 4
    $menueFitness = new Menue();
    $menueFitness->setTitel("Fitness Menü");
    $menueFitness->setBeschreibung("Die perfekte Mahlzeit nach dem Training – vollgepackt mit Proteinen & Nährstoffen!");
    $menueFitness->setPreis("10.50");
    $menueFitness->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Fitness Menü.jpg")));

    $produktGegrillteHaehnchenbrustMitReis = new Produkt();
    $produktGegrillteHaehnchenbrustMitReis->setTitel("Gegrillte Hähnchenbrust mit Reis");
    $produktGegrillteHaehnchenbrustMitReis->setBeschreibung("Proteinreiche Hähnchenbrust mit lockerem Naturreis.");
    $produktGegrillteHaehnchenbrustMitReis->setPreis("7.00");
    $produktGegrillteHaehnchenbrustMitReis->setZutat(new ArrayCollection([
        $zutatHaehnchen, $zutatNaturreis, $zutatBrokkoli, $zutatPaprika, $zutatKarotten
    ]));
    $energiewertGegrillteHaehnchenbrustMitReis = new Energiewert();
    $energiewertGegrillteHaehnchenbrustMitReis->setPortionSize("250g");
    $energiewertGegrillteHaehnchenbrustMitReis->setKalorien("520");
    $energiewertGegrillteHaehnchenbrustMitReis->setFett("9");
    $energiewertGegrillteHaehnchenbrustMitReis->setKohlenhydrate("65");
    $energiewertGegrillteHaehnchenbrustMitReis->setZucker("4");
    $energiewertGegrillteHaehnchenbrustMitReis->setEiweiss("40");
    $produktGegrillteHaehnchenbrustMitReis->setEnergiewert($energiewertGegrillteHaehnchenbrustMitReis);
    $produktGegrillteHaehnchenbrustMitReis->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Gegrillte Hähnchenbrust mit Reis.jpg")));
    $produktGegrillteHaehnchenbrustMitReis->setAusverkauft(false);

    $produktKleinePortionGemuese = new Produkt();
    $produktKleinePortionGemuese->setTitel("Kleine Portion gedämpftes Gemüse");
    $produktKleinePortionGemuese->setBeschreibung("Frische Karotten, Brokkoli und Paprika, schonend gegart.");
    $produktKleinePortionGemuese->setPreis("3.00");
    $produktKleinePortionGemuese->setZutat(new ArrayCollection([
        $zutatKarotten, $zutatBrokkoli, $zutatPaprika, $zutatOlivenoel, $zutatSalz
    ]));
    $energiewertKleinePortionGemuese = new Energiewert();
    $energiewertKleinePortionGemuese->setPortionSize("150g");
    $energiewertKleinePortionGemuese->setKalorien("80");
    $energiewertKleinePortionGemuese->setFett("2");
    $energiewertKleinePortionGemuese->setKohlenhydrate("12");
    $energiewertKleinePortionGemuese->setZucker("6");
    $energiewertKleinePortionGemuese->setEiweiss("4");
    $produktKleinePortionGemuese->setEnergiewert($energiewertKleinePortionGemuese);
    $produktKleinePortionGemuese->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Kleine Portion gedämpftes Gemüse.jpg")));
    $produktKleinePortionGemuese->setAusverkauft(false);

    $produktProteinshake = new Produkt();
    $produktProteinshake->setTitel("Schoko Proteinshake");
    $produktProteinshake->setBeschreibung("Perfekt für die Fitness-Liebhaber!");
    $produktProteinshake->setPreis("4.50");
    $produktProteinshake->setZutat(new ArrayCollection([
        $zutatMilch, $zutatProteinpulver, $zutatBanane, $zutatHonig, $zutatKakaopulver
    ]));
    $energiewertProteinshake = new Energiewert();
    $energiewertProteinshake->setPortionSize("150g");
    $energiewertProteinshake->setKalorien("250");
    $energiewertProteinshake->setFett("6");
    $energiewertProteinshake->setKohlenhydrate("30");
    $energiewertProteinshake->setZucker("22");
    $energiewertProteinshake->setEiweiss("25");
    $produktProteinshake->setEnergiewert($energiewertProteinshake);
    $produktProteinshake->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Schoko Proteinshake.jpg")));
    $produktProteinshake->setAusverkauft(false);

    $menueFitness->setProdukte(new ArrayCollection([
        $produktGegrillteHaehnchenbrustMitReis, $produktKleinePortionGemuese, $produktProteinshake
    ]));

    //Menü 5
    $menueFruehstueck = new Menue();
    $menueFruehstueck->setTitel("Frühstücks Menü");
    $menueFruehstueck->setBeschreibung("Starte den Tag mit einer gesunden, sättigenden Mahlzeit!");
    $menueFruehstueck->setPreis("7.50");
    $menueFruehstueck->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Frühstücks Menü.jpg")));

    $produktRuehreiMitVollkornbrot = new Produkt();
    $produktRuehreiMitVollkornbrot->setTitel("Rührei mit Vollkornbrot");
    $produktRuehreiMitVollkornbrot->setBeschreibung("Zwei fluffige Eier mit frischen Kräutern, serviert mit Vollkornbrot.");
    $produktRuehreiMitVollkornbrot->setPreis("4.80");
    $produktRuehreiMitVollkornbrot->setZutat(new ArrayCollection([
        $zutatEier, $zutatVollkornbroetchen, $zutatButter, $zutatSalz, $zutatKraeuter
    ]));
    $energiewertRuehreiMitVollkornbrot = new Energiewert();
    $energiewertRuehreiMitVollkornbrot->setPortionSize("200g");
    $energiewertRuehreiMitVollkornbrot->setKalorien("320");
    $energiewertRuehreiMitVollkornbrot->setFett("18");
    $energiewertRuehreiMitVollkornbrot->setKohlenhydrate("22");
    $energiewertRuehreiMitVollkornbrot->setZucker("2");
    $energiewertRuehreiMitVollkornbrot->setEiweiss("20");
    $produktRuehreiMitVollkornbrot->setEnergiewert($energiewertRuehreiMitVollkornbrot);
    $produktRuehreiMitVollkornbrot->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Rührei mit Vollkornbrot.jpg")));
    $produktRuehreiMitVollkornbrot->setAusverkauft(false);

    $produktFruchtjoghurtMitHonig = new Produkt();
    $produktFruchtjoghurtMitHonig->setTitel("Fruchtjoghurt mit Honig");
    $produktFruchtjoghurtMitHonig->setBeschreibung("Cremiger Naturjoghurt mit süßem Honig und frischen Früchten.");
    $produktFruchtjoghurtMitHonig->setPreis("3.50");
    $produktFruchtjoghurtMitHonig->setZutat(new ArrayCollection([
        $zutatNaturjoghurt, $zutatHonig, $zutatErdbeere, $zutatBanane, $zutatHaferflocken
    ]));
    $energiewertFruchtjoghurtMitHonig = new Energiewert();
    $energiewertFruchtjoghurtMitHonig->setPortionSize("180g");
    $energiewertFruchtjoghurtMitHonig->setKalorien("200");
    $energiewertFruchtjoghurtMitHonig->setFett("6");
    $energiewertFruchtjoghurtMitHonig->setKohlenhydrate("30");
    $energiewertFruchtjoghurtMitHonig->setZucker("24");
    $energiewertFruchtjoghurtMitHonig->setEiweiss("8");
    $produktFruchtjoghurtMitHonig->setEnergiewert($energiewertFruchtjoghurtMitHonig);
    $produktFruchtjoghurtMitHonig->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Fruchtjoghurt mit Honig.jpg")));
    $produktFruchtjoghurtMitHonig->setAusverkauft(false);

    $produktKaffee = new Produkt();
    $produktKaffee->setTitel("Kaffee");
    $produktKaffee->setBeschreibung("Wachmacher für einen gesunden Start in den Tag.");
    $produktKaffee->setPreis("2.00");
    $produktKaffee->setZutat(new ArrayCollection([
        $zutatKaffeebohnen, $zutatWasser
    ]));
    $energiewertKaffee = new Energiewert();
    $energiewertKaffee->setPortionSize("200ml");
    $energiewertKaffee->setKalorien("2");
    $energiewertKaffee->setFett("0");
    $energiewertKaffee->setKohlenhydrate("0");
    $energiewertKaffee->setZucker("0");
    $energiewertKaffee->setEiweiss("0");
    $produktKaffee->setEnergiewert($energiewertKaffee);
    $produktKaffee->setBild(new Bild(file_get_contents("assets/sample/menueProdukte/Kaffee.jpg")));
    $produktKaffee->setAusverkauft(true);

    $menueFruehstueck->setProdukte(new ArrayCollection([
        $produktRuehreiMitVollkornbrot, $produktFruchtjoghurtMitHonig, $produktKaffee
    ]));

    $menueRepository = new MenueRepository($entityManager);
    $menueRepository->save($menueClassicChicken);
    $menueRepository->save($menueCheeseburgerLight);
    $menueRepository->save($menueVeggie);
    $menueRepository->save($menueFitness);
    $menueRepository->save($menueFruehstueck);

    echo "Menüs und Produkte wurden hinzugefügt...\n";

    /*
     * Bestellstatus hinzufügen
     */
    $bestellstatusBestellungErhalten = new Bestellstatus();
    $bestellstatusBestellungErhalten->setStatus("Bestellung erhalten");
    $bestellstatusBestellungErhalten->setFarbe("#4682B4");

    $bestellstatusInBearbeitung = new Bestellstatus();
    $bestellstatusInBearbeitung->setStatus("In Bearbeitung");
    $bestellstatusInBearbeitung->setFarbe("#FFDF00");

    $bestellstatusVersandt = new Bestellstatus();
    $bestellstatusVersandt->setStatus("Versandt");
    $bestellstatusVersandt->setFarbe("#228B22");

    $bestellstatusStorniert = new Bestellstatus();
    $bestellstatusStorniert->setStatus("Storniert");
    $bestellstatusStorniert->setFarbe("#FF0000");

    $bestellstatusZugestellt = new Bestellstatus();
    $bestellstatusZugestellt->setStatus("Zugestellt");
    $bestellstatusZugestellt->setFarbe("#008000");

    $bestellstatusRepository = new BestellstatusRepository($entityManager);
    $bestellstatusRepository->save($bestellstatusBestellungErhalten);
    $bestellstatusRepository->save($bestellstatusInBearbeitung);
    $bestellstatusRepository->save($bestellstatusVersandt);
    $bestellstatusRepository->save($bestellstatusStorniert);
    $bestellstatusRepository->save($bestellstatusZugestellt);

    echo "Bestellstatus wurde hinzugefügt...\n";

    /*
     * Admin Login hinzufügen
     */
    $login = new Login();
    $login->setNutzername("admin");

    $hashedPassword = PasswortHash::hashPassword("admin");
    $login->setPasswort($hashedPassword);

    $loginRepository = new LoginRepository($entityManager);
    $loginRepository->save($login);

    $admin = new Admin();
    $admin->setLogin($login);

    $adminRepository = new AdminRepository($entityManager);
    $adminRepository->save($admin);

    echo "Admin Login wurde hinzugefügt unter den Credentials: \n";
    echo "Nutzername: admin\n";
    echo "Passwort: admin\n";

    /*
     * Nutzer hinzufügen
     */

    $login = new Login();
    $login->setNutzername("Max");

    $hashedPassword = PasswortHash::hashPassword("1234");
    $login->setPasswort($hashedPassword);

    $kunde = new Kunde();
    $kunde->setVorname("Maximilian");
    $kunde->setNachname("Mustermann");
    $kunde->setTelefonnummer("09557425839");
    $kunde->setRegistrierungsdatum(new DateTime());
    $kunde->setLogin($login);

    $adresse = new Adresse();
    $adresse->setStrassenname("Musterstr.");
    $adresse->setHausnummer("1a");
    $adresse->setBundesland("Berlin");
    $adresse->setPLZ("80448");
    $adresse->setStadt("Berlin");
    $adresse->setZusatz("5. Stock");
    $kunde->setAdresse($adresse);

    $kundeRepository = new KundeRepository($entityManager);
    $kundeRepository->save($kunde);

    echo "Kunde wurde hinzugefügt unter den Credentials: \n";
    echo "Nutzername: Max\n";
    echo "Passwort: 1234\n";

} catch (ErrorException $e) {
    echo "Fehler: " . $e->getMessage();
    exit();
} finally {
    restore_error_handler();
}

echo "\nSample Daten erfolgreich in die Datenbank gespeichert!\n";