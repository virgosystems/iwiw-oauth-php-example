# Letöltés
Git-tel:

	git clone http://github.com/virgo/iwiw-oauth-php-example.git

vagy svn-nel:

	svn checkout http://svn.github.com/virgo/iwiw-oauth-php-example.git

vagy [letölthető zip-ben](http://github.com/virgo/iwiw-oauth-php-example/archives/master).

# Konfigurálás
A példakód iWiW Homokozóval való használatához a következőket kell tenned:

* index.php-ben add meg a kulcsodat és titkos kulcsodat (a [fejlesztői portálon](http://dev.iwiw.hu) szerezheted be őket):
  * $consumerKey='kulcs';
  * $consumerSecret='titkos_kulcs';
* Éles iWiW-en való használathoz:
  * $iwiwBaseURL = 'http://iwiw.hu';
  * $iwiwBaseApiURL = 'http://api.iwiw.hu';

# Telepítés
* Töltsd le az [OpenSocial PHP Client Libraryt 1.1.1](http://code.google.com/p/opensocial-php-client/)
* Az `osapi` foldert teljes tartalmával másold az iWiW példa folderébe.
* Add meg a kulcsaidat.
* Másold fel az egészet egy php támogatással rendelkező webszerverre.
* Nyisd meg az index.php-t tetszőleges browserrel.

# Egyebek
Szabadon felhasználható és módosítható Apache License, Version 2.0 alapján.
