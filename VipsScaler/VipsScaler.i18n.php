<?php
/**
 * Internationalisation file for extension VipsScaler.
 *
 * @file
 * @ingroup Extensions
 */
 
$messages = array();

$messages['en'] = array( 
	'vipstest' => 'VIPS scaling test page',

	'vipsscaler-desc' => 'Create thumbnails using VIPS',
	'vipsscaler-invalid-file' => 'Could not process requested file. Check that it exists on this wiki.',
	'vipsscaler-invalid-width' => 'Thumbnail width should be larger than zero and not larger than file width.',
	'vipsscaler-invalid-sharpen' => 'Sharpening amount should be a number larger than zero and smaller than five.',
	'vipsscaler-thumb-error' => 'VIPS could not generate a thumbnail with given parameters.',

	# Vipscaler test form:
	'vipsscaler-form-legend' => 'VIPS scaling',
	'vipsscaler-form-width'  => 'Thumbnail width:',
	'vipsscaler-form-file'   => 'File on this wiki:',
	'vipsscaler-form-sharpen-radius' => 'Amount of sharpening:',
	'vipsscaler-form-bilinear' => 'Bilinear scaling',
	'vipsscaler-form-submit' => 'Generate thumbnails',

	'vipsscaler-thumbs-legend' => 'Generated thumbnails',
	'vipsscaler-thumbs-help' => 'The thumbnail shown below was generated with the default scaler. Move your mouse over the thumbnail to compare it with the one generated by VIPS. Alternatively, you can click / unclick the checkbox below to switch between thumbnails.', 
	'vipsscaler-thumbs-switch-label' => 'Click to switch between default and VIPS scaling output.',
	'vipsscaler-default-thumb' => 'Thumbnail generated with default scaler',
	'vipsscaler-vips-thumb' => 'Thumbnail generated with VIPS',
		
	'vipsscaler-show-both' => 'Show both thumbnails',
	'vipsscaler-show-default' => 'Show default thumbnail only',
	'vipsscaler-show-vips' => 'Show VIPS thumbnail only',

	# User rights
	'right-vipsscaler-test' => 'Use the VIPS scaling test interface [[Special:VipsTest]]',
);

/** Message documentation (Message documentation)
 * @author Purodha
 * @author Umherirrender
 */
$messages['qqq'] = array(
	'vipstest' => 'Title of the Special:VipsTest page',
	'vipsscaler-desc' => '{{desc}}',
	'vipsscaler-invalid-file' => 'Error message when SpecialVipsTest was given a non existent or invalid file name',
	'vipsscaler-invalid-width' => 'Error message when SpecialVipsTest did not get a valid width parameter',
	'vipsscaler-thumb-error' => 'Error message when VIPS did not manage to generate a thumbnail',
	'vipsscaler-form-legend' => 'Special:VipsTest form: legend at top of the form',
	'vipsscaler-form-width' => 'Special:VipsTest form: label for the width input box',
	'vipsscaler-form-file' => 'Special:VipsTest form: label for the file input box',
	'vipsscaler-form-sharpen-radius' => 'Special:VipsTest form: label for the sharpening amount input box',
	'vipsscaler-form-bilinear' => 'Special:VipsTest form: Checkbox label to determine whether to enable bilinear scaling',
	'vipsscaler-form-submit' => 'Special:VipsTest form: submit button text. The page will then attempt to generate a thumbnail with the given parameters.',
	'vipsscaler-default-thumb' => 'Special:VipsTest: caption of the default thumbnail',
	'vipsscaler-vips-thumb' => 'Special:VipsTest: caption of the vips thumbnail',
	'vipsscaler-show-both' => 'Special:VipsTest: button to show both thumbnails',
	'vipsscaler-show-default' => 'Special:VipsTest: button to show default thumbnail only',
	'vipsscaler-show-vips' => 'Special:VipsTest: button to show VIPS thumbnail only',
	'right-vipsscaler-test' => '{{doc-right|vipsscaler-test}}',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'vipsscaler-desc' => 'Skep duimnaels met behulp van VIPS.',
);

/** Asturian (Asturianu)
 * @author Xuacu
 */
$messages['ast'] = array(
	'vipsscaler-desc' => 'Crear miniatures usando VIPS',
);

