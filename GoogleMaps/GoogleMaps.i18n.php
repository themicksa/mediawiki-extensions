<?php
// These are the messages displayed. Most are used for the Editor's Map.

// To add messages for another language, just make a key that's the same as
// the $wgLanguageCode you want it to work for. You can translate as many or as few
// messages as you'd like; the extension will just fall back on the English
// version.

// In addition, if you'd prefer not to mess with this file, you can just define
// messages in LocalSettings.php with a variable called $wgGoogleMapsCustomMessages.
// That variable will override the messages here. It should look something like

// $wgGoogleMapsCustomMessages = array( "yes" => "Ja", "no" => "Nein" );

// i.e., you shouldn't have the intermediate language code key like you see below.

// Using $wgGoogleMapsCustomMessages is a good idea to make future upgrades of this
// extension easier, but you are encouraged to contribute your translation to the project.
// Just send an email to me at emmiller@gmail.com, including the language code ("de", "en", etc.)
// and the relevant data structure, and I'll include it in the next release.

$wgGoogleMapsMessages = array();

$wgGoogleMapsMessages['en'] = array(
	'gm-incompatible-browser' => 'In order to see the map that would go in this space, you will need to use a <a href="http://local.google.com/support/bin/answer.py?answer=16532&amp;topic=1499">compatible web browser</a>.',
	'gm-no-editor' => 'Unfortunately, your browser does not support the interactive map-making features. Try the latest version of <a href="http://www.microsoft.com/ie">Internet Explorer</a> (Windows) or <a href="http://www.mozilla.org/products/firefox">Firefox</a> (Windows, Mac, and Linux).',
	'gm-balloon-title' => 'Title:',
	'gm-make-marker' => 'Caption (wiki mark-up OK):',
	'gm-remove' => 'remove',
	'gm-caption' => 'Caption',
	'gm-tab-title' => 'Tab title',
	'gm-tab' => 'Tab',
	'gm-start-path' => 'start a path',
	'gm-trace-area' => 'trace an area',
	'gm-save-point' => 'save &amp; close',
	'gm-load-map-from-article' => 'Load a map from the article:',
	'gm-no-maps' => 'No maps in this article to load.',
	'gm-refresh-list' => 'gm-refresh-list',
	'gm-load-map' => 'Load map',
	'gm-clip-result' => 'Add to map',
	'gm-no-results' => 'Sorry, no results',
	'gm-searching' => 'searching...',
	'gm-map' => 'Map',
	'gm-note' => 'Note: be sure to copy what you want to save into the article (below) before hitting "Load map", "Save" or "Preview"!',
	'gm-instructions' => 'Below is the Wiki mark-up to create the map above.',
	'gm-are-you-sure' => 'Are you sure?',
	'gm-clear-all-points' => 'Clear all points',
	'gm-refresh-points' => 'Refresh points',
	'gm-width' => 'Width',
	'gm-height' => 'Height',
	'gm-scale-control' => 'Scale',
	'gm-overview-control' => 'Overview',
	'gm-selector-control' => 'Map/Satellite selector',
	'gm-zoom-control' => 'Navigation',
	'gm-large' => 'Large',
	'gm-medium' => 'Medium',
	'gm-small' => 'Small',
	'gm-no-zoom-control' => 'None',
	'gm-yes' => 'Yes',
	'gm-no' => 'No',
	'gm-search-preface' => 'Click the map to add a point, or jump to a city, country, address or business:',
	'gm-geocode-preface' => 'Click the map to add a point, or jump to a city, country, or address:',
	'gm-no-search-preface' => 'Click the map to add a point.',
	'gm-search' => 'Search',
	'gm-clear-search' => 'clear search results',
	'gm-meters' => 'meters', # unused?
	'gm-miles' => 'miles', # unused?
	'gm-editing-path' => 'Click the map to add more points to this path.',
	'gm-save-path' => 'Save',
	'gm-edit-path' => 'add points',
	'gm-show-path' => 'show points',
	'gm-color-path' => 'change color',
	'gm-color-fill' => 'change fill color',
	'gm-add-fill' => 'fill in area',
	'gm-remove-fill' => 'gm-remove-fill',
	'gm-fill-color' => 'Fill color',
	'gm-line-color' => 'Line color',
	'gm-opacity' => 'Opacity',
	'gm-line-width' => 'Width',
	'gm-make-map' => 'make a map',
	'gm-hide-map' => 'gm-hide-map',
	'gm-back' => 'gm-back',
	'gm-kml-include' => 'External KML/GeoRSS:',
	'gm-kml-include-link' => 'add to map',
	'gm-kml-loading' => 'loading...',
	'gm-kml-export' => 'Export this map to KML',
);

