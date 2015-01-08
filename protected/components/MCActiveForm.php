<?php
    class MCActiveForm extends CActiveForm
    {
        public function error($model,$attribute,$htmlOptions=array())
        {
            $optionNames = array(

                'validationDelay' => '2',
                'inputContainer' => '123',//undefined
                 /*'errorCssClass' => '',//undefined
                'successCssClass' => '',//undefined
                'validatingCssClass' => '',//undefined
                //'beforeValidateAttribute' => '',//undefined
                //'afterValidateAttribute' => '',//undefined*/

            );

            //$str = str_replace("</div>","<span class='er-top'>123</span></div>",$a);
            return CActiveForm::error($model,$attribute,$optionNames);;
        }
    }
?>