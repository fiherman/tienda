<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class PdfController extends Controller
{
    
    public function invoice($id) 
    {
        
        $Html="<html><title>ESTADO DE CTA</title>";         
        $Html.="<style>
                    .table_cab { border-collapse: separate;  border-spacing:  -1px; border-style: hidden;margin-left:10px }
                    .table_cab tr td{ border:1px solid #000000; font-size: 14px;  }
                    .table_trat{ font-size: 12px;margin-left:10px}
                    #cabesera{font-size: 14px;}
                    
                    #header { position: fixed; left: 10px; top: -50px; right: 0px; height: 20px; background-color: white; text-align: center; }
                    #footer { position: fixed; left: 10px; bottom: -50px; right: 0px; height: 50px; background-color: white; font-family:arial, helvetica; font-size:12px; font-size:12px;text-align: right; }
                    @page {margin-top: 80px; margin-left: 2.0em;}
                    #header .page:after { content: counter(page, arial); }
                 </style>";         
         $Html.="<div id='header'>   
                    <table width=100%><tr>
                            <td width=80px> <img style='margin-left:0px;width:130px' src='http://".$_SERVER["SERVER_NAME"]."/tienda/public/images/x.png'/><td>                            
                            <td width=400px><span style='margin-left:15%;font-size: 16px;text-decoration: underline;color:#FF0000'>ESTADO DE CUENTA DEL PACIENTE</span><td>
                            <td width=80px><span class='page'><br>N&deg;Pag: </span><td></tr>
                    </table>                                 
                 </div>                 
                 <hr style='background-color: black; height: 1px; border: 0;margin-top:40px;margin-left:10px'><br>";
        $Html.='</html>';
        
        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadHTML($Html)->setOrientation('portraid')->setPaper('A7');
        return $pdf->stream();

    }
 
    public function getData() 
    {
        $data =  [
            'quantity'      => '1' ,
            'description'   => 'some ramdom text',
            'price'   => '500',
            'total'     => '500'
        ];
        return $data;
    }

    
    public function store(Request $request)
    {
        //
    }

    
    public function show($id)
    {
        //
    }

    
    public function edit($id)
    {
        //
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
