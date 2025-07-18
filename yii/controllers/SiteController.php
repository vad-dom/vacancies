<?php

namespace app\controllers;

use app\models\Vacancy;
use Throwable;
use Yii;
use yii\data\Pagination;
use yii\db\Exception;
use yii\db\Query;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
            'corsFilter' => [
                'class' => \yii\filters\Cors::class,
                'cors' => [
                    // restrict access to the following controller actions
                    'Origin' => ['*'],
                    'Access-Control-Request-Method' => ['GET', 'POST', 'PATCH', 'PUT', 'DELETE', 'OPTIONS'],
                    'Access-Control-Request-Headers' => ['*'],
                    //'Access-Control-Allow-Credentials' => true,
                    'Access-Control-Max-Age' => 3600,
                    //'Access-Control-Allow-Headers' => ['Content-Type'],
                    //'Access-Control-Expose-Headers' => ['*'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
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
}
