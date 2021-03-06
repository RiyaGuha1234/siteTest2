<?php

namespace App\Http\Controllers;

use App\Models\BillDetail;
use App\Models\CustomVoucher;
use App\Models\Material;
use App\Models\MaterialTransactionDetail;
use App\Models\Person;
use App\Models\OrderDetail;
use App\Models\OrderMaster;
use App\Models\JobMaster;
use App\Models\PaymentCash;
use App\Models\PaymentGold;
use App\Models\User;
use App\Models\UserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Array_;
use PhpParser\Node\Expr\Cast\Object_;
//use function foo\func;

class CustomerController extends Controller
{
    public function index()
    {
//        $query = UserType::find(10)->people
//        $query = Person::select('people.id',
//            'user_name',
//            'user_type_id',
//            'email',
//            'mobile1',
//            'mobile2',
//            'customer_category_id',
//            'address1',
//            'address2',
//            'state',
//            'city',
//            'po',
//            'area',
//            'pin',
//            'opening_balance_LC',
//            'opening_balance_Gold',
//            'mv',
//            'discount'
//            ,'email')
//            ->leftJoin('users', 'users.person_id', '=', 'people.id')
//            ->where('customer_category_id', '!=', 5)
//            ->where('user_type_id', '=', 10)->get();

//        foreach ($query as $user)
//        {
//            $user->passwordk = null;
//        }
        $query = UserType::find(10)->customer;
        return response()->json(['success' => 1, 'data' => $query], 200, [], JSON_NUMERIC_CHECK);
//        $query = Person::select('id',
//            'user_name',
//            'user_type_id',
//            'email',
//            'mobile1',
//            'mobile2',
//            'customer_category_id',
//            'address1',
//            'address2',
//            'state',
//            'city',
//            'po',
//            'area',
//            'pin',
//            'opening_balance_LC',
//            'opening_balance_Gold',
//            'mv',
//            'discount')
//            ->where('user_type_id', '=', 10)
//            ->where('customer_category_id', '!=', 5);
//            ->whereNotIn('customer_category_id',4);

        //to bind the parameters, the above statement does not bind the parameters so we need to bind them
        // using following statement
//        $finalQuery = Str::replaceArray('?', $query->getBindings(), $query->toSql());
//        $result = DB::table(DB::raw("($finalQuery) as table1"))->select()->get();
//        return response()->json(['success' => 1, 'data' => $query], 200, [], JSON_NUMERIC_CHECK);

    }


    public function saveCustomer(Request $request)
    {
        $existingCustomer = Person::select()->where('user_name',$request->input('user_name'))->first();

//        return response()->json(['success'=>1, 'data'=>$test], 200,[],JSON_NUMERIC_CHECK);
////        return $request;
        if($existingCustomer === null) {
            $customer = new Person();
            $customer->user_name = $request->input('user_name');
            $customer->billing_name = $request->input('billing_name');
//        $customer->email = $request->input('email');
//        $customer->password = "81dc9bdb52d04dc20036dbd8313ed055";
//        $customer->user_type_id = $request->input('user_type_id');
            $customer->user_type_id = 10;
            $customer->customer_category_id = $request->input('customer_category_id');
            $customer->mobile1 = $request->input('mobile1');
            $customer->mobile2 = $request->input('mobile2');
            $customer->address1 = $request->input('address1');
            $customer->address2 = $request->input('address2');
            $customer->state = $request->input('state');
            $customer->po = $request->input('po');
            $customer->area = $request->input('area');
            $customer->city = $request->input('city');
            $customer->pin = $request->input('pin');

            if ($request->input('opening_balance_LC')) {
                $customer->opening_balance_LC = $request->input('opening_balance_LC');
            }

            if ($request->input('opening_balance_Gold')) {
                $customer->opening_balance_Gold = $request->input('opening_balance_Gold');
            }

            $customer->mv = $request->input('mv');

            if ($request->input('discount')) {
                $customer->discount = $request->input('discount');
            }

//        if ($request->input('mv')) {
//        $customer->mv = $request->input('mv');
//        }
            $customer->save();

//        if($request->input('email') && $customer){
////            $user = new User();
////            $user->person_id = $customer->id;
////            $user->email = $request->input('email');
////            $user->password = $request->input('password') | md5('1234');
////            $user->save();
////            return response()->json(['success'=>1, 'data'=>$request->input('password')], 200,[],JSON_NUMERIC_CHECK);
//            $user = User::create([
//                'email'    => $request->input('email'),
//                'password' => $request->input('password'),
//                'person_id' => $customer->id,
//            ]);
//            if(!$user){
//                return response()->json(['success'=>0, 'data'=>$user, 'message'=> 'Failed to save data in user'], 200,[],JSON_NUMERIC_CHECK);
//            }
////            $token = $user->createToken('my-app-token')->plainTextToken;
//        }
            return response()->json(['success' => 1, 'data' => $customer], 200, [], JSON_NUMERIC_CHECK);
        }
        else{
            return response()->json(['success' => 0], 200, [], JSON_NUMERIC_CHECK);
        }
    }

