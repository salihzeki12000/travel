<?php
/**
 * Created by JetBrains PhpStorm.
 * User: dimitry
 * Date: 9/24/14
 * Time: 8:26 PM
 * To change this template use File | Settings | File Templates.
 */

class PlacesController extends AdminController {

    public function actionIndex($page = 0){
        $criteria = New CDbCriteria();

        $count = Places::model()->count($criteria);

        $pagination = New CPagination($count);
        $pagination->pageSize = 10;
        $pagination->currentPage = $page;
        $pagination->applyLimit($criteria);

        $pages = $pagination->pageCount;

        $places = Places::model()->findAll($criteria);

        $this->render('index', compact('places', 'pages', 'pagination'));
    }

    public function actionCreate(){
        $model = new Places();

        if(isset($_POST['Places']))
        {
            $model->attributes = Yii::app()->request->getPost('Places');

            if($model->save()){
                $images = Yii::app()->request->getPost('Images');
                foreach($images as $image){
                    if(!isset($image['id'])){
                        $uploadedImage = CUploadedFile::getInstance($image, 'file');
                        if ($uploadedImage){
                            $filename =  md5(rand(1000,9999) . time()) . '.' . $uploadedImage->getExtensionName();

                            $image = new Images();
                            $image->origanal = $filename;
                            $image->save();

                            $placeImage = new PlacesImages();
                            $placeImage->relatedPlaceId = $model->placeId;
                            $placeImage->relatedImageId = $image->imageId;
                            $placeImage->save();

                            $uploadedImage->saveAs('content/places' . $filename);
                        }
                    }
                }

                $this->redirect(array('index'));
            }
        }

        $this->render('form', array(
            'model'=>$model,
        ));
    }

    public function actionUpdate($id = null){
        if(!$id)
            throw New Exception('Ошибка! Неверное значение идентификатора страны');

        $model = Places::model()->findByPk($id);

        if(isset($_POST['Places']))
        {
            $model->attributes = Yii::app()->request->getPost('Places');
            if($model->save()){
                $images = $_FILES['Images'];
                foreach($images as $index => $image){
                    if(!isset($image['id'])){
                        $uploadedImage = CUploadedFile::getInstanceByName('Images[0][file]');
                        if ($uploadedImage){
                            $filename =  md5(rand(1000,9999) . time()) . '.' . $uploadedImage->getExtensionName();

                            $image = new Images();
                            $image->original = $filename;
                            $image->save();

                            $placeImage = new PlacesImages();
                            $placeImage->relatedPlaceId = $model->placeId;
                            $placeImage->relatedImageId = $image->imageId;
                            $placeImage->save();

                            $uploadedImage->saveAs('content/places/' . $filename);
                        }
                    }
                }

                $this->redirect(array('index'));
            }
        }

        $this->render('form', array(
            'model'=>$model,
        ));
    }

    public function actionDelete()
    {
        $id = Yii::app()->request->getPost('id');
        Places::model()->findByPk($id)->delete();
        $this->redirect(array('index'));
    }

}