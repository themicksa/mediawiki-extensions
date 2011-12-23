<?php
/*
	Score, a MediaWiki extension for rendering musical scores with LilyPond.
	Copyright © 2011 Alexander Klauer

	This program is free software: you can redistribute it and/or modify
	it under the terms of the GNU General Public License as published by
	the Free Software Foundation, either version 3 of the License, or
	(at your option) any later version.

	This program is distributed in the hope that it will be useful,
	but WITHOUT ANY WARRANTY; without even the implied warranty of
	MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
	GNU General Public License for more details.

	You should have received a copy of the GNU General Public License
	along with this program.  If not, see <http://www.gnu.org/licenses/>.

	To contact the author:
	<Graf.Zahl@gmx.net>
	http://en.wikisource.org/wiki/User_talk:GrafZahl
	https://github.com/TheCount/score

 */

$messages = array();

/* English */
$messages['en'] = array(
	'score-abc2lynotexecutable' => 'ABC to LilyPond converter could not be executed: $1 is not an executable file. Make sure <code>$wgAbc2Ly</code> is set correctly.',
	'score-abcconversionerr' => 'Unable to convert ABC file to LilyPond format:
$1',
	'score-chdirerr' => 'Unable to change to directory $1',
	'score-cleanerr' => 'Unable to clean out old files before re-rendering',
	'score-compilererr' => 'Unable to compile LilyPond input file:
$1',
	'score-desc' => 'Adds a tag for rendering musical scores with LilyPond',
	'score-getcwderr' => 'Unable to obtain current working directory',
	'score-invalidlang' => 'Invalid score language lang="$1". Currently recognised languages are lang="lilypond" (the default) and lang="ABC".',
	'score-noabcinput' => 'ABC source file $1 could not be created.',
	'score-nooutput' => 'Failed to create LilyPond image directory $1.',
	'score-nofactory' => 'Failed to create LilyPond factory directory.',
	'score-noinput' => 'Failed to create LilyPond input file $1.',
	'score-notexecutable' => 'Could not execute LilyPond: $1 is not an executable file. Make sure <code>$wgLilyPond</code> is set correctly.',
	'score-page' => 'Page $1',
	'score-pregreplaceerr' => 'PCRE regular expression replacement failed',
	'score-readerr' => 'Unable to read file $1.',
	'score-renameerr' => 'Error moving score files to upload directory.',
	'score-trimerr' => 'Image could not be trimmed:
$1
Set <code>$wgScoreTrim=false</code> if this problem persists.',
	'score-versionerr' => 'Unable to obtain LilyPond version:
$1',
);

/** Message documentation (Message documentation) */
$messages['qqq'] = array(
	'score-abc2lynotexecutable' => 'Displayed if the ABC to LilyPond converter could not be executed. $1 is the path to the abc2ly binary.',
	'score-abcconversionerr' => 'Displayed if the ABC to LilyPond conversion failed. $1 is the error (generally big block of text in a pre tag)',
	'score-chdirerr' => 'Displayed if the extension cannot change its working directory. $1 is the path to the target directory.',
	'score-cleanerr' => 'Displayed if an old file cleanup operation fails.',
	'score-compilererr' => 'Displayed if the LilyPond code could not be compiled. $1 is the error (generally big block of text in a pre tag)',
	'score-desc' => '{{desc}}',
	'score-getcwderr' => 'Displayed if the extension cannot obtain the current working directory.',
	'score-invalidlang' => 'Displayed if the lang="…" attribute contains an unrecognised score language. $1 is the unrecognised language.',
	'score-noabcinput' => 'Displayed if an ABC source file could not be created for lang="ABC". $1 is the path to the file that could not be created.',
	'score-nooutput' => 'Displayed if the LilyPond image/midi dir cannot be created. $1 is the name of the directory.',
	'score-nofactory' => 'Displayed if the LilyPond/ImageMagick working directory cannot be created.',
	'score-noinput' => 'Displayed if the LilyPond input file cannot be created. $1 is the path to the input file.',
	'score-notexecutable' => 'Displayed if LilyPond binary cannot be executed. $1 is the path to the LilyPond binary.',
	'score-page' => 'The word "Page" as used in pagination. $1 is the page number',
	'score-pregreplaceerr' => 'Displayed if a PCRE regular expression replacement failed.',
	'score-readerr' => 'Displayed if the extension could not read a file. $1 is the path to the file that could not be read.',
	'score-renameerr' => 'Displayed if moving the resultant files from the working environment to the upload directory fails.',
	'score-trimerr' => 'Displayed if the extension failed to trim an output image. $1 is the error (generally big block of text in a pre tag)',
	'score-versionerr' => 'Displayed if the extension failed to obtain the version string of LilyPond. $1 is the LilyPond stdout output generated by the attempt.',
);

/** Danish (Dansk)
 * @author Peter Alberti
 */
