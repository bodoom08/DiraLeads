<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php
// $header_menu = get_menu('main');
// array_sort_by_column($header_menu, 'position_menu', SORT_ASC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title><?php echo isset($title) && html_escape($title) != 'Home' ? html_escape($title) . ' | ' . html_escape(RADIUS) : html_escape(RADIUS); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="utf-8">
    <?php $this->load->view('common/styles'); ?>
</head>

<body>