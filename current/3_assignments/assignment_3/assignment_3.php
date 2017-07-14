<?php
/**
 * Assignment #3
 * Use the same code from assignment #2
 *
 * Create a web page which fetches the data without a refresh/pageload
 * The page should initially show a button with the text 'Fetch all payments'
 * - If you click on it, you should fetch the data in a JSON format. Result should look like the image below (see imgur.com URL)
 *
 * Minimal requirements:
 * - Use jQuery
 * - The fetched data should be in JSON format
 * - Loop through the data and show the output in a HTML table (so JSON shouldn't return HTML, but pure JSON)
 *
 * You're allowed to use other frontend/JS frameworks (i.e. Bootstrap, jQuery plugins)
 * 
 */

if(isset($_SERVER['HTTP_X_REQUESTED_WITH']))
    require '../assignment_2/assignment_2_extra.php';
else
    require 'html/view.html';
