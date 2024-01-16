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

.subhead{
    border:1px solid lightgray;

}



table{
    width:100%;
}
.ledger {
    border:1px solid lightgray;
    padding:12px;
}
.column-headers{
    border:1px solid lightgray;
    background: #e3e3e3;
    margin-top:5px;
    margin-bottom:5px;
    border-bottom: 2px double  lightgray;
    border-collapse: collapse;
    text-align: center;
}
.column-headers th{
    text-align: center;
}
.data {
    border-collapse: collapse;
}
.data tr td{
    border-left: 1px solid lightgray;
    border-top: 1px solid lightgray;
    text-align: left;
    font-size: 0.9rem;
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
                {{-- <td align="left" style="width:20%;"> --}}
                    {{-- <img src="{{ asset('/images/pipesfittings.jpg') }}" width="90"> --}}
                {{-- </td> --}}
                <td align="center" style="width:60%;">
                    <h1> {{ $hdng1 }} </h1>
                </td>
                {{-- <td align="right" style="width:20%;"> --}}
                    &nbsp;&nbsp;&nbsp;&nbsp;
                {{-- </td> --}}
            </tr>
        </tbody>
    </table>

    {{-- Address --}}
    <table>
        <tbody>
            <tr>
                <td  style="text-align: center;">
                    {{-- <h3 style="font-size:0.9rem">Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes</h3> --}}
                    {{-- <h3 style="font-size:0.9rem">Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,</h3> --}}
                    {{-- <h3 style="font-size:0.9rem">Phone : 021-32588781, 021-32574285 , Fax : 021-32588782</h3> --}}
                    <h3> {{ $hdng2 }} </h3>
                </td>            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:2rem">PURCHASE HISTORY - IMPORT </span>
                </td>
            </tr>

        </tbody>
    </table>


    {{-- Ledger Info --}}
    <table class="ledger">
        <tbody>
            <tr>
                <td>
                    Date Period
                </td>
                <td>
                    From {{ $fromdate }} to {{ $todate }}
                </td>
            </tr>
        </tbody>
    </table>

    {{-- column headers --}}
    <table class="column-headers">
        <thead>

            <tr>
                <td colspan="3" width="38%" style="text-align:center;font-weight: bold;border-right: 1px solid lightgray;"> Material Description</td>
                <td colspan="3" width="18%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Purchasing Qty</td>
                <td colspan="3" width="23%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Purchasing Value</td>
                <td colspan="3" width="21%" style="text-align: center;font-weight: bold;border-right: 1px solid lightgray;">Item Cost</td>
            </tr>




            <tr>

                <th class="column-headers" width="3%">S#</th>
                <th class="column-headers" width="27%">Items</th>
                <th class="column-headers" width="8%">Size</th>

                <th class="column-headers" width="6%">Pcs</th>
                <th class="column-headers" width="6%">Kg</th>
                <th class="column-headers" width="6%">Feet</th>

                <th class="column-headers" width="7%">Rate$</th>
                <th class="column-headers" width="8%">Amount$</th>
                <th class="column-headers" width="8%">AmountPkr</th>

                <th class="column-headers" width="7%">Pcs</th>
                <th class="column-headers" width="7%">Kg</th>
                <th class="column-headers" width="7%">Feet</th>



                </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{-- {{ $debitpkr = 0}} --}}
            {{ $gtpcs = 0 }};{{ $gtwt = 0 }};{{ $gtft = 0 }};{{ $gtvaldlr = 0 }};{{ $gtvalrup = 0 }}
            {{ $stpcs = 0 }};{{ $stwt = 0 }};{{ $stft = 0 }};{{ $stvaldlr = 0 }};{{ $stvalrup = 0 }}

