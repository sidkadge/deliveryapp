<?php

namespace App\Controllers;
use App\Models\Register_model;

class Home extends BaseController
{
    public function index(): string
    {
        return view('home');
    }
    public function login()
    {
        return view('login');
    }
    public function contactus()
    {
        return view('contact');
    }
    public function terms_and_conditions()
    {
        return view('terms_and_conditions');
    }
    public function shipping_policy()
    {
        return view('shipping_policy');
    }
    public function privacy_policy()
    {
        return view('privacy_policy');
    }
    public function about_us()
    {
        return view('about_us');
    }
    public function getregister()
   {
    $model = new Register_model();
    
    $wherecond = array('is_active' => 'Y',);

    $zones = $model->getalldata('zone', $wherecond);
    // print_r($data['zons']);die;
    return view('register',['zones' => $zones]);
   }
   public function getSocietiesByZone()
   {
  
    $postData = $this->request->getPost();
    $zone_id = $postData['zone_id']; 
    $model = new Register_model();
    $wherecond = array('zone_id' => $zone_id, 'is_active' => 'Y');
    $societies = $model->getalldata('society', $wherecond);
    echo json_encode($societies);
   }
   public function getBuildingsBySociety()
{
    $postData = $this->request->getPost();
    $zone_id = $postData['zone_id'];
    $society_id = $postData['society_id'];

    $model = new Register_model();
    
    $wherecond = array(
        'is_active' => 'Y',
        'zone_id' => $zone_id,
        'society_id' => $society_id
    );

    $buildings = $model->getalldata('building', $wherecond);
    echo json_encode($buildings);
}
   
    public function Customerlist()
    {
        $session = \Config\Services::session();
        if (!$session->has('id')) {
            return redirect()->to('/');
        }
        $model = new Register_model();
    
        $wherecond = array('role' => 'customer','allot_partner'=> null);
    
        $data['customer'] = $model->getalldata('register', $wherecond);

        $db = \Config\Database::connect();
        $builder = $db->table('register');
        $builder->like('accesslevel', 'yourorder');
        $builder->where(['role' => 'Admin', 'active' => 'Y']);
        $query = $builder->get();
        $data['userdata'] = $query->getResult();
    //    echo '<pre>'; print_r($data['customer']);die;
        return view('Admin/Customerlist',$data);
    }
    public function register()
    {
        $db = \Config\Database::connect();
        $postData = $this->request->getPost();
        $zoneId = $postData['Zone'];
    
        // Handle Society
        if ($postData['Societyname'] === 'Other') {
            $societyName = $postData['OtherSocietyname'];
            $societyData = [
                'Societyname' => $societyName,
                'zone_id' => $zoneId
            ];
            $db->table('society')->insert($societyData);
            $societyId = $db->insertID();
        } else {
            $societyId = $postData['Societyname'];
        }
        if ($postData['Buildingname'] === 'Other') {
            $buildingName = $postData['OtherBuildingname'];
            $buildingData = [
                'Buildingname' => $buildingName,
                'zone_id' => $zoneId,
                'society_id' => $societyId
            ];
            $db->table('building')->insert($buildingData);
            $buildingId = $db->insertID();
        } else {
            $buildingId = $postData['Buildingname'];
        }
        $registerData = [
            'full_name' => $postData['full_name'],
            'email' => $postData['email'],
            'mobile_no' => $postData['mobile_no'],
            'role' => 'customer',
            'location' => $postData['location'],
            'alternate_name' => $postData['Alternate_name'],
            'alternate_number' => $postData['Alternatenumber'],
            'flat' => $postData['Flat'],
            'floor' => $postData['Floor'],
            'address' => $postData['Address'],
            'password' => $postData['password'],
            'agree' => $postData['agree'],
            'Zone' => $zoneId,
            'Societyname' => $societyId,
            'Buildingname' => $buildingId
        ];
        $db->table('register')->insert($registerData);
        return redirect()->to('login');
    }
    
