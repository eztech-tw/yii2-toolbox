資料格式化工具
===

* 資料格式化，即為將原始的資料庫資料，轉換為適合顯示給使用者看的格式。
* 內建有 boolean datetime integer raw ntext html 等等...
* [全部內建格式說明文件](https://www.yiiframework.com/doc/guide/2.0/en/output-formatting)

安裝
====

於config設定檔中，將 formatter 的類別改為此類別即可

````php
'components' => [
    'formatter' => [
        'class' => '\eztechtw\toolbox\EzFormatter',
    ],
]
````

此類別提供之額外自訂之轉換格式：
====

*  arrayjson 將物件陣列的欄位，轉換為 Json 文字輸出
````php
DetailView::widget([
    'model' => $model,
    'attributes' => [
        #將物件陣列的欄位，轉換為 Json 文字輸出
        'payload:arrayjson',
    ],
])
````

* 尚待增加更多轉換格式