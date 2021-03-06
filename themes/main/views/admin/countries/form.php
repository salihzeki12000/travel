<h1>Страны</h1>
<br/>
<?php $form=$this->beginWidget('CActiveForm', array(
    'id'=>'country-form',
    'enableAjaxValidation'=>false,
    'htmlOptions'=>array(
        'class'=>'form-horizontal',
    ),
)); ?>
    <div class="form-group <?if($form->error($model,'name')):?>has-error<? endif; ?>">
        <label class="col-sm-2 control-label">Имя</label>
        <div class="col-sm-10">
            <?php echo $form->textField($model,'name', array('class'=>'form-control')); ?>
        </div>
    </div>
    <div class="form-group <?if($form->error($model,'alias')):?>has-error<? endif; ?>">
        <label class="col-sm-2 control-label">Псевдоним</label>
        <div class="col-sm-10">
            <?php echo $form->textField($model,'alias', array('class'=>'form-control')); ?>
        </div>
    </div>
    <div class="form-group <?if($form->error($model,'relatedDestinationId')):?>has-error<? endif; ?>">
        <label class="col-sm-2 control-label">Направление</label>
        <div class="col-sm-10">
            <?php echo $form->dropDownList($model, 'relatedDestinationId', CHtml::listData(Destinations::model()->findAll(), 'destinationId', 'name'), array('class'=>'form-control')); ?>
        </div>
    </div>
    <div class="form-group <?if($form->error($model,'shortDescription')):?>has-error<? endif; ?>">
        <label class="col-sm-2 control-label">Краткое описание</label>
        <div class="col-sm-10">
            <?php echo $form->textArea($model,'shortDescription', array('class'=>'redactor')); ?>
        </div>
    </div>
    <div class="form-group <?if($form->error($model,'fullDescription')):?>has-error<? endif; ?>">
        <label class="col-sm-2 control-label">Полное описание</label>
        <div class="col-sm-10">
            <?php echo $form->textArea($model,'fullDescription', array('class'=>'redactor')); ?>
        </div>
    </div>
<div class="form-group <?if($form->error($model,'images')):?>has-error<? endif; ?>">
    <label class="col-sm-2 control-label">Картинки</label>
    <div class="col-sm-10">
        <table class="js-images admin-images-list table table-bordered table-striped">
            <thead>
            <tr>
                <th>Картинка</th>
                <th>Название</th>
                <th>Источник</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <? foreach($model->images as $image): ?>
                <tr>
                    <td>
                        <input type="hidden" name="AddedImages[]" value="<?= $image->countryImageId ?>">
                        <img style="height: 28px" src="/content/countries/<?= $image->image->original ?>">
                    </td>
                    <td></td>
                    <td></td>
                    <td style="text-align: right;">
                        <a href="#" class="js-image-delete">Удалить</a>
                    </td>
                </tr>
            <? endforeach; ?>
            </tbody>
        </table>
        <a href="#" id="add-image">Добавить новую</a>
    </div>
</div>
    <div class="form-group">
        <div class="col-sm-2"></div>
        <div class="col-sm-10">
            <button type="submit" class="btn btn-default">Сохранить</button>
        </div>
    </div>
<?php $this->endWidget(); ?>

<hr>

<? if(Yii::app()->controller->action->id == 'update'): ?>
    <form method="POST" action="/admin/countries/delete">
        <input type="hidden" name="id" value="<?= $model->countryId ?>">
        <button type="submit" class="btn btn-danger">Удалить</button>
    </form>
<? endif; ?>

<script type="text/javascript">
    $(function()
    {
        $('.redactor').redactor();
    });
</script>

<script type="text/javascript">
    $(function()
    {
        $('#add-image').click(function(e){
            e.preventDefault();

            var html = '';
            html += '<tr><td colspan="4"><input type="file" name="Images[]"></td></tr>';

            $('.js-images tbody').append(html);
        });
        $('.js-image-delete').click(function(e){
            e.preventDefault();

            $(this).closest('tr').remove();
        });
    });
</script>