$wgGoogleMapsMessages['ar'] = array(
	'gm-incompatible-browser' => 'لكي تشاهد الخريطة المراد ادخالها في هذا الفضاء، ستحتاج لإستخدام <a href="http://local.google.com/support/bin/answer.py?answer=16532&topic=1499">متصفح ويب متوافق</a>.',
	'gm-no-editor' => 'لسوء الحظ ، متصفّحك لا يدعم ميزّات انشاء الخريطة التفاعلية. جرّب آخر نسخة <a href="http://www.microsoft.com/ie">لمستكشف أنترنت</a> (ويندوز) او <a href="http://www.mozilla.org/products/firefox">فايرفوكس</a> (ويندوز، ماك، و لينكس).',
	'gm-make-marker' => 'تعليق (wiki mark-up OK):',
	'gm-remove' => 'حذف',
	'gm-caption' => 'تعليق',
	'gm-tab-title' => 'عنوان اللسيّن',
	'gm-tab' => 'لسيّن',
	'gm-start-path' => 'إبدأ المسار',
	'gm-save-point' => 'حفظ و غلق',
	'gm-load-map-from-article' => 'حمّل خريطة من المقالة:',
	'gm-no-maps' => 'لا توجد خرائط في هذه المقالة للتحميل.',
	'gm-refresh-list' => 'أنعش القائمة',
	'gm-load-map' => 'حمّل خريطة',
	'gm-clip-result' => 'أضف الى الخريطة',
	'gm-no-results' => 'آسف ، لا توجد نتائج',
	'gm-searching' => 'في بحث...',
	'gm-map' => 'خريطة',
	'gm-note' => 'ملاحظة: كن متأكّدا من نسخ الذي تريد حفظه في المقالة (أدناه) قبل النّقر على "حمّل الخريطة "،" حفظ "أو" استعرض "!',
	'gm-instructions' => 'أدناه ويكي mark-up لانشاء الخريطة above.',
	'gm-are-you-sure' => 'هل انت متأكد ؟',
	'gm-clear-all-points' => 'أحذف كلّ النقاط',
	'gm-refresh-points' => 'أنعش النقاط',
	'gm-width' => 'عرض',
	'gm-height' => 'إرتفاع',
	'gm-scale-control' => 'مقياس',
	'gm-overview-control' => 'نظرة عامّة',
	'gm-selector-control' => 'مختار خريطة/ قمر صناعي',
	'gm-zoom-control' => 'ملاحة',
	'gm-large' => 'كبير',
	'gm-medium' => 'وسط',
	'gm-small' => 'صغير',
	'gm-no-zoom-control' => 'لا شيئ',
	'gm-yes' => 'نعم',
	'gm-no' => 'لا',
	'gm-search-preface' => 'أنقر على الخريطة لإضافة نقطة، أو إنتقل إلى مدينة ، بلد ، عنوان أو عمل:',
	'gm-search' => 'بحث',
	'gm-clear-search' => 'امسح نتائج البحث',
	'gm-meters' => 'أمتار',
	'gm-miles' => 'أميال',
	'gm-editing-path' => 'نقر على الخريطة لإضافة نقاط أكثر إلى هذا المسار.',
	'gm-save-path' => 'حفظ',
	'gm-edit-path' => 'أضف نقاطا',
	'gm-color-path' => 'غيّر اللّون',
	'gm-make-map' => 'إنشاء خريطة',
	'gm-hide-map' => 'إخفاء خريطة',
);

