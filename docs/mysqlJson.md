MySQL的Json格式，讓資料欄位被簡易處理
===
* MySQL 自從 5.7.8 之後，開始原生支援 Json 格式作為資料類型，並提供一系列的方式來運用。

* Yii2 自從 2.0.14 之後，ActiveRecord 也開始支援了 Json 格式。

* 在 Yii2 較新的版本中，MySQL 的 Json 欄位於 Yii2 中將有以下特性

    * ActiveRecord 由資料庫取出資料後，將自動呼叫 Json::decode()，於是資料將自動變為物件陣列。
    * ActiveRecord 要儲存傳入之資料時，將自動呼叫 Json::encode()，於是資料將由物件陣列自動轉為 Json 字串並儲存到資料庫中。
    * 由於傳入之資料為物件陣列，ActiveRecord 不需驗證資料，傳入任何物件都將自動編碼並儲存。
    * 須注意若於儲存時，將 Json 字串直接存入欄位，字串將再次被編碼，形成兩層式的 Json，故下面提供方便自動解譯的 Model。

常見使用方式
----
若 ``Message->payload`` 欄位，於資料庫中是一個 Json 格式的欄位
儲存資料如
````json
{
    "title": "MyTitle",
    "body": "Text Information"
}
````

則內建之 Widget 可用如下方式直接讀取欄位並顯示

````php
GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        #直接顯示
        'payload.title', 
        #指定標題文字
        ['attribute'=>'payload.body', 'label'=>'payload body'],
    ],
]);
````

於ArrayHelper亦可直接指定

````php
$array = ArrayHelper::map($datas, 'payload.title','payload.body');
````

為避免如 Api 呼叫時，傳入 Json 字串，以 ``$model->load()`` 方式載入時，將被再次編碼的問題，可直接將 Model 直接繼承
JsonModel 類別，這個類別將會自動檢測，當傳入 Json 字串時自動解開，以避免錯誤的編碼。
````php
use eztechtw\toolbox\JsonModel;

#繼承 JsonModel 可以避免未解碼的 Json 字串
class Message extends JsonModel
{
}
```` 
而若想要於欄位中直接顯示整個 Json 字串時，請先安裝

* [資料格式化工具](EzFormatter.md) eztechtw\toolbox\EzFormatter

安裝後即可如下使用 arrayjson 自動格式

````php
DetailView::widget([
    'model' => $model,
    'attributes' => [
        #將物件陣列的欄位，轉換為 Json 文字輸出
        'payload:arrayjson',
    ],
])
````

而於新增/更新表單中，可以如下使用 Json 欄位

````php
    <?= $form->field($model, 'payload[title]')->textInput()->label('title') ?>

    <?= $form->field($model, 'payload[body]')->textInput()->label('body') ?>
````

如此操作，後端 Controller 即可使用原本的方式儲存資料，無論是由前端表單傳入，或 RESTful 傳入字串，都將自動處理。

````php
if ($model->load(Yii::$app->request->post()) && $model->save()) {
    return $this->redirect(['index']);
}
````