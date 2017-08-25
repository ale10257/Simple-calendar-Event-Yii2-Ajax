<?php
/**
 * @var $this \yii\web\View
 * @var $calendar string
 * @var $form string
 */

use app\modules\calendar\assets\CalendarAsset;

CalendarAsset::register($this);
?>
<div class="calendar">
    <h1>Новогодний календарь</h1>
    <?= $form ?>
    <div id="calendar-table">
        <?php if ($calendar) : ?>
            <?= $calendar ?>
        <?php endif ?>
    </div>
</div>

<div id="modal-events" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>
    </div>
</div>
