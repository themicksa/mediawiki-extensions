<?php
// Portuguese (Lugusto)
$messages = array(
	'makevalidate-autosum'  => 'promovido automaticamente',
	'group-editor'          => 'Editores',
	'grouppage-editor'      => '{{ns:project}}:{{int:group-editor}}',
	'reviewer'              => 'Crítico',
	'group-reviewer'        => 'Críticos',
	'group-reviewer-member' => 'Crítico',
	'grouppage-reviewer'    => '{{ns:project}}:{{int:group-reviewer}}',
	'revreview-current'     => 'Esboço',
	'revreview-edit'        => 'Editar esboço',
	'revreview-source'      => 'código do esboço',
	'revreview-stable'      => 'Estável',
	'revreview-oldrating'   => 'Esteve avaliada como:',
	'revreview-noflagged'   => 'Não há edições críticas para esta página; talvez ainda \'\'\'não\'\'\' tenha sido [[{{ns:help}}:Validação de páginas|verificada]] a sua qualidade.',
	'revreview-quick-none'  => '\'\'\'Crítica\'\'\'. Não há edições críticas.',
	'revreview-quick-see-quality' => '\'\'\'Atual\'\'\'. [[{{fullurl:{{FULLPAGENAMEE}}|stable=1}} ver edição estável]] ($2 [{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur&editreview=1}} {{plural:$2|alteração|alterações}}])',
	'revreview-quick-see-basic' => '\'\'\'Atual\'\'\'. [[{{fullurl:{{FULLPAGENAMEE}}|stable=1}} ver edição estável]] ($2 [{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur&editreview=1}} {{plural:$2|alteração|alterações}}])',
	'revreview-quick-basic' => '\'\'\'[[{{ns:help}}:Validação de páginas|Crítica]]\'\'\'. [[{{fullurl:{{FULLPAGENAMEE}}|stable=0}} ver edição atual]] ($2 [{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur&editreview=1}} {{plural:$2|alteração|alterações}}])',
	'revreview-quick-quality' => '\'\'\'[[{{ns:help}}:Validação de páginas|Estável]]\'\'\'. [[{{fullurl:{{FULLPAGENAMEE}}|stable=0}} ver edição atual]] ($2 [{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur&editreview=1}} {{plural:$2|alteração|alterações}}])',
	'revreview-newest-basic' => 'A [{{fullurl:{{FULLPAGENAMEE}}|stable=1}} mais recente edição crítica] ([{{fullurl:Special:Stableversions|page={{FULLPAGENAMEE}}}} listar todas]) foi [{{fullurl:Special:Log|type=review&page={{FULLPAGENAMEE}}}} aprovada]
	 em <i>$2</i>. [{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur&editreview=1}} $3 {{plural:$3|alteração|alterações}}] {{plural:$3|necessita|necessitam}} análise.',
	'revreview-newest-quality' => 'A [{{fullurl:{{FULLPAGENAMEE}}|stable=1}} mais recente edição crítica] ([{{fullurl:Special:Stableversions|page={{FULLPAGENAMEE}}}} listar todas]) foi [{{fullurl:Special:Log|type=review&page={{FULLPAGENAMEE}}}} aprovada] em <i>$2</i>. [{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur&editreview=1}} $3 {{plural:$3|alteração|alterações}}] {{plural:$3|necessita|necessitam}} análise.',
	'revreview-basic'       => 'Esta é a mais recente edição [[{{ns:help}}:Validação de páginas|crítica]] desta página, [{{fullurl:Special:Log|type=review&page={{FULLPAGENAMEE}}}} aprovada] em <i>$2</i>. É possível [{{fullurl:{{FULLPAGENAMEE}}|action=edit}} editar] a [{{fullurl:{{FULLPAGENAMEE}}|stable=0}} versão atual]; [{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur&editreview=1}} $3 {{plural:$3|alteração|alterações}}] {{plural:$3|aguarda|aguardam}} revisão.',
	'revreview-quality'     => 'Esta é a mais recente edição [[{{ns:help}}:Validação de páginas|estável]], [{{fullurl:Special:Log|type=review&page={{FULLPAGENAMEE}}}} aprovada] em <i>$2</i>. É possível [{{fullurl:{{FULLPAGENAMEE}}|action=edit}} editar] a [{{fullurl:{{FULLPAGENAMEE}}|stable=0}} versão atual]; [{{fullurl:{{FULLPAGENAMEE}}|oldid=$1&diff=cur&editreview=1}} $3 {{plural:$3|alteração|alterações}}] {{plural:$3|aguarda|aguardam}} revisão.',
	'revreview-static'      => 'Esta é uma edição [[{{ns:help}}:Validação de páginas|crítica]] da \'\'\'[[:$3|$3]]\'\'\', [{{fullurl:Special:Log/review|page=$1}} aprovada] em <i>$2</i>. É possível [{{fullurl:{{FULLPAGENAMEE}}|action=edit}} editar] a [{{fullurl:{{FULLPAGENAMEE}}|stable=0}} versão atual].',
	'revreview-note'        => '[[{{ns:user}}:$1|$1]] deixou as seguintes observações ao [[{{ns:help}}:Validação de páginas|criticar]] esta edição:',
	'revreview-update'      => 'Por gentileza, analise todas as alterações exibidas a seguir, feitas desde a última edição estável desta página. Talvez as predefinições e imagens utilizadas possam ter sido também alteradas.',
	'revreview-auto'        => '(automático)',
	'revreview-auto-w'      => 'Você está editando a edição estável, todas as alterações serão \'\'\'automaticamente tidas como revistas\'\'\' (ed. crítica). Talvez deseje prever a página antes de a salvar.',
	'revreview-auto-w-old'  => 'Você está editando uma edição antiga, todas as alterações serão \'\'\'automaticamente tidas como revistas\'\'\' (ed. crítica). Talvez deseje prever a página antes de a salvar.',
	'hist-stable'           => '[ed. crítica]',
	'hist-quality'          => '[ed. estável]',
	'flaggedrevs'           => 'Edições Críticas',
	'review-logpage'        => 'Registo de edições críticas',
	'review-logpagetext'    => 'Este é um registo de alterações de status de páginas de conteúdo com [[{{ns:help}}:Validação de páginas|edições críticas]].',
	'review-logaction'      => 'ID de edição: $1',
	'revisionreview'        => 'Criticar edições',
	'revreview-main'        => 'Você precisa selecionar uma edição em específico de uma página de conteúdo para poder fazer uma edição crítica.