$wgGoogleMapsMessages['bg'] = array(
	'gm-incompatible-browser' => 'За правилното визуализиране на картата, която трябва да бъде показана на това място, е необходим <a href="http://local.google.com/support/bin/answer.py?answer=16532&topic=1499">съвместим уеб браузър</a>.',
	'gm-no-editor' => 'Използваният браузър не поддържа показването на интерактивните карти. Опитайте с последните версии на <a href="http://www.microsoft.com/ie">Internet Explorer</a> (Windows) или <a href="http://www.mozilla.org/products/firefox">Firefox</a> (Windows, Mac и Linux).',
	'gm-make-marker' => 'Легенда (уики-синтаксисът е вкл.):',
	'gm-remove' => 'премахване',
	'gm-caption' => 'Легенда',
	'gm-tab-title' => 'Заглавие на етикет',
	'gm-tab' => 'Етикет',
	'gm-start-path' => 'започване на път',
	'gm-trace-area' => 'щриховане на областта',
	'gm-save-point' => 'съхранение & затваряне',
	'gm-load-map-from-article' => 'Зареждане на карта от страница:',
	'gm-no-maps' => 'Статията не съдържа карти, които да бъдат показани.',
	'gm-refresh-list' => 'Опресняване на списъка',
	'gm-load-map' => 'Зареждане на картата',
	'gm-clip-result' => 'Добавяне на картата',
	'gm-no-results' => 'Няма намерен резултат',
	'gm-searching' => 'търсене...',
	'gm-map' => 'Карта',
	'gm-note' => 'Забележка: уверете се, че сте копирали каквото желаете да съхраните в страницата преди да натиснете "Зареждане на картата", "Съхранение" или "Преглед"!',
	'gm-instructions' => 'По-долу е показан уики-код за създаване на показаната карта.',
	'gm-are-you-sure' => 'Необходимо е потвърждение за желаното действие',
	'gm-clear-all-points' => 'Изчистване на всички отметки',
	'gm-refresh-points' => 'Опресняване на отметките',
	'gm-width' => 'Ширина',
	'gm-height' => 'Височина',
	'gm-scale-control' => 'Скала',
	'gm-overview-control' => 'Общ преглед',
	'gm-selector-control' => 'Възможност за избор на Карта/Сателитна снимка',
	'gm-zoom-control' => 'Навигация',
	'gm-large' => 'Голяма',
	'gm-medium' => 'Средна',
	'gm-small' => 'Малка',
	'gm-no-zoom-control' => 'Няма',
	'gm-yes' => 'Да',
	'gm-no' => 'Не',
	'gm-search-preface' => 'Натискането върху картата добавя отметка или отива на град или държава:',
	'gm-geocode-preface' => 'Натискането върху картата добавя отметка или отива на град, държава или адрес:',
	'gm-no-search-preface' => 'Щракване върху картата добавя отметка.',
	'gm-search' => 'Търсене',
	'gm-clear-search' => 'изчистване на резултата от търсенето',
	'gm-meters' => 'метри',
	'gm-miles' => 'мили',
	'gm-editing-path' => 'Още отметки към този път могат да бъдат добавени чрез натискане върху картата.',
	'gm-save-path' => 'Съхранение',
	'gm-edit-path' => 'добавяне на отметки',
	'gm-show-path' => 'показване на отметките',
	'gm-color-path' => 'промяна на цвета',
	'gm-color-fill' => 'промяна на цвета на запълване',
	'gm-add-fill' => 'запълване на областта',
	'gm-remove-fill' => 'премахване на запълването',
	'gm-make-map' => 'създаване на карта',
	'gm-hide-map' => 'скриване на картата',
	'gm-back' => 'обратно',
);

$wgGoogleMapsMessages['bg'] = array(
	'gm-incompatible-browser' => 'Para ver o mapa que iria neste espaço, você precisará usar um <a href="http://local.google.com/support/bin/answer.py?answer=16532&topic=1499">navegador compatível</a>.',
	'gm-no-editor' => 'Infelizmente, o seu navegador não suporta o recurso de mapa interativo. Experimente uma versão mais recente do <a href="http://www.microsoft.com/ie">Internet Explorer</a> (Windows) ou do <a href="http://www.mozilla.org/products/firefox">Firefox</a> (Windows, Mac, Linux).',
	'gm-make-marker' => 'Texto explicativo (Marcar wiki OK):',
	'gm-remove' => 'remover',
	'gm-caption' => 'Texto explicativo',
	'gm-tab-title' => 'Título da Etiqueta',
	'gm-tab' => 'Etiqueta',
	'gm-start-path' => 'Começo do caminho',
	'gm-trace-area' => 'Trace uma área',
	'gm-save-point' => 'Salvar &amp; Fechar',
	'gm-load-map-from-article' => 'Carregar um mapa do artigo:',
	'gm-no-maps' => 'Não há mapas nesse artigo para carregar.',
	'gm-refresh-list' => 'Atualizar a Lista',
	'gm-load-map' => 'Carregar um mapa',
	'gm-clip-result' => 'Adicionar ao mapa',
	'gm-no-results' => 'Desculpe, não há resultados',
	'gm-searching' => 'procurando...',
	'gm-map' => 'Mapa',
	'gm-note' => 'Observação: não se esqueça de copiar o conteúdo que se quer salvar no artigo (abaixo) antes de pressionar as opções "Carregar mapa", "Salvar" ou "Pré-visualizar"!',
	'gm-instructions' => 'Abaixo está a notação (padrão Wiki) para se criar o mapa acima no wiki',
	'gm-are-you-sure' => 'Você tem certeza?',
	'gm-clear-all-points' => 'Limpar todos os pontos (marcas, apontadores)',
	'gm-refresh-points' => 'Atualizar pontos marcados',
	'gm-width' => 'Largura',
	'gm-height' => 'Comprimento',
	'gm-scale-control' => 'Escala',
	'gm-overview-control' => 'Visão Geral',
	'gm-selector-control' => 'Seletor de Mapa/Satélite',
	'gm-zoom-control' => 'Navegação',
	'gm-large' => 'Grande',
	'gm-medium' => 'Médio',
	'gm-small' => 'Pequeno',
	'gm-no-zoom-control' => 'Sem controle de zoom',
	'gm-yes' => 'Sim',
	'gm-no' => 'Não',
	'gm-search-preface' => 'Clique no mapa para adicionar um ponto, ou ir para uma cidade, pais, endereço ou comércio:',
	'gm-geocode-preface' => 'Clique no mapa para adicionar um ponto, ou ir para uma cidade, pais ou endereço:',
	'gm-no-search-preface' => 'Clique no mapa para adicionar um ponto.',
	'gm-search' => 'Procurar',
	'gm-clear-search' => 'Limpar resultados da procura',
	'gm-meters' => 'metros',
	'gm-miles' => 'milhas',
	'gm-editing-path' => 'Clique no mapa para adicionar mais pontos para o caminho.',
	'gm-save-path' => 'Salvar',
	'gm-edit-path' => 'adicionar pontos',
	'gm-show-path' => 'mostrar pontos',
	'gm-color-path' => 'mudar a cor',
	'gm-color-fill' => 'mudar a cor do preenchimento',
	'gm-add-fill' => 'Preencher na área',
	'gm-remove-fill' => 'remover preenchimento',
	'gm-make-map' => 'criar um mapa',
	'gm-hide-map' => 'esconder um mapa',
	'gm-back' => 'voltar',
);

