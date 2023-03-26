<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Array_;
use Symfony\Component\HttpFoundation\ParameterBag;

class SecureRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {

        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 0);

        if ($request->has('to_decrpyt')  && $request->isJson() && ($request->isMethod('POST') || $request->isMethod('PATCH'))) {
            $this->clean($request->json());
            if (isset($request->data)) {
                foreach ($request->data as $key => $data) {
                    $request->merge([$key => $data]);
                }
                unset($request['data']);
                if($request->has('to_decrpyt')){
                    unset($request['to_decrpyt']);
                }
                return $next($request);
            }

            return $next($request);
        } else {
            // $this->clean($request->request);
            return $next($request);
        }
    }

    private function clean(ParameterBag $bag)
    {
        $bag->replace($this->cleanData($bag->all()));
    }

    private function cleanData(array $data)
    {
        $dataToReturn =  collect($data)->map(function ($value, $key) {
            $decodeData = $this->decrypt($value, 'D');
            $decodeData = json_decode($decodeData, true);
            return $decodeData;
        })->all();
        return $dataToReturn;
    }

    private function decrypt($value, $type)
    {
        $output = NULL;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'glL5ZdSE6%To^2EMEsfR2)A1Ca8gNNEd';
        $secret_iv = md5(md5($secret_key, true));
        if ($type == 'E') {
            $key = pack("H*", hash('sha256', $secret_key));
            $iv = substr(pack("H*", hash('sha256', $secret_iv)), 0, 16);
            $output = openssl_encrypt($value, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($type == 'D') {
            $key = hex2bin(hash('sha256', $secret_key));
            $iv = substr(hex2bin(hash('sha256', $secret_iv)), 0, 16);
            $output = openssl_decrypt(base64_decode($value), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
}