Veja [[{{ns:special}}:Unreviewedpages]] para uma listagem de páginas ainda não criticadas.',
	'revreview-selected'    => 'Edição selecionada de \'\'\'$1:\'\'\'',
	'revreview-text'        => 'As edições aprovadas são exibidas por padrão no lugar de edições mais recentes.',
	'revreview-toolow'      => 'Você precisará criticar em cada um dos atributos com valores mais altos do que "rejeitada" para que uma edição seja considerada aprovada. Para rebaixar uma edição, defina todos os atributos como "rejeitada".',
	'revreview-flag'        => 'Critique esta edição (#$1)',
	'revreview-legend'      => 'Avaliar conteúdo da edição',
	'revreview-notes'       => 'Observações ou notas a serem exibidas:',
	'revreview-accuracy'    => 'Precisão',
	'revreview-accuracy-0'  => 'Rejeitada',
	'revreview-accuracy-1'  => 'Objetiva',
	'revreview-accuracy-2'  => 'Precisa',
	'revreview-accuracy-3'  => 'Bem referenciada',
	'revreview-accuracy-4'  => 'Exemplar',
	'revreview-depth'       => 'Profundidade',
	'revreview-depth-0'     => 'Rejeitada',
	'revreview-depth-1'     => 'Básica',
	'revreview-depth-2'     => 'Moderada',
	'revreview-depth-3'     => 'Alta',
	'revreview-depth-4'     => 'Exemplar',
	'revreview-style'       => 'Inteligibilidade',
	'revreview-style-0'     => 'Rejeitada',
	'revreview-style-1'     => 'Aceitável',
	'revreview-style-2'     => 'Boa',
	'revreview-style-3'     => 'Concisa',
	'revreview-style-4'     => 'Exemplar',
	'revreview-log'         => 'Comentário exibido no registo:',
	'revreview-submit'      => 'Enviar crítica',
	'revreview-changed'     => '\'\'\'A acção seleccionada não pode ser executada nesta edição.\'\'\'
	
Uma predefinição ou imagem pode ter sido requisitada sem uma edição específica ter sido informada. Isso pode ocorrer quando uma predefinição dinâmica faz transclusão de outra imagem ou predefinição através de uma variável que pode ter sido alterada enquanto era feita a edição crítica nesta página. Recarregar a página e enviar uma nova edição crítica talvez seja suficiente para contornar este contratempo.',
	'stableversions'        => 'Edições Críticas',
	'stableversions-leg1'   => 'Listar edições críticas de uma página',
	'stableversions-page'   => 'Título da página',
	'stableversions-none'   => '[[:$1]] não possui edições críticas.',
	'stableversions-list'   => 'A seguir, uma lista das edições de "[[:$1]]" que são edições críticas:',
	'stableversions-review' => 'Criticada em <i>$1</i> por $2',
	'review-diff2stable'    => 'Comparar com a edição crítica mais recente',
	'review-diff2oldest'    => 'Comparar com a edição mais antiga',
	'unreviewedpages'       => 'Páginas sem edições críticas',
	'viewunreviewed'        => 'Listar páginas de conteúdo que ainda não possuam uma edição crítica',
	'unreviewed-outdated'   => 'Substituir pelas páginas que possuem edição crítica mas sofreram alterações que ainda não foram revistas.',
	'unreviewed-category'   => 'Categoria',
	'unreviewed-diff'       => 'Alterações',
	'unreviewed-list'       => 'Esta página lista as páginas de conteúdo que ainda não receberam uma edição crítica ou que possuam uma nova edição a ser analisada.',
);
