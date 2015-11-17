# Installatie via SSH + GIT #
+ Log in op SSH (of console) en zorg dat GIT geinstalleerd is op uw webserver.
+ Ga naar de root van de WHMCS installatie (de hoofd folder) en voer het onderstaande commando uit.
+ ``` git clone --recursive https://github.com/0100Dev/WHMCS-Mollie.git /tmp/whmcs && sudo cp /tmp/whmcs/src ./modules/gateways/```

# Installatie via FTP #
+ Log in op FTP.
+ Download de `whmcs-mollie.tar.gz` van onze [releases pagina](https://github.com/0100Dev/WHMCS-Mollie/releases).
+ Upload alles uit de `src` folder uit de hierboven gedownloaden TAR in de `/modules/gateways` folder van uw WHMCS installatie.

# Ondersteunde betaalmethodes #
Alle betaalmethodes van Mollie zijn ondersteund. Zet de gewenste betaalmethodes aan door de gateway in WHMCS te activeren.

# Support #
Support alleen in Github via haar issuetracker.

[Meer informatie via Mollie](https://www.mollie.nl/betaaldiensten/)

![Powerd By Mollie](http://www.mollie.nl/images/badge-betaling-medium.png)
