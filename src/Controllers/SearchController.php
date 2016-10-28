<?php namespace IgetMaster\MaterialAdmin\Controllers;

use Cache;
use IgetMaster\MaterialAdmin\Contracts\SearchableInterface as SearchableContract;
use IgetMaster\MaterialAdmin\Models\Contracts\PublicSearchable;
use Illuminate\Routing\Controller as BaseController;

class SearchController extends BaseController
{

    private $aliases = [];

    public function __construct()
    {
        $this->aliases = \Config::get('admin.search.aliases');
        $this->scopes = \Config::get('admin.search.scopes');
        $this->relations = \Config::get('admin.search.relations');
    }

    /**
     * @param $model
     * @param $query
     * @return Array
     */
    public function search($model_alias, $query)
    {
        // Check if this alias have an model associated, if not, abort 404.
        if (array_key_exists($model_alias, $this->aliases)) {
            $model = $this->aliases[$model_alias];
        } else {
            abort(404);
        }

        /** @var array $tags */
        $tags = func_get_args();

        // If alias has relations, add it to query.
        if (array_key_exists($model_alias, $this->relations)) {
            $search = call_user_func_array("$model::with", $this->relations[$model_alias]);
        } else {
            $search = new $model;
        }

        // Deny access to non public searchable models
        if (!array_key_exists(PublicSearchable::class, class_implements($model)) || !auth()->check()) {
            dd(!array_key_exists(PublicSearchable::class, class_implements($model)), !auth()->check(), auth()->user(), \Auth::user());
            return abort(401);
        }

        // Use cached results if available
        if (!config()->get('app.debug') && Cache::tags($tags)->has($query)) {
            return Cache::tags($tags)->get($query);
        }

        if (method_exists($search, 'elasticSearch')) {
            $result = call_user_func_array([$search, 'elasticSearch'], array_slice(func_get_args(), 1));
        } else {
            // If alias has scopes, add it to query.
            if (array_key_exists($model_alias, $this->scopes)) {
                foreach ($this->scopes[$model_alias] as $scope => $arguments) {
                    $total_args = func_num_args();
                    $arg = [];
                    foreach ($arguments as $argument) {
                        if ($argument + 1 >= $total_args - 2) {
                            $arg[] = func_get_arg($argument + 2);
                            $tags[] = func_get_arg($argument + 2);
                        } else {
                            // If argument not exists, this is an invalid request for this alias.
                            abort(400);
                        }
                    }
                    $search = call_user_func_array([$search, $scope], $arg);
                }
            }

            $result = $search->search($query, null, true)->distinct()->orderBy('relevance', 'desc')->take(5)->get()->toJson();
        }

        Cache::tags($tags)->put($query, $result, config()->get('admin.search.cache_lifetime', 5));
        return $result;
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
