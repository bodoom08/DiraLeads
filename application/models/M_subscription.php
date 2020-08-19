<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_subscription extends CI_Model
{
    public function getThisSubscription()
    {
        $allSubs = $this->db
            ->where('user_id', $_SESSION['id'])
            ->group_start()
            ->where('start_date<=', date('Y-m-d'))
            ->or_where('end_date>=', date('Y-m-d'))
            ->group_end()
            ->get('user_packages')
            ->result_array();
            
        // exit(json_encode($allSubs));
        return $allSubs;
    }

    public function getThisSSubscribePackage($package_id) {
        $lastPackage = $this->db
                ->where('package_id', $package_id)
                ->where('user_id', $_SESSION['id'])
                ->group_start()
                ->where('start_date <=', date('Y-m-d'))
                ->where('end_date >=', date('Y-m-d'))
                ->group_end()
                ->order_by('end_date', 'desc')
                ->limit(1)
                ->get('user_packages')
                ->row();

        return $lastPackage;
    }

    public function getTheUserPackage($record_id) {
        $lastPackage = $this->db
                ->select('package_name, no_of_days, no_of_area, start_date, end_date, price')
                ->where('id', $record_id)                
                ->get('user_packages')
                ->row();

        return $lastPackage;
    }

    public function getLastPackageById($package_id) {
        $lastPackage = $this->db
                ->where('package_id', $package_id)
                ->where('user_id', $_SESSION['id'])
                ->order_by('id', 'desc')
                ->limit(1)
                ->get('user_packages')
                ->row();
        return $lastPackage;
    }

    public function getdata()
    {
        extract($this->input->get());

        $search = array_map('trim', $search);
        $search['value'] = strtolower($search['value']);

        $this->db->start_cache();

        $query['select'] = [
            'a.id',
            'a.package_id',
            'a.package_name',
            'a.validity',
            'a.no_of_area',
            'a.price',
            'a.start_date',
            'a.end_date',
            'a.user_id',
        ];
        $this->db->select("a.id, a.package_id, a.package_name, a.validity, a.no_of_area, a.price, a.start_date, a.end_date")
                        ->where('a.user_id', $_SESSION['id'])
                        ->group_start()
                        ->where('a.start_date<=', date('Y-m-d'))
                        ->or_where('a.end_date>=', date('Y-m-d'))
                        ->group_end();
        $this->db->from('user_packages a');

        $query['recordsTotal'] = $this->db->count_all_results();

        if (isset($search['value'])) {
            $this->db->group_start();
            foreach ($query['select'] as $s) {
                $this->db->or_like('LOWER(' . $s . ')', $search['value']);
            }
            $this->db->group_end();
        }

        $this->db->stop_cache();

        $this->db->order_by('a.id', 'desc');

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

    // public function getAllPackages()
    // {
    //     return $this->db->where('status', 'active')->get('packages')->result_array();
    // }
}
