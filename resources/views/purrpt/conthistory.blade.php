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
                {{-- <td align="left" style="width:20%;"> --}}
                    {{-- <img src="{{ asset('/images/pipesfittings.jpg') }}" width="90"> --}}
                {{-- </td> --}}
                <td align="center" style="width:60%;">
                    <h1> MUHAMMAD NAZIR & Co </h1>
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
                    <h3 style="font-size:0.7rem">Steam Pipes, Pipe Fitting, Flanges Valves, S.S Pipes</h3>
                    <h3 style="font-size:0.7rem">Plot # 8 Near Allah Malik Godown Shershah Kabari Bazar,</h3>
                    <h3 style="font-size:0.7rem">Phone : 021-32588781, 021-32574285 , Fax : 021-32588782</h3>
                </td>            </tr>
            <tr>
                <td  style="text-align: center;">
                    <span style="font-size:2rem">CONTRACT HISTORY </span>
                </td>
            </tr>

        </tbody>
    </table>


    {{-- Ledger Info --}}
    <table class="ledger">
        <tbody>
            {{-- <tr>
                <td>
                    Ledger Type
                </td>
                <td>
                    {{ $data[0]->Descr }}
                    Transaction Prove List (TPL)
                </td>
            </tr> --}}
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
                    <th class="column-headers" width="3%">S#</th>
                    <th class="column-headers" width="40%">Material Name</th>
                    <th class="column-headers" width="16%">Size</th>
                    <th class="column-headers" width="5%">Unit</th>
                    <th class="column-headers" width="8%">Pcs</th>
                    <th class="column-headers" width="8%">Kg</th>
                    <th class="column-headers" width="10%">Price$</th>
                    <th class="column-headers" width="10%">Amount$</th>

            </tr>
        </thead>
    </table>

    <table class="data" cellspacing="0">
        <tbody>
            {{-- {{ $debitpkr = 0}} --}}
            {{ $gtpcs = 0 }};  {{ $gtwt = 0 }};  {{ $gtval = 0 }}
            {{ $stpcs = 0 }};  {{ $stwt = 0 }};  {{ $stval = 0 }}

@for ($i = 0 ; $i < count($data) ; $i++)

{{ $gtpcs += $data[$i]->totpcs }}
{{ $gtwt += $data[$i]->wt }}
{{ $gtval += $data[$i]->vlues }}




                @if( $i==0 )
                <tr>
                    <td class="subhead" colspan="2" width="100%"   > Supplier Name: <span style="font-weight: bold;color:brown" > {{ $data[$i]->supname}} </span> </td>
                </tr>
                <tr>
                <td class="subhead" colspan="2" > Invoice Date: <span style="font-weight: bold;color:brown">  {{ $data[$i]->invoice_date}} </span>
                    Invoice No: <span style="font-weight: bold;color:brown"  > {{ $data[$i]->invoiceno}} </span></td>
                </tr>
            @else

            {{ $srno = $i - 1 }}
            {{ $stpcs += $data[$srno]->totpcs }}
            {{ $stwt += $data[$srno]->wt }}
            {{ $stval += $data[$srno]->vlues }}


        @if ($data[$i]->purid  <> $data[$srno]->purid)

            <tr>
                <td colspan="2" width="100%" style="font-size:1rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">Sub Total</td>
                <td colspan="3" width="8%" style="font-size:1rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stpcs,0) }} </td>
                <td colspan="1" width="8%" style="font-size:1rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stwt,1) }} </td>
                <td colspan="2" width="10%" style="font-size:1rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stval,0) }} </td>
            </tr>

            <tr>

                <td class="subhead" colspan="2"   > Supplier Name: <span style="font-weight: bold;color:brown" > {{ $data[$i]->supname}} </span> </td>
            </tr>


            <tr>
                <td class="subhead" colspan="2"> Invoice Date: <span style="font-weight: bold;color:brown">  {{ $data[$i]->invoice_date}} </span>
                    Invoice No: <span style="font-weight: bold;color:brown"  > {{ $data[$i]->invoiceno}} </span></td>
                </tr>

             {{ $stpcs = 0 }};  {{ $stwt = 0 }};  {{ $stval = 0 }}
        @endif
        @endif

.
            <tr>


                {{-- {{ $debitusd += $data[$i]->DebitAmtDlr }}
                {{ $creditusd += $data[$i]->CreditAmtDlr }} --}}

                <td style="font-size:0.9rem;text-align:center" width="3%">{{ $i+1 }}</td>
                <td style="font-size:0.9rem;text-align:left" width="40%">{{ $data[$i]->material_title}} </td>
                <td style="font-size:0.9rem;text-align:center" width="16%">{{ $data[$i]->size}} </td>
                <td style="font-size:0.9rem;text-align:center" width="5%">{{ $data[$i]->unit}} </td>
                <td style="font-size:0.9rem;text-align:right" width="8%">{{ number_format($data[$i]->totpcs,0) }} </td>
                <td style="font-size:0.9rem;text-align:right" width="8%">{{ number_format($data[$i]->wt,2) }} </td>
                <td style="font-size:0.9rem;text-align:right" width="10%">{{ number_format($data[$i]->price,3) }} </td>
                <td style="font-size:0.9rem;text-align:right" width="10%">{{ number_format($data[$i]->vlues,3) }} </td>

            </tr>
@endfor

{{ $stpcs += $data[$srno+1]->totpcs }}
{{ $stwt += $data[$srno+1]->wt }}
{{ $stval += $data[$srno+1]->vlues }}

<tr>
    <td colspan="2"  style="font-size:1rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">Sub Total</td>
    <td colspan="3"  style="font-size:1rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stpcs,0) }} </td>
    <td colspan="1"  style="font-size:1rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stwt,1) }} </td>
    <td colspan="2"  style="font-size:1rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($stval,0) }} </td>
</tr>




<tr>
    <td colspan="2"  style="font-size:1rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">Grand Total(s)</td>
    <td colspan="3"  style="font-size:1rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($gtpcs,0) }} </td>
    <td colspan="1"  style="font-size:1rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($gtwt,1) }} </td>
    <td colspan="2"  style="font-size:1rem; border:1px solid lightgray; text-align: right;font-weight: bold;background: #e3e3e3;border-top: 2px double  lightgray ;">{{ number_format($gtval,0) }} </td>
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
