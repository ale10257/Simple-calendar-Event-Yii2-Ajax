<?php
/**
 * @var $model \app\modules\calendar\models\CalendarEvent
 * @var $_month_array array
 * @var $_year_array array
 * @var $action string
 */

use yii\widgets\ActiveForm;
use yii\helpers\Html;

?>
<div id="create-event">
    <div class="row">
        <div class="col-md-4">
            <? $form = ActiveForm::begin([
                'action' => $action,
            ]) ?>
            <?= $form->field($model, 'month')->dropDownList($_month_array, [
                'disabled' => !empty($edit) ? '' : false
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'day')->textInput([
                'autocomplete' => 'off',
                'disabled' => !empty($edit) ? '' : false
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'year')->dropDownList($_year_array, [
                'disabled' => !empty($edit) ? '' : false
            ]) ?>
        </div>
        <div class="col-md-4">
            <?= $form->field($model, 'time')->dropDownList($model->time_array, [
                'disabled' => !empty($edit) ? '' : false
            ]) ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4">
            <?= $form->field($model, 'event')->textarea(['rows' => 5]) ?>
        </div>
    </div>
    <div class="row">
        <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
        <div class="col-md-4">
            <p>
                <?= Html::submitButton(!empty($edit) ? 'Изменить событие' : 'Создать событие', ['class' => 'btn btn-primary']) ?>
            </p>
            <?php if(!empty($edit)) : ?>
                <p><a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['/calendar', 'year' => $model->year, 'month' => $model->month]) ?>">Разблокировать форму</a></p>
            <?php endif ?>
        </div>
        <? ActiveForm::end(); ?>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-4">
        <?= Html::beginForm('/calendar', 'get') ?>
        <div class="form-group">
            <label class="control-label" for="year">Год</label>
            <?= Html::dropDownList('year', 'null', $_year_array, [
                'class' => 'form-control'
            ]) ?>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label class="control-label" for="month">Месяц</label>
            <?= Html::dropDownList('month', 'null', $_month_array, [
                'class' => 'form-control'
            ]) ?>
        </div>
    </div>
    <div style="padding-top: 25px;" class="col-md-4">
        <?= Html::submitButton('Выбрать календарь', ['class' => 'btn btn-primary']) ?>
        <?= Html::endForm() ?>
    </div>
</div>
<hr>
<div class="row">
    <div class="col-md-2">
        <?= Html::beginForm('/calendar/default/print-events', 'post', ['id' => 'print-events']) ?>
        <div class="form-group">
            <label class="control-label" for="year">Год</label>
            <?= Html::dropDownList('year', 'null', $_year_array, [
                'class' => 'form-control'
            ]) ?>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label" for="month">Месяц</label>
            <?= Html::dropDownList('month', 'null', $_month_array, [
                'class' => 'form-control'
            ]) ?>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label" for="day1">С (число)</label>
            <?= Html::input('text', 'day1', null, [
                'style' => 'width:100px;'
            ]) ?>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label" for="day2">По (число)</label>
            <?= Html::input('text', 'day2', null, [
                'style' => 'width:100px;'
            ]) ?>
        </div>
    </div>
    <div style="padding-top: 25px;" class="col-md-2">
        <?= Html::submitButton('Печать', ['class' => 'btn btn-primary']) ?>
        <?= Html::endForm() ?>
    </div>
</div>
<hr>
