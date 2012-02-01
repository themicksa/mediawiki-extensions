<?php
/**
 * Language file for Semantic Page Series
 */

$messages = array();

/** English
 * @author F.trott
 */
$messages['en'] = array(
	'semanticpageseries-desc' => 'Creating a series of pages from one [https://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Form]',
	'spssuccesstitle' => 'Creating $1 pages',
	'spssuccess' => '{{PLURAL:$1|One page|$1 pages}} will be created.',
	'spssuccess_returntoorigin' => 'Return to $1',
	'spserror' => 'An error occurred',
	
	'spserror_diffnotsupported' => 'The diff action is not supported for page series.',
	'spserror_previewnotsupported' => 'The preview action is not supported for page series.',
	'spserror_noiteratorname' => 'No iterator specified. You have to set the parameter "iterator" in the #serieslink parser function call.',
	'spserror_iteratorunknown' => 'Iterator "$1" does not exist. You have to correct the parameter "iterator" in the #serieslink parser function call.',
	'spserror_noformname' => 'No form name given.  You have to set the parameter "form" in the #serieslink parser function.',
	'spserror_formunknown' => 'Form "$1" does not exist.',
	'spserror_notargetformname' => 'No target form name given. You have to set the parameter "target form" in the #serieslink parser function call.',
	'spserror_notargetfieldname' => 'No target field name given. You have to set the parameter "target field" in the #serieslink parser function call.',
	'spserror_iteratorparammissing' => "The following iterator parameters are missing in the #serieslink call:\n$1",
	'spserror_noiteratordata' => 'No iterator parameters found in the sent data.',
	'spserror_pagegenerationlimitexeeded' => 'You tried to generate {{PLURAL:$1|one page|$1 pages}}. This exeeds your allowed limit of {{PLURAL:$2|one page|$2 pages}}.',
);

/** Message documentation (Message documentation)
 * @author F.trott
 * @author Raymond
 */
$messages['qqq'] = array(
	'semanticpageseries-desc' => '{{desc}}',
	'spssuccesstitle' => 'The title of a page containing a success message. The parameter will contain the category of pages to be created, e.g. Event',
	'spssuccess' => 'A success message. The parameter will contain a number.',
	'spssuccess_returntoorigin' => 'Provides navigation back to the origin page. The parameter is the link.',
	'spserror' => 'The title of en error page',
	'spserror_diffnotsupported' => 'An error message',
	'spserror_previewnotsupported' => 'An error message',
	'spserror_noiteratorname' => 'An error message. See the [[wikipedia:Iterator | wikipedia page]] for the meaning of iterator. The name of the parameter in quotes should not be translated!',
	'spserror_iteratorunknown' => 'An error message. See the [[wikipedia:Iterator | wikipedia page]] for the meaning of iterator. The name of the parameter in quotes should not be translated!',
	'spserror_noformname' => 'An error message. The name of the parameter in quotes should not be translated!',
	'spserror_formunknown' => 'An error message',
	'spserror_notargetformname' => 'An error message. The name of the parameter in quotes should not be translated!',
	'spserror_notargetfieldname' => 'An error message. The name of the parameter in quotes should not be translated!',
	'spserror_iteratorparammissing' => 'An error message. See the [[wikipedia:Iterator | wikipedia page]] for the meaning of iterator. Do not translate <code>#serieslink</code>.',
	'spserror_noiteratordata' => 'An error message. See the [[wikipedia:Iterator | wikipedia page]] for the meaning of iterator.',
	'spserror_pagegenerationlimitexeeded' => 'An error message',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'semanticpageseries-desc' => 'Ermöglicht das Erstellen einer Seitenfolge mit einem von [https://www.mediawiki.org/wiki/Extension:Semantic_Forms Semantic Forms] bereitgestellten Formular',
	'spssuccesstitle' => '$1 Seiten werden erstellt …',
	'spssuccess' => '{{PLURAL:$1|Eine Seite wird|$1 Seiten werden}} erstellt.',
	'spserror' => 'Ein Fehler ist aufgetreten',
	'spserror_diffnotsupported' => 'Die Aktion „diff“ wird nicht unterstützt.',
	'spserror_previewnotsupported' => 'Die Seitenvorschau wird nicht unterstützt.',
	'spserror_noiteratorname' => 'Der Seitenfolgebezeichner wurde nicht angegeben. Der Parameter „iterator“ muss zur Funktion #serieslink angegeben werden.',
	'spserror_iteratorunknown' => 'Der Seitenfolgebezeichner „$1“ ist nicht vorhanden. Der Parameter „iterator“ der Funktion #serieslink muss berichtigt werden.',
	'spserror_noformname' => 'Der Name des Formulars wurde nicht angegeben.',
	'spserror_formunknown' => 'Das Formular „$1“ ist nicht vorhanden.',
	'spserror_notargetformname' => 'Der Name des Zielformulars wurde nicht angegeben. Der Parameter „target form“ muss zur Funktion #serieslink angegeben werden.',
	'spserror_notargetfieldname' => 'Der Name des Zielfeldes wurde nicht angegeben. Der Parameter „target field“ muss zur Funktion #serieslink angegeben werden.',
	'spserror_iteratorparammissing' => 'Die folgenden Parameter zum Seitenfolgebezeichner fehlen beim Aufruf der Funktion #serieslink:
$1',
	'spserror_noiteratordata' => 'Die gesendeten Daten enthalten keine Parameter zum Seitenfolgebezeichner.',
	'spserror_pagegenerationlimitexeeded' => 'Es {{PLURAL:$1|sollte eine Seite|sollten $1 Seiten}} erstellt werden. Diese Anzahl übertrifft den zulässigen Grenzwert von {{PLURAL:$2|einer Seite|$2 Seiten}}.',
);

