<?php
$messages = array();

/** English
 * @author Nimish Gautam
 * @author Sam Reed
 * @author Brandon Harris
 */
$messages['en'] = array(
	'articleassessment' => 'Article assessment',
	'articleassessment-desc' => 'Article assessment (pilot version)',
	'articleassessment-yourfeedback' => 'Your feedback',
	'articleassessment-pleaserate' => 'Please take a moment to rate this page below.',
	'articleassessment-submit' => 'Submit',
	'articleassessment-rating-wellsourced' => 'Well-Sourced:',
	'articleassessment-rating-neutrality' => 'Neutral:',
	'articleassessment-rating-completeness' => 'Complete:',
	'articleassessment-rating-readability' => 'Readable:',
	'articleassessment-rating-wellsourced-tooltip' => 'Do you feel this page has sufficient citations and that those citations come from trustworthy sources?',
	'articleassessment-rating-neutrality-tooltip' => 'Do you feel that this page shows a fair representation of all perspectives on the issue?',
	'articleassessment-rating-completeness-tooltip' => 'Do you feel that this page covers the essential topic areas that it should?',
	'articleassessment-rating-readability-tooltip' => 'Do you feel that this page is well-organized and well written?',
	'articleassessment-articlerating' => 'Page rating',
	'articleassessment-error' => 'An error has occurred.
Please try again later.',
	'articleassessment-thanks' => 'Thanks! Your ratings have been saved.',

	# This special page doesn't exist yet, but it will soon.
	'articleassessment-featurefeedback' => 'Give us <span class="feedbacklink">feedback</span> about this feature.',
	'articleassessment-noratings' => '$1 ($2 {{PLURAL:$2|rating|ratings}})',
	'articleassessment-stalemessage-norevisioncount' => "This page has been ''revised'' since you last reviewed it.
You may wish to rate it again.",

	# Links get rewritten in javascript.
	'articleassessment-results-show' => '(Results hidden. <span class="showlink">Show</span> them.)',
	'articleassessment-results-hide' => '(<span class="hidelink">Hide results</span>)',
);

/** Message documentation (Message documentation)
 * @author Brandon Harris
 * @author EugeneZelenko
 * @author Sam Reed
 */
$messages['qqq'] = array(
	'articleassessment' => 'The title of the feature. It is about reader feedback.
	
Please visit http://prototype.wikimedia.org/articleassess/Main_Page for a prototype installation.',
	'articleassessment-desc' => '{{desc}}',
	'articleassessment-yourfeedback' => 'This is a box or section header.  It indicates that the contents of the box are personal to the user.',
	'articleassessment-pleaserate' => 'This is a call to action for the user to provide their ratings about the page.',
	'articleassessment-submit' => '{{Identical|Submit}}',
	'articleassessment-rating-wellsourced' => 'This is a rating metric label. The metric is for measuring how researched the article is.',
	'articleassessment-rating-neutrality' => "This is a rating metric label. The metric is for measuring an article's NPOV.",
	'articleassessment-rating-completeness' => 'This is a rating metric label. The metric is for measuring how comprehensive the article is.',
	'articleassessment-rating-readability' => 'This is a rating metric label. The metric is for measuring how well written the article is.',
	'articleassessment-rating-wellsourced-tooltip' => 'This is a tool tip that is designed to explain what the "well-sourced" metric means.',
	'articleassessment-rating-neutrality-tooltip' => 'This is a tool tip that is designed to explain what the "neutrality" metric means.',
	'articleassessment-rating-completeness-tooltip' => 'This is a tool tip that is designed to explain what the "completeness" metric means.',
	'articleassessment-rating-readability-tooltip' => 'This is a tool tip that is designed to explain what the "readability" metric means.',
	'articleassessment-articlerating' => 'This is a box or section header. It indicates that the contents of the box are the average ratings for the article.',
	'articleassessment-error' => 'A generic error message to display on any error.',
	'articleassessment-thanks' => 'The message to display when the user has successfully submitted a rating.',
	'articleassessment-featurefeedback' => 'This is a call to action link for users to provide feedback about the feature.  It takes them to a survey.',
	'articleassessment-noratings' => 'This indicates the number of ratings that the article has received.
Note that PLURAL does not currently work in this message but defaults to the zero; it will work properly in the near future, so keep the calls in.',
	'articleassessment-stalemessage-norevisioncount' => 'This is a message shown to the user when their ratings are "stale" and does NOT include the number of revisions. This is an ambiguous reason, and allows for us to have complicated staleness patterns. This is the preferred message.',
	'articleassessment-results-show' => 'This is an explanatory control that, when clicked, will display hidden aggregate ratings.
The span tag gets rewritten in JavaScript to become a link.',
	'articleassessment-results-hide' => 'This is a control that, when clicked, will hide the aggregate ratings.
The span tag gets rewritten in JavaScript to become a link.',
);

