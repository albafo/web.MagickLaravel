<?php
/**
 * Created by PhpStorm.
 * User: alvarobanofos
 * Date: 25/07/15
 * Time: 13:36
 */

namespace Magia\Model\Relations;


use Illuminate\Database\Eloquent\Relations\Relation;

abstract class MagiaRelation extends Relation {

    const BELONGS_TO = "BelongsTo";
    const BELONGS_TO_MANY = "BelongsToMany";




}