# WHMCS Mollie Gateway
Onofficiële Mollie gateway voor WHMCS. In deze gratis plugin zit GEEN ondersteuning voor Mollie Recurring (SEPA/Automatisch Incasso). Hiervoor hebben we een [betaalde](https://0100dev.nl/modules/whmcs#WHMCS%20Mollie%20Recurring) plugin. Deze plugins zijn niet afhankelijk van elkaar en kunnen naast elkaar opereren maar ook zonder elkaar.

Compatible met **alle** WHMCS versies.

### Installatie via SSH
+ Log in op SSH (of console) en zorg dat GIT geinstalleerd is op uw webserver.
+ Ga naar de root van de WHMCS installatie (de hoofd folder) en voer het onderstaande commando uit.
+ ``` git clone --recursive https://github.com/0100Dev/WHMCS-Mollie.git /tmp/whmcs && sudo cp /tmp/whmcs/src ./modules/gateways/```

### Installatie via FTP
+ Log in op FTP.
+ Download de `whmcs-mollie.tar.gz` van onze [releases pagina](https://github.com/0100Dev/WHMCS-Mollie/releases) (**LET OP:** **niet** `Source code (zip)` of `Source code (tar.gz)`!).
+ Upload alles uit de `src` folder uit de hierboven gedownloaden TAR in de `/modules/gateways` folder van uw WHMCS installatie.

### Betaalmethodes
Alle betaalmethodes van Mollie zijn ondersteund. Zet de gewenste betaalmethodes aan door de gateway in WHMCS te activeren.

### Updates

#### V1.0 naar V2.0
Deze release is NIET compatible met V1.x. Verwijder eerst alle files vanuit je /modules/gateways folder die betrekking hebben op deze gateway. Alles dus met mollie_x.php. In WHMCS dien je ook opnieuw deze gateways in te schakelen. WHMCS zal aangeven dat de ouded gateways niet meer gevonden kunnen worden, dit klopt - verwijder deze en vervang deze met de nieuw ingeschakelde.

Let erop dat je bijvoorbeeld NIET onze mollierecurring.php moet verwijderen, als je onze betaalde Mollie Recurring gateway actief hebt.

### Support
Support op basis van best-effort in Github via haar issuetracker. Business support (reactietijd van max. 24 uur, normaliter <1 uur) via ons [klantenpaneel](https://my.0100dev.nl/) tegen ons uurtarief a € 45,- excl. VAT. Maak een account aan en stuur via daar een ticket in.

[Meer informatie via Mollie](https://www.mollie.nl/betaaldiensten/)
