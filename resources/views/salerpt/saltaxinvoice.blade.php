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
    box-sizing: border-box;
}
table{
    width:100%;
}
.ledger {
    border:1px solid lightgray;
    padding:12px;
}

.ledger1 {
            /* border-top: 1px solid lightgray;
            border-bottom: 1px solid lightgray;
            border-left: 1px solid lightgray;
            border-right: 1px solid lightgray; */
            /* text-align: left; */
            border: 1px solid #ccc;
            padding-top: 0.5em;
            padding-bottom: 0.5em;
            width: 25px;
            height:40px;
            /* margin: 1px; */


        }


        .usman {

            border: 1px solid #ccc ;
            padding-top: 0.5em;
            padding-bottom: 0.5em;
            width: 100%;
            height:12ch;
            border-left: 1px solid lightgray;
            border-right: 1px solid lightgray;
            /* margin: 1px; */


        }

        .ledger2 {
            /* border: 1px solid #ccc; */
            border-top: 1px solid lightgray;
            border-bottom: 1px solid lightgray;
            border-left: 1px solid lightgray;
            border-right: 1px solid lightgray;
            float: left;
            /* text-align: center; */
            width: 100px;
            height:40px;
            margin: 1px;
        }




.column-headers{
    border:1px solid lightgray;
    border-left: 1px solid lightgray;
    border-right: 1px solid lightgray;
    background: #e3e3e3;
    font-size: 0.8rem;
    margin-top:5px;
    margin-bottom:5px;

    border-bottom: 2px double gray;
}
.column-headers th{
    text-align: center;
}
.data {
    border-collapse: collapse;
    border-block-width:500px;
}
.data tr td{
    border-left: 1px solid lightgray;
    border-right: 1px solid lightgray;
    border-top: 1px solid lightgray;
    text-align: left;
    font-size: 0.8rem;
    font-style: normal;
}
.data tr td:nth-child(7){
    border-right:1px solid lightgray;
}
.data tr td:nth-child(5),
.data tr td:nth-child(6),
.data tr td:nth-child(7),{
    text-align: right;
}
.data tr:last-child{
    border-bottom:solid thin;
}
</style>
</head>
    <body>
{{-- https://stackoverflow.com/questions/3341485/how-to-make-a-html-page-in-a4-paper-size-pages?answertab=votes#tab-top --}}

    {{-- Report Header --}}
    <table>
        <tbody>
            <tr>
                {{-- logo --}}
                <td align="left" style="width:20%;">
                    {{-- <img src="{{ asset('/images/pipesfittings.jpg') }}" width="90"> --}}
                </td>
                <td align="center" style="width:60%;">
                    <h1>MUHAMMAD HABIB & Co. </h1>
                </td>
                <td align="right" style="width:20%;">
                    &nbsp;&nbsp;&nbsp;&nbsp;
                </td>
.            </tr>
        </tbody>
    </table>

    {{-- Address --}}
    <table>
        <tbody>
            <tr>
                <td  style="text-align: center;">
                    <h3 style="font-size:0.7rem">Steam Pipes, Pipe Fittings, Flanges, Valves, S.S.Pipes & Tbues</h3>
                    <h3 style="font-size:0.7rem">30 KM, Sunder Stop, Multan Road, Lahore</h3>
                </td>
            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:2.5rem;font-weight: bold">Sales Tax Invoice</span>
                </td>
            </tr>
        </tbody>
    </table>



    <table  >
        <tbody >
            <tr>
                <td class="ledger1" >
                    Invoice No: {{ $data[0]->billno }}
                </td>
                <td class="ledger2" >
                   Date: {{ $data[0]->invoice_date }}
                </td>
                <td class="ledger2" >
                    Delivery Challan#: {{ $data[0]->dcno }}
                 </td>

                <td class="ledger2">
                    Original <br> Duplicate
                </td>
                {{-- <td>
                    {{ $data[0]->billno }}
                </td> --}}
            </tr>

            <tr>

                <td class="ledger1" >
                    BUYER'S NAME <br> & <br> ADDRESS
                </td>
                <td class="ledger2" ><span style="font-size:1rem;font-weight: bold">M/S. M.NAZEER M RAHIM & CO</span> <br>
                                    <span style="font-size:0.9rem">1-A,1ST FLOOR, PLOT NO.8-391-A,</span> <br>
                                    <span style="font-size:0.9rem">K/S 1024, ALLAH MALIK GODOWN,</span> <br>
                                    <span style="font-size:0.9rem">JAHAN ABAD KABARI MARKET</span> <br>
                                    <span style="font-size:0.9rem"> SHER SHAH KARACHI.</span> <br>
                </td>

                <td class="ledger2" >
                    SUPPLIER'S NAME <br> & <br>ADDRESS
                </td>
                <td class="ledger2" >
                    {{ $data[0]->custname }} <br>
                    {{ $data[0]->address2 }}
                </td>

            </tr>

            <tr>

                <td class="ledger1" >
                    Telephone No:
                </td>
                <td class="ledger2" ><span style="font-size:1rem;font-weight: bold">021-32574285 / 32588781</span></td>
                <td class="ledger2" >
                    Telephone No:
                </td>
                <td class="ledger2" ><span style="font-size:1rem;font-weight: bold">{{ $data[0]->phoneoff }}</span></td>

            </tr>

            <tr>
                <td class="ledger1" >
                    NTN No:
                </td>
                <td class="ledger2" ><span style="font-size:1rem;font-weight: bold">3646770-7</span></td>
                <td class="ledger2" >
                    NTN No:
                </td>
                <td class="ledger2" ><span style="font-size:1rem;font-weight: bold">{{ $data[0]->ntn }}</span></td>
            </tr>

            <tr>
                <td class="ledger1" >
                    Registration No:
                </td>
                <td class="ledger2" ><span style="font-size:1rem;font-weight: bold">17-00-3646-770-15</span></td>
                <td class="ledger2" >
                    Registration No:
                </td>
                <td class="ledger2" ><span style="font-size:1rem;font-weight: bold">{{ $data[0]->stax }}</span></td>
            </tr>






        </tbody>
    </table>



    {{-- <table class="ledger">
        <tbody>
            <tr>
                <td>
                    Customer Name
                </td>
                <td>
                    {{ $data[0]->custname }}
                </td>
                <td>
                    Bill No
                </td>
                <td>
                    {{ $data[0]->billno }}
                </td>
            </tr>
            <tr>
                <td>
                    DC No
                </td>
                <td>
                    From {{ $fromdate }} to {{ $todate }}
                    {{ $data[0]->dcno }}
                </td>
                <td>
                    Invoice Date
                </td>
                <td>
                    {{ $data[0]->invoice_date }}
                </td>
            </tr>
        </tbody>
    </table> --}}
    {{-- column headers --}}
    <table class="">
        <thead  >
            <tr class="column-headers ">
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th class="column-headers" width="3%">S#</th>
                    <th class="column-headers" width="10%">QUANTITY<br>RFT/KG/MTR<br>/NO </th>
                    <th class="column-headers" width="30%">DESCRIPIOTN OF<br>GOOD SOLD</th>
                    <th class="column-headers"  width="10%">UNIT<br>PRICE</th>
                    <th class="column-headers"  width="10%">VALUES OF<br>GOODS<br>/BEFORE S.TAX </th>
                    <th class="column-headers"  width="9%">RATE<br>OF<br>/SALES TAX </th>
                    <th class="column-headers"  width="9%">AMOUNT<br>OF<br>/SALES TAX </th>
                    <th class="column-headers"  width="8%">SPECIAL<br>EXCISE<br>DUTY </th>
                    <th class="column-headers"  width="11%">VALUES OF<br>GOODS<br>AFTER S.TAX </th>
            </tr>

            <tr class="column-headers ">
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th class="column-headers" width="3%">1</th>
                    <th class="column-headers" width="10%">2</th>
                    <th class="column-headers" width="30%">3</th>
                    <th class="column-headers"  width="10%">4</th>
                    <th class="column-headers"  width="10%">5=2*4 </th>
                    <th class="column-headers"  width="9%">6 </th>
                    <th class="column-headers"  width="9%">7=5%6 </th>
                    <th class="column-headers"  width="8%">8</th>
                    <th class="column-headers"  width="11%">9=5+7 </th>
            </tr>


        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody class="">

            {{ $vnvlues = 0 }}
            {{ $vsvlues = 0 }}
            {{ $vtvlues = 0 }}

            @for ($i = 0 ; $i < count($data) ; $i++)
            <tr>

                {{ $vnvlues += $data[$i]->value }}
                {{ $vsvlues += $data[$i]->staxamount }}
                {{ $vtvlues += $data[$i]->trcvblamount }}


                {{-- <td class="" width="3%">{{ $i+1 }}</td> --}}
                <td  width="3%" style="font-size:0.8rem;text-align:center">{{ $i+1 }}</td>
                <td  width="10%" style="font-size:0.8rem;text-align:right">{{ number_format($data[$i]->qty,0) }}</td>
                <td  width="30%" style="font-size:0.8rem;text-align:left">{{ $data[$i]->material_title }}</td>
                <td  width="10%" style="font-size:0.8rem;text-align:right">{{ number_format($data[$i]->price,1) }}</td>
                <td  width="10%" style="font-size:0.8rem;text-align:right">{{ number_format($data[$i]->value,0) }}</td>
                <td  width="9%" style="font-size:0.8rem;text-align:right">{{ number_format($data[$i]->saletaxper,1) }}</td>
                <td  width="9%" style="font-size:0.8rem;text-align:right">{{ number_format($data[$i]->staxamount,0) }}</td>
                <td  width="8%" style="font-size:0.8rem;text-align:right">0</td>
                <td  width="11%" style="font-size:0.8rem;text-align:right">{{ number_format($data[$i]->trcvblamount,0) }}</td>


            </tr>
            @endfor
            <tr>
                <td  colspan="9" width="100%" style="border-bottom: #ccc"></td>
                {{-- <td class="column-headers" colspan="2" width="10%" style="text-align: right;font-weight: bold">{{ number_format($vnvlues,0) }} </td> --}}
                {{-- <td class="column-headers" colspan="2" width="9%" style="text-align: right;font-weight: bold">{{ number_format($vsvlues,0) }} </td> --}}
                {{-- <td class="column-headers" colspan="2" width="11%" style="text-align: right;font-weight: bold">{{ number_format($vtvlues,0) }} </td> --}}
           </tr>
        </tbody>
    </table>



    <div style="margin-top:420px;">
        <table >

            <tr style="margin-top:16px;margin-bottom:16px;">
                {{-- <td style="width=33%;font-size:80%;text-align:center"> --}}
                    <td class="column-headers" colspan="3" width="30%" style="text-align: right;font-weight: bold">Total Amount</td>
                    <td class="column-headers" colspan="2" width="10%" style="text-align: right;font-weight: bold">{{ number_format($vnvlues,0) }} </td>
                    <td class="column-headers" colspan="2" width="9%" style="text-align: right;font-weight: bold">{{ number_format($vsvlues,0) }} </td>
                    <td class="column-headers" colspan="2" width="11%" style="text-align: right;font-weight: bold">{{ number_format($vtvlues,0) }} </td>
                {{-- </td> --}}
            </tr>


        </table>
    </div>


    {{-- Footer  --}}
    <div style="margin-top:65px;">
        <table >

            <tr style="margin-top:16px;margin-bottom:16px;">
                <td style="width=33%;font-size:80%;text-align:center">
                    --------------------
                </td>

                <td style="width=33%;font-size:80%;text-align:center">
                    --------------------
                </td>
            </tr>
            <tr>
                <td style="width=33%;font-size:80%;text-align:center">
                    Prepared By
                </td>

                <td style="width=33%;font-size:80%;text-align:center">
                    Approved By
                </td>
            </tr>

        </table>
    </div>




    </body>

</html>
