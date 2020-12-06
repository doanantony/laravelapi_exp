<?php

namespace App\Http\Controllers;

use Validator;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Customers;
use App\Http\Resources\CustomersCollection;
use App\Http\Resources\Customers as CustomersResource;
use App\Http\Controllers\Controller;

class CustomersController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $per_page = (int) $request->query('per_page', 15);

        $collection = new CustomersCollection(customers::paginate($per_page));

        return $collection->additional([
            'status' => 1
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make(
            $request->all(),
            $this->get_rules(),
            $this->get_messages()
        );

        if ($validator->fails()) {

            return response()->json([
                'status' => 0,
                'message' => 'The given data was invalid.',
                'errors' => $validator->errors()->toArray(),
            ], 422);

        }

        // Create new customer
        $now = now();
        $code = $now->year + 
                        $now->month + 
                        $now->day + 
                        $now->hour + 
                        $now->minute + 
                        $now->second + 
                        mt_rand(100, 1100);

        $accounting_code = "AC". $code;
        $subsidiary_code = "SC". $code;

        $customer = Customers::create([
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'accounting_code' => $accounting_code,
            'subsidiary_code' => $subsidiary_code,
            'merchant_account' =>  1
        ]);

        // Store customers programe
        \DB::table('customers_programs')->insert([
            'client_id' => $customer->id,
            'program_id' => $request->input('programe_id'), 
        ]);

        return response()->json([
            'status' => 1,
            'data' => $customer,
        ], 201);

    }

    protected function get_rules()
    {
        
        return [

            'firstname' => [
                'required',
                'regex:/^[a-z0-9\s]+$/i',
                'min:3',
                'max:255',
            ],

            'lastname' => [
                'required',
                'regex:/^[a-z0-9\s]+$/i',
                'min:3',
                'max:255',
            ],           
    
            'email' => [
                'required',
                'email',
                Rule::unique('customers')
            ],
    
            // 'phone' => [
            //    'required',
            //    'phone',
            //     Rule::unique('customers')
            // ],
            
            'programe_id' => [
                'required',
            ],
        ];

    }

    protected function get_messages()
    {

        return [
            'firstname.required' => 'Please provide your first name.',
            'firstname.regex' => 'First Name should only contain letters and numbers.',
            'firstname.min' => 'First Name should be at least 3 characters long',
            'lastname.required' => 'Please provide your last name.',
            'lastname.regex' => 'Last Name should only contain letters and numbers.',
            'lastname.min' => 'Last Name should be at least 3 characters long',
            'email.required' => 'Please provide your email address.',
            'email.email' => 'The email address seems to be invalid.',
            'email.unique' => 'The email address :input is already associated with another customer.',
            'phone.required' => 'Please provide your phone number.',
            'phone.phone' => 'The phone number seems to be invalid.',
            'phone.unique' => 'The phone :input is already associated with another customer.',
            'programe_id.required' => 'Please provider a programe id for this customer',

            
        ];

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $customer_id)
    {   
         
        $customer = Customers::find($customer_id);

        if (is_null($customer)) {

            return response()->json([
                'status' => 0,
                'message' => 'Customers not found'
            ], 404);

        }

        return response()->json([
            'status' => 1,
            'data' => $customer->toArray()
        ], 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
