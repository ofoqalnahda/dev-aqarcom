<?php

namespace App\Http\Controllers;
use App\Models\User;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use UnexpectedValueException;

class NafathController extends Controller
{
    private $is_test = false;

    private $stg_key = [
        "kty"=> "RSA",
        "e"=> "AQAB",
        "use"=> "sig",
        "kid"=> "elm",
        "alg"=> "RS256",
        "n"=> "t7XTT2MemdyhJfod_maQUklmw2iCF0CzXDaJyZLYDXyrfUJb5FCq4sl3cZTB9GlxRLQU13Cw7hkf22lAlIU193uRGYHGNXMwlFL1BlEBfspM9PAQW9wSWVQXlcYMWLryNMtRjx3gsk5YgOwJoMwjqzIVcqyu6zMM1jTMs8xJ4fOgq-3TQg3koGQT_j2vK9V4vmrrQ1h86y--l4aBHFCgqvowB1lG5qN6hQ7xzz8t94oW_lHbyF2U9DqcrF8vdhKcqAJvC8Bce9LiwHCsmyK_6YCB1AXZRwRkG9MnWPtO6l5ufsVf3C3oBzfUzYjJ7FZyVpRTFVpRCr8xqUd2E6pF_w"
    ];

    private $prod_key = [
        "kty"=> "RSA",
        "e"=> "AQAB",
        "use"=> "sig",
        "kid"=> "elm",
        "alg"=> "RS256",
        "n"=> "pVXsvUMjiBWnbdmzpLF7OUNXfFF-AXKuwuui6dzUSZgg4hTyG_-OLePOCMAM8jxf_FNriZVt_DHK4nInLNP9pCoAXaaL6yaneG_NYXUIqGR3SoZgVUdV3saVSGpuwRCS0JksZ_2DslMnrrYxQORfUjnzWaAwnXHuowlCjaczjTRYiDBhOvj-ozw6sFg96x9MV-0Ou0TIPrRn5Z1LUykIOGvk5IOkuMQtnVO6mcAdWjf0pWp71E2oaDWkUawTyLzTti3k7SHHiQpi_3x-3vMiZNpLbyHL3pdOxxZK0vKO8HCxiR0WUt_JO1RNV-8p0XKNKXA9eBbFi8_uEb_BFZIoCw"
    ];

    private $natath = [
        "test_url_request"=>"https://nafath.api.elm.sa/stg/api/v1/mfa/request",
        "url_request"=>"https://nafath.api.elm.sa/api/v1/mfa/request"
    ];

    public function nafathCallback(){
        Log::info("nafathCallback Step #1");
        $data = request()->all();
        $res = $this->verify($data['token'], $this->prod_key);
        return $this->return_response($data,$res);

    }
    public function testNafathCallback(){
        $data = request()->all();
        $res = $this->verify($data['token'], $this->stg_key);
        return $this->return_response($data,$res);

    }

    private function return_response($data,$res)
    {
        Log::info("return_response Step #1");
        Log::info(["data"=>$data,"res"=>$res,"object"=>is_object($res),"array"=>is_array($res)]);
        if($res instanceof \stdClass)
            $res = json_decode(json_encode($res), true);
        Log::info("return_response Step #2");
        Log::info(["object"=>is_object($res),"array"=>is_array($res)]);
        if(!is_array($res) || !$res['transId']){
            Log::info("return_response Step #3");
            Log::info(json_encode(
                    ["error"=>[
                        "يسطا مش موجوده في الاراي",
                        !is_array($res),
                        $res,
                        $res instanceof \stdClass,
                    ]
                    ]
                )
            );
            return response()->json(['message' => 'failed', 'data' => $res]);
        }

        $user = User::where("transId",$res['transId'])->first();

        if(!$user){
            Log::info("return_response Step #4");
            Log::info(["يسطا مش موجوده في الداتا بيز",$res['transId']]);
            return response()->json(['message' => 'failed', 'data' => "transId not found"]);
        }

        if($res['status'] == "COMPLETED"){
            $user->update([
                'is_nafath_verified' => true,
            ]);
        }
        Log::info("return_response Step #5");
        Log::info(["stage"=>"final","res"=>$res]);
        return response()->json(['message' => 'success', 'data' => $res]);
    }

    private function verify(string $jwt, array $key)
    {
        $keys =[
            'keys' =>[
                $key
            ]
        ];

        try{
            return JWT::decode($jwt, JWK::parseKeySet($keys));
        }catch (ExpiredException $e){
            return "Expired Token";
        }catch (SignatureInvalidException $e) {
            return "Invalid Token";
        }catch (UnexpectedValueException $e) {
            return "Invalid JWK";
        }
    }

    public function send_request(Request $request)
    {
        $data = $request->validate([
            'name' => 'required_if:identity_type,2|required_if:identity_type,3',
            'unified_number' => 'required_if:identity_type,2|required_if:identity_type,3',
            'nationalId' => 'required|string|size:10|starts_with:1|unique:users,identity_number,'.auth()->id(),
            'identity_type' => 'required|in:1,2,3',
        ],[
            'nationalId.unique' => __('already_nafath_verified'),
            'nationalId.starts_with' => __('national_id_starts_with'),
            'nationalId.size' => __('national_id_size'),

        ]);

        $data = [
            'nationalId' => $data['nationalId'],
            "service"=>"RecipientApprovalWithoutBio"
        ];
        $params = [
            "local"=>app()->getLocale(),
            "requestId"=>uuid_create(),
        ];

        try{
            $res = Http::withHeaders([
                    "APP-ID"=> $this->is_test ? env("NAFATH_TEST_APP_ID") : env("NAFATH_APP_ID"),
                    "APP-KEY"=> $this->is_test ? env("NAFATH_TEST_APP_KEY") : env("NAFATH_APP_KEY"),
                    "Content-Type"=>"application/json",
                    "Accept"=>"application/json",
                ])->post(
                    $this->natath[ $this->is_test?'test_url_request':'url_request']."?".http_build_query($params),
                    $data
                );
                Log::info("nafath send_request");
                Log::info(["data"=>$data,"params"=>$params,"res"=>$res->json()]);
                if($res->failed())
                    return response()->json(['message' => 'failed','error'=>$res->json()['message'], 'data' => null]);
        
                auth()->user()->update([
                    'identity_type' => $request->identity_type??1,
                    'identity_number' => $data['nationalId'],
                    'unified_number' => $request->unified_number,
                    'name' => $request->name,
                    'transId' => $res->json()['transId'],
                    'requestId' => $params['requestId']
                ]);
            return response()->json(['message' => 'success', 'data' => $res->json()]); 
        }catch (\Exception $e){
             return response()->json(['message' => 'failed','error'=>__('eror_nfaz'), 'data' => null]);
        
        }
               

    }


    public function nafath_status(){
        return response()->json(['message' => 'success', 'status' => auth()->user()->is_nafath_verified]);
    }

}
