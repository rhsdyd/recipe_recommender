<?php

require_once __DIR__ . '/Database.php';
$db = Database::getInstance();

class Food
{
    public $name = '';
    public $months = [];
}

function crawl_page($url)
{
    $dom = new DOMDocument('1.0');
    @$dom->loadHTMLFile($url);

    $anchors = $dom->getElementById('scrollable-section');
    $table = $anchors->firstChild;
    $tbody = $table->childNodes[1];

    $foods = [];

    foreach ($tbody->childNodes as $tr)
    {
        $food = new Food();
        $i = 0;
        foreach ($tr->childNodes as $td)
        {
            if ($i == 0)
                $food->name = $td->textContent;
            else
                $food->months[] = $td->textContent == ' At its best';

            $i++;
        }

        $foods[] = $food;
    }

    return $foods;
}

function save(Database $db, $data)
{
    foreach ($data as $entry)
    {
        $insert = [
            'food_name' => $db->escape($entry->name),
            'm1' =>  $entry->months[0],
            'm2' =>  $entry->months[1],
            'm3' =>  $entry->months[2],
            'm4' =>  $entry->months[3],
            'm5' =>  $entry->months[4],
            'm6' =>  $entry->months[5],
            'm7' =>  $entry->months[6],
            'm8' =>  $entry->months[7],
            'm9' =>  $entry->months[8],
            'm10' => $entry->months[9],
            'm11' => $entry->months[10],
            'm12' => $entry->months[11],
        ];
        $db->insert('seasonal_data', $insert);
    }
}

function truncate(Database $db)
{
    $db->truncate(['seasonal_data']);
}

truncate($db);
save($db, crawl_page("https://www.bbcgoodfood.com/seasonal-calendar/all"));

echo 'done';