    public function addCoustmersbyadmin()
    {  
        $db = \Config\Database::connect();
        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'mobile_no' => $this->request->getPost('mobile_no'),
            'role' =>'customer',
            'location'=>$this->request->getPost('location'),
            'alternate_name' => $this->request->getPost('Alternate_name'),
            'alternate_number' => $this->request->getPost('Alternatenumber'),
            'flat' => $this->request->getPost('Flat'),
            'floor' => $this->request->getPost('Floor'),
            'address' => $this->request->getPost('Address'),
            'password' =>$this->request->getPost('password'),
            'agree'=>'on',
        ];
        $db->table('register')->insert($data);
        return redirect()->to('addCoustmer'); 
    }
    public function dologin()
    {
    $model = new Register_model();
    $session = \CodeIgniter\Config\Services::session();
    $mobile_no = $this->request->getPost('mobile_no');
    $password = $this->request->getPost('password');  
    $user = $model->checkCredentials(['mobile_no' => $mobile_no]);
    if ($user) {
        if ($password === $user['password']) {  
            $userData = [
                'id' => $user['id'],
                'full_name' => $user['full_name'],
                'email' => $user['email'],
                'mobile_no' => $user['mobile_no'],
                'role' => $user['role'],
                'accesslevel'=>$user['accesslevel'],
            
            ];
            $session->set($userData);
            if ($user['role'] === 'customer') {
                return redirect()->to(base_url('product'));
            } 
                elseif ($user['role'] === 'Admin' && $userData['accesslevel']==='yourorder') {
                    return redirect()->to(base_url('yourorder'));
            } 
            elseif ($user['role'] === 'Admin') {
                return redirect()->to(('AdminDashboard'));
            } else {
                session()->setFlashdata('error', 'Invalid credentials');
                return redirect()->to('login'); 
            }
        } else {
            session()->setFlashdata('error', 'Invalid password');
            return redirect()->to('login');
        }

    } else {
        session()->setFlashdata('error', 'User not found');
        return redirect()->to('login');
    }
}
public function coustmordashboard()
{
    echo view('customer/coustmordashboard');

}
// public function Subscriptionsbook()
// {
//     print_r($_POST);die;
//     $session = \Config\Services::session();
//     $id = $session->get('id');
//     $request = \Config\Services::request();
//     $model = new Register_model();
//     $wherecond = array('id' =>$id,);
//     $partnerid = $model->getalldata('register', $wherecond);
//     $allotPartnerId = null;
//     if (!empty($partnerid) && is_array( $partnerid)) {
//         $user =  $partnerid[0];
//         if (isset($user->allot_partner)) {
//             $allotPartnerId = $user->allot_partner;
//         }
//     }
//     $product = $request->getPost('productDropdown');
//     $pricePerUnit =$request->getPost('pricePerUnit');
//     $quantity = $request->getPost('quantityInput');
//     $deliveryTime = $request->getPost('deliveryTime');
//     $paymentMode = $request->getPost('paymentMode');
//     $price = $request->getPost('price');
//     $unit = $request->getPost('unit');
//     $transactionIdInput = $request->getPost('transactionIdInput');
//     $selectedDates = explode(',', $request->getPost('selectedDates'));
//     $validation = \Config\Services::validation();
//     $validation->setRules([
//         'productDropdown' => 'required',
//         'quantityInput' => 'required|integer|greater_than[0]',
//         'deliveryTime' => 'required',
//         'paymentMode' => 'required',
//         'transactionIdInput' => 'permit_empty',
//         'screenshotInput' => 'permit_empty|uploaded[screenshotInput]|max_size[screenshotInput,1024]|ext_in[screenshotInput,jpg,jpeg,png,pdf]'
//     ]);
//     foreach ($selectedDates as $date) {
//         $data = [
//             'product' => $product,
//             'quantity' => $quantity,
//             'delivery_date' => $date,
//             'delivery_time' => $deliveryTime,
//             'payment_mode' => $paymentMode,
//             'coustomerid' => $id,
//             'allot_partner'=>$allotPartnerId,
//             'unit' => $unit,
//             'price' => $pricePerUnit * $quantity,
//             'transaction_id' => $transactionIdInput,
//         ];
//         $file = $request->getFile('screenshotInput');
//         if ($file->isValid() && !$file->hasMoved()) {
//             $newName = $file->getRandomName();
//             $file->move(ROOTPATH . 'public/uploads/paymentscreenshot', $newName);
//             $data['payment_screenshot'] = $newName;
//         }
//         if (!empty($transactionIdInput) || !empty($data['payment_screenshot'])) {
//             $data['payment_status'] = 'paid';
//             $data['deliveypartnerypaymet'] = 'R'; 
//         } else {
//             $data['payment_status'] = 'unpaid';
//         }

//         $db = \Config\Database::connect();
//         $db->table('tbl_order')->insert($data);
//     }

//     session()->setFlashdata('success', 'Order placed successfully!');
//     return redirect()->to('ordehistory');
// }
public function Subscriptionsbook()
{
    $session = \Config\Services::session();
    $id = $session->get('id');
    $request = \Config\Services::request();
    $model = new Register_model();
    $wherecond = ['id' => $id];
    $partnerid = $model->getalldata('register', $wherecond);
    $allotPartnerId = null;

    if (!empty($partnerid) && is_array($partnerid)) {
        $user = $partnerid[0];
        if (isset($user->allot_partner)) {
            $allotPartnerId = $user->allot_partner;
        }
    }

    $product = $request->getPost('productDropdown');
    $pricePerUnit = $request->getPost('pricePerUnit');
    $quantity = $request->getPost('quantityInput');
    $deliveryTime = $request->getPost('deliveryTime');
    $paymentMode = $request->getPost('paymentMode');
    $price = $request->getPost('price');
    $unit = $request->getPost('unit');
    $transactionIdInput = $request->getPost('paymentId'); // Changed to match Razorpay response
    $selectedDates = explode(',', $request->getPost('selectedDates'));

    $validation = \Config\Services::validation();
    $validation->setRules([
        'productDropdown' => 'required',
        'quantityInput' => 'required|integer|greater_than[0]',
        'deliveryTime' => 'required',
        'paymentMode' => 'required',
        'transactionIdInput' => 'permit_empty',
    ]);

    if (!$validation->withRequest($request)->run()) {
        return $this->response->setJSON([
            'success' => false,
            'errors' => $validation->getErrors()
        ]);
    }

    $db = \Config\Database::connect();
    $success = true;

    foreach ($selectedDates as $date) {
        $data = [
            'product' => $product,
            'quantity' => $quantity,
            'delivery_date' => $date,
            'delivery_time' => $deliveryTime,
            'payment_mode' => $paymentMode,
            'coustomerid' => $id,
            'allot_partner' => $allotPartnerId,
            'unit' => $unit,
            'price' => $pricePerUnit * $quantity,
            'transaction_id' => $transactionIdInput,
        ];

        // Determine payment status based on the presence of the transaction ID
        if (!empty($transactionIdInput)) {
            $data['payment_status'] = 'paid';
            $data['deliveypartnerypaymet'] = 'R'; // Assuming 'R' stands for Razorpay
        } else {
            $data['payment_status'] = 'unpaid';
        }

        if (!$db->table('tbl_order')->insert($data)) {
            $success = false;
            break;
        }
    }

    if ($paymentMode === 'cash') {
        // Return a response indicating the need for redirection
        return redirect()->to('ordehistory');
    } else {
        // Handle other payment modes (e.g., UPI) if needed
        return $this->response->setJSON([
            'success' => $success
        ]);
    }
}

