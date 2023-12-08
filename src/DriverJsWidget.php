<?php

namespace adlurfm\driverjs;

class DriverJsWidget extends \yii\base\Widget
{
    public function run()
    {
        //register asset
        DriverJsAsset::register($this->view);

        //create driverObj
        $this->registerJs();
        
    }



    private function registerJs(){
        $js_script = <<< JS
            document.addEventListener('DOMContentLoaded', function() {
                const driver = window.driver.js.driver;
                const driverObj = driver();
            });
JS;
        $this->view->registerJs($js_script, \yii\web\View::POS_END);
    }


}
