<?php defined('BASEPATH') or exit('No direct script access allowed');
function get_menu($menuposition)
{
    $ci = &get_instance();
    $ci->load->database();

    $ci->db->select('b.*');
    $ci->db->where('a.position="' . $menuposition . '"', null, false);
    $ci->db->where('a.id=b.menu_position_id', null, false);
    $ci->db->where('b.status=1', null, false);
    $ci->db->from('menupositions a,menus b');
    $query = $ci->db->get();

    $menus = $query->result_array();

    array_sort_by_column($menus, 'position_menu', SORT_ASC);

    return $menus;
}
function array_sort_by_column(&$arr, $col, $dir = SORT_DESC)
{
    $sort_col = array();
    foreach ($arr as $key => $row) {
        $sort_col[$key] = $row[$col];
    }
    array_multisort($sort_col, $dir, $arr);
}
function gen_otp() {
    return substr(str_shuffle('123456789011'), 3, 6);
}
