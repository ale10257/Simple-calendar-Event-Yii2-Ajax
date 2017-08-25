<?php
use yii\helpers\Url;
/**
 * @var $this \yii\web\View
 * @var $model \app\modules\calendar\models\CalendarEvent
 * @var $grid array
 * @var $month integer
 * @var $year integer
 * @var $data array
 * @var $_month_array array
 */
$month_name = $model->month_array_name[$month];
$guest = yii::$app->user->isGuest;
$class_td = '';
if (!$guest) {
    $class_td = ' class="show-events post-data show-modal"';
}
?>
<?php if (!yii::$app->user->isGuest) : ?>
    <p>
        Ссылка на календарь для вставки в статью:
        <code><?= \yii\helpers\Url::to(['/calendar', 'year' => $year, 'month' => $month]) ?></code>
    </p>
<?php endif ?>
<h2><?= $_month_array[$month] . ' ' . $year ?>г. </h2>
<p><span class="span-info error">Красный цвет - время занято</span></p>
<p><span class="span-info success">Зеленый цвет - время свободно</span></p>
<table>
    <tr>
        <th><?= $model->week_array[0] ?></th>
        <th><?= $model->week_array[1] ?></th>
        <th><?= $model->week_array[2] ?></th>
        <th><?= $model->week_array[3] ?></th>
        <th><?= $model->week_array[4] ?></th>
        <th><?= $model->week_array[5] ?></th>
        <th><?= $model->week_array[6] ?></th>
    </tr>
    <?php foreach ($grid as $week) : ?>
        <tr>
            <?php foreach ($week as $day) : ?>
                <?php $data_url = !$guest && $day ? ' data-url="' . Url::to(['/calendar/default/view-events', 'year' => $year, 'month' => $month, 'day' => $day]) . '"' : '' ?>
                <td<?= $data_url ? $class_td . $data_url : '' ?>>
                    <?php if ($day) : ?>
                        <p>
                            <?= $day . ' ' . $month_name ?>
                        </p>
                        <p>
                            <?php foreach ($model->time_array as $key => $time) : ?>
                                <?php
                                $class = !empty($data[$day][$key]) ? 'error' : 'success';
                                ?>
                                <span class="span-info <?= $class ?>">
                                    <?= $time > 9 ? $time : '0' . $time ?>
                                </span>
                            <?php endforeach ?>
                        </p>
                    <?php endif ?>
                </td>
            <?php endforeach ?>
        </tr>
    <?php endforeach ?>
</table>



