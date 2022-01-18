<?php namespace IgetMaster\MaterialAdmin\Controllers;

use Cache;
use IgetMaster\MaterialAdmin\Contracts\SearchableInterface as SearchableContract;
use IgetMaster\MaterialAdmin\Models\Contracts\PublicSearchable;
use Illuminate\Routing\Controller as BaseController;
//use ScoutElastic\Searchable;
use Sofa\Eloquence\Eloquence;

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
        if (array_key_exists('with', $settings) && is_array($settings['with']) && count($settings['with'])) {
            $with = $settings['with'];
        } else {
            $with = [];
        }

        $search = new $model;
        $primaryKey = $search->getKeyName();

        $uses = class_uses($model);

        // Deny access to non public searchable models
        if (!array_key_exists(PublicSearchable::class, class_implements($model)) && !auth()->check()) {
            return abort(401);
        }

        $scopesToApply = [];

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
                        if (array_key_exists(Searchable::class, $uses)) {
                            $scopesToApply[\Illuminate\Support\Str::camel($filter)] = [$filterValue];
                        } else {
                            $search = call_user_func_array([$search, \Illuminate\Support\Str::camel($filter)], [$filterValue]);
                        }
                    } else {
                        if ($options['required']) {
                            abort(422);
                        }
                    }
                }
            }

            if (array_key_exists(Searchable::class, $uses)) {
                if (count($scopesToApply)) {
                    $ids = $search->search($query)->take(5)->get()->pluck($primaryKey);
                    $search = new $model;
                    $search = $search->with($with)->whereIn($primaryKey, $ids);

                    foreach($scopesToApply as $scope=>$parameters) {
                        $search = call_user_func_array([$search, $scope], $parameters);
                    }

                    $result = $search->get()->toJson();
                } else {
                    $result = $search->search($query)->take(5)->get()->load($with)->toJson();
                }
            } else {
                if (count($with)) {
                    $search = $search->with($with);
                }

                if (array_key_exists(Eloquence::class, $uses)) {
                    $result = $search->search($query)->distinct()->orderBy('relevance', 'desc')->take(5)->get()->toJson();
                } else {
                    $result = $search->search($query, 1, true)->distinct()->orderBy('relevance', 'desc')->take(5)->get()->toJson();
                }
            }
        }

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
