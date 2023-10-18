<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Consultation extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // untuk mengecek status login
        checking_session($this->username, $this->role, ['admin']);
    }

    // untuk default
    public function index()
    {
        $data = [
            'assessment' => $this->_get_assessment(),
        ];
        // untuk load view
        $this->template->load('admin', 'Consultation', 'consultation', 'view', $data);
    }

    public function process()
    {
        $post = $this->input->post(NULL, TRUE);

        $data_test = [];
        for ($i = 0; $i < count($post['id_criteria']); $i++) {
            $data_test[$post['id_criteria'][$i]] = $post['nilai'][$i];
        }

        $data = [
            'consultation' => json_encode($data_test),
        ];

        $this->db->trans_start();
        $this->crud->i('tb_consultation', $data);
        $id = $this->db->insert_id();
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $response = ['title' => 'Gagal!', 'text' => 'Gagal Simpan!', 'type' => 'error', 'button' => 'Ok!'];
        } else {
            $response = ['title' => 'Berhasil!', 'text' => 'Berhasil Simpan!', 'type' => 'success', 'button' => 'Ok!', 'id' => $id];
        }

        $this->_response_message($response);

        debug($data_test);
    }

    public function _clasification()
    {
        $clasification = $this->m_classification->get_all()->result();

        $result = [];

        foreach ($clasification as $key => $value) {
            $result[$value->id_classification] = $value->nama;
        }

        return $result;
    }

    public function _criteria_sub()
    {
        $criteria_sub = $this->m_criteria_sub->get_all()->result();

        $result = [];

        foreach ($criteria_sub as $key => $value) {
            $result[$value->id_criteria][$value->nilai] = $value->nama;
        }

        return $result;
    }

    public function results($id)
    {
        $get_consultation = $this->crud->gda('tb_consultation', ['id_consultation' => $id]);

        $data_test = json_decode($get_consultation['consultation'], TRUE);

        $data_training       = $this->_get_datatraining();
        $data_criteria       = $this->m_criteria->get_all()->result();
        $data_classification = $this->m_classification->get_all()->result();

        $a = $this->processCountClassification($data_training);

        $b = $this->processCountCriteriaClassification($data_training, $a);

        $c = $this->processCountCriteriaProbabilitas($a, $b);

        $d = $this->processGetResultProbabilitas($a, $c);

        // debug($data_training, $a, $b, $c, $d);

        $data = [
            'ini'                 => $this,
            'data_training'       => $data_training,
            'criteria'            => $data_criteria,
            'data_test'           => $data_test,
            'data_classification' => $data_classification,
        ];

        // untuk load view
        $this->template->load('admin', 'Hasil Konsultasi', 'consultation', 'result', $data);
    }

    public function _get_assessment()
    {
        $criteria = $this->m_criteria->get_all()->result();
        $result = [];
        foreach ($criteria as $key => $value) {
            $criteria_sub = $this->m_criteria_sub->get_detail($value->id_criteria)->result_array();
            $result[] = [
                'id_criteria'  => $value->id_criteria,
                'nama'         => $value->nama,
                'sub_criteria' => $criteria_sub
            ];
        }
        return $result;
    }

    public function _get_datatraining()
    {
        $datatraining = $this->db->query("SELECT d.id_classification, d.count, c.nama FROM tb_datatraining AS d LEFT JOIN tb_classification AS c ON c.id_classification = d.id_classification GROUP BY d.count, d.id_classification ORDER BY d.count, d.id_classification ASC");
        $result = [];
        foreach ($datatraining->result() as $k_a => $v_a) {
            $datatraining_detail = $this->db->query("SELECT d.id_classification, d.id_criteria, d.count, d.nilai FROM tb_datatraining AS d WHERE d.count = '$v_a->count' AND d.id_classification = '$v_a->id_classification'");
            foreach ($datatraining_detail->result() as $k_b => $v_b) {
                $data[$v_a->id_classification][$v_a->count][$v_b->id_criteria] = [
                    'label' => $this->_criteria_sub()[$v_b->id_criteria][$v_b->nilai],
                    'nilai' => $v_b->nilai
                ];
            }

            $result[] = [
                'classification' => $v_a->id_classification,
                'count'          => $v_a->count,
                'kriteria'       => $data[$v_a->id_classification][$v_a->count],
                'nama'           => $v_a->nama,
            ];
        }
        return $result;
    }

    public function processCountClassification($data_training)
    {
        $result = [];

        foreach ($data_training as $k_d => $v_d) {
            foreach ($this->_clasification() as $k_c => $v_c) {
                if ($k_c == $v_d['classification']) {
                    $result[$v_c][] = 'test';
                }
            }
        }

        return $result;
    }

    public function processCountCriteriaClassification($data_training, $data_class)
    {
        $data_criteria = $this->m_criteria->get_all()->result();

        $result = [];

        foreach ($data_training as $k_d => $v_d) {
            foreach ($data_class as $k_a => $v_a) {
                foreach ($data_criteria as $k_c => $v_c) {
                    if ($v_d['nama'] === $k_a && $v_d['kriteria'][$v_c->id_criteria]['label'] === $this->_criteria_sub()[$v_c->id_criteria][$v_d['kriteria'][$v_c->id_criteria]['nilai']]) {
                        $result[$v_c->id_criteria][$k_a][$this->_criteria_sub()[$v_c->id_criteria][$v_d['kriteria'][$v_c->id_criteria]['nilai']]][] = 'test';
                    }
                }
            }
        }

        return $result;
    }

    public function processCountCriteriaProbabilitas($data_class, $data_count)
    {
        $data_criteria     = $this->m_criteria->get_all()->result();
        $data_criteria_sub = $this->_criteria_sub();

        $result = [];

        foreach ($data_class as $k_a => $v_a) {
            foreach ($data_criteria as $k_c => $v_c) {
                foreach ($data_criteria_sub[$v_c->id_criteria] as $k_d => $v_d) {
                    $hasil_sebelum = (empty($data_count[$v_c->id_criteria][$k_a][$v_d]) ? 0 : count($data_count[$v_c->id_criteria][$k_a][$v_d]));
                    $count_class   = count($v_a);
                    $hitung        = ($hasil_sebelum !== 0 ? ($hasil_sebelum / $count_class) : 0);
                    $hasil         = number_format(round($hitung, 1), 1);

                    $result[$v_c->id_criteria][$k_a][$v_d] = $hasil;
                }
            }
        }

        return $result;
    }

    public function processGetResultProbabilitas($data_class, $data_probabilitas)
    {
        $data_criteria     = $this->m_criteria->get_all()->result();
        $data_criteria_sub = $this->_criteria_sub();

        $result = [];

        foreach ($data_class as $k_a => $v_a) {
            foreach ($data_criteria as $k_c => $v_c) {
                foreach ($data_criteria_sub[$v_c->id_criteria] as $k_d => $v_d) {
                    $result[$k_a][$v_c->id_criteria][$v_d] = $data_probabilitas[$v_c->id_criteria][$k_a][$v_d];
                }
            }
        }

        return $result;
    }
}