/** Belarusian (Taraškievica orthography) (‪Беларуская (тарашкевіца)‬)
 * @author Wizardist
 */
$messages['be-tarask'] = array(
	'vipsscaler-desc' => 'Стварае мініятуры з дапамогай VIPS',
);

/** Breton (Brezhoneg)
 * @author Fulup
 */
$messages['br'] = array(
	'vipsscaler-desc' => 'Krouiñ a ra munudoù en ur ober gant VIPS',
	'vipsscaler-form-file' => 'Restr er wiki-mañ :',
);

/** Bosnian (Bosanski)
 * @author CERminator
 */
$messages['bs'] = array(
	'vipsscaler-desc' => 'Pravljenje smanjenog pregleda koristeći VIPS',
);

/** Danish (Dansk)
 * @author Peter Alberti
 */
$messages['da'] = array(
	'vipstest' => 'Testside for skalering vha. VIPS',
	'vipsscaler-desc' => 'Opret miniaturebilleder ved hjælp af VIPS',
	'vipsscaler-invalid-file' => 'Ugyldig fil: kunne ikke behandle den angivne fil. Findes den på denne wiki?',
	'vipsscaler-invalid-width' => 'Du skal angive en bredde (heltal > 0).',
	'vipsscaler-thumb-error' => 'VIPS kunne ikke oprette et miniaturebillede med de angivne parametre.',
	'vipsscaler-form-legend' => 'Skalering vha. VIPS',
	'vipsscaler-form-width' => 'Miniaturebredde:',
	'vipsscaler-form-file' => 'Fil på denne wiki:',
	'vipsscaler-form-submit' => 'Opret miniature',
	'right-vipsscaler-test' => 'Brug brugerfladen til test af skalering ved hjælp af VIPS på [[Special:VipsTest]]',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'vipstest' => 'Testseite zur VIPS-Skalierung',
	'vipsscaler-desc' => 'Ermöglicht das Generieren von Miniaturbildern mit VIPS',
	'vipsscaler-invalid-file' => 'Die angeforderte Datei konnte nicht verarbeitet werden. Bitte überprüfen, ob Sie auf diesem Wiki vorhanden ist.',
	'vipsscaler-invalid-width' => 'Die Breite des Miniaturbildes sollte größer als Null und nicht größer als die Breite des Bildes sein.',
	'vipsscaler-invalid-sharpen' => 'Der Wert der Bildschärfe sollte größer als Null und kleiner als Fünf sein.',
	'vipsscaler-thumb-error' => 'VIPS konnte auf Basis der angegebenen Parameter kein Miniaturbild generieren.',
	'vipsscaler-form-legend' => 'VIPS-Skalierung',
	'vipsscaler-form-width' => 'Breite des Miniaturbildes:',
	'vipsscaler-form-file' => 'Datei in diesem Wiki:',
	'vipsscaler-form-sharpen-radius' => 'Wert der Bildschärfe:',
	'vipsscaler-form-bilinear' => 'Bilineare Skalierung',
	'vipsscaler-form-submit' => 'Miniaturbild generieren',
	'vipsscaler-thumbs-legend' => 'Generierte Miniaturbilder',
	'vipsscaler-thumbs-help' => 'Das unten angezeigte Miniaturbild wurde mit dem Standardskalierungsprogramm generiert. Bitte die Maus über das Miniaturbild bewegen, um es mit einer von VIPS generierten Version zu vergleichen. Alternativ kann man auch das Kästchen unten selektieren/deselektieren, um zwischen den Miniaturbildern zu wechseln.',
	'vipsscaler-thumbs-switch-label' => 'Anklicken, um zwischen der Standardskalierung und der VIPS-Skalierung zu wechseln.',
	'vipsscaler-default-thumb' => 'Das Miniaturbild wurde mit dem Standardskalierungsprogramm generiert.',
	'vipsscaler-vips-thumb' => 'Das Miniaturbild wurde mit VIPS generiert.',
	'vipsscaler-show-both' => 'Beide Miniaturbilder anzeigen',
	'vipsscaler-show-default' => 'Nur das Standardminiaturbild anzeigen',
	'vipsscaler-show-vips' => 'Nur das VIPS-Miniaturbild anzeigen',
	'right-vipsscaler-test' => 'Das [[Special:VipsTest|Testinterface zur VIPS-Skalierung]] nutzen',
);

