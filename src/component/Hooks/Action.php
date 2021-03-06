<?php

namespace Rudolf\Component\Hooks;

/**
 * Hooks class. (WordPress plugin API fork).
 *
 * @author Mikołaj Pich <m.pich@outlook.com>
 *
 * @version 0.1
 */
class Action
{
    /**
     * holds list of actions.
     *
     * @var array
     */
    public static $actions = array();

    /**
     * add Hooks a function on to a specific action.
     *
     * @since 0.1
     *
     * @param string   $tag           The name of the action to which the $functionToAdd is hooked.
     * @param callback $functionToAdd The name of the function you wish to be called.
     * @param int      $priority      optional. Used to specify the order in which the functions associated
     *                                with a particular action are executed (default: 10). Lower numbers correspond with
     *                                earlier execution, and functions with the same priority are executed in the order in
     *                                which they were added to the action.
     * @param int      $accepted_args optional. The number of arguments the function accept (default 1).
     *
     * @return bool
     */
    public static function add($tag, $functionToAdd, $priority = 10, $accepted_args = 1)
    {
        return Filter::add($tag, $functionToAdd, $priority, $accepted_args);
    }

    /**
     * isHas Check if any action has been registered for a hook.
     *
     * @since 0.1
     *
     * @param string   $tag               The name of the action hook.
     * @param callback $function_to_check optional.
     *
     * @return mixed If $function_to_check is omitted, returns boolean for whether the hook has
     *               anything registered. When checking a specific function, the priority of that hook is
     *               returned, or false if the function is not attached. When using the $function_to_check
     *               argument, this function may return a non-boolean value that evaluates to false
     *               (e.g.) 0, so use the === operator for testing the return value.
     */
    public static function isHas($tag, $function_to_check = false)
    {
        return Filter::has($tag, $function_to_check);
    }

    /**
     * remove Removes a function from a specified action hook.
     *
     * @since 0.1
     *
     * @param string   $tag              The action hook to which the function to be removed is hooked.
     * @param callback $functionToRemove The name of the function which should be removed.
     * @param int      $priority         optional The priority of the function (default: 10).
     *
     * @return bool Whether the function is removed.
     */
    public static function remove($tag, $functionToRemove, $priority = 10)
    {
        return Filter::remove($tag, $functionToRemove, $priority);
    }

    /**
     * removeAll Remove all of the hooks from an action.
     *
     * @since 0.1
     *
     * @param string $tag      The action to remove hooks from.
     * @param int    $priority The priority number to remove them from.
     *
     * @return bool True when finished.
     */
    public function removeAll($tag, $priority = false)
    {
        return Filter::removeAll($tag, $priority);
    }

    /**
     * dispatch Execute functions hooked on a specific action hook.
     *
     * @since 0.1
     *
     * @param string $tag     The name of the action to be executed.
     * @param mixed  $arg,... Optional additional arguments which are passed on to the functions
     *                        hooked to the action.
     */
    public static function dispatch($tag, $arg = '')
    {
        if (!isset(self::$actions)) {
            self::$actions = array();
        }

        if (!isset(self::$actions[$tag])) {
            self::$actions[$tag] = 1;
        } else {
            ++self::$actions[$tag];
        }

        // Do 'all' actions first
        if (isset(Filter::$filters['all'])) {
            Filter::$currentFilter[] = $tag;
            $all_args = func_get_args();
            self::_call_all_hook($all_args);
        }

        if (!isset(Filter::$filters[$tag])) {
            if (isset(Filter::$filters['all'])) {
                array_pop(Filter::$currentFilter);
            }

            return;
        }

        if (!isset(Filter::$filters['all'])) {
            Filter::$currentFilter[] = $tag;
        }

        $args = array();
        if (is_array($arg) && 1 == count($arg) && isset($arg[0]) && is_object($arg[0])) { // array (&$this)
            $args[] = &$arg[0];
        } else {
            $args[] = $arg;
        }
        for ($a = 2, $aMax = func_num_args(); $a < $aMax; ++$a) {
            $args[] = func_get_arg($a);
        }

        // Sort
        if (!isset(Filter::$mergedFilters[ $tag ])) {
            ksort(Filter::$filters[$tag]);
            Filter::$mergedFilters[ $tag ] = true;
        }

        reset(Filter::$filters[$tag]);

        do {
            foreach ((array) current(Filter::$filters[$tag]) as $the_) {
                if (!is_null($the_['function'])) {
                    call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));
                }
            }
        } while (next(Filter::$filters[$tag]) !== false);

        array_pop(Filter::$currentFilter);
    }

    /**
     * doRefArray Execute functions hooked on a specific action hook, specifying arguments in an array.
     *
     * @since 0.1
     *
     * @param string $tag  The name of the action to be executed.
     * @param array  $args The arguments supplied to the functions hooked to <tt>$tag</tt>
     */
    public static function doRefArray($tag, $args)
    {
        if (!isset(self::$actions)) {
            self::$actions = array();
        }

        if (!isset(self::$actions[$tag])) {
            self::$actions[$tag] = 1;
        } else {
            ++self::$actions[$tag];
        }

        // Do 'all' actions first
        if (isset(Filter::$filters['all'])) {
            Filter::$currentFilter[] = $tag;
            $all_args = func_get_args();
            self::$_call_all_hook($all_args);
        }

        if (!isset(Filter::$filters[$tag])) {
            if (isset(Filter::$filters['all'])) {
                array_pop(Filter::$currentFilter);
            }

            return;
        }

        if (!isset(Filter::$filters['all'])) {
            Filter::$currentFilter[] = $tag;
        }

        // Sort
        if (!isset($merged_filters[ $tag ])) {
            ksort(Filter::$filters[$tag]);
            $merged_filters[ $tag ] = true;
        }

        reset(Filter::$filters[ $tag ]);

        do {
            foreach ((array) current(Filter::$filters[$tag]) as $the_) {
                if (!is_null($the_['function'])) {
                    call_user_func_array($the_['function'], array_slice($args, 0, (int) $the_['accepted_args']));
                }
            }
        } while (next(Filter::$filters[$tag]) !== false);

        array_pop(Filter::$currentFilter);
    }

    /**
     * did Retrieve the number of times an action is fired.
     *
     * @since 0.1
     *
     * @param string $tag The name of the action hook.
     *
     * @return int The number of times action hook <tt>$tag</tt> is fired
     */
    public static function did($tag)
    {
        if (!isset(self::$actions) || !isset(self::$actions[$tag])) {
            return 0;
        }

        return self::$actions[$tag];
    }

    /**
     * Retrieve the name of the current action.
     *
     * @since 0.1.2
     *
     * @uses Filter::current()
     *
     * @return string Hook name of the current action.
     */
    public static function current()
    {
        return Filter::current();
    }

    /**
     * Retrieve the name of an action currently being processed.
     *
     * @since 0.1.2
     *
     * @uses Filter::doing()
     *
     * @param string|null $action Optional. Action to check. Defaults to null, which checks
     *                            if any action is currently being run.
     *
     * @return bool Whether the action is currently in the stack.
     */
    public static function doing($action = null)
    {
        return Filter::doing($action);
    }
}
