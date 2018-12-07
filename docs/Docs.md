markdown文件顯示
====

* 於Yii2專案中建立提供使用者閱讀之說明文件
* 提供一個路由，即可自動將``.md``文件顯示出來

安裝
====

* 文件讀取的路徑為``@app/docs/{$path}``，也就是專案的根目錄中，建立一個docs資料夾，裡面即可放``.md``檔案，
可以使用資料夾分類，``$path``只要將相應路徑傳入即可。


於想要掛載文件的控制器中，加入此載入文件的 Action
````php
class SiteController extends Controller
{
    public function actions()
    {
        return [
            'doc' => [
                'class' => 'eztechtw\toolbox\doc\DocsAction',
            ],
        ];
    }
}
````
即可以以該控制器，將``$path``傳入即可。

* 如： ``https://example.com/index.php?r=site/doc&path=index.md`` 即會載入 ``@app/docs/index.md`` 並顯示

如果改寫路由的話：
````php
'urlManager' => [
    'enablePrettyUrl' => true,
    'enableStrictParsing' => true,
    'showScriptName' => false,
    'rules' => [
        "" => "site/index",
        "docs/<path:.+>" => "site/doc", #轉送指定路徑
        "<controller:\w+>" => "<controller>/index",
        "<controller:\w+>/<action:\w+>" => "<controller>/<action>",
    ],
],
````

``"docs/<path:.+>" => "site/doc"``意思即為，將``docs/``開頭的路由，轉送到``site/doc``這個Action，
並把``docs/``後面的所有文字做為``$path``這個GET參數傳入Acion中，例如：

* ``https://example.com/index.php?r=docs/index.md`` 即會載入 ``@app/docs/index.md`` 並顯示

如果網站打開``enablePrettyUrl``，則路徑可以更為簡潔：

* ``https://example.com/docs/index.md`` 即會載入 ``@app/docs/index.md`` 並顯示

如果正確設定，則網站可以直接將``docs``資料夾下之``.md``檔案直接顯示在網站的``docs/*``路由底下。