/** German (formal address) (‪Deutsch (Sie-Form)‬)
 * @author Kghbln
 */
$messages['de-formal'] = array(
	'right-vipsscaler-test' => 'Nutzen Sie das Testinterface zur VIPS-Skalierung [[Special:VipsTest]]',
);

/** French (Français)
 * @author Crochet.david
 * @author Gomoko
 * @author IAlex
 */
$messages['fr'] = array(
	'vipstest' => "Page de test de la mise à l'échelle de VIPS",
	'vipsscaler-desc' => "Créer des miniatures à l'aide de VIPS",
	'vipsscaler-invalid-file' => "Impossible de traiter le fichier demandé. Vérifiez qu'il existe sur ce wiki.",
	'vipsscaler-invalid-width' => 'La largeur de la vignette doit être supérieure à zéro et pas supérieure à la largeur du fichier.',
	'vipsscaler-invalid-sharpen' => 'La quantité de netteté doit être un nombre plus grand que zéro et plus petit que cinq.',
	'vipsscaler-thumb-error' => "VIPS n'a pas pu générer une miniature avec les paramètres fournis.",
	'vipsscaler-form-legend' => "Mise à l'échelle de VIPS",
	'vipsscaler-form-width' => 'Largeur de la miniature :',
	'vipsscaler-form-file' => 'Fichier sur ce wiki :',
	'vipsscaler-form-sharpen-radius' => 'Montant de netteté :',
	'vipsscaler-form-bilinear' => "Mise à l'échelle bilinéaire",
	'vipsscaler-form-submit' => 'Générer la vignette',
	'vipsscaler-thumbs-legend' => 'Vignettes générées',
	'vipsscaler-thumbs-help' => "La vignette ci-dessous a été générée avec la mise à l'échelle par défaut. Déplacez votre souris sur la vignette pour la comparer avec celle générée par VIPS. Comme alternative, vous pouvez cliquer / décocher la case à cocher ci-dessous pour basculer entre les vignettes.",
	'vipsscaler-thumbs-switch-label' => "Cliquez sur basculer entre par l'affichage par défaut et par la mise à l'échelle VIPS.",
	'vipsscaler-default-thumb' => "Vignette générée avec une mise à l'échelle par défaut",
	'vipsscaler-vips-thumb' => 'Vignette générée avec VIPS',
	'vipsscaler-show-both' => 'Afficher les deux vignettes',
	'vipsscaler-show-default' => 'Afficher uniquement la vignette par défaut',
	'vipsscaler-show-vips' => 'Afficher uniquement la vignette VIPS',
	'right-vipsscaler-test' => "Utiliser l'interface de test de mise à l'échelle de VIP [[Special:VipsTest]]",
);

/** Franco-Provençal (Arpetan)
 * @author ChrisPtDe
 */
$messages['frp'] = array(
	'vipsscaler-desc' => 'Fât des figures avouéc VIPS.',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'vipstest' => 'Páxina de probas da escala de VIPS',
	'vipsscaler-desc' => 'Crear miniaturas utilizando VIPS',
	'vipsscaler-invalid-file' => 'Non se puido procesar o ficheiro solicitado. Comprobe que existe neste wiki.',
	'vipsscaler-invalid-width' => 'O largo da miniatura debe ser maior que cero e non pode superar o largo do ficheiro.',
	'vipsscaler-invalid-sharpen' => 'A cantidade de agudización debe ser un número maior que cero e menor que cinco.',
	'vipsscaler-thumb-error' => 'VIPS non pode xerar unha miniatura cos parámetros proporcionados.',
	'vipsscaler-form-legend' => 'Escala de VIPS',
	'vipsscaler-form-width' => 'Largo da miniatura:',
	'vipsscaler-form-file' => 'Ficheiro neste wiki:',
	'vipsscaler-form-sharpen-radius' => 'Cantidade de agudización:',
	'vipsscaler-form-bilinear' => 'Escala bilinear',
	'vipsscaler-form-submit' => 'Xerar a miniatura',
	'vipsscaler-thumbs-legend' => 'Miniaturas xeradas',
	'vipsscaler-thumbs-help' => 'A miniatura mostrada a continuación foi xerada coa escala por defecto. Desprace o rato por riba da miniatura para comparala con aquela xerada por VIPS. Como alternativa, pode marcar ou desmarcar a caixa de verificación inferior para alternar entre as miniaturas.',
	'vipsscaler-thumbs-switch-label' => 'Preme para alternar entre a saída coa escala predeterminada e a de VIPS.',
	'vipsscaler-default-thumb' => 'Miniatura xerada coa escala por defecto',
	'vipsscaler-vips-thumb' => 'Miniatura xerada con VIPS',
	'vipsscaler-show-both' => 'Mostrar ambas as miniaturas',
	'vipsscaler-show-default' => 'Mostrar só a miniatura por defecto',
	'vipsscaler-show-vips' => 'Mostrar só a miniatura de VIPS',
	'right-vipsscaler-test' => 'Utilizar a interface de probas de escala de VIPS, [[Special:VipsTest]]',
);

