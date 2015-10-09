<?php

class ZurbPresenter extends Illuminate\Pagination\Presenter {

    public function getActivePageWrapper($text){

        return '<li class="page-item active">'.$text.'</li>';
    }

    public function getDisabledTextWrapper($text){

        return '<li class="page-item unavailable">'.$text.'</li>';
    }

    public function getPageLinkWrapper($url, $page, $rel = null){

        return '<li class="page-item"><a href="'.$url.'">'.$page.'</a></li>';
    }

    public function getNext( $text = '&raquo;' ){

        $text = '>';
        
        if ($this->currentPage >= $this->lastPage){

            return $this->getDisabledTextWrapper($text);
        }

        $url = $this->paginator->getUrl($this->currentPage + 1);

        return $this->getPageLinkWrapper($url, $text, 'next');
    }

    public function getPrevious($text = '&laquo;'){

        $text = '<';

        if ($this->currentPage <= 1){

            return $this->getDisabledTextWrapper($text);
        }

        $url = $this->paginator->getUrl($this->currentPage - 1);

        return $this->getPageLinkWrapper($url, $text, 'prev');
    }

    public function render(){

        $total = 5;

        if ( $this->currentPage - 2 < 1 ){
            
            $content = $this->getPageRange( 1, $total > $this->lastPage ? $this->lastPage : $total );
        }
        else{
            $fromPage   = $this->currentPage - 2;
            $toPage     = $this->currentPage + 2;
            
            if ( $toPage > $this->lastPage ){
                $fromPage   = $fromPage - $toPage + $this->lastPage;
                $toPage     = $this->lastPage;
            }

            $content = $this->getPageRange( $fromPage, $toPage );
        }

        return $this->getPrevious().$content.$this->getNext();
    }
}