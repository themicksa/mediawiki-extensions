<?php
/**
 * Internationalization file for the LinkFilter extension.
 *
 * @file
 * @ingroup Extensions
 */

$messages = array();

/** English
 * @author Aaron Wright <aaron.wright@gmail.com>
 * @author David Pean <david.pean@gmail.com>
 */
$messages['en'] = array(
	'linkapprove' => 'Approve links',
	'linkshome' => 'Links home',
	'linksubmit' => 'Submit a link',
	'linkfilter-desc' => 'Adds new special pages and a parser hook for link submitting/approval/reject',
	'linkfilter-nothing-to-approve' => 'There are currently no links awaiting approval.',
	'linkfilter-no-recently-approved' => 'No links have been approved recently.',
	'linkfilter-no-links-at-all' => 'No links have been submitted yet or the link administrators have not reviewed the submitted links yet.',
	'linkfilter-ago' => '$1 ago under <i>$2</i>',
	'linkfilter-all' => 'All',
	'linkfilter-submit' => 'Submit',
	'linkfilter-submit-title' => 'Submit a link',
	'linkfilter-submit-no-title' => 'Please enter a title',
	'linkfilter-submit-no-type' => 'Pick a link type.',
	'linkfilter-edit-title' => 'Edit $1',
	'linkfilter-approve-links' => 'Approve links',
	'linkfilter-submit-another' => 'Submit another link',
	'linkfilter-login-title' => 'Not logged in',
	'linkfilter-login-text' => 'You must be logged in to submit links.',
	'linkfilter-url' => 'URL',
	'linkfilter-title' => 'Title',
	'linkfilter-type' => 'Link type',
	'linkfilter-description' => 'Description',
	'linkfilter-submit-button' => 'Submit link',
	'linkfilter-home-button' => 'Links home',
	'linkfilter-submit-success-title' => 'Link submitted',
	'linkfilter-submit-success-text' => 'Your link has been sent for approval',
	'linkfilter-instructions-url' => 'Linkfilter-instructions',
	'linkfilter-instructions' => 'You can [[{{MediaWiki:Linkfilter-instructions-url}}|add instructions for users]].',
	'linkfilter-admin-instructions-url' => 'Linkfilter-admin-instructions',
	'linkfilter-admin-instructions' => 'You can add [[{{MediaWiki:Linkfilter-admin-instructions-url}}|instructions for administrators]].',
	'linkfilter-admin-recent' => 'Recently approved',
	'linkfilter-approve-title' => 'Link administration',
	'linkfilter-submittedby' => 'Submitted by',
	'linkfilter-submitted' => 'Submitted $1',
	'linkfilter-admin-accept' => 'Accept',
	'linkfilter-admin-reject' => 'Reject',
	'linkfilter-admin-reject-success' => 'The link was rejected',
	'linkfilter-admin-accept-success' => 'The link was accepted',
	'linkfilter-in-the-news' => 'In the news',
	'linkfilter-about-submitter' => 'About the submitter',
	'linkfilter-anonymous' => 'Anonymous fanatic',
	'linkfilter-comments-of-day' => 'Top comments',
	'linkfilter-comments' => '{{PLURAL:$1|$1 comment|$1 comments}}',
	'linkfilter-home-title' => '$1 links',
	'linkfilter-home-title-all' => 'All links',
	'linkfilter-next' => 'next',
	'linkfilter-previous' => 'previous',
	'linkfilter-description-max' => 'Maximum characters',
	'linkfilter-description-left' => '$1 left',
	'linkfilter-popular-articles' => 'Do not miss',
	'linkfilter-new-links-title' => 'New links',
	'linkfilter-time-days' => '{{PLURAL:$1|one day|$1 days}}',
	'linkfilter-time-hours' => '{{PLURAL:$1|one hour|$1 hours}}',
	'linkfilter-time-minutes' => '{{PLURAL:$1|one minute|$1 minutes}}',
	'linkfilter-time-seconds' => '{{PLURAL:$1|one second|$1 seconds}}',
	'linkfilter-edit-summary' => 'new link',
	'linkfilter-no-results' => 'No pages found.',
	'linkfilter-feed-title' => '{{SITENAME}} links', // RSS feed title
	// For Special:ListUsers - new group
	'group-linkadmin' => 'Link administrators',
	'group-linkadmin-member' => 'link administrator',
	'grouppage-linkadmin' => '{{ns:project}}:Link administrators',
	// For Special:ListGroupRights
	'right-linkadmin' => 'Administrate user-submitted links',
);