/** Afrikaans (Afrikaans)
 * @author Naudefj
 */
$messages['af'] = array(
	'articleassessment-yourfeedback' => 'U terugvoer',
	'articleassessment-submit' => 'Dien in',
	'articleassessment-rating-wellsourced' => 'Goed van bronne voorsien:',
	'articleassessment-rating-neutrality' => 'Neutraal:',
	'articleassessment-rating-completeness' => 'Volledig:',
	'articleassessment-rating-readability' => 'Leesbaar:',
	'articleassessment-articlerating' => 'Artikel gradering',
	'articleassessment-results-show' => '(Resultate versteek. <span class="showlink">Wys</span> hulle.)',
	'articleassessment-results-hide' => '(<span class="hidelink">Versteek resultate</span>)',
);

/** Belarusian (Taraškievica orthography) (Беларуская (тарашкевіца))
 * @author EugeneZelenko
 * @author Jim-by
 */
$messages['be-tarask'] = array(
	'articleassessment' => 'Адзнака артыкулаў',
	'articleassessment-desc' => 'Адзнака артыкулаў (пачатковая вэрсія)',
	'articleassessment-yourfeedback' => 'Ваш водгук',
	'articleassessment-pleaserate' => 'Калі ласка, знайдзіце час, каб адзначыць старонку ўнізе.',
	'articleassessment-submit' => 'Даслаць',
	'articleassessment-rating-wellsourced' => 'Спасылкі на крыніцы:',
	'articleassessment-rating-neutrality' => 'Нэўтральнасьць:',
	'articleassessment-rating-completeness' => 'Скончанасьць:',
	'articleassessment-rating-readability' => 'Лёгкасьць чытаньня:',
	'articleassessment-rating-wellsourced-tooltip' => 'Вы лічыце, што гэты артыкул мае дастаткова цытатаў, і яны спасылаюцца на крыніцы, якія заслугоўваюць даверу?',
	'articleassessment-rating-neutrality-tooltip' => 'Вы лічыце, што на гэтай старонцы адлюстраваныя усе пункты гледжаньня на пытаньне?',
	'articleassessment-rating-readability-tooltip' => 'Вы лічыце, што гэтая старонка добра арганізаваная і добра напісаная?',
	'articleassessment-articlerating' => 'Адзнака старонкі',
	'articleassessment-error' => 'Узьнікла памылка.
Калі ласка, паспрабуйце потым.',
	'articleassessment-thanks' => 'Дзякуй! Вашая адзнака была захаваная.',
	'articleassessment-featurefeedback' => 'Паведаміце нам <span class="feedbacklink">Вашае меркаваньне</span> пра гэтую магчымасьць.',
	'articleassessment-noratings' => '$1 ($2 {{PLURAL:$2|адзнака|адзнакі|адзнакаў}})',
	'articleassessment-stalemessage-norevisioncount' => "Гэтая старонка была ''рэдагаваная'' пасьля Вашага апошняга рэцэнзаваная.
Верагодна, Вы жадаеце адзначыць яе яшчэ раз.",
	'articleassessment-results-show' => '(Вынікі схаваныя. <span class="showlink">Паказаць</span> іх.)',
	'articleassessment-results-hide' => '(<span class="hidelink">Схаваць вынікі</span>)',
);

/** German (Deutsch)
 * @author Kghbln
 */
