<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_preferences extends CI_Model
{
    public function getdata()
    {
        extract($this->input->get());

        $search = array_map('trim', $search);
        $search['value'] = strtolower($search['value']);

        $this->db->start_cache();

        $query['select'] = [
            'a.title',
            'a.for',
            'a.price_min',
            'a.types',
            'a.created_at'
        ];
        $this->db->select("a.title, a.for, CONCAT(a.price_min, ' - ', a.price_max) price_range, a.types, a.created_at");
        $this->db->from('preferences a');

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

    public function getById($id)
    {
        return $this->db
            ->select("a.*, JSON_EXTRACT(a.package, '$.price') as price")
            ->where('a.id', $id)
            ->where('b.user_id', $_SESSION['id'])
            ->from('invoices a')
            ->join('user_packages b', 'a.id = b.invoice_id', 'right')
            ->get()
            ->row();
    }

    function getAllAreas()
    {
        return $this->db->get('areas')->result_array();
    }

    public function save()
    {
        array_walk_recursive($_POST, 'trim');
        extract($this->input->post());

        if ($title) {
            $this->db->insert('preferences', [
                'user_id' => $_SESSION['id'],
                'title' => $title,
                'for' => implode(',', $for),
                'area_ids' => implode(',', $area),
                'types' => implode(',', $types),
                'price_min' => $price_min,
                'price_max' => $price_max
            ]);

            return ['type' => 'success', 'text' => 'Preference Added!'];
        }
        return ['type' => 'error', 'text' => 'Title field is required!'];
    }
}
