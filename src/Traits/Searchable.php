<?php 

namespace Rupesh\MicroMatrix\Traits;

/**
 * Use this trait in any model to make it listenable for other micro services
 */
trait Searchable
{
    public static function makeSearchQuery(&$query, $params) {
        $className = get_called_class();
        $id = self::getPrimaryKeyName();
        $table = self::getTableName();
        $listenableFields = self::listenableFields();

        if (isset($params['id'])) {
            $params['id'] = explode(",", $params['id']);
            $query->whereIn($table . '.' . $id, $params['id']);
        }
        if (!empty($params['search_text'])) {
            $query->where(function($q) use ($table,$listenableFields,$params,$id) {
                $q->whereRaw(" 1 ");
                foreach($listenableFields as $lf){
                    $q->orWhere($table . '.' . $lf, '=', $params['search_text']);
                } 
            });
        }
        return $query;
    }

    public static function getSearchSelect($params) {
        $className = get_called_class();
        $table =  self::getTableName();
        $id = self::getPrimaryKeyName();
        $listenableFields = self::listenableFields();
        $select = [$table . '.' . $id];
        foreach ( $listenableFields as $lf ) {
            $select[] = $table.'.'.$lf;
        }
        return $select;
    }

    public static function getSearchGroupBy() {
        $className = get_called_class();
        $table = self::getTableName();
        return $table . '.' . self::getPrimaryKeyName();
    }

    public static function searchRecords($params) {
        $className = get_called_class();
        $params['limit'] = isset($params['limit']) ? $params['limit'] : 10;
        $currentPage = (isset($params['page']) && $params['page'] > 0) ? $params['page'] : 1;
        $query = self::query();
        $query = $className::makeSearchQuery($query, $params);
        if(!empty($params['with'])){
            $withs = explode(',', $params['with']);
            foreach ($withs as $with) {
                if(method_exists($className,$with)){
                    $query->with($with);
                }
            }
        }
        $query->select($className::getSearchSelect($params));
        $groupBy = $className::getSearchGroupBy();
        
        if ($groupBy != false) {
            $query->groupBy($groupBy);
        }

        if(isset($params['order_by']) && !empty($params['order_by'])){
            $params['sort_order'] = isset($params['sort_order']) ? $params['sort_order'] : 'ASC';
            $query->orderBy($params['order_by'],$params['sort_order']);
        }

        try {
            $query->get();
            $query = $query->paginate($params['limit'], '*', 'page', $currentPage);
        } catch (\Throwable $th) {
            $arr = [
                'data' => [],
                'type' => 'error',
                'message' => $th->getMessage()
            ];
            $query = $arr;
        }

        return $query;
    }
}