$messages['de'] = array(
	'articleassessment' => 'Artikeleinschätzung',
	'articleassessment-desc' => 'Ermöglicht die Einschätzung von Artikeln (Pilotversion)',
	'articleassessment-yourfeedback' => 'Deine Rückmeldung',
	'articleassessment-pleaserate' => 'Bitte nehme dir kurz Zeit diesen Artikel unten auf dieser Seite einzuschätzen.',
	'articleassessment-submit' => 'Speichern',
	'articleassessment-rating-wellsourced' => 'Gut belegt:',
	'articleassessment-rating-neutrality' => 'Neutral:',
	'articleassessment-rating-completeness' => 'Vollständig:',
	'articleassessment-rating-readability' => 'Verständlich:',
	'articleassessment-rating-wellsourced-tooltip' => 'Hast du den Eindruck, dass dieser Artikel über genügend Quellenangaben verfügt und diese zudem aus vertrauenswürdigen Quellen stammen?',
	'articleassessment-rating-neutrality-tooltip' => 'Hast du den Eindruck, dass dieser Artikel eine ausgewogene Darstellung aller mit dessen Inhalt verbundenen Aspekte enthält?',
	'articleassessment-rating-completeness-tooltip' => 'Hast du den Eindruck, dass dieser Artikel alle wichtigen Aspekte enthält, die mit dessen Inhalt zusammenhängen?',
	'articleassessment-rating-readability-tooltip' => 'Hast du den Eindruck, dass dieser Artikel gut strukturiert sowie geschrieben wurde?',
	'articleassessment-articlerating' => 'Einschätzung des Artikels',
	'articleassessment-error' => 'Ein Fehler ist aufgetreten.
Bitte versuche es später erneut.',
	'articleassessment-thanks' => 'Vielen Dank! Deine Einschätzung wurde gespeichert.',
	'articleassessment-featurefeedback' => 'Gebe uns bitte eine <span class="feedbacklink">Rückmeldung</span> zu dieser Funktion zur Einschätzung eines Artikels.',
	'articleassessment-noratings' => '$1 ($2 {{PLURAL:$2|Einschätzung|Einschätzungen}})',
	'articleassessment-stalemessage-norevisioncount' => "Dieser Artikel wurde seit deiner letzten Einschätzung ''bearbeitet''.
Vielleicht möchtest du ihn erneut einschätzen.",
	'articleassessment-results-show' => '(Ergebnisse sind ausgeblendet. <span class="showlink">Einblenden</span>.)',
	'articleassessment-results-hide' => '(<span class="hidelink">Ergebnisse ausblenden</span>)',
);

/** Galician (Galego)
 * @author Toliño
 */
$messages['gl'] = array(
	'articleassessment' => 'Avaliación do artigo',
	'articleassessment-desc' => 'Versión piloto da avaliación dos artigos',
	'articleassessment-yourfeedback' => 'Os seus comentarios',
	'articleassessment-pleaserate' => 'Por favor, tome uns intres para avaliar esta páxina.',
	'articleassessment-submit' => 'Enviar',
	'articleassessment-rating-wellsourced' => 'Ben documentado:',
	'articleassessment-rating-neutrality' => 'Neutral:',
	'articleassessment-rating-completeness' => 'Completo:',
	'articleassessment-rating-readability' => 'Lexible:',
	'articleassessment-rating-wellsourced-tooltip' => 'Cre que esta páxina ten citas suficientes e que estas son de fontes fiables?',
	'articleassessment-rating-neutrality-tooltip' => 'Cre que esta páxina mostra unha representación xusta de todas as perspectivas do tema?',
	'articleassessment-rating-completeness-tooltip' => 'Cre que esta páxina aborda as áreas esenciais do tema que debería?',
	'articleassessment-rating-readability-tooltip' => 'Cre que esta páxina está ben organizada e escrita?',
	'articleassessment-articlerating' => 'Avaliación do artigo',
	'articleassessment-error' => 'Houbo un erro.
Inténteo de novo máis tarde.',
	'articleassessment-thanks' => 'Grazas! Gardáronse as súas valoracións.',
	'articleassessment-featurefeedback' => 'Déanos <span class="feedbacklink">a súa opinión</span> sobre esta característica.',
	'articleassessment-noratings' => '$1 ($2 {{PLURAL:$2|avaliación|avaliacións}})',
	'articleassessment-stalemessage-norevisioncount' => "Alguén fixo unha ''revisión'' da páxina desde a súa última visita.
Quizais queira avaliala novamente.",
	'articleassessment-results-show' => '(Resultados agochados. <span class="showlink">Mostralos</span>.)',
	'articleassessment-results-hide' => '(<span class="hidelink">Agochar os resultados</span>)',
);

