<?php

use yii\helpers\Url;
use yii\helpers\Html;

/**
 * @var $year integer
 * @var $month integer
 * @var $day integer
 * @var $data_events \app\modules\calendar\models\CalendarEvent
 * @var $model \app\modules\calendar\models\CalendarEvent
 */
?>
<h4><?= $day . ' ' . $model->month_array_name[$month] . ' ' . $year ?>г. </h4>
<table id="event-table">
    <?php $num = 1 ?>
    <?php for ($i = 1; $i < 3; $i++) : ?>
        <tr>
            <?php for ($_i = 1; $_i < 6; $_i++) : ?>
                <td class="data-events">
                    <?= isset($model->time_array[$num]) ? $model->time_array[$num] : '' ?>
                    <?php if (!empty($data_events[$num])) : ?>
                        <p >
                            <?php $url = Url::to(['/calendar/default/edit-event', 'id' => $data_events[$num]['id']]) ?>
                            <?= Html::a('<i class="fa fa-pencil"></i>', $url) ?>
                            <i data-url="<?= Url::to(['/calendar/default/remove-event', 'id' => $data_events[$num]['id']]) ?>"
                               class="fa fa-remove delete post-data"></i>
                        </p>
                        <p>
                            <?= nl2br($data_events[$num]['event']) ?>
                        </p>
                    <?php endif ?>
                </td>
                <?php $num++ ?>
            <?php endfor ?>
        </tr>
    <?php endfor ?>
</table>
