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
    width:100%;.
}
.ledger {
    border:1px solid lightgray;
    padding:12px;
}
.column-headers{
    border:1px solid lightgray;
    border-left: 1px solid lightgray;
    border-right: 1px solid lightgray;
    background: #e3e3e3;
    font-size: 0.9rem;
    margin-top:5px;
    margin-bottom:5px;
    border-collapse: collapse;
    /* border-bottom: 2px double gray; */
}
.column-headers th{
    text-align: center;
}
.data {
    border-collapse: collapse;
    font-size: 1rem;
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
                    <h1>{{ $hdng1 }}</h1>
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
                    {{-- <h3 style="font-size:0.8rem">Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes</h3> --}}
                    {{-- <h3 style="font-size:0.8rem">Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,</h3> --}}
                    <h3> {{ $hdng2 }}</h3>
                </td>            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:1.5rem">IMPORT PURCHASE PAYMENT CRITERIA </span>
                </td>
            </tr>

        {{-- <tr>

            <td  style="text-align: center;">
                <span style="font-size:1.5rem;font-weight: bold">{{ $ltype }}</span>
            </td>

        </tr> --}}


        </tbody>
    </table>

    {{-- Ledger Info --}}
    {{-- <table class="ledger">
        <tbody>
            <tr>
                <td>
                    Supplier Name
                </td>
                <td>
                    {{ $data[0]->supname }}
                </td>

                <td>
                    Contract No
                </td>
                <td>
                    {{ $data[0]->invoiceno }}
                </td>
            </tr>
            <tr>
                <td>
                    Total Weight
                </td>
                <td style="font-weight: bold;color:brown" >   {{ $data[0]->totwt }}   </td>
                <td>
                    Contract Date
                </td>
                <td>
                    {{ $data[0]->invoice_date }}
                </td>


            </tr>
        </tbody>
    </table> --}}
    {{-- column headers --}}
    <table class="column-headers ">
        <thead >
            {{-- <tr> <th class="column-headers" width="50%">OPENING BNALANCE</th></tr> --}}
            <tr>
                <td colspan="5" width="44%" style="text-align:center;font-weight: bold;border-right: 1px solid lightgray;"> Invoice Description</td>
                <td colspan="3" width="24%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Bank Payable</td>
                <td colspan="3" width="24%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Cash Payable</td>
                {{-- <td colspan="1" width="8%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Invoice Balance</td> --}}
            </tr>

            <tr>
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th class="column-headers" width="3%">S#</th>
                    <th class="column-headers" width="15%">Supplier Name</th>
                    <th class="column-headers" width="10%">G.D No</th>
                    <th class="column-headers" width="8%">G.D Date</th>
                    <th class="column-headers" width="8%">Weight</th>

                    <th class="column-headers" width="8%">Payable</th>
                    <th class="column-headers" width="8%">Payment</th>
                    <th class="column-headers" width="8%">Balance<br>
                    <th class="column-headers" width="8%">Payable</th>
                    <th class="column-headers" width="8%">Payment</th>
                    <th class="column-headers" width="8%">Balance</th>
                    <th class="column-headers" width="8%">Invoice<br>Balance</th>



            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>

            {{ $cashpbl = 0 }};{{ $cashpmt = 0 }};{{ $cashbal = 0 }}
            {{ $bankhpbl = 0 }};{{ $bankpmt = 0 }};{{ $bankbal = 0 }}
            {{ $totalbal = 0 }}


            @for ($i = 0 ; $i < count($data) ; $i++)


            <tr>

                {{ $bankhpbl += $data[$i]->bankpayable }};{{ $bankpmt += $data[$i]->bnkpayment }}; {{ $bankbal += $data[$i]->bankbalance }}
                {{ $cashpbl += $data[$i]->cashpayable }};{{ $cashpmt += $data[$i]->cashpayment }}; {{ $cashbal += $data[$i]->cashbalance }}
                {{ $totalbal += $data[$i]->gbalance }}

                <td style="text-align:center" width="3%">{{ $i+1 }}</td>
                <td style="text-align:left" width="15%">{{ $data[$i]->supname}} </td>
                <td style="text-align:center" width="10%">{{ $data[$i]->machineno}} </td>
                <td style="text-align:center" width="8%">{{ $data[$i]->machine_date}} </td>
                <td style="text-align:center" width="8%">{{ $data[$i]->supwt}} </td>

                <td style="text-align:right" width="8%">{{ number_format($data[$i]->bankpayable,2) }} </td>
                <td style="text-align:right" width="8%">{{ number_format($data[$i]->bnkpayment,2) }} </td>
                <td style="text-align:right" width="8%">{{ number_format($data[$i]->bankbalance,2) }} </td>

                <td style="text-align:right" width="8%">{{ number_format($data[$i]->cashpayable,2) }} </td>
                <td style="text-align:right" width="8%">{{ number_format($data[$i]->cashpayment,2) }} </td>
                <td style="text-align:right" width="8%">{{ number_format($data[$i]->cashbalance,2) }} </td>
                <td style="text-align:right" width="8%">{{ number_format($data[$i]->gbalance,2) }} </td>


            </tr>
            @endfor
            <tr>
                <td class="column-headers" colspan="2"  style="text-align: right;font-weight: bold; border-bottom: 1px solid lightgray;">Total</td>
                <td class="column-headers" colspan="4"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($bankhpbl,2) }} </td>
                <td class="column-headers" colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($bankpmt,2) }} </td>
                <td class="column-headers" colspan="1"  style=" color:brown;font-weight:bold;  text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($bankbal,2) }} </td>

                <td class="column-headers" colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($cashpbl,2) }} </td>
                <td class="column-headers" colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($cashpmt,2) }} </td>
                <td class="column-headers" colspan="1"  style=" color:brown;font-weight:bold;  text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($cashbal,2) }} </td>
                <td class="column-headers" colspan="1"  style=" color:brown;font-weight:bold;  text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($totalbal,2) }} </td>

            </tr>






        </tbody>
    </table>

    {{-- Footer  --}}
    <div style="margin-top:64px;">
        <table >

            {{-- <tr style="margin-top:16px;margin-bottom:16px;">
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
            </tr> --}}






        </table>






    </div>



    </body>

</html>