/** Interlingua (Interlingua)
 * @author McDutchie
 */
$messages['ia'] = array(
	'articleassessment' => 'Evalutation de articulos',
	'articleassessment-desc' => 'Evalutation de articulos (version pilota)',
	'articleassessment-yourfeedback' => 'Tu opinion',
	'articleassessment-pleaserate' => 'Per favor prende un momento pro evalutar iste pagina hic infra.',
	'articleassessment-submit' => 'Submitter',
	'articleassessment-rating-wellsourced' => 'Ben referentiate:',
	'articleassessment-rating-neutrality' => 'Neutral:',
	'articleassessment-rating-completeness' => 'Complete:',
	'articleassessment-rating-readability' => 'Legibile:',
	'articleassessment-rating-wellsourced-tooltip' => 'Pensa tu que iste articulo ha sufficiente citationes e que iste citationes refere a fontes digne de fide?',
	'articleassessment-rating-neutrality-tooltip' => 'Pensa tu que iste articulo monstra un representation juste de tote le perspectivas super le question?',
	'articleassessment-rating-completeness-tooltip' => 'Pensa tu que iste articulo coperi le themas essential que illo deberea coperir?',
	'articleassessment-rating-readability-tooltip' => 'Pensa tu que iste articulo es ben organisate e ben scribite?',
	'articleassessment-articlerating' => 'Evalutation del articulo',
	'articleassessment-error' => 'Un error ha occurrite.
Per favor reproba plus tarde.',
	'articleassessment-thanks' => 'Gratias! Tu evalutation ha essite salveguardate.',
	'articleassessment-featurefeedback' => 'Da nos [[Special:Article Assessment Feedback|tu opinion]] super iste functionalitate.',
	'articleassessment-noratings' => '$1 ($2 {{PLURAL:$2|evalutation|evalutationes}})',
	'articleassessment-stalemessage-norevisioncount' => "Iste articulo ha essite ''re-elaborate'' post tu ultime evalutation.
Es recommendate que tu lo re-evaluta.",
	'articleassessment-results-show' => '(Resultatos celate. <span class="showlink">Revelar</span> los.)',
	'articleassessment-results-hide' => '(<span class="hidelink">Celar resultatos</span>)',
);

/** Japanese (日本語)
 * @author Marine-Blue
 * @author Yanajin66
 */
$messages['ja'] = array(
	'articleassessment' => '記事の評価',
	'articleassessment-desc' => '記事の評価（パイロット版）',
	'articleassessment-yourfeedback' => 'あなたのフィードバック',
	'articleassessment-pleaserate' => 'このページの評価を算出していますので、少しお待ちください。',
	'articleassessment-submit' => '送信',
	'articleassessment-rating-wellsourced' => '良くソース化できたもの:',
	'articleassessment-rating-neutrality' => '中立的なもの:',
	'articleassessment-rating-completeness' => '完了:',
	'articleassessment-rating-readability' => '読み込み可能なもの:',
	'articleassessment-rating-wellsourced-tooltip' => 'あなたはこの記事が十分な引用を含んでいて、それらの引用は信憑性のあるソースからのものだと感じますか？',
	'articleassessment-rating-neutrality-tooltip' => 'あなたはこの記事が問題点における全ての見解の中で公正な表現だと感じますか？',
	'articleassessment-rating-completeness-tooltip' => 'あなたはこの記事が不可欠な話題の領域をカバーしていると感じますか？',
	'articleassessment-rating-readability-tooltip' => 'あなたはこの記事が良く整理され、良く書かれていると感じますか？',
	'articleassessment-articlerating' => '記事の評価',
	'articleassessment-error' => 'エラーが発生しました。
後でもう一度試みてください。',
	'articleassessment-thanks' => 'ありがとうございます！あなたの評価は保存されました。',
	'articleassessment-stalemessage-norevisioncount' => "この記事はあなたが最後にレビューしてから、''修正''されました。
再度レビューしたほうが良いかもしれません。",
);

/** Luxembourgish (Lëtzebuergesch)
 * @author Robby
 */
