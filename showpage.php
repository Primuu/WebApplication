<?php
function PokazPodstrone(mysqli $link, $id)
{
    $id_clear = htmlspecialchars($id);

    $query = "SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_array($result);

    if(empty($row['id']))
    {
        $web = '[nie_znaleziono_strony]';
    }
    else
    {
        $web = $row['page_content'];
    }

    echo $web;
}

function PokazTytul(mysqli $link, $id)
{
    $id_clear = htmlspecialchars($id);

    $query = "SELECT * FROM page_list WHERE id='$id_clear' LIMIT 1";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_array($result);

    if(empty($row['id']))
    {
        $title = '[nie_znaleziono_strony]';
    }
    else
    {
        $title = $row['page_title'];
    }

    return $title;
}
?>