public function Subscriptions()
{

    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to('/');
    }
    $model = new Register_model();
    $wherecond = array('is_deleted' => 'N');
    $data['product'] = $model->getalldata('tbl_produact', $wherecond);
    echo view('customer/Subscriptions',$data);
}
public function ordehistory()
{
    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to('/');
    }
    $id = $session->get('id');
    $model = new Register_model();
    $wherecond = array('coustomerid' => $id, 'is_deleted' => 'N');
    $orders = $model->getalldata('tbl_order', $wherecond);
    $data['order'] = [];
    if (!is_array($orders)) {
        $orders = [];
    }
    foreach ($orders as $order) {
        $product = $model->getProductById($order->product);
        $order->product_name = $product->productname; 
        $data['order'][] = $order;
    }
    echo view('customer/ordehistory', $data);
}
public function order()
{
    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to('/');
    }
    $model = new Register_model();
    $wherecond = array('is_deleted' => 'N');
    $data['product'] = $model->getalldata('tbl_produact', $wherecond);
    echo view('customer/order',$data);
}

public function add_to_card($id)
{
    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to('/');
    }

    $model = new Register_model();
    $wherecond = array(
        'is_deleted' => 'N'
    );
    $data['product'] = $model->getalldata('tbl_produact', $wherecond);
    $wherecond = array(
        'id' => $id,
        'is_deleted' => 'N'
    );

    $data['sproduct'] = $model->getsinglerow('tbl_produact', $wherecond);
    // print_r($data['sproduct']);die;
    echo view('customer/order', $data);
}


public function add_to_cardfors($id)
{
    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to('/');
    }
    $model = new Register_model();
    $wherecond = array(
        'is_deleted' => 'N'
    );
    $data['product'] = $model->getalldata('tbl_produact', $wherecond);

    $wherecond = array(
        'id' => $id,
        'is_deleted' => 'N'
    );

    $data['sproduct'] = $model->getsinglerow('tbl_produact', $wherecond);
echo view('customer/Subscriptions',$data);
}

public function AdminDashboard()
{
    $model = new Register_model();
    $wherecond = array('order_status' => 'B');
    $orders = $model->getalldata('tbl_order', $wherecond);
    if (!is_array($orders)) {
        $orders = [];
    }
    $data['order'] = [];
    foreach ($orders as $order) {
        $product = $model->getProductById($order->product);
        $order->product_name = $product->productname; 
        $user = $model->getuserById($order->coustomerid);
        $order->user_name = $user->full_name; 
        $data['order'][] = $order;
    }
    return view('Admin/AdminDashboard', $data);
}

public function addCoustmer()
{
    return view('Admin/addCoustmer');
}
public function Receivedorder()
{

    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to('/');
    }
    $model = new Register_model();
    $wherecond = array('order_status' => 'B', 'is_deleted' => 'N');
    $orders = $model->getalldata('tbl_order', $wherecond);
    $data['order'] = [];
    foreach ($orders as $order) {
        $product = $model->getProductById($order->product);
        $order->product_name = $product->productname; 
        $user = $model->getuserById($order->coustomerid);
        $order->user_name = $user->full_name; 
        $data['order'][] = $order;
    }
    return view('Admin/receivedorder',$data);
}
// public function orderpayment()
// {
//     $session = \Config\Services::session();
//     if (!$session->has('id')) {
//         return redirect()->to('/');
//     }

//     $model = new Register_model();
//     $db = \Config\Database::connect();
//     $builder = $db->table('tbl_order');

//     // Use the query builder to add complex conditions
//     $builder->where('order_status IS NOT NULL', null, false);
//     $builder->where('is_deleted', 'N');
    
//     // Fetch the results
//     $orders = $builder->get()->getResult();

//     if (!is_array($orders)) {
//         $orders = [];
//     }

//     $data['order'] = [];
//     foreach ($orders as $order) {
//         $product = $model->getProductById($order->product);
//         $order->product_name = $product->productname;
//         $user = $model->getuserById($order->coustomerid);
//         $order->user_name = $user->full_name;
//         $data['order'][] = $order;
//     }
// echo '<pre>';print_r($data['order']);die;
//     return view('Admin/orderpayment', $data);
// }
public function orderpayment()
{
    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to('/');
    }

    $model = new Register_model();
    $db = \Config\Database::connect();
    $builder = $db->table('tbl_order');

    // Use the query builder to add complex conditions
    $builder->where('order_status IS NOT NULL', null, false);
    $builder->where('is_deleted', 'N');
    
    // Fetch the results
    $orders = $builder->get()->getResult();

    if (!is_array($orders)) {
        $orders = [];
    }

    $data['order'] = [];
    foreach ($orders as $order) {
        $product = $model->getProductById($order->product);
        $order->product_name = $product->productname;
        $user = $model->getuserById($order->coustomerid);
        $order->user_name = $user->full_name;    
        if (!empty($order->payment_screenshot)) {
            $order->payment_screenshot_path = base_url('public/uploads/paymentscreenshot/' . $order->payment_screenshot);
        } else {
            $order->payment_screenshot_path = null; 
        }  
        $data['order'][] = $order;
    }
    return view('Admin/orderpayment', $data);
}

public function allotdelivery()
{
    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to('/');
    }
    
    $model = new Register_model();
    $wherecond = ['order_status' => 'B', 'is_deleted' => 'N'];
    $orders = $model->getalldata('tbl_order', $wherecond);
    
    $data['order'] = [];
    foreach ($orders as $order) {
        $product = $model->getProductById($order->product);
        $order->product_name = $product->productname; 
        $user = $model->getuserById($order->coustomerid);
        $order->user_name = $user->full_name;
        if (!empty($order->allot_partner)) {
            $partner = $model->getuserById($order->allot_partner);
            $order->partner_name = $partner->full_name;
        } else {
            $order->partner_name = null;
        }
        
        $data['order'][] = $order;
    }
    $db = \Config\Database::connect();
    $builder = $db->table('register');
    $builder->like('accesslevel', 'yourorder');
    $builder->where(['role' => 'Admin', 'active' => 'Y']);
    $query = $builder->get();
    $data['userdata'] = $query->getResult();
    
    return view('Admin/allotdelivery', $data);
}

