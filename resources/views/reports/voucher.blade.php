<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<style>
* {
    margin:0;
    padding:0;
    font-size:0.8rem;
    font-style: normal;
    /* box-sizing: border-box; */
}

.voucher-headers{
    /* border:1px solid black; */
    /* background: #e3e3e3; */
    /* padding:12px; */
    /* margin-top:5px; */
    /* margin-bottom:5px; */
    font-weight: bold;
    text-align: center;
    font-size: 1.5rem;
}




table{
    width:100%;
}
.ledger {
    border:1px solid black;
    padding:12px;
}
.column-headers{
    border:1px solid black;
    background: #e3e3e3;
    padding:12px;
    margin-top:5px;
    margin-bottom:5px;
    /* border-bottom: 2px double  lightgray; */
    border-collapse: collapse;
    text-align: center;
}
.column-headers th{
    text-align: center;
}.
.data {

    border-collapse: collapse;
}
.data tr td{
    border:1px solid black;
    padding:12px;
    border-collapse: collapse;
    /* border-left: 1px solid black;
    border-top: 1px solid black;
    border-right: 1px solid black; */

    text-align: left;
    /* font-size: 1rem; */
    /* font-style: normal; */
}
.data tr td:nth-child(7){
    border-right:1px solid black;
}
.data tr td:nth-child(5),
.data tr td:nth-child(6),
.data tr td:nth-child(7),{
    text-align: right;
}
.data tr:last-child{
    border-bottom:1px solid black;
}
</style>
</head>
    <body>
{{-- https://stackoverflow.com/questions/3341485/how-to-make-a-html-page-in-a4-paper-size-pages?answertab=votes#tab-top --}}

    {{-- Report Header --}}

    {{-- Address --}}


    {{-- Ledger Info --}}
    {{-- <table class="ledger">
        <tbody>
            <tr>   <td>  {{$data[0]->vnodesc}} <span style="font-weight: bold;margin-bottom:10px  ">{{ $data[0]->vno }}</span>    </td>  </tr>
            <tr>   <td>  {{$data[0]->paytodesc}} <span style="font-weight: bold;margin-top:10px  ">{{ $data[0]->payto }}</span>   </td> </tr>
            <tr>
            <td style="text-align: left;border-bottom: 1px solid black;margin-top:10px" > DEBIT TO:<span style="font-weight: bold  ">{{ $data[0]->dbtto }}</span>  </td>
                <td > A/C</td>
            </tr>
        </tbody>
    </table> --}}

    {{-- <table >
        <tbody>
            <tr>
                <td style="text-align: left;border-bottom: 1px solid black;padding:12px;" > DEBIT TO:<span style="font-weight: bold ;color:blue ">{{ $data[0]->dbtto }}</span>  </td>
                <td > A/C</td>
            </tr>
        </tbody>
    </table> --}}





    @for ($i = 0 ; $i < count($data) ; $i++)



    <table >
        <tbody>
            <tr>


                {{-- logo --}}

                {{-- <td align="left" style="width:20%;">
                    <img src="{{ asset('/images/pipesfittings.jpg') }}" width="90">
                 </td> --}}

                <td style= "text-align:center; width:60%;">
                    <h1>MUHAMMAD NAZIR & Co </h1>
                </td>
            </tr>
        </tbody>
    </table>

    <table>
        <tbody>
            <tr>
                <td  style="text-align: center;">
                    <h3 style="font-size:0.8rem">Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes</h3>
                    <h3 style="font-size:0.8rem">Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,</h3>
                    <h3 style="font-size:0.8rem">Phone : 021-32588781, 021-32574285 , Fax : 021-32588782</h3>
                </td>            </tr>
                <tr>
                    <td style="color:white"> a </td>

                </tr>

            <tr>
                <td  style="text-align: right;">
                    <span style="font-size:1rem;font-weight: bold"> Date:  {{ $data[$i]->vdate }} </span>
                </td>
            </tr>

        </tbody>
    </table>

<table class="voucher-headers">
    <tbody>
        <tr >
            <td>   {{ $data[$i]->rpttitle }}   </td>
        </tr>
    </tbody>
</table>




    <table style="font-weight: bold">
        <tbody>
            <tr> <td> VOUCHER #: {{ $data[$i]->vno }}  </td>  </tr>

        </tbody>
    </table>


    <table style="font-weight: bold">
        <tbody>
            <tr> <td> PAYEE: {{ $data[$i]->payto }}  </td>  </tr>

        </tbody>
    </table>

    <table style="font-weight: bold;border-bottom: 1px solid black;">
        <tbody>
            <tr> <td> {{ $data[$i]->ttype }} {{ $data[$i]->dbtto }}  </td> <td> A/C </td>
            </tr>

        </tbody>
    </table>

    <table style="padding:3px;">
        <tbody>
            <tr> <td>  </td> </tr>

        </tbody>
    </table>






    <table class="column-headers" cellspacing="0"  >
        <tbody>
            <tr>
                <td class="column-headers" cellspacing="0" width="5%">Sr#</td>
                <td class="column-headers" cellspacing="0" width="70%">Description</td>
                <td class="column-headers" cellspacing="0" width="15%">Rs.</td>
                <td class="column-headers" cellspacing="0" width="10%">Ps.</td>
            </tr>
        </tbody>
    </table>





    <table class="data" cellspacing="0" >
        <tbody>
            {{ $totamount = 0 }}



            <tr>
                {{ $totamount += $data[$i]->amount_fc }}

                <td class="" width="5%">1</td>
                <td class="" width="70%">{{ $data[$i]->description }} </td>
                {{-- <td  width="33%"> <span style="font-size:0.8rem;font-weight: bold;color:brown">{{ $data[$i]->Descr }}</span> --}}
                    {{-- <br> {{ $data[$i]->DESCRIPTION }} </td> --}}
                <td style="text-align: right" width="15%">{{ $data[$i]->amount_fc }} </td>
                <td class="" width="10%"> </td>

            </tr>

            <tr>
                <td colspan="1"  style="text-align: right;border-bottom: 1px solid black;"></td>
                <td colspan="1"  style="text-align: right;border-bottom: 1px solid black;font-weight: bold">Total Amount. </td>
                <td colspan="1"  style="text-align: right;border-bottom: 1px solid black;font-weight: bold">{{ number_format($totamount,2) }} </td>
                <td colspan="1"  style="text-align: right;border-bottom: 1px solid black;"> </td>
            </tr>





        </tbody>
    </table>

    <table >
        <tr style="padding:12px"> <td style="font-weight:bold"> {{ $data[$i]->bnkfooter }} </td>   </tr>
    </table>



    <table >
        <tr style="padding:12px"> <td style="font-weight:bold"> Rupees.{{ $data[$i]->amountword }} </td>   </tr>
    </table>

    <div style="margin-top:60px;">
        <table >

            <tr style="margin-top:16px;margin-bottom:10px;">
                <td style="width=33%;font-size:80%;text-align:center">
                    --------------------------------
                </td>

                <td style="width=33%;font-size:80%;text-align:center">
                    --------------------------------
                </td>

                <td style="width=33%;font-size:80%;text-align:center">
                    --------------------------------
                </td>
            </tr>
            <tr>
                <td style="width=33%;font-size:80%;text-align:center">
                    Accountant
                </td>

                <td style="width=33%;font-size:80%;text-align:center">
                    Director
                </td>

                <td style="width=33%;font-size:80%;text-align:center">
                    Receiver's Signature
                </td>


            </tr>
        </table>
    </div>


    <div style="margin-top:90px;">
        <table >

            <tr>

                <td >

                </td>


            </tr>
        </table>
    </div>





    @endfor
    {{-- Footer  --}}

    {{-- <div style="margin-top:30px;"> --}}
    {{-- </div> --}}


    </body>
</html>
