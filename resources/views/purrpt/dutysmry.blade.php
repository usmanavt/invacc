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
                    <h1>MUHAMMAD NAZIR & Co</h1>
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
                    <h3 style="font-size:0.8rem">Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes</h3>
                    <h3 style="font-size:0.8rem">Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,</h3>
                    <h3 style="font-size:0.8rem">Phone : 021-32588781, 021-32574285 , Fax : 021-32588782</h3>
                </td>            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:1.5rem">CUSTOM DUTY SUMMARY </span>
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
            {{-- <tr>
                <td colspan="4" width="64%" style="text-align:center;font-weight: bold;border-right: 1px solid lightgray;"> Material Description</td>
                <td colspan="2" width="16%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Quantity</td>
                <td colspan="2" width="20%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Supplier Value($)</td>
            </tr> --}}

            <tr>
                {{-- <td  style="text-align: center font-size:0.5rem;font-weight: bold"> --}}
                    <th class="column-headers" width="3%">S#</th>
                    <th class="column-headers" width="10%">Invoice <br> No</th>
                    <th class="column-headers" width="10%">Invoice <br> Date</th>
                    <th class="column-headers" width="10%">G.D No</th>
                    <th class="column-headers" width="10%">G.D Date</th>
                    <th class="column-headers" width="9%">Total <br> Weight</th>
                    <th class="column-headers" width="10%">Payable<br>Amount</th>
                    <th class="column-headers" width="9%">Cleared<br>Weight</th>
                    <th class="column-headers" width="10%">Cleared<br>Duty</th>
                    <th class="column-headers" width="9%">Balance<br>Weight</th>
                    <th class="column-headers" width="10%">Duty<br>Variance</th>



            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>

            {{ $cash = 0 }};{{ $bnk = 0 }};{{ $tot = 0 }}

            @for ($i = 0 ; $i < count($data) ; $i++)

            <tr>

                {{-- {{ $cash += $data[$i]->cashpayable }}.
                {{ $bnk += $data[$i]->bankpayable }}
                {{ $tot += $data[$i]->amtdlr }} --}}



                <td style="text-align:center" width="3%">{{ $i+1 }}</td>
                {{-- <td style="text-align:left" width="29%">{{ $data[$i]->supname}} </td> --}}
                <td style="text-align:center" width="10%">{{ $data[$i]->invoiceno}} </td>
                <td style="text-align:center" width="10%">{{ $data[$i]->invoice_date}} </td>
                <td style="text-align:center" width="10%">{{ $data[$i]->machineno}} </td>
                <td style="text-align:center" width="10%">{{ $data[$i]->machine_date}} </td>

                <td style="text-align:right" width="9%">{{ number_format($data[$i]->twt,1) }} </td>
                <td style="text-align:right" width="10%">{{ number_format($data[$i]->tduty,0) }} </td>
                <td style="text-align:right" width="9%">{{ number_format($data[$i]->clrdtywt,0) }} </td>
                <td style="text-align:right" width="10%">{{ number_format($data[$i]->dtycleared,0) }} </td>

                <td style="text-align:right" width="9%">{{ number_format($data[$i]->balwt,0) }} </td>
                <td style="text-align:right" width="10%">{{ number_format($data[$i]->baldutyclrd,0) }} </td>


            </tr>
            @endfor
            {{-- <tr> --}}
                {{-- <td class="column-headers" colspan="2"  style="text-align: right;font-weight: bold; border-bottom: 1px solid lightgray;">Total</td> --}}
                {{-- <td class="column-headers" colspan="5"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($cash,2) }} </td>
                <td class="column-headers" colspan="1"  style="text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($bnk,2) }} </td>
                <td class="column-headers" colspan="1"  style=" color:brown;font-weight:bold;  text-align: right;border-bottom: 1px solid lightgray;background: #e3e3e3;font-weight: bold">{{ number_format($tot,2) }} </td> --}}
            {{-- </tr> --}}






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
