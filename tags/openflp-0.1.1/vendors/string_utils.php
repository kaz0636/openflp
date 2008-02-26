<?php

function purify_url($url)
{
    // FIXME
    $url = htmlspecialchars($url, ENT_QUOTES);
    return $url;
}

function purify_html($html)
{
    // FIXME
    $html = strip_tags($html);
    $html = htmlspecialchars($html, ENT_QUOTES);
    return $html;
}

function scrub_html($html)
{
    // FIXME
    return purify_html($html);
}
