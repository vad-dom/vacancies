<?php

namespace app\controllers;

use app\models\Vacancy;
use Throwable;
use Yii;
use yii\data\Pagination;
use yii\db\Exception;
use yii\db\Query;
use yii\db\StaleObjectException;
use yii\filters\Cors;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\rest\Controller;

class VacancyController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PATCH', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Max-Age' => 3600,
            ],
        ];
        return $behaviors;
    }

    /**
     * @return array
     */
    public function actionList(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        $query = (new Query())
            ->select(['id', 'title', 'salary', 'short_details'])
            ->from(Vacancy::tableName());
        if ($sort = Yii::$app->request->get('sort')) {
            $order = Yii::$app->request->get('order');
            $query->orderBy([$sort => $order === 'asc' ? SORT_ASC : SORT_DESC]);
        }

        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'pageSizeLimit' => [1, 50],
            'defaultPageSize' => 10,
        ]);
        if ($pagination->getPage() > $pagination->getPageCount() - 1) {
            $pagination->setPage($pagination->getPageCount() - 1);
        }

        $vacancies = $query
            ->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return [
            'vacancies' => $vacancies,
            'pagination' => [
                'totalCount' => $pagination->totalCount,
                'pageSize' => $pagination->pageSize,
                'pageCount' => $pagination->getPageCount(),
                'page' => $pagination->getPage() + 1,
            ],
        ];
    }

    /**
     * @param $id
     * @return string[]
     * @throws NotFoundHttpException
     */
    public function actionCard($id): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $fields = Yii::$app->request->get('fields');
        $vacancy = Vacancy::find()
            ->select(explode(',', $fields))
            ->where(['id' => $id])
            ->one();
        if (!$vacancy) {
            throw new NotFoundHttpException('Вакансия не найдена');
        }
        return $vacancy->toArray();
    }

    /**
     * @return array
     * @throws Exception
     */
    public function actionSave(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $vacancy = new Vacancy();
        if ($vacancy->load(Yii::$app->request->post()) && $vacancy->validate()) {
            $vacancy->save();
            return [
                'success' => true,
                'id' => $vacancy->id,
            ];
        }
        return [
            'success' => false,
            'errors' => $vacancy->getErrors(),
        ];
    }

    /**
     * @param $id
     * @return array|true[]
     * @throws NotFoundHttpException
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $vacancy = Vacancy::findOne(['id' => $id]);
        if (!$vacancy) {
            throw new NotFoundHttpException('Вакансия не найдена');
        }
        if ($vacancy->delete()) {
            return ['success' => true];
        }
        return ['success' => false];
    }

    /**
     * @return array
     */
    public function actionCsrf(): array
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        return [
            'param' => Yii::$app->request->csrfParam,
            'token' => Yii::$app->request->getCsrfToken(),
        ];
    }
}
