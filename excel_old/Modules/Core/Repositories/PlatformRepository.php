<?php

namespace Modules\Core\Repositories;

use Modules\Core\Helper\CrudHelper;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class PlatformRepository
 * @package Modules\Platform\Core\Repositories
 */
abstract class PlatformRepository extends BaseRepository
{

    /**
     * Find by Entity Id (null if not exist)
     * @param $id
     * @return null
     */
    public function findWithoutFail($id)
    {
        try {
            return $this->find($id);
        } catch (\Exception $exception) {
            return null;
        }
    }

    /**
     * Find by entity id and cleanup
     * @param $id
     * @return null
     */
    public function findWithoutFailForCopy($id)
    {

        $entity = $this->findWithoutFail($id);
        if (!empty($entity)) {

            try {
                $rows = $entity->rows()->get();

                foreach ($rows as $row) {
                    $row->id = null;
                }

                $entity->rows = $rows;
            } catch (\Exception $e) {

            }

            return $entity;

        }
        return null;
    }

    public function createEntity($attributes, $entity)
    {


        unset($attributes['_method']);
        unset($attributes['_token']);
        unset($attributes['owned_by']);
        unset($attributes['entityCreateMode']);
        unset($attributes['relationType']);
        unset($attributes['relatedField']);
        unset($attributes['relatedEntityId']);
        unset($attributes['relatedEntity']);

        foreach ($attributes as $field => $value) {
            if (method_exists($entity, $field)) { // skip relations
            } else {
                if ($value == '') {
                    $value = null;
                }
                $entity->setAttribute($field, $value);
            }
        }

        $entity->save();

        foreach ($attributes as $field => $value) {
            if (method_exists($entity, $field)) {
                $e = CrudHelper::learnMethodType($entity, $field);
                if ($e == CrudHelper::BELONGS_TO) {
                    $entity->{$field}()->associate($value);
                }
                if ($e == CrudHelper::BELONGS_TO_MANY) {
                    $entity->{$field}()->sync($value);
                }
            }
        }

        // save relations
        $entity->save();

        return $entity;
    }

    /**
     * Update for crud
     * Need to use this function to set owner
     * @param $attributes
     * @param $entity
     * @return mixed
     */
    public function updateEntity($attributes, $entity)
    {
        unset($attributes['_method']);
        unset($attributes['_token']);
        unset($attributes['owned_by']);

        foreach ($attributes as $field => $value) {
            if (method_exists($entity, $field)) {


                $e = CrudHelper::learnMethodType($entity, $field);
                if ($e == CrudHelper::BELONGS_TO) {
                    $entity->{$field}()->associate($value);
                }
                if ($e == CrudHelper::BELONGS_TO_MANY) {
                    $entity->{$field}()->sync($value);
                }
            } else {
                if ($value == '') {
                    $value = null;
                }
                $entity->setAttribute($field, $value);
            }
        }

        $entity->save();

        return $entity;
    }

    /**
     * Next record
     *
     * @param $entity
     * @return mixed
     */
    public function next($entity)
    {
        $nextId = $this->model::where('id', '>', $entity->id)->min('id');
        if ($nextId > 0) {
            return $this->find($nextId);
        }
    }

    /**
     * Prev record
     *
     * @param $entity
     * @return mixed
     */
    public function prev($entity)
    {
        $prevOd = $this->model::where('id', '<', $entity->id)->max('id');
        if ($prevOd > 0) {
            return $this->find($prevOd);
        }
    }
}
