<?php

class PfOrderItemsController extends Controller {
    #public $layout='//layouts/column2';

    public $defaultAction = "admin";
    public $scenario = "crud";
    public $scope = "crud";

    public function filters() {
        return [
            'accessControl',
        ];
    }

    public function accessRules() {
        return [
            [
                'allow',
                'actions' => ['create', 'admin', 'view', 'update', 'editableSaver', 'delete', 'ajaxCreate'],
                'roles' => ['Ldm.PfOrderItems.*'],
            ],
            [
                'allow',
                'actions' => ['create', 'ajaxCreate'],
                'roles' => ['Ldm.PfOrderItems.Create'],
            ],
            [
                'allow',
                'actions' => ['view', 'admin'], // let the user view the grid
                'roles' => ['Ldm.PfOrderItems.View'],
            ],
            [
                'allow',
                'actions' => ['update', 'editableSaver'],
                'roles' => ['Ldm.PfOrderItems.Update'],
            ],
            [
                'allow',
                'actions' => ['delete'],
                'roles' => ['Ldm.PfOrderItems.Delete'],
            ],
            [
                'deny',
                'users' => ['*'],
            ],
        ];
    }

    public function beforeAction($action) {
        parent::beforeAction($action);
        if ($this->module !== null) {
            $this->breadcrumbs[$this->module->Id] = ['/' . $this->module->Id];
        }
        return true;
    }

    public function actionView($id, $ajax = false) {
        $model = $this->loadModel($id);
        if ($ajax) {
            $this->renderPartial('_view-relations_grids', [
                'modelMain' => $model,
                'ajax' => $ajax,
                    ]
            );
        } else {
            $this->render('view', ['model' => $model,]);
        }
    }

    public function actionCreate($order_id) {
        $model = new PfOrderItems;
        $model->scenario = $this->scenario;
        $model->order_id = $order_id;
        $this->performAjaxValidation($model, 'pf-order-items-form');

        if (isset($_POST['PfOrderItems'])) {
            $model->attributes = $_POST['PfOrderItems'];

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(['pfOrder/view', 'id' => $model->order_id]);
                    }
                }
            } catch (Exception $e) {
                $model->addError('id', $e->getMessage());
            }
        } elseif (isset($_GET['PfOrderItems'])) {
            $model->attributes = $_GET['PfOrderItems'];
        }

        $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'pf-order-items-form');

        if (isset($_POST['PfOrderItems'])) {
            $model->attributes = $_POST['PfOrderItems'];


            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(['view', 'id' => $model->id]);
                    }
                }
            } catch (Exception $e) {
                $model->addError('id', $e->getMessage());
            }
        }

        $this->render('update', ['model' => $model]);
    }

    public function actionEditableSaver() {
        $es = new EditableSaver('PfOrderItems'); // classname of model to be updated
        $es->update();
    }

    public function actionAjaxCreate($field, $value) {
        $model = new PfOrderItems;
        $model->$field = $value;
        try {
            if ($model->save()) {
                return TRUE;
            } else {
                return var_export($model->getErrors());
            }
        } catch (Exception $e) {
            throw new CHttpException(500, $e->getMessage());
        }
    }

    public function actionDelete($id) {

        $model = $this->loadModel($id);
        $order_id = $model->order_id;
        try {

            $model->delete();
            $this->redirect(['pfOrder/view', 'id' => $order_id]);
        } catch (Exception $e) {
            throw new CHttpException(500, $e->getMessage());
        }
    }

    public function actionAdmin() {
        $model = new PfOrderItems('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['PfOrderItems'])) {
            $model->attributes = $_GET['PfOrderItems'];
        }

        $this->render('admin', ['model' => $model]);
    }

    public function loadModel($id) {
        $m = PfOrderItems::model();
        // apply scope, if available
        $scopes = $m->scopes();
        if (isset($scopes[$this->scope])) {
            $m->{$this->scope}();
        }
        $model = $m->findByPk($id);
        if ($model === null) {
            throw new CHttpException(404, Yii::t('LdmModule.crud', 'The requested page does not exist.'));
        }
        return $model;
    }

    protected function performAjaxValidation($model) {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pf-order-items-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