$wgGoogleMapsMessages['ca'] = array(
	'gm-incompatible-browser' => 'Per veure el mapa que hi ha en aquesta p&agrave;gina, has d\'utilitzar un <a href="http://local.google.com/support/bin/answer.py?answer=16532&amp;topic=1499">navegador compatible</a>.',
	'gm-no-editor' => 'Desgraciadament, el teu navegador no suporta la funci&oacute; interactiva de construcci&oacute; de mapes. Prova la darrera versi&oacute; de <a href="http://www.microsoft.com/ie">Internet Explorer</a> (Windows) o <a href="http://www.mozilla.org/products/firefox">Firefox</a> (Windows, Mac i Linux).',
	'gm-make-marker' => 'Llegenda (sintaxi wiki OK):',
	'gm-remove' => 'eliminar',
	'gm-caption' => 'Llegenda',
	'gm-tab-title' => 'T&iacute;tol de tab',
	'gm-tab' => 'Tab',
	'gm-start-path' => 'inicia una ruta',
	'gm-save-point' => 'guarda i tanca',
	'gm-load-map-from-article' => 'Carrega un mapa des de l\'article:',
	'gm-no-maps' => 'No hi ha mapes per carregar en aquest article.',
	'gm-refresh-list' => 'Recarrega la llista',
	'gm-load-map' => 'Carrega el mapa',
	'gm-clip-result' => 'Afageix al mapa',
	'gm-no-results' => 'Ho sento, no hi ha resultats',
	'gm-searching' => 'buscant...',
	'gm-map' => 'Mapa',
	'gm-note' => 'Nota: assegura\'t de copiar el que vulguis guardar a l\'article (aqu&iacute; sota) abans de pr&eacute;mer "Carrega el mapa", "Desa la p&agrave;gina" o "Mostra previsualitzaci&oacute;"!',
	'gm-instructions' => 'Aqu&iacute; sota tens la sintaxi Wiki per crear el mapa.',
	'gm-are-you-sure' => 'Segur?',
	'gm-clear-all-points' => 'Elimina tots els punts',
	'gm-refresh-points' => 'Refresa els punts',
	'gm-width' => 'Ample',
	'gm-height' => 'Alt',
	'gm-scale-control' => 'Escala',
	'gm-overview-control' => 'Miniatura',
	'gm-selector-control' => 'Selector Mapa/Sat&egrave;lit',
	'gm-zoom-control' => 'Tamany',
	'gm-large' => 'Gran',
	'gm-medium' => 'Mitj&agrave;',
	'gm-small' => 'Petit',
	'gm-no-zoom-control' => 'Cap',
	'gm-yes' => 'S&iacute;',
	'gm-no' => 'No',
	'gm-search-preface' => 'Fes click sobre el mapa per afegir un punt, o ves a una ciutat, pa&iacute;s, direcci&oacute; o negoci:',
	'gm-geocode-preface' => 'Fes click sobre el mapa per afegir un punt, o ves a una ciutat, pa&iacute;s, o direcci&oacute;:',
	'gm-no-search-preface' => 'Fes click sobre el mapa per afegir un punt.',
	'gm-search' => 'Cercar',
	'gm-clear-search' => 'Neteja els resultats de la cerca',
	'gm-meters' => 'Metres',
	'gm-miles' => 'Milles',
	'gm-editing-path' => 'Fes click sobre el mapa per afegir m&eacute;s punts a aquesta ruta.',
	'gm-save-path' => 'Guardar',
	'gm-edit-path' => 'afegir punts',
	'gm-color-path' => 'canviar el color',
	'gm-make-map' => 'inserir un mapa',
	'gm-hide-map' => 'ocultar el mapa',
);