$messages['lb'] = array(
	'articleassessment' => 'Artikelaschätzung',
	'articleassessment-desc' => 'Artikelaschätzung Pilotversioun',
	'articleassessment-yourfeedback' => 'Äre Feedback',
	'articleassessment-pleaserate' => 'Huelt Iech w.e.g. een Ament fir déi Säit hei drënner ze bewäerten.',
	'articleassessment-submit' => 'Späicheren',
	'articleassessment-rating-wellsourced' => 'Gudd dokumentéiert:',
	'articleassessment-rating-neutrality' => 'Neutral:',
	'articleassessment-rating-completeness' => 'Komplett:',
	'articleassessment-rating-readability' => 'Verständlech:',
	'articleassessment-articlerating' => 'Bewäertung vum Artikel',
	'articleassessment-error' => 'Et ass e Feeler geschitt.
Probéiert w.e.g. méi spéit nach emol.',
	'articleassessment-thanks' => 'Merci! Är Bewäertung gouf gespäichert.',
	'articleassessment-featurefeedback' => 'Gitt eis Äre [[Special:Article Assessment Feedback|Feedback]] vun dëser Fonctioun.',
	'articleassessment-noratings' => '$1 ($2 {{PLURAL:$2|Bewäertung|Bewäertungen}})',
	'articleassessment-stalemessage-norevisioncount' => "Dësen Artikel gouf zënter datt Dir e fir d'lescht nogekuckt hutt ''verännert''.
Et kéint sinn datt dir en nei bewäerte wëllt.",
	'articleassessment-results-show' => '(D\'Resultater si verstopp. Resultater <span class="showlink">weisen</span>.)',
	'articleassessment-results-hide' => '(<span class="hidelink">Resultater verstoppen</span>)',
);

/** Macedonian (Македонски)
 * @author Bjankuloski06
 */
$messages['mk'] = array(
	'articleassessment' => 'Оценување на статија',
	'articleassessment-desc' => 'Пилотна верзија на Оценување на статија',
	'articleassessment-yourfeedback' => 'Ваше мислење',
	'articleassessment-pleaserate' => 'Одвојте момент за да ја оцените страницава подолу',
	'articleassessment-submit' => 'Поднеси',
	'articleassessment-rating-wellsourced' => 'Доволно извори:',
	'articleassessment-rating-neutrality' => 'Неутрална:',
	'articleassessment-rating-completeness' => 'Исцрпна:',
	'articleassessment-rating-readability' => 'Читлива:',
	'articleassessment-rating-wellsourced-tooltip' => 'Дали сметате дека статијава има доволно наводи и дека се преземени од доверливи извори?',
	'articleassessment-rating-neutrality-tooltip' => 'Дали сметате дека статијава на праведен начин ги застапува сите гледишта на оваа проблематика?',
	'articleassessment-rating-completeness-tooltip' => 'Дали сметате дека статијава ги обработува најважните основни теми што треба да се обработат?',
	'articleassessment-rating-readability-tooltip' => 'Дали сметате дека статијава е добро организирана и убаво напишана?',
	'articleassessment-articlerating' => 'Оценки за статијата',
	'articleassessment-error' => 'Се појави грешка.
Обидете се подоцна.',
	'articleassessment-thanks' => 'Ви благодариме! Вашите оценки се зачувани.',
	'articleassessment-featurefeedback' => 'Дајте ваше <span class="feedbacklink">мислење</span> за оваа функција.',
	'articleassessment-noratings' => '$1 ($2 {{PLURAL:$2|оценка|оценки}})',
	'articleassessment-stalemessage-norevisioncount' => "Статијава е ''преработена'' од последниот преглеед наваму.
Ви предлагаме да ја преоцените.",
	'articleassessment-results-show' => '(Резултатите се скриени. <span class="showlink">Прикажи</span> ги.)',
	'articleassessment-results-hide' => '(<span class="hidelink">Сокриј резултати</span>)',
);

/** Dutch (Nederlands)
 * @author Siebrand
 */
