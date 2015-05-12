<?php namespace IgetMaster\MaterialAdmin\Controllers;

use IgetMaster\MaterialAdmin\Contracts\SearchableInterface as SearchableContract;
use Illuminate\Routing\Controller as BaseController;

class SearchController extends BaseController {

    private $aliases = [];

    public function __construct() {
        $this->aliases = \Config::get('admin.search.aliases');
        $this->scopes = \Config::get('admin.search.scopes');
        $this->relations = \Config::get('admin.search.relations');
    }

    /**
     * @param $model
     * @param $query
     * @return Array
     */
    public function search($model_alias, $query) {
        // Check if this alias have an model associated, if not, abort 404.
        if (array_key_exists($model_alias, $this->aliases)) {
            $model = $this->aliases[$model_alias];
        } else {
            abort(404);
        }

        // If alias has relations, add it to query.
        if (array_key_exists($model_alias, $this->relations)) {
            $search = call_user_func_array("$model::with", $this->relations[$model_alias]);
        } else {
            $search = new $model;
        }

        // If alias has scopes, add it to query.
        if (array_key_exists($model_alias, $this->scopes)) {
            foreach($this->scopes[$model_alias] as $scope => $arguments) {
                $total_args = func_num_args();
                $arg = [];
                foreach($arguments as $argument) {
                    if ($argument + 1 >= $total_args - 2) {
                        $arg[] = func_get_arg($argument + 2);
                    } else {
                        // If argument not exists, this is an invalid request for this alias.
                        abort(400);
                    }
                }
                $search = call_user_func_array([$search, $scope], $arg);
            }
        }

        return response()->json($search->search($query, null, true)->take(5)->get());
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
