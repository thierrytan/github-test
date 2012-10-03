<?php
    function form_begin ($class, $method, $action) {
        echo "<form name ='$class' method='$method' action='$action'>";
    }

    function form_end() {
        echo "</form>";
    }
    
    function form_input_text ($label, $name, $size, $value) {
        echo "<label>$label : </label><br>";
        echo "<input type='text' name='$name' size='$size' value='$value'/></br>";
    }

    function form_input_password ($label, $name, $size) {
        echo "<label>$label : </label><br>";
        echo "<input type='password' name='$name' size='$size'/></br>";
    }

    function form_select ($label, $name, $multiple, $size, $hashtable) {
        echo "<label>$label : </label><br>";
        echo "<select name='$name' $multiple size=$size/>";
        foreach ($hashtable as $key => $value) {
            echo "<option value='$key'>$value</option>";
        }
        echo "</select>";
    }

    function form_input_checkbox ($name, $checked, $label) {
        echo "<label>$label : </label><br>";
        echo "<input type='checkbox' name='$name' checked='$checked'/></br>";
    }

    function form_input_radio ($name, $checked, $value, $label) {
        echo "<input type='radio' name='$name' checked='$checked' value='$value'/>$label</br>";
    }

    function form_input_submit ($value) {
        echo "<input type='submit' value='$value'/>";
    }

    function form_input_reset ($value) {
        echo "<input type='reset' value='$value'/>";
    }

    function form_textarea ($label, $name, $value) {
        echo "<label>$label : </label><br>";
        echo "<textarea name='$name' value='$value'/></br>";
    }

    function form_hidden ($name, $value) {
        echo "<input type='hidden' name='$name' value='$value'/>";
    }
?>