$messages['nl'] = array(
	'articleassessment' => 'Paginabeoordeling',
	'articleassessment-desc' => 'Paginabeoordeling (testversie)',
	'articleassessment-yourfeedback' => 'Uw terugkoppeling',
	'articleassessment-pleaserate' => 'Geef alstublieft een beoordeling van deze pagina.',
	'articleassessment-submit' => 'Opslaan',
	'articleassessment-rating-wellsourced' => 'Goed van bronnen voorzien:',
	'articleassessment-rating-neutrality' => 'Neutraal:',
	'articleassessment-rating-completeness' => 'Compleet:',
	'articleassessment-rating-readability' => 'Leesbaar:',
	'articleassessment-rating-wellsourced-tooltip' => 'Vindt u dat deze pagina voldoende bronvermeldingen heeft en dat de bronvermeldingen betrouwbaar zijn?',
	'articleassessment-rating-neutrality-tooltip' => 'Vindt u dat deze pagina een eerlijke weergave is van alle invalshoeken voor dit onderwerp?',
	'articleassessment-rating-completeness-tooltip' => 'Vindt u dat deze pagina de essentie van dit onderwerp bestrijkt?',
	'articleassessment-rating-readability-tooltip' => 'Vindt u dat deze pagina een correcte opbouw heeft een goed is geschreven?',
	'articleassessment-articlerating' => 'Paginawaardering',
	'articleassessment-error' => 'Er is een fout opgetreden. 
Probeer het later opnieuw.',
	'articleassessment-thanks' => 'Bedankt!
Uw beoordeling is opgeslagen.',
	'articleassessment-featurefeedback' => 'Geef ons [[Special:ArticleAssessmentFeedback|terugkoppeling]] over deze functie.',
	'articleassessment-noratings' => '$1 ($2 {{PLURAL:$2|beoordeling|beoordelingen}})',
	'articleassessment-stalemessage-norevisioncount' => "Deze pagina is ''aangepast'' sinds uw beoordeling.
Wilt u de pagina opnieuw beoordelen?",
	'articleassessment-results-show' => '(<span class="showlink">resultaten weergeven</span>)',
	'articleassessment-results-hide' => '(<span class="hidelink">resultaten verbergen</span>)',
);

/** Piedmontese (Piemontèis)
 * @author Dragonòt
 */
$messages['pms'] = array(
	'articleassessment' => "Valutassion ëd j'artìcoj",
	'articleassessment-desc' => "Vërsion pilòta dla valutassion ëd j'artìcoj",
	'articleassessment-yourfeedback' => 'Tò artorn',
	'articleassessment-pleaserate' => 'Për piasì pija un moment për valuté sta pàgina sota.',
	'articleassessment-submit' => 'Spediss',
	'articleassessment-rating-wellsourced' => 'Bon-e-Sorgiss:',
	'articleassessment-rating-neutrality' => 'Neutral:',
	'articleassessment-rating-completeness' => 'Completa:',
	'articleassessment-rating-readability' => 'Lesìbil:',
	'articleassessment-rating-wellsourced-tooltip' => "Pensës-to che sto artìcol a l'abia basta citassion e che ste citassion a rivo da sorziss sigure?",
	'articleassessment-rating-neutrality-tooltip' => 'Pensës-to che sto artìcol a mosta na giusta rapresentassion ëd tute le prospetive ant sua edission?',
	'articleassessment-rating-completeness-tooltip' => "Pensës-to che sto artìcol a coata le aire essensial ëd l'argoment com a dovrìa?",
	'articleassessment-rating-readability-tooltip' => 'Pensës-to che sto artìcol a sia bin-organisà e bin scrivù?',
	'articleassessment-articlerating' => "Valutassion ëd l'artìcol",
	'articleassessment-error' => "Un eror a l'é capità.
Për piasì preuva torna pi tard.",
	'articleassessment-thanks' => 'Mersì! Toe valutassion a son ëstàite salvà.',
	'articleassessment-featurefeedback' => 'Dane <span class="feedbacklink">artorn</span> a propòsit dë sta funsion.',
	'articleassessment-noratings' => '$1 ($2 {{PLURAL:$2|valutassion|valutassion}})',
	'articleassessment-stalemessage-norevisioncount' => "Sto artìcol a l'é stàit ''revisionà'' da quand ch'it l'has revisionalo.
It podrìe vorejlo revaluté.",
	'articleassessment-results-show' => '(Arzultà stërmà. <span class="showlink">Mostlo</span>.)',
	'articleassessment-results-hide' => '(<span class="hidelink">Stërma arzultà</span>)',
);

/** Portuguese (Português)
 * @author Hamilton Abreu
 * @author Waldir
 */
