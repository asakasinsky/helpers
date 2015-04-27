<?php

if ( ! function_exists('create_guid'))
{
    /**
     * Create GUID function
     * http://en.wikipedia.org/wiki/Globally_unique_identifier
     * 
     * @param  string $namespace  for more enthropy
     * @return string $guid       00000000-0000-0000-0000-000000000000
     */
    function create_guid($namespace='')
    {
        static $guid = '';
        $allowed_keys = array(
            'REQUEST_TIME',
            'HTTP_USER_AGENT',
            'LOCAL_ADDR',
            'REMOTE_ADDR',
            'REMOTE_PORT'
            );
        $request_data = array_intersect_key(
            $_SERVER,
            array_fill_keys(
                $allowed_keys,
                null
                )
            );
        $uid = uniqid($namespace, true);
        $data = implode('', $request_data);
        $hash = strtoupper(hash('ripemd128', $uid . $guid . md5($data)));
        $guid = substr($hash,  0,  8).
            '-'.substr($hash,  8,  4).
            '-'.substr($hash, 12,  4).
            '-'.substr($hash, 16,  4).
            '-'.substr($hash, 20, 12);
        return $guid;
    }
}