/** Message documentation (Message documentation)
 * @author Siebrand
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'linkfilter-instructions-url' => 'Page name for LinkFilter instructions. Use in content language in {{msg-mw|linkfilter-instructions}}.',
	'linkfilter-admin-instructions-url' => 'Page name for LinkFilter instructions for administrators. Use in content language in {{msg-mw|linkfilter-admin-instructions}}.',
	'right-linkadmin' => '{{doc-right|linkadmin}}',
);

/** Breton (Brezhoneg)
 * @author Y-M D
 */
$messages['br'] = array(
	'linkfilter-all' => 'Pep tra',
	'linkfilter-submit' => 'Kas',
	'linkfilter-edit-title' => 'Kemmañ $1',
	'linkfilter-title' => 'Titl',
	'linkfilter-admin-accept' => 'Asantiñ',
	'linkfilter-admin-reject' => 'Disteurel',
	'linkfilter-home-title' => '$1 liamm',
	'linkfilter-home-title-all' => 'An holl liammoù',
	'linkfilter-next' => "war-lerc'h",
	'linkfilter-previous' => 'kent',
	'linkfilter-new-links-title' => 'Liammoù nevez',
	'linkfilter-edit-summary' => 'liamm nevez',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'linkapprove' => 'Akzeptieren von Links',
	'linkshome' => 'Startseite zu Links',
	'linksubmit' => 'Einen Link einreichen',
	'linkfilter-desc' => 'Ergänzt eine Spezialseite zum Einreichen/Akzeptieren und Ablehnen von Links, sowie einen entsprechenden Parser-Hook',
	'linkfilter-nothing-to-approve' => 'Derzeit sind keine Links zum Überprüfen vorhanden.',
	'linkfilter-no-recently-approved' => 'In letzter Zeit wurden keine Links akzeptiert.',
	'linkfilter-no-links-at-all' => 'Bislang wurden entweder noch keine Links eingereicht, oder die Linkadministratoren haben die eingereichten Links noch nicht überprüft.',
	'linkfilter-ago' => 'Vor $1 unter <i>$2</i>',
	'linkfilter-all' => 'Alle',
	'linkfilter-submit' => 'Speichern',
	'linkfilter-submit-title' => 'Einen Link einreichen',
	'linkfilter-submit-no-title' => 'Bitte einen Namen angeben',
	'linkfilter-submit-no-type' => 'Die Art des Links auswählen',
	'linkfilter-edit-title' => '$1 bearbeitet',
	'linkfilter-approve-links' => 'Links überprüfen',
	'linkfilter-submit-another' => 'Einen weiteren Link einreichen',
	'linkfilter-login-title' => 'Du bist nicht angemeldet.',
	'linkfilter-login-text' => 'Du musst angemeldet zu sein, um Links einreichen zu können.',
	'linkfilter-title' => 'Name',
	'linkfilter-type' => 'Art des Links',
	'linkfilter-description' => 'Beschreibung',
	'linkfilter-submit-button' => 'Link einreichen',
	'linkfilter-home-button' => 'Startseite',
	'linkfilter-submit-success-title' => 'Der Link wurde eingereicht.',
	'linkfilter-submit-success-text' => 'Der Link wurde zur Überprüfung eingereicht.',
	'linkfilter-instructions-url' => 'Anleitung zum Linkfilter',
	'linkfilter-instructions' => 'Du kannst [[{{MediaWiki:Linkfilter-instructions-url}}|eine Anleitung für andere Benutzer hinzufügen]].',
	'linkfilter-admin-instructions-url' => 'Administratorenanleitung zum Linkfilter',
	'linkfilter-admin-instructions' => 'Du kannst [[{{MediaWiki:Linkfilter-admin-instructions-url}}|eine Anleitung für andere Administratoren hinzufügen]].',
	'linkfilter-admin-recent' => 'Vor kurzem akzeptiert',
	'linkfilter-approve-title' => 'Linkverwaltung',
	'linkfilter-submittedby' => 'Eingereicht von',
	'linkfilter-submitted' => '$1 eingereicht',
	'linkfilter-admin-accept' => 'Akzeptieren',
	'linkfilter-admin-reject' => 'Ablehnen',
	'linkfilter-admin-reject-success' => 'Der Link wurde abgelehnt.',
	'linkfilter-admin-accept-success' => 'Der Link wurde akzeptiert.',
	'linkfilter-in-the-news' => 'Neuigkeiten',
	'linkfilter-about-submitter' => 'Über den Einreicher',
	'linkfilter-anonymous' => 'Anonymer',
	'linkfilter-comments-of-day' => 'Beliebteste Kommentare',
	'linkfilter-comments' => '{{PLURAL:$1|Ein Kommentar|$1 Kommentare}}',
	'linkfilter-home-title' => '$1 Links',
	'linkfilter-home-title-all' => 'Alle Links',
	'linkfilter-next' => 'nächster',
	'linkfilter-previous' => 'vorheriger',
	'linkfilter-description-max' => 'Maximale Anzahl an Zeichen',
	'linkfilter-description-left' => 'Noch $1',
	'linkfilter-popular-articles' => 'Nicht verpassen',
	'linkfilter-new-links-title' => 'Neue Links',
	'linkfilter-time-days' => '{{PLURAL:$1|ein Tag|$1 Tage}}',
	'linkfilter-time-hours' => '{{PLURAL:$1|eine Stunde|$1 Stunden}}',
	'linkfilter-time-minutes' => '{{PLURAL:$1|eine Minute|$1 Minuten}}',
	'linkfilter-time-seconds' => '{{PLURAL:$1|eine Sekunde|$1 Sekunden}}',
	'linkfilter-edit-summary' => 'neuer Link',
	'linkfilter-no-results' => 'Es wurden keine Seiten gefunden.',
	'linkfilter-feed-title' => 'Links bei {{SITENAME}}',
	'group-linkadmin' => 'Linkadministratoren',
	'group-linkadmin-member' => 'Linkadministrator',
	'grouppage-linkadmin' => '{{ns:project}}:Linkadminstrator',
	'right-linkadmin' => 'Von Benutzern eingereichte Links verwalten',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'linkfilter-login-title' => 'Sie sind nicht angemeldet.',
	'linkfilter-login-text' => 'Sie müssen angemeldet zu sein, um Links einreichen zu können.',
	'linkfilter-instructions' => 'Sie können [[{{MediaWiki:Linkfilter-instructions-url}}|eine Anleitung für andere Benutzer hinzufügen]].',
	'linkfilter-admin-instructions' => 'Sie können [[{{MediaWiki:Linkfilter-admin-instructions-url}}|eine Anleitung für andere Administratoren hinzufügen]].',
);