$wgGoogleMapsMessages['cn'] = array(
	'gm-make-marker' => '建立标记 (wiki mark-up OK):',
	'gm-remove' => '移除',
	'gm-caption' => '说明',
	'gm-tab-title' => 'Tab 标题名称',
	'gm-tab' => 'Tab',
	'gm-start-path' => '开始路径',
	'gm-save-point' => '保存 &amp; 关闭',
	'gm-load-map-from-article' => '从文章中读取已经存在的地图文件:',
	'gm-no-maps' => '在本文章中找不到存在的地图.',
	'gm-refresh-list' => '刷新列表',
	'gm-load-map' => '读取地图',
	'gm-clip-result' => '添加地图',
	'gm-no-results' => '抱歉,没有相关纪录',
	'gm-searching' => '搜索中...',
	'gm-map' => '卫星地图',
	'gm-note' => '注意: 在你保存,预览,重新读取地图之前,请确定你已经粘贴系统生成的地图代码到该编辑的文章中!',
	'gm-instructions' => '以下是 维基百科卫星地图上的标记链接.',
	'gm-are-you-sure' => '是否确定?',
	'gm-clear-all-points' => '清除全部标记',
	'gm-refresh-points' => '刷新标记',
	'gm-width' => '宽',
	'gm-height' => '高',
	'gm-scale-control' => '比例',
	'gm-overview-control' => '移动控制',
	'gm-selector-control' => 'Map/Satellite 选择',
	'gm-zoom-control' => '比例控制',
	'gm-large' => '大',
	'gm-medium' => '中',
	'gm-small' => '小',
	'gm-no-zoom-control' => '没有比例大小控制',
	'gm-yes' => '是',
	'gm-no' => '否',
	'gm-search-preface' => '点击地图以搜索一个标记, 或转到一个城市, 国家, 地址 或 商情:',
	'gm-geocode-preface' => '点击地图以添加一个标记, 或转到一个城市, 国家, 地址 或 商业信息:',
	'gm-no-search-preface' => '没有搜索结果, 请点击地图添加一个标记.',
	'gm-search' => '搜索',
	'gm-clear-search' => '清除搜索结果',
	'gm-meters' => '米',
	'gm-miles' => '英里',
	'gm-editing-path' => '点击地图上多个位置以添加一条经过这些位置的路径.',
	'gm-save-path' => '保存',
	'gm-edit-path' => '编辑路径',
	'gm-color-path' => '改变颜色',
	'gm-make-map' => '添加一个卫星地图',
	'gm-hide-map' => '隐藏此地图',
);

$wgGoogleMapsMessages['de'] = array(
	'gm-incompatible-browser' => 'Um die Karte sehen zu k&ouml;nnen, die hier angezeigt werden soll, brauchen Sie einen <a href="http://local.google.com/support/bin/answer.py?answer=16532&amp;topic=1499">kompatiblen Browser</a>.',
	'gm-no-editor' => 'Leider unterst&uuml;tzt Ihr Browser den interaktiven Karten-Editor nicht. Versuchen Sie es mit der neuesten Version von <a href="http://www.mozilla.org/products/firefox">Firefox</a> (Windows, Mac und Linux) oder <a href="http://www.microsoft.com/ie">Internet Explorer</a> (Windows).',
	'gm-make-marker' => 'Beschreibung (Wiki-Syntax ist OK):',
	'gm-remove' => 'Entfernen',
	'gm-caption' => 'Beschreibung',
	'gm-tab-title' => 'Karteireiter-Titel',
	'gm-tab' => 'Karteireiter',
	'gm-start-path' => 'Pfad beginnen',
	'gm-save-point' => 'Speichern',
	'gm-load-map-from-article' => 'Lade Karte aus Artikel:',
	'gm-no-maps' => 'Diese Artikel enth&auml;lt keine Karten.',
	'gm-refresh-list' => 'Liste neu laden',
	'gm-load-map' => 'Karte laden',
	'gm-clip-result' => 'Zu Karte hinzuf&uuml;gen',
	'gm-no-results' => 'Sorry, keine Ergebnisse',
	'gm-searching' => 'Suche...',
	'gm-map' => 'Karte',
	'gm-note' => 'Achtung: Kopieren Sie die Wiki-Syntax in den Artikel (unten), bevor Sie "Karte laden", "Speichern" oder "Vorschau" klicken!',
	'gm-instructions' => 'Die n&ouml;tige Wiki-Syntax um diese Karte zu erzeugen:',
	'gm-are-you-sure' => 'Sind Sie sicher?',
	'gm-clear-all-points' => 'Alle Punkte entfernen',
	'gm-refresh-points' => 'Punkte neu laden',
	'gm-width' => 'Breite',
	'gm-height' => 'H&ouml;he',
	'gm-scale-control' => 'Ma&szlig;stab',
	'gm-overview-control' => '&Uuml;bersichtskarte',
	'gm-selector-control' => 'Karten/Sat-Ansicht',
	'gm-zoom-control' => 'Navigation',
	'gm-large' => 'Gro&szlig;',
	'gm-medium' => 'Mittel',
	'gm-small' => 'Klein',
	'gm-no-zoom-control' => 'Aus',
	'gm-yes' => 'Ja',
	'gm-no' => 'Nein',
	'gm-search-preface' => 'Klicken Sie auf die Karte, um einen Punkt hinzuzuf&uuml;gen. Oder springen Sie zu einer Stadt, Land, Adresse, oder Gesch&auml;ft:',
	'gm-geocode-preface' => 'Klicken Sie auf die Karte, um einen Punkt hinzuzuf&uuml;gen. Oder springen Sie zu einer Stadt, Land oder Adresse:',
	'gm-no-search-preface' => 'Klicken Sie auf die Karte, um einen Punkt hinzuzuf&uuml;gen.',
	'gm-search' => 'Suchen',
	'gm-clear-search' => 'Suchergebnis l&ouml;schen',
	'gm-meters' => 'Meter',
	'gm-miles' => 'Meilen',
	'gm-editing-path' => 'Klicken Sie auf die Karte, um diesen Pfad zu verl&auml;ngern.',
	'gm-save-path' => 'Speichern',
	'gm-edit-path' => 'Punkte hinzuf&uuml;gen',
	'gm-color-path' => 'Farbe &auml;ndern',
	'gm-make-map' => 'Karte erstellen',
	'gm-hide-map' => 'Karte verbergen',
);

