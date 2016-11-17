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
        $this->aliases = \Config::get('search.aliases');
    }

    /**
     * @param $alias
     * @param $query
     * @return Array
     * @throws \Exception
     */
    public function search($alias, $query)
    {
        // Check if this alias have an model associated, if not, abort 404.
        if (array_key_exists($alias, $this->aliases)) {
            $settings = $this->aliases[$alias];
            $model = $settings['model'];
        } else {
            return abort(404);
        }

        /** @var array $tags */
        $tags = func_get_args();

        // If alias has relations, add it to query.
        if (array_key_exists('with', $settings) && is_array($settings['with'])) {
            $search = call_user_func_array("$model::with", $settings['with']);
        } else {
            $search = new $model;
        }

        // Deny access to non public searchable models
        if (!array_key_exists(PublicSearchable::class, class_implements($model)) && !auth()->check()) {
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
            if (array_key_exists('scopes', $settings) && is_array($settings['scopes'])) {
                foreach ($settings['scopes'] as $scope) {
                    $search = call_user_func_array([$search, $scope], []);
                }
            }

            // If alias has filters, parse it
            if (array_key_exists('filters', $settings) && is_array($settings['filters'])) {
                $arguments = func_get_args();
                array_splice($arguments, 0, 2);

                foreach ($settings['filters'] as $filter => $options) {
                    $filterFound = false;
                    $filterValue = null;
                    foreach ($arguments as $index => $argument) {
                        if ($argument == $filter) {
                            $filterFound = true;
                            if (array_key_exists($index + 1, $arguments)) {
                                $filterValue = $arguments[$index + 1];
                            } else {
                                throw new \Exception("Missing filter {$filter} argument");
                            }
                        }
                    }

                    if ($filterFound) {
                        $search = call_user_func_array([$search, $filter], [$filterValue]);
                    } else {
                        if ($options['required']) {
                            abort(422);
                        }
                    }
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