/** Finnish (Suomi)
 * @author Jack Phoenix <jack@countervandalism.net>
 */
$messages['fi'] = array(
	'linkapprove' => 'Linkkien ylläpito',
	'linkshome' => 'Linkkien kotisivu',
	'linksubmit' => 'Lähetä linkki',
	'linkfilter-nothing-to-approve' => 'Tällä hetkellä ei ole yhtään linkkiä odottamassa hyväksyntää.',
	'linkfilter-ago' => '$1 sitten luokkaan "<i>$2</i>"',
	'linkfilter-all' => 'Kaikki',
	'linkfilter-submit' => 'Lähetä',
	'linkfilter-submit-title' => 'Lähetä linkki',
	'linkfilter-submit-no-title' => 'Ole hyvä ja anna otsikko',
	'linkfilter-submit-no-type' => 'Hei, valitse linkin tyyppi!',
	'linkfilter-edit-title' => 'Muokkaa $1',
	'linkfilter-approve-links' => 'Hyväksy linkkejä',
	'linkfilter-submit-another' => 'Lähetä toinen linkki',
	'linkfilter-login-title' => 'Et ole kirjautunut sisään',
	'linkfilter-login-text' => 'Sinun tulee olla kirjautuneena sisään voidaksesi lähettää linkkejä.',
	'linkfilter-url' => 'URL',
	'linkfilter-title' => 'Otsikko',
	'linkfilter-type' => 'Linkin tyyppi',
	'linkfilter-description' => 'Kuvaus',
	'linkfilter-submit-button' => 'Lähetä linkki',
	'linkfilter-home-button' => 'Linkkien kotisivu',
	'linkfilter-submit-success-title' => 'Linkki lähetetty',
	'linkfilter-submit-success-text' => 'Linkkisi on lähetetty hyväksyntää odottamaan',
	'linkfilter-instructions' => 'Voit lisätä ohjeita käyttäjille [[MediaWiki:Linkfilter-instructions|täällä]]',
	'linkfilter-admin-instructions' => 'Voit lisätä ohjeita ylläpitäjille [[MediaWiki:Linkfilter-admin-instructions|täällä]]',
	'linkfilter-admin-recent' => 'Äskettäin hyväksytyt',
	'linkfilter-approve-title' => 'Linkkien ylläpito',
	'linkfilter-submittedby' => 'Lähettänyt',
	'linkfilter-submitted' => 'Lähetetty $1',
	'linkfilter-admin-accept' => 'Hyväksy',
	'linkfilter-admin-reject' => 'Hylkää',
	'linkfilter-admin-reject-success' => 'Linkki hylättiin',
	'linkfilter-admin-accept-success' => 'Linkki hyväksyttiin',
	'linkfilter-in-the-news' => 'Uutisissa',
	'linkfilter-about-submitter' => 'Tietoja lähettäjästä',
	'linkfilter-anonymous' => 'Anonyymi fanaatikko',
	'linkfilter-comments-of-day' => 'Huippukommentit',
	'linkfilter-comments' => '{{PLURAL:$1|yksi kommentti|$1 kommenttia}}',
	'linkfilter-home-title' => 'Linkit aiheesta $1',
	'linkfilter-home-title-all' => 'Kaikki linkit',
	'linkfilter-next' => 'seuraava',
	'linkfilter-previous' => 'edellinen',
	'linkfilter-description-max' => 'Merkkien maksimimäärä',
	'linkfilter-description-left' => '$1 jäljellä',
	'linkfilter-popular-articles' => 'Älä unohda',
	'linkfilter-new-links-title' => 'Uudet linkit',
	'linkfilter-time-days' => '{{PLURAL:$1|yksi päivä|$1 päivää}}',
	'linkfilter-time-hours' => '{{PLURAL:$1|yksi tunti|$1 tuntia}}',
	'linkfilter-time-minutes' => '{{PLURAL:$1|yksi minuutti|$1 minuuttia}}',
	'linkfilter-time-seconds' => '{{PLURAL:$1|yksi sekunti|$1 sekuntia}}',
	'linkfilter-edit-summary' => 'uusi linkki',
	'linkfilter-no-results' => 'Sivuja ei löytynyt.',
	'linkfilter-feed-title' => '{{GRAMMAR:genitive|{{SITENAME}}}} linkit',
	'group-linkadmin' => 'Linkkien ylläpitäjät',
	'group-linkadmin-member' => 'Linkkien ylläpitäjä',
	'right-linkadmin' => 'Hallinnoida käyttäjien lähettämiä linkkejä',
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'linkfilter-admin-accept' => 'Accèptar',
	'linkfilter-admin-reject' => 'Refusar',
	'linkfilter-comments' => '$1 comentèro{{PLURAL:$1||s}}',
	'linkfilter-home-title-all' => 'Tôs los lims',
	'linkfilter-next' => 'aprés',
	'linkfilter-previous' => 'devant',
	'linkfilter-new-links-title' => 'Lims novéls',
	'linkfilter-time-days' => '$1 jorn{{PLURAL:$1||s}}',
	'linkfilter-time-hours' => '$1 hor{{PLURAL:$1|a|es}}',
	'linkfilter-time-minutes' => '$1 menut{{PLURAL:$1|a|es}}',
	'linkfilter-time-seconds' => '$1 second{{PLURAL:$1|a|es}}',
	'linkfilter-edit-summary' => 'lim novél',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'linkfilter-all' => 'Todos',
	'linkfilter-submit' => 'Enviar',
	'linkfilter-submit-no-title' => 'Escriba un título',
	'linkfilter-edit-title' => 'Editar "$1"',
	'linkfilter-login-title' => 'Non accedeu ao sistema',
	'linkfilter-login-text' => 'Debe acceder ao sistema para enviar ligazóns.',
	'linkfilter-title' => 'Título',
	'linkfilter-type' => 'Tipo de ligazón',
	'linkfilter-description' => 'Descrición',
	'linkfilter-approve-title' => 'Administración das ligazóns',
	'linkfilter-admin-accept' => 'Aceptar',
	'linkfilter-admin-reject' => 'Rexeitar',
	'linkfilter-in-the-news' => 'Actualidade',
	'linkfilter-comments' => '{{PLURAL:$1|$1 comentario|$1 comentarios}}',
	'linkfilter-home-title' => '$1 ligazóns',
	'linkfilter-home-title-all' => 'Todas as ligazóns',
	'linkfilter-next' => 'seguinte',
	'linkfilter-previous' => 'anterior',
	'linkfilter-description-max' => 'Número máximo de caracteres',
	'linkfilter-description-left' => '$1 restantes',
	'linkfilter-new-links-title' => 'Novas ligazóns',
	'linkfilter-time-days' => '{{PLURAL:$1|un día|$1 días}}',
	'linkfilter-time-hours' => '{{PLURAL:$1|unha hora|$1 horas}}',
	'linkfilter-time-minutes' => '{{PLURAL:$1|un minuto|$1 minutos}}',
	'linkfilter-time-seconds' => '{{PLURAL:$1|un segundo|$1 segundos}}',
	'linkfilter-edit-summary' => 'nova ligazón',
	'linkfilter-no-results' => 'Non se atopou ningunha páxina.',
	'group-linkadmin' => 'Administradores das ligazóns',
	'group-linkadmin-member' => 'administrador das ligazóns',
	'grouppage-linkadmin' => '{{ns:project}}:Administradores das ligazóns',
	'right-linkadmin' => 'Administrar as ligazóns enviadas polos usuarios',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'linkapprove' => 'Approbar ligamines',
	'linkshome' => 'Initio de ligamines',
	'linksubmit' => 'Submitter un ligamine',
	'linkfilter-desc' => 'Adde nove paginas special e extende le analysator syntactic pro submission/approbation/rejection de ligamines',
	'linkfilter-nothing-to-approve' => 'Il non ha actualmente ligamines attendente approbation.',
	'linkfilter-no-recently-approved' => 'Nulle ligamine ha essite approbate recentemente.',
	'linkfilter-no-links-at-all' => 'Nulle ligamine ha ancora essite submittite o le administratores de ligamines non ha ancora revidite le ligamines submittite.',
	'linkfilter-ago' => '$1 retro sub <i>$2</i>',
	'linkfilter-all' => 'Totes',
	'linkfilter-submit' => 'Submitter',
	'linkfilter-submit-title' => 'Submitter un ligamine',
	'linkfilter-submit-no-title' => 'Per favor entra un titulo',
	'linkfilter-submit-no-type' => 'Selige un typo de ligamine.',
	'linkfilter-edit-title' => 'Modificar $1',
	'linkfilter-approve-links' => 'Approbar ligamines',
	'linkfilter-submit-another' => 'Submitter un altere ligamine',
	'linkfilter-login-title' => 'Non identificate',
	'linkfilter-login-text' => 'Es necessari aperir session pro submitter ligamines.',
	'linkfilter-title' => 'Titulo',
	'linkfilter-type' => 'Typo de ligamine',
	'linkfilter-description' => 'Description',
	'linkfilter-submit-button' => 'Submitter ligamine',
	'linkfilter-home-button' => 'Initio de ligamines',
	'linkfilter-submit-success-title' => 'Ligamine submittite',
	'linkfilter-submit-success-text' => 'Tu ligamine ha essite inviate pro approbation',
	'linkfilter-instructions-url' => 'Instructiones pro filtro de ligamines',
	'linkfilter-instructions' => 'Tu pote [[{{MediaWiki:Linkfilter-instructions-url}}|adder instructiones pro usatores]].',
	'linkfilter-admin-instructions-url' => 'Instructiones pro administration de ligamines',
	'linkfilter-admin-instructions' => 'Tu pote adder [[{{MediaWiki:Linkfilter-admin-instructions-url}}|instructiones pro administratores]].',
	'linkfilter-admin-recent' => 'Recentemente approbate',
	'linkfilter-approve-title' => 'Administration de ligamines',
	'linkfilter-submittedby' => 'Submittite per',
	'linkfilter-submitted' => '$1 submittite',
	'linkfilter-admin-accept' => 'Acceptar',
	'linkfilter-admin-reject' => 'Rejectar',
	'linkfilter-admin-reject-success' => 'Le ligamine ha essite rejectate',
	'linkfilter-admin-accept-success' => 'Le ligamine ha essite acceptate',
	'linkfilter-in-the-news' => 'Actualitates',
	'linkfilter-about-submitter' => 'A proposito del submissor',
	'linkfilter-anonymous' => 'Fanatico anonyme',
	'linkfilter-comments-of-day' => 'Principal commentos',
	'linkfilter-comments' => '{{PLURAL:$1|$1 commento|$1 commentos}}',
	'linkfilter-home-title' => '$1 ligamines',
	'linkfilter-home-title-all' => 'Tote le ligamines',
	'linkfilter-next' => 'sequente',
	'linkfilter-previous' => 'precedente',
	'linkfilter-description-max' => 'Maximo de characteres',
	'linkfilter-description-left' => '$1 restante',
	'linkfilter-popular-articles' => 'Non mancar a',
	'linkfilter-new-links-title' => 'Nove ligamines',
	'linkfilter-time-days' => '{{PLURAL:$1|un die|$1 dies}}',
	'linkfilter-time-hours' => '{{PLURAL:$1|un hora|$1 horas}}',
	'linkfilter-time-minutes' => '{{PLURAL:$1|un minuta|$1 minutas}}',
	'linkfilter-time-seconds' => '{{PLURAL:$1|un secunda|$1 secundas}}',
	'linkfilter-edit-summary' => 'nove ligamine',
	'linkfilter-no-results' => 'Nulle pagina trovate.',
	'linkfilter-feed-title' => 'Ligamines de {{SITENAME}}',
	'group-linkadmin' => 'Administratores de ligamines',
	'group-linkadmin-member' => 'administrator de ligamines',
	'grouppage-linkadmin' => '{{ns:project}}:Administratores de ligamines',
	'right-linkadmin' => 'Administrar ligamines submittite per usatores',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'linkapprove' => 'Linken akzeptéieren',
	'linkshome' => 'Haaptsäit vun de Linken',
	'linksubmit' => 'E Link proposéieren',
	'linkfilter-desc' => 'Setzt eng nei Spezialsäit an e Parser-Hook derbäi fir Linken ze proposéieren/akzeptéieren/refuséieren.',
	'linkfilter-nothing-to-approve' => 'Et gëtt elo keng linken déi dorop waarde fir akzeptéiert ze ginn.',
	'linkfilter-no-recently-approved' => 'Rezent goufe keng Linken akzeptéiert.',
	'linkfilter-no-links-at-all' => "Et goufen entweder nach keng Linke proposéiert oder d'Link-Administrateuren hunn déi proposéiert Linken nach net nogekuckt.",
	'linkfilter-ago' => 'Viru(n) $1 ënner <i>$2</i>',
	'linkfilter-all' => 'All',
	'linkfilter-submit' => 'Späicheren',
	'linkfilter-submit-title' => 'E Link proposéieren',
	'linkfilter-submit-no-title' => 'Gitt w.e.g. en Titel un',
	'linkfilter-submit-no-type' => 'En Typ vu Link eraussichen.',
	'linkfilter-edit-title' => '$1 änneren',
	'linkfilter-approve-links' => 'Linken akzeptéieren',
	'linkfilter-submit-another' => 'Nach ee Link proposéieren',
	'linkfilter-login-title' => 'Net ageloggt',
	'linkfilter-login-text' => 'Dir musst ageloggt si fir Linken ze proposéieren.',
	'linkfilter-title' => 'Titel',
	'linkfilter-type' => 'Typ vu Link',
	'linkfilter-description' => 'Beschreiwung',
	'linkfilter-submit-button' => 'Link proposéieren',
	'linkfilter-home-button' => 'Haaptsäit vun de Linken',
	'linkfilter-submit-success-title' => 'De Link ass elo proposéiert',
	'linkfilter-submit-success-text' => "Äre Link gouf weiderginn un d'Administrateure fir akzeptéiert ze ginn",
	'linkfilter-instructions-url' => 'Instruktioune fir de Linkfilter',
	'linkfilter-instructions' => "Dir kënnt [[{{MediaWiki:Linkfilter-instructions-url}}|Instruktioune fir d'Benotzer]] derbäisetzen.",
	'linkfilter-admin-instructions-url' => "Instruktioune fir d'Gestioun vum Linkfilter",
	'linkfilter-admin-instructions' => "Dir kënnt [[{{MediaWiki:Linkfilter-admin-instructions-url}}|Instruktioune fir d'Aadministrateuren]] derbäisetzen.",
	'linkfilter-admin-recent' => 'Rezent akzeptéiert',
	'linkfilter-approve-title' => 'Gestioun vun de Linken',
	'linkfilter-submittedby' => 'Proposéiert vum',
	'linkfilter-submitted' => '$1 gespäichert',
	'linkfilter-admin-accept' => 'Akzeptéieren',
	'linkfilter-admin-reject' => 'Refuséieren',
	'linkfilter-admin-reject-success' => 'De Link gouf refuséiert',
	'linkfilter-admin-accept-success' => 'De Link gouf akzeptéiert',
	'linkfilter-in-the-news' => 'An den Neiegkeeten',
	'linkfilter-about-submitter' => 'Iwwer deen deen de Link proposéiert huet',
	'linkfilter-anonymous' => 'Anonymen Unhänger',
	'linkfilter-comments-of-day' => 'Beléifste Bemierkungen',
	'linkfilter-comments' => '{{PLURAL:$1|eng Bemierkung|$1 Bemierkungen}}',
	'linkfilter-home-title' => 'Linken $1',
	'linkfilter-home-title-all' => 'All Linken',
	'linkfilter-next' => 'nächsten',
	'linkfilter-previous' => 'vireg',
	'linkfilter-description-max' => 'Maximal Zuel vun Zeechen',
	'linkfilter-description-left' => '$1 iwwreg',
	'linkfilter-popular-articles' => 'Net verpassen',
	'linkfilter-new-links-title' => 'Nei Linken',
	'linkfilter-time-days' => '{{PLURAL:$1|een Dag|$1 Deeg}}',
	'linkfilter-time-hours' => '{{PLURAL:$1|eng Stonn|$1 Stonnen}}',
	'linkfilter-time-minutes' => '{{PLURAL:$1|eng Minutt|$1 Minutten}}',
	'linkfilter-time-seconds' => '{{PLURAL:$1|eng Sekonn|$1 Sekonnen}}',
	'linkfilter-edit-summary' => 'neie Link',
	'linkfilter-no-results' => 'Keng Säite fonnt.',
	'linkfilter-feed-title' => '{{SITENAME}}-Linken',
	'group-linkadmin' => 'Link-Administrateuren',
	'group-linkadmin-member' => 'Link-Administrateur',
	'grouppage-linkadmin' => '{{ns:project}}:Link-Administrateuren',
	'right-linkadmin' => 'Gestioun vun de Linken déi vun de Benotzer proposéiert goufen',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'linkapprove' => 'Одобри врски',
	'linkshome' => 'Врски — Почетна',
	'linksubmit' => 'Поднеси врска',
	'linkfilter-desc' => 'Додава нови специјални страници и парсерска кука за поднесување/одобрување/одбивање на врски',
	'linkfilter-nothing-to-approve' => 'Моментално нема врски што чекаат на одобрение.',
	'linkfilter-no-recently-approved' => 'Нема неодамна одобрени врски.',
	'linkfilter-no-links-at-all' => 'Досега никој нема поднесено врски или администраторите сè уште ги немаат прегледано поднесените врски.',
	'linkfilter-ago' => 'Пред $1 под <i>$2</i>',
	'linkfilter-all' => 'Сите',
	'linkfilter-submit' => 'Поднеси',
	'linkfilter-submit-title' => 'Поднесување на врска',
	'linkfilter-submit-no-title' => 'Внесете наслов',
	'linkfilter-submit-no-type' => 'Одберете тип на врска.',
	'linkfilter-edit-title' => 'Уредување на $1',
	'linkfilter-approve-links' => 'Одобри врски',
	'linkfilter-submit-another' => 'Поднеси друга врска',
	'linkfilter-login-title' => 'Не сте најавени',
	'linkfilter-login-text' => 'Мора да сте најавени за да можете да поднесувате врски.',
	'linkfilter-url' => 'URL',
	'linkfilter-title' => 'Наслов',
	'linkfilter-type' => 'Тип на врска',
	'linkfilter-description' => 'Опис',
	'linkfilter-submit-button' => 'Поднеси',
	'linkfilter-home-button' => 'Врски — Почетна',
	'linkfilter-submit-success-title' => 'Врската е поднесена',
	'linkfilter-submit-success-text' => 'Врските се испратени на разгледување',
	'linkfilter-instructions-url' => 'ФилтерНаВрски-напатствија',
	'linkfilter-instructions' => 'Можете да [[{{MediaWiki:Linkfilter-instructions-url}}|додадете напатствија за корисниците]].',
	'linkfilter-admin-instructions-url' => 'ФилтерНаВрски-напатствија-администратори',
	'linkfilter-admin-instructions' => 'Можете да додадете [[{{MediaWiki:Linkfilter-admin-instructions-url}}|напатствија за администраторите]].',
	'linkfilter-admin-recent' => 'Неодамна одобрени',
	'linkfilter-approve-title' => 'Администрација на врски',
	'linkfilter-submittedby' => 'Поднел',
	'linkfilter-submitted' => 'Поднесено $1',
	'linkfilter-admin-accept' => 'Прифати',
	'linkfilter-admin-reject' => 'Одбиј',
	'linkfilter-admin-reject-success' => 'Врската е одбиена',
	'linkfilter-admin-accept-success' => 'Врската е прифатена',
	'linkfilter-in-the-news' => 'Вести',
	'linkfilter-about-submitter' => 'За поднесувачот',
	'linkfilter-anonymous' => 'Анонимен фанатик',
	'linkfilter-comments-of-day' => 'Најчитани коментари',
	'linkfilter-comments' => '{{PLURAL:$1|$1 коментар|$1 коментари}}',
	'linkfilter-home-title' => '$1 врски',
	'linkfilter-home-title-all' => 'Сите врски',
	'linkfilter-next' => 'следна',
	'linkfilter-previous' => 'претходна',
	'linkfilter-description-max' => 'Макс. знаци',
	'linkfilter-description-left' => '{{PLURAL:$1|преостанува $1|преостануваат $1}}',
	'linkfilter-popular-articles' => 'Не пропуштајте',
	'linkfilter-new-links-title' => 'Нови врски',
	'linkfilter-time-days' => '{{PLURAL:$1|еден ден|$1 дена}}',
	'linkfilter-time-hours' => '{{PLURAL:$1|еден часr|$1 часа}}',
	'linkfilter-time-minutes' => '{{PLURAL:$1|една минута|$1 минути}}',
	'linkfilter-time-seconds' => '{{PLURAL:$1|една секунда|$1 секунди}}',
	'linkfilter-edit-summary' => 'нова врска',
	'linkfilter-no-results' => 'Нема пронајдено ниедна страница.',
	'linkfilter-feed-title' => 'Врски на {{SITENAME}}',
	'group-linkadmin' => 'Администратори на врски',
	'group-linkadmin-member' => 'администратор на врски',
	'grouppage-linkadmin' => '{{ns:project}}:Администратори на врски',
	'right-linkadmin' => 'Администрација на врски поднесени од корисници',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 */
$messages['nl'] = array(
	'linkfilter-ago' => '$1 geleden onder <i>$2</i>',
	'linkfilter-edit-title' => '$1 bewerken',
	'linkfilter-login-title' => 'Niet aangemeld',
	'linkfilter-title' => 'Titel',
	'linkfilter-description' => 'Beschrijving',
	'linkfilter-admin-accept' => 'Aanvaarden',
	'linkfilter-admin-reject' => 'Afwijzen',
	'linkfilter-admin-reject-success' => 'De koppeling is afgewezen',
	'linkfilter-admin-accept-success' => 'De koppeling is aanvaard',
	'linkfilter-in-the-news' => 'Actueel',
	'linkfilter-comments' => '{{PLURAL:$1|$1 opmerking|$1 opmerkingen}}',
	'linkfilter-home-title' => '$1 verwijzingen',
	'linkfilter-home-title-all' => 'Alle verwijzingen',
	'linkfilter-next' => 'volgende',
	'linkfilter-previous' => 'vorige',
	'linkfilter-description-max' => 'Maximum aantal tekens',
	'linkfilter-new-links-title' => 'Nieuwe verwijzingen',
	'linkfilter-time-days' => '{{PLURAL:$1|één dag|$1 dagen}}',
	'linkfilter-time-hours' => '{{PLURAL:$1|één uur|$1 uur}}',
	'linkfilter-time-minutes' => '{{PLURAL:$1|minuut|$1 minuten}}',
	'linkfilter-time-seconds' => '{{PLURAL:$1|één seconde|$1 seconden}}',
	'linkfilter-edit-summary' => 'nieuwe verwijzing',
	'linkfilter-no-results' => "Geen pagina's gevonden.",
);

