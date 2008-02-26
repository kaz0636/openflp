<?php

function eh($string)
{
    echo htmlspecialchars($string, ENT_QUOTES);
}

class BasicsHelper extends Helper
{
    public function loadJS($files)
    {
        foreach ($files as $file) {
            $src = '/js/' . $file . '.js';
            $filename = JS . $file . '.js';
            if (file_exists($filename)) {
                $src .= '?' . date('YmdHis', filemtime($filename));
            }
            $s = sprintf('<script charset="utf-8" src="%s" type="text/javascript"></script>', h($src));
            echo $s . PHP_EOL;
        }
    }

    public function usersLink($feed)
    {
        $num = $feed['Feed']['subscribers_count'];
        if ($num > 0) {
            $s = sprintf('<a href="about/%s">%s</a>', h($feed['Feed']['feedlink']), $this->users($num, true));
        } else {
            $s = '(' . $this->users($num, true) . ')';
        }
        echo $s;
    }

    public function users($num, $return = false)
    {
        $user = ($num == 0 || $num > 1) ? 'users' : 'user';
        $s = h($num) . " {$user}";
        if ($return) return $s;
        echo $s;
    }

    public function rateImage($rate)
    {
        $s = sprintf('<img src="/img/rate/%s.gif" />', h($rate));
        echo $s;
    }

}