/** Hebrew (עברית)
 * @author Amire80
 */
$messages['he'] = array(
	'vipstest' => 'דף בדיקות לשינוי גודל באמצעות VIPS',
	'vipsscaler-desc' => 'יצירות תמונות ממוזערות באמצעות VIPS',
	'vipsscaler-invalid-file' => 'עיבוד קובץ לא הצליח. נא לבדוק שהוא קיים בוויקי הזה.',
	'vipsscaler-invalid-width' => 'תמונה ממוזערת צריכה להיות גדולה מאפס ולא גדולה מגודל הקובץ המורשה.',
	'vipsscaler-invalid-sharpen' => 'ערך החידוד צריך להיות גדול מאפס מקטן מחמש.',
	'vipsscaler-thumb-error' => 'תוכנת VIPS לא הצליחה לייצר תמונה ממוזערת עם הפרמטרים שניתנו.',
	'vipsscaler-form-legend' => 'שינוי גודל באמצעות VIPS',
	'vipsscaler-form-width' => 'גודל תמונה ממוזערת:',
	'vipsscaler-form-file' => 'הקובץ על הוויקי הזה:',
	'vipsscaler-form-sharpen-radius' => 'ערך החידוד:',
	'vipsscaler-form-bilinear' => 'שינוי גודל דו־קווי',
	'vipsscaler-form-submit' => 'יצירת תמונה ממוזערת',
	'vipsscaler-thumbs-legend' => 'תמונות ממוזערות מיוצרות',
	'vipsscaler-thumbs-help' => 'התמונה הממוזערת המוצגת להלן יוצרה על־ידי משנה הגדול הרגיל. העבירו את העכבר מעל התמונה הממוזערת כדי להשוות אותה עם התמונה שיוצרה על־ידי VIPS. לחלופין, אפשר לסמן את התיבה להלן כדי לעבור בין תמונות ממוזערות.',
	'vipsscaler-thumbs-switch-label' => 'מעבר בין תמונה ממוזערת רגילה ותמונה שיוצרה על־ידי VIPS.',
	'vipsscaler-default-thumb' => 'תמונה ממוזערת שיוצרה על־ידי משנה הגודל הרגיל',
	'vipsscaler-vips-thumb' => 'תמונה ממוזערת שיוצרה על־ידי VIPS',
	'vipsscaler-show-both' => 'הצגת שתי התמונות הממוזערות',
	'vipsscaler-show-default' => 'הצגת התמונה הממוזערת הרגילה בלבד',
	'vipsscaler-show-vips' => 'הצגת התמונה הממוזערת של VIPS בלבד',
	'right-vipsscaler-test' => 'שימוש בממשק בדיקות של שינוי גודל של VIPS [[מיוחד:VipsTest]]',
);

/** Upper Sorbian (Hornjoserbsce)
 * @author Michawiki
 */