/** French (Français)
 * @author Gomoko
 */
$messages['fr'] = array(
	'semanticpageseries-desc' => 'Créer une série de pages depuis un [https://www.mediawiki.org/wiki/Extension:Semantic_Forms formulaire sémantique]',
	'spssuccesstitle' => 'Créer $1 pages',
	'spssuccess' => '{{PLURAL:$1|Une page sera créée|$1 pages seront créées}}.',
	'spserror' => 'Une erreur est survenue',
	'spserror_diffnotsupported' => "L'action diff n'est pas supportée pour les séries de page.",
	'spserror_previewnotsupported' => "L'action de prévisualisation n'est pas supportée pour les séries de page.",
	'spserror_noiteratorname' => "Aucun itérateur n'a été spécifié. Vous devez définir le paramètre \"iterator\" dans l'appel à la fonction #serieslink de l'analyseur.",
	'spserror_iteratorunknown' => 'L\'itérateur "$1" n\'existe pas. Vous devez corriger le paramètre "iterator" dans l\'appel à la fonction #serieslink de l\'analyseur.',
	'spserror_noformname' => 'Aucun nom de formulaire n\'a été fourni. Vous devez définir le paramètre "form" dans la fonction #serieslink de l\'analyseur.',
	'spserror_formunknown' => 'Le formulaire "$1" n\'existe pas.',
	'spserror_notargetformname' => "Aucun nom de formulaire cible n'a été fourni. Vous devez définir le paramètre \"target form\" dans l'appel à la fonction #serieslink de l'analyseur.",
	'spserror_notargetfieldname' => "Aucun nom de champ cible n'a été fourni. Vous devez définir le paramètre \"target field\" dans l'appel à la fonction #serieslink de l'analyseur.",
	'spserror_iteratorparammissing' => "Les paramètres suivants de l'itérateur sont absents dans l'appel à #serieslink:
$1",
	'spserror_noiteratordata' => "Aucun paramètre de l'itérateur n'a été trouvé dans les données envoyées.",
	'spserror_pagegenerationlimitexeeded' => 'Vous avez essayé de générer {{PLURAL:$1|une page|$1 pages}}. Cela dépasse votre limite autorisée de {{PLURAL:$2|une page|$2 pages}}.',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'semanticpageseries-desc' => 'Wutworjenje slěda stronow ze [https://www.mediawiki.org/wiki/Extension:Semantic_Forms semantiskim formularom]',
	'spssuccesstitle' => '$1 stronow so wutwarja',
	'spssuccess' => '{{PLURAL:$1|Jedna strona so wutwori|$1 stronje so wutworitej|$1 strony so wutworja|$1 stronow so wutwori}}.',
	'spserror' => 'Zmylk je wustupił',
	'spserror_diffnotsupported' => 'Akcija "diff" so za slědy stronow njepodpěruje.',
	'spserror_previewnotsupported' => 'Přehlad so za slědow stronow njepodpěruje.',
	'spserror_noiteratorname' => 'Žane iteratorowe mjeno njepodate. Parameter "iterator" dyrbi so we wołanju parseroweje funkcije #serieslink podać.',
	'spserror_iteratorunknown' => 'Iterator "$1" njeeksistuje. Parameter "iterator" dyrbi so we wołanju parseroweje funkcije #serieslink podać.',
	'spserror_noformname' => 'Žane formularne mjeno njepodate.',
	'spserror_formunknown' => 'Formular "$1" njeeksistuje.',
	'spserror_notargetformname' => 'Žadyn cilowy formular njepodaty. Parameter "target form" dyrbi so we wołanju parseroweje funkcije #serieslink podać.',
	'spserror_notargetfieldname' => 'Žane cilowe polo njepodate. Parameter "target field" dyrbi so we wołanju parseroweje funkcije #serieslink podać.',
	'spserror_iteratorparammissing' => 'Slědowace iteratorowe parametry při wołanju funkcije #serieslink faluja: $1',
	'spserror_noiteratordata' => 'Žane iteratorowe parametry w pósłanych datach namakane.',
	'spserror_pagegenerationlimitexeeded' => 'Sy spytał {{PLURAL:$1|jednu stronu|$1 stronje|$1 strony|$1 stronow}} płodźić. To překročuje dowoleny limit wot {{PLURAL:$2|jedneje strony|$2 stronow|$2 stronow|$1 stronow}}.',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'semanticpageseries-desc' => 'Crea un serie de paginas ab un sol [https://www.mediawiki.org/wiki/Extension:Semantic_Forms formulario semantic]',
	'spssuccesstitle' => 'Crea $1 paginas',
	'spssuccess' => '{{PLURAL:$1|Un pagina|$1 paginas}} essera create.',
	'spserror' => 'Un error ha occurrite',
	'spserror_diffnotsupported' => 'Le action "diff" non es supportate pro series de paginas.',
	'spserror_previewnotsupported' => 'Le action de previsualisation non es supportate pro series de paginas.',
	'spserror_noiteratorname' => 'Nulle iterator specificate. Es necessari specificar le parametro "iterator" in le appello al function analysator #serieslink.',
	'spserror_iteratorunknown' => 'Le iterator "$1" non existe. Es necessari corriger le parametro "iterator" in le appello al function analysator #serieslink.',
	'spserror_noformname' => 'Nulle nomine de formulario specificate.',
	'spserror_formunknown' => 'Le formulario "$1" non existe.',
	'spserror_notargetformname' => 'Nulle nomine de formulario de destination specificate. Es necessari specificar le parametro "target form" in le appello al function analysator #serieslink.',
	'spserror_notargetfieldname' => 'Nulle nomine de campo de destination specificate. Es necessari specificar le parametro "target field" in le appello al function analysator #serieslink.',
	'spserror_iteratorparammissing' => 'Le sequente parametros de iterator manca in le appello #serieslink:
$1',
	'spserror_noiteratordata' => 'Nulle parametro de iterator trovate in le datos inviate.',
	'spserror_pagegenerationlimitexeeded' => 'Tu tentava generar {{PLURAL:$1|un pagina|$1 paginas}}. Isto excede tu limite autorisate de {{PLURAL:$2|un pagina|$2 paginas}}.',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'semanticpageseries-desc' => 'Создавање на низа страници од еден [https://www.mediawiki.org/wiki/Extension:Semantic_Forms?uselang=mk Семантички образец]',
	'spssuccesstitle' => 'Создате $1 страници',
	'spssuccess' => '{{PLURAL:$1|Ќе биде создадена една страница|Ќе бидат создадени $1 страници}}',
	'spserror' => 'Се појави грешка',
	'spserror_diffnotsupported' => 'Функцијата „разлика“ не е достапна за цели низи од страници.',
	'spserror_previewnotsupported' => 'Функцијата „преглед“ не е достапна за цели низи од страници.',
	'spserror_noiteratorname' => 'Нема укажано повторувач. Треба да зададете параметар „iterator“ во повикот #serieslink на парсерската функција.',
	'spserror_iteratorunknown' => 'Повторувачот „$1“ не постои. Ќе треба да го исправите параметарот „iterator“ во повикот #serieslink на парсерската функција.',
	'spserror_noformname' => 'Нема укажано име на образецот.',
	'spserror_formunknown' => 'Образецот „$1“ не постои.',
	'spserror_notargetformname' => 'Нема укажано име на целниот образец. Треба да зададете параметар „target form“ во повикот #serieslink на парсерската функција.',
	'spserror_notargetfieldname' => 'Нема укажано име на целното поле. Треба да зададете параметар „target field“ во повикот #serieslink на парсерската функција.',
	'spserror_iteratorparammissing' => 'Следниве параметри за повторувачот недостасуваат во повикот #serieslink call:
$1',
	'spserror_noiteratordata' => 'Не пронајдов параметри за повторувачот во испратените податоци.',
	'spserror_pagegenerationlimitexeeded' => 'Се обидовте да создадете {{PLURAL:$1|една страница|$1 страници}}. Со тоа ја надминувате дозволената граница од {{PLURAL:$2|една страница|$2 страници}}.',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 */
$messages['nl'] = array(
	'spserror_formunknown' => 'Formulier "$1" bestaat niet.',
);