$messages['pt'] = array(
	'articleassessment' => 'Avaliação do artigo',
	'articleassessment-desc' => 'Avaliação do artigo (versão de testes)',
	'articleassessment-yourfeedback' => 'Os seus comentários',
	'articleassessment-pleaserate' => 'Dedique um momento a avaliar esta página abaixo, por favor.',
	'articleassessment-submit' => 'Enviar',
	'articleassessment-rating-wellsourced' => 'Bem referenciado:',
	'articleassessment-rating-neutrality' => 'Neutro:',
	'articleassessment-rating-completeness' => 'Completo:',
	'articleassessment-rating-readability' => 'Fácil de ler:',
	'articleassessment-rating-wellsourced-tooltip' => 'Considera que esta página tem citações suficientes e que essas citações provêm de fontes fiáveis?',
	'articleassessment-rating-neutrality-tooltip' => 'Acha que esta página representa, de forma equilibrada, todos os pontos de vista sobre o assunto?',
	'articleassessment-rating-completeness-tooltip' => 'Considera que esta página aborda os temas essenciais que deviam ser cobertos?',
	'articleassessment-rating-readability-tooltip' => 'Acha que esta página está bem organizada e bem escrita?',
	'articleassessment-articlerating' => 'Avaliação da página',
	'articleassessment-error' => 'Ocorreu um erro. 
Por favor, tente novamente mais tarde.',
	'articleassessment-thanks' => 'Obrigado! As suas avaliações foram gravadas.',
	'articleassessment-featurefeedback' => 'Envie-nos os seus <span class="feedbacklink">comentários</span> sobre esta funcionalidade.',
	'articleassessment-noratings' => '$1 ($2 {{PLURAL:$2|avaliação|avaliações}})',
	'articleassessment-stalemessage-norevisioncount' => "Esta página foi ''alterada'' desde a sua última revisão. 
Talvez queira voltar a avaliá-la.",
	'articleassessment-results-show' => '(Resultados ocultados. <span class="showlink">Mostrá-los</span>.)',
	'articleassessment-results-hide' => '(<span class="hidelink">Ocultar os resultados</span>)',
);

/** Brazilian Portuguese (Português do Brasil)
 * @author Giro720
 */
$messages['pt-br'] = array(
	'articleassessment' => 'Avaliação do artigo',
	'articleassessment-desc' => 'Avaliação do artigo (versão de testes)',
	'articleassessment-yourfeedback' => 'Os seus comentários',
	'articleassessment-pleaserate' => 'Dedique um momento para avaliar esta página abaixo, por favor.',
	'articleassessment-submit' => 'Enviar',
	'articleassessment-rating-wellsourced' => 'Bem referenciado:',
	'articleassessment-rating-neutrality' => 'Neutro:',
	'articleassessment-rating-completeness' => 'Completo:',
	'articleassessment-rating-readability' => 'Fácil de ler:',
	'articleassessment-rating-wellsourced-tooltip' => 'Você considera que esta página tem citações suficientes e que essas citações provêm de fontes fiáveis?',
	'articleassessment-rating-neutrality-tooltip' => 'Você acha que esta página representa, de forma equilibrada, todos os pontos de vista sobre o assunto?',
	'articleassessment-rating-completeness-tooltip' => 'Você considera que esta página aborda os temas essenciais que deviam ser cobertos?',
	'articleassessment-rating-readability-tooltip' => 'Você acha que esta página está bem organizada e bem escrita?',
	'articleassessment-articlerating' => 'Avaliação da página',
	'articleassessment-error' => 'Ocorreu um erro. 
Por favor, tente novamente mais tarde.',
	'articleassessment-thanks' => 'Obrigado! As suas avaliações foram salvas.',
	'articleassessment-featurefeedback' => 'Envie-nos os seus <span class="feedbacklink">comentários</span> sobre esta funcionalidade.',
	'articleassessment-noratings' => '$1 ($2 {{PLURAL:$2|avaliação|avaliações}})',
	'articleassessment-stalemessage-norevisioncount' => "Esta página foi ''alterada'' desde a sua última revisão. 
Talvez queira voltar a avaliá-la.",
	'articleassessment-results-show' => '(Resultados ocultados. <span class="showlink">Mostrá-los</span>.)',
	'articleassessment-results-hide' => '(<span class="hidelink">Ocultar os resultados</span>)',
);

