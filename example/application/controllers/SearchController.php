<?php

class SearchController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $query = trim($this->getRequest()->getQuery('q', ''));
        $this->view->query = $query;
        if (!empty($query)) {
            $count = 10;
            $page = (int) $this->getRequest()->getQuery('p', 1);
            if ($page < 1) {
                $page = 1;
            }
            
            // Perform the search!
            $boss = new Noginn_Service_YahooBoss('BEDVfQXIkY0JPLmKM6BAXwfgFt1.EEc-');
            $webResults = $boss->webSearch($query, array(
                'count' => $count,
                'start' => $count * ($page - 1),
                'sites' => 'noginn.com'
            ));
            
            // Paginate the results
            $paginator = new Zend_Paginator(new Zend_Paginator_Adapter_Null($webResults->getTotalHits()));
            $paginator->setCurrentPageNumber($page);
            $paginator->setItemCountPerPage($count);
            
            $this->view->webResults = $webResults;
            $this->view->paginator = $paginator;
        }
    }
}
