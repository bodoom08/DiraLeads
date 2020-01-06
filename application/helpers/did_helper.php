<?php

function allocate_did($property_id, $vn_id, $type = 'Auto Allocation', $notes = null) {
    $ci = &get_instance();
    $ci->load->database();
    
    $ci->db->where('id', $property_id)->update('properties', [
        'vn_id' => $vn_id
    ]);

    $ci->db->insert('did_log', [
        'property_id' => $property_id,
        'vn_id' => $vn_id,
        'type' => $type,
        'notes' => $notes,
        'user_id' => $_SESSION['id']
    ]);
}