$wgGoogleMapsMessages['es'] = array(
	'gm-incompatible-browser' => 'Para ver el mapa que hay en esta p&aacute;gina, necesitas usar un <a href="http://local.google.com/support/bin/answer.py?answer=16532&amp;topic=1499">navegador compatible</a>.',
	'gm-no-editor' => 'Desgraciadamente, tu navegador no soporta la funci&oacute;n interactiva de construcci&oacute;n de mapas. Prueba la &oucute;ltima versi&oacute;n de <a href="http://www.microsoft.com/ie">Internet Explorer</a> (Windows) o <a href="http://www.mozilla.org/products/firefox">Firefox</a> (Windows, Mac y Linux).',
	'gm-make-marker' => 'Leyenda (sintaxis wiki OK):',
	'gm-remove' => 'eliminar',
	'gm-caption' => 'Leyenda',
	'gm-tab-title' => 'T&iacute;tulo de tab',
	'gm-tab' => 'Tab',
	'gm-start-path' => 'inicia una ruta',
	'gm-save-point' => 'guarda y cierra',
	'gm-load-map-from-article' => 'Carga un mapa desde el art&iacute;culo:',
	'gm-no-maps' => 'No hay mapas que cargar es este art&iacute;culo.',
	'gm-refresh-list' => 'Recarga la lista',
	'gm-load-map' => 'Carga el mapa',
	'gm-clip-result' => 'A&#241;ade al mapa',
	'gm-no-results' => 'Lo siento, no hay resultados',
	'gm-searching' => 'buscando...',
	'gm-map' => 'Mapa',
	'gm-note' => 'Nota: asegurate de copiar lo que quieras salvar dentro del art&iacute;culo (debajo) antes de pulsar "Carga el mapa", "Grabar la p&aacute;gina" o "Mostrar previsualizar"!',
	'gm-instructions' => 'Debajo tienes la sintaxis Wiki para crear el mapa.',
	'gm-are-you-sure' => 'Est&aacute;s seguro?',
	'gm-clear-all-points' => 'Elimina todos los puntos',
	'gm-refresh-points' => 'Recarga los puntos',
	'gm-width' => 'Ancho',
	'gm-height' => 'Alto',
	'gm-scale-control' => 'Escala',
	'gm-overview-control' => 'Overview',
	'gm-selector-control' => 'Selector Mapa/Sat&iecute;lite',
	'gm-zoom-control' => 'Tama&#241;o',
	'gm-large' => 'Grande',
	'gm-medium' => 'Mediano',
	'gm-small' => 'Peque&#241;o',
	'gm-no-zoom-control' => 'Ninguno',
	'gm-yes' => 'S&iacute;',
	'gm-no' => 'No',
	'gm-search-preface' => 'Haz click sobre el mapa para a&#241;adir un punto, o v&eacute; a una ciudad, pa&iacute;s, direcci&oacute;n o negocio:',
	'gm-geocode-preface' => 'Haz click sobre el mapa para a&#241;adir un punto, o v&eacute; a una ciudad, pa&iacute;s, o direcci&oacute;n:',
	'gm-no-search-preface' => 'Haz click sobre el mapa para a&#241;adir un punto.',
	'gm-search' => 'Buscar',
	'gm-clear-search' => 'Limpia los resultados de la b&uacute;squeda',
	'gm-meters' => 'Metros',
	'gm-miles' => 'Millas',
	'gm-editing-path' => 'Haz click en el mapa para a&#241;adir m&aacute;s puntos a esta ruta.',
	'gm-save-path' => 'Guardar',
	'gm-edit-path' => 'a&#241;adir puntos',
	'gm-color-path' => 'cambiar el color',
	'gm-make-map' => 'insertar un mapa',
	'gm-hide-map' => 'ocultar mapa',
);

