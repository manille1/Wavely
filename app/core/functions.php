<?php
    function cleanString(string $value): string{
        /*--fonction de nettoyage*/
        return trim(htmlspecialchars($value, ENT_QUOTES)); 
    }
?>