    public function updateCustomer($id, Request $request)
    {
        $existingCustomer = Person::select()
            ->where('user_name',$request->input('user_name'))
            ->where('id','<>',$id)
            ->first();
        if($existingCustomer === null){
            $customer = Person::find($id);
            if ($request->input('user_name')) {
                $customer->user_name = $request->input('user_name');
            }
            if ($request->input('billing_name')) {
                $customer->billing_name = $request->input('billing_name');
            }
            if ($request->input('email')) {
                $customer->email = $request->input('email');
            }
            if ($request->input('password')) {
                $customer->password = $request->input('password');
            }

            if ($request->input('user_type_id')) {
                $customer->user_type_id = $request->input('user_type_id');
            }

            if ($request->input('customer_category_id')) {
                $customer->customer_category_id = $request->input('customer_category_id');
            }

            if ($request->input('mobile1')) {
                $customer->mobile1 = $request->input('mobile1');
            }

            if ($request->input('mobile2')) {
                $customer->mobile2 = $request->input('mobile2');
            }

            if ($request->input('address1')) {
                $customer->address1 = $request->input('address1');
            }

            if ($request->input('address2')) {
                $customer->address2 = $request->input('address2');
            }

            if ($request->input('state')) {
                $customer->state = $request->input('state');
            }

            if ($request->input('po')) {
                $customer->po = $request->input('po');
            }

            if ($request->input('area')) {
                $customer->area = $request->input('area');
            }

            if ($request->input('city')) {
                $customer->city = $request->input('city');
            }

            if ($request->input('pin')) {
                $customer->pin = $request->input('pin');
            }
            if ($request->input('mv')) {
                $customer->mv = $request->input('mv');
            }
            $customer->save();
            return response()->json(['success' => 1, 'data' => $customer], 200, [], JSON_NUMERIC_CHECK);

        }
        else{
            return response()->json(['success' => 0], 200, [], JSON_NUMERIC_CHECK);
        }


    }

    public function deleteCustomer($id)
    {
        $res = Person::destroy($id);
        if ($res) {
            return response()->json(['success' => 1, 'message' => 'Deleted'], 200, [], JSON_NUMERIC_CHECK);
        } else {
            return response(o)->json(['success' => 0, 'data' => 'Not Deleted'], 200, [], JSON_NUMERIC_CHECK);
        }
    }

