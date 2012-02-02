<?php

/**
 * Object for creating HTML template
 */
class ArticleCreationTemplates {

	public static function loadArticleCreationModules() {
		$action = wfMessage( 'ac-action-indicator' )->escaped();
		$createArticle = wfMessage( 'ac-action-create-article' )->escaped();
		$createArticleSubtitle = wfMessage( 'ac-action-create-article-subtitle' )->escaped();
		$stepByStep = wfMessage( 'ac-action-step-by-step' )->escaped(); 
		$stepByStepSubtitle = wfMessage( 'ac-action-step-by-step-subtitle' )->escaped();
		$redirect = wfMessage( 'ac-action-redirect' )->escaped();
		$redirectSubtitle = wfMessage( 'ac-action-redirect-subtitle' )->escaped();
		
		$html = <<<HTML
			<span class="article-creation-heading">$action</span>
			<div id="article-creation-panel">
				<div class="ac-button-wrap">
					<a class="ac-article-button ac-button-blue ac-article-create" data-ac-button="normal">
						<div class="ac-arrow ac-arrow-forward">&nbsp;</div>
						<div class="ac-button-text">
							<div class="ac-button-title">$createArticle</div>
							<div class="ac-button-body">$createArticleSubtitle</div>
						</div>
					</a>
				</div>
				<div class="ac-button-wrap">
					<a class="ac-article-button ac-button-blue ac-article-wizard" data-ac-button="wizard">
						<div class="ac-arrow ac-arrow-forward">&nbsp;</div>
						<div class="ac-button-text">
							<div class="ac-button-title">$stepByStep</div>	
							<div class="ac-button-body">$stepByStepSubtitle</div>
						</div>
					</a>
				</div>
				<div class="ac-button-wrap">
					<a class="ac-article-button ac-button-red" data-ac-button="getOut">
						<div class="ac-arrow ac-arrow-backward">&nbsp;</div>
						<div class="ac-button-text">
							<div class="ac-button-title">$redirect</div>
							<div class="ac-button-body">$redirectSubtitle</div>
						</div>
					</a>
				</div>
			</div>
HTML;

		return $html;
	}
	
}



