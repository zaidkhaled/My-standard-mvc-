<?php

function data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    return $data;
}

function string($data) 
{
    $data = trim($data);
    return filter_var($data, FILTER_SANITIZE_STRING);
}

function integer($integer, $filter = 'FALSE')
{
    if ($filter == "TRUE")
    {
        return filter_var($integer, FILTER_SANITIZE_NUMBER_INT);
    }
    return (int) $integer;
}

function email($email)
{
    return filter_var($email, FILTER_SANITIZE_EMAIL);
}

function url($url)
{
    return filter_var($url, FILTER_SANITIZE_URL);
}

function pre($array)
{
    echo "<pre>";
    print_r($array);
    echo "</pre>";
}

function is_email($email)
{
    if(filter_var($email, FILTER_VALIDATE_EMAIL) == TRUE)
    {
        return $email;
    }
}