$messages['da'] = array(
	'score-abc2lynotexecutable' => 'Kunne ikke køre programmet til at konvertere fra ABC til LilyPond.',
	'score-abcconversionerr' => 'Kunne ikke konvertere ABC-fil til LilyPond-format:
$1',
	'score-chdirerr' => 'Kunne ikke skifte folder',
	'score-cleanerr' => 'Kunne ikke rense ud i gamle filer før genrendering',
	'score-compilererr' => 'Kunne ikke kompilere inddatafil til LilyPond:
$1',
	'score-desc' => 'Tilføjer et tag til at gengive partiturer ved hjælp af LilyPond',
	'score-getcwderr' => 'Kunne ikke bestemme navnet på den gældende arbejdsfolder',
	'score-invalidlang' => 'Ugyldigt partitursprog angivet. De sprog, der kan genkendes i øjeblikket, er lang="lilypond" (standardværdien) og lang="ABC".',
	'score-noabcinput' => 'Kunne ikke oprette ABC-kildefilen',
	'score-nooutput' => 'Kunne ikke oprette folder til LilyPond-billeder',
	'score-nofactory' => 'Kunne ikke oprette arbejdsfolder til LilyPond',
	'score-noinput' => 'Kunne ikke oprette inddatafil til LilyPond',
	'score-notexecutable' => 'Kunne ikke køre LilyPond. Kontroller at <code>$wgLilyPond</code> er sat korrekt.',
	'score-page' => 'Side $1',
	'score-pregreplaceerr' => 'Erstatning med PCRE regulært udtryk lykkedes ikke',
	'score-readerr' => 'Kunne ikke læse fil',
	'score-renameerr' => 'Der opstod en fejl under flytningen af partiturfiler til folderen for oplægning',
	'score-trimerr' => 'Billedet kunne ikke beskæres. Sæt $wgScoreTrim=false, hvis dette problem fortsætter.',
	'score-versionerr' => 'Kunne ikke bestemme LilyPonds version.',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'score-abc2lynotexecutable' => 'Der Konverter von ABC nach LilyPond konnte nicht ausgeführt werden: $1 ist keine ausführbare Datei. Es muss sichergestellt sein, dass <code>$wgAbc2Ly</code> in der Konfigurationsdatei richtig eingestellt wurde.',
	'score-abcconversionerr' => 'Die ABC-Datei konnte nicht in das LilyPond-Format konvertiert werden:
$1',
	'score-chdirerr' => 'Es konnte nicht zum Verzeichnis $1 gewechselt werden',
	'score-cleanerr' => 'Die alten Dateien konnten vor dem erneuten Rendern nicht bereinigt werden',
	'score-compilererr' => 'Die Eingabedatei von LilyPond konnte nicht kompiliert werden:
$1',
	'score-desc' => 'Ergänzt das Tag <code><score></code>, welches das Rendern und Einbetten von Partituren mit LilyPond ermöglicht',
	'score-getcwderr' => 'Das aktuelle Arbeitsverzeichnis konnte nicht aufgerufen werden',
	'score-invalidlang' => 'Die für die Partitur verwendete Sprache <code>lang="$1"</code> ist ungültig. Die derzeit verwendbaren Sprache sind <code>lang="lilypond"</code> (Standardeinstellung) und <code>lang="ABC"</code>.',
	'score-noabcinput' => 'Die ABC-Quelldatei $1 konnte nicht erstellt werden.',
	'score-nooutput' => 'Das Bildverzeichnis $1 für LilyPond konnte nicht erstellt werden.',
	'score-nofactory' => 'Das Arbeitsverzeichnis für LilyPond konnte nicht erstellt werden',
	'score-noinput' => 'Die Eingabedatei $1 für LilyPond konnte nicht erstellt werden.',
	'score-notexecutable' => 'LilyPond konnte nicht ausgeführt werden: $1 ist eine nicht ausführbare Datei. Es muss sichergestellt sein, dass <code>$wgLilyPond</code> in der Konfigurationsdatei richtig eingestellt wurde.',
	'score-page' => 'Seite $1',
	'score-pregreplaceerr' => 'Die PCRE-Musterersetzung ist gescheitert.',
	'score-readerr' => 'Die Datei $1 kann nicht gelesen werden.',
	'score-renameerr' => 'Beim Verschieben der Partiturdateien in das Verzeichnis zum Hochladen ist ein Fehler aufgetreten',
	'score-trimerr' => 'Das Bild konnte nicht zugeschnitten werden:
$1 
In der Konfigurationsdatei muss <code>$wgScoreTrim = false;</code> festgelegt werden, sofern das Problem bestehen bleibt.',
	'score-versionerr' => 'Die Version von LilyPond konnte nicht ermittelt werden:
$1',
);

/** French (Français)
 * @author Seb35
 */