@for ($i = 0 ; $i < count($data) ; $i++)

                {{ $gtpcs += $data[$i]->pcs }}
                {{ $gtwt += $data[$i]->supwt }}
                {{ $gtft += $data[$i]->qtyinfeet }}
                {{ $gtvaldlr += $data[$i]->supvaldlr }}
                {{ $gtvalrup += $data[$i]->supvalrup }}



                @if( $i==0 )
                <tr>
                    <td class="subhead" colspan="2" width="100%"   > Supplier Name: <span style="font-weight: bold;color:brown" > {{ $data[$i]->supname}} </span> </td>
                    <td class="subhead" colspan="3" width="100%"   > machine No: <span style="font-weight: bold;color:brown" > {{ $data[$i]->machineno}} </span> </td>
                </tr>
                <tr>
                <td class="subhead" colspan="2" > Invoice Date: <span style="font-weight: bold;color:brown">  {{ $data[$i]->invoice_date}} </span>
                    Invoice No: <span style="font-weight: bold;color:brown"  > {{ $data[$i]->invoiceno}} </span></td>
                    <td class="subhead" colspan="3" width="100%"   > Conv.Rate: <span style="font-weight: bold;color:brown" > {{ $data[$i]->sconversionrate}} </span> </td>
                </tr>
            @else

            {{ $srno = $i - 1 }}

                {{ $stpcs += $data[$srno]->pcs }}
                {{ $stwt += $data[$srno]->supwt }}
                {{ $stft += $data[$srno]->qtyinfeet }}
                {{ $stvaldlr += $data[$srno]->supvaldlr }}
                {{ $stvalrup += $data[$srno]->supvalrup }}


        @if ($data[$i]->purid  <> $data[$srno]->purid)

            <tr>
                <td class="column-headers" colspan="3"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">Sub Total</td>
                <td class="column-headers" colspan="1"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stpcs,0) }} </td>
                <td class="column-headers" colspan="1"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stwt,0) }} </td>
                <td class="column-headers" colspan="1"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stft,0) }} </td>
                <td class="column-headers" colspan="2"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stvaldlr,0) }} </td>
                <td class="column-headers" colspan="1"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stvalrup,0) }} </td>
                <td class="column-headers" colspan="4"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;"> </td>
            </tr>

            <tr>

                <td class="subhead" colspan="2"   > Supplier Name: <span style="font-weight: bold;color:brown" > {{ $data[$i]->supname}} </span> </td>
                <td class="subhead" colspan="3" width="100%"   > machine No: <span style="font-weight: bold;color:brown" > {{ $data[$i]->machineno}} </span> </td>
            </tr>


            <tr>
                <td class="subhead" colspan="2"> Invoice Date: <span style="font-weight: bold;color:brown">  {{ $data[$i]->invoice_date}} </span>
                    Invoice No: <span style="font-weight: bold;color:brown"  > {{ $data[$i]->invoiceno}} </span></td>
                    <td class="subhead" colspan="3" width="100%"   > Conv.Rate: <span style="font-weight: bold;color:brown" > {{ $data[$i]->sconversionrate}} </span> </td>
                </tr>

                {{ $stpcs = 0 }};{{ $stwt = 0 }};{{ $stft = 0 }};{{ $stvaldlr = 0 }};{{ $stvalrup = 0 }}
        @endif
        @endif

.
            <tr>


                {{-- {{ $debitusd += $data[$i]->DebitAmtDlr }}
                {{ $creditusd += $data[$i]->CreditAmtDlr }} --}}

                    <td style="text-align: center"  width="3%">{{ $i+1 }}</td>
                    <td  width="27%">{{ $data[$i]->matname }} </td>
                    <td style="text-align: center"  width="8%">{{ $data[$i]->size }} </td>

                    <td style="text-align: right"  width="6%">{{ number_format($data[$i]->pcs,0) }} </td>

                    <td style="text-align: right"  width="6%">{{ number_format($data[$i]->supwt,1) }} </td>
                    <td style="text-align: right"  width="6%">{{ number_format($data[$i]->qtyinfeet,0) }} </td>

                    <td style="text-align: right"  width="7%">{{ number_format($data[$i]->supprice,2) }} </td>
                    <td style="text-align: right"  width="8%">{{ number_format($data[$i]->supvaldlr,2) }} </td>
                    <td style="text-align: right"  width="8%">{{ number_format($data[$i]->supvalrup,0) }} </td>

                    <td style="text-align: right"  width="7%">{{ number_format($data[$i]->perpc,2) }} </td>
                    <td style="text-align: right"  width="7%">{{ number_format($data[$i]->perkg,2) }} </td>
                    <td style="text-align: right"  width="7%">{{ number_format($data[$i]->perft,0) }} </td>


                    {{-- <td style="text-align: center"  width="5%">{{ $data[$i]->unit }} </td>
                    <td  width="25%">{{ $data[$i]->forcust }} </td>
                    <td  width="9%">{{ number_format($data[$i]->price,1) }} </td>
                    <td  width="9%">{{ number_format($data[$i]->vlues,0) }} </td> --}}

            </tr>
@endfor

{{ $stpcs += $data[$srno+1]->pcs }}
{{ $stwt += $data[$srno+1]->supwt }}
{{ $stft += $data[$srno+1]->qtyinfeet }}
{{ $stvaldlr += $data[$srno+1]->supvaldlr }}
{{ $stvalrup += $data[$srno+1]->supvalrup }}



<tr>
    <td class="column-headers" colspan="3"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">Sub Total</td>
    <td class="column-headers" colspan="1"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stpcs,0) }} </td>
    <td class="column-headers" colspan="1"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stwt,0) }} </td>
    <td class="column-headers" colspan="1"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stft,0) }} </td>
    <td class="column-headers" colspan="2"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stvaldlr,0) }} </td>
    <td class="column-headers" colspan="1"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stvalrup,0) }} </td>
    <td class="column-headers" colspan="4"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;"></td>
</tr>




<tr>
    <td class="column-headers" colspan="3"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">Grand Total</td>
    <td class="column-headers" colspan="1"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($gtpcs,0) }} </td>
    <td class="column-headers" colspan="1"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($gtwt,0) }} </td>
    <td class="column-headers" colspan="1"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($gtft,0) }} </td>
    <td class="column-headers" colspan="2"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($gtvaldlr,0) }} </td>
    <td class="column-headers" colspan="1"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($gtvalrup,0) }} </td>
    <td class="column-headers" colspan="4"  style="font-size:0.9rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;"> </td>
</tr>



</tbody>
    </table>

    {{-- Footer  --}}
    {{-- <div style="margin-top:64px;">
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

    </body> --}}
</html>
