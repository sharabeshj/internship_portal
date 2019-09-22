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

    function renderLink($rel,$href,$integrity=null, $crossorigin=null){
        echo '<link',
            prepareAttribute('rel', $rel),
            prepareAttribute('href',$href),
            prepareAttribute('integrity',$integrity,false),
            prepareAttribute('crossorigin', $crossorigin, false),
            '>';
    }

    function renderScript($src,$integrity=null, $crossorigin=null, $contentRenderer=null){
        echo '<script',
            prepareAttribute('src', $src),
            prepareAttribute('integrity', $integrity, false),
            prepareAttribute('crossorigin',$crossorigin,false),
            '>';
            if($contentRenderer) $contentRenderer();
            echo '</script>';
    }

    function renderTitle($contentRenderer=null) {
        echo '<title>';
        if($contentRenderer)
            $contentRenderer();
        echo '</title>';
    }
    
    function renderBody($contentRenderer = null) {
        echo '<body>';
        if($contentRenderer) $contentRenderer();
        echo '</body>';
    }

    function renderA($href, $target = '', $contentRenderer = null) {
        echo '<a',
            prepareAttribute('href', $href),
            prepareAttribute('target',$target,false),
            '>';
            if($contentRenderer) $contentRenderer();
            echo '</a>';
    }

    function renderDiv($class=null, $contentRenderer=null)
    {
        echo '<div',
            prepareAttribute('class',$class, false),
            '>';
            if($contentRenderer) $contentRenderer();
            echo '</div>';
    }

    function renderH1($class=null, $contentRenderer=null)
    {
        echo '<h1',
            prepareAttribute('class', $class,  false),
            '>';
            if($contentRenderer) $contentRenderer();
            echo '</h1>';
    }

    function renderH2($class, $contentRenderer=null){
        echo '<h2',
            prepareAttribute('class',$class,false),
            '>';
            if($contentRenderer) $contentRenderer();
            echo '</h2>';
    }

    function renderP($class=null, $contentRenderer=null){
        echo '<p',
            prepareAttribute('class',$class, null),
            '>';
            if($contentRenderer) $contentRenderer();
            echo '</p>';
    }

    function renderForm($action, $method='GET', $contentRenderer=null){
        echo '<form',
            prepareAttribute('action', $action),
            prepareAttribute('method',$method,false),
            '>';
            if($contentRenderer) $contentRenderer();
            echo '</form>';
    }

    function renderLabel($for=null,$class=null,$contentRenderer=null){
        echo '<label',
            prepareAttribute('for',$for,false),
            prepareAttribute('class',$class,false),
            '>';
        if($contentRenderer) $contentRenderer();
        echo '</label>';
    }

    function renderInput($type, $name=null,$id=null,$class=null, $value =null){
        echo '<input',
            prepareAttribute('type',$type),
            prepareAttribute('name',$name, false),
            prepareAttribute('class',$class, false),
            prepareAttribute('id',$id,false),
            prepareAttribute('value',$value, false),
            '>';
    }

    function renderSpan($class=null,$contentRenderer=null){
        echo '<span',
            prepareAttribute('class',$class,false),
            '>';
        if($contentRenderer) $contentRenderer();
        echo '</span>';
    }

    function renderOption($name,$value=null,$selected=null, $contentRenderer=null){
        echo '<option',
            prepareAttribute('value',$value,false),
            prepareAttribute('selected',$selected,false),
            '>';
        if($contentRenderer) $contentRenderer($name);
        echo '</option>';
    }

    function renderSelect($name,$id=null,$class=null, $options=null,$contentRenderer=null){
        echo '<select',
            prepareAttribute('name',$name),
            prepareAttribute('id',$id,false),
            prepareAttribute('class',$class,false),
            '>';
        if($contentRenderer) $contentRenderer();
        foreach($options as $value => $name){
            renderOption($name,$value, null, function($name){
                echo $name;
            });
        }
        echo '</select>';
    }
?>