public function profile()
{ 
    $session = \Config\Services::session();
    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to('/');
    }
    $id = $session->get('id');
    $model = new Register_model();

  
    $wherecond1 = [
        'id' => $id,
    ];
    $customerData = $model->getsinglerow('register', $wherecond1);
  echo view('customer/profile', ['customerData' => $customerData]);
}
public function Updateprofile()
{
    $session = \Config\Services::session();
    $id = $session->get('id');
    $model = new Register_model();
    $data = [
        'full_name' => $this->request->getPost('full_name'),
        'email' => $this->request->getPost('email'),
        'mobile_no' => $this->request->getPost('mobile_no'),
        'alternate_name' => $this->request->getPost('alternate_name'),
        'alternate_number' => $this->request->getPost('alternate_number'),
        'flat' => $this->request->getPost('flat'),
        'floor' => $this->request->getPost('floor'),
        'address' => $this->request->getPost('address'),
        'location' => $this->request->getPost('location'),
        'password' => $this->request->getPost('password')
    ];
    if ($model->update($id, $data)) {
        return $this->response->setJSON(['success' => true]);
    } else {
        return $this->response->setJSON(['success' => false]);
    }
}
public function addproduct()
{
    $model = new Register_model();
    $uri = service('uri');
    $id = $uri->getSegment(2);
    $wherecond = array('is_deleted' => 'N', 'id' => $id);
    $data['single_data'] = $model->get_single_data('tbl_produact', $wherecond);
    echo view('Admin/Addproduct', $data);
}
// public function add_product()
// {
//     // print_r($_POST);die;
//     $productname = $this->request->getPost('productname');
//     $price=$this->request->getPost('price');
//     $Size=$this->request->getPost('Size');
//     $unit=$this->request->getPost('unit');
//     $brand=$this->request->getPost('brand');
//     $data = [
//         'productname' => $productname,
//         'price'=>$price,
//         'Size'=>$Size,
//         'unit'=>$unit,
//          'brand'=>$brand,
//     ];
//     $db = \Config\Database::connect();
//     $tbl_produact = $db->table('tbl_produact');
//     $existingTask = $tbl_produact->where('productname', $productname)->get()->getFirstRow();
//     if ($existingTask && ($this->request->getVar('id') == "" || $existingTask->id != $this->request->getVar('id'))) {
//         session()->setFlashdata('success', 'Task name already exists.');
//         return redirect()->to('productlist');
//     }

//     if ($this->request->getVar('id') == "") {
//         $tbl_produact->insert($data);
//         session()->setFlashdata('success', 'Menu added successfully.');
//     } else {
//         $tbl_produact->where('id', $this->request->getVar('id'))->update($data);
//         session()->setFlashdata('success', 'Menu updated successfully.');
//     }

//     return redirect()->to('produactlist');
// }
public function add_product()
{
    $productname = $this->request->getPost('productname');
    $price = $this->request->getPost('price');
    $Size = $this->request->getPost('Size');
    $unit = $this->request->getPost('unit');
    $brand = $this->request->getPost('brand');
    $data = [
        'productname' => $productname,
        'price' => $price,
        'Size' => $Size,
        'unit' => $unit,
        'brand' => $brand,
    ];
    $imageFile = $this->request->getFile('image');
    if ($imageFile && $imageFile->isValid() && !$imageFile->hasMoved()) {
        $validationRule = [
            'uploaded[image]',
            'mime_in[image,image/jpg,image/jpeg,image/png,image/gif]',
            'max_size[image,2048]',  // Max size 2MB
        ];
        
        if ($this->validate(['image' => $validationRule])) {
            $newImageName = $imageFile->getRandomName();
            $imageFile->move('public/Imges', $newImageName);        
            $data['image'] = $newImageName;
        } else {
            session()->setFlashdata('error', 'Image upload failed: ' . implode(', ', $this->validator->getErrors()));
            return redirect()->to('productlist');
        }
    }
    $db = \Config\Database::connect();
    $tbl_produact = $db->table('tbl_produact');
    $existingProduct = $tbl_produact->where('productname', $productname)->get()->getFirstRow();
    if ($existingProduct && ($this->request->getVar('id') == "" || $existingProduct->id != $this->request->getVar('id'))) {
        session()->setFlashdata('error', 'Product name already exists.');
        return redirect()->to('productlist');
    }
    if ($this->request->getVar('id') == "") {
        $tbl_produact->insert($data);
        session()->setFlashdata('success', 'Product added successfully.');
    } else {
        $tbl_produact->where('id', $this->request->getVar('id'))->update($data);
        session()->setFlashdata('success', 'Product updated successfully.');
    }
    return redirect()->to('productlist');
}

public function produact_list()
{
    $model = new Register_model();

    $wherecond = array('is_deleted' => 'N');

    $data['menu_data'] = $model->getalldata('tbl_produact', $wherecond);
    echo view('Admin/productlist',$data);
}
public function deleteproduct()
{
    $ab_id = $this->request->getPost('id');
    $table = $this->request->getPost('table_name');
    $data = ['is_deleted' => 'Y'];
    $db = \Config\Database::connect();
    $update_data = $db->table($table)->where('id', $ab_id); 
    $update_data->update($data);
    session()->setFlashdata('success', 'Data deleted successfully.');
    return redirect()->to('produactlist');
}
public function adduser()
{
    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to('/');
    }
    $model = new Register_model();
    $uri = service('uri');
    $id = $uri->getSegment(2);
    $wherecond = array('active' => 'Y', 'id' => $id);
    $data['single_data'] = $model->get_single_data('register', $wherecond);
    $wherecond = array('is_deleted' => 'N');
    $data['menu_data'] = $model->getalldata('tbl_menu', $wherecond);
    echo view('Admin/adduser', $data);
}

