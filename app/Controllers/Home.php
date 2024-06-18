<?php

namespace App\Controllers;
use App\Models\Register_model;

class Home extends BaseController
{
    public function index(): string
    {
        return view('login');
    }
    public function getregister()
   {
    return view('register');
   }
    public function login()
    {
        return view('login');
    }
    public function register()
    {
        // print_r($_POST);die;
        $db = \Config\Database::connect();

        // Get the POST data
        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'mobile_no' => $this->request->getPost('mobile_no'),
            'role' =>'customer',
            'alternate_name' => $this->request->getPost('Alternate_name'),
            'alternate_number' => $this->request->getPost('Alternatenumber'),
            'flat' => $this->request->getPost('Flat'),
            'floor' => $this->request->getPost('Floor'),
            'address' => $this->request->getPost('Address'),
            'password' =>$this->request->getPost('password'),
            'agree'=>$this->request->getPost('agree'),
        ];

        // Insert data into the database table
        $db->table('register')->insert($data);
        return redirect()->to('login'); 
    }
    public function addCoustmersbyadmin()
    {  

        $db = \Config\Database::connect();
        // print_r($_POST);die;
        // Get the POST data
        $data = [
            'full_name' => $this->request->getPost('full_name'),
            'email' => $this->request->getPost('email'),
            'mobile_no' => $this->request->getPost('mobile_no'),
            'role' =>'customer',
            'alternate_name' => $this->request->getPost('Alternate_name'),
            'alternate_number' => $this->request->getPost('Alternatenumber'),
            'flat' => $this->request->getPost('Flat'),
            'floor' => $this->request->getPost('Floor'),
            'address' => $this->request->getPost('Address'),
            'password' =>$this->request->getPost('password'),
            'agree'=>'on',
        ];

        // Insert data into the database table
        $db->table('register')->insert($data);
        return redirect()->to('addCoustmer'); 
    }
    public function dologin()
    {
    //  print_r($_POST);die;
    $model = new Register_model();

    $session = \CodeIgniter\Config\Services::session();
    // $model = new Loginmodel();
    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');  
    $user = $model->checkCredentials(['email' => $email]);
    // print_r($user);die;
    if ($user) {
        if ($password === $user['password']) {  
            $userData = [
                'id' => $user['id'],
                'full_name' => $user['full_name'],
                'email' => $user['email'],
                'role' => $user['role'],
                'accesslevel'=>$user['accesslevel'],
            
            ];
            $session->set($userData);
            // print_r($userData);die;
            if ($user['role'] === 'customer') {
                return redirect()->to(base_url('order'));
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
public function Subscriptionsbook()
{
    // print_r($_POST);die;
    $session = \Config\Services::session();
    $id = $session->get('id');
    $request = \Config\Services::request();

    // Retrieve common data from the request
    $product = $request->getPost('productDropdown');
    $pricePerUnit =$request->getPost('pricePerUnit');
    $quantity = $request->getPost('quantityInput');
    $deliveryTime = $request->getPost('deliveryTime');
    $paymentMode = $request->getPost('paymentMode');
    $price = $request->getPost('price');
    $unit = $request->getPost('unit');
    $transactionIdInput = $request->getPost('transactionIdInput');

    // Retrieve selected dates from the request
    $selectedDates = explode(',', $request->getPost('selectedDates'));

    // Validation setup
    $validation = \Config\Services::validation();
    $validation->setRules([
        'productDropdown' => 'required',
        'quantityInput' => 'required|integer|greater_than[0]',
        'deliveryTime' => 'required',
        'paymentMode' => 'required',
        'transactionIdInput' => 'permit_empty',
        'screenshotInput' => 'permit_empty|uploaded[screenshotInput]|max_size[screenshotInput,1024]|ext_in[screenshotInput,jpg,jpeg,png,pdf]'
    ]);

    // Iterate over selected dates and insert records
    foreach ($selectedDates as $date) {
        $data = [
            'product' => $product,
            'quantity' => $quantity,
            'delivery_date' => $date,
            'delivery_time' => $deliveryTime,
            'payment_mode' => $paymentMode,
            'coustomerid' => $id,
            'unit' => $unit,
            'price' => $pricePerUnit * $quantity,
            'transaction_id' => $transactionIdInput,
        ];

        // Handle file upload
        $file = $request->getFile('screenshotInput');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/paymentscreenshot', $newName);
            $data['payment_screenshot'] = $newName;
        }

        // Update payment status based on transaction ID or uploaded screenshot
        if (!empty($transactionIdInput) || !empty($data['payment_screenshot'])) {
            $data['payment_status'] = 'paid';
            $data['deliveypartnerypaymet'] = 'R'; // Not sure what 'deliveypartnerypaymet' is, so replaced with 'R'
        } else {
            $data['payment_status'] = 'unpaid';
        }

        // Insert data into database
        $db = \Config\Database::connect();
        $db->table('tbl_order')->insert($data);
    }

    session()->setFlashdata('success', 'Order placed successfully!');
    return redirect()->to('ordehistory');
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
    // print_r( $data['product']);die;
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

    // Get order data
    $orders = $model->getalldata('tbl_order', $wherecond);

    // Fetch product names
    $data['order'] = [];
    if (!is_array($orders)) {
        $orders = [];
    }
    // print_r($orders);die;
    foreach ($orders as $order) {

        $product = $model->getProductById($order->product);
        $order->product_name = $product->productname; // Assuming your product table has a 'name' field
        $data['order'][] = $order;
    }

    // print_r($data['order']); // Debugging line, remove or comment out after confirming it works
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
// print_r($data['product']);die;
    echo view('customer/order',$data);
}
public function AdminDashboard()
{
    $model = new Register_model();
    $wherecond = array('order_status' => 'B');
    $orders = $model->getalldata('tbl_order', $wherecond);

    // Ensure $orders is an array
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
    // print_r($orders);die;
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
        $data['order'][] = $order;
    }
// print_r($data['order']);die;
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
//   print_r($coustmordata);die;
  echo view('customer/profile', ['customerData' => $customerData]);
}
public function Updateprofile()
{
    $session = \Config\Services::session();
    $id = $session->get('id');
    $model = new Register_model();

    // Collect POST data
    $data = [
        'full_name' => $this->request->getPost('full_name'),
        'email' => $this->request->getPost('email'),
        'mobile_no' => $this->request->getPost('mobile_no'),
        'alternate_name' => $this->request->getPost('alternate_name'),
        'alternate_number' => $this->request->getPost('alternate_number'),
        'flat' => $this->request->getPost('flat'),
        'floor' => $this->request->getPost('floor'),
        'address' => $this->request->getPost('address')
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
public function add_product()
{
    // print_r($_POST);die;
    $productname = $this->request->getPost('productname');
    $price=$this->request->getPost('price');
    $Size=$this->request->getPost('Size');
    $unit=$this->request->getPost('unit');
    $brand=$this->request->getPost('brand');
    $data = [
        'productname' => $productname,
        'price'=>$price,
        'Size'=>$Size,
        'unit'=>$unit,
         'brand'=>$brand,
    ];
    $db = \Config\Database::connect();
    $tbl_produact = $db->table('tbl_produact');
    $existingTask = $tbl_produact->where('productname', $productname)->get()->getFirstRow();
    if ($existingTask && ($this->request->getVar('id') == "" || $existingTask->id != $this->request->getVar('id'))) {
        session()->setFlashdata('success', 'Task name already exists.');
        return redirect()->to('productlist');
    }

    if ($this->request->getVar('id') == "") {
        $tbl_produact->insert($data);
        session()->setFlashdata('success', 'Menu added successfully.');
    } else {
        $tbl_produact->where('id', $this->request->getVar('id'))->update($data);
        session()->setFlashdata('success', 'Menu updated successfully.');
    }

    return redirect()->to('produactlist');
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
// add user
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
    // print_r($data['menu_data']);die;
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
    // print_r($data);die;
    echo view('Admin/coustmerreport',$data);
}

public function addstaff()
{
    // print_r($_POST);die;
    $model = new Register_model();
    $db = \Config\Database::connect();
    
    // Get the posted access levels
    $access_level = $this->request->getPost('accesslevel');
    if (!is_array($access_level)) {
        $access_level = [];
    }

    // Prepare the data for insertion
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

    // return redirect()->to('produactlist');
}
public function addmenu()
{
    echo view('Admin/addmenu');
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

   // Insert data into the database table
   $db->table('tbl_menu')->insert($data);
   return redirect()->to('addmenu');
}
public function orderbook() {
    $session = \Config\Services::session();
    $id = $session->get('id');
    $request = \Config\Services::request();
    $product = $request->getPost('productDropdown');
    $quantity = $request->getPost('quantityInput');
    $deliveryDate = $request->getPost('deliveryDate');
    $deliveryTime = $request->getPost('deliveryTime');
    $paymentMode = $request->getPost('paymentMode');
    $price = $request->getPost('price');
    $unit = $request->getPost('unit');
    $transactionIdInput = $request->getPost('transactionIdInput');
    $validation = \Config\Services::validation();
    $validation->setRules([
        'productDropdown' => 'required',
        'quantityInput' => 'required|integer|greater_than[0]',
        'deliveryDate' => 'required|valid_date',
        'deliveryTime' => 'required',
        'paymentMode' => 'required',
        'transactionIdInput' => 'permit_empty',
        'screenshotInput' => 'permit_empty|uploaded[screenshotInput]|max_size[screenshotInput,1024]|ext_in[screenshotInput,jpg,jpeg,png,pdf]' // updated file types to include images
    ]);
    if (!$validation->withRequest($request)->run()) {
        return redirect()->back()->withInput()->with('errors', $validation->getErrors());
    }
    $data = [
        'product' => $product,
        'quantity' => $quantity,
        'delivery_date' => $deliveryDate,
        'delivery_time' => $deliveryTime,
        'payment_mode' => $paymentMode,
        'coustomerid'=>$id,
        'unit' => $unit,
        'price' => $price,
        'transaction_id' => $transactionIdInput,
    ];
    $file = $request->getFile('screenshotInput');
    if ($file->isValid() && !$file->hasMoved()) {
        $newName = $file->getRandomName();
        $file->move(ROOTPATH . 'public/uploads/paymentscreenshot', $newName);
        $data['payment_screenshot'] = $newName;
    }
    if (!empty($transactionIdInput) || !empty($data['payment_screenshot'])) {
        $data['payment_status'] = 'paid';
        $data['deliveypartnerypaymet'] = 'R';
       
    } else {
        $data['payment_status'] = 'unpaid';
    }
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
    // session_destroy();
    $session->destroy();
    // print_r($_SESSION);die;
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
public function updatepaymentstatus()
{
    // print_r($_POST);die;
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

    // print_r($data['userdata']);die;
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
  //  echo '<pre>'; print_r($data['order']); die;
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
    // print_r($data);die;
    echo view('Admin/deliveredorder',$data);
}
 public function yourorder()
{
    $session = \Config\Services::session();
    if (!$session->has('id')) {
        return redirect()->to('/');
    }

    $id = $session->get('id');
    $model = new Register_model();
    $wherecond = array('order_status' => 'B', 'allot_partner' => $id);
    $orders = $model->getalldata('tbl_order', $wherecond);
    $data['order'] = [];
    if (!empty($orders) && (is_array($orders) || is_object($orders))) {
        foreach ($orders as $order) {
            $product = $model->getProductById($order->product);
            $order->product_name = $product->productname; 
            $user = $model->getuserById($order->coustomerid);
            $order->user_name = $user->full_name; 
            $order->address = $user->address; 
            $data['order'][] = $order;
        }
    } else {
        $data['message'] = 'No orders found.';
    }
// print_r( $data['order']);die;
    echo view('Admin/yourorder', $data);
}
 public function updateorderstatus()
 {
    // print_r($_POST);die;
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
    //  print_r($_POST);die;
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
            //  return $this->response->setJSON(['status' => 'error', 'message' => 'Update failed.']);
         } else {
             $db->transCommit();
            //  return $this->response->setJSON(['status' => 'success', 'message' => 'Record updated successfully.']);
            return redirect()->to('userlist');
        }
     } catch (\Exception $e) {
         $db->transRollback();
         return redirect()->to('userlist');
        //  return $this->response->setJSON(['status' => 'error', 'message' => 'An error occurred: ' . $e->getMessage()]);
     }
 }
 
}
