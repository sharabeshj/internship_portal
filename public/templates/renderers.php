<?php
    function prepareAttribute($name, $value, $mandatory=true){
        $attribute = '';
        if($mandatory || $value || $value === 0 || $value === '0'){
            $attribute = ' '.$name.'="'.htmlspecialchars($value).'"';
        }
        return $attribute;
    }

    function renderHTML($contentRenderer=null){
        echo '<html>';
            if($contentRenderer) $contentRenderer(); 
        echo '</html>';       
    }

    function renderHead($contentRenderer=null){
        echo '<head>';
            if($contentRenderer) $contentRenderer();
        echo '</head>';
    }

    

?>