public function userlist()
{
    $model = new Register_model();
    $wherecond = array('role'=>'Admin','active' => 'Y');
    $data['menu_data'] = $model->getalldata('register', $wherecond);
    echo view('Admin/userlist',$data);
}

public function coustmerlisting()
{
    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to('/');
    }
   $db = \Config\Database::connect();
    $model = new Register_model();
    $wherecond = array('role' => 'customer','active' => 'Y');
    $data['coustomer'] = $model->getalldata('register', $wherecond);
    echo view('Admin/coustmerreport',$data);
}

public function addstaff()
{
    $model = new Register_model();
    $db = \Config\Database::connect();
    $access_level = $this->request->getPost('accesslevel');
    if (!is_array($access_level)) {
        $access_level = [];
    }
    $data = [
        'full_name' => $this->request->getPost('full_name'),
        'email' => $this->request->getPost('email'),
        'role'=>'Admin',
        'mobile_no' => $this->request->getPost('mobile_no'),
        'password' => $this->request->getPost('password'),
        'accesslevel' => implode(',', $access_level),
    ];
    $db = \Config\Database::Connect();
    if ($this->request->getVar('id') ==     "") {
        $add_data = $db->table('register');
        $add_data->insert($data);
        session()->setFlashdata('success', 'Data added successfully.');
    } else {
        $update_data = $db->table('register')->where('id', $this->request->getVar('id'));
        $update_data->update($data);
        session()->setFlashdata('success', 'Data updated successfully.');
    }
    return redirect()->to('userlist');
}
public function addmenu()
{
    echo view('Admin/addmenu');
}
public function addzones()
{
    echo view('Admin/addzone');
}
public function addzone()
{
    // print_r($_POST);die;
    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to('/');
    }
   $db = \Config\Database::connect();
   $data = [
       'zone' => $this->request->getPost('zone'),
   ];

   $db->table('zone')->insert($data);
   return redirect()->to('addzones');
}
public function setmenu()
{
    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to('/');
    }
   $db = \Config\Database::connect();
   $data = [
       'menu_name' => $this->request->getPost('menu_name'),
       'url_location' => $this->request->getPost('url_location'),
   ];

   $db->table('tbl_menu')->insert($data);
   return redirect()->to('addmenu');
}
// public function orderbook() {
//     print_r($_POST);die;
//     $session = \Config\Services::session();
//     $id = $session->get('id');
//     $model = new Register_model();
//     $wherecond = array('id' =>$id,);
//     $partnerid = $model->getalldata('register', $wherecond);
//     $allotPartnerId = null;
//     if (!empty($partnerid) && is_array( $partnerid)) {
//         $user =  $partnerid[0];
//         if (isset($user->allot_partner)) {
//             $allotPartnerId = $user->allot_partner;
//         }
//     }
//     $request = \Config\Services::request();
//     $product = $request->getPost('productDropdown');
//     $quantity = $request->getPost('quantityInput');
//     $deliveryDate = $request->getPost('deliveryDate');
//     $deliveryTime = $request->getPost('deliveryTime');
//     $paymentMode = $request->getPost('paymentMode');
//     $price = $request->getPost('price');
//     $unit = $request->getPost('unit');
//     $transactionIdInput = $request->getPost('transactionIdInput');
//     $validation = \Config\Services::validation();
//     $validation->setRules([
//         'productDropdown' => 'required',
//         'quantityInput' => 'required|integer|greater_than[0]',
//         'deliveryDate' => 'required|valid_date',
//         'deliveryTime' => 'required',
//         'paymentMode' => 'required',
//         'transactionIdInput' => 'permit_empty',
//         'screenshotInput' => 'permit_empty|uploaded[screenshotInput]|max_size[screenshotInput,1024]|ext_in[screenshotInput,jpg,jpeg,png,pdf]' // updated file types to include images
//     ]);
//     if (!$validation->withRequest($request)->run()) {
//         return redirect()->back()->withInput()->with('errors', $validation->getErrors());
//     }
//     $data = [
//         'product' => $product,
//         'quantity' => $quantity,
//         'delivery_date' => $deliveryDate,
//         'delivery_time' => $deliveryTime,
//         'payment_mode' => $paymentMode,
//         'coustomerid'=>$id,
//         'allot_partner'=>$allotPartnerId,
//         'unit' => $unit,
//         'price' => $price,
//         'transaction_id' => $transactionIdInput,
//     ];
//     $file = $request->getFile('screenshotInput');
//     if ($file->isValid() && !$file->hasMoved()) {
//         $newName = $file->getRandomName();
//         $file->move(ROOTPATH . 'public/uploads/paymentscreenshot', $newName);
//         $data['payment_screenshot'] = $newName;
//     }
//     if (!empty($transactionIdInput) || !empty($data['payment_screenshot'])) {
//         $data['payment_status'] = 'paid';
//         $data['deliveypartnerypaymet'] = 'R';
       
//     } else {
//         $data['payment_status'] = 'unpaid';
//     }
//     $db = \Config\Database::connect();
//     $db->table('tbl_order')->insert($data);

//     session()->setFlashdata('success', 'Order placed successfully!');
//     return redirect()->to('ordehistory');
// }
// public function orderbook() {
//     print_r($_POST);die;

