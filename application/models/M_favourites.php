<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_favourites extends CI_Model
{
    public function getdata()
    {
        extract($this->input->get());

        $search = array_map('trim', $search);
        $search['value'] = strtolower($search['value']);

        $this->db->start_cache();

        $query['select'] = [
            'b.user_id',
            'c.title'
        ];
        $this->db->select("c.title, b.for, b.price, b.type, b.created_at");
        $this->db->from('favorites a');
        $this->db->join('properties b', 'a.property_id = b.id', 'INNER');
        $this->db->join('areas c', 'c.id = b.area_id', 'INNER');
        $this->db->where('a.user_id', $_SESSION['id']);
        // print_r($_SESSION);
        // die();

        $query['recordsTotal'] = $this->db->count_all_results();

        if (isset($search['value'])) {
            $this->db->group_start();
            foreach ($query['select'] as $s) {
                $this->db->or_like('LOWER(' . $s . ')', $search['value']);
            }
            $this->db->group_end();
        }

        $this->db->stop_cache();

        $this->db->order_by('a.created_at', 'desc');

        if ($length > 0) {
            $this->db->limit($length, $start);
        }
        $query['data'] = $this->db->get()->result_array();
        $query['draw'] = $draw;
        $query['recordsFiltered'] = $this->db->count_all_results();
        $this->db->flush_cache();
        unset($query['select']);
        return $query;
    }

}
