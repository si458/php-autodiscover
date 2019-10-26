# php-autodiscover

This PHP script is intended to respond to any request to ``http(s)://mydomain.com/autodiscover/autodiscover.xml``

If configured properly, it will send a spec-complient autodiscover XML response, pointing mail clients to the
appropriate mail services.

## Supports
* IMAP
* POP3
* SMTP
* ACTIVESYNC

## Nginx Rewrite Rule Required To Work
````
rewrite (?i)^/autodiscover/autodiscover.xml$ /autodiscover.php;
````

## Apache Rewrite Rule Required To Work
````
RedirectMatch (?i)/autodiscover/autodiscover.xml /autodiscover.php
````