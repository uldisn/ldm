<?php


class PfOrderItemNotesController extends Controller
{
    #public $layout='//layouts/column2';

    public $defaultAction = "admin";
    public $scenario = "crud";
    public $scope = "crud";


public function filters()
{
    return [
        'accessControl',
    ];
}

public function accessRules()
{
     return [
        [
            'allow',
            'actions' => ['markAsRead'],
            'users' => ['@'],
        ], 
        [
            'allow',
            'actions' => ['create', 'admin', 'view', 'update', 
                'editableSaver', 'delete','ajaxCreate'],
            'roles' => ['Ldm.PfOrderItemNotes.*'],
        ],
        [
            'allow',
            'actions' => ['create','ajaxCreate'],
            'roles' => ['Ldm.PfOrderItemNotes.Create'],
        ],
        [
            'allow',
            'actions' => ['view', 'admin'], // let the user view the grid
            'roles' => ['Ldm.PfOrderItemNotes.View'],
        ],
        [
            'allow',
            'actions' => ['update', 'editableSaver'],
            'roles' => ['Ldm.PfOrderItemNotes.Update'],
        ],
        [
            'allow',
            'actions' => ['delete'],
            'roles' => ['Ldm.PfOrderItemNotes.Delete'],
        ],
        [
            'deny',
            'users' => ['*'],
        ],
    ];
}

    public function beforeAction($action)
    {
        parent::beforeAction($action);
        if ($this->module !== null) {
            $this->breadcrumbs[$this->module->Id] = ['/' . $this->module->Id];
        }
        return true;
    }

    public function actionView($id, $ajax = false)
    {
        $model = $this->loadModel($id);
        if($ajax){
            $this->renderPartial('_view-relations_grids', 
                    [
                        'modelMain' => $model,
                        'ajax' => $ajax,
                        ]
                    );
        }else{
            $this->render('view', ['model' => $model,]);
        }
    }

    public function actionCreate($order_item_id)
    {
        $model = new PfOrderItemNotes;
        $model->scenario = $this->scenario;
        $model->order_item_id = $order_item_id;
        $model->created = new CDbExpression('NOW()');
        $model->from_pprs_id = Yii::app()->getModule('user')->user()->profile->person_id;
        $this->performAjaxValidation($model, 'pf-order-item-notes-form');

        if (isset($_POST['PfOrderItemNotes'])) {
            $model->attributes = $_POST['PfOrderItemNotes'];

            try {
                if ($model->save()) {
                    if (isset($_GET['returnUrl'])) {
                        $this->redirect($_GET['returnUrl']);
                    } else {
                        $this->redirect(['pfOrder/view', 'id' => $model->orderItem->order_id]);
                    }
                }
            } catch (Exception $e) {
                $model->addError('id', $e->getMessage());
            }
        } elseif (isset($_GET['PfOrderItemNotes'])) {
            $model->attributes = $_GET['PfOrderItemNotes'];
        }

        $this->render('create', ['model' => $model]);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $model->scenario = $this->scenario;

        $this->performAjaxValidation($model, 'pf-order-item-notes-form');

        if (isset($_POST['PfOrderItemNotes'])) {
            $model->attributes = $_POST['PfOrderItemNotes'];


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

    public function actionEditableSaver()
    {
        $es = new EditableSaver('PfOrderItemNotes'); // classname of model to be updated
        $es->update();
    }
    
    public function actionMarkAsRead($id)
    {
        $model = $this->loadModel($id);
        $model->readed = new CDbExpression('NOW()');
        $model->save();
        $this->redirect(['pfOrder/view', 'id' => $model->orderItem->order_id]);
    }

    public function actionAjaxCreate($field, $value) 
    {
        $model = new PfOrderItemNotes;
        $model->$field = $value;
        try {
            if ($model->save()) {
                return TRUE;
            }else{
                return var_export($model->getErrors());
            }            
        } catch (Exception $e) {
            throw new CHttpException(500, $e->getMessage());
        }
    }
    
    public function actionDelete($id)
    {
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

    public function actionAdmin()
    {
        $model = new PfOrderItemNotes('search');
        $scopes = $model->scopes();
        if (isset($scopes[$this->scope])) {
            $model->{$this->scope}();
        }
        $model->unsetAttributes();

        if (isset($_GET['PfOrderItemNotes'])) {
            $model->attributes = $_GET['PfOrderItemNotes'];
        }

        $this->render('admin', ['model' => $model]);
    }

    /**
     * load controller model
     * @param int $id
     * @return PfOrderItemNotes
     * @throws CHttpException|
     */
    public function loadModel($id)
    {
        $m = PfOrderItemNotes::model();
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

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'pf-order-item-notes-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

}
