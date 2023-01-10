<?php 
    function redirect($path) {
        header("Location: {$path}");
        exit;
    }

    function debug($value) {
        echo "<pre>";
        print_r($value);
        echo "</pre>";
    }

    function generateErrorMessageForEmptyField($field, $fieldName) {
        if (empty($field)){

            $errorMessage = '<li><strong>'. $fieldName .'</strong> är obligatorisk. </li>';
            return $errorMessage;
        } 
    }
?>