$messages['fr'] = array(
	'score-chdirerr' => 'Impossible de changer de répertoire',
	'score-cleanerr' => 'Impossible d’effacer les anciens fichiers avant de regénérer',
	'score-compilererr' => 'Impossible de compiler le fichier d’entrée LilyPond :
$1',
	'score-desc' => 'Ajoute une balise pour le rendu d’extraits musicaux avec LilyPond',
	'score-getcwderr' => 'Impossible d’obtenir le répertoire de travail actuel',
	'score-nooutput' => 'Erreur lors de la création du répertoire image de LilyPond',
	'score-nofactory' => 'Erreur lors de la création du répertoire de la fabrique LilyPond',
	'score-noinput' => 'Erreur lors de la création du fichier d’entrée LilyPond',
	'score-notexecutable' => 'Impossible d’exécuter LilyPond. Vérifiez que <code>$wgLilyPond</code> est correctement configuré.',
	'score-page' => 'Page $1',
	'score-renameerr' => 'Erreur lors du déplacement des fichiers de musique vers le répertoire de téléversement',
	'score-trimerr' => 'L’image ne peut pas être redimensionnée. Configurez $wgScoreTrim=false si le problème persiste.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'score-page' => 'Säit $1',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'score-abc2lynotexecutable' => 'Не можев да го извршам претворањето од ABC во LilyPond:$1 не е извршна податотека. Проверете дали <code>$wgAbc2Ly</code> е правилно наместен.',
	'score-abcconversionerr' => 'Не можам да ја претворам ABC податотеката во формат LilyPond:
$1',
	'score-chdirerr' => 'Не можам да го сменам директориумот $1',
	'score-cleanerr' => 'Не можам да ги исчистам старите податотеки пред да извршам повторен испис',
	'score-compilererr' => 'Не можам да составам влезна податотека за LilyPond:
$1',
	'score-desc' => 'Додава ознака за испис на музички партитури со LilyPond',
	'score-getcwderr' => 'Не можам да го добијам тековниот работен директориум',
	'score-invalidlang' => 'lang="$1" не е важечки јазик за партитурата. Моментално се признаваат јазиците lang="lilypond" (основниот) и lang="ABC".',
	'score-noabcinput' => 'Не можев да ја создадам изворната ABC податотека $1.',
	'score-nooutput' => 'Не можев да го создадам директориумот $1 за сликите на LilyPond',
	'score-nofactory' => 'Не можев да создадам фабрички директориум за LilyPond',
	'score-noinput' => 'Не можев да ја создадам влезната податотека $1 за LilyPond.',
	'score-notexecutable' => 'Не можев да го пуштам LilyPond. $1 не е извршна податотека. Проверете дали <code>$wgLilyPond</code> е правилно наместен.',
	'score-page' => 'Страница $1',
	'score-pregreplaceerr' => 'Не успеа замената на регуларниот израз PCRE',
	'score-readerr' => 'Не можам да ја прочитам податотеката $1',
	'score-renameerr' => 'Грешка при преместувањето на партитурните податотеки во директориумот за подигања',
	'score-trimerr' => 'Не можев да ја скастрам сликата. 
$1
Ако проблемот продолжи да се јавува, задајте <code>$wgScoreTrim=false</code>.',
	'score-versionerr' => 'Не можам да ја добијам верзијата на LilyPond.
$1',
);

/** Dutch (Nederlands)
 * @author SPQRobin
 * @author Siebrand
 */
$messages['nl'] = array(
	'score-abc2lynotexecutable' => 'Het omzetten van ABC naar LilyPond was niet mogelijk.',
	'score-abcconversionerr' => 'Het was niet mogelijk het ABC-bestand om te zetten naar LilyPond:
$1',
	'score-chdirerr' => 'Van map wisselen is niet mogelijk',
	'score-cleanerr' => 'Het was niet mogelijk de oude bestanden op te ruimen voor het opnieuw aanmaken van de afbeeldingen',
	'score-compilererr' => 'Het was niet mogelijk de LilyPondinvoer te compileren:
$1',
	'score-desc' => 'Voegt een label toe voor het weergeven van bladmuziek met LilyPond',
	'score-getcwderr' => 'Het was niet mogelijk de ingestelde werkmap te gebruiken',
	'score-invalidlang' => 'Er is een onjuiste taal voor bladmuziek aangegeven. Op dit moment worden lang="lilypond" (standaard) en lang="ABC" ondersteund.',
	'score-noabcinput' => 'Het ABC-bronbestand kon niet aangemaakt worden',
	'score-nooutput' => 'Het was niet mogelijk de afbeeldingenmap voor LilyPond aan te maken',
	'score-nofactory' => 'Het was niet mogelijk de factorymap voor LilyPond aan te maken',
	'score-noinput' => 'Het was niet mogelijk het invoerbestand voor LilyPond aan te maken',
	'score-notexecutable' => 'Het was niet mogelijk om LilyPond uit te voeren. Zorg dat <code>$wgLilyPond</code> correct is ingesteld.',
	'score-page' => 'Pagina $1',
	'score-pregreplaceerr' => 'Vervangen met behulp van een PCRE reguliere expressie is mislukt',
	'score-readerr' => 'Het bestand kan niet gelezen worden',
	'score-renameerr' => 'Er is een fout opgetreden tijdens het verplaatsen van de bladmuziekbestanden naar de uploadmap',
	'score-trimerr' => 'De afbeelding kon niet bijgesneden worden. Stel de volgende waarde in als dit probleem blijft bestaan: <code>$wgScoreTrim=false</code>.',
	'score-versionerr' => 'Het was niet mogelijk de LiliPond-versie te achterhalen.',
);

