<?php

namespace App\Models;

use CodeIgniter\Model;

class Register_model extends Model
{
    protected $table = 'register';
    protected $allowedFields = ['id', 'full_name','role', 'email', 'mobile_no','alternate_name','alternate_number','flat','floor','address','location','password','agree','active','accesslevel',];

    public function getsinglerow($table, $wherecond)
    {
        $result = $this->db->table($table)->where($wherecond)->get()->getRow();
    
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

    public function checkCredentials($where)
    {
        $user = $this->table('register') // Set the table explicitly
                     ->where($where)
                     ->first();
        if ($user) {
            return $user; // Login successful  
        }
        return null; // Login failed
    }
    public function getalldata($table, $wherecond)
    {
        $result = $this->db->table($table)->where($wherecond)->get()->getResult();
        // print_r($result);die;
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    public function get_single_data($table, $wherecond)
    {
        $result = $this->db->table($table)->where($wherecond)->get()->getRow();

        if ($result) {
            return $result;
        } else {
            return false;
        }
    }
    public function getProductById($productId)
    {
        return $this->db->table('tbl_produact') // Assuming 'products' is your product table
                        ->where('id', $productId)
                        ->get()
                        ->getRow();
    }
    public function getuserById($getuserById)
    {
        return $this->db->table('register') // Assuming 'products' is your product table
                        ->where('id', $getuserById)
                        ->get()
                        ->getRow();
    }
    public function getdeliveryuser($dilevryuser)
    {
        return $this->db->table('register') // Assuming 'products' is your product table
                        ->where('id', $dilevryuser)
                        ->get()
                        ->getRow();
    }
    public function updateAllotPartner($orderId, $partnerId)
    {
        return $this->db->table('tbl_order')
                        ->where('id', $orderId)
                        ->update(['allot_partner' => $partnerId]);
    }
    public function updateOrder($table, $data, $conditions)
    {
        $builder = $this->db->table($table);
        $builder->where($conditions);
        return $builder->update($data);
    }
    public function updatePartner($Id, $partnerId)
    {
        return $this->db->table('register')
                        ->where('id', $Id)
                        ->update(['allot_partner' => $partnerId]);
    }
    public function updatedpayment($orderId, $payment_status)
    {
        return $this->db->table('tbl_order')
                        ->where('id', $orderId)
                        ->update(['payment_status' => $payment_status]);
    }
    public function updateorderstatus($orderId, $order_status,$deliverdby)
    {
        return $this->db->table('tbl_order')
        ->where('id', $orderId)
        ->update(['order_status' => $order_status,'delivererdby'=>$deliverdby]);
    }
    public function updatepaymetbydeliverypartner($orderId, $order_status,$deliverdby)
    {
        return $this->db->table('tbl_order')
        ->where('id', $orderId)
        ->update(['deliveypartnerypaymet' => $order_status,'delivererdby'=>$deliverdby]);
    }
}