$messages['hsb'] = array(
	'vipsscaler-desc' => 'Přehladowe wobrazki z pomocu VIPS wutworić',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'vipstest' => 'Pagina de test pro scalation VIPS',
	'vipsscaler-desc' => 'Crear miniaturas con VIPS',
	'vipsscaler-invalid-file' => 'Non poteva processar le file requestate. Verifica que illo existe in iste wiki.',
	'vipsscaler-invalid-width' => 'Le latitude del miniatura debe esser superior a zero e non superior al latitude del file.',
	'vipsscaler-invalid-sharpen' => 'Le quantitate de acutiamento debe esser un numero superior a zero e inferior a cinque.',
	'vipsscaler-thumb-error' => 'VIPS non poteva generar un miniatura con le parametros specificate.',
	'vipsscaler-form-legend' => 'Scalation VIPS',
	'vipsscaler-form-width' => 'Latitude del miniatura:',
	'vipsscaler-form-file' => 'File in iste wiki:',
	'vipsscaler-form-sharpen-radius' => 'Quantitate de acutiamento:',
	'vipsscaler-form-bilinear' => 'Redimensionamento bilinear',
	'vipsscaler-form-submit' => 'Generar miniatura',
	'vipsscaler-thumbs-legend' => 'Miniaturas generate',
	'vipsscaler-thumbs-help' => 'Le miniatura monstrate hic infra ha essite generate con le scalator predefinite. Move le cursor super le miniatura pro comparar lo con illo generate per VIPS. Alternativemente, tu pote marcar/dismarcar le quadrato sequente pro cambiar inter miniaturas.',
	'vipsscaler-thumbs-switch-label' => 'Clicca pro cambiar inter le resultato del scalation predefinite e illo de VIPS.',
	'vipsscaler-default-thumb' => 'Miniatura generate con redimensionator predefinite',
	'vipsscaler-vips-thumb' => 'Miniatura generate con VIPS',
	'vipsscaler-show-both' => 'Monstrar ambe miniaturas',
	'vipsscaler-show-default' => 'Monstrar miniatura predefinite solmente',
	'vipsscaler-show-vips' => 'Monstrar miniatura VIPS solmente',
	'right-vipsscaler-test' => 'Usar le interfacie de test pro scalation VIPS [[Special:VipsTest]]',
);

/** Indonesian (Bahasa Indonesia)
 * @author IvanLanin
 */
$messages['id'] = array(
	'vipsscaler-desc' => 'Membuat gambar mini dengan menggunakan VIPS',
);

/** Italian (Italiano)
 * @author Beta16
 */
$messages['it'] = array(
	'vipsscaler-desc' => 'Crea miniature utilizzando VIPS',
);

/** Japanese (日本語)
 * @author Schu
 */
$messages['ja'] = array(
	'vipsscaler-desc' => 'VIPS を用いてサムネイルを作成します。',
);

/** Colognian (Ripoarisch)
 * @author Purodha
 */
$messages['ksh'] = array(
	'vipsscaler-desc' => 'Minibeldsche met <i lang="en">VIPS</i> maache.',
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'vipsscaler-desc' => 'Miniaturbiller mat VIPS maachen',
	'vipsscaler-form-width' => 'Breet vum Miniatur-Bild:',
	'vipsscaler-form-file' => 'Fichier an dëser Wiki:',
	'vipsscaler-form-sharpen-radius' => 'Wäert vun der Schäerft vum Bild:',
	'vipsscaler-form-submit' => 'Miniaturbiller generéieren',
	'vipsscaler-thumbs-legend' => 'Generéiert Miniaturbiller',
	'vipsscaler-show-both' => 'Déi zwee Miniatur-Biller wesien',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'vipstest' => 'Проба за менување на размер со VIPS',
	'vipsscaler-desc' => 'Создавање на минијатури со VIPS',
	'vipsscaler-invalid-file' => 'Не можев да ја обработам бараната податотека. Проверете дали воопшто постои на ова вики.',
	'vipsscaler-invalid-width' => 'Минијатурата мора да е поширока од нула, а потесна од изворната ширина на податотеката.',
	'vipsscaler-invalid-sharpen' => 'Изострувањето треба да е поголемо од нула а помало од пет.',
	'vipsscaler-thumb-error' => 'VIPS не можеше да создаде минијатура со зададените параметри.',
	'vipsscaler-form-legend' => 'Менување големина со VIPS',
	'vipsscaler-form-width' => 'Ширина на минијатурата:',
	'vipsscaler-form-file' => 'Податотека на ова вики:',
	'vipsscaler-form-sharpen-radius' => 'Изострување:',
	'vipsscaler-form-bilinear' => 'Билинеарно размерување',
	'vipsscaler-form-submit' => 'Создај минијатура',
	'vipsscaler-thumbs-legend' => 'Создадени минијатури',
	'vipsscaler-thumbs-help' => 'Долуприкажаната минијатура е создадена со стандардниот зададен резмерител. Ставете глушецот врз минијатурата за да ја споредите со онаа создадена од VIPS. Друг начин: можете да го штиклирате / отштиклирате кутивчето подолу за да се префрлите од една на друга минијатура.',
	'vipsscaler-thumbs-switch-label' => 'Стиснете за да се префрлите од стандарден на VIPS размерен извод и обратно',
	'vipsscaler-default-thumb' => 'Минијатура создадена со основно-зададениот размерител',
	'vipsscaler-vips-thumb' => 'Минијатура создадена со VIPS',
	'vipsscaler-show-both' => 'Прикажи ги двете минијатури',
	'vipsscaler-show-default' => 'Прикажи ја само основната минијатура',
	'vipsscaler-show-vips' => 'Прикажи ја само минијатурата од VIPS',
	'right-vipsscaler-test' => 'Употреба на го посредникот [[Special:VipsTest]] за испробување на менување големина со VIPS',
);

