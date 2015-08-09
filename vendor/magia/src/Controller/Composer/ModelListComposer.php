<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 07/08/15
 * Time: 11:09
 */

namespace Magia\Controller\Composer;


use Magia\Controller\HtmlRenderer\TableRenderer;

class ModelListComposer {
    /**
     * @var \Magia\Model\MagickEloquent $model
     */

    protected $model = null;
    /**x
     * @param \Magia\Model\MagickEloquent $model
     * @return string
     */
    public static function getList($model)
    {
        if($model->count() > 0) {

            $listComposer = new ModelListComposer();
            $listComposer->model = $model;
            $collection = $model->all();
            $headers = $listComposer->generateHeaders($collection);
            $arrayData = $listComposer->generateArrayData($collection);
            $table = TableRenderer::createTable($headers, $arrayData);
            return $table;
        }
    }

    /**
     * @param \Illuminate\Database\Eloquent\Collection|static[] $collection
     */
    public function generateHeaders($collection)
    {
        $modelObject = $collection->first();
        $headers = array();
        foreach($modelObject->getListAttributes() as $index=>$value) {
            $headers[] = $index;
        }
        $headers[] = "Acciones";
        return $headers;

    }
    /**
     * @param \Illuminate\Database\Eloquent\Collection|static[] $collection
     */
    public function generateArrayData($collection)
    {
        $modelObject = $collection->first();
        $arrayData = array();
        foreach($collection as $item) {
            $row = array();
            foreach ($modelObject->getListAttributes() as $index=>$value) {
                $row[] = $item->$index;
            }
            $pk = $modelObject->getPrimaryKey();
            $href = route('admin_edit', ['model'=>$this->model->getUrlName(), 'id'=>"$pk:{$item->$pk}"]);
            $row[] = "<a href='$href'>Editar</a>";
            $arrayData[] = $row;
        }
        return $arrayData;

    }
}