//     $session = \Config\Services::session();
//     $id = $session->get('id');
//     $model = new Register_model();
//     $wherecond = array('id' => $id);
//     $partnerid = $model->getalldata('register', $wherecond);
//     $allotPartnerId = null;

//     if (!empty($partnerid) && is_array($partnerid)) {
//         $user = $partnerid[0];
//         if (isset($user->allot_partner)) {
//             $allotPartnerId = $user->allot_partner;
//         }
//     }

//     $request = \Config\Services::request();
//     $product = $request->getPost('productDropdown');
//     $quantity = $request->getPost('quantityInput');
//     $deliveryDate = $request->getPost('deliveryDate');
//     $deliveryTime = $request->getPost('deliveryTime');
//     $paymentMode = $request->getPost('paymentMode');
//     $price = $request->getPost('price');
//     $unit = $request->getPost('unit');
//     $transactionIdInput = $request->getPost('transactionIdInput');
    
//     // Validation rules
//     $validation = \Config\Services::validation();
//     $validation->setRules([
//         'productDropdown' => 'required',
//         'quantityInput' => 'required|integer|greater_than[0]',
//         'deliveryDate' => 'required|valid_date',
//         'deliveryTime' => 'required',
//         'paymentMode' => 'required',
//         'transactionIdInput' => 'permit_empty',
//         'screenshotInput' => 'permit_empty|uploaded[screenshotInput]|max_size[screenshotInput,1024]|ext_in[screenshotInput,jpg,jpeg,png,pdf]' // updated file types to include images
//     ]);

//     if (!$validation->withRequest($request)->run()) {
//         return redirect()->back()->withInput()->with('errors', $validation->getErrors());
//     }

//     // Process delivery date and time
//     $deliveryDateObj = new \DateTime($deliveryDate);
//     $deliveryTimeObj = \DateTime::createFromFormat('H:i', explode('-', $deliveryTime)[0]);

//     // Check if delivery date is today and time is after 14:00
//     if ($deliveryDateObj->format('Y-m-d') === (new \DateTime())->format('Y-m-d')) {
//         if ($deliveryTimeObj >= new \DateTime('14:00')) {
//             // Change delivery date to the next day and set delivery time to 09:00-14:00
//             $deliveryDateObj->modify('+1 day');
//             $deliveryTime = '09:00-14:00';
//         }
//     }

//     // Format the adjusted delivery date
//     $deliveryDateAdjusted = $deliveryDateObj->format('Y-m-d');

//     $data = [
//         'product' => $product,
//         'quantity' => $quantity,
//         'delivery_date' => $deliveryDateAdjusted,
//         'delivery_time' => $deliveryTime,
//         'payment_mode' => $paymentMode,
//         'coustomerid' => $id,
//         'allot_partner' => $allotPartnerId,
//         'unit' => $unit,
//         'price' => $price,
//         'transaction_id' => $transactionIdInput,
//     ];

//     // Handle file upload
//     $file = $request->getFile('screenshotInput');
//     if ($file->isValid() && !$file->hasMoved()) {
//         $newName = $file->getRandomName();
//         $file->move(ROOTPATH . 'public/uploads/paymentscreenshot', $newName);
//         $data['payment_screenshot'] = $newName;
//     }

//     // Determine payment status
//     if (!empty($transactionIdInput) || !empty($data['payment_screenshot'])) {
//         $data['payment_status'] = 'paid';
//         $data['deliveypartnerypaymet'] = 'R';
//     } else {
//         $data['payment_status'] = 'unpaid';
//     }

//     // Insert into the database
//     $db = \Config\Database::connect();
//     $db->table('tbl_order')->insert($data);

//     session()->setFlashdata('success', 'Order placed successfully!');
//     return redirect()->to('ordehistory');
// }
public function orderbook() {
    // Debug print to check received POST data
    // print_r($_POST);die;

    $session = \Config\Services::session();
    $id = $session->get('id');
    $model = new Register_model();
    $wherecond = array('id' => $id);
    $partnerid = $model->getalldata('register', $wherecond);
    $allotPartnerId = null;

    if (!empty($partnerid) && is_array($partnerid)) {
        $user = $partnerid[0];
        if (isset($user->allot_partner)) {
            $allotPartnerId = $user->allot_partner;
        }
    }

    $request = \Config\Services::request();
    $product = $request->getPost('productDropdown');
    $quantity = $request->getPost('quantityInput');
    $deliveryDate = $request->getPost('deliveryDate');
    $deliveryTime = $request->getPost('deliveryTime');
    $paymentMode = $request->getPost('paymentMode');
    $price = $request->getPost('price');
    $unit = $request->getPost('unit');
    $transactionIdInput = $request->getPost('transaction_id');
    
    // Validation rules
    $validation = \Config\Services::validation();
    $validation->setRules([
        'productDropdown' => 'required',
        'quantityInput' => 'required|integer|greater_than[0]',
        'deliveryDate' => 'required|valid_date',
        'deliveryTime' => 'required',
        'paymentMode' => 'required',
        'transaction_id' => 'permit_empty',
    ]);

    if (!$validation->withRequest($request)->run()) {
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }

    // Set the timezone to IST
    date_default_timezone_set('Asia/Kolkata');

    // Process delivery date and time
    $deliveryDateObj = new \DateTime($deliveryDate);
    $deliveryTimeObj = \DateTime::createFromFormat('H:i', explode('-', $deliveryTime)[0]);

    // Get the current time
    $currentDateTime = new \DateTime();
    $currentTime = $currentDateTime->format('H:i');
    $currentDate = $currentDateTime->format('Y-m-d');
    
    // Debug print to check current IST time
    // print_r($currentTime);die;
    
    // Check if delivery date is today
    if ($deliveryDateObj->format('Y-m-d') === $currentDate) {
        if ($deliveryTime === '09:00-14:00' && $currentTime < '14:00') {
            // If current time is less than 14:00 and the delivery time is 09:00-14:00, set delivery time to 16:00-18:00
            $deliveryTime = '16:00-18:00';
        } elseif ($currentTime >= '14:00') {
            // If current time is 14:00 or later, set delivery date to the next day and delivery time to 09:00-14:00
            $deliveryDateObj->modify('+1 day');
            $deliveryTime = '09:00-14:00';
        }
    }

    // Format the adjusted delivery date
    $deliveryDateAdjusted = $deliveryDateObj->format('Y-m-d');

    $data = [
        'product' => $product,
        'quantity' => $quantity,
        'delivery_date' => $deliveryDateAdjusted,
        'delivery_time' => $deliveryTime,
        'payment_mode' => $paymentMode,
        'coustomerid' => $id,
        'allot_partner' => $allotPartnerId,
        'unit' => $unit,
        'price' => $price,
        'transaction_id' => $transactionIdInput,
    ];

    // Determine payment status
    if (!empty($transactionIdInput)) {
        $data['payment_status'] = 'paid';
        $data['deliveypartnerypaymet'] = 'R';
    } else {
        $data['payment_status'] = 'unpaid';
    }

    // Insert into the database
    $db = \Config\Database::connect();
    $db->table('tbl_order')->insert($data);

    session()->setFlashdata('success', 'Order placed successfully!');
    return redirect()->to('ordehistory');
}



