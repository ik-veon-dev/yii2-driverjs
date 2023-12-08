<?php

namespace adlurfm\driverjs;

use yii\helpers\Html;
use yii\helpers\Json;

class DriverJsWidget extends \yii\base\Widget
{
    private $_asset;
    private $_use_button = false;
    private $_button_id = "#driver-js-run-button";
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

    public function useButton($button_id = "#driver-js-run-button"){
        $this->_use_button = true;
        $this->_button_id = $button_id;
        return $this;
    }

    public function build(){
        $steps = Json::encode($this->steps);
        
        $js_script_btn = ($this->_use_button) ? "$('{$this->_button_id}').click(function(){ driverObj.drive(); });" : "driverObj.drive();";

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

    public static function helpButton($text = "", $id="driver-js-run-button"){
        return Html::a('<i class="fas fa-question-circle"></i>'.$text, '#', ['class'=>'btn btn-xs btn-outline-primary', 'id'=>$id]);
    }

}
