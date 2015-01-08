<?php

/*
 * Контроллер відповідає за роботу по збереженню та cut аватарки
 */

class LogoController extends Controller
{
    public function actionIndex()
    {
        $model = new LogoFile;
        $dir_full = Yii::getPathOfAlias('application.data.uploads.logo.full');
        $dir_small = Yii::getPathOfAlias('application.data.uploads.logo.small');
        $fullLink = false;
        $linkLogoPicture = false;
        $linkLogoPictureSmall = false;
        $uploaded = false;

        $lawyer = Lawyer::model()->findByPk(Yii::app()->user->getId());
        if($lawyer===null){
            throw new CHttpException(400, 'Пустой массив юриста');
            Yii::app()->end();
        }else{
            if((isset($_POST['LogoFile'])))
            {
                $model->attributes=$_POST['LogoFile'];
                $file = CUploadedFile::getInstance($model,'file');
                if($model->validate()){
                    Yii::import('main.controllers.RegistryController');
                    Yii::import('profile.controllers.EditController');
                    $fileName = $lawyer->id.'_'.RegistryController::generatePassword(64);
                    $fullName = $fileName.'.'.EditController::getExtensionOnType($file->getType());
                    $fullLink = $dir_full.'/'.$fullName;
                    $uploaded = $file->saveAs($fullLink);


                    $filename = $fullLink;
                    list($width, $height) = getimagesize($filename);
                    $new_width = 400; //Новая ширина
                    $new_height = 0; //Висота

                    $k = $new_width/$width;
                    $new_height = $k*$height;

                    $jpeg_quality = 80;

                    $size=getimagesize($filename);
                    switch($size["mime"]){
                        case "image/jpeg":

                            $image_p = imagecreatetruecolor($new_width, $new_height);
                            $image = imagecreatefromjpeg($filename);
                            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                            imagejpeg($image_p,$filename, 70);

                            break;
                        case "image/gif":

                            $image_p = imagecreatetruecolor($new_width, $new_height);
                            $image = imagecreatefromgif($filename);
                            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                            imagegif($image_p,$filename, 70);

                            break;
                        case "image/png":

                            $image_p = imagecreatetruecolor($new_width, $new_height);
                            $image = imagecreatefrompng($filename);
                            imagecopyresampled($image_p, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                            imagepng($image_p,$filename, 8);

                            break;
                    }


                    if($uploaded){

                        if($lawyer->logo_full){
                            @unlink($dir_full.'/'.$lawyer->logo_full);
                            $lawyer->logo_full = null;
                        }
                        if($lawyer->logo_small){
                            @unlink($dir_small.'/'.$lawyer->logo_small);
                            $lawyer->logo_small = null;
                        }
                        $lawyer->save(false);

                        $lawyer->logo_full = $fullName;
                        $lawyer->save(false);
                        $this->refresh();
                    }
                }
            }

            if($lawyer->logo_full!=null){
                $linkLogoPicture = 'http://'.$_SERVER['SERVER_NAME'].Yii::app()->assetManager->publish($dir_full).'/'.$lawyer->logo_full;
            }
            if($lawyer->logo_small!=null){
                $linkLogoPictureSmall = Yii::app()->assetManager->publish($dir_small.'/'.$lawyer->logo_full);
            }

            $this->layout='/edit/layouts/panelTopLawyer';
            $this->render('/edit/lawyer/logoForm',array('model'=>$model,'linkLogoPicture'=>$linkLogoPicture,'linkLogoPictureSmall'=>$linkLogoPictureSmall,'dir_small'=>$dir_small));

        }
    }

    public function actionRemove(){
        $lawyer = Lawyer::model()->findByPk(Yii::app()->user->getId());
        if($lawyer===null){
            throw new CHttpException(400, 'Пустой массив юриста');
            Yii::app()->end();
        }else{
            if($lawyer->logo_full){
                @unlink($dir_full.'/'.$lawyer->logo_full);
                $lawyer->logo_full = null;
            }
            if($lawyer->logo_small){
                @unlink($dir_small.'/'.$lawyer->logo_small);
                $lawyer->logo_small = null;
            }
            $lawyer->save(false);
            $this->redirect(array('index'));
        }
    }

    //Ф. обрезки фотографии
    public function actionAct(){
        function resize($file_input, $file_output, $w_o, $h_o, $percent = false) {
            list($w_i, $h_i, $type) = getimagesize($file_input);
            if (!$w_i || !$h_i) {
                throw new CHttpException(400, 'Невозможно получить длину и ширину изображения');
                Yii::app()->end();
                return;
            }
            $types = array('','gif','jpeg','png');
            $ext = $types[$type];
            if ($ext) {
                $func = 'imagecreatefrom'.$ext;
                $img = $func($file_input);
            } else {
                throw new CHttpException(400, 'Некорректный формат файла');
                Yii::app()->end();
                return;
            }
            if ($percent) {
                $w_o *= $w_i / 100;
                $h_o *= $h_i / 100;
            }
            if (!$h_o) $h_o = $w_o/($w_i/$h_i);
            if (!$w_o) $w_o = $h_o/($h_i/$w_i);
            $img_o = imagecreatetruecolor($w_o, $h_o);
            imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
            if ($type == 2) {
                imagejpeg($img_o,$file_output,100);
            } else {
                $func = 'image'.$ext;
                $func($img_o,$file_output);
            }

            imagedestroy($img_o);
        }

        function crop($file_input, $file_output, $crop = 'square',$percent = false) {
            list($w_i, $h_i, $type) = getimagesize($file_input);
            if (!$w_i || !$h_i) {
                throw new CHttpException(400, 'Невозможно получить длину и ширину изображения');
                Yii::app()->end();
                return;
            }
            $types = array('','gif','jpeg','png');
            $ext = $types[$type];
            if ($ext) {
                $func = 'imagecreatefrom'.$ext;
                $img = $func($file_input);
            } else {
                throw new CHttpException(400, 'Некорректный формат файла');
                Yii::app()->end();
                return;
            }
            if ($crop == 'square') {
                $min = $w_i;
                if ($w_i > $h_i) $min = $h_i;
                $w_o = $h_o = $min;
            } else {
                list($x_o, $y_o, $w_o, $h_o) = $crop;
                if ($percent) {
                    $w_o *= $w_i / 100;
                    $h_o *= $h_i / 100;
                    $x_o *= $w_i / 100;
                    $y_o *= $h_i / 100;
                }
                if ($w_o < 0) $w_o += $w_i;
                $w_o -= $x_o;
                if ($h_o < 0) $h_o += $h_i;
                $h_o -= $y_o;
            }
            $img_o = imagecreatetruecolor($w_o, $h_o);
            imagecopy($img_o, $img, 0, 0, $x_o, $y_o, $w_o, $h_o);
            if ($type == 2) {
                imagejpeg($img_o,$file_output,100);

            } else {
                $func = 'image'.$ext;
                $func($img_o,$file_output);
            }

            $lawyer = Lawyer::model()->findByPk(Yii::app()->user->getId());
            if($lawyer===null){
                throw new CHttpException(400, 'Пустой массив юриста');
                Yii::app()->end();
            }else{
                $lawyer->logo_small = $lawyer->logo_full;
                $lawyer->save(false);
            }

            imagedestroy($img_o);
        }

        function prov($per){
            if (isset($per)) {
                $per = stripslashes($per);
                $per = htmlspecialchars($per);
                $per = addslashes($per);
            }
            return $per;
        }

        if(isset($_POST)){

            $lawyer = Lawyer::model()->findByPk(Yii::app()->user->getId());
            if($lawyer===null){
                throw new CHttpException(400, 'Пустой массив юриста');
                Yii::app()->end();
            }else{
                $filenew = $lawyer->logo_full;
            }

            //$filenew = time().rand(100,999).'.jpg';
            $x1 = prov($_POST['x1']);
            $x2 = prov($_POST['x2']);
            $y1 = prov($_POST['y1']);
            $y2 = prov($_POST['y2']);
            $img = prov($_POST['img']);
            //Путь куда сохранять обрезанное изображение
            $crop = Yii::getPathOfAlias('application.data.uploads.logo.small').'/';
            crop($img, $crop.$filenew, array($x1, $y1, $x2, $y2));
            echo $filenew;
        }
    }

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions'=>array('Index','Remove','Act'),
                'roles'=>array(
                    User::DLAWYER
                )
            ),
            array('deny',
                'actions'=>array('Index','Remove','Act'),
                'users'=>array('*')
            ),
        );
    }
}