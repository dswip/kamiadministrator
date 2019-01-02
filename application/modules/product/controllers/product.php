<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Product extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        
        $this->load->model('Product_model', '', TRUE);

        $this->properti = $this->property->get();
//        $this->acl->otentikasi();

        $this->modul = $this->components->get(strtolower(get_class($this)));
        $this->title = strtolower(get_class($this));
        $this->role = new Role_lib();
        $this->category = new Categoryproduct_lib();
        $this->product = new Product_lib();
        $this->supplier = new Supplier_lib();
        $this->sales = new Sales_lib();
        $this->api = new Api_lib();
        
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token'); 
        
    }

    private $properti, $modul, $title, $product, $supplier, $api;
    private $role, $category, $model, $currency, $sales;

    function index()
    {
       $this->session->unset_userdata('start'); 
       $this->session->unset_userdata('end');
       $this->session->unset_userdata('langid');
       $this->get_last(); 
    }
    
    // =================== API ====================
        
    // get product list based category and limit
    public function get_list($cat,$type=null,$limit=5,$start=0){
        
      if ($this->api->otentikasi() == TRUE){  
        $status=200;  
        $lib = new Product_lib();
        if ($type != 'recommend'){
           $result = $lib->get_poduct_based_cat($cat,$limit,$start)->result();
           $num = $lib->get_poduct_based_cat($cat,$limit,$start)->num_rows();
           
        }else{ $result = $lib->get_recommended($limit); }
        
        $output = null;
        foreach($result as $res){
            
            $qty = $this->product->get_qty($res->id);
            $output[] = array ("id" => $res->id, "sku" => $res->sku, "name" => $res->name, "order" => $res->orders, "price" => $res->price, "restricted" => $res->restricted, "qty" => $qty,  
                               "image" => base_url().'images/product/'.$res->image);
        }
        
        if ($type != 'recommend'){
           if ($num > 0){ $response['content'] = $output; }else{ $response['content'] = 'reachedMax'; }     
        }else{ $response['content'] = $output; }
      }else{ $response = array('error' => 'Invalid Token or Expired..!'); $status = 401; }
      $this->api->response($response, $status);
    }
    
     public function product_detail($pid=0){
        
        $lib = new Product_lib();
        $cat = new Categoryproduct_lib();
        $model = new Model_lib();
        
        $res = $lib->get_detail_based_id($pid);
        $qty = $lib->get_qty($res->id);
        $url1 = null; $url2 = null; $url3 = null; $url4 = null; $url5 = null; $url6 = null;
        if ($res->url_type == 'UPLOAD'){ $url = base_url().'images/product/'; 
        
            if ($res->url1){ $url1 = $url.$res->url1; }
            if ($res->url2){ $url2 = $url.$res->url2; }
            if ($res->url3){ $url3 = $url.$res->url3; }
            if ($res->url4){ $url4 = $url.$res->url4; }
            if ($res->url5){ $url5 = $url.$res->url5; }
            if ($res->url6){ $url6 = $url.$res->url6; }
        
        }else{
           $url1 = $res->url1; $url2 = $res->url2; $url3 = $res->url3;
           $url4 = $res->url4; $url5 = $res->url5; $url6 = $res->url6;
        }
        
        $output[] = array ("id" => $res->id, "sku" => $res->sku, "name" => $res->name,
                           "category" => $cat->get_name($res->category),
                           "image" => base_url().'images/product/'.$res->image,  
                           "url1" => $url1, "url2" => $url2, "url3" => $url3, "url4" => $url4, 
                           "url5" => $url5, "url6" => $url6, "price" => $res->price, "restricted" => $res->restricted,
                           "qty" => $qty, "start" => $res->start, "end" => $res->end, "recommended" => $res->recommended, "orders" => $res->orders, 
                           "description" => $res->description
                          );
         
        $response['content'] = $output;
            $this->output
            ->set_status_header(200)
            ->set_content_type('application/json', 'utf-8')
            ->set_output(json_encode($response,128))
            ->_display();
            exit; 
    }
    
    // =================== API ====================
    
    // ============ ajax ==========================
    
    function get_price($pid){
        $product = $this->Product_model->get_by_id($pid)->row();
        echo $product->price;
    }
     
    public function getdatatable($search=null,$cat='null',$model='null',$publish='null')
    {
        if(!$search){ $result = $this->Product_model->get_last($this->modul['limit'])->result(); }
        else {$result = $this->Product_model->search($cat,$model,$publish)->result(); }
	
        $output = null;
        if ($result){
                
         foreach($result as $res)
	 {   
	   $output[] = array ($res->id, $res->sku, $this->category->get_name($res->category), base_url().'images/product/'.$res->image,
                              strtoupper($res->name), idr_format($res->price), $res->publish, $res->recommended, $res->orders
                             );
	 } 
         
        $this->output
         ->set_status_header(200)
         ->set_content_type('application/json', 'utf-8')
         ->set_output(json_encode($output))
         ->_display();
         exit;  
         
        }
    }

    function get_last()
    {
        $this->acl->otentikasi1($this->title);

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Product Manager');
        $data['h2title'] = 'Product Manager';
        $data['main_view'] = 'product_view';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['form_action_update'] = site_url($this->title.'/update_process');
        $data['form_action_del'] = site_url($this->title.'/delete_all');
        $data['form_action_report'] = site_url($this->title.'/report_process');
        $data['form_action_assembly'] = site_url($this->title.'/assembly_process');
        $data['form_action_import'] = site_url($this->title.'/import');
        $data['link'] = array('link_back' => anchor('main/','Back', array('class' => 'btn btn-danger')));

        $data['category'] = $this->category->combo();
        $data['supplier'] = $this->supplier->combo();
        $data['array'] = array('','');

        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="datatable-buttons" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('#','No', 'Image', 'Category', 'SKU', 'Name', 'Price', 'Order', 'Action');

        $data['table'] = $this->table->generate();
        $data['source'] = site_url($this->title.'/getdatatable');
        $data['graph'] = site_url()."/product/chart/";
            
        // Load absen view dengan melewatkan var $data sbgai parameter
	$this->load->view('template', $data);
    }
    
    function chart()
    {
        $data = $this->category->get();
        $datax = array();
        foreach ($data as $res) 
        {  
           $point = array("label" => $res->name , "y" => $this->product->get_product_based_category($res->id));
           array_push($datax, $point);      
        }
        echo json_encode($datax, JSON_NUMERIC_CHECK);
    }
    
    function publish($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->Product_model->get_by_id($uid)->row();
       if ($val->publish == 0){ $lng = array('publish' => 1); }else { $lng = array('publish' => 0); }
       $this->Product_model->update($uid,$lng);
       echo 'true|Status Changed...!';
       }else{ echo "error|Sorry, you do not have the right to change publish status..!"; }
    }
    
    function recomend($uid = null)
    {
       if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){ 
       $val = $this->Product_model->get_by_id($uid)->row();
       if ($val->recommended == 0){ $lng = array('recommended' => 1); }else { $lng = array('recommended' => 0); }
       $this->Product_model->update($uid,$lng);
       echo 'true|Status Changed...!';
       }else{ echo "error|Sorry, you do not have the right to change recommended status..!"; }
    }
    
    function delete_all($type='soft')
    {
      if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){
      
        $cek = $this->input->post('cek');
        $jumlah = count($cek);

        if($cek)
        {
          $jumlah = count($cek);
          $x = 0;
          for ($i=0; $i<$jumlah; $i++)
          {
             if ($type == 'soft') { $this->Product_model->delete($cek[$i]); }
             else { $this->remove_img($cek[$i],'force');
                    $this->attribute_product->force_delete_by_product($cek[$i]);
                    $this->Product_model->force_delete($cek[$i]);  }
             $x=$x+1;
          }
          $res = intval($jumlah-$x);
          //$this->session->set_flashdata('message', "$res $this->title successfully removed &nbsp; - &nbsp; $x related to another component..!!");
          $mess = "$res $this->title successfully removed &nbsp; - &nbsp; $x related to another component..!!";
          echo 'true|'.$mess;
        }
        else
        { //$this->session->set_flashdata('message', "No $this->title Selected..!!"); 
          $mess = "No $this->title Selected..!!";
          echo 'false|'.$mess;
        }
      }else{ echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
      
    }

    function delete($uid)
    {
        if ($this->acl->otentikasi_admin($this->title,'ajax') == TRUE){
            $this->Product_model->delete($uid);
            
            $this->session->set_flashdata('message', "1 $this->title successfully removed..!");

            echo "true|1 $this->title successfully removed..!";
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
        
    }
    
    function add()
    {

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Create New '.$this->modul['title'];
        $data['main_view'] = 'article_form';
	$data['form_action'] = site_url($this->title.'/add_process');
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $data['language'] = $this->language->combo();
        $data['category'] = $this->category->combo();
        $data['currency'] = $this->currency->combo();
        $data['source'] = site_url($this->title.'/getdatatable');
        
        $this->load->helper('editor');
        editor();

        $this->load->view('template', $data);
    }

    function add_process()
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){

        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'category_view';
	$data['form_action'] = site_url($this->title.'/add_process');
	$data['link'] = array('link_back' => anchor('category/','<span>back</span>', array('class' => 'back')));

	// Form validation
        $this->form_validation->set_rules('tsku', 'SKU', 'required|callback_valid_sku');
        $this->form_validation->set_rules('tname', 'Name', 'required|callback_valid_name');
        $this->form_validation->set_rules('tmodal', 'Modal Price', 'required|numeric');
        $this->form_validation->set_rules('tprice', 'Price', 'required|numeric');
        $this->form_validation->set_rules('ccategory', 'Category', 'required');
        $this->form_validation->set_rules('csupplier', 'Supplier', 'required');

        if ($this->form_validation->run($this) == TRUE)
        {
            $config['upload_path'] = './images/product/';
            $config['file_name'] = split_space($this->input->post('tname'));
            $config['allowed_types'] = 'jpg|gif|png';
            $config['overwrite'] = true;
            $config['max_size']	= '10000';
            $config['max_width']  = '30000';
            $config['max_height']  = '30000';
            $config['remove_spaces'] = TRUE;

            $this->load->library('upload', $config);
//
            if ( !$this->upload->do_upload("userfile")) // if upload failure
            {
                $info['file_name'] = null;
                $data['error'] = $this->upload->display_errors();
                $product = array('name' => strtolower($this->input->post('tname')),
                                 'sku' => $this->input->post('tsku'), 'capital' => $this->input->post('tmodal'), 
                                 'price' => $this->input->post('tprice'), 
                                 'category' => $this->input->post('ccategory'), 'supplier' => $this->input->post('csupplier'),
                                 'image' => null, 'created' => date('Y-m-d H:i:s'));
            }
            else
            {
                $info = $this->upload->data();
                $this->crop_image($info['file_name']);
                
                $product = array('name' => strtolower($this->input->post('tname')),
                                 'sku' => $this->input->post('tsku'), 'capital' => $this->input->post('tmodal'), 
                                 'price' => $this->input->post('tprice'), 
                                 'category' => $this->input->post('ccategory'), 'supplier' => $this->input->post('csupplier'),
                                 'image' => $info['file_name'], 'created' => date('Y-m-d H:i:s'));
            }
            
            $this->Product_model->add($product);
            $this->session->set_flashdata('message', "One $this->title data successfully saved!");
//            redirect($this->title);
            
            if ($this->upload->display_errors()){ echo "warning|".$this->upload->display_errors(); }
            else { echo 'true|'.$this->title.' successfully saved..!|'.base_url().'images/product/'.$info['file_name']; }
            
          //  echo 'true';
        }
        else{ echo "error|".validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }

    }
    
    private function crop_image($filename){
        
        $config['image_library'] = 'gd2';
        $config['source_image'] = './images/product/'.$filename;
        $config['maintain_ratio'] = TRUE;
        $config['height']	= 250;

        $this->load->library('image_lib', $config); 
        $this->image_lib->resize();
    }
    
    private function cek_tick($val)
    {
        if (!$val)
        { return 0;} else { return 1; }
    }
    
    private function split_array($val)
    { return implode(",",$val); }
    
    function remove_img($id,$type='primary')
    {
        $img = $this->Product_model->get_by_id($id)->row();
        
        if ($type == 'primary'){
            $img = $img->image;
            if ($img){ $img = "./images/product/".$img; @unlink("$img"); }
        }else{
            $image = "./images/product/".$img->image; @unlink("$image");
            $img1 = "./images/product/".$img->url1; @unlink("$img1"); 
            $img2 = "./images/product/".$img->url2; @unlink("$img2");
            $img3 = "./images/product/".$img->url3; @unlink("$img3");
            $img4 = "./images/product/".$img->url4; @unlink("$img4");
            $img5 = "./images/product/".$img->url5; @unlink("$img5");
        }
    }
    
    function assembly($uid){
        
        $assembly = new Assembly_lib();
        $result = $assembly->get_details($uid)->result();
        $hasil = array();
        $i=0;
        foreach ($result as $value) { 
            $hasil[$i] = $value->material; 
            $i++;
        }
        
        echo $uid.'|'.$this->product->get_name($uid).'|'.implode(',', $hasil);
    }
    
    function assembly_process()
    {
        if ($this->acl->otentikasi2($this->title,'ajax') == TRUE){
        $assembly = new Assembly_lib();
        $this->form_validation->set_rules('cmaterial', 'Material', 'required');
        
        if ($this->form_validation->run($this) == TRUE){
            
           $assembly->cleaning($this->input->post('tid')); 
           foreach ($this->input->post('cmaterial') as $value) {
               $assembly->create($this->input->post('tid'),$value);
           }
           echo "true|Material items already added..!!";
            
        }else{ echo "error|".validation_errors(); }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }

    // Fungsi update untuk menset texfield dengan nilai dari database
    function update($uid=null)
    {        
        $this->session->unset_userdata('langid');
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Edit '.$this->modul['title'];
        $data['main_view'] = 'product_update';
	$data['form_action'] = site_url($this->title.'/update_process');
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));

        $data['category'] = $this->category->combo();
        $data['supplier'] = $this->supplier->combo();
        $data['source'] = site_url($this->title.'/getdatatable');
        
        $product = $this->Product_model->get_by_id($uid)->row();
	$this->session->set_userdata('langid', $product->id);
        
        $data['default']['sku'] = $product->sku;
        $data['default']['category'] = $product->category;
        $data['default']['supplier'] = $product->supplier;
        $data['default']['name'] = $product->name;
        $data['default']['modal'] = $product->capital;
        $data['default']['price'] = $product->price;
        $data['default']['description'] = $product->description;
        $data['default']['restricted']  = $product->restricted;
        $data['default']['qty']   = $product->qty;
        $data['default']['start'] = $product->start;
        $data['default']['end'] = $product->end;
        $data['default']['order'] = $product->orders;
        $data['default']['url_type'] = $product->url_type;
        $data['default']['image'] = base_url().'images/product/'.$product->image;
         
        $this->load->helper('editor');
        editor();
        $this->load->view('template', $data);
    }
    
    function image_gallery($pid=null)
    {
        $result = $this->Product_model->get_by_id($pid)->row();
        if ($result->url_type == 'URL'){ 
            $action = site_url($this->title.'/add_image_url/'.$pid);  $view = 'product_image_url';
        }else{
            $action = site_url($this->title.'/add_image/'.$pid);  $view = 'product_image';
        }
        
        $data['title'] = $this->properti['name'].' | Administrator  '.ucwords($this->modul['title']);
        $data['h2title'] = 'Edit '.$this->modul['title'];
        $data['main_view'] = 'article_form';
	$data['form_action'] = $action;
        $data['link'] = array('link_back' => anchor($this->title,'Back', array('class' => 'btn btn-danger')));


        // library HTML table untuk membuat template table class zebra
        $tmpl = array('table_open' => '<table id="" class="table table-striped table-bordered">');

        $this->table->set_template($tmpl);
        $this->table->set_empty("&nbsp;");

        //Set heading untuk table
        $this->table->set_heading('No', 'Name', 'Image');
        
        for ($i=1; $i<=6; $i++)
        {   
            switch ($i) {
                case 1:$url = $result->url1; break;
                case 2:$url = $result->url2; break;
                case 3:$url = $result->url3; break;
                case 4:$url = $result->url4; break;
                case 5:$url = $result->url5; break;
                case 6:$url = $result->url6; break;
            }
            
            if ($result->url_type == 'URL'){ $url = $url;}else{ $url = base_url().'images/product/'.$url;}
            $image_properties = array('src' => $url, 'alt' => 'Image'.$i, 'class' => 'img_product', 'width' => '60', 'title' => 'Image'.$i,);
            $this->table->add_row
            (
               $i, 'Image'.$i, !empty($url) ? img($image_properties) : ''
            );
        }

        $data['table'] = $this->table->generate();
        
        $this->load->view($view, $data);
    }
    
    function valid_image($val)
    {
        if ($val == 0)
        {
            if (!$this->input->post('turl')){ $this->form_validation->set_message('valid_image','Image Url Required..!'); return FALSE; }
            else { return TRUE; }            
        }
    }
    
    function add_image_url($pid)
    {
        if ($this->acl->otentikasi2($this->title) == TRUE){

            $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Product Manager');
            $data['h2title'] = 'Product Manager';
            $data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

            // Form validation
            
            $this->form_validation->set_rules('cname', 'Image Attribute', 'required|');
            $this->form_validation->set_rules('turl', 'Image Url', 'required');

            if ($this->form_validation->run($this) == TRUE)
            {  
                $result = $this->Product_model->get_by_id($pid)->row();
                $attr = array('url'.$this->input->post('cname') => $this->input->post('turl')); 
                $this->Product_model->update($pid, $attr);
                $this->session->set_flashdata('message', "One $this->title data successfully saved!");
                
                echo 'true|Data successfully saved..!'; 
            }
            else
            {
    //            echo validation_errors();
                echo 'error|'.validation_errors();
            }
        }
        else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function add_image($pid)
    {
        if ($this->acl->otentikasi2($this->title) == TRUE){

            $data['title'] = $this->properti['name'].' | Administrator  '.ucwords('Product Manager');
            $data['h2title'] = 'Product Manager';
            $data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

            // Form validation
            
            $this->form_validation->set_rules('cname', 'Image Attribute', 'required|');
            $this->form_validation->set_rules('userfile', 'Image Value', '');

            if ($this->form_validation->run($this) == TRUE)
            {  
                $result = $this->Product_model->get_by_id($pid)->row();
                
                switch ($this->input->post('cname')) {
                case 1:$img = "./images/product/".$result->url1; break;
                case 2:$img = "./images/product/".$result->url2; break;
                case 3:$img = "./images/product/".$result->url3; break;
                case 4:$img = "./images/product/".$result->url4; break;
                case 5:$img = "./images/product/".$result->url5; break;
                case 6:$img = "./images/product/".$result->url6; break;
               }
               @unlink("$img"); 
                
                
                    $config['upload_path'] = './images/product/';
                    $config['file_name'] = split_space($result->name.'_'.$this->input->post('cname'));
                    $config['allowed_types'] = 'jpg|gif|png|jpeg';
                    $config['overwrite']  = true;
                    $config['max_size']   = '50000';
                    $config['max_width']  = '30000';
                    $config['max_height'] = '30000';
                    $config['remove_spaces'] = TRUE;

                    $this->load->library('upload', $config);
                    
                    if ( !$this->upload->do_upload("userfile")) // if upload failure
                    {
                        $attr = array('url'.$this->input->post('cname') => null);
                    }
                    else {$info = $this->upload->data();
                         $attr = array('url'.$this->input->post('cname') => $info['file_name']); 
                    } 
                
                $this->Product_model->update($pid, $attr);
                $this->session->set_flashdata('message', "One $this->title data successfully saved!");
                
                echo 'true|Data successfully saved..!'; 
            }
            else
            {
    //            echo validation_errors();
                echo 'error|'.validation_errors();
            }
        }
        else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
    
    function valid_time(){
        
        $restrict = $this->input->post('crestrict');
        if($restrict == 1)
        {
          $start = strtotime($this->input->post('tstart'));
          $end = strtotime($this->input->post('tend'));
          
          if ($start > $end){
             $this->form_validation->set_message('valid_time', "Invalid Time.");
             return FALSE;
          }else{ return TRUE; }  

        }
        else{ return TRUE; }
    }
    
    function valid_qty($val)
    {
        $restrict = $this->input->post('crestrict');
        if($restrict == 1)
        {
          if ($val == 0 || $val == ""){
             $this->form_validation->set_message('valid_qty', "Qty required.");
             return FALSE;
          }else{ return TRUE; }  

        }
        else{ return TRUE; }
    }

    function valid_role($val)
    {
        if(!$val)
        {
          $this->form_validation->set_message('valid_role', "role type required.");
          return FALSE;
        }
        else{ return TRUE; }
    }
    
    function valid_sku($val)
    {
        if ($this->Product_model->valid('sku',$val) == FALSE)
        {
            $this->form_validation->set_message('valid_sku','SKU registered..!');
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validating_sku($val)
    {
	$id = $this->session->userdata('langid');
	if ($this->Product_model->validating('sku',$val,$id) == FALSE)
        {
            $this->form_validation->set_message('validating_sku', "SKU registered!");
            return FALSE;
        }
        else{ return TRUE; }
    }
    
    function valid_name($val)
    {
        if ($this->Product_model->valid('name',$val) == FALSE)
        {
            $this->form_validation->set_message('valid_name','Name registered..!');
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validating_name($val)
    {
	$id = $this->session->userdata('langid');
	if ($this->Product_model->validating('name',$val,$id) == FALSE)
        {
            $this->form_validation->set_message('validating_name', "Name registered!");
            return FALSE;
        }
        else{ return TRUE; }
    }
    
    function valid_model($val)
    {
        if ($this->Product_model->valid('model',$val) == FALSE)
        {
            $this->form_validation->set_message('valid_model','Model registered..!');
            return FALSE;
        }
        else{ return TRUE; }
    }

    function validating_model($val)
    {
	$id = $this->session->userdata('langid');
	if ($this->Product_model->validating('model',$val,$id) == FALSE)
        {
            $this->form_validation->set_message('validating_model', "Model registered!");
            return FALSE;
        }
        else{ return TRUE; }
    }

    // Fungsi update untuk mengupdate db
    function update_process($param=0)
    {
        if ($this->acl->otentikasi_admin($this->title) == TRUE){

        $data['title'] = $this->properti['name'].' | Productistrator  '.ucwords($this->modul['title']);
        $data['h2title'] = $this->modul['title'];
        $data['main_view'] = 'product_update';
	$data['form_action'] = site_url($this->title.'/update_process');
	$data['link'] = array('link_back' => anchor('admin/','<span>back</span>', array('class' => 'back')));

	// Form validation
        if ($param == 1)
        {
            $this->form_validation->set_rules('tsku', 'SKU', 'required|callback_validating_sku');
            $this->form_validation->set_rules('ccategory', 'Category', 'required');
            $this->form_validation->set_rules('csupplier', 'Supplier', 'required');
            $this->form_validation->set_rules('tname', 'Product Name', 'required|callback_validating_name');
            $this->form_validation->set_rules('tmodal', 'Modal', 'required|numeric');
            $this->form_validation->set_rules('tprice', 'Price', 'required|numeric');
            $this->form_validation->set_rules('tqty', 'Qty', 'required|numeric|callback_valid_qty');
            $this->form_validation->set_rules('tstart', 'Start Time', 'required|callback_valid_time');
            $this->form_validation->set_rules('tend', 'End Time', 'required');
            $this->form_validation->set_rules('torder', 'Product Order', 'required|numeric');
            $this->form_validation->set_rules('tdesc', 'Description', '');
            
            if ($this->form_validation->run($this) == TRUE)
            {
                // start update 1
                $config['upload_path'] = './images/product/';
                $config['file_name'] = split_space($this->input->post('tname'));
                $config['allowed_types'] = 'jpg|gif|png';
                $config['overwrite'] = true;
                $config['max_size']	= '10000';
                $config['max_width']  = '30000';
                $config['max_height']  = '30000';
                $config['remove_spaces'] = TRUE;

                $this->load->library('upload', $config);
                
                if ($this->input->post('crestrict') == 1){ $start = $this->input->post('tstart'); $end = $this->input->post('tend'); $qty = $this->input->post('tqty');
                }else{ $start = null; $end = null; $qty = 0; }

                if ( !$this->upload->do_upload("userfile")) // if upload failure
                {
                    $info['file_name'] = null;
                    $data['error'] = $this->upload->display_errors();
                    $product = array('name' => strtolower($this->input->post('tname')), 'url_type' => $this->input->post('curl'),
                                     'sku' => $this->input->post('tsku'), 'start' => $start, 'end' => $end, 'qty' => $qty, 
                                     'restricted' => $this->input->post('crestrict'), 'capital' => $this->input->post('tmodal'), 'price' => $this->input->post('tprice'),
                                     'category' => $this->input->post('ccategory'), 'supplier' => $this->input->post('csupplier'),
                                     'description' => $this->input->post('tdesc'), 'orders' => $this->input->post('torder'));
                }
                else
                {
                    $info = $this->upload->data();
                    $this->crop_image($info['file_name']);
                    $product = array('name' => strtolower($this->input->post('tname')), 'url_type' => $this->input->post('curl'),
                                     'sku' => $this->input->post('tsku'), 'start' => $start, 'end' => $end, 'qty' => $qty, 
                                     'restricted' => $this->input->post('crestrict'), 'capital' => $this->input->post('tmodal'), 'price' => $this->input->post('tprice'),
                                     'category' => $this->input->post('ccategory'), 'supplier' => $this->input->post('csupplier'),
                                     'description' => $this->input->post('tdesc'), 'orders' => $this->input->post('torder'),
                                     'image' => $info['file_name']);
                }
                
                $this->Product_model->update($this->session->userdata('langid'), $product);
                $this->session->set_flashdata('message', "One $this->title has successfully updated!");
                redirect($this->title.'/update/'.$this->session->userdata('langid'));
                
                // end update 1
            }
            else{ $this->session->set_flashdata('message', validation_errors());
                  redirect($this->title.'/update/'.$this->session->userdata('langid'));
                }
        }
        }else { echo "error|Sorry, you do not have the right to edit $this->title component..!"; }
    }
        
    function report_process()
    {
        $this->acl->otentikasi2($this->title);
        $data['title'] = $this->properti['name'].' | Report '.ucwords($this->modul['title']);

        $data['rundate'] = tglin(date('Y-m-d'));
        $data['log'] = $this->session->userdata('log');
        $data['category'] = $this->category->get_name($this->input->post('ccategory'));
        $data['model'] = $this->model->get_name($this->input->post('cmodel'));

//        Property Details
        $data['company'] = $this->properti['name'];
        $data['reports'] = $this->Product_model->report($this->input->post('ccategory'), $this->input->post('cmodel'))->result();
        
        if ($this->input->post('ctype') == 0){ $this->load->view('product_report', $data); }
        else { $this->load->view('product_pivot', $data); }
    }
   

}

?>