$wgGoogleMapsMessages['fr'] = array(
	'gm-incompatible-browser' => 'Pour voir la carte qui devrait &ecirc;tre dans cette espace, utilisez un <a href="http://local.google.com/support/bin/answer.py?answer=16532&amp;topic=1499">navigateur compatible</a>.',
	'gm-no-editor' => 'Malheureusement, votre navigateur ne supporte pas la cr&eacute;ation interactive de carte. Essayez d\'installer la derni&egrave;re version de <a href="http://www.mozilla.org/products/firefox">Firefox</a> (Windows, Mac, and Linux) ou au pire <a href="http://www.microsoft.com/ie">Internet Explorer</a> (Windows)',
	'gm-make-marker' => 'Légende (wiki annotation OK):',
	'gm-remove' => 'Enlever',
	'gm-caption' => 'Légende',
	'gm-tab-title' => 'Titre de l\'onglet',
	'gm-tab' => 'Onglet',
	'gm-start-path' => 'Démarrer le trajet',
	'gm-save-point' => 'Enregistrer & fermer',
	'gm-load-map-from-article' => 'Charger une carte de l\'article:',
	'gm-no-maps' => 'Pas de carte dans cet article &agrave; charger.',
	'gm-refresh-list' => 'Mettre &agrave; jour la liste',
	'gm-load-map' => 'Charger la carte',
	'gm-clip-result' => 'Ajouter &agrave; la carte',
	'gm-no-results' => 'Désolé, pas de r&eacute;sultats',
	'gm-searching' => 'Recherche...',
	'gm-map' => 'Carte',
	'gm-note' => 'Note: assurez vous d\'avoir bien copi&eacute; ce que vous voulez enregistrer dans l\'article avant de cliquer sur "Charger la carte", "Enregistrer" ou "Preview"!',
	'gm-instructions' => 'Si dessous, l\'annotation wiki pour cr&eacute;er la carte obtenue au dessus.',
	'gm-are-you-sure' => 'Etes-vous sur ?',
	'gm-clear-all-points' => 'Enlever tous les points',
	'gm-refresh-points' => 'Mettre &agrave; jour les points',
	'gm-width' => 'Largeur',
	'gm-height' => 'Hauteur',
	'gm-scale-control' => 'Echelle',
	'gm-overview-control' => 'Vue d\'ensemble',
	'gm-selector-control' => 'Selection Carte/Satelite',
	'gm-zoom-control' => 'Navigation',
	'gm-large' => 'Grande',
	'gm-medium' => 'Moyenne',
	'gm-small' => 'Petite',
	'gm-no-zoom-control' => 'Non',
	'gm-yes' => 'Oui',
	'gm-no' => 'Non',
	'gm-search-preface' => 'Cliquez sur la carte pour ajouter un point ou se déplacer vers une ville, pays, adresse:',
	'gm-search' => 'Rechercher',
	'gm-clear-search' => 'Nettoyer les r&eacute;sultats des recherches',
	'gm-meters' => 'm&egrave;tres',
	'gm-miles' => 'gm-miles',
	'gm-editing-path' => 'Cliquez sur la carte pour ajouter d\'autres points &agrave; ce trajet.',
	'gm-save-path' => 'Sauvegarder',
	'gm-edit-path' => 'Ajouter des points',
	'gm-color-path' => 'Changer de couleur',
	'gm-make-map' => 'Créer une carte',
	'gm-hide-map' => 'Cacher la carte'
);