    public function getKarigarhs()
    {
        $result = Person::select('id', 'user_name')->where('user_type_id', '=', 11)->get();
        return response()->json(['success' => 1, 'data' => $result], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getGoldquantity()
    {
        $result = OrderMaster::select('users.user_name', 'users.id')
            ->join('users', 'order_masters.person_id', '=', 'users.id')
            ->join('order_details', 'order_details.order_master_id', '=', 'order_masters.id')
            ->where('order_details.bill_created','=',0)
            ->where('order_details.status_id','=',100)
            ->distinct()
            ->get();
        return response()->json(['success' => 1, 'data' => $result], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getDetails(Request $request)
    {
        $input = ($request->json()->all());
        $data = OrderMaster::select(DB::raw(" distinct order_masters.order_number"), 'order_masters.id', 'people.user_name')
            ->join('order_details', 'order_details.order_master_id', '=', 'order_masters.id')
            ->join('job_masters', 'job_masters.order_details_id', '=', 'order_details.id')
            ->join('people', 'order_masters.person_id', '=', 'people.id')
            ->where('order_details.bill_created','=',0)
            ->where('order_masters.person_id', '=', $input)
            ->get();
        return response()->json(['success' => 1, 'data' => $data], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getCompletedBIllDetails(Request $request)
    {
        $input = ($request->json()->all());
        $data = OrderMaster::select(DB::raw(" distinct order_masters.order_number"), 'order_masters.id', 'people.user_name')
            ->join('order_details', 'order_details.order_master_id', '=', 'order_masters.id')
            ->join('job_masters', 'job_masters.order_details_id', '=', 'order_details.id')
            ->join('people', 'order_masters.person_id', '=', 'people.id')
            ->where('order_details.bill_created','=',1)
            ->where('order_masters.person_id', '=', $input)
            ->get();
        return response()->json(['success' => 1, 'data' => $data], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getFinishedJobData(Request $request)
    {
        $input = ($request->json()->all());
        $data = JobMaster::select(DB::raw('order_masters.id as order_master_id'),'rates.price','products.model_number', DB::raw('karigarh.user_name as karigarh_name'), DB::raw('people.id as customer_id'), DB::raw('karigarh.id as karigarh_id'),'people.mv','people.customer_category_id', 'order_masters.order_number', 'order_masters.date_of_order', 'order_masters.agent_id','job_masters.gross_weight', 'products.model_number', 'order_details.size', 'order_details.quantity','order_details.material_id', 'order_details.price','order_details.discount','order_masters.date_of_order', 'job_masters.job_number', 'people.user_name','people.billing_name', 'people.address1', 'people.mobile1', 'people.state', 'people.po', 'people.area', 'people.city', 'people.pin', 'job_masters.id','job_masters.status_id', DB::raw("if(job_masters.status_id = 100,'COMPLETED',if(job_masters.status_id = 102,'STOCK CREATED','WORK IN PROGRESS')) as status"))
            ->join('people as karigarh', 'job_masters.karigarh_id', '=', 'karigarh.id')
            ->join('order_details', 'job_masters.order_details_id', '=', 'order_details.id')
            ->join('order_masters', 'order_details.order_master_id', '=', 'order_masters.id')
            ->join('products', 'order_details.product_id', '=', 'products.id')
            ->join('people', 'order_masters.person_id', '=', 'people.id')
            ->join('rates', function($join){
                $join->on('rates.price_code_id', '=', 'products.price_code_id');
                $join->on('rates.customer_category_id','=', 'people.customer_category_id');
            })
//            ->where('job_masters.bill_created','=',0)
            ->where('job_masters.bill_created','=',0)
            ->where('order_masters.id', '=', $input)
            ->get();
        return response()->json(['success' => 1, 'data' => $data], 200, [], JSON_NUMERIC_CHECK);
    }


//    public function showCompletedBills($id)
//    {
//        $input = ($request->json()->all());
//        $data = JobMaster::select('bill_masters.bill_number','bill_masters.bill_date',DB::raw('order_masters.id as order_master_id'), DB::raw('karigarh.user_name as karigarh_name'), DB::raw('users.id as customer_id'), DB::raw('karigarh.id as karigarh_id'), 'order_masters.order_number', 'order_masters.date_of_order', 'job_masters.gross_weight', 'products.model_number', 'order_details.size', 'order_details.quantity', 'order_details.price','order_masters.date_of_order', 'job_masters.job_number', 'users.user_name', 'users.address1', 'users.mobile1', 'users.state', 'users.po', 'users.area', 'users.city', 'users.pin', 'job_masters.id', DB::raw("if(order_details.status_id = 100,'COMPLETED',if(order_details.status_id = 40,'NOT STARTED','WORK IN PROGRESS')) as status"))
//            ->join('users as karigarh', 'job_masters.karigarh_id', '=', 'karigarh.id')
//            ->join('order_details', 'job_masters.order_details_id', '=', 'order_details.id')
//            ->join('order_masters', 'order_details.order_master_id', '=', 'order_masters.id')
//            ->join('bill_masters', 'bill_masters.order_master_id', '=', 'order_masters.id')
//            ->join('products', 'order_details.product_id', '=', 'products.id')
//            ->join('users', 'order_masters.person_id', '=', 'users.id')
////            ->join('bill_details', 'bill_details.bill_master_id', '=', 'bill_masters.id')
//            ->where('job_masters.bill_created','=',1)
//            ->where('bill_masters.id', '=', 1)
////            ->where('bill_details.bill_master_id', '=', 1)
//            ->get();



//        $data = BillDetail::select('bill_masters.bill_number','bill_masters.bill_date',DB::raw('order_masters.id as order_master_id'), DB::raw('karigarh.user_name as karigarh_name'), DB::raw('users.id as customer_id'), DB::raw('karigarh.id as karigarh_id'), 'order_masters.order_number', 'order_masters.date_of_order', 'job_masters.gross_weight', 'products.model_number', 'order_details.size', 'order_details.quantity', 'order_details.price','order_masters.date_of_order', 'job_masters.job_number', 'users.user_name', 'users.address1', 'users.mobile1', 'users.state', 'users.po', 'users.area', 'users.city', 'users.pin', 'job_masters.id', DB::raw("if(order_details.status_id = 100,'COMPLETED',if(order_details.status_id = 40,'NOT STARTED','WORK IN PROGRESS')) as status"))
//        $data = BillDetail::select()
//            ->join('bill_masters', 'bill_masters.id', '=', 'bill_details.bill_master_id')
//            ->join('job_masters', 'job_masters.id', '=', 'bill_details.job_master_id')
//            ->join('users as karigarh', 'job_masters.karigarh_id', '=', 'karigarh.id')
//            ->join('order_details', 'order_details.id', '=', 'job_masters.order_details_id')
////            ->join('products', 'order_details.product_id', '=', 'products.id')
//            ->join('order_masters', 'order_masters.id', '=', 'order_details.order_master_id')
//            ->join('users', 'users.id', '=', 'order_masters.person_id')
//
//            ->where('bill_masters.id', '=', $input)
////            ->where('bill_details.bill_master_id', '=', 1)
//            ->get();


//        return response()->json(['success' => 1, 'data' => $data], 200, [], JSON_NUMERIC_CHECK);
//    }


    public function getGoldQuantityBill($id)
    {
        $result=DB::query()->fromSub(function ($query) use($id){
            $query->from("job_details")
                ->select(DB::raw("SUM(if(material_quantity>0,material_quantity,0)) as positive_value, SUM(if(material_quantity<0,material_quantity,0)) as negative_value"))
                ->where("job_details.job_task_id",1)
                ->where("job_details.job_master_id",$id)
                ->orWhere("job_details.job_task_id",2)
                ->where("job_details.job_master_id",$id);
        },"table1")->select("table1.positive_value","table1.negative_value",DB::raw("abs(table1.positive_value + table1.negative_value) as total"))
            ->get();
        return response()->json(['success' => 1, 'data' => $result], 200, [], JSON_NUMERIC_CHECK);
    }

    public function finishedJobsCustomers()
    {
        $result = OrderMaster::select('people.user_name', 'people.id')
            ->join('people', 'order_masters.person_id', '=', 'people.id')
            ->join('order_details', 'order_details.order_master_id', '=', 'order_masters.id')
            ->where('order_details.bill_created','=',0)
            ->where('order_details.status_id','=',100)
            ->distinct()
            ->get();
        return response()->json(['success' => 1, 'data' => $result], 200, [], JSON_NUMERIC_CHECK);
    }

    public function completedBillCustomers()
    {
        $result = OrderMaster::select('people.user_name', 'people.id')
            ->join('people', 'order_masters.person_id', '=', 'people.id')
            ->join('bill_masters', 'bill_masters.order_master_id', '=', 'order_masters.id')
            ->join('order_details', 'order_details.order_master_id', '=', 'order_masters.id')
            ->where('order_details.bill_created','=',1)
            ->where('order_details.status_id','=',100)
            ->distinct()
            ->get();
        return response()->json(['success' => 1, 'data' => $result], 200, [], JSON_NUMERIC_CHECK);
    }

    public function getTotalGoldQuantity($id)
    {
        $totalGold = DB::select('SELECT get_gold_quantity(?) AS data',[$id])[0];
        return response()->json(['success'=>1,'data'=>$totalGold],200,[], JSON_NUMERIC_CHECK);
    }

    public function showCompletedBills($id){
        $data = BillDetail::select('people.id','bill_details.bill_master_id','bill_details.job_master_id','bill_details.tag'
            ,'bill_details.model_number','bill_details.size','bill_details.gross_weight','bill_details.material_id',
            'bill_details.ginnie','bill_details.rate','bill_details.pure_gold','bill_details.quantity','bill_details.mv'
            ,'bill_masters.bill_number','bill_masters.bill_date','bill_masters.order_master_id','bill_masters.agent_id'
            ,'order_details.discount',DB::raw("bill_masters.discount as discount_amount"),'job_masters.job_number','people.user_name','people.billing_name','people.address1','people.address2'
            ,'people.state','people.po','people.area','people.city','people.pin','order_masters.date_of_order','order_masters.order_number')
                ->join('bill_masters', 'bill_masters.id', '=', 'bill_details.bill_master_id')
                ->join('job_masters', 'job_masters.id', '=', 'bill_details.job_master_id')
                ->join('people as karigarh', 'job_masters.karigarh_id', '=', 'karigarh.id')
                ->join('order_details', 'order_details.id', '=', 'job_masters.order_details_id')
                ->join('order_masters', 'order_masters.id', '=', 'order_details.order_master_id')
                ->join('people', 'people.id', '=', 'order_masters.person_id')
                ->where('bill_details.bill_master_id',$id)
                ->get();
        return response()->json(['success'=>1,'data'=>$data],200,[],JSON_NUMERIC_CHECK);
    }


//    public function getFinishedJobData(Request $request)
//    {
//        $input = ($request->json()->all());
//        $data = JobMaster::select(DB::raw('order_masters.id as order_master_id'),'rates.price', DB::raw('karigarh.user_name as karigarh_name'), DB::raw('people.id as customer_id'), DB::raw('karigarh.id as karigarh_id'),'users.mv','users.customer_category_id', 'order_masters.order_number', 'order_masters.date_of_order', 'order_masters.agent_id','job_masters.gross_weight', 'products.model_number', 'order_details.size', 'order_details.quantity','order_details.material_id', 'order_details.price','order_details.discount','order_masters.date_of_order', 'job_masters.job_number', 'users.user_name', 'users.address1', 'users.mobile1', 'rates.customer_category_id','users.state', 'users.po', 'users.area', 'users.city', 'users.pin', 'job_masters.id','job_masters.status_id', DB::raw("if(job_masters.status_id = 100,'COMPLETED',if(job_masters.status_id = 102,'STOCK CREATED','WORK IN PROGRESS')) as status"))
//            ->join('users as karigarh', 'job_masters.karigarh_id', '=', 'karigarh.id')
//            ->join('order_details', 'job_masters.order_details_id', '=', 'order_details.id')
//            ->join('order_masters', 'order_details.order_master_id', '=', 'order_masters.id')
//            ->join('products', 'order_details.product_id', '=', 'products.id')
//            ->join('users', 'order_masters.person_id', '=', 'users.id')
//            ->join('rates', 'products.price_code_id','=','rates.price_code_id')
//            ->where('rates.customer_category_id ','=','users.customer_category_id')
//            ->where('job_masters.bill_created','=',0)
//            ->where('order_masters.id', '=', $input)
//            ->get();
//        return response()->json(['success' => 1, 'data' => $data], 200, [], JSON_NUMERIC_CHECK);
//    }

  public function getEmployeeMaterial(){

        $test1 =  Person::select('id','Person_name')
                 ->where('Person_type_id','!=',9)
                 ->where('Person_type_id','!=',10)
                 ->get();


        $test2 = Material::select('id','material_name')
                 ->where('main_material_id',0)
                 ->get();

        $newArray = [];
        for($i=0; $i<count($test1); $i++){
            for($j=0; $j<count($test2); $j++){
                $result=DB::select('SELECT get_employee_balance(?,?) as employee_balance,? as material_name, ? as Person_name',array($i,$test2[$j]->id,$test2[$j]->material_name,$test1[$i]->user_name))[0];
                array_push($newArray,$result);
            }
        }

//        $result=DB::select('SELECT get_employee_balance(?,?)',array(1,1));


        return response()->json(['success' => 1, 'data' => $newArray], 200, [], JSON_NUMERIC_CHECK);

  }
  public function testGetEmployeeMaterial(){

        $result = DB::table('people')
                ->select('people.id','people.user_name','materials.material_name','people.user_type_id',DB::raw("get_employee_balance(people.id, materials.id) as employee_balance"))
                ->crossJoin('materials')
                ->where('people.user_type_id','<>',9)
                ->where('people.user_type_id','<>',10)
                ->where('materials.main_material_id',0)
                ->get();



        return response()->json(['success' => 1, 'data' => $result], 200, [], JSON_NUMERIC_CHECK);
  }

//    public function getEmployeeStock()
//    {
//
//        $test1 = Person::select('id', 'user_name')
//            ->where('user_type_id', '!=', 9)
//            ->where('user_type_id', '!=', 10)
//            ->get();
//
//
//        $test2 = Material::select('id', 'material_name')
//            ->where('main_material_id', 0)
//            ->get();
//
//
//        $employeeArray = [];
//
//        for ($i = 0; $i < count($test1); $i++) {
//            $stockArray = [];
//            for ($j = 0; $j < count($test2); $j++) {
////                $result = DB::select('SELECT get_employee_balance(?,?) as employee_balance,? as material_name, ? as user_name',  array($i, $test2[$j]->id, $test2[$j]->material_name, $test1[$i]->user_name))[0];
//                $result = DB::select('SELECT get_employee_balance(?,?) as employee_balance,? as material_name, ? as user_name',  array($test1[$i]->id, $test2[$j]->id, $test2[$j]->material_name, $test1[$i]->user_name))[0];
//                array_push($stockArray, $result);
//
//            }
//
//            $employeeStock =  (object) array("user_name"=> $test1[$i]->user_name,
//                                    "Pure_gold"=> $stockArray[0]->employee_balance,
//                                    "Pure_silver"=>$stockArray[1]->employee_balance,
//                                    "ginnie_92"=>$stockArray[2]->employee_balance,
//                                    "Pan"=>$stockArray[3]->employee_balance,
//                                    "ginnie_90"=>$stockArray[4]->employee_balance,
//                                    "Dal"=>$stockArray[5]->employee_balance,
//                                    "Nitric"=>$stockArray[6]->employee_balance,
//                                    "Production_dust"=>$stockArray[7]->employee_balance
//                             );
////
////            $employeeStock =  (object) array("user_name"=> $test1[$i]->user_name,
////                                    $stockArray[0]->material_name=>$stockArray[0]->employee_balance,
////                                    $stockArray[1]->material_name=>$stockArray[1]->employee_balance,
////                                    $stockArray[2]->material_name=>$stockArray[2]->employee_balance,
////                                    $stockArray[3]->material_name=>$stockArray[3]->employee_balance,
////                                    $stockArray[4]->material_name=>$stockArray[4]->employee_balance,
////                                    $stockArray[5]->material_name=>$stockArray[5]->employee_balance,
////                                    $stockArray[6]->material_name=>$stockArray[6]->employee_balance,
////                                    $stockArray[7]->material_name=>$stockArray[7]->employee_balance
////                            );
//
////            $resultNew = (object)$employeeStock;
//            array_push($employeeArray, $employeeStock);
//        }
//
//        return response()->json(['success' => 500, 'data' => $employeeArray], 200, [], JSON_NUMERIC_CHECK);
//    }



    public function getEmployeeStock($id)
    {

//        $test1 = Person::select('id', 'user_name')
//            ->where('user_type_id', '!=', 9)
//            ->where('user_type_id', '!=', 10)
//            ->get();

        $test1 = Person::find($id);


        $test2 = Material::select('id', 'material_name')
            ->where('main_material_id', 0)
            ->get();


        $employeeArray = [];

//        for ($i = 0; $i < count($test1); $i++) {
            $stockArray = [];
            for ($j = 0; $j < count($test2); $j++) {
//                $result = DB::select('SELECT get_employee_balance(?,?) as employee_balance,? as material_name, ? as user_name',  array($i, $test2[$j]->id, $test2[$j]->material_name, $test1[$i]->user_name))[0];
                $result = DB::select('SELECT get_employee_balance(?,?) as employee_balance,? as material_name, ? as user_name',  array($test1->id, $test2[$j]->id, $test2[$j]->material_name, $test1->user_name))[0];
                array_push($stockArray, $result);

            }

            $employeeStock =  (object) array("user_name"=> $test1->user_name,
                "Pure_gold"=> $stockArray[0]->employee_balance,
                "Pure_silver"=>$stockArray[1]->employee_balance,
                "ginnie_92"=>$stockArray[2]->employee_balance,
                "Pan"=>$stockArray[3]->employee_balance,
                "ginnie_90"=>$stockArray[4]->employee_balance,
                "Dal"=>$stockArray[5]->employee_balance,
                "Nitric"=>$stockArray[6]->employee_balance,
                "Production_dust"=>$stockArray[7]->employee_balance
            );
//
//            $employeeStock =  (object) array("user_name"=> $test1[$i]->user_name,
//                                    $stockArray[0]->material_name=>$stockArray[0]->employee_balance,
//                                    $stockArray[1]->material_name=>$stockArray[1]->employee_balance,
//                                    $stockArray[2]->material_name=>$stockArray[2]->employee_balance,
//                                    $stockArray[3]->material_name=>$stockArray[3]->employee_balance,
//                                    $stockArray[4]->material_name=>$stockArray[4]->employee_balance,
//                                    $stockArray[5]->material_name=>$stockArray[5]->employee_balance,
//                                    $stockArray[6]->material_name=>$stockArray[6]->employee_balance,
//                                    $stockArray[7]->material_name=>$stockArray[7]->employee_balance
//                            );

//            $resultNew = (object)$employeeStock;
            array_push($employeeArray, $employeeStock);
//        }

        return response()->json(['success' => 1, 'data' => $employeeArray], 200, [], JSON_NUMERIC_CHECK);
    }

    public function employeeTransactionTest($id){

        $data1 = MaterialTransactionDetail::select('transaction_masters_id')
                 ->where('employee_id',$id)
                 ->get();

        $result= [];
        for($i=0;$i<count($data1);$i++){
            $queryResult = DB::select('call employeeTransaction(?,?)', [$id,$data1[$i]->transaction_masters_id])[0];
            array_push($result,$queryResult);
        }

        return response()->json(['success' => 200, 'data' => $result], 200, [], JSON_NUMERIC_CHECK);
    }

//    public function CustomerTransactionTest($id){
//
//        $testLC = [];
//
//        $data1 = (array) DB::table('users')
//                 ->select('users.opening_balance_LC as cash_received','users.opening_balance_Gold as gold_received','users.created_at' ,DB::raw("if(users.opening_balance_Gold,'Opening Balance','Opening Balance') as statement"))
//                 ->where('id',$id)
//                 ->get()[0];
//
//        array_push($testLC,$data1);
//
//        $data2 =   BillDetail::select('bill_masters.id','bill_masters.created_at',DB::raw("sum(bill_details.quantity * bill_details.rate) as cash_received"),DB::raw("sum(bill_details.pure_gold) as  gold_received"),DB::raw("if(sum(bill_details.quantity * bill_details.rate),'Billed','--') as statement"))
//                  ->join('bill_masters','bill_masters.id','=','bill_details.bill_master_id')
//                  ->where('bill_masters.customer_id',$id)
//                  ->groupBy('bill_masters.id')
//                  ->get();
//        for($i=0;$i<count($data2);$i++) {
//
//            array_push($testLC,$data2[$i]);
//        }
//        $data3 =  PaymentCash::select('payment_cashes.cash_received','payment_cashes.created_at' ,DB::raw("if(payment_cashes.cash_received,'--',0) as gold_received"),DB::raw("if(payment_cashes.cash_received,'Received','--') as statement"))
//                  ->where('person_id',$id)
//                  ->get();
//
//        $data4 =  PaymentGold::select('payment_gold.gold_received','payment_gold.created_at',DB::raw("if(payment_gold.gold_received,'--',0) as cash_received"),DB::raw("if(payment_gold.gold_received,'Received','--') as statement"))
//                  ->where('person_id',$id)
//                  ->get();
//
//        for($i=0;$i<count($data3);$i++) {
//
//            array_push($testLC,$data3[$i]);
//        }
//
//        for($i=0;$i<count($data4);$i++) {
//
//            array_push($testLC,$data4[$i]);
//
//        }
//        $date = array();
//        foreach ($testLC as $key => $row)
//        {
//            $date[$key] = $row['created_at'];
//        }
//        array_multisort($date, SORT_ASC, $testLC, SORT_NUMERIC);
//
//
//        return response()->json(['success' =>100, 'data' => $testLC], 200, [], JSON_NUMERIC_CHECK);
//
//    }


    public function CustomerTransactionTest($id){

        $testLC = [];
        $LC_balance=0 ;
        $gold_balance=0 ;
//
//        $data1 = (array) DB::table('users')
////        $data1 = User::
//            ->select('users.opening_balance_LC as cash_received','users.opening_balance_Gold as gold_received','users.opening_balance_LC as LC_balance','users.opening_balance_Gold as gold_balance','users.created_at' ,DB::raw("if(users.opening_balance_Gold,'Opening Balance','Opening Balance') as statement"))
////            select(DB::raw("users.opening_balance_LC as cash_received"),DB::raw("users.opening_balance_Gold as gold_received"),'users.created_at' ,DB::raw("if(users.opening_balance_Gold,'Opening Balance','Opening Balance') as statement"))
//            ->where('users.id',$id)
//            ->first();

        $data1 = (array) DB::table('people')
            ->select('people.opening_balance_LC as cash_received','people.opening_balance_Gold as gold_received','people.created_at','people.opening_balance_LC as LC_balance','people.opening_balance_Gold as gold_balance' ,DB::raw("if(people.opening_balance_Gold,'Opening Balance','Opening Balance') as statement"),DB::raw("if(people.opening_balance_Gold,'--','--') as reference_number"))
            ->where('id',$id)
            ->first();

        array_push($testLC,$data1);

        $data2 =   BillDetail::select('bill_masters.id','bill_masters.created_at',DB::raw("bill_masters.bill_number as reference_number"),DB::raw("sum(bill_details.quantity * bill_details.rate) - bill_masters.discount as cash_received"),DB::raw("sum(bill_details.pure_gold) as  gold_received"),DB::raw("if(sum(bill_details.quantity * bill_details.rate),'Billed','--') as statement"))
            ->join('bill_masters','bill_masters.id','=','bill_details.bill_master_id')
            ->where('bill_masters.customer_id',$id)
            ->groupBy('bill_masters.id')
            ->get();

        for($i=0;$i<count($data2);$i++) {

            array_push($testLC,$data2[$i]);
        }
        $data3 =  PaymentCash::select('payment_cashes.cash_received','payment_cashes.created_at',DB::raw("payment_cashes.transaction_id as reference_number") ,DB::raw("if(payment_cashes.cash_received,'--',0) as gold_received"),DB::raw("if(payment_cashes.cash_received,'Received','--') as statement"))
            ->where('person_id',$id)
            ->get();

        $data4 =  PaymentGold::select('payment_gold.gold_received','payment_gold.created_at',DB::raw("payment_gold.transaction_id as reference_number") ,DB::raw("if(payment_gold.gold_received,'--',0) as cash_received"),DB::raw("if(payment_gold.gold_received,'Received','--') as statement"))
            ->where('person_id',$id)
            ->get();

        for($i=0;$i<count($data3);$i++) {

            array_push($testLC,$data3[$i]);
        }

        for($i=0;$i<count($data4);$i++) {

            array_push($testLC,$data4[$i]);

        }
        $date = array();
        foreach ($testLC as $key => $row)
        {
            $date[$key] = $row['created_at'];
        }
        array_multisort($date, SORT_ASC, $testLC, SORT_NUMERIC);

       foreach ($testLC as $value){
           if($value['statement'] == 'Opening Balance')
           {
                $LC_balance = $value['LC_balance'];
                $gold_balance  = $value['gold_balance'];
//                $value['LC_balance'] = $value['cash_received'];
//                $value['gold_balance'] = $value['gold_received'];

           }
           elseif($value['statement'] == 'Billed')
           {
               $LC_balance = $LC_balance + $value['cash_received'];
               $gold_balance = $gold_balance +  $value['gold_received'];

               $value['LC_balance'] = $LC_balance ;
               $value['gold_balance'] =  $gold_balance ;
//               return $testLC;
           }
           else
           {
               if($value['cash_received'] != '--')
               {
                   $LC_balance = $LC_balance - $value['cash_received'];
                   $value['LC_balance'] = $LC_balance ;
                   $value['gold_balance'] =  $gold_balance ;
               }
               else
               {
                   $gold_balance = $gold_balance - $value['gold_received'];
                   $value['gold_balance'] =  $gold_balance ;
                   $value['LC_balance'] = $LC_balance;
               }

           }

       }

       return response()->json(['success' =>200, 'data' => $testLC], 200, [], JSON_NUMERIC_CHECK);

    }

    public  function  joinTest(){

        //type-1
        $result = User::select()
                  ->join('bill_masters','bill_masters.customer_id','=','people.id')
                  ->get();
        return response()->json(['success'=>300,'result'=>$result],200,[],JSON_NUMERIC_CHECK);

        //type-2

        $result1 = User::select()
                   ->join('customer_categories',function ($join){
                      $join->on('customer_categories.id','=','people.customer_category_id') ;
                   })
                   ->get();

        //type-3

        $result2 = DB::table('people')
                   ->select()
                   ->join('customer_categories','customer_categories.id','=','people.customer_category_id')
                   ->get();

        //type-4

        $result3=DB::table('people')
                 ->join('customer_categories',function($join){
                     $join->on('customer_categories.id','=','people.customer_category_id');
                })
                ->get();

        return response()->json(['success'=>300,'result'=>$result3],200,[],JSON_NUMERIC_CHECK);
    }

    public function testModel(){
     $test = ['New York','US','UK','prtugl','Russ'];
     foreach ($test as $item){
         print_r($item);
         print_r('</br>');
     }



    }

    function getEmployees(){
        $result = Person::select('users.id','users.person_id','people.user_name')
                  ->join('users','users.person_id','=','people.id')
                  ->get();

        return response()->json(['success'=>1,'data'=>$result], 200,[],JSON_NUMERIC_CHECK);
    }


}
