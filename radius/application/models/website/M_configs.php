<?php
defined('BASEPATH') or exit('No direct script access allowed');
class M_configs extends CI_Model
{
    public function getAll()
    {
        $configs = $this->db->get('website_configs')->result_array();

        return array_column($configs, 'value', 'key');
    }

    public function update()
    {
        $title = $this->input->post('title');
        $footer_desc = $this->input->post('footer_desc');

        if ($title) {
            $this->db
                ->where('key', 'title')
                ->update('website_configs', [
                    'value' => $title,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
        }

        if ($footer_desc) {
            $this->db
                ->where('key', 'footer_desc')
                ->update('website_configs', [
                    'value' => $footer_desc,
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
        }

        if ($_FILES['userfile']) {
            $this->load->library('upload');
            
            $path = FCPATH . '../uploads';
            $config = array();
            $config['upload_path'] = $path;
            $config['allowed_types'] = 'jpg|jpeg|png|webp|svg';
            $config['max_size'] = '0';
            $config['overwrite'] = true;

            $this->upload->initialize($config);

            if (!$this->upload->do_upload()) {
                $errors = $this->upload->display_errors();
                return ['type' => 'error', 'text' => $errors];
            } else {
                $upload_data = $this->upload->data();

                $this->db
                    ->where('key', 'logo')
                    ->update('website_configs', [
                        'value' => $upload_data['file_name'],
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
            }
        }

        return ['type' => 'success', 'text' => 'Website config updated!'];
    }
}
