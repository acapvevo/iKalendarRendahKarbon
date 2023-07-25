<?php

namespace App\Plugins;

use PDO;
use PDOException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Query\Builder;


/*
 * Helper functions for building a DataTables server-side processing SQL query
 *
 * The static functions in this class are just helper functions to help build
 * the SQL used in the DataTables demo server-side processing scripts. These
 * functions obviously do not represent all that can be done with server-side
 * processing, they are intentionally simple to show how it works. More complex
 * server-side processing operations will likely require a custom script.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */


class Datatable
{
    /**
     * Create the data output array for the DataTables rows
     *
     *  @param  array       $columns    Column information array
     *  @param  Collection  $data       Data from the SQL get
     *  @return array                   Formatted data in a row based format
     */
    static function data_output($columns, $data)
    {
        $out = array();

        for ($i = 0, $ien = count($data); $i < $ien; $i++) {
            $row = array();

            for ($j = 0, $jen = count($columns); $j < $jen; $j++) {
                $column = $columns[$j];

                // Is there a formatter?
                if (isset($column['formatter'])) {
                    // if (empty($column['db'])) {
                    //     // $row[$column['dt']] = $column['formatter']($data[$i]);

                    //     $row[$column['dt']] = $column['formatter']($data->get($i));
                    // } else {
                    //     // $row[$column['dt']] = $column['formatter']($data[$i][$column['db']], $data[$i]);

                    //     $row[$column['dt']] = $column['formatter']($data->get($i)->{$columns[$j]['as']}, $data->get($i));
                    // }

                    $row[$column['dt']] = $column['formatter']($data->get($i)->{$columns[$j]['as']} ?? '', $data->get($i));
                } else {
                    // if (!empty($column['db'])) {
                    //     // $row[$column['dt']] = $data[$i][$columns[$j]['db']];

                    //     $row[$column['dt']] = $data->get($i)->{$columns[$j]['as']};
                    // } else {
                    //     $row[$column['dt']] = "";
                    // }

                    $row[$column['dt']] = $data->get($i)->{$columns[$j]['as']};
                }
            }

            $out[] = $row;
        }

        return $out;
    }

    /**
     * Paging
     *
     * Construct the LIMIT clause for server-side processing SQL query
     *
     *  @param  array   $request    Data sent to server by DataTables
     *  @param  Builder $dbObj      Added LIKE Clause Builder Object
     *  @return void
     */
    static function limit($request, $dbObj)
    {
        // $limit = '';

        if (isset($request['start']) && $request['length'] != -1) {
            $dbObj = $dbObj->skip(intval($request['start']))->take(intval($request['length']));
            // $limit = "LIMIT " . intval($request['start']) . ", " . intval($request['length']);
        }
        // return $limit;
    }


