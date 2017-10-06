# WHMCS Mollie Gateway
Onofficiële Mollie gateway voor WHMCS.

Compatible met WHMCS **7.3.0**.

### Installatie via SSH
+ Log in op SSH (of console) en zorg dat GIT geinstalleerd is op uw webserver.
+ Ga naar de root van de WHMCS installatie (de hoofd folder) en voer het onderstaande commando uit.
+ ``` git clone --recursive https://github.com/0100Dev/WHMCS-Mollie.git /tmp/whmcs && sudo cp /tmp/whmcs/src ./modules/gateways/```

### Installatie via FTP
+ Log in op FTP.
+ Download de `whmcs-mollie.tar.gz` van onze [releases pagina](https://github.com/0100Dev/WHMCS-Mollie/releases) (**LET OP:** **niet** `Source code (zip)` of `Source code (tar.gz)`!).
+ Upload alles uit de `src` folder uit de hierboven gedownloaden TAR in de `/modules/gateways` folder van uw WHMCS installatie.
+ Opmerking: mollieideal.php van deze module moet de originele van WHMCS overschrijven. Het is tot nu toe nog niet mogelijk om het bestand een andere naam te geven dankzij WHMCS naamgevingen en interne namen.

### Betaalmethodes
Alle betaalmethodes van Mollie zijn ondersteund. Zet de gewenste betaalmethodes aan door de gateway in WHMCS te activeren.

### Support
Support alleen in Github via haar issuetracker.

[Meer informatie via Mollie](https://www.mollie.nl/betaaldiensten/)

![Powerd By Mollie](http://www.mollie.nl/images/badge-betaling-medium.png)
