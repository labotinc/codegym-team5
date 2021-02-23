<?php
//　補足：管理者画面作成時には値を変更することで対応可能
$record_name = [1, 2, 3, 4, 5, 6, 7, 8];
$column_name = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K'];
?>

<ul>
    <li>
        <p></p> <!-- gridでの左上の空白 -->
        <?php
        //カラムヘッダー出力
        for ($i = 0; $i < count($column_name); $i++) {
            echo '<p>' . $column_name[$i] . '</p>';
        }
        ?>
    </li>
    <?php
    // レコードヘッダーと席のボタン出力
    for ($j = 0; $j < count($record_name); $j++) {
        echo '<li>';
        echo '<p>' . $record_name[$j] . '</p>';
        for ($k = 0; $k < count($column_name); $k++) {
            $seat_value = $column_name[$k] . '-' . $record_name[$j];
            echo '<button type="button" value="' . $seat_value . '"></button>';
        }
        echo '<p>' . $column_name[$j] . '</p>';
        echo '<li>';
    }
    ?>
</ul>