    /**
     * Ordering
     *
     * Construct the ORDER BY clause for server-side processing SQL query
     *
     *  @param  array   $request    Data sent to server by DataTables
     *  @param  Builder $dbObj      Added LIMIT Clause Builder Object
     *  @param  array   $columns    Column information array
     *  @return void
     */
    static function order($request, $dbObj, $columns)
    {
        if (isset($request['order']) && count($request['order'])) {
            $orderBy = array();
            $dtColumns = self::pluck($columns, 'dt');

            for ($i = 0, $ien = count($request['order']); $i < $ien; $i++) {
                // Convert the column index into the column data property
                $columnIdx = intval($request['order'][$i]['column']);
                $requestColumn = $request['columns'][$columnIdx];

                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];

                if ($requestColumn['orderable'] == 'true') {
                    $dir = $request['order'][$i]['dir'] === 'asc' ?
                        'ASC' :
                        'DESC';

                    $orderBy[] = [
                        'column' => $column['db'],
                        'dir' => $dir,
                    ];
                    // $orderBy[] = '`' . $column['db'] . '` ' . $dir;
                }
            }

            if (count($orderBy)) {
                foreach ($orderBy as $orderByRow) {
                    $dbObj = $dbObj->orderBy($orderByRow['column'], $orderByRow['dir']);
                }
                // $order = 'ORDER BY ' . implode(', ', $orderBy);
            }
        }
    }


    /**
     * Searching / Filtering
     *
     * Construct the WHERE clause for server-side processing SQL query.
     *
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here performance on large
     * databases would be very poor
     *
     *  @param  array   $request    Data sent to server by DataTables
     *  @param  Builder $dbObj      Default Builder Object
     *  @param  array   $columns    Column information array
     *  @return void
     */
    static function filter($request, $dbObj, $columns)
    {
        $globalSearch = array();
        $columnSearch = array();
        $dtColumns = self::pluck($columns, 'dt');

        if (isset($request['search']) && $request['search']['value'] != '') {
            $str = $request['search']['value'];

            for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];

                if ($requestColumn['searchable'] == 'true') {
                    if (!empty($column['db'])) {
                        $globalSearch[] = [
                            'inFilter' => isset($column['inFilter']) ? $column['inFilter'] : true,
                            'column' => $column['db'],
                            'str' => isset($column['reader']) ? $column['reader']($str) : $str
                        ];

                        // $binding = self::bind($bindings, '%' . $str . '%', PDO::PARAM_STR);
                        // $globalSearch[] = "`" . $column['db'] . "` LIKE " . $binding;
                    }
                }
            }
        }

        // Individual column filtering
        if (isset($request['columns'])) {
            for ($i = 0, $ien = count($request['columns']); $i < $ien; $i++) {
                $requestColumn = $request['columns'][$i];
                $columnIdx = array_search($requestColumn['data'], $dtColumns);
                $column = $columns[$columnIdx];

                $str = $requestColumn['search']['value'];

                if (
                    $requestColumn['searchable'] == 'true' &&
                    $str != ''
                ) {
                    if (!empty($column['db'])) {
                        $columnSearch[] = [
                            'inFilter' => isset($column['inFilter']) ? $column['inFilter'] : true,
                            'column' => $column['db'],
                            'str' => isset($column['reader']) ? $column['reader']($str) : $str
                        ];

                        // $binding = self::bind($bindings, '%' . $str . '%', PDO::PARAM_STR);
                        // $columnSearch[] = "`" . $column['db'] . "` LIKE " . $binding;
                    }
                }
            }
        }

        // Combine the filters into a single string
        // $where = '';

        if (count($globalSearch)) {
            $dbObj = $dbObj->where(function ($query) use ($globalSearch) {
                foreach ($globalSearch as $globalSearchRow) {
                    if (!$globalSearchRow['inFilter'])
                        continue;

                    $query = $query->orWhere($globalSearchRow['column'], 'LIKE', '%' . $globalSearchRow['str'] . '%');
                }
            });

            // $where = '(' . implode(' OR ', $globalSearch) . ')';
        }

        if (count($columnSearch)) {
            $dbObj = $dbObj->where(function ($query) use ($columnSearch) {
                foreach ($columnSearch as $columnSearchRow) {
                    if (!$columnSearchRow['inFilter'])
                        continue;

                    $query = $query->orWhere($columnSearchRow['column'], 'LIKE', '%' . $columnSearchRow['str'] . '%');
                }
            });
            // $where = $where === '' ?
            //     implode(' AND ', $columnSearch) :
            //     $where . ' AND ' . implode(' AND ', $columnSearch);
        }

        // if ($where !== '') {
        //     $where = 'WHERE ' . $where;
        // }
    }

    /**
     *  @param  array   $data       Search Builder data
     *  @param  Builder $dbObj      Default Builder Object
     *  @param  array   $columns    Column information array
     *  @return void
     */
    static function search_builder($data, $dbObj, $columns)
    {
        $first = true;

        if (!isset($data['criteria'])) {
            return;
        }

        // Iterate over every group or criteria in the current group
        foreach ($data['criteria'] as $crit) {

            // If criteria is defined then this must be a group
            if (isset($crit['criteria'])) {

                // Check if this is the first, or if it is and logic
                if ($data['logic'] === 'AND' || $first) {
                    // Call the function for the next group
                    $dbObj->where(function ($q) use ($crit, $columns) {
                        $this->search_builder($q, $crit, $columns);
                    });

                    // Set first to false so that in future only the logic is checked
                    $first = false;
                } else {
                    $dbObj->orWhere(function ($q) use ($crit, $columns) {
                        $this->search_builder($q, $crit, $columns);
                    });
                }
            } else if (isset($crit['condition']) && ((isset($crit['value1']) || isset($crit['value'][0])) || $crit['condition'] === 'null' || $crit['condition'] === '!null')) {
                // Sometimes the structure of the object that is passed across is named in a strange way.
                // This conditional assignment solves that issue
                if(isset($crit['value1']) || isset($crit['value2'])){
                    $val1 = $crit['value1'];
                    $val2 = isset($crit['value2']) ? $crit['value2'] : '';
                } else if(isset($crit['value'][0]) || isset($crit['value'][1])){
                    $val1 = $crit['value'][0];
                    $val2 = isset($crit['value'][1]) ? $crit['value'][1] : '';
                } else {
                    $val1 = '';
                    $val2 = '';
                }

                if (strlen($val1) === 0 && $crit['condition'] !== 'null' && $crit['condition'] !== '!null') {
                    continue;
                }
                if (strlen($val2) === 0 && ($crit['condition'] === 'between' || $crit['condition'] === '!between')) {
                    continue;
                }

                $column = collect($columns)->where('title', $crit['data'])->first();
                $crit['data'] = $column['db'] ?? $crit['data'];
                //Debugbar::info($crit['origData']);

                // Format value based on column details given in $columns
                if (isset($column['reader'])) {
                    if ($val1) {
                        $val1 = $column['reader']($val1);
                    }
                    if ($val2) {
                        $val2 = $column['reader']($val2);
                    }
                }

                // Switch on the condition that has been passed in
                switch ($crit['condition']) {
                    case '=':
                        // Check if this is the first, or if it is and logic
                        if ($data['logic'] === 'AND' || $first) {
                            // Call the where function for this condition
                            $dbObj = $dbObj->where($crit['data'], '=', $val1);
                            // Set first to false so that in future only the logic is checked
                            $first = false;
                        } else {
                            // Call the orWhere function - has to be or logic in this block
                            $dbObj->orWhere($crit['data'], '=', $val1);
                        }
                        break;
                    case '!=':
                        if ($data['logic'] === 'AND' || $first) {
                            $dbObj->where($crit['data'], '!=', $val1);
                            $first = false;
                        } else {
                            $dbObj->orWhere($crit['data'], '!=', $val1);
                        }
                        break;
                    case 'contains':
                        if ($data['logic'] === 'AND' || $first) {
                            $dbObj->where($crit['data'], 'LIKE', '%' . $val1 . '%');
                            $first = false;
                        } else {
                            $dbObj->orWhere($crit['data'], 'LIKE', '%' . $val1 . '%');
                        }
                        break;
                    case 'starts':
                        if ($data['logic'] === 'AND' || $first) {
                            $dbObj->where($crit['data'], 'LIKE', $val1 . '%');
                            $first = false;
                        } else {
                            $dbObj->orWhere($crit['data'], 'LIKE', $val1 . '%');
                        }
                        break;
                    case 'ends':
                        if ($data['logic'] === 'AND' || $first) {
                            $dbObj->where($crit['data'], 'LIKE', '%' . $val1);
                            $first = false;
                        } else {
                            $dbObj->orWhere($crit['data'], 'LIKE', '%' . $val1);
                        }
                        break;
                    case '<':
                        if ($data['logic'] === 'AND' || $first) {
                            $dbObj->where($crit['data'], '<', $val1);
                            $first = false;
                        } else {
                            $dbObj->orWhere($crit['data'], '<', $val1);
                        }
                        break;
                    case '<=':
                        if ($data['logic'] === 'AND' || $first) {
                            $dbObj->where($crit['data'], '<=', $val1);
                            $first = false;
                        } else {
                            $dbObj->orWhere($crit['data'], '<=', $val1);
                        }
                        break;
                    case '>=':
                        if ($data['logic'] === 'AND' || $first) {
                            $dbObj->where($crit['data'], '>=', $val1);
                            $first = false;
                        } else {
                            $dbObj->orWhere($crit['data'], '>=', $val1);
                        }
                        break;
                    case '>':
                        if ($data['logic'] === 'AND' || $first) {
                            $dbObj->where($crit['data'], '>', $val1);
                            $first = false;
                        } else {
                            $dbObj->orWhere($crit['data'], '>', $val1);
                        }
                        break;
                    case 'between':
                        if ($data['logic'] === 'AND' || $first) {
                            $dbObj->where(function ($q) use ($crit, $val1, $val2) {
                                $q->where($crit['data'], '>=', is_numeric($val1) ? intval($val1) : $val1)->where($crit['data'], '<=', is_numeric($val2) ? intval($val2) : $val2);
                            });
                            $first = false;
                        } else {
                            $dbObj->orWhere($crit['data'], '>=', is_numeric($val1) ? intval($val1) : $val1)->where($crit['data'], '<=', is_numeric($val2) ? intval($val2) : $val2);
                        }
                        break;
                    case '!between':
                        if ($data['logic'] === 'AND' || $first) {
                            $dbObj->where(function ($q) use ($crit, $val1, $val2) {
                                $q->where($crit['data'], '<', is_numeric($val1) ? intval($val1) : $val1)->orWhere($crit['data'], '<', is_numeric($val2) ? intval($val2) : $val2, '>');
                            });
                            $first = false;
                        } else {
                            $dbObj->orWhere($crit['data'], '<', is_numeric($val1) ? intval($val1) : $val1)->orWhere($crit['data'], '<', is_numeric($val2) ? intval($val2) : $val2, '>');
                        }
                        break;
                    case 'null':
                        if ($data['logic'] === 'AND' || $first) {
                            $dbObj->where(function ($q) use ($crit) {
                                $q->where($crit['data'], "=", null);
                                if (strpos($crit['type'], 'date') === false && strpos($crit['type'], 'moment') === false && strpos($crit['type'], 'luxon') === false) {
                                    $q->orWhere($crit['data'], "=", "");
                                }
                            });
                            $first = false;
                        } else {
                            $dbObj->orWhere(function ($q) use ($crit) {
                                $q->where($crit['data'], "=", null);
                                if (strpos($crit['type'], 'date') === false && strpos($crit['type'], 'moment') === false && strpos($crit['type'], 'luxon') === false) {
                                    $q->orWhere($crit['data'], "=", "");
                                }
                            });
                        }
                        break;
                    case '!null':
                        if ($data['logic'] === 'AND' || $first) {
                            $dbObj->where(function ($q) use ($crit) {
                                $q->where($crit['data'], "!=", null);
                                if (strpos($crit['type'], 'date') === false && strpos($crit['type'], 'moment') === false && strpos($crit['type'], 'luxon') === false) {
                                    $q->where($crit['data'], "!=", "");
                                }
                            });
                            $first = false;
                        } else {
                            $dbObj->orWhere(function ($q) use ($crit) {
                                $q->where($crit['data'], "!=", null);
                                if (strpos($crit['type'], 'date') === false && strpos($crit['type'], 'moment') === false && strpos($crit['type'], 'luxon') === false) {
                                    $q->where($crit['data'], "!=", "");
                                }
                            });
                        }
                        break;
                    default:
                        break;
                }
            }
        }
    }


    /**
     * Perform the SQL queries needed for an server-side processing requested,
     * utilising the helper functions of this class, limit(), order() and
     * filter() among others. The returned array is ready to be encoded as JSON
     * in response to an SSP request, or can be modified if needed before
     * sending back to the client.
     *
     *  @param  array   $request    Data sent to server by DataTables
     *  @param  Builder $dbObj      Builder object
     *  @param  array   $columns    Column information array
     *  @return array               Server-side processing response array
     */
    static function simple($request, $dbObj, $columns)
    {
        // Total data set length
        $recordsTotal = $dbObj->count();

        self::filter($request, $dbObj, $columns);
        if (isset($request['searchBuilder'])) {
            self::search_builder($request['searchBuilder'], $dbObj, $columns);
        }

        // Data set length after filtering
        $recordsFiltered = $dbObj->count();

        // Build the SQL query string from the request
        self::limit($request, $dbObj);
        self::order($request, $dbObj, $columns);

        // Main query to actually get the data
        $data = $dbObj->get();

        /*
		 * Output
		 */
        return array(
            "draw"            => isset($request['draw']) ?
                intval($request['draw']) :
                0,
            "recordsTotal"    => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data"            => self::data_output($columns, $data)
        );
    }


    /**
     * The difference between this method and the `simple` one, is that you can
     * apply additional `where` conditions to the SQL queries. These can be in
     * one of two forms:
     *
     * * 'Result condition' - This is applied to the result set, but not the
     *   overall paging information query - i.e. it will not effect the number
     *   of records that a user sees they can have access to. This should be
     *   used when you want apply a filtering condition that the user has sent.
     * * 'All condition' - This is applied to all queries that are made and
     *   reduces the number of records that the user can access. This should be
     *   used in conditions where you don't want the user to ever have access to
     *   particular records (for example, restricting by a login id).
     *
     *  @param  array $request Data sent to server by DataTables
     *  @param  array|PDO $conn PDO connection resource or connection parameters array
     *  @param  string $table SQL table to query
     *  @param  string $primaryKey Primary key of the table
     *  @param  array $columns Column information array
     *  @param  string $whereResult WHERE condition to apply to the result set
     *  @param  string $whereAll WHERE condition to apply to all queries
     *  @return array          Server-side processing response array
     */
    static function complex($request, $table, $primaryKey, $columns, $whereResult = null, $whereAll = null)
    {
        $bindings = array();
        $db = self::db(self::getSqlDetails());
        $localWhereResult = array();
        $localWhereAll = array();
        $whereAllSql = '';

        // Build the SQL query string from the request
        $limit = self::limit($request, $columns);
        $order = self::order($request, $columns);
        $where = self::filter($request, $columns, $bindings);

        $whereResult = self::_flatten($whereResult);
        $whereAll = self::_flatten($whereAll);

        if ($whereResult) {
            $where = $where ?
                $where . ' AND ' . $whereResult :
                'WHERE ' . $whereResult;
        }

        if ($whereAll) {
            $where = $where ?
                $where . ' AND ' . $whereAll :
                'WHERE ' . $whereAll;

            $whereAllSql = 'WHERE ' . $whereAll;
        }

        // Main query to actually get the data
        $data = self::sql_exec(
            $db,
            $bindings,
            "SELECT `" . implode("`, `", self::pluck($columns, 'db')) . "`
			 FROM `$table`
			 $where
			 $order
			 $limit"
        );

        // Data set length after filtering
        $resFilterLength = self::sql_exec(
            $db,
            $bindings,
            "SELECT COUNT(`{$primaryKey}`)
			 FROM   `$table`
			 $where"
        );
        $recordsFiltered = $resFilterLength[0][0];

        // Total data set length
        $resTotalLength = self::sql_exec(
            $db,
            $bindings,
            "SELECT COUNT(`{$primaryKey}`)
			 FROM   `$table` " .
                $whereAllSql
        );
        $recordsTotal = $resTotalLength[0][0];

        /*
		 * Output
		 */
        return array(
            "draw"            => isset($request['draw']) ?
                intval($request['draw']) :
                0,
            "recordsTotal"    => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data"            => self::data_output($columns, $data)
        );
    }

    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Internal methods
	 */

    /**
     * Pull a particular property from each assoc. array in a numeric array,
     * returning and array of the property values from each item.
     *
     *  @param  array  $a    Array to get data from
     *  @param  string $prop Property to read
     *  @return array        Array of property values
     */
    static function pluck($a, $prop)
    {
        $out = array();

        for ($i = 0, $len = count($a); $i < $len; $i++) {
            if (empty($a[$i][$prop])) {
                continue;
            }
            //removing the $out array index confuses the filter method in doing proper binding,
            //adding it ensures that the array data are mapped correctly
            $out[$i] = $a[$i][$prop];
        }

        return $out;
    }


    /**
     * Return a string from an array or a string
     *
     * @param  array|string $a Array to join
     * @param  string $join Glue for the concatenation
     * @return string Joined string
     */
    static function _flatten($a, $join = ' AND ')
    {
        if (!$a) {
            return '';
        } else if ($a && is_array($a)) {
            return implode($join, $a);
        }
        return $a;
    }
}
