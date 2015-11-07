<?php

class PfOrderController extends Controller {
    #public $layout='//layouts/column2';

    public $defaultAction = "admin";
    public $scenario = "crud";
    public $scope = "crud";
    public $menu_route = "ldm/pfOrder";

    public function filters() {
        return [
            'accessControl',
        ];
    }

    public function accessRules() {
        return [
            [
                'allow',
                'actions' => [
                    'create', 'admin', 'view', 'update', 
                    'editableSaver', 'delete', 'ajaxCreate',
                    'exportExcel'
                    ],
                'roles' => ['Ldm.PfOrder.*'],
            ],
            [
                'allow',
                'actions' => ['create', 'ajaxCreate'],
                'roles' => ['Ldm.PfOrder.Create'],
            ],
            [
                'allow',
                'actions' => ['view', 'admin','exportExcel'], // let the user view the grid
                'roles' => ['Ldm.PfOrder.View'],
            ],
            [
                'allow',
                'actions' => ['update', 'editableSaver'],
                'roles' => ['Ldm.PfOrder.Update'],
            ],
            [
                'allow',
                'actions' => ['delete'],
                'roles' => ['Ldm.PfOrder.Delete'],
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

    public function actionCreate() {
        $model = new PfOrder;
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'pf-order-form');

        if (isset($_POST['PfOrder'])) {
            $model->attributes = $_POST['PfOrder'];

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
        } elseif (isset($_GET['PfOrder'])) {
            $model->attributes = $_GET['PfOrder'];
        }

        $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id) {
        $model = $this->loadModel($id);
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'pf-order-form');

        if (isset($_POST['PfOrder'])) {
            $model->attributes = $_POST['PfOrder'];


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
        $es = new EditableSaver('PfOrder'); // classname of model to be updated
        $es->update();
    }

    public function actionAjaxCreate($field, $value) {
        $model = new PfOrder;
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
        if (Yii::app()->request->isPostRequest) {
            try {
                $this->loadModel($id)->delete();
            } catch (Exception $e) {
                throw new CHttpException(500, $e->getMessage());
            }

            if (!isset($_GET['ajax'])) {
                if (isset($_GET['returnUrl'])) {
                    $this->redirect($_GET['returnUrl']);
                } else {
                    $this->redirect(['admin']);
                }
            }
        } else {
            throw new CHttpException(400, Yii::t('LdmModule.crud', 'Invalid request. Please do not repeat this request again.'));
        }
    }

    public function actionAdmin() {
        $model = new PfOrder('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['PfOrder'])) {
            $model->attributes = $_GET['PfOrder'];
        }

        $this->render('admin', ['model' => $model]);
    }

    public function actionExportExcel() {

        $model = new PfOrder('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['PfOrder'])) {
            $model->attributes = $_GET['PfOrder'];
        }
        
        $this->renderPartial('adminExcel', ['model' => $model]);

    }

    public function loadModel($id) {
        $m = PfOrder::model();
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
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pf-order-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
