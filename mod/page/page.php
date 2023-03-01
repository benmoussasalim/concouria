<?php
    $request['p'] = $request['p'] ? $request['p'] : 'accueil';

	$page = ContentQuery::create()->filterByStatus('Publié')->filterBySlug($request['p'])->findOne();
	if(!$page){ $page = ContentQuery::create()->filterByStatus('Publié')->filterByHome('Oui')->findOne(); }

	if($page){
        $swMenu[] = [_("Modifier le contenu"),_SITE_URL.'Content/edit/'.$page->getIdContent()];
        
        $blocks = 
            BlockQuery::create()
            ->filterByIdContent($page->getIdContent())
            ->filterByStatus('Publié')
            ->orderBy('Order','ASC')
            ->orderBy('DateCreation','ASC')
            ->find()
        ;
        
        if($blocks) {
            foreach($blocks as $block) {
                $blockLg = $block->getTranslation($lang_sql);
                
                $blockContent[$block->getIdBlock()] =
                    div(
                        div($blockLg->getText(),'',swEdit('Text',true))
                    ,'',['class="sw-block" data-block="'.$block->getIdBlock().'"',swEdit('Block',$block->getIdBlock(),$block->getTitle())])
                ;
            }
        }

		if ($page->getType() == 'Contenu dynamique') {
            include _BASE_DIR.'mod/page/'.$page->getSlug().'.php';
            $content = $htmlOutput;
            
        } else { 
            $bodyClass.= "page-fixe"; 
            $content = div(div($page->getTranslation($lang_sql)->getText(),'',swEdit('Text',true)),'',swEdit('Content',$page->getIdContent(),$page->getNameMenu()));
            
            if($blockContent) { $content .= implode('',$blockContent); }
        }

	}
