<?php

/**
 * Proxy script to load a file from other domain
 *
 * PHP versions 4 and 5
 *
 * Copyright (c) 2010-2013 Shinya Muramatsu
 *
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
 * THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER
 * DEALINGS IN THE SOFTWARE.
 *
 * @author     Shinya Muramatsu <revulon@gmail.com>
 * @copyright  2010-2013 Shinya Muramatsu
 * @license    http://www.opensource.org/licenses/mit-license.php  MIT License
 * @link       http://flashcanvas.net/
 * @link       http://code.google.com/p/flashcanvas/
 */

function getHostName() {
    if (isset($_SERVER['HTTP_X_FORWARDED_HOST'])) {
        return $_SERVER['HTTP_X_FORWARDED_HOST'];
    } else if (isset($_SERVER['HTTP_HOST'])) {
        return $_SERVER['HTTP_HOST'];
    } else {
        return $_SERVER['SERVER_NAME'];
    }
}

// Whether we check referrer or not
define('CHECK_REFERRER', true);

// If necessary, specify the host where the SWF file is located
define('SWF_HOST_NAME', '');

// Check that the request comes from the same host
if (CHECK_REFERRER) {
    if (empty($_SERVER['HTTP_REFERER'])) {
        exit;
    }
    if (SWF_HOST_NAME) {
        $host = SWF_HOST_NAME;
    } else {
        $host = getHostName();
    }
    $pattern = '#^https?://' . str_replace('.', '\.', $host) . '(:\d*)?/#';
    if (!preg_match($pattern, $_SERVER['HTTP_REFERER'])) {
        exit;
    }
}

// Check that the request has a valid URL parameter
if (empty($_GET['url'])) {
    exit;
}
if (!preg_match('#^https?://#', $_GET['url'])) {
    exit;
}

// Percent-encode special characters in the URL
$search  = array(  '%',   '#',   ' ');
$replace = array('%25', '%23', '%20');
$url     = str_replace($search, $replace, $_GET['url']);

// Disable compression
header('Content-Encoding: none');

// Load and output the file
if (extension_loaded('curl')) {
    // Use cURL extension
    $ch = curl_init($url);
//  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
//  curl_setopt($ch, CURLOPT_MAXREDIRS, 10);
    curl_exec($ch);
    curl_close($ch);
} else {
    // Use the http:// wrapper
    readfile($url);
}