/** Malay (Bahasa Melayu)
 * @author Anakmalaysia
 */
$messages['ms'] = array(
	'vipstest' => 'Laman ujian penskalaan VIPS',
	'vipsscaler-desc' => 'Cipta gambar kenit dengan VIPS',
	'vipsscaler-invalid-file' => 'Fail yang dipohon tidak dapat diproseskan. Tolong semak sama ada ia wujud di wiki ini atau tidak.',
	'vipsscaler-invalid-width' => 'Lebar gambar kenit seharusnya lebih besar daripada sifar dan tidak lebih daripada lebar fail.',
	'vipsscaler-invalid-sharpen' => 'Jumlah ketajaman haruslah bilangan yang lebih daripada sifar dan kurang daripada lima.',
	'vipsscaler-thumb-error' => 'VIPS tidak dapat menghasilkan gambar kenit dengan parameter-parameter yang diberikan.',
	'vipsscaler-form-legend' => 'Penskalaan VIPS',
	'vipsscaler-form-width' => 'Lebar gambar kenit:',
	'vipsscaler-form-file' => 'Fail di wiki ini:',
	'vipsscaler-form-sharpen-radius' => 'Jumlah ketajaman:',
	'vipsscaler-form-bilinear' => 'Penskalaan dwilinear',
	'vipsscaler-form-submit' => 'Hasilkan gambar kenit',
	'vipsscaler-thumbs-legend' => 'Gambar kenit yang terhasil',
	'vipsscaler-thumbs-help' => 'Gambar kenit yang ditunjukkan di bawah dihasilkan dengan penskala asali. Alihkan tetikus anda ke atas gambar kenit itu untuk membandingkannya dengan yang dihasilkan oleh VIPS. Ataupun, anda boleh menandai atau memadamkan tanda pada kotak pilihan di bawah untuk menukar gambar kenit.',
	'vipsscaler-thumbs-switch-label' => 'Klik untuk bertukar antara output asli dan output penskalaan VIPS.',
	'vipsscaler-default-thumb' => 'Gambar kenit yang dihasilkan dengan penskala asali',
	'vipsscaler-vips-thumb' => 'Gambar kenit yang dihasilkan dengan VIPS',
	'vipsscaler-show-both' => 'Tunjukkan kedua-dua gambar kenit',
	'vipsscaler-show-default' => 'Tunjukkan gambar kenit asali sahaja',
	'vipsscaler-show-vips' => 'Tunjukkan gambar kenit VIPS sahaja',
	'right-vipsscaler-test' => 'Menggunakan antaramuka ujian penskalaan VIPS [[Special:VipsTest]]',
);

/** Dutch (Nederlands)
 * @author Saruman
 * @author Siebrand
 */