/** Russian (Русский)
 * @author Сrower
 */
$messages['ru'] = array(
	'articleassessment' => 'Оценка статьи',
	'articleassessment-desc' => 'Оценка статьи (экспериментальный вариант)',
	'articleassessment-yourfeedback' => 'Ваш отзыв',
	'articleassessment-pleaserate' => 'Пожалуйста, уделите минуту, чтобы оценить статью ниже.',
	'articleassessment-submit' => 'Сохранить',
	'articleassessment-rating-wellsourced' => 'Из хорошего источника:',
	'articleassessment-rating-neutrality' => 'Нейтральная:',
	'articleassessment-rating-completeness' => 'Завершённая:',
	'articleassessment-rating-readability' => 'Читаемая:',
	'articleassessment-rating-wellsourced-tooltip' => 'Считаете ли Вы, что на этой странице достаточно цитат и что они взяты из достоверных источников?',
	'articleassessment-rating-neutrality-tooltip' => 'Считаете ли Вы, что эта страница объективно отражает все точки зрения по этому вопросу?',
	'articleassessment-rating-completeness-tooltip' => 'Считаете ли Вы, что эта страница в достаточной мере расскрывает основные вопросы темы.',
	'articleassessment-rating-readability-tooltip' => 'Считаете ли Вы, что эта страница хорошо организована и хорошо написана?',
	'articleassessment-articlerating' => 'Рейтинг страницы',
	'articleassessment-error' => 'Произошла ошибка. 
Пожалуйста, повторите попытку позже.',
	'articleassessment-thanks' => 'Спасибо! Ваши оценки сохранены.',
	'articleassessment-featurefeedback' => 'Сообщите [[Special:ArticleAssessmentFeedback|Ваше мнение]] об этой функции.',
	'articleassessment-noratings' => '$1 ($2 {{PLURAL: $ 2 | оценка | оценки}})',
	'articleassessment-stalemessage-norevisioncount' => 'Эта страница редактировалась после Вашего просмотра. 
Вы можете оценить её еще раз.',
	'articleassessment-results-show' => '(Результаты скрыты. <span class="showlink">Показать</span> их).',
	'articleassessment-results-hide' => '(<span class="hidelink">Скрыть результаты</span>)',
);

/** Vietnamese (Tiếng Việt)
 * @author Minh Nguyen
 */
$messages['vi'] = array(
	'articleassessment-pleaserate' => 'Xin hãy dành một chút thì giờ để đánh giá trang này ở dưới:',
	'articleassessment-submit' => 'Đánh giá',
	'articleassessment-rating-wellsourced' => 'Đầy đủ nguồn:',
	'articleassessment-rating-neutrality' => 'Trung lập:',
	'articleassessment-rating-completeness' => 'Đầy đủ:',
	'articleassessment-rating-readability' => 'Dễ đọc:',
	'articleassessment-rating-wellsourced-tooltip' => 'Bạn có cảm thấy rằng bày này chú thích nguồn gốc đầy đủ và đáng tin các nguồn?',
	'articleassessment-rating-neutrality-tooltip' => 'Bạn có cảm thấy rằng bài này đại diện công bằng cho tất cả các quan điểm về các vấn đề?',
	'articleassessment-rating-completeness-tooltip' => 'Bạn có cảm thấy rằng bài này bao gồm các đề tài cần thiết?',
	'articleassessment-rating-readability-tooltip' => 'Bạn có cảm thấy rằng bài này được sắp xếp đàng hoàng có văn bản hay?',
	'articleassessment-articlerating' => 'Đánh giá bài',
	'articleassessment-error' => 'Đã gặp lỗi.
Xin hãy thử lại sau.',
	'articleassessment-thanks' => 'Cám ơn! Đánh giá của bạn đã được lưu.',
	'articleassessment-noratings' => '$1 ($2 đánh giá)',
	'articleassessment-stalemessage-norevisioncount' => "Bài này đã được ''chỉnh sửa'' sau lần cuối bạn xem xét nó.
Bạn có thể muốn đánh giá nó một lần nữa.",
	'articleassessment-results-show' => '(Các kết quả được ẩn. <span class="showlink">Hiện</span> kết quả.)',
	'articleassessment-results-hide' => '(<span class="hidelink">Ẩn kết quả</span>)',
);

