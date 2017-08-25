<?php

namespace app\modules\calendar\controllers;

use yii\web\Controller;
use app\modules\calendar\models\CalendarEvent;
use yii;
use yii\web\Response;
use yii\web\HttpException;
use yii\helpers\Url;

class DefaultController extends Controller
{
    public function actionIndex($year = null, $month = null)
    {
        $model = new CalendarEvent();
        $calendar = $this->createCalendarHtml($year, $month);
        $_month_array = $model::$_month_array;
        $_year_array = $model::$_year_array;
        return $this->render('index', [
            'calendar' => $calendar,
            'form' => yii::$app->user->isGuest ? '' : $this->renderPartial('_form', [
                'model' => $model,
                '_year_array' => $_year_array,
                '_month_array' => $_month_array,
                'action' => '/calendar/default/create-event',
                'edit' => false,
            ]),
        ]);
    }

    public function actionEditEvent($id)
    {
        if (yii::$app->user->isGuest) {
            return $this->redirect('/');
        }
        if (!$model = CalendarEvent::findOne($id)) {
            throw new HttpException(404);
        }
        if ($model->load(yii::$app->request->post()) && $model->validate() && $model->save()) {
            yii::$app->response->format = Response::FORMAT_JSON;
            $result = [
                'result' => '',
                'html' => '',
            ];
            $result['result'] = 'Событие изменено успешно';
            $result['html'] = $this->createCalendarHtml($model->year, $model->month);
            return $result;
        }
        $calendar = $this->createCalendarHtml($model->year, $model->month);
        $_month_array = $model::$_month_array;
        $_year_array = $model::$_year_array;
        return $this->render('index', [
            'calendar' => $calendar,
            'form' => $this->renderPartial('_form', [
                'model' => $model,
                '_year_array' => $_year_array,
                '_month_array' => $_month_array,
                'action' => Url::to(['/calendar/default/edit-event', 'id' => $id]),
                'edit' => true,
            ]),
        ]);
    }

    public function actionCreateEvent()
    {
        yii::$app->response->format = Response::FORMAT_JSON;
        $model = new CalendarEvent();
        $result = [
            'result' => '',
            'html' => '',
        ];
        if ($model->load(yii::$app->request->post()) && $model->validate()) {
            $check = CalendarEvent::find()
                ->where([
                    'year' => $model->year,
                    'month' => $model->month,
                    'day' => $model->day,
                    'time' => $model->time
                ])->count();
            if (!$check) {
                $model->save();
                $result['result'] = 'Событие создано успешно';
            } else {
                $result['result'] = 'Событие для этого времени уже существует';
            }
        } else {
            $result['result'] = 'Ошибка. Проверьте введенные данные.';
        }
        $result['html'] = $this->createCalendarHtml($model->year, $model->month);
        return $result;
    }

    public function actionViewEvents($year, $month, $day)
    {
        $data_events = CalendarEvent::find()
            ->where(['year' => $year, 'month' => $month, 'day' => $day])
            ->orderBy(['time' => SORT_ASC])
            ->indexBy('time')
            ->asArray()
            ->all();
        $model = new CalendarEvent();
        return $this->renderPartial('view_events', [
            'year' => $year,
            'data_events' => $data_events,
            'day' => $day,
            'model' => $model,
            'month' => $month,
        ]);
    }

    public function actionRemoveEvent($id)
    {
        return CalendarEvent::deleteAll(['id' => $id]);
    }

    public function actionPrintEvents()
    {
        $post = yii::$app->request->post();
        if (!$post['day1'] && !$post['day2']) {
            return '';
        }
        $day_of_month = date('t',
            mktime(0, 0, 0, $post['month'], 1, $post['year']));

        if ($day_of_month) {
            if ($post['day1'] <= $day_of_month && $post['day2'] <= $day_of_month) {
                $query = CalendarEvent::find()->where(['year' => $post['year'], 'month' => $post['month']]);
                if ($post['day1'] && $post['day2']) {
                    $query->andWhere(['>=', 'day', $post['day1']]);
                    $query->andWhere(['<=', 'day', $post['day2']]);
                }
                if ($post['day1'] && !$post['day2']) {
                    $query->andWhere(['=', 'day', $post['day1']]);
                }
                if (!$post['day1'] && $post['day2']) {
                    $query->andWhere(['=', 'day', $post['day2']]);
                }
                if (!$model = $query->orderBy(['day' => SORT_ASC, 'time' => SORT_ASC])->asArray()->all()) {
                    return '';
                }
                $data_model = [];
                foreach ($model as $item) {
                    $data_model[$item['day']][$item['time']] = $item;
                }
                $html = '';
                $model = new CalendarEvent();
                foreach ($data_model as $key => $item) {
                    $html .= $this->renderPartial('view_events', [
                        'month' => $post['month'],
                        'year' => $post['year'],
                        'model' => $model,
                        'data_events' => $item,
                        'day' => $key
                    ]);
                }
                return $html;
            }
            return '';
        }
        return '';
    }

    private function createCalendarHtml($year, $month)
    {
        $_year_array = CalendarEvent::$_year_array;
        $_month_array = CalendarEvent::$_month_array;
        $data = [];
        if ($year && $month) {
            if (!isset($_year_array[$year]) || !isset($_month_array[$month])) {
                throw new HttpException(404);
            }
            $data_model = CalendarEvent::find()
                ->where(['year' => $year, 'month' => $month])
                ->orderBy(['day' => SORT_ASC, 'time' => SORT_ASC])
                ->asArray()
                ->all();
            foreach ($data_model as $item) {
                $data[$item['day']][$item['time']] = $item;
            }
            return $this->renderPartial('calendar_grid', [
                'month' => $month,
                'grid' => $this->createCalendarGrid($year, $month),
                'model' => new CalendarEvent(),
                'data' => $data,
                'year' => $year,
                '_month_array' => $_month_array,
            ]);
        }
        return '';
    }

    private function createCalendarGrid($year, $month)
    {
        $day_count = 1;
        $day_of_month = date('t',
            mktime(0, 0, 0, $month, 1, $year));
        $week = [];
        // 1. Первая неделя
        $num = 0;
        for ($i = 0; $i < 7; $i++) {
            // Вычисляем номер дня недели для числа
            $day_of_week = date('w',
                mktime(0, 0, 0, $month, $day_count, $year));
            // Приводим к числа к формату 1 - понедельник, ..., 6 - суббота
            $day_of_week = $day_of_week - 1;
            if ($day_of_week == -1) $day_of_week = 6;
            if ($day_of_week == $i) {
                // Если дни недели совпадают,
                // заполняем массив $week
                // числами месяца
                $week[$num][$i] = $day_count;
                $day_count++;
            } else {
                $week[$num][$i] = "";
            }
        }
        // 2. Последующие недели месяца
        while (true) {
            $num++;
            for ($i = 0; $i < 7; $i++) {
                $week[$num][$i] = $day_count;
                $day_count++;
                // Если достигли конца месяца - выходим
                // из цикла
                if ($day_count > $day_of_month) break;
            }
            // Если достигли конца месяца - выходим
            // из цикла
            if ($day_count > $day_of_month) break;
        }
        return $week;
    }
}
