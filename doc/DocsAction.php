<?php
namespace eztechtw\toolbox\doc;

use Yii;
use yii\base\Action;
use yii\base\Exception;
use yii\base\UserException;
use yii\web\NotFoundHttpException;

class DocsAction extends Action
{
    /**
     * Runs the action.
     *
     * @return string result content
     */
    public function run($path)
    {
        $filePath = Yii::getAlias("@app/docs/{$path}");
        if (file_exists($filePath)) {
            $Parsedown = new \Parsedown();
            $Content = $Parsedown->text(file_get_contents($filePath));
            return $this->controller->render('@vendor/eztech-tw/yii2-toolbox/doc/index.php',[
                'Content' => $Content,
                'Path' => $path,
            ]);
        } else {
            throw new NotFoundHttpException();
        }
    }
}
