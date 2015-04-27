<?php namespace IgetMaster\MaterialAdmin\Controllers;

use IgetMaster\MaterialAdmin\Contracts\SearchableInterface as SearchableContract;
use Illuminate\Routing\Controller as BaseController;

class SearchController extends BaseController {

    private $aliases = [];

    public function __construct() {
        $this->aliases = \Config::get('admin.search.aliases');
        $this->relations = \Config::get('admin.search.relations');
    }

    /**
     * @param $model
     * @param $query
     * @return Array
     */
    public function search($model_alias, $query) {
        if (array_key_exists($model_alias, $this->aliases)) {
            $model = $this->aliases[$model_alias];
        }

        if (array_key_exists($model_alias, $this->relations)) {
            $search = call_user_func_array("$model::with", $this->relations);
        } else {
            $search = new $model;
        }

        return response()->json($search->search($query)->take(5)->get());
    }

    /**
     * @param SearchableContract $searchable
     * @param string $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function getNaturalSearchResults(SearchableContract $searchable, $query, $limit)
    {
        return $searchable->naturalSearch($query)->take($limit)->get();
    }
}