$wgGoogleMapsMessages['nl'] = array(
	'gm-incompatible-browser' => 'om de kaart te kunnen zien, die hier zichtbaar zou moeten zijn, dien je gebruik te maken van een <a href="http://local.google.com/support/bin/answer.py?answer=16532&amp;topic=1499">geschikte browser</a>.',
	'gm-no-editor' => 'jammer genoeg ondersteunt je browser de interactieve kaart-editor niet. Probeer het eens met de nieuwste versie van <a href="http://www.mozilla.org/products/firefox">Firefox</a> (Windows, Mac en Linux) of <a href="http://www.microsoft.com/ie">Internet Explorer</a> (Windows).',
	'gm-make-marker' => 'beschrijving (wiki-syntax is OK):',
	'gm-remove' => 'verplaatsen',
	'gm-caption' => 'omschrijving',
	'gm-tab-title' => 'tab-titel',
	'gm-tab' => 'Tab',
	'gm-start-path' => 'pad beginnen',
	'gm-save-point' => 'punt opslaan',
	'gm-load-map-from-article' => 'laad kaart uit artikel',
	'gm-no-maps' => 'dit artikel bevat geen kaart',
	'gm-refresh-list' => 'lijst verversen',
	'gm-load-map' => 'kaart laden',
	'gm-clip-result' => 'aan kaart toevoegen',
	'gm-no-results' => 'excuses, geen resultaat',
	'gm-searching' => 'zoekt...',
	'gm-map' => 'kaart',
	'gm-note' => 'waarschuwing: kopieer de wiki-syntax in het artikel alvorens je de kaart laadt, het artikel opslaat of op "voorbeeld" klikt!',
	'gm-instructions' => 'de benodigde wiki-syntax om de kaart in te voegen:',
	'gm-are-you-sure' => 'bent je zeker?',
	'gm-clear-all-points' => 'alle punten wissen',
	'gm-refresh-points' => 'punten opnieuw laden',
	'gm-width' => 'breedte',
	'gm-height' => 'hoogte',
	'gm-scale-control' => 'schaal',
	'gm-overview-control' => 'overzichtskaart',
	'gm-selector-control' => 'kaart/satelliet',
	'gm-zoom-control' => 'navigatie',
	'gm-large' => 'groot',
	'gm-medium' => 'middel',
	'gm-small' => 'klein',
	'gm-no-zoom-control' => 'uit',
	'gm-yes' => 'ja',
	'gm-no' => 'nee',
	'gm-search-preface' => 'Klik op de kaart om een punt in te voegen. Of spring naar een stad, land of adres:',
	'gm-search' => 'zoeken',
	'gm-clear-search' => 'zoekopdracht wissen',
	'gm-meters' => 'gm-meters',
	'gm-miles' => 'mijlen',
	'gm-editing-path' => 'Klik op de kaart om het pad te wijzigen.',
	'gm-save-path' => 'pad opslaan',
	'gm-edit-path' => 'pad wijzigen',
	'gm-color-path' => 'kleur veranderen',
	'gm-make-map' => 'kaart maken',
	'gm-hide-map' => 'kaart verbergen',
);

$wgGoogleMapsMessages['ru'] = array(
	'gm-incompatible-browser' => 'Для просмотра карты воспользуйтесь <a href=\"http://local.google.com/support/bin/answer.py?answer=16532&amp;topic=1499\">совместимым броузером</a>.',
	'gm-no-editor' => 'К сожалению, ваш броузер на поддерживает функцию создания интерактивных карт. Воспользуйтесь свежей версией <a href=\"http://www.microsoft.com/ie\">Internet Explorer</a> (Windows) или <a href=\"http://www.mozilla.org/products/firefox\">Firefox</a> (Windows, Mac и Linux).',
	'gm-make-marker' => 'Маркер (возможна вики-разметка):',
	'gm-remove' => 'Удалить',
	'gm-caption' => 'Маркер',
	'gm-tab-title' => 'Название пометки',
	'gm-tab' => 'Пометка',
	'gm-start-path' => 'Проложить маршрут',
	'gm-save-point' => 'Сохранить &amp; закрыть',
	'gm-load-map-from-article' => 'Загрузить карту из статьи:',
	'gm-no-maps' => 'В этот статье нет карт для загрузки.',
	'gm-refresh-list' => 'Обновить список',
	'gm-load-map' => 'Загрузить карту',
	'gm-clip-result' => 'Добавить карту',
	'gm-no-results' => 'Извините, ничего не найдено',
	'gm-searching' => 'Ищем-с...',
	'gm-map' => 'Карта',
	'gm-note' => 'Внимание: Сохраните полученный код в статье (см. ниже) перед тем, как \"Загрузить карту\", \"Сохранить\" или \"Предварительный просмотр\"!',
	'gm-instructions' => 'Вики-разметка для создания карты.',
	'gm-are-you-sure' => 'Вы уверены?',
	'gm-clear-all-points' => 'Удалить все точки',
	'gm-refresh-points' => 'Обновить точки',
	'gm-width' => 'Ширина',
	'gm-height' => 'Высота',
	'gm-scale-control' => 'Шкала',
	'gm-overview-control' => 'Общий вид',
	'gm-selector-control' => 'Выбор Карта/Спутник',
	'gm-zoom-control' => 'Навигация',
	'gm-large' => 'Большой',
	'gm-medium' => 'Средний',
	'gm-small' => 'Маленький',
	'gm-no-zoom-control' => 'Нет',
	'gm-yes' => 'Да',
	'gm-no' => 'Нет',
	'gm-search-preface' => 'Щелкните по карте для добавления точки или поиска города, страны, адреса или бизнеса:',
	'gm-geocode-preface' => 'Щелкните по карте для добавления точки или поиска города, страны или адреса:',
	'gm-no-search-preface' => 'Щелкните по карте для добавления точки.',
	'gm-search' => 'Поиск',
	'gm-clear-search' => 'Удалить результаты поиска',
	'gm-meters' => 'метры',
	'gm-miles' => 'мили',
	'gm-editing-path' => 'Click the map to add more points to this path.',
	'gm-save-path' => 'Сохранить',
	'gm-edit-path' => 'Добавить точки',
	'gm-color-path' => 'Изменить цвет',
	'gm-make-map' => 'Сделать карту',
	'gm-hide-map' => 'Спрятать карту',
);