$messages['nl'] = array(
	'vipstest' => 'Testpagina voor VIPS-transformaties',
	'vipsscaler-desc' => 'Miniaturen van bestanden aanmaken met VIPS',
	'vipsscaler-invalid-file' => 'Het was niet mogelijk het gevraagde bestand te verwerken. Controleer of het binnen deze wiki aanwezig is.',
	'vipsscaler-invalid-width' => 'De breedte van de miniatuur moet groter zijn dan 0 en niet groter dan de breedte van het bestand.',
	'vipsscaler-invalid-sharpen' => 'De hoeveelheid verscherping moet een getal zijn dat groter is dan nul en kleiner is dan vijf.',
	'vipsscaler-thumb-error' => 'VIPS kon geen miniatuur genereren met de opgegeven parameters.',
	'vipsscaler-form-legend' => 'VIPS-transformaties',
	'vipsscaler-form-width' => 'Breedte miniatuur:',
	'vipsscaler-form-file' => 'Bestand op deze wiki:',
	'vipsscaler-form-sharpen-radius' => 'Hoeveelheid verscherping:',
	'vipsscaler-form-bilinear' => 'Bilineair schalen',
	'vipsscaler-form-submit' => 'Miniatuur aanmaken',
	'vipsscaler-thumbs-legend' => 'Aangemaakte miniaturen',
	'vipsscaler-thumbs-help' => 'De hieronder weergegeven miniatuurafbeelding is gegenereerd met de standaard schaler. Beweeg uw muis over de afbeelding om deze te vergelijken met degene die is gegenereerd met VIPS. U kunt ook klikken op het aanvinkvakje hieronder om te wisselen tussen de miniatuurafbeeldingen.',
	'vipsscaler-thumbs-switch-label' => 'Klik hierop om te wisselen tussen standaard- en VIPS-schalingsuitvoer.',
	'vipsscaler-default-thumb' => 'Er is een miniatuurafbeelding aangemaakt met de standaard opschaler',
	'vipsscaler-vips-thumb' => 'Er is een miniatuurafbeelding aangemaakt met VIPS',
	'vipsscaler-show-both' => 'Beide miniatuurafbeeldingen weergeven',
	'vipsscaler-show-default' => 'Alleen de standaard miniatuurafbeelding weergeven',
	'vipsscaler-show-vips' => 'Alleen de VIPS-miniatuurafbeelding weergeven',
	'right-vipsscaler-test' => 'Gebruik de [[Special:VipsTest|testinterface voor VIPS-transformaties]]',
);

/** Norwegian (bokmål)‬ (‪Norsk (bokmål)‬)
 * @author Nghtwlkr
 */
$messages['no'] = array(
	'vipsscaler-desc' => 'Opprett miniatyrbilder med VIPS',
);

/** Polish (Polski)
 * @author Woytecr
 */
$messages['pl'] = array(
	'vipsscaler-desc' => 'Tworzy miniaturki korzystając z VIPS',
);

/** Piedmontese (Piemontèis)
 * @author Borichèt
 * @author Dragonòt
 */