public function paymentsucess()
{
    print_r($_POST);die;
}
public function logout()
{
    $session = session();
    $session->destroy();
    return redirect()->to('/');
}
public function allotpartners()
{
    $partnerId = $this->request->getPost('allot_partner');
    $orderId = $this->request->getPost('order_id');
    
    $model = new Register_model();
    
    if ($model->updateAllotPartner($orderId, $partnerId)) {
        session()->setFlashdata('success','Partner allotted successfully');
        return redirect()->to('allotdelivery');
    } else {
        session()->setFlashdata('error','Failed to allot partner');
        return redirect()->to('allotdelivery');
    }
}
public function allotpartnerstocustomer()
{
    $partnerId = $this->request->getPost('allot_partner');
    $Id = $this->request->getPost('Customer_id');
    $model = new Register_model();
    $currentDate = date('Y-m-d'); 
    $wherecond = ['delivery_date >=' => $currentDate,'coustomerid'=>$Id
    ];

    $orders = $model->getalldata('tbl_order', $wherecond);
    foreach ($orders as $order) {
        $updateData = ['allot_partner' => $partnerId];
        $updateCondition = ['id' => $order->id]; 
        $model->updateOrder('tbl_order', $updateData, $updateCondition);
    }
    if ($model->updatePartner($Id, $partnerId)) {
        session()->setFlashdata('success','Partner allotted successfully');
        return redirect()->to('Customerlist');
    } else {
        session()->setFlashdata('error','Failed to allot partner');
        return redirect()->to('Customerlist');
    }
}
public function updatepaymentstatus()
{
    $payment_status = $this->request->getPost('payment_status');
    $orderId = $this->request->getPost('order_id');
    
    $model = new Register_model();
  
    if ($model->updatedpayment($orderId, $payment_status)) {
        session()->setFlashdata('success','payemnt recieved successfully');
        return redirect()->to('orderpayment');
    } else {
        session()->setFlashdata('error','Failed to recieved payment');
        return redirect()->to('orderpayment');
    }
}
public function Staffdelivery()
{
    $db = \Config\Database::connect();
    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to('/');
    }
    $builder = $db->table('register');
    $builder->like('accesslevel', 'yourorder');
    $builder->where(['role' => 'Admin', 'active' => 'Y']);
    $query = $builder->get();
    $data['userdata'] = $query->getResult();

    echo view('Admin/Staffdelivery',$data);
}
public function Orderlist()
{
    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to('/');
    }
    $model = new Register_model();
    $wherecond = array('is_deleted' => 'N');
    $orders = $model->getalldata('tbl_order', $wherecond);
    if (!is_array($orders)) {
        $orders = [];
    }
    $data['order'] = [];
    foreach ($orders as $order) {
        $product = $model->getProductById($order->product);
        if ($product) {
            $order->product_name = $product->productname;
        } else {
            $order->product_name = "Unknown Product";
        }
        $user = $model->getuserById($order->coustomerid);
        if ($user) {
            $order->user_name = $user->full_name;
        } else {
            $order->user_name = "Unknown User";
        }
        $deliveryPartner = $model->getuserById($order->delivererdby);
        if ($deliveryPartner) {
            $order->delivererdby_name = $deliveryPartner->full_name;
        } else {
            $order->delivererdby_name = "";
        }

        $data['order'][] = $order;
    }
    echo view('Admin/orderlist', $data);
}
public function deliveredorder()
{
    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to('/');
    }
   $db = \Config\Database::connect();
    $model = new Register_model();
    $wherecond = array('order_status' => 'D','is_deleted' => 'N');
    $orders = $model->getalldata('tbl_order', $wherecond);
    if (!is_array($orders)) {
        $orders = [];
    }
    $data['order'] = [];
    foreach ($orders as $order) {
        $product = $model->getProductById($order->product);
        if ($product) {
            $order->product_name = $product->productname;
        } else {
            $order->product_name = "Unknown Product";
        }
        $user = $model->getuserById($order->coustomerid);
        if ($user) {
            $order->user_name = $user->full_name;
        } else {
            $order->user_name = "Unknown User";
        }
        $deliveryPartner = $model->getuserById($order->delivererdby);
        if ($deliveryPartner) {
            $order->delivererdby_name = $deliveryPartner->full_name;
        } else {
            $order->delivererdby_name = "";
        }

        $data['order'][] = $order;
    }
    echo view('Admin/deliveredorder',$data);
}
//  public function yourorder()
// {
//     $session = \Config\Services::session();
//     if (!$session->has('id')) {
//         return redirect()->to('/');
//     }
//     $today = date('Y-m-d');
//     $id = $session->get('id');
//     $model = new Register_model();
//     $wherecond = array('order_status' => 'B', 'allot_partner' => $id ,'delivery_date' =>$today);
//     $orders = $model->getalldata('tbl_order', $wherecond);
//     $data['order'] = [];
//     if (!empty($orders) && (is_array($orders) || is_object($orders))) {
//         foreach ($orders as $order) {
//             $product = $model->getProductById($order->product);
//             $order->product_name = $product->productname; 
//             $user = $model->getuserById($order->coustomerid);
//             $order->user_name = $user->full_name; 
//             $order->address = $user->address; 
//             $order->location = $user->location; 
//             $data['order'][] = $order;
//         }
//     } else {
//         $data['message'] = 'No orders found.';
//     }
// //    echo '<pre>'; print_r($data);die;
//     echo view('Admin/yourorder', $data);
// }
public function yourorder()
{
    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to('/');
    }

    $today = date('Y-m-d');
    $id = $session->get('id');
    $model = new Register_model();
    $wherecond = array('order_status' => 'B', 'allot_partner' => $id, 'delivery_date' => $today);

    // Get filter inputs from GET request
    $filter_zone = $this->request->getGet('zone');
    $filter_society = $this->request->getGet('society_name');
    $filter_building = $this->request->getGet('building_name');

    $orders = $model->getalldata('tbl_order', $wherecond);
    $data['order'] = [];
    $data['zones'] = $model->getalldata('zone', []); // Fetch all zones
    $data['societies'] = $model->getalldata('society', []); // Fetch all societies
    $data['buildings'] = $model->getalldata('building', []); // Fetch all buildings

    if (!empty($orders) && (is_array($orders) || is_object($orders))) {
        foreach ($orders as $order) {
            $product = $model->getProductById($order->product);
            $order->product_name = $product->productname;
            $user = $model->getuserById($order->coustomerid);
            $order->user_name = $user->full_name;
            $order->address = $user->address;
            $order->location = $user->location;

            // Fetch Zone, Societyname, and Buildingname
            $registerData = $model->getalldata('register', array('id' => $order->coustomerid));
            if (!empty($registerData) && is_array($registerData)) {
                $registerData = $registerData[0];

                // Fetch Zone
                $zone = $model->getalldata('zone', array('id' => $registerData->Zone));
                $order->zone = !empty($zone) ? $zone[0]->zone : '';

                // Fetch Societyname
                $society = $model->getalldata('society', array('id' => $registerData->Societyname));
                $order->Societyname = !empty($society) ? $society[0]->Societyname : '';

                // Fetch Buildingname
                $building = $model->getalldata('building', array('id' => $registerData->Buildingname));
                $order->Buildingname = !empty($building) ? $building[0]->Buildingname : '';
            }

            // Apply filters
            $match = true;
            if ($filter_zone && $filter_zone != $order->zone) {
                $match = false;
            }
            if ($filter_society && $filter_society != $order->Societyname) {
                $match = false;
            }
            if ($filter_building && $filter_building != $order->Buildingname) {
                $match = false;
            }

            if ($match) {
                $data['order'][] = $order;
            }
        }
    } else {
        $data['message'] = 'No orders found.';
    }

    echo view('Admin/yourorder', $data);
}

 public function updateorderstatus()
 {
    $order_status = $this->request->getPost('status');
    $orderId = $this->request->getPost('order_id'); 
    $deliverdby =$this->request->getPost('allot_partner'); 
    $model = new Register_model(); 
    if ($model->updateorderstatus($orderId, $order_status,$deliverdby)) {
        session()->setFlashdata('success','payemnt recieved successfully');
        return redirect()->to('yourorder');
    } else {
        session()->setFlashdata('error','Failed to recieved payment');
        return redirect()->to('yourorder');
    }
 }
 public function deliverypaymentcollect()
 {
     $order_status = $this->request->getPost('deliveypartnerypaymet');
     $orderId = $this->request->getPost('order_id'); 
     $deliverdby =$this->request->getPost('allot_partner'); 
     $model = new Register_model(); 
     if ($model->updatepaymetbydeliverypartner($orderId, $order_status,$deliverdby)) {
         session()->setFlashdata('success','payemnt recieved successfully');
         return redirect()->to('yourorder');
     } else {
         session()->setFlashdata('error','Failed to recieved payment');
         return redirect()->to('yourorder');
     }

 }
 public function deletuser()
 { 
     $id = $this->request->getPost('id'); 
     $tableName = $this->request->getPost('table_name');

     if (!$id || !$tableName) {
         return $this->response->setJSON(['status' => 'error', 'message' => 'Invalid input.']);
     }
     $db = \Config\Database::connect();

     try {
         $db->transBegin();
         $builder = $db->table($tableName);
         $builder->where('id', $id);
         $builder->update(['active' => 'N']);
         if ($db->transStatus() === FALSE) {
             $db->transRollback();
             return redirect()->to('userlist');
         } else {
             $db->transCommit();
            return redirect()->to('userlist');
        }
     } catch (\Exception $e) {
         $db->transRollback();
         return redirect()->to('userlist');
     }
 }
 public function productpage()
{
    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to('/');
    }

    $model = new Register_model();
    $wherecond = array('is_deleted' => 'N');
    $data['products'] = $model->getalldata('tbl_produact', $wherecond);

    echo view('customer/productpage', $data);
}

 
}
