# WHMCS Mollie Payments gateway
Unofficial Mollie Payments gateway for WHMCS. This free gateway does NOT support Mollie Recurring, only Molie Payments. For Mollie Recurring we have a [paid](https://0100dev.nl/modules/whmcs#WHMCS%20Mollie%20Recurring) gateway. These gateways are not dependent on each other and can operate side by side, but also without each other.

Compatible with **alle** WHMCS versions that are supported by WHMCS.

### Installation
+ Log in to your (s)FTP.
+ Download the `whmcs-mollie.tar.gz` from the [releases page](https://github.com/0100Dev/WHMCS-Mollie/releases) (**PLEASE NOTE:** **not** `Source code (zip)` or `Source code (tar.gz)`!).
+ Upload all the files from the `src` folder to the `/modules/gateways` folder in your WHMCS installation.

### Payment Methodes
All payment methods from Mollie are supported (which is also supported by their API). Enable the desired payment methods by activating the gateway in WHMCS.

Support for new payment methods must be added manually, due to the structure of this gateway. It can therefore take a while before a new payment method is supported. Is it urgent? Contact our paid support or add support for it yourself and contribute it back using a pull request.

You can use `Mollie Checkout` to use the Mollie Payments checkout pages. In this case it'll use the Mollie Payments checkout screen and show all enabled payment methodes in your Mollie account.

### Support
Support is best-effort through the Github issue tracker. Business support (responsetime within 24 hours, normally less then 1 hour) through our [website](https://0100dev.nl/) against our hourly rate at € 75,- excl. VAT. Please create an account at our website before contacting us.

[More information through Mollie about Mollie Payments](https://www.mollie.com/en/payments)
