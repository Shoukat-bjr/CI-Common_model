<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Common_model extends CI_Model {

    /*
    |--------------------------------------------------------------------------
    | get_data
    |--------------------------------------------------------------------------
    |
    | pass an array as an argument. the sytax of array is as follow
    | array('column'=>'col1,col2,col3,...', 'table'=>'table1,table2,table3,...', 'limit'=>'5', 'offset'=>'0', 'where'=>'col=1', 'single'=>'single');
    | 
    |
    */
    public function get_data($array) {
        // if set column 
        if(isset($array['column'])) {
            $this->db->select($array['column']);
        }
        else {
            $this->db->select();
        }

        $this->db->from($array['table']);

        // if set limit and offset
        if(isset($array['limit']) && isset($array['offset'])) {
            $this->db->limit($array['limit'], $array['offset']);
        }

        // if set where
        if(isset($array['where'])) {
            $this->db->where($array['where']);
        }
        // get query
        $query = $this->db->get();

        // if set single
        if (isset($array['single'])) {
            return $query->row();
        }

        // if set row_array
        if(isset($array['row_array'])) {
            return $query->row_array();
        }

        // return 
        return $query->result();
    }

    // Add new data to database
    public function add_data($table, $data, $last_id = "") {
        $result = $this->db->insert($table, $data);

        if($last_id) {
            $last_id = $this->db->insert_id();
            return $multi_id;
        }
            
        if($result) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    // Update
    public function update_data($table, $data, $where) {
        $result = $this->db->where($where)->update($table, $data);
        if($result) {
            return TRUE;
        }
        else {
            return FALSE;
        }
    }

    // Delete
    public function delete_data($table, $where) {
        $result = $this->db->where($where)->delete($table);
        if($result){
            return TRUE;
        }
        else {
            return FALSE;
        }
        
    }

    // Count numbe of rows of a table
    public function num_rows($table, $where=NULL)
    {
        $this->db
             ->select()
             ->from($table);
        if($where) {
            $this->db->where($where);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    // joining of tables
    public function join_table($table1, $table2, $table1_id, $table2_id, $where=NULL, $single=NULL) {
        $this->db->select('*')
                 ->from($table1)
                 ->join($table2, "$table1.$table1_id = $table2.$table2_id");
        if($where != NULL) {
            $this->db->where($where);
        }
        $query = $this->db->get();
        if($single != NULL) {
            return $query->row();
        }
        return $query->result();

    }
    
    public function sum_where($table, $column, $where = NULL) {
        $this->db->select_sum($column);
        if($where) {
            $this->db->where($where);
        }
        $query = $this->db->get($table)->row();
        return $query->$column;
    }
    
}

/* End of file ModelName.php */
