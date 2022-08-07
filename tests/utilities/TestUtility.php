<?php

/**
 * create - creates a new instance of the model and save it in the database
 *
 * @param $class
 * @param $attributes
 * @param $times
 * @return mixed
 */
function create($class, $attributes = [], $times = 1)
{
    if ($times == 1)
        return $class::factory()->create($attributes);

    return $class::factory()->count($times)->create($attributes);
}

/**
 * make - creates a new instance of the model
 *
 * @param $class
 * @param $attributes
 * @param $times
 * @return mixed
 */
function make($class, $attributes = [], $times = 1)
{
    if ($times == 1)
        return $class::factory()->make($attributes);

    return $class::factory()->count($times)->make($attributes);
}
