<!-- Kenneth 
Huurtoeslag:
    Jaar = Date;
    bool Toeslagpartner;
    bool andereBewoners;
    Date_of_birth = date;
    string land = Nederland;
    int inkomen = 0;
    int huurPrijs = 0;
    int maxVermogen = 37395,00;

    ===================================================
    Vraag 1: Voor welk jaar wilt u toeslagen aanvragen?
        1: 2025
        2: 2024
        3: 2023
        4: 2022
        5: 2021

    Vraag 2: Welke toeslagen wilt u aanvragen?
        is isset(alleToeslagen) {}
        else if isset (Huurtoeslag) {}
        else if isset ()

    Vraag 3: Heeft u een toeslagpartner?
        if true: (Resultaat / 2)

    Vraag 4: Wat is uw geboortedatum?
        if age < 21 
            (maxHuur = 477,20)
        else
            (maxHuur = 900,27)

    Vraag 5: In welk land woont u?
        if Nederland {continue}
        else break;

    Vraag 6: Wat is uw inkomen van [JAARTAL]?
        int inkomen = 0;

    Vraag 7: Wonen er nog andere bewoners in uw huis?
        if true: (Hoeveel mensen zijn dat?) 
        else continue;

    Vraag 8: Hoeveel kale huur betaalt u per maand?
        if age < 21 && maxHuur < 477,20: (BEREKENING MINDERJARIGE)
        else if age < 21 && maxHuur > 477,20: (ALERT: De maximale huur bedraagt 477,20 voor mensen onder de 21)
        else if age > 21 && maxHuur < 900,27: (BEREKENING MEERDERJARIGE)
        else if age > 21 && maxHuur > 900,27:(ALERT: De maximale huur waarvoor u huurtoeslag kunt krijgen bedraagt 900,27)
        else: (ALERT: er ging iets mis!)

    Vraag 9: Is uw vermogen op 1 januari [JAARTAL] meer dan €37.395?
        if true: (ALERT: U hebt geen recht op huurtoeslag!)
        if false: BUTTON: [Toon resultaten]

    ==================================================
    Ingevoerde gegevens:
    Jaar                            2025
    Rekenhuur (huur per maand)      € 570,26
    Toeslagpartner                  nee
    Andere bewoners                 nee
    Toetsingsinkomen                € 12.000

    Resultaat:                      € 338 per maand
-->
<?php
require_once 'db.php';

class Product {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Alle toeslagen bekijken
    public function selectAll() {
        return $this->db->execute("SELECT * FROM toeslagen")->fetchAll();
    }

    // Functie om nieuwe toeslagen aan te vragen
    public function addUserToeslagen() {}

    // Aanvragen van normale gebruiker accounts beoordelen 
    public function getUserAanvragen() {}

    

    // Functie om uitbetalings data in op te slaan en te verwerken
    public function getUitbetalingen() {}


}

?>