<?php namespace IgetMaster\MaterialAdmin\Controllers;

use IgetMaster\MaterialAdmin\Contracts\SearchableInterface as SearchableContract;
use Illuminate\Routing\Controller as BaseController;

class SearchController extends BaseController {

    private $aliases = [];

    public function __construct() {
        $this->aliases = \Config::get('admin.search.aliases');
    }

    /**
     * @param $model
     * @param $query
     * @return Array
     */
    public function search($model, $query) {
        if (array_key_exists($model, $this->aliases)) {
            $model = $this->aliases[$model];
        }
        return response()->json($model::search($query)->take(5)->get());
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
