<?php

/**
 * Internationalisation file for the GiveRollback extension
 *
 * @addtogroup Extensions
 * @author Rob Church <robchur@gmail.com>
 * @copyright © 2006 Rob Church
 * @licence GNU General Public Licence 2.0 or later
 */

function efGiveRollbackMessages() {
	$messages = array(
	
/* English (Rob Church) */
'en' => array(
'giverollback' => 'Grant or revoke rollback rights',
'giverollback-header' => "'''A local bureaucrat can use this page to grant or revoke [[Help:Rollback|rollback rights]] to another user account.'''<br />This can be used to allow non-sysops to revert vandalism quickly. This should be done in accordance with applicable policies.",
'giverollback-username' => 'Username:',
'giverollback-search' => 'Go',
'giverollback-hasrb' => '[[User:$1|$1]] has rollback rights.',
'giverollback-norb' => '[[User:$1|$1]] does not have rollback rights.',
'giverollback-toonew' => '[[User:$1|$1]] is too new, and cannot be given rollback rights.',
'giverollback-sysop' => '[[User:$1|$1]] is a sysop, and already has rollback permissions.',
'giverollback-change' => 'Change status:',
'giverollback-grant' => 'Grant',
'giverollback-revoke' => 'Revoke',
'giverollback-comment' => 'Comment:',
'giverollback-granted' => '[[User:$1|$1]] now has rollback rights.',
'giverollback-revoked' => '[[User:$1|$1]] no longer has rollback rights.',
'giverollback-logpage' => 'Rollback rights log',
'giverollback-logpagetext' => 'This is a log of changes to non-sysops\' [[Help:Rollback|rollback]] rights.',
'giverollback-logentrygrant' => 'granted rollback rights to [[$1]]',
'giverollback-logentryrevoke' => 'removed rollback rights from [[$1]]',
),

'ar' => array(
'giverollback' => 'منح أو سحب صلاحيات الاسترجاع',
'giverollback-username' => 'اسم المستخدم:',
'giverollback-search' => 'اذهب',
'giverollback-hasrb' => '[[User:$1|$1]] لديه صلاحيات استرجاع.',
'giverollback-norb' => '[[User:$1|$1]] ليس لديه صلاحيات استرجاع.',
'giverollback-toonew' => '[[User:$1|$1]] جديد جدا، ولا يمكن إعطاؤه صلاحيات استرجاع.',
'giverollback-sysop' => '[[User:$1|$1]] إداري، ولديه بالفعل سماحات استرجاع.',
'giverollback-change' => 'غير الحالة:',
'giverollback-grant' => 'منح',
'giverollback-revoke' => 'سحب',
'giverollback-comment' => 'تعليق:',
'giverollback-granted' => '[[User:$1|$1]] لديه الآن صلاحيات استرجاع.',
'giverollback-revoked' => '[[User:$1|$1]] لم يعد لديه صلاحيات استرجاع.',
'giverollback-logpage' => 'سجل صلاحيات الاسترجاع',
'giverollback-logentrygrant' => 'منح صلاحيات استرجاع إلى [[$1]]',
'giverollback-logentryrevoke' => 'أزال صلاحيات استرجاع من [[$1]]',
),

/* German (Raymond) */
'de' => array(
'giverollback' => 'Zurücksetzen-Recht erteilen oder entziehen',
'giverollback-header' => "'''Ein lokaler Bürokrat kann auf dieser Seite anderen Benutzern das Recht zum Zurücksetzen ''(Rollback)'' erteilen oder entziehen.<br />Dadurch können auch Benutzer ohne Administratoren-Status Vandalismus schnell rückgängig machen. Dies sollte in Übereinstimmung mit den anwendbaren Richtlinien geschehen.",
'giverollback-username' => 'Benutzername:',
'giverollback-search' => 'Ok',
'giverollback-hasrb' => '[[User:$1|$1]] hat das Zurücksetzen-Recht.',
'giverollback-norb' => '[[User:$1|$1]] hat das Zurücksetzen-Recht nicht.',
'giverollback-toonew' => '[[User:$1|$1]] ist zu neu, ihm kann das Zurücksetzen-Recht nicht gegeben werden.',
'giverollback-sysop' => '[[User:$1|$1]] ist ein Administrator und hat bereits das Zurücksetzen-Recht.',
'giverollback-change' => 'Ändere den Status:',
'giverollback-grant' => 'Erteile',
'giverollback-revoke' => 'Entziehe',
'giverollback-comment' => 'Kommentar:',
'giverollback-granted' => '[[User:$1|$1]] wurde das Zurücksetzen-Recht erteilt.',
'giverollback-revoked' => '[[User:$1|$1]] wurde das Zurücksetzen-Recht entzogen.',
'giverollback-logpage' => 'Zurücksetzen-Rechte Logbuch',
'giverollback-logpagetext' => 'Dies ist das Logbuch der Zurücksetzen-Rechtevergabe für Nicht-Administratoren.',
'giverollback-logentrygrant' => 'erteilte das Zurücksetzen-Recht an [[$1]]',
'giverollback-logentryrevoke' => 'entzog das Zurücksetzen-Recht von [[$1]]',
),

'ext' => array(
'giverollback-username' => 'Nombri el usuáriu:',
'giverollback-search' => 'Dil',
'giverollback-change' => 'Chambal estau:',
),

/* French */
'fr' => array(
'giverollback' => 'Donner ou enlever les droits de révocation',
'giverollback-header' => "'''Un bureaucrate local peut utiliser cette page pour donner ou enlever les droits de révocation (« revert ») à un compte utilisateur.'''<br />
On peut l’utiliser pour autoriser des non-administrateurs à révoquer des vandalismes plus rapidement. Les bureaucrates ne devraient le faire qu’en accord avec les règles en vigueur.",
'giverollback-username' => 'Nom d’utilisateur :',
'giverollback-search' => 'Chercher',
'giverollback-hasrb' => '[[User:$1|$1]] a les droits de révocation.',
'giverollback-norb' => '[[User:$1|$1]] n’a pas les droits de révocation.',
'giverollback-toonew' => '[[User:$1|$1]] est trop récent, et ne peut pas recevoir les droits de révocation.',
'giverollback-sysop' => '[[User:$1|$1]] est un administrateur, et peut déjà révoquer les articles.',
'giverollback-change' => 'Changer le statut :',
'giverollback-grant' => 'Donner',
'giverollback-revoke' => 'Enlever',
'giverollback-comment' => 'Commentaire :',
'giverollback-granted' => '[[User:$1|$1]] possède maintenant les droits de révocation.',
'giverollback-revoked' => '[[User:$1|$1]] ne possède plus les droits de révocation.',
'giverollback-logpage' => 'Historique des droits de révocation',
'giverollback-logpagetext' => 'Cette page présente un journal du changement des droits de révocation.',
'giverollback-logentrygrant' => 'a donné les droits de révocation à [[$1]]',
'giverollback-logentryrevoke' => 'a enlevé les droits de révocation de [[$1]]',
),
	
'hsb' => array(
'giverollback' => 'Prawa wróćostajenja dać abo zebrać',
'giverollback-header' => '\'\'\'Lokalny běrokrat móže stronu wužiwać, zo by druhim wužiwarjam prawo wróćostajenja \'\'(rollback)\'\' dał abo zebrał.\'\'\'<br /> Tak móža tež wužiwarjo bjez prawow administratora wandalizm spěšnje wróćo stajić. To měło so w přezjednosći z nałožujomnymi prawidłami stać.',
'giverollback-username' => 'Wužiwarske mjeno:',
'giverollback-search' => 'Pytać',
'giverollback-hasrb' => '[[User:$1|$1]] ma prawo wróćostajenja.',
'giverollback-norb' => '[[User:$1|$1]] nima prawo wróćostajenja.',
'giverollback-toonew' => '[[User:$1|$1]] je přenowy, njemóže prawo wróćostajenja dóstać.',
'giverollback-sysop' => '[[User:$1|$1]] je administrator a ma hižo prawo wróćostajenja.',
'giverollback-change' => 'Status změnić:',
'giverollback-grant' => 'Dowolić',
'giverollback-revoke' => 'Wotwołać',
'giverollback-comment' => 'Komentar:',
'giverollback-granted' => '[[User:$1|$1]] ma nětko prawo wróćostajenja.',
'giverollback-revoked' => '[[User:$1|$1]] hižo nima prawo wróćostajenja.',
'giverollback-logpage' => 'Protokol wo prawach wróćostajenja',
'giverollback-logpagetext' => 'Tuto je protokol wo změnach prawow wróćostajenja za njeadministratorow.',
'giverollback-logentrygrant' => 'je wužiwarjej [[$1]] prawo wróćostajenja dał',
'giverollback-logentryrevoke' => 'je wužiwarjej [[$1]] prawo wróćostajenja zebrał',
),

/* Italian (BrokenArrow) */
'it' => array(
'giverollback' => 'Assegna o revoca il diritto di rollback',
'giverollback-header' => "'''Questa pagina consente ai burocrati di assegnare o revocare il diritto di [[{{ns:Help}}:Rollback|rollback]] a un'altra utenza.'''<br /> Questa funzione consente di annullare i vandalismi in modo rapido anche a chi non è amministratore. Tale operazione dev'essere effettuata in conformità con le policy del sito.",
'giverollback-username' => 'Nome utente:',
'giverollback-search' => 'Vai',
'giverollback-hasrb' => 'L\'utente [[{{ns:user}}:$1|$1]] ha il diritto di rollback.',
'giverollback-norb' => 'L\'utente [[{{ns:user}}:$1|$1]] non ha il diritto di rollback.',
'giverollback-toonew' => '[[{{ns:user}}:$1|$1]] è un nuovo utente e non può ricevere il diritto di rollback.',
'giverollback-sysop' => '[[User:$1|$1]] è un amministratore e possiede già il diritto di rollback.',
'giverollback-change' => 'Modifica lo status:',
'giverollback-grant' => 'Concedi',
'giverollback-revoke' => 'Revoca',
'giverollback-comment' => 'Commento:',
'giverollback-granted' => 'L\'utente [[{{ns:user}}:$1|$1]] ha ora il diritto di rollback.',
'giverollback-revoked' => 'L\'utente [[{{ns:user}}:$1|$1]] non ha più il diritto di rollback.',
'giverollback-logpage' => 'Registro dei diritti di rollback',
'giverollback-logpagetext' => 'Qui di seguito viene riportata la lista delle modifiche al diritto di [[{{ns:Help}}:Rollback|rollback]] per gli utenti non amministratori.',
'giverollback-logentrygrant' => 'ha concesso il diritto di rollback a [[$1]]',
'giverollback-logentryrevoke' => 'ha revocato il diritto di rollback a [[$1]]',
),

'la' => array(
'giverollback-username' => 'Nomen usoris:',
'giverollback-search' => 'Ire',
'giverollback-grant' => 'Licere',
'giverollback-revoke' => 'Revocare',
'giverollback-comment' => 'Summarium:',
'giverollback-granted' => '[[User:$1|$1]] nunc habet iures \'\'rollback\'\'.',
),

/* nld / Dutch (Siebrand Mazeland) */
'nl' => array(
'giverollback' => 'Terugdraairechten beheren',
'giverollback-header' => "'''Een lokale bureaucraat kan deze pagina gebruiken om [[Help:Terugdraaien|terugdraairechten]] voor een gebruiker in te stellen of te verwijderen.'''<br />Dit kan gebruikt worden om gebruikers die geen beheerder zijn snel vandalisme terug te laten draaien. Dit hoort uiteraard te gebeuren in overeenstemming met het geldende beleid.",
'giverollback-username' => 'Gebruiker:',
'giverollback-search' => 'OK',
'giverollback-hasrb' => '[[User:$1|$1]] heeft terugdraairechten.',
'giverollback-norb' => '[[User:$1|$1]] heeft geen terugdraairechten.',
'giverollback-toonew' => '[[User:$1|$1]] is te nieuw en kan geen terugdraairechten krijgen.',
'giverollback-sysop' => '[[User:$1|$1]] is beheerder en heeft al terugdraairechten.',
'giverollback-change' => 'Wijzig status:',
'giverollback-grant' => 'Toestaan',
'giverollback-revoke' => 'Intrekken',
'giverollback-comment' => 'Opmerking:',
'giverollback-granted' => '[[User:$1|$1]] heeft nu terugdraairechten.',
'giverollback-revoked' => '[[User:$1|$1]] heeft geen terugdraairechten meer.',
'giverollback-logpage' => 'Terugdraairechtenlogboek',
'giverollback-logpagetext' => 'Dit is een logboek van de wijzigingen ten aanzien van \' [[Help:Terugdraaien|terugdraairechten]] voor gebruikers die geen beheerder zijn.',
'giverollback-logentrygrant' => 'heeft terugdraairechten gegeven aan [[$1]]',
'giverollback-logentryrevoke' => 'heeft terugdraairechten ingetrokken voor [[$1]]',
),

/* Slovak (helix84) */
'sk' => array(
'giverollback' => 'Udeliť alebo odobrať právo rollback',
'giverollback-header' => "'''Miestny byrokrat m§že použiť túto stránku na udelenie alebo odobranie [[Help:Rollback|práva rollback]] inému používateľskému účtu.'''<br />Tak je možné napríklad umožniť používateľom, ktorí nie sú správci rýchlejšie vracať vandalské úpravy. Využívanie tejto stránky by malo prebiehať v súlade s prijatými zásadami.",
'giverollback-username' => 'Používateľské meno:',
'giverollback-search' => 'Choď',
'giverollback-hasrb' => '[[User:$1|$1]] má právo rollback.',
'giverollback-norb' => '[[User:$1|$1]] nemá právo rollback.',
'giverollback-toonew' => '[[User:$1|$1]] je príliš nový a nie je možné mu udeliť právo rollback.',
'giverollback-sysop' => '[[User:$1|$1]] je správca a už má povolenie rollback.',
'giverollback-change' => 'Zmeniť stav:',
'giverollback-grant' => 'Udeliť',
'giverollback-revoke' => 'Odobrať',
'giverollback-comment' => 'Komentár:',
'giverollback-granted' => '[[User:$1|$1]] odteraz má právo rollback.',
'giverollback-revoked' => '[[User:$1|$1]] odteraz nemá právo rollback.',
'giverollback-logpage' => 'Záznam práv rollback',
'giverollback-logpagetext' => 'Toto je záznam zmien práv používateľov, ktorí nie sú správcovia.\' [[Help:Rollback|rollback]] rights.',
'giverollback-logentrygrant' => 'udelené právo rollback používateľovi [[$1]]',
'giverollback-logentryrevoke' => 'odobraté právo rollback používateľovi [[$1]]',
),

/* Serbian default (Sasa Stefanovic) */
'sr' => array(
'giverollback' => 'Додај или одузми права враћања',
'giverollback-header' => "'''Локални бирократа може да користи ову страницу да додели или одузме права враћања другим корисницима.'''<br />Ова права се могу користити како бисте доделили обичним корисницима могућност брзог враћања вандализама. Ово мора да се уради са тренутним правилима пројекта.",
'giverollback-username' => 'Корисник:',
'giverollback-search' => 'Иди',
'giverollback-hasrb' => '[[User:$1|$1]] има права враћања.',
'giverollback-norb' => '[[User:$1|$1]] нема права враћања.',
'giverollback-toonew' => '[[User:$1|$1]] је превише нов, и не могу му се доделити права враћања.',
'giverollback-sysop' => '[[User:$1|$1]] је администратор, и већ има права враћања.',
'giverollback-change' => 'Промени статус:',
'giverollback-grant' => 'Додели',
'giverollback-revoke' => 'Одузми',
'giverollback-comment' => 'Коментар:',
'giverollback-granted' => '[[User:$1|$1]] сад има права враћања.',
'giverollback-revoked' => '[[User:$1|$1]] више нема права враћања.',
'giverollback-logpage' => 'Историја права враћања',
'giverollback-logpagetext' => 'Ово је историја промена обичних корисника са [[Помоћ:Права враћања|правом враћања]] ',
'giverollback-logentrygrant' => 'доделио права враћања кориснику [[$1]]',
'giverollback-logentryrevoke' => 'одузео права враћања кориснику [[$1]]',
),

/* Serbian cyrillic (Sasa Stefanovic) */
'sr-ec' => array(
'giverollback' => 'Додај или одузми права враћања',
'giverollback-header' => "'''Локални бирократа може да користи ову страницу да додели или одузме права враћања другим корисницима.'''<br />Ова права се могу користити како бисте доделили обичним корисницима могућност брзог враћања вандализама. Ово мора да се уради са тренутним правилима пројекта.",
'giverollback-username' => 'Корисник:',
'giverollback-search' => 'Иди',
'giverollback-hasrb' => '[[User:$1|$1]] има права враћања.',
'giverollback-norb' => '[[User:$1|$1]] нема права враћања.',
'giverollback-toonew' => '[[User:$1|$1]] је превише нов, и не могу му се доделити права враћања.',
'giverollback-sysop' => '[[User:$1|$1]] је администратор, и већ има права враћања.',
'giverollback-change' => 'Промени статус:',
'giverollback-grant' => 'Додели',
'giverollback-revoke' => 'Одузми',
'giverollback-comment' => 'Коментар:',
'giverollback-granted' => '[[User:$1|$1]] сад има права враћања.',
'giverollback-revoked' => '[[User:$1|$1]] више нема права враћања.',
'giverollback-logpage' => 'Историја права враћања',
'giverollback-logpagetext' => 'Ово је историја промена обичних корисника са [[Помоћ:Права враћања|правом враћања]] ',
'giverollback-logentrygrant' => 'доделио права враћања кориснику [[$1]]',
'giverollback-logentryrevoke' => 'одузео права враћања кориснику [[$1]]',
),

/* Serbian latin (Sasa Stefanovic) */
'sr-el' => array(
'giverollback' => 'Dodaj ili oduzmi prava vraćanja',
'giverollback-header' => "'''Lokalni birokrata može da koristi ovu stranicu da dodeli ili oduzme prava vraćanja drugim korisnicima.'''<br />Ova prava se mogu koristiti kako biste dodelili običnim korisnicima mogućnost brzog vraćanja vandalizama. Ovo mora da se uradi sa trenutnim pravilima projekta.",
'giverollback-username' => 'Korisnik:',
'giverollback-search' => 'Idi',
'giverollback-hasrb' => '[[User:$1|$1]] ima prava vraćanja.',
'giverollback-norb' => '[[User:$1|$1]] nema prava vraćanja.',
'giverollback-toonew' => '[[User:$1|$1]] je previše nov, i ne mogu mu se dodeliti prava vraćanja.',
'giverollback-sysop' => '[[User:$1|$1]] je administrator, i već ima prava vraćanja.',
'giverollback-change' => 'Promeni status:',
'giverollback-grant' => 'Dodeli',
'giverollback-revoke' => 'Oduzmi',
'giverollback-comment' => 'Komentar:',
'giverollback-granted' => '[[User:$1|$1]] sad ima prava vraćanja.',
'giverollback-revoked' => '[[User:$1|$1]] više nema prava vraćanja.',
'giverollback-logpage' => 'Istorija prava vraćanja',
'giverollback-logpagetext' => 'Ovo je istorija promena običnih korisnika sa [[Pomoć:Prava vraćanja|pravom vraćanja]] ',
'giverollback-logentrygrant' => 'dodelio prava vraćanja korisniku [[$1]]',
'giverollback-logentryrevoke' => 'oduzeo prava vraćanja korisniku [[$1]]',
),

/* Cantonese (Shinjiman) */
'yue' => array(
'giverollback' => '畀或收番一撳還原權限',
'giverollback-header' => "'''一位事務員可以用呢一版去畀或收番呢一個用戶戶口嘅[[Help:一撳還原|一撳還原權限]]。'''<br />呢個係可以容許非操作員可以更加快噉去回復破壞。呢個應該要在合適嘅政策來進行。",
'giverollback-username' => '用戶名:',
'giverollback-search' => '去',
'giverollback-hasrb' => '[[User:$1|$1]] 已經有一撳還原權限。',
'giverollback-norb' => '[[User:$1|$1]] 未有一撳還原權限。',
'giverollback-toonew' => '[[User:$1|$1]] 來得太早喇，唔能夠畀一撳還原權限。',
'giverollback-sysop' => '[[User:$1|$1]] 係一位操作員，已經有一撳還原權限。',
'giverollback-change' => '更改狀態:',
'giverollback-grant' => '畀',
'giverollback-revoke' => '收',
'giverollback-comment' => '註解:',
'giverollback-granted' => '[[User:$1|$1]] 而家有一撳還原權限。',
'giverollback-revoked' => '[[User:$1|$1]] 唔再有一撳還原權限。',
'giverollback-logpage' => '一撳還原權限日誌',
'giverollback-logpagetext' => '呢個係非操作員嘅[[Help:一撳還原|一撳還原]]權限記錄。',
'giverollback-logentrygrant' => '已經畀咗 [[$1]] 嘅一撳還原權限',
'giverollback-logentryrevoke' => '已經收番 [[$1]] 嘅一撳還原權限',
),

/* Chinese (Simplified) (Shinjiman) */
'zh-hans' => array(
'giverollback' => '给予或撤销快速回退权限',
'giverollback-header' => "'''一位本地行政员可以使用这一页来给予或撤销另一位用户的[[Help:快速回退|快速回退权限]]。'''<br />这可容许非操作员快速地回退破坏。这应该要在合适的方针之下进行。",
'giverollback-username' => '用户名称:',
'giverollback-search' => '进入',
'giverollback-hasrb' => '[[User:$1|$1]] 已经拥有快速回退权限。',
'giverollback-norb' => '[[User:$1|$1]] 尚未拥有快速回退权限。',
'giverollback-toonew' => '[[User:$1|$1]] 太新了，不能给予快速回退权限。',
'giverollback-sysop' => '[[User:$1|$1]] 是一位操作员，已经拥有快速回退权限。',
'giverollback-change' => '更改状态:',
'giverollback-grant' => '给予',
'giverollback-revoke' => '撤销',
'giverollback-comment' => '注解:',
'giverollback-granted' => '[[User:$1|$1]] 现在拥有快速回退权限。',
'giverollback-revoked' => '[[User:$1|$1]] 不再拥有快速回退权限。',
'giverollback-logpage' => '快速回退权限日志',
'giverollback-logpagetext' => '这个是非操作员的[[Help:快速回退|快速回退]]权限记录。',
'giverollback-logentrygrant' => '已经给予 [[$1]] 的快速回退权限',
'giverollback-logentryrevoke' => '已经撤销 [[$1]] 的快速回退权限',
),

/* Chinese (Traditional) (Shinjiman) */
'zh-hant' => array(
'giverollback' => '給予或撤銷快速回退權限',
'giverollback-header' => "'''一位本地行政員可以使用這一頁來給予或撤銷另一位用戶的[[Help:快速回退|快速回退權限]]。'''<br />這可容許非操作員快速地回退破壞。這應該要在合適的方針之下進行。",
'giverollback-username' => '用戶名稱:',
'giverollback-search' => '進入',
'giverollback-hasrb' => '[[User:$1|$1]] 已經擁有快速回退權限。',
'giverollback-norb' => '[[User:$1|$1]] 尚未擁有快速回退權限。',
'giverollback-toonew' => '[[User:$1|$1]] 太新了，不能給予快速回退權限。',
'giverollback-sysop' => '[[User:$1|$1]] 是一位操作員，已經擁有快速回退權限。',
'giverollback-change' => '更改狀態:',
'giverollback-grant' => '給予',
'giverollback-revoke' => '撤銷',
'giverollback-comment' => '註解:',
'giverollback-granted' => '[[User:$1|$1]] 現在擁有快速回退權限。',
'giverollback-revoked' => '[[User:$1|$1]] 不再擁有快速回退權限。',
'giverollback-logpage' => '快速回退權限日誌',
'giverollback-logpagetext' => '這個是非操作員的[[Help:快速回退|快速回退]]權限記錄。',
'giverollback-logentrygrant' => '已經給予 [[$1]] 的快速回退權限',
'giverollback-logentryrevoke' => '已經撤銷 [[$1]] 的快速回退權限',
),

	);

	/* Chinese defaults, fallback to zh-hans or zh-hant */
	$messages['zh'] = $messages['zh-hans'];
	$messages['zh-cn'] = $messages['zh-hans'];
	$messages['zh-hk'] = $messages['zh-hant'];
	$messages['zh-tw'] = $messages['zh-hans'];
	$messages['zh-sg'] = $messages['zh-hant'];
	/* Cantonese default, fallback to yue */
	$messages['zh-yue'] = $messages['yue'];

	return $messages;

}




