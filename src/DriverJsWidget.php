<?php

namespace adlurfm\driverjs;

use yii\helpers\Json;

class DriverJsWidget extends \yii\base\Widget
{
    private $_asset;
    private $_use_button = false;
    public $steps = [];

    public function __construct() {
        //register asset
        $this->_asset = DriverJsAsset::register($this->view);
    }

    public function run()
    {
        if(empty($this->_asset))
            $this->_asset = DriverJsAsset::register($this->view);        
    }

    public function highlight($element, $title, $description, $side = "bottom"){
        $js_script = <<< JS
            document.addEventListener('DOMContentLoaded', function() {
                const driver = window.driver.js.driver;
                const driverObj = driver();

                driverObj.highlight({
                    element: "{$element}",
                    popover: {
                        side: "{$side}",
                        title: "{$title}",
                        description: "{$description}",
                    }
                });
            });
        JS;
        $this->view->registerJs($js_script, \yii\web\View::POS_END);
    }


    public function addStep($element, $title, $description, $side="left", $align="start")
    {
        $this->steps[] = [
            "element"=>$element, 
            "popover" => [ 
                "title"         => $title, 
                "description"   => $description, 
                "side"          => $side, 
                "align"         => $align 
            ]
        ];
        return $this;
    }

    public function useButton(){
        $this->_use_button = true;
        return $this;
    }

    public function build(){
        $steps = Json::encode($this->steps, $asArray = true);
        
        $js_script_btn = ($this->_use_button) ? "$('#driver-js-run-button').click(function(){ driverObj.drive(); });" : "driverObj.drive();";

        $js_script = <<< JS
            document.addEventListener('DOMContentLoaded', function() {
                const driver = window.driver.js.driver;
                const driverObj = driver({
                    showProgress: true,
                    steps: {$steps}
                });

                {$js_script_btn}
            });
        JS;

        $this->view->registerJs($js_script, \yii\web\View::POS_END); 
    }

}
