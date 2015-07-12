<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 08/06/15
 * Time: 13:41
 */

namespace Magia\Controller;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Model;

class AdminController extends Controller{

    protected $originalAttributes = array();

    protected $customAttributes = array();

    protected $types = array();

    protected $model = null;

    function __construct()
    {

        $this->model = $this->modelOfController();
    }


    public function getList()
    {

        $this->renderListTable();

    }

    protected function modelOfController()
    {
        $string = get_called_class();
        $controller = explode("\\", $string);
        $controller = $controller[sizeof($controller)-1];
        $model = explode("Controller", $controller)[0];

        return "\\App\\".$model;
    }


    /**
     *  @param   \Illuminate\Database\Eloquent\Model  $model
     */
    protected function renderListTable()
    {

        $modelObject = new $this->model();
        $collection = $modelObject->all();
        $rows = $this->getRowsFromCollection($collection, $modelObject);
        $headers = $this->getHeadersFromModel();
        return view("magia::list", ['rows'=>$rows, 'headers'=>$headers]);

    }

    protected function getRowsFromCollection($collection, $modelObject)
    {
        $rows = array();
        foreach($collection as $row) {
            $rowAttr = $row->toArray();
            foreach ($modelObject->getHidden() as $hidden) {
                $rowAttr[$hidden] = $row[$hidden];
            }
            $rows[] = $rowAttr;
        }

        return $rows;
    }

    protected function getHeadersFromModel()
    {
        if(empty($this->attributes)) {
            $this->fillAttributes();
        }
    }

    protected function fillAttributes()
    {

    }

    public function dashboard()
    {
        return view('magia::index');
    }

    public function modelList($model)
    {
        $modelObject = $this->generateModel($model);
        $primaryKey = $modelObject->getPrimaryKey();
        $count = $modelObject->all()->count();
        return view('magia::list', ['count'=>$count, 'modelObject'=>$modelObject, 'primaryKey'=>$primaryKey, 'modelName'=>$model]);


    }

    public function edit($model, $id)
    {
        $model = $this->generateModel($model);
        list($index, $value) = $this->extractParameter($id);
        $item = $model->where($index, $value)->first();
        return view('magia::edit', ['item'=>$item]);
    }

    public function generateModel($model)
    {
        $model = $this->cleanModel($model);

        $modelPath = '\\App\\'.$model;
        if(!class_exists($modelPath)) {
            throw new \Exception("Class $model not found");
        }

        /* @var \Magia\Model\MagickEloquent $modelObject */
        $modelObject = new $modelPath();
        if(!is_a($modelObject, 'Magia\Model\MagickEloquent')) {
            throw new \Exception("Class $model is not a MagickEloquent Model");
        }
        return $modelObject;
    }

    public function extractParameter($parameter)
    {
        $parts = explode(":", $parameter);
        return array($parts[0], $parts[1]);
    }

    public function cleanModel($model)
    {
        $parts = explode("-", $model);
        $model = '';
        foreach($parts as $part)
            $model .= ucfirst($part);
        return $model;
    }


}