$messages['pms'] = array(
	'vipsscaler-desc' => 'Creé dle miniadure dovrand VIPS',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 */
$messages['pt'] = array(
	'vipsscaler-desc' => 'Criar miniaturas usando VIPS',
);

/** Tarandíne (Tarandíne)
 * @author Joetaras
 */
$messages['roa-tara'] = array(
	'vipsscaler-desc' => 'Ccreje le miniature ausanne VIPS',
);

/** Russian (Русский)
 * @author Александр Сигачёв
 */
$messages['ru'] = array(
	'vipsscaler-desc' => 'Создаёт миниатюры с помощью VIPS',
);

/** Slovenian (Slovenščina)
 * @author Dbc334
 */
$messages['sl'] = array(
	'vipstest' => 'Preskusna stran spreminjanja velikosti VIPS',
	'vipsscaler-desc' => 'Ustvari sličice z VIPS',
	'vipsscaler-invalid-file' => 'Ne morem obdelati zahtevane datoteke. Preverite, če obstaja na tem wikiju.',
	'vipsscaler-invalid-width' => 'Širina sličice mora biti večja od nič in manjša od širine datoteke.',
	'vipsscaler-invalid-sharpen' => 'Delež ostrenja mora biti število večje od nič in manjše od pet.',
	'vipsscaler-thumb-error' => 'VIPS ni mogel ustvariti sličice z navedenimi parametri.',
	'vipsscaler-form-legend' => 'Spreminjanje velikosti VIPS',
	'vipsscaler-form-width' => 'Širina sličice:',
	'vipsscaler-form-file' => 'Datoteka na wikiju:',
	'vipsscaler-form-sharpen-radius' => 'Delež ostrenja:',
	'vipsscaler-form-bilinear' => 'Bilinearno spreminjanje velikosti',
	'vipsscaler-form-submit' => 'Ustvari sličice',
	'vipsscaler-thumbs-legend' => 'Ustvarjene sličice',
	'vipsscaler-thumbs-help' => 'Spodnje sličice je ustvaril privzeti pomanjševalec. Premaknite miško na sličico, da jo primerjate s tisto, ki jo je ustvaril VIPS. Lahko pa označite ali počistite spodnje potrditveno polje in tako preklapljate med sličicama.',
	'vipsscaler-thumbs-switch-label' => 'Kliknite za preklop med privzetim prikazom in prikazom spremenjene velikosti z VIPS.',
	'vipsscaler-default-thumb' => 'Sličica, ustvarjena s privzetim pomanjševalcem',
	'vipsscaler-vips-thumb' => 'Sličica, ustvarjena z VIPS',
	'vipsscaler-show-both' => 'Prikaži obe sličici',
	'vipsscaler-show-default' => 'Prikaži samo privzeto sličico',
	'vipsscaler-show-vips' => 'Prikaži samo sličico VIPS',
	'right-vipsscaler-test' => 'Uporaba vmesnika za spreminjanje velikosti VIPS [[Special:VipsTest]]',
);

/** Serbian (Cyrillic script) (‪Српски (ћирилица)‬)
 * @author Rancher
 */
$messages['sr-ec'] = array(
	'vipsscaler-desc' => 'Прављење умањених приказа слика користећи VIPS',
);

/** Telugu (తెలుగు)
 * @author Veeven
 */
$messages['te'] = array(
	'vipsscaler-desc' => 'VIPSని ఉపయోగించి నఖచిత్రాలను తయారుచేయండి',
);

/** Tagalog (Tagalog)
 * @author AnakngAraw
 */
$messages['tl'] = array(
	'vipsscaler-desc' => 'Lumikha ng mga kagyat na ginagamit ang VIPS',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'vipstest' => 'Trang thử thu nhỏ VIPS',
	'vipsscaler-desc' => 'Tạo hình thu nhỏ dùng VIPS',
	'vipsscaler-invalid-file' => 'Không thể xử lý tập tin được yêu cầu. Hãy kiểm tra nó có tồn tại trên wiki này không.',
	'vipsscaler-invalid-width' => 'Chiều rộng hình nhỏ phải hơn 0 và không được hơn chiều rộng của tập tin gốc.',
	'vipsscaler-invalid-sharpen' => 'Mức độ làm rõ phải là số hơn 0 và ít hơn 5.',
	'vipsscaler-thumb-error' => 'VIPS không thể tạo ra một hình nhỏ với các tham số được chỉ định.',
	'vipsscaler-form-legend' => 'Thu nhỏ VIPS',
	'vipsscaler-form-width' => 'Chiều rộng hình nhỏ:',
	'vipsscaler-form-file' => 'Tập tin trong wiki này:',
	'vipsscaler-form-sharpen-radius' => 'Mức độ làm rõ:',
	'vipsscaler-form-bilinear' => 'Thu nhỏ song tuyến tính',
	'vipsscaler-form-submit' => 'Tạo hình thu nhỏ',
	'vipsscaler-thumbs-legend' => 'Các hình nhỏ được tạo ra',
	'vipsscaler-thumbs-help' => 'Hình nhỏ ở dưới được tạo ra dùng bộ thu nhỏ mặc định. Di chuyển chuột lên hình nhỏ để so sánh nó với hình do VIPS tạo ra. Hoặc bạn có thể chọn và bỏ chọn hộp kiểm ở dưới để đổi qua lại các hình nhỏ.',
	'vipsscaler-thumbs-switch-label' => 'Nhấn chuột để đổi giữa các hình nhỏ mặc định và VIPS.',
	'vipsscaler-default-thumb' => 'Hình nhỏ do bộ thu nhỏ mặc định tạo ra',
	'vipsscaler-vips-thumb' => 'Hình nhỏ do VIPS tạo ra',
	'vipsscaler-show-both' => 'Hiện cả hai hình nhỏ',
	'vipsscaler-show-default' => 'Chỉ hiện hình nhỏ mặc định',
	'vipsscaler-show-vips' => 'Chỉ hiện hình nhỏ VIPS',
	'right-vipsscaler-test' => 'Thử bộ thu nhỏ hình VIPS dùng trang [